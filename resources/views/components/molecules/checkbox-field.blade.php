@props([
    'name',
    'label',
    'value' => '1',
    'checked' => false,
    'disabled' => false,
    'size' => 'md'
])

@php
    $sizes = [
        'sm' => 'h-3 w-3',
        'md' => 'h-4 w-4', 
        'lg' => 'h-5 w-5'
    ];
    
    $labelSizes = [
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base'
    ];
    
    $hasError = $errors->has($name);
    $checkboxId = $name . '_' . str()->random(6);
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $labelSizeClasses = $labelSizes[$size] ?? $labelSizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-start space-x-3']) }}>
    <div class="flex items-center h-5">
        <input 
            id="{{ $checkboxId }}"
            name="{{ $name }}" 
            type="checkbox" 
            value="{{ $value }}"
            class="{{ $sizeClasses }} text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
            @if(old($name, $checked)) checked @endif
            @if($disabled) disabled @endif
        >
    </div>
    
    <div class="flex-1">
        <label for="{{ $checkboxId }}" class="{{ $labelSizeClasses }} font-medium text-gray-700 cursor-pointer">
            {{ $label }}
        </label>
        
        @if($slot->isNotEmpty())
            <div class="mt-1 {{ $labelSizeClasses }} text-gray-500">
                {{ $slot }}
            </div>
        @endif
        
        @if($hasError)
            <x-atoms.error class="mt-1">
                {{ $errors->first($name) }}
            </x-atoms.error>
        @endif
    </div>
</div>
