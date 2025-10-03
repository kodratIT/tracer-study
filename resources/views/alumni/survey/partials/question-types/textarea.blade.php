{{-- Textarea Question Type --}}
@php
    $maxLength = $question->validation_rules['max_length'] ?? 1000;
    $rows = $question->validation_rules['rows'] ?? 4;
    $currentLength = strlen($answer?->answer_text ?? '');
@endphp

<textarea 
    name="answer_{{ $question->question_id }}"
    rows="{{ $rows }}"
    placeholder="Tuliskan jawaban Anda di sini..."
    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-y"
    @if($question->is_required) required @endif
    maxlength="{{ $maxLength }}"
    id="textarea_{{ $question->question_id }}"
>{{ old('answer_' . $question->question_id, $answer?->answer_text) }}</textarea>

<div class="mt-2 flex items-center justify-between text-sm">
    <p class="text-gray-500">
        @if($question->validation_rules && isset($question->validation_rules['max_words']))
            Maksimal {{ $question->validation_rules['max_words'] }} kata
        @else
            Jelaskan dengan detail
        @endif
    </p>
    <p class="text-gray-500">
        <span id="char-count-{{ $question->question_id }}">{{ $currentLength }}</span> / {{ $maxLength }} karakter
    </p>
</div>

@push('scripts')
<script>
document.getElementById('textarea_{{ $question->question_id }}').addEventListener('input', function() {
    document.getElementById('char-count-{{ $question->question_id }}').textContent = this.value.length;
});
</script>
@endpush
