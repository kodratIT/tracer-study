<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Modules\Alumni\Models\Alumni;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('alumni.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if admin is already logged in
        if (Auth::guard('web')->check()) {
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('error', 'Anda sudah login sebagai admin.');
        }

        if (Auth::guard('alumni')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('alumni.dashboard');
        }

        throw ValidationException::withMessages([
            'email' => __('validation.auth_failed'),
        ]);
    }

    public function showRegister()
    {
        return view('alumni.auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|unique:alumni,student_id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:alumni,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'graduation_year' => 'required|integer|min:1980|max:' . date('Y'),
        ]);

        $alumni = Alumni::create([
            'student_id' => $request->student_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'graduation_year' => $request->graduation_year,
        ]);

        Auth::guard('alumni')->login($alumni);

        return redirect('/alumni/dashboard');
    }

    public function logout(Request $request)
    {
        Auth::guard('alumni')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('alumni.login')
            ->with('success', 'Anda telah berhasil logout.');
    }

    public function dashboard()
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Load program relation if exists
        if ($alumni->program_id) {
            $alumni->load('program.department');
        }
        
        // Load address relation if exists
        if ($alumni->address_id) {
            $alumni->load('address');
        }
        
        // Check employment status
        $hasEmployment = \Modules\Employment\Models\EmploymentHistory::where('alumni_id', $alumni->alumni_id)->exists();
        
        // Get active survey session
        $activeSurveySession = \Modules\Survey\Models\TracerStudySession::active()
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->with(['surveyResponses' => function($query) use ($alumni) {
                $query->where('alumni_id', $alumni->alumni_id);
            }])
            ->first();
        
        $surveyResponse = $activeSurveySession ? $activeSurveySession->surveyResponses->first() : null;
        
        // Check questionnaire status
        $hasCompletedSurvey = \Modules\Survey\Models\SurveyResponse::where('alumni_id', $alumni->alumni_id)
            ->where('completion_status', 'completed')
            ->exists();
        
        return view('alumni.dashboard', compact('alumni', 'hasEmployment', 'hasCompletedSurvey', 'activeSurveySession', 'surveyResponse'));
    }

    public function showProfile()
    {
        $alumni = Auth::guard('alumni')->user();
        
        // Load address relation if exists
        if ($alumni->address_id) {
            $alumni->load('address');
        }
        
        // Get all active programs with department info
        $programs = \Modules\Education\Models\Program::active()
            ->with('department')
            ->orderBy('program_name')
            ->get();
        
        return view('alumni.profile', compact('alumni', 'programs'));
    }

    public function updateProfile(Request $request)
    {
        $alumni = Auth::guard('alumni')->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:alumni,email,' . $alumni->alumni_id . ',alumni_id',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female',
            'birth_date' => 'nullable|date|before:today',
            'gpa' => 'nullable|numeric|min:0|max:4',
            'program_id' => 'nullable|integer',
            'street' => 'required_with:city,province|nullable|string|max:255',
            'city' => 'required_with:street,province|nullable|string|max:100',
            'district' => 'nullable|string|max:100',
            'village' => 'nullable|string|max:100',
            'province' => 'required_with:street,city|nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'country' => 'nullable|string|max:100',
        ]);

        // Handle address creation/update
        if ($request->filled(['street', 'city', 'province'])) {
            $addressData = [
                'street' => $request->street,
                'city' => $request->city,
                'district' => $request->district,
                'village' => $request->village,
                'province' => $request->province,
                'postal_code' => $request->postal_code,
                'country' => $request->country ?? 'Indonesia',
            ];

            if ($alumni->address_id) {
                // Update existing address
                $alumni->address()->update($addressData);
            } else {
                // Create new address
                $address = \Modules\Alumni\Models\Address::create($addressData);
                $alumni->address_id = $address->address_id;
            }
        }

        $alumni->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
            'gpa' => $request->gpa,
            'program_id' => $request->program_id,
        ]);

        return redirect()->route('alumni.profile')->with('success', 'Profil berhasil diperbarui!');
    }
}
