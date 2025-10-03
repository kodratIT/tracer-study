{{-- Radio Button Question Type --}}
<div class="max-w-2xl">
    <div class="space-y-2">
        @foreach($question->options()->ordered()->get() as $option)
            <label class="flex items-center px-4 py-3 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all group has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50 has-[:checked]:ring-2 has-[:checked]:ring-blue-500 has-[:checked]:ring-opacity-20">
                <input 
                    type="radio" 
                    name="answer_{{ $question->question_id }}"
                    value="{{ $option->option_id }}"
                    {{ old('answer_' . $question->question_id, $answer?->option_id) == $option->option_id ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-2 focus:ring-blue-500 flex-shrink-0"
                    @if($question->is_required) required @endif
                />
                <span class="ml-3 text-gray-900 group-hover:text-blue-700 has-[:checked]:text-blue-700 has-[:checked]:font-medium">{{ $option->option_text }}</span>
            </label>
        @endforeach
    </div>
</div>

@if($question->options->isEmpty())
    <p class="text-sm text-gray-500 italic">Tidak ada pilihan tersedia untuk pertanyaan ini.</p>
@endif
