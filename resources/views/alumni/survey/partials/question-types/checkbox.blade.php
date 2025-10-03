{{-- Checkbox Question Type --}}
@php
    $selectedOptions = [];
    if ($answer && $answer->additional_data && isset($answer->additional_data['selected_options'])) {
        $selectedOptions = $answer->additional_data['selected_options'];
    }
    $minSelections = $question->validation_rules['min_selections'] ?? null;
    $maxSelections = $question->validation_rules['max_selections'] ?? null;
@endphp

<div class="space-y-2.5">
    @foreach($question->options()->ordered()->get() as $option)
        <label class="flex items-center p-3.5 border border-gray-300 rounded-lg cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all checkbox-option group">
            <input 
                type="checkbox" 
                name="answer_{{ $question->question_id }}[]"
                value="{{ $option->option_id }}"
                {{ in_array($option->option_id, $selectedOptions) ? 'checked' : '' }}
                class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-2 focus:ring-blue-500"
                data-question-id="{{ $question->question_id }}"
                @if($maxSelections) data-max-selections="{{ $maxSelections }}" @endif
            />
            <span class="ml-3 text-gray-900 group-hover:text-blue-700">{{ $option->option_text }}</span>
        </label>
    @endforeach
</div>

@if($minSelections || $maxSelections)
    <p class="mt-3 text-sm text-gray-600">
        @if($minSelections && $maxSelections)
            Pilih minimal {{ $minSelections }} dan maksimal {{ $maxSelections }} pilihan
        @elseif($minSelections)
            Pilih minimal {{ $minSelections }} pilihan
        @elseif($maxSelections)
            Pilih maksimal {{ $maxSelections }} pilihan
        @endif
    </p>
@else
    <p class="mt-3 text-sm text-gray-500">Anda dapat memilih lebih dari satu pilihan</p>
@endif

@push('scripts')
<script>
// Limit checkbox selections
document.querySelectorAll('input[data-question-id="{{ $question->question_id }}"]').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        const maxSelections = this.dataset.maxSelections;
        if (maxSelections) {
            const questionId = this.dataset.questionId;
            const checkboxes = document.querySelectorAll(`input[data-question-id="${questionId}"]`);
            const checkedCount = Array.from(checkboxes).filter(cb => cb.checked).length;
            
            if (checkedCount >= parseInt(maxSelections)) {
                checkboxes.forEach(cb => {
                    if (!cb.checked) {
                        cb.disabled = true;
                        cb.closest('.checkbox-option').classList.add('opacity-50', 'cursor-not-allowed');
                    }
                });
            } else {
                checkboxes.forEach(cb => {
                    cb.disabled = false;
                    cb.closest('.checkbox-option').classList.remove('opacity-50', 'cursor-not-allowed');
                });
            }
        }
    });
});
</script>
@endpush
