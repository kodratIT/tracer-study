@props([
    'size' => 'sm'
])

@php
    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-base'
    ];
    
    $baseClasses = 'text-red-600 mt-1 flex items-center';
    $sizeClasses = $sizes[$size] ?? $sizes['sm'];
@endphp

<div {{ $attributes->merge(['class' => "{$baseClasses} {$sizeClasses}"]) }}>
    <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
    </svg>
    {{ $slot }}
</div>
