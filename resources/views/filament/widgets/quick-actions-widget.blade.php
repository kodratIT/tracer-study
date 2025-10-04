<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                <span>Quick Actions</span>
            </div>
        </x-slot>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            @foreach ($this->getQuickActions() as $action)
                <a 
                    href="{{ $action['url'] }}" 
                    class="group relative overflow-hidden rounded-xl border-2 border-transparent
                        {{ $action['color'] === 'primary' ? 'hover:border-primary-500 hover:bg-primary-50 dark:hover:bg-primary-950/20' : '' }}
                        {{ $action['color'] === 'success' ? 'hover:border-success-500 hover:bg-success-50 dark:hover:bg-success-950/20' : '' }}
                        {{ $action['color'] === 'warning' ? 'hover:border-warning-500 hover:bg-warning-50 dark:hover:bg-warning-950/20' : '' }}
                        {{ $action['color'] === 'info' ? 'hover:border-info-500 hover:bg-info-50 dark:hover:bg-info-950/20' : '' }}
                        bg-white dark:bg-gray-900 
                        transition-all duration-300 ease-out
                        hover:shadow-lg hover:-translate-y-1
                    "
                >
                    <!-- Background gradient on hover -->
                    <div class="absolute inset-0 opacity-0 group-hover:opacity-5 transition-opacity duration-300
                        {{ $action['color'] === 'primary' ? 'bg-gradient-to-br from-primary-400 to-primary-600' : '' }}
                        {{ $action['color'] === 'success' ? 'bg-gradient-to-br from-success-400 to-success-600' : '' }}
                        {{ $action['color'] === 'warning' ? 'bg-gradient-to-br from-warning-400 to-warning-600' : '' }}
                        {{ $action['color'] === 'info' ? 'bg-gradient-to-br from-info-400 to-info-600' : '' }}
                    "></div>

                    <!-- Content -->
                    <div class="relative p-5 flex flex-col items-center text-center">
                        <!-- Icon container with gradient -->
                        <div class="relative mb-4">
                            <div class="absolute inset-0 rounded-2xl blur-xl opacity-30 group-hover:opacity-50 transition-opacity duration-300
                                {{ $action['color'] === 'primary' ? 'bg-primary-500' : '' }}
                                {{ $action['color'] === 'success' ? 'bg-success-500' : '' }}
                                {{ $action['color'] === 'warning' ? 'bg-warning-500' : '' }}
                                {{ $action['color'] === 'info' ? 'bg-info-500' : '' }}
                            "></div>
                            <div class="relative flex items-center justify-center w-16 h-16 rounded-2xl 
                                {{ $action['color'] === 'primary' ? 'bg-gradient-to-br from-primary-400 to-primary-600' : '' }}
                                {{ $action['color'] === 'success' ? 'bg-gradient-to-br from-success-400 to-success-600' : '' }}
                                {{ $action['color'] === 'warning' ? 'bg-gradient-to-br from-warning-400 to-warning-600' : '' }}
                                {{ $action['color'] === 'info' ? 'bg-gradient-to-br from-info-400 to-info-600' : '' }}
                                group-hover:scale-110 transition-transform duration-300
                                shadow-lg
                            ">
                                <x-filament::icon 
                                    :icon="$action['icon']" 
                                    class="w-8 h-8 text-white"
                                />
                            </div>
                        </div>
                        
                        <!-- Label -->
                        <h3 class="font-bold text-sm mb-1.5
                            {{ $action['color'] === 'primary' ? 'text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400' : '' }}
                            {{ $action['color'] === 'success' ? 'text-gray-900 dark:text-white group-hover:text-success-600 dark:group-hover:text-success-400' : '' }}
                            {{ $action['color'] === 'warning' ? 'text-gray-900 dark:text-white group-hover:text-warning-600 dark:group-hover:text-warning-400' : '' }}
                            {{ $action['color'] === 'info' ? 'text-gray-900 dark:text-white group-hover:text-info-600 dark:group-hover:text-info-400' : '' }}
                            transition-colors duration-300
                        ">
                            {{ $action['label'] }}
                        </h3>
                        
                        <!-- Description -->
                        <p class="text-xs text-gray-500 dark:text-gray-400 leading-relaxed">
                            {{ $action['description'] }}
                        </p>

                        <!-- Arrow indicator -->
                        <div class="mt-3 flex items-center justify-center w-6 h-6 rounded-full
                            {{ $action['color'] === 'primary' ? 'bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400' : '' }}
                            {{ $action['color'] === 'success' ? 'bg-success-100 dark:bg-success-900/30 text-success-600 dark:text-success-400' : '' }}
                            {{ $action['color'] === 'warning' ? 'bg-warning-100 dark:bg-warning-900/30 text-warning-600 dark:text-warning-400' : '' }}
                            {{ $action['color'] === 'info' ? 'bg-info-100 dark:bg-info-900/30 text-info-600 dark:text-info-400' : '' }}
                            opacity-0 group-hover:opacity-100 
                            transform translate-x-0 group-hover:translate-x-1
                            transition-all duration-300
                        ">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
