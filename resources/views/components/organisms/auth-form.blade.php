@props([
    'action',
    'method' => 'POST',
    'submitText' => 'Submit',
    'submitIcon' => null,
    'loading' => false,
    'footerText' => null,
    'footerLink' => null,
    'footerLinkText' => null
])

<form action="{{ $action }}" method="{{ $method }}" class="space-y-6" {{ $attributes }}>
    @if($method !== 'GET')
        @csrf
    @endif
    
    <!-- Form Fields -->
    <div class="space-y-4">
        {{ $slot }}
    </div>
    
    <!-- Submit Button -->
    <div class="space-y-4">
        <x-atoms.button 
            type="submit" 
            variant="primary" 
            size="lg"
            :loading="$loading"
            :icon="$submitIcon"
            class="w-full justify-center"
        >
            {{ $submitText }}
        </x-atoms.button>
        
        <!-- Footer Link -->
        @if($footerText && $footerLink && $footerLinkText)
            <div class="text-center">
                <p class="text-sm text-gray-600">
                    {{ $footerText }}
                    <a href="{{ $footerLink }}" class="font-medium text-blue-600 hover:text-blue-500 transition-colors duration-200">
                        {{ $footerLinkText }}
                    </a>
                </p>
            </div>
        @endif
    </div>
</form>
