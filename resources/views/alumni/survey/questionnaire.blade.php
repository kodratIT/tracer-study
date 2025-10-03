@extends('alumni.layouts.app')

@section('title', 'Tracer Study - Kuesioner')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Progress Header -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Tracer Study {{ $session->year }}</h1>
                    <p class="text-sm text-gray-600 mt-1">Jawab semua pertanyaan dengan jujur dan lengkap</p>
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">{{ $progress }}%</p>
                    <p class="text-xs text-gray-500">Progress</p>
                </div>
            </div>
            
            <!-- Progress Bar -->
            <div class="w-full bg-gray-200 rounded-full h-2 overflow-hidden">
                <div id="progress-bar" class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $progress }}%"></div>
            </div>
            
            <div class="flex items-center justify-between mt-3 text-sm">
                <span class="text-gray-600">
                    <span id="answered-count">{{ $answers->filter(fn($a) => !$a->is_empty)->count() }}</span> dari {{ $questions->count() }} terjawab
                </span>
                <span id="auto-save-indicator" class="text-gray-500 flex items-center">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="save-status">Semua perubahan tersimpan</span>
                </span>
            </div>
        </div>

        @if($errors->any())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-red-800">Terdapat kesalahan:</p>
                        <ul class="mt-1.5 text-sm text-red-700 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Questions Form -->
        <form id="survey-form" method="POST" action="{{ route('alumni.survey.review', $response) }}">
            @csrf
            
            <div class="space-y-6">
                @foreach($questions as $index => $question)
                    @php
                        $answer = $answers->get($question->question_id);
                        $questionNumber = $index + 1;
                    @endphp
                    
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 question-card" data-question-id="{{ $question->question_id }}">
                        <!-- Question Header -->
                        <div class="mb-4">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-3">
                                    <span class="flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-lg text-sm font-semibold flex-shrink-0">
                                        {{ $questionNumber }}
                                    </span>
                                    @if($question->is_required)
                                        <span class="px-2.5 py-0.5 bg-red-100 text-red-700 text-xs font-medium rounded">
                                            Wajib
                                        </span>
                                    @endif
                                </div>
                                <div id="status-{{ $question->question_id }}" class="flex items-center gap-1.5 text-sm">
                                    @if($answer && !$answer->is_empty)
                                        <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-green-700">Terjawab</span>
                                    @else
                                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-500">Belum dijawab</span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">
                                {{ $question->question_text }}
                                @if($question->is_required)
                                    <span class="text-red-500">*</span>
                                @endif
                            </h3>
                        </div>

                        <!-- Question Input -->
                        <div class="mt-4">
                            @includeFirst([
                                "alumni.survey.partials.question-types.{$question->question_type}",
                                'alumni.survey.partials.question-types.text'
                            ], ['question' => $question, 'answer' => $answer])
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <div class="flex items-center justify-between gap-4">
                    <form action="{{ route('alumni.survey.save-draft', $response) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Simpan Draft
                            </span>
                        </button>
                    </form>
                    
                    <button type="submit" id="continue-btn" class="px-8 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <span class="flex items-center gap-2">
                            Review Jawaban
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </span>
                    </button>
                </div>
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
// CSRF Token
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}';

// Auto-save functionality
let saveTimeout;
let isSaving = false;

function updateSaveStatus(status, message) {
    const indicator = document.getElementById('auto-save-indicator');
    const statusText = document.getElementById('save-status');
    
    if (status === 'saving') {
        indicator.classList.remove('text-gray-500', 'text-green-600');
        indicator.classList.add('text-blue-600');
        statusText.textContent = 'Menyimpan...';
        const svg = indicator.querySelector('svg');
        svg.innerHTML = '<circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>';
        svg.classList.add('animate-spin');
    } else if (status === 'saved') {
        indicator.classList.remove('text-gray-500', 'text-blue-600');
        indicator.classList.add('text-green-600');
        statusText.textContent = message || 'Tersimpan';
        const svg = indicator.querySelector('svg');
        svg.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
        svg.classList.remove('animate-spin');
    } else {
        indicator.classList.remove('text-blue-600', 'text-green-600');
        indicator.classList.add('text-gray-500');
        statusText.textContent = message || 'Semua perubahan tersimpan';
    }
}

function saveAnswer(questionId, answerData) {
    if (isSaving) return;
    
    isSaving = true;
    updateSaveStatus('saving');
    
    fetch('{{ route("alumni.survey.answer", $response) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            question_id: questionId,
            ...answerData
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update progress
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.querySelector('.text-3xl.font-bold.text-blue-600');
            const answeredCount = document.getElementById('answered-count');
            
            progressBar.style.width = data.progress + '%';
            progressText.textContent = data.progress + '%';
            answeredCount.textContent = data.answered_count;
            
            updateSaveStatus('saved', `Tersimpan ${data.saved_at}`);
            
            // Update answer status indicator
            const statusElement = document.getElementById(`status-${questionId}`);
            if (statusElement) {
                statusElement.innerHTML = `
                    <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-green-700">Terjawab</span>
                `;
            }
        }
        isSaving = false;
    })
    .catch(error => {
        console.error('Error saving answer:', error);
        updateSaveStatus('error', 'Gagal menyimpan');
        isSaving = false;
    });
}

// Debounced save for text inputs
function debouncedSave(questionId, answerData) {
    clearTimeout(saveTimeout);
    saveTimeout = setTimeout(() => {
        saveAnswer(questionId, answerData);
    }, 1000);
}

// Attach event listeners to all inputs
document.addEventListener('DOMContentLoaded', function() {
    // Text and Textarea inputs
    document.querySelectorAll('input[type="text"], textarea').forEach(input => {
        input.addEventListener('input', function() {
            const questionCard = this.closest('.question-card');
            const questionId = questionCard.dataset.questionId;
            
            debouncedSave(questionId, {
                answer_type: 'text',
                answer_text: this.value
            });
        });
    });
    
    // Radio and Select inputs
    document.querySelectorAll('input[type="radio"], select').forEach(input => {
        input.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            const questionId = questionCard.dataset.questionId;
            
            saveAnswer(questionId, {
                answer_type: 'option',
                option_id: this.value
            });
        });
    });
    
    // Checkbox inputs
    document.querySelectorAll('input[type="checkbox"]').forEach(input => {
        input.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            const questionId = questionCard.dataset.questionId;
            const checkboxes = questionCard.querySelectorAll('input[type="checkbox"]:checked');
            const selectedOptions = Array.from(checkboxes).map(cb => cb.value);
            
            saveAnswer(questionId, {
                answer_type: 'checkbox',
                selected_options: selectedOptions
            });
        });
    });
    
    // Rating inputs
    document.querySelectorAll('input[name^="rating"]').forEach(input => {
        input.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            const questionId = questionCard.dataset.questionId;
            
            saveAnswer(questionId, {
                answer_type: 'rating',
                rating_value: parseInt(this.value)
            });
        });
    });
    
    // Date inputs
    document.querySelectorAll('input[type="date"]').forEach(input => {
        input.addEventListener('change', function() {
            const questionCard = this.closest('.question-card');
            const questionId = questionCard.dataset.questionId;
            
            saveAnswer(questionId, {
                answer_type: 'text',
                answer_text: this.value
            });
        });
    });
});

// Prevent accidental page close
window.addEventListener('beforeunload', function (e) {
    if (isSaving) {
        e.preventDefault();
        e.returnValue = '';
        return '';
    }
});
</script>
@endpush
@endsection
