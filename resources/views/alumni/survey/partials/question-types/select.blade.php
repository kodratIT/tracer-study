{{-- Select Dropdown Question Type --}}
<select 
    name="answer_{{ $question->question_id }}"
    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors bg-white"
    @if($question->is_required) required @endif
>
    <option value="">-- Pilih salah satu --</option>
    @foreach($question->options()->ordered()->get() as $option)
        <option 
            value="{{ $option->option_id }}"
            {{ old('answer_' . $question->question_id, $answer?->option_id) == $option->option_id ? 'selected' : '' }}
        >
            {{ $option->option_text }}
        </option>
    @endforeach
</select>

@if($question->options->isEmpty())
    <p class="mt-2 text-sm text-gray-500 italic">Tidak ada pilihan tersedia untuk pertanyaan ini.</p>
@endif
