{{-- Textarea Question Type --}}
@php
    $maxLength = $question->validation_rules['max_length'] ?? 1000;
    $rows = $question->validation_rules['rows'] ?? 4;
    $currentLength = strlen($answer?->answer_text ?? '');
@endphp

<div class="max-w-3xl">
    <textarea 
        name="answer_{{ $question->question_id }}"
        rows="{{ $rows }}"
        placeholder="Tuliskan jawaban Anda secara detail di sini..."
        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-y text-gray-900 placeholder-gray-400"
        @if($question->is_required) required @endif
        maxlength="{{ $maxLength }}"
        id="textarea_{{ $question->question_id }}"
    >{{ old('answer_' . $question->question_id, $answer?->answer_text) }}</textarea>
    
    <div class="mt-2 flex items-center justify-between text-xs">
        <p class="text-gray-500">
            @if($question->validation_rules && isset($question->validation_rules['max_words']))
                <svg class="inline w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Maksimal {{ $question->validation_rules['max_words'] }} kata
            @else
                Jelaskan dengan detail dan lengkap
            @endif
        </p>
        <p class="text-gray-600 font-medium">
            <span id="char-count-{{ $question->question_id }}">{{ $currentLength }}</span> / {{ $maxLength }}
        </p>
    </div>
</div>

@push('scripts')
<script>
document.getElementById('textarea_{{ $question->question_id }}').addEventListener('input', function() {
    document.getElementById('char-count-{{ $question->question_id }}').textContent = this.value.length;
});
</script>
@endpush
