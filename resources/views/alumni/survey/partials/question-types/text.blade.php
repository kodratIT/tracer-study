{{-- Text Input Question Type --}}
<input 
    type="text" 
    name="answer_{{ $question->question_id }}"
    value="{{ old('answer_' . $question->question_id, $answer?->answer_text) }}"
    placeholder="Masukkan jawaban Anda..."
    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
    @if($question->is_required) required @endif
    @if($question->validation_rules && isset($question->validation_rules['max_length']))
        maxlength="{{ $question->validation_rules['max_length'] }}"
    @endif
/>

@if($question->validation_rules && isset($question->validation_rules['max_length']))
    <p class="mt-2 text-sm text-gray-500">
        Maksimal {{ $question->validation_rules['max_length'] }} karakter
    </p>
@endif
