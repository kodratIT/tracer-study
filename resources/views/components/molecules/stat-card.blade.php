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
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-3">
                    @if($icon)
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center group-hover:scale-110 transition-transform duration-200">
                                {!! $icon !!}
                            </div>
                        </div>
                    @endif
                    
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-600 mb-1">{{ $title }}</p>
                        <p class="text-2xl font-bold text-gray-900 tracking-tight">{{ $value }}</p>
                        
                        @if($subtitle)
                            <p class="text-xs text-gray-500 mt-1">{{ $subtitle }}</p>
                        @endif
                    </div>
                </div>
            </div>
            
            @if($trend)
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        {{ $trend['direction'] === 'up' ? 'bg-green-100 text-green-800' : ($trend['direction'] === 'down' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                        @if($trend['direction'] === 'up')
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.293 9.707a1 1 0 010-1.414l6-6a1 1 0 011.414 0l6 6a1 1 0 01-1.414 1.414L10 4.414 4.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @elseif($trend['direction'] === 'down')
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 10.293a1 1 0 010 1.414l-6 6a1 1 0 01-1.414 0l-6-6a1 1 0 111.414-1.414L10 15.586l5.293-5.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        @endif
                        {{ $trend['value'] }}
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-molecules.card>
