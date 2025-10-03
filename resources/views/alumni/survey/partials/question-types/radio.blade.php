{{-- Radio Button Question Type --}}
<div class="space-y-2.5">
    @foreach($question->options()->ordered()->get() as $option)
        <label class="flex items-center p-3.5 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group">
            <input 
                type="radio" 
                name="answer_{{ $question->question_id }}"
                value="{{ $option->option_id }}"
                {{ old('answer_' . $question->question_id, $answer?->option_id) == $option->option_id ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500"
                @if($question->is_required) required @endif
            />
            <span class="ml-3 text-gray-900 group-hover:text-blue-700">{{ $option->option_text }}</span>
        </label>
    @endforeach
</div>

@if($question->options->isEmpty())
    <p class="text-sm text-gray-500 italic">Tidak ada pilihan tersedia untuk pertanyaan ini.</p>
@endif
