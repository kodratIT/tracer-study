{{-- Select Dropdown Question Type --}}
<div class="max-w-xl">
    <select 
        name="answer_{{ $question->question_id }}"
        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white text-gray-900 cursor-pointer"
        @if($question->is_required) required @endif
    >
        <option value="" class="text-gray-400">-- Pilih salah satu --</option>
        @foreach($question->options()->ordered()->get() as $option)
            <option 
                value="{{ $option->option_id }}"
                {{ old('answer_' . $question->question_id, $answer?->option_id) == $option->option_id ? 'selected' : '' }}
                class="text-gray-900"
            >
                {{ $option->option_text }}
            </option>
        @endforeach
    </select>
</div>

@if($question->options->isEmpty())
    <p class="mt-2 text-sm text-gray-500 italic">Tidak ada pilihan tersedia untuk pertanyaan ini.</p>
@endif
