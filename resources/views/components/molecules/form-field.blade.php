@props([
    'name',
    'label',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
    'icon' => null,
    'iconPosition' => 'left',
    'size' => 'md',
    'help' => null
])

@php
    $hasError = $errors->has($name);
    $inputId = $name . '_' . str()->random(6);
@endphp

<div {{ $attributes->only('class')->merge(['class' => 'space-y-1']) }}>
    @if($label)
        <x-atoms.label 
            :for="$inputId" 
            :required="$required"
            :size="$size"
        >
            {{ $label }}
        </x-atoms.label>
    @endif
    
    <x-atoms.input 
        :id="$inputId"
        :name="$name"
        :type="$type"
        :placeholder="$placeholder"
        :value="old($name, $value)"
        :error="$hasError"
        :disabled="$disabled"
        :icon="$icon"
        :iconPosition="$iconPosition"
        :size="$size"
        :required="$required"
        {{ $attributes->except(['class', 'label', 'help', 'icon', 'iconPosition', 'size']) }}
    />
    
    @if($hasError)
        <x-atoms.error>
            {{ $errors->first($name) }}
        </x-atoms.error>
    @endif
    
    @if($help && !$hasError)
        <p class="text-xs text-gray-500 mt-1">{{ $help }}</p>
    @endif
</div>
