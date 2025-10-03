<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Survey\Models\TracerStudySession;
use Modules\Survey\Models\SurveyQuestion;
use Modules\Survey\Models\SurveyResponse;
use Modules\Survey\Models\Answer;

class SurveyController extends Controller
{
    /**
     * Display list of available survey sessions
     */
    public function index()
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Get all active sessions with response status
        $sessions = TracerStudySession::active()
            ->with(['surveyResponses' => function($query) use ($alumni) {
                $query->where('alumni_id', $alumni->alumni_id);
            }])
            ->orderBy('year', 'desc')
            ->get()
            ->map(function($session) use ($alumni) {
                $response = $session->surveyResponses->first();
                
                return [
                    'session' => $session,
                    'response' => $response,
                    'status' => $response ? $response->completion_status : null,
                    'can_start' => !$response || in_array($response->completion_status, ['draft', 'partial']),
                    'is_completed' => $response && $response->completion_status === 'completed',
                ];
            });
        
        return view('alumni.survey.index', compact('sessions'));
    }

    /**
     * Show survey introduction/welcome page
     */
    public function show(TracerStudySession $session)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check if session is active and within date range
        if (!$session->is_active || $session->is_expired) {
            return redirect()->route('alumni.survey.index')
                ->with('error', 'Sesi survey ini sudah tidak aktif atau telah berakhir.');
        }
        
        // Get existing response if any
        $response = SurveyResponse::where('session_id', $session->session_id)
            ->where('alumni_id', $alumni->alumni_id)
            ->first();
        
        // Get question count
        $questionCount = SurveyQuestion::where('session_id', $session->session_id)
            ->count();
        
        return view('alumni.survey.introduction', compact('session', 'response', 'questionCount'));
    }

    /**
     * Start or resume survey
     */
    public function start(TracerStudySession $session)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check if session is active
        if (!$session->is_active || $session->is_expired) {
            return redirect()->route('alumni.survey.index')
                ->with('error', 'Sesi survey ini sudah tidak aktif atau telah berakhir.');
        }
        
        // Check if already completed
        $existingResponse = SurveyResponse::where('session_id', $session->session_id)
            ->where('alumni_id', $alumni->alumni_id)
            ->where('completion_status', 'completed')
            ->first();
        
        if ($existingResponse) {
            return redirect()->route('alumni.survey.index')
                ->with('info', 'Anda sudah menyelesaikan survey ini.');
        }
        
        // Get or create response
        $response = SurveyResponse::firstOrCreate(
            [
                'session_id' => $session->session_id,
                'alumni_id' => $alumni->alumni_id,
            ],
            [
                'completion_status' => 'draft',
                'metadata' => [
                    'started_at' => now()->toDateTimeString(),
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                ],
            ]
        );
        
        return redirect()->route('alumni.survey.questionnaire', $response);
    }

    /**
     * Display questionnaire page
     */
    public function questionnaire(SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            abort(403, 'Unauthorized access.');
        }
        
        // Check if already completed
        if ($response->completion_status === 'completed') {
            return redirect()->route('alumni.survey.index')
                ->with('info', 'Survey ini sudah diselesaikan.');
        }
        
        // Load session with questions and options
        $session = $response->session;
        $questions = SurveyQuestion::where('session_id', $session->session_id)
            ->with('options')
            ->ordered()
            ->get();
        
        // Load existing answers
        $answers = Answer::where('response_id', $response->response_id)
            ->get()
            ->keyBy('question_id');
        
        // Calculate progress
        $totalQuestions = $questions->count();
        $answeredQuestions = $answers->filter(function($answer) {
            return !$answer->is_empty;
        })->count();
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
        
        return view('alumni.survey.questionnaire', compact('response', 'session', 'questions', 'answers', 'progress'));
    }

    /**
     * Save answer for a question (AJAX)
     */
    public function answer(Request $request, SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        
        // Check if already completed
        if ($response->completion_status === 'completed') {
            return response()->json(['success' => false, 'message' => 'Survey already completed'], 400);
        }
        
        $validated = $request->validate([
            'question_id' => 'required|exists:survey_questions,question_id',
            'answer_type' => 'required|in:text,option,rating,checkbox',
            'answer_text' => 'nullable|string',
            'option_id' => 'nullable|exists:survey_options,option_id',
            'rating_value' => 'nullable|integer|min:1|max:5',
            'selected_options' => 'nullable|array',
            'selected_options.*' => 'exists:survey_options,option_id',
        ]);
        
        // Get question to validate
        $question = SurveyQuestion::findOrFail($validated['question_id']);
        
        // Prepare answer data
        $answerData = [
            'response_id' => $response->response_id,
            'question_id' => $validated['question_id'],
            'answer_text' => $validated['answer_text'] ?? null,
            'option_id' => $validated['option_id'] ?? null,
            'rating_value' => $validated['rating_value'] ?? null,
            'additional_data' => null,
        ];
        
        // Handle checkbox (multiple selections)
        if ($validated['answer_type'] === 'checkbox' && !empty($validated['selected_options'])) {
            $answerData['additional_data'] = [
                'selected_options' => $validated['selected_options'],
            ];
        }
        
        // Update or create answer
        Answer::updateOrCreate(
            [
                'response_id' => $response->response_id,
                'question_id' => $validated['question_id'],
            ],
            $answerData
        );
        
        // Update response status to partial if still draft
        if ($response->completion_status === 'draft') {
            $response->update(['completion_status' => 'partial']);
        }
        
        // Calculate new progress
        $totalQuestions = SurveyQuestion::where('session_id', $response->session_id)->count();
        $answeredQuestions = Answer::where('response_id', $response->response_id)
            ->whereNotNull('answer_text')
            ->orWhereNotNull('option_id')
            ->orWhereNotNull('rating_value')
            ->count();
        $progress = $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0;
        
        return response()->json([
            'success' => true,
            'message' => 'Jawaban berhasil disimpan',
            'progress' => $progress,
            'saved_at' => now()->format('H:i'),
        ]);
    }

    /**
     * Save draft progress (manual save)
     */
    public function saveDraft(SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            abort(403);
        }
        
        // Update metadata
        $metadata = $response->metadata ?? [];
        $metadata['last_saved_at'] = now()->toDateTimeString();
        $response->update([
            'metadata' => $metadata,
            'completion_status' => 'partial',
        ]);
        
        return redirect()->route('alumni.survey.index')
            ->with('success', 'Progress survey berhasil disimpan. Anda dapat melanjutkan nanti.');
    }

    /**
     * Show review page before submit
     */
    public function review(SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            abort(403);
        }
        
        // Check if already completed
        if ($response->completion_status === 'completed') {
            return redirect()->route('alumni.survey.success', $response);
        }
        
        // Load questions with answers
        $questions = SurveyQuestion::where('session_id', $response->session_id)
            ->with('options')
            ->ordered()
            ->get();
        
        $answers = Answer::where('response_id', $response->response_id)
            ->with(['question', 'option'])
            ->get()
            ->keyBy('question_id');
        
        // Find missing required questions
        $missingRequired = $questions->filter(function($question) use ($answers) {
            if (!$question->is_required) {
                return false;
            }
            
            $answer = $answers->get($question->question_id);
            return !$answer || $answer->is_empty;
        });
        
        // Calculate completion
        $totalQuestions = $questions->count();
        $answeredQuestions = $answers->filter(function($answer) {
            return !$answer->is_empty;
        })->count();
        
        return view('alumni.survey.review', compact('response', 'questions', 'answers', 'missingRequired', 'totalQuestions', 'answeredQuestions'));
    }

    /**
     * Submit final survey response
     */
    public function submit(SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            abort(403);
        }
        
        // Check if already completed
        if ($response->completion_status === 'completed') {
            return redirect()->route('alumni.survey.success', $response);
        }
        
        // Validate all required questions are answered
        $questions = SurveyQuestion::where('session_id', $response->session_id)
            ->where('is_required', true)
            ->get();
        
        $answers = Answer::where('response_id', $response->response_id)
            ->get()
            ->keyBy('question_id');
        
        $missingRequired = $questions->filter(function($question) use ($answers) {
            $answer = $answers->get($question->question_id);
            return !$answer || $answer->is_empty;
        });
        
        if ($missingRequired->isNotEmpty()) {
            return back()->with('error', 'Masih ada ' . $missingRequired->count() . ' pertanyaan wajib yang belum dijawab.');
        }
        
        // Update response as completed
        $response->update([
            'completion_status' => 'completed',
            'submitted_at' => now(),
            'metadata' => array_merge($response->metadata ?? [], [
                'completed_at' => now()->toDateTimeString(),
                'completion_duration' => $response->created_at->diffInMinutes(now()),
            ]),
        ]);
        
        return redirect()->route('alumni.survey.success', $response);
    }

    /**
     * Show success page after submission
     */
    public function success(SurveyResponse $response)
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Check ownership
        if ($response->alumni_id !== $alumni->alumni_id) {
            abort(403);
        }
        
        // Must be completed
        if ($response->completion_status !== 'completed') {
            return redirect()->route('alumni.survey.questionnaire', $response);
        }
        
        return view('alumni.survey.success', compact('response'));
    }
}
