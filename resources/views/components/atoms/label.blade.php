@props([
    'required' => false,
    'size' => 'md',
    'for' => null
])

@php
    $sizes = [
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base'
    ];
    
    $baseClasses = 'block font-medium text-gray-700 mb-1';
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

<label 
    @if($for) for="{{ $for }}" @endif
    {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses}"]) }}
>
    {{ $slot }}
    @if($required)
        <span class="text-red-500 ml-1">*</span>
    @endif
</label>
