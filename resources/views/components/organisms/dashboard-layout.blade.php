@props([
    'title',
    'subtitle' => null,
    'actions' => null
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Alumni Portal') }} - Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50">
    @auth('alumni')
        <!-- Modern Navigation -->
        <nav class="bg-white/80 backdrop-blur-md shadow-sm border-b border-white/20 sticky top-0 z-50" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo and primary nav -->
                    <div class="flex items-center space-x-8">
                        <div class="flex-shrink-0 flex items-center">
                            <div class="w-8 h-8 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <a href="{{ route('alumni.dashboard') }}" class="text-xl font-bold text-gray-900">
                                Portal Alumni
                            </a>
                        </div>
                        
                        <!-- Navigation Links -->
                        <div class="hidden md:flex space-x-6">
                            <a href="{{ route('alumni.dashboard') }}" 
                               class="px-3 py-2 text-sm font-medium {{ request()->routeIs('alumni.dashboard') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900' }} rounded-lg transition-all duration-200">
                                Dashboard
                            </a>
                            <a href="{{ route('alumni.profile') }}" 
                               class="px-3 py-2 text-sm font-medium {{ request()->routeIs('alumni.profile') ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900' }} rounded-lg transition-all duration-200">
                                Profil
                            </a>
                        </div>
                    </div>

                    <!-- User dropdown -->
                    <div class="flex items-center space-x-4">
                        <!-- Notifications -->
                        <button class="p-2 text-gray-400 hover:text-gray-600 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-5 5v-5a7.5 7.5 0 00-15 0v5l-5-5h5z"></path>
                            </svg>
                        </button>
                        
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" 
                                    class="flex items-center space-x-3 text-sm bg-white rounded-xl px-3 py-2 border border-gray-200 hover:shadow-sm transition-all duration-200 group">
                                <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-semibold text-white">
                                        {{ substr(Auth::guard('alumni')->user()->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="hidden md:block text-left">
                                    <div class="font-medium text-gray-900">{{ Auth::guard('alumni')->user()->name }}</div>
                                    <div class="text-xs text-gray-500">Alumni {{ Auth::guard('alumni')->user()->graduation_year }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" 
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-50 mt-2 w-56 rounded-xl shadow-lg py-2 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none">
                                <a href="{{ route('alumni.profile') }}" 
                                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-150">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profil Saya
                                </a>
                                <div class="border-t border-gray-100 my-1"></div>
                                <form action="{{ route('alumni.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-150">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex-1 min-w-0">
                    <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">{{ $title }}</h1>
                    @if($subtitle)
                        <p class="mt-2 text-lg text-gray-600">{{ $subtitle }}</p>
                    @endif
                </div>
                @if($actions)
                    <div class="mt-4 md:mt-0 md:ml-4">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Page Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
            {{ $slot }}
        </div>
    @else
        <!-- Redirect to login if not authenticated -->
        <script>window.location.href = "{{ route('alumni.login') }}";</script>
    @endauth
    </div>
</body>
</html>
