@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $variants = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white border-transparent focus:ring-blue-500',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white border-transparent focus:ring-gray-500',
        'outline' => 'bg-transparent hover:bg-blue-50 text-blue-600 border-blue-600 focus:ring-blue-500',
        'ghost' => 'bg-transparent hover:bg-gray-50 text-gray-700 border-transparent focus:ring-gray-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white border-transparent focus:ring-red-500'
    ];
    
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg'
    ];
    
    $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg border transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';
    
    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
@endphp

<button 
    type="{{ $type }}" 
    {{ $attributes->merge(['class' => "{$baseClasses} {$variantClasses} {$sizeClasses}"]) }}
    @if($disabled || $loading) disabled @endif
>
    @if($loading)
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Loading...
    @else
        @if($icon && $iconPosition === 'left')
            {!! $icon !!}
        @endif
        
        {{ $slot }}
        
        @if($icon && $iconPosition === 'right')
            {!! $icon !!}
        @endif
    @endif
</button>
