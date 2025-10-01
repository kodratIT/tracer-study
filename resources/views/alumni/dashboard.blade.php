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

<!-- Clean Dashboard Layout -->
<div class="bg-gray-50 min-h-screen">
    <!-- Welcome Section -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Selamat datang, {{ $alumni->name }}!</h1>
                    <p class="mt-1 text-sm text-gray-600">NIM: {{ $alumni->student_id }} • Lulusan {{ $alumni->graduation_year }}</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        Status Aktif
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4 mb-8">
        <!-- Profile Completion -->
        <x-molecules.stat-card 
            title="Profil Alumni"
            value="{{ $profileCompletion }}%"
            color="{{ $profileColor }}"
            subtitle="{{ $completedFields }} dari {{ count($profileFields) }} field"
            :trend="$profileCompletion < 100 ? ['direction' => 'up', 'value' => 'Perlu Dilengkapi'] : ['direction' => 'up', 'value' => 'Lengkap']"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Tracer Study"
            value="Menunggu Pengisian"
            color="yellow"
            subtitle="Kuesioner belum diisi"
            :trend="['direction' => 'up', 'value' => 'Segera Isi']"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Status Pekerjaan"
            value="Belum Ada Data"
            color="gray"
            subtitle="Informasi kosong"
            :trend="['direction' => 'up', 'value' => 'Update Diperlukan']"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0V6a2 2 0 002 2h2a2 2 0 002-2V4z\'></path></svg>'"
        />

        <x-molecules.stat-card 
            title="Pemberitahuan"
            value="0 Pesan"
            color="blue"
            subtitle="Semua sudah dibaca"
            :icon="'<svg class=\'w-6 h-6\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 17h5l-5 5v-5a7.5 7.5 0 00-15 0v5l-5-5h5z\'></path></svg>'"
        />
    </div>

    <!-- Quick Actions Section -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Aksi Cepat</h2>
            <span class="text-sm text-gray-500">Aksi yang tersedia untuk Anda</span>
        </div>
        
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
            <x-molecules.action-card 
                title="Perbarui Profil"
                description="Lengkapi informasi pribadi dan kontak untuk kelengkapan data"
                :href="route('alumni.profile')"
                color="blue"
                :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'></path></svg>'"
            />
            
            <x-molecules.action-card 
                title="Isi Tracer Study"
                description="Lengkapi kuesioner tentang status pekerjaan dan pendidikan"
                href="#"
                color="green"
                :disabled="true"
                :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z\'></path></svg>'"
            />
            
            <x-molecules.action-card 
                title="Lihat Pengumuman"
                description="Periksa pengumuman dan informasi terbaru dari kampus"
                href="#"
                color="purple"
                :disabled="true"
                :icon="'<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 17h5l-5 5v-5a7.5 7.5 0 00-15 0v5l-5-5h5z\'></path></svg>'"
            />
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Aktivitas Terbaru</h2>
                <span class="text-sm text-gray-500">Riwayat aktivitas Anda</span>
            </div>
            
            <div class="space-y-4">
                <!-- Account Creation Activity -->
                <div class="flex items-start space-x-3 p-4 bg-green-50 rounded-lg border border-green-100">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">Akun berhasil dibuat</p>
                        <p class="text-xs text-gray-600 mt-1">Selamat datang di Portal Alumni! Akun Anda telah aktif.</p>
                        <p class="text-xs text-gray-500 mt-2">{{ $alumni->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                
                @if($profileCompletion < 100)
                <!-- Profile Update Reminder -->
                <div class="flex items-start space-x-3 p-4 bg-blue-50 rounded-lg border border-blue-100">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">Lengkapi profil Anda</p>
                                <p class="text-xs text-gray-600 mt-1">Mohon lengkapi informasi profil untuk pengalaman yang lebih baik.</p>
                            </div>
                            <span class="text-xs bg-blue-600 text-white px-2 py-1 rounded-md font-medium ml-2">
                                Perlu tindakan
                            </span>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Empty State -->
                <div class="text-center py-6 border-t border-gray-100">
                    <svg class="mx-auto h-8 w-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm text-gray-500">Aktivitas lainnya akan muncul di sini</p>
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

@endsection
