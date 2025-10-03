{{-- Date Input Question Type --}}
@php
    $minDate = $question->validation_rules['min_date'] ?? null;
    $maxDate = $question->validation_rules['max_date'] ?? null;
@endphp

<input 
    type="date" 
    name="answer_{{ $question->question_id }}"
    value="{{ old('answer_' . $question->question_id, $answer?->answer_text) }}"
    class="px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors"
    @if($question->is_required) required @endif
    @if($minDate) min="{{ $minDate }}" @endif
    @if($maxDate) max="{{ $maxDate }}" @endif
/>

@if($minDate || $maxDate)
    <p class="mt-2 text-sm text-gray-500">
        @if($minDate && $maxDate)
            Pilih tanggal antara {{ \Carbon\Carbon::parse($minDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($maxDate)->format('d M Y') }}
        @elseif($minDate)
            Tanggal minimal: {{ \Carbon\Carbon::parse($minDate)->format('d M Y') }}
        @elseif($maxDate)
            Tanggal maksimal: {{ \Carbon\Carbon::parse($maxDate)->format('d M Y') }}
        @endif
    </p>
@endif
