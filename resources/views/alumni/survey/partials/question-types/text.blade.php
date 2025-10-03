{{-- Text Input Question Type --}}
<div class="max-w-2xl">
    <input 
        type="text" 
        name="answer_{{ $question->question_id }}"
        value="{{ old('answer_' . $question->question_id, $answer?->answer_text) }}"
        placeholder="Ketik jawaban Anda di sini..."
        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors text-gray-900 placeholder-gray-400"
        @if($question->is_required) required @endif
        @if($question->validation_rules && isset($question->validation_rules['max_length']))
            maxlength="{{ $question->validation_rules['max_length'] }}"
        @endif
    />
    
    @if($question->validation_rules && isset($question->validation_rules['max_length']))
        <p class="mt-2 text-xs text-gray-500">
            <svg class="inline w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Maksimal {{ $question->validation_rules['max_length'] }} karakter
        </p>
    @endif
</div>
