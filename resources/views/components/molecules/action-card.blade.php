@props([
    'title',
    'description',
    'icon' => null,
    'href' => '#',
    'color' => 'blue',
    'disabled' => false
])

@php
    $colorClasses = [
        'blue' => 'text-blue-600 bg-blue-50 ring-blue-200 group-hover:bg-blue-100',
        'green' => 'text-green-600 bg-green-50 ring-green-200 group-hover:bg-green-100',
        'yellow' => 'text-yellow-600 bg-yellow-50 ring-yellow-200 group-hover:bg-yellow-100',
        'red' => 'text-red-600 bg-red-50 ring-red-200 group-hover:bg-red-100',
        'indigo' => 'text-indigo-600 bg-indigo-50 ring-indigo-200 group-hover:bg-indigo-100',
        'purple' => 'text-purple-600 bg-purple-50 ring-purple-200 group-hover:bg-purple-100',
        'gray' => 'text-gray-600 bg-gray-50 ring-gray-200 group-hover:bg-gray-100',
    ];
    
    $iconColor = $colorClasses[$color] ?? $colorClasses['blue'];
@endphp

<a href="{{ $disabled ? '#' : $href }}" 
   class="relative group block p-6 bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-all duration-200 hover:border-gray-300 {{ $disabled ? 'opacity-50 cursor-not-allowed' : '' }}"
   {{ $disabled ? 'onclick="return false;"' : '' }}>
   
    <div class="flex items-start space-x-4">
        @if($icon)
            <div class="flex-shrink-0">
                <div class="w-12 h-12 rounded-xl {{ $iconColor }} flex items-center justify-center group-hover:scale-110 transition-all duration-200 ring-2 {{ $disabled ? '' : 'ring-transparent group-hover:ring-opacity-20' }}">
                    {!! $icon !!}
                </div>
            </div>
        @endif
        
        <div class="flex-1 min-w-0">
            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-gray-700 transition-colors duration-200">
                {{ $title }}
                @if(!$disabled)
                    <svg class="inline-block w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                @endif
            </h3>
            <p class="mt-2 text-sm text-gray-600 leading-relaxed">{{ $description }}</p>
            
            @if($disabled)
                <p class="mt-2 text-xs text-gray-400 italic">Fitur akan segera tersedia</p>
            @endif
        </div>
    </div>
    
    @if(!$disabled)
        <div class="absolute inset-0 rounded-xl ring-2 ring-transparent group-hover:ring-blue-200 group-hover:ring-opacity-50 transition-all duration-200"></div>
    @endif
</a>
