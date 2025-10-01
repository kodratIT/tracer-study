@props([
    'variant' => 'default',
    'padding' => 'md',
    'shadow' => 'md',
    'rounded' => 'lg'
])

@php
    $variants = [
        'default' => 'bg-white border border-gray-200',
        'elevated' => 'bg-white',
        'outlined' => 'bg-white border-2 border-gray-200',
        'glass' => 'bg-white/80 backdrop-blur-sm border border-gray-200/50'
    ];
    
    $paddings = [
        'none' => '',
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
        'xl' => 'p-10'
    ];
    
    $shadows = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl'
    ];
    
    $roundeds = [
        'none' => '',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        '2xl' => 'rounded-2xl'
    ];
    
    $variantClasses = $variants[$variant] ?? $variants['default'];
    $paddingClasses = $paddings[$padding] ?? $paddings['md'];
    $shadowClasses = $shadows[$shadow] ?? $shadows['md'];
    $roundedClasses = $roundeds[$rounded] ?? $roundeds['lg'];
@endphp

<div {{ $attributes->merge(['class' => "transition-all duration-200 {$variantClasses} {$paddingClasses} {$shadowClasses} {$roundedClasses}"]) }}>
    {{ $slot }}
</div>
