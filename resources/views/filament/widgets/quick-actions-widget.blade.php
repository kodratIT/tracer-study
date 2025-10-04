<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Quick Actions
        </x-slot>

        <x-slot name="description">
            Akses cepat ke fitur utama
        </x-slot>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($this->getQuickActions() as $action)
                <a 
                    href="{{ $action['url'] }}" 
                    class="flex flex-col items-center p-6 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 hover:shadow-md group"
                >
                    <div class="flex items-center justify-center w-12 h-12 rounded-full mb-3 
                        {{ $action['color'] === 'primary' ? 'bg-primary-100 dark:bg-primary-900/20' : '' }}
                        {{ $action['color'] === 'success' ? 'bg-success-100 dark:bg-success-900/20' : '' }}
                        {{ $action['color'] === 'warning' ? 'bg-warning-100 dark:bg-warning-900/20' : '' }}
                        {{ $action['color'] === 'info' ? 'bg-info-100 dark:bg-info-900/20' : '' }}
                        group-hover:scale-110 transition-transform duration-200
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
                    
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white mb-1 text-center">
                        {{ $action['label'] }}
                    </h3>
                    
                    <p class="text-xs text-gray-500 dark:text-gray-400 text-center">
                        {{ $action['description'] }}
                    </p>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
