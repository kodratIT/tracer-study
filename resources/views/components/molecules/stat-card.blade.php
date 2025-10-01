@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'blue',
    'subtitle' => null,
    'trend' => null,
    'size' => 'md'
])

@php
    $colorClasses = [
        'blue' => 'text-blue-600 bg-blue-50 border-blue-100',
        'green' => 'text-green-600 bg-green-50 border-green-100',
        'yellow' => 'text-yellow-600 bg-yellow-50 border-yellow-100',
        'red' => 'text-red-600 bg-red-50 border-red-100',
        'indigo' => 'text-indigo-600 bg-indigo-50 border-indigo-100',
        'purple' => 'text-purple-600 bg-purple-50 border-purple-100',
        'gray' => 'text-gray-600 bg-gray-50 border-gray-100',
    ];
    
    $sizeClasses = [
        'sm' => 'p-4',
        'md' => 'p-5',
        'lg' => 'p-6'
    ];
    
    $iconColor = $colorClasses[$color] ?? $colorClasses['blue'];
    $padding = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<x-molecules.card 
    variant="elevated" 
    rounded="xl" 
    class="hover:shadow-lg transition-all duration-200 group"
>
    <div class="{{ $padding }}">
        <!-- Icon and Title Section -->
        <div class="flex items-center justify-between mb-4">
            @if($icon)
                <div class="w-12 h-12 rounded-lg {{ $iconColor }} flex items-center justify-center">
                    {!! $icon !!}
                </div>
            @endif
            
            @if($trend)
                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium 
                    {{ $trend['direction'] === 'up' ? 'bg-orange-100 text-orange-700' : ($trend['direction'] === 'down' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700') }}">
                    @if($trend['direction'] === 'up')
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @elseif($trend['direction'] === 'down')
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L10 15.586l5.293-5.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                    @else
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                    @endif
                    {{ $trend['value'] }}
                </span>
            @endif
        </div>
        
        <!-- Content Section -->
        <div>
            <h3 class="text-sm font-semibold text-gray-900 mb-2">{{ $title }}</h3>
            <div class="flex items-baseline space-x-2 mb-3">
                <span class="text-2xl font-bold text-gray-900">{{ $value }}</span>
                @if($subtitle)
                    <span class="text-sm text-gray-500">{{ $subtitle }}</span>
                @endif
            </div>
        </div>
    </div>
</x-molecules.card>
