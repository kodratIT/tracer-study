<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Header Widgets -->
        @if($this->getHeaderWidgets())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($this->getHeaderWidgets() as $widget)
                    @livewire($widget)
                @endforeach
            </div>
        @endif

        <!-- Main Analytics Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-900">
                    Alumni & Employment Analytics
                </h2>
                <p class="text-sm text-gray-600 mt-1">
                    Comprehensive analysis of alumni employment trends and survey responses
                </p>
            </div>

            <!-- Chart Widgets Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($this->getWidgets() as $widget)
                    <div class="bg-gray-50 rounded-lg p-4">
                        @livewire($widget)
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Export Actions Section -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-blue-900">
                        Export Data & Reports
                    </h3>
                    <p class="text-sm text-blue-700 mt-1">
                        Download comprehensive data exports in Excel or PDF format
                    </p>
                </div>
                <div class="flex space-x-3">
                    {{ $this->getHeaderActions()[0] ?? '' }}
                    {{ $this->getHeaderActions()[1] ?? '' }}
                    {{ $this->getHeaderActions()[2] ?? '' }}
                </div>
            </div>
        </div>

        <!-- Quick Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-50 border border-green-200 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-green-900">Alumni Data</h3>
                        <p class="text-sm text-green-700">Complete alumni profiles with graduation info</p>
                    </div>
                </div>
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 012 2v6a2 2 0 01-2 2H8a2 2 0 01-2-2V8a2 2 0 012-2V6"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-blue-900">Employment Records</h3>
                        <p class="text-sm text-blue-700">Job history and career progression</p>
                    </div>
                </div>
            </div>

            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v6a2 2 0 002 2h2m0 0h2m-2 0v6a2 2 0 002 2h6a2 2 0 002-2v-6a2 2 0 00-2-2h-2m-2 0V9a2 2 0 00-2-2H9z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-purple-900">Survey Analytics</h3>
                        <p class="text-sm text-purple-700">Response tracking and insights</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
