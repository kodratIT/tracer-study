@extends('alumni.layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    // Calculate profile completion
    $profileFields = [
        'name' => $alumni->name,
        'email' => $alumni->email, 
        'phone' => $alumni->phone,
        'graduation_year' => $alumni->graduation_year,
        'gender' => $alumni->gender ?? null,
        'birth_date' => $alumni->birth_date ?? null,
        'gpa' => $alumni->gpa ?? null,
        'address' => $alumni->address ?? null
    ];
    
    $completedFields = collect($profileFields)->filter(function($value) {
        return !empty($value);
    })->count();
    
    $profileCompletion = round(($completedFields / count($profileFields)) * 100);
    $profileColor = $profileCompletion >= 80 ? 'green' : ($profileCompletion >= 50 ? 'yellow' : 'red');
@endphp

<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 -mt-16 pt-16">
    <!-- Page Header with Modern Design -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">Selamat datang kembali, {{ $alumni->name }}!</h1>
                <p class="mt-2 text-lg text-gray-600">NIM: {{ $alumni->student_id }} | Lulusan {{ $alumni->graduation_year }}</p>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Profile Completion -->
        <x-molecules.stat-card 
            title="Kelengkapan Profil"
            value="{{ $profileCompletion }}%"
            color="{{ $profileColor }}"
            subtitle="{{ $completedFields }}/{{ count($profileFields) }} field lengkap"
            :trend="$profileCompletion < 100 ? ['direction' => 'up', 'value' => 'Perlu dilengkapi'] : null"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Status Tracer Study"
            value="Menunggu"
            color="yellow"
            subtitle="Belum mengisi kuesioner"
            :trend="['direction' => 'up', 'value' => 'Action needed']"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Status Pekerjaan"
            value="Belum diperbarui"
            color="gray"
            subtitle="Data employment kosong"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 002 2h2a2 2 0 002-2V4z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Notifikasi"
            value="0"
            color="blue"
            subtitle="Tidak ada pesan baru"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 17h5l-5 5v-5a7.5 7.5 0 00-15 0v5l-5-5h5z\'></path></svg>'"
        />
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Aksi Cepat</h2>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
            
            <x-molecules.action-card 
                title="Perbarui Profil"
                description="Lengkapi informasi pribadi dan kontak Anda untuk meningkatkan kelengkapan data"
                :href="route('alumni.profile')"
                color="blue"
                :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'></path></svg>'"
            />
            
            <x-molecules.action-card 
                title="Isi Tracer Study"
                description="Lengkapi kuesioner tentang status pekerjaan dan pendidikan lanjutan Anda"
                href="#"
                color="green"
                :disabled="true"
                :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z\'></path></svg>'"
            />
            
            <x-molecules.action-card 
                title="Lihat Notifikasi"
                description="Periksa pembaruan penting dan pengumuman terbaru dari kampus"
                href="#"
                color="purple"
                :disabled="true"
                :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 17h5l-5 5v-5a7.5 7.5 0 00-15 0v5l-5-5h5z\'></path></svg>'"
            />
            
        </div>
    </div>

    <!-- Recent Activity Section -->
    <x-molecules.card variant="elevated" rounded="xl" class="mb-8">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Aktivitas Terbaru</h2>
            
            <div class="space-y-6">
                <!-- Account Creation Activity -->
                <div class="flex items-start space-x-4 group">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-10 h-10 bg-gradient-to-r from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-900">Akun berhasil dibuat</p>
                                <p class="text-sm text-gray-600">Selamat datang di Portal Alumni! Akun Anda telah aktif dan siap digunakan.</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                                    {{ $alumni->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Profile Update Reminder -->
                <div class="flex items-start space-x-4 group">
                    <div class="flex-shrink-0 mt-1">
                        <div class="w-10 h-10 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all duration-200">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-base font-medium text-gray-900">Lengkapi profil Anda</p>
                                <p class="text-sm text-gray-600">Untuk pengalaman yang lebih baik, mohon lengkapi informasi profil Anda.</p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded-full font-medium">
                                    Action needed
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Empty State for More Activities -->
                @if($profileCompletion < 100)
                <div class="border-t border-gray-100 pt-6">
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="mt-4 text-sm font-medium text-gray-900">Aktivitas akan muncul di sini</h3>
                        <p class="mt-2 text-sm text-gray-500">Mulai lengkapi profil dan isi tracer study untuk melihat aktivitas terbaru.</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </x-molecules.card>

    </div>
</div>

@endsection
