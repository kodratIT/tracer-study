<x-filament-widgets::widget class="fi-wi-quick-actions">
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span class="text-base font-semibold">Akses Cepat</span>
            </div>
        </x-slot>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($this->getQuickActions() as $action)
                <a 
                    href="{{ $action['url'] }}" 
                    class="group flex items-start gap-4 p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 hover:border-gray-300 dark:hover:border-gray-600 transition-all duration-200 hover:shadow-md"
                >
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <div class="flex items-center justify-center w-12 h-12 rounded-lg
                            {{ $action['color'] === 'primary' ? 'bg-primary-50 dark:bg-primary-950/50' : '' }}
                            {{ $action['color'] === 'success' ? 'bg-success-50 dark:bg-success-950/50' : '' }}
                            {{ $action['color'] === 'warning' ? 'bg-warning-50 dark:bg-warning-950/50' : '' }}
                            {{ $action['color'] === 'info' ? 'bg-info-50 dark:bg-info-950/50' : '' }}
                        ">
                            <x-filament::icon 
                                :icon="$action['icon']" 
                                class="w-6 h-6
                                    {{ $action['color'] === 'primary' ? 'text-primary-600 dark:text-primary-400' : '' }}
                                    {{ $action['color'] === 'success' ? 'text-success-600 dark:text-success-400' : '' }}
                                    {{ $action['color'] === 'warning' ? 'text-warning-600 dark:text-warning-400' : '' }}
                                    {{ $action['color'] === 'info' ? 'text-info-600 dark:text-info-400' : '' }}
                                "
                            />
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $action['label'] }}
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400">
                            {{ $action['description'] }}
                        </p>
                    </div>

                    <!-- Arrow -->
                    <div class="flex-shrink-0 self-center">
                        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </div>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
