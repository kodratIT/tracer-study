{{-- Rating Scale Question Type --}}
@php
    $minValue = $question->validation_rules['min_value'] ?? 1;
    $maxValue = $question->validation_rules['max_value'] ?? 5;
    $step = $question->validation_rules['step'] ?? 1;
    $currentRating = old('answer_' . $question->question_id, $answer?->rating_value);
@endphp

<div class="py-4">
    <!-- Rating Options -->
    <div class="flex items-center justify-center gap-4 mb-4">
        @for($i = $minValue; $i <= $maxValue; $i += $step)
            <label class="flex flex-col items-center cursor-pointer group">
                <input 
                    type="radio" 
                    name="answer_{{ $question->question_id }}"
                    value="{{ $i }}"
                    {{ $currentRating == $i ? 'checked' : '' }}
                    class="sr-only peer"
                    @if($question->is_required) required @endif
                />
                <div class="w-14 h-14 flex items-center justify-center rounded-full border-2 border-gray-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 peer-checked:text-white group-hover:border-blue-400 transition-all">
                    <span class="text-lg font-semibold">{{ $i }}</span>
                </div>
                @if($i == $minValue)
                    <span class="mt-2 text-xs text-gray-500 text-center">Sangat<br>Tidak Puas</span>
                @elseif($i == $maxValue)
                    <span class="mt-2 text-xs text-gray-500 text-center">Sangat<br>Puas</span>
                @else
                    <span class="mt-2 text-xs text-gray-400">&nbsp;</span>
                @endif
            </label>
        @endfor
    </div>

    <!-- Rating Labels -->
    <div class="flex items-center justify-between text-sm text-gray-600 px-4">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
            </svg>
            Tidak Puas
        </span>
        <span class="flex items-center">
            Sangat Puas
            <svg class="w-4 h-4 ml-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
            </svg>
        </span>
    </div>
</div>
