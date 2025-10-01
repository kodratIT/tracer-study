@props([
    'type' => 'text',
    'size' => 'md',
    'error' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $sizes = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2.5 text-sm',
        'lg' => 'px-4 py-3 text-base'
    ];
    
    $baseClasses = 'block w-full rounded-lg border transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed placeholder-gray-400';
    
    $stateClasses = $error 
        ? 'border-red-300 text-red-900 focus:ring-red-500 focus:border-red-500' 
        : 'border-gray-300 text-gray-900 focus:ring-blue-500 focus:border-blue-500';
    
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    $iconClasses = $icon ? ($iconPosition === 'left' ? 'pl-10' : 'pr-10') : '';
@endphp

<div class="relative">
    @if($icon)
        <div class="absolute inset-y-0 {{ $iconPosition === 'left' ? 'left-0 pl-3' : 'right-0 pr-3' }} flex items-center pointer-events-none">
            <div class="h-5 w-5 {{ $error ? 'text-red-400' : 'text-gray-400' }}">
                {!! $icon !!}
            </div>
        </div>
    @endif
    
    <input 
        type="{{ $type }}"
        {{ $attributes->merge([
            'class' => trim("{$baseClasses} {$stateClasses} {$sizeClasses} {$iconClasses}")
        ]) }}
        @if($disabled) disabled @endif
    />
</div>
