@extends('alumni.layouts.app')

@section('title', 'Review Jawaban - Tracer Study')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Review Jawaban Anda</h1>
            <p class="mt-2 text-gray-600">Periksa kembali jawaban Anda sebelum mengirim</p>
        </div>

        <!-- Completion Summary -->
        <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    @if($missingRequired->isEmpty())
                        <div class="p-3 bg-green-100 rounded-full">
                            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Semua Pertanyaan Wajib Terjawab</h3>
                            <p class="text-sm text-gray-600">{{ $answeredQuestions }}/{{ $totalQuestions }} pertanyaan terjawab</p>
                        </div>
                    @else
                        <div class="p-3 bg-red-100 rounded-full">
                            <svg class="w-8 h-8 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-red-900">Ada Pertanyaan Wajib yang Belum Dijawab</h3>
                            <p class="text-sm text-red-700">{{ $missingRequired->count() }} pertanyaan wajib belum terjawab</p>
                        </div>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-3xl font-bold text-blue-600">{{ $totalQuestions > 0 ? round(($answeredQuestions / $totalQuestions) * 100) : 0 }}%</p>
                    <p class="text-xs text-gray-500">Lengkap</p>
                </div>
            </div>
        </div>

        @if(session('error'))
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-start">
                <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Missing Required Questions Warning -->
        @if($missingRequired->isNotEmpty())
            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-red-900 mb-2">Pertanyaan Berikut Wajib Dijawab:</h3>
                        <ul class="space-y-1 text-sm text-red-800">
                            @foreach($missingRequired as $question)
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>{{ $question->question_text }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        <!-- Answers Review -->
        <div class="space-y-6">
            @foreach($questions as $index => $question)
                @php
                    $answer = $answers->get($question->question_id);
                    $isMissing = $question->is_required && (!$answer || $answer->is_empty);
                @endphp
                
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 {{ $isMissing ? 'border-red-300 bg-red-50' : '' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <!-- Question -->
                            <div class="flex items-center gap-3 mb-3">
                                <span class="inline-flex items-center justify-center w-8 h-8 bg-blue-100 text-blue-700 rounded-full text-sm font-semibold flex-shrink-0">
                                    {{ $index + 1 }}
                                </span>
                                <div class="flex-1">
                                    <h3 class="text-base font-medium text-gray-900">
                                        {{ $question->question_text }}
                                        @if($question->is_required)
                                            <span class="text-red-500">*</span>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-500 mt-1">
                                        Jenis: {{ $question->type_display_name }}
                                    </p>
                                </div>
                            </div>

                            <!-- Answer -->
                            <div class="ml-11 p-4 {{ $isMissing ? 'bg-white border-2 border-red-200' : 'bg-gray-50 border border-gray-200' }} rounded-lg">
                                @if($answer && !$answer->is_empty)
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm font-medium text-gray-900">{{ $answer->display_value }}</p>
                                        </div>
                                    </div>
                                @else
                                    <div class="flex items-start">
                                        <svg class="w-5 h-5 text-red-500 mr-2 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div class="flex-1">
                                            <p class="text-sm text-red-700 font-medium">
                                                @if($question->is_required)
                                                    Belum dijawab (wajib)
                                                @else
                                                    Tidak dijawab (opsional)
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Edit Button -->
                        <a href="{{ route('alumni.survey.questionnaire', $response) }}#question-{{ $question->question_id }}" class="ml-4 inline-flex items-center px-3 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 text-sm font-medium rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Action Buttons -->
        <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <a href="{{ route('alumni.survey.questionnaire', $response) }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    Kembali Edit
                </a>
                
                @if($missingRequired->isEmpty())
                    <form id="submit-form" action="{{ route('alumni.survey.submit', $response) }}" method="POST">
                        @csrf
                    </form>
                    <button type="button" onclick="openSubmitModal()" class="inline-flex items-center px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Submit Survey
                    </button>
                @else
                    <button disabled class="inline-flex items-center px-8 py-3 bg-gray-300 text-gray-500 font-medium rounded-lg cursor-not-allowed">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Lengkapi Pertanyaan Wajib
                    </button>
                @endif
            </div>

            @if($missingRequired->isNotEmpty())
                <p class="mt-4 text-sm text-red-600 text-center">
                    Silakan kembali dan lengkapi {{ $missingRequired->count() }} pertanyaan wajib sebelum mengirim survey
                </p>
            @endif
        </div>

    </div>
</div>

<!-- Submit Confirmation Modal -->
<div id="submit-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <!-- Modal panel -->
    <div class="bg-white rounded-lg shadow-xl border border-gray-200 w-full max-w-md">
        <div class="p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold text-gray-900" id="modal-title">
                        Submit Survey?
                    </h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Apakah Anda yakin ingin mengirim survey ini? Setelah dikirim, Anda tidak dapat mengubah jawaban.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-3 flex justify-end gap-3 rounded-b-lg">
            <button type="button" onclick="closeSubmitModal()" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Batal
            </button>
            <button type="button" onclick="confirmSubmit()" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition-colors">
                Ya, Kirim Survey
            </button>
        </div>
    </div>
</div>

<script>
function openSubmitModal() {
    document.getElementById('submit-modal').classList.remove('hidden');
}

function closeSubmitModal() {
    document.getElementById('submit-modal').classList.add('hidden');
}

function confirmSubmit() {
    document.getElementById('submit-form').submit();
}

// Close modal on Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeSubmitModal();
    }
});
</script>
@endsection
