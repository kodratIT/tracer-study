@props([
    'title',
    'subtitle' => null,
    'cardWidth' => 'max-w-md',
    'showLogo' => true
])

<div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="{{ $cardWidth }} w-full space-y-8">
        <!-- Header Section -->
        <div class="text-center">
            @if($showLogo)
                <div class="mx-auto h-16 w-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-xl flex items-center justify-center mb-6 shadow-lg">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                </div>
            @endif
            
            <h2 class="text-3xl font-bold text-gray-900 mb-2">
                {{ $title }}
            </h2>
            
            @if($subtitle)
                <p class="text-sm text-gray-600 max-w-sm mx-auto">
                    {{ $subtitle }}
                </p>
            @endif
        </div>
        
        <!-- Main Card -->
        <x-molecules.card 
            variant="elevated" 
            shadow="xl" 
            rounded="xl"
            padding="lg"
            class="backdrop-blur-sm"
        >
            {{ $slot }}
        </x-molecules.card>
    </div>
</div>
