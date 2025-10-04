@extends('alumni.layouts.app')

@section('title', 'Dashboard')

@section('content')

@php
    // Calculate profile completion
    $profileFields = [
        'name' => $alumni->name,
        'email' => $alumni->email, 
        'phone' => $alumni->phone,
        'gender' => $alumni->gender ?? null,
        'birth_date' => $alumni->birth_date ?? null,
        'gpa' => $alumni->gpa ?? null,
        'program_id' => $alumni->program_id ?? null,
        'address' => ($alumni->address_id && $alumni->address) ? $alumni->address->street : null
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
                    <div class="mt-2 flex flex-wrap items-center gap-3 text-sm text-gray-600">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            {{ $alumni->student_id }}
                        </span>
                        <span class="text-gray-300">•</span>
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                            </svg>
                            Lulusan {{ $alumni->graduation_year }}
                        </span>
                        @if($alumni->program_id && $alumni->program)
                            <span class="text-gray-300">•</span>
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                                {{ $alumni->program->program_name }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
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

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-8">
        <!-- Profile Completion Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg bg-{{ $profileColor }}-100">
                    <svg class="w-6 h-6 text-{{ $profileColor }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <span class="text-3xl font-bold text-gray-900">{{ $profileCompletion }}%</span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 mb-1">Kelengkapan Profil</h3>
            <div class="flex items-center justify-between text-xs">
                <span class="text-gray-500">{{ $completedFields }} dari {{ count($profileFields) }} terisi</span>
                @if($profileCompletion < 100)
                    <a href="{{ route('alumni.profile') }}" class="text-{{ $profileColor }}-600 hover:text-{{ $profileColor }}-700 font-medium">Lengkapi →</a>
                @else
                    <span class="text-green-600 font-medium">✓ Lengkap</span>
                @endif
            </div>
            <div class="mt-3 w-full bg-gray-200 rounded-full h-2">
                <div class="bg-{{ $profileColor }}-500 h-2 rounded-full transition-all duration-300" style="width: {{ $profileCompletion }}%"></div>
            </div>
        </div>

        <!-- Employment Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg {{ $hasEmployment ? 'bg-green-100' : 'bg-gray-100' }}">
                    <svg class="w-6 h-6 {{ $hasEmployment ? 'text-green-600' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 12H8m13-13v6m0 0v6m0-6h.01M21 12h.01"></path>
                    </svg>
                </div>
                <span class="text-sm font-semibold {{ $hasEmployment ? 'text-green-600 bg-green-50' : 'text-gray-500 bg-gray-50' }} px-3 py-1 rounded-full">
                    {{ $hasEmployment ? 'Terisi' : 'Belum Ada' }}
                </span>
            </div>
            <h3 class="text-sm font-medium text-gray-600 mb-1">Data Pekerjaan</h3>
            <p class="text-xs text-gray-500 mb-3">
                {{ $hasEmployment ? 'Informasi pekerjaan sudah tersedia' : 'Tambahkan data pekerjaan Anda' }}
            </p>
            @if($hasEmployment)
                <a href="{{ route('alumni.employment.index') }}" class="inline-flex items-center text-sm text-green-600 hover:text-green-700 font-medium">
                    Lihat Detail
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            @else
                <a href="{{ route('alumni.employment.create') }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium">
                    Tambah Data
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </a>
            @endif
        </div>

        <!-- Survey Status Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 rounded-lg {{ $activeSurveySession && $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'bg-purple-100' : ($activeSurveySession ? 'bg-yellow-100' : 'bg-gray-100') }}">
                    <svg class="w-6 h-6 {{ $activeSurveySession && $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'text-purple-600' : ($activeSurveySession ? 'text-yellow-600' : 'text-gray-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                @if($activeSurveySession && $surveyResponse && $surveyResponse->completion_status === 'completed')
                    <span class="text-sm font-semibold text-purple-600 bg-purple-50 px-3 py-1 rounded-full">
                        Selesai
                    </span>
                @elseif($activeSurveySession && $surveyResponse)
                    <span class="text-sm font-semibold text-yellow-600 bg-yellow-50 px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full inline-block mr-1 animate-pulse"></span>
                        {{ ucfirst($surveyResponse->completion_status) }}
                    </span>
                @elseif($activeSurveySession)
                    <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        Tersedia
                    </span>
                @else
                    <span class="text-sm font-semibold text-gray-500 bg-gray-50 px-3 py-1 rounded-full">
                        Tidak Ada
                    </span>
                @endif
            </div>
            <h3 class="text-sm font-medium text-gray-600 mb-1">Tracer Study Survey</h3>
            <p class="text-xs text-gray-500 mb-3">
                @if($activeSurveySession)
                    @if($surveyResponse && $surveyResponse->completion_status === 'completed')
                        Survey {{ $activeSurveySession->year }} sudah selesai
                    @elseif($surveyResponse)
                        Lanjutkan mengisi survey {{ $activeSurveySession->year }}
                    @else
                        Survey {{ $activeSurveySession->year }} tersedia
                    @endif
                @else
                    Belum ada survey aktif saat ini
                @endif
            </p>
            @if($activeSurveySession)
                @if($surveyResponse && $surveyResponse->completion_status === 'completed')
                    <a href="{{ route('alumni.survey.success', $surveyResponse) }}" class="inline-flex items-center text-sm text-purple-600 hover:text-purple-700 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Lihat Detail
                    </a>
                @elseif($surveyResponse)
                    <a href="{{ route('alumni.survey.questionnaire', $surveyResponse) }}" class="inline-flex items-center text-sm text-yellow-600 hover:text-yellow-700 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        Lanjutkan Mengisi
                    </a>
                @else
                    <a href="{{ route('alumni.survey.show', $activeSurveySession) }}" class="inline-flex items-center text-sm text-blue-600 hover:text-blue-700 font-medium">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                        Mulai Survey
                    </a>
                @endif
            @else
                <span class="inline-flex items-center text-sm text-gray-400 font-medium">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Segera Hadir
                </span>
            @endif
        </div>
    </div>



    <!-- Activity Tracker Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
        <div class="p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Langkah-langkah Selanjutnya</h2>
                <span class="text-sm text-gray-500">Selesaikan tahapan berikut secara berurutan</span>
            </div>
            
            @php
                $profileComplete = $profileCompletion >= 80;
                $canAccessEmployment = $profileComplete;
                $canAccessQuestionnaire = $profileComplete && $hasEmployment && $activeSurveySession;
            @endphp
            
            <div class="space-y-4">
                <!-- Step 1: Complete Profile -->
                <div class="relative flex items-start space-x-4 p-4 rounded-lg border-2 {{ $profileComplete ? 'bg-green-50 border-green-200' : 'bg-blue-50 border-blue-200' }}">
                    <!-- Step Number/Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $profileComplete ? 'bg-green-500' : 'bg-blue-500' }}">
                            @if($profileComplete)
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @else
                                <span class="text-white font-bold text-lg">1</span>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-base font-semibold {{ $profileComplete ? 'text-green-900' : 'text-blue-900' }}">
                                    Lengkapi Profil Alumni
                                </h3>
                                <p class="text-sm {{ $profileComplete ? 'text-green-700' : 'text-blue-700' }} mt-1">
                                    @if($profileComplete)
                                        Profil Anda sudah lengkap! Anda dapat melanjutkan ke tahap berikutnya.
                                    @else
                                        Lengkapi informasi pribadi, kontak, dan alamat Anda untuk melanjutkan.
                                    @endif
                                </p>
                                <div class="mt-2">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 bg-gray-200 rounded-full h-2 max-w-xs">
                                            <div class="bg-{{ $profileComplete ? 'green' : 'blue' }}-500 h-2 rounded-full" style="width: {{ $profileCompletion }}%"></div>
                                        </div>
                                        <span class="text-xs font-medium {{ $profileComplete ? 'text-green-700' : 'text-blue-700' }}">{{ $profileCompletion }}%</span>
                                    </div>
                                </div>
                            </div>
                            @if(!$profileComplete)
                                <a href="{{ route('alumni.profile') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    Lengkapi Profil
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="ml-4 inline-flex items-center px-4 py-2 bg-green-100 text-green-700 text-sm font-medium rounded-lg">
                                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Selesai
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Connection Line -->
                <div class="relative pl-5">
                    <div class="absolute left-5 top-0 w-0.5 h-full {{ $profileComplete ? 'bg-green-300' : 'bg-gray-300' }}"></div>
                </div>

                <!-- Step 2: Add Employment -->
                <div class="relative flex items-start space-x-4 p-4 rounded-lg border-2 {{ $hasEmployment ? 'bg-green-50 border-green-200' : ($canAccessEmployment ? 'bg-yellow-50 border-yellow-200' : 'bg-gray-50 border-gray-200') }}">
                    <!-- Step Number/Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $hasEmployment ? 'bg-green-500' : ($canAccessEmployment ? 'bg-yellow-500' : 'bg-gray-400') }}">
                            @if($hasEmployment)
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($canAccessEmployment)
                                <span class="text-white font-bold text-lg">2</span>
                            @else
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-base font-semibold {{ $hasEmployment ? 'text-green-900' : ($canAccessEmployment ? 'text-yellow-900' : 'text-gray-500') }}">
                                    Tambah Data Pekerjaan
                                </h3>
                                <p class="text-sm {{ $hasEmployment ? 'text-green-700' : ($canAccessEmployment ? 'text-yellow-700' : 'text-gray-500') }} mt-1">
                                    @if($hasEmployment)
                                        Data pekerjaan Anda sudah tersimpan. Anda dapat melanjutkan ke kuesioner.
                                    @elseif($canAccessEmployment)
                                        Tambahkan informasi tentang pekerjaan atau kegiatan Anda saat ini.
                                    @else
                                        Selesaikan profil terlebih dahulu untuk membuka tahap ini.
                                    @endif
                                </p>
                            </div>
                            @if($canAccessEmployment && !$hasEmployment)
                                <a href="{{ route('alumni.employment.create') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white text-sm font-medium rounded-lg transition-colors">
                                    Tambah Pekerjaan
                                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </a>
                            @elseif($hasEmployment)
                                <a href="{{ route('alumni.employment.index') }}" class="ml-4 inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors">
                                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                            @else
                                <span class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Terkunci
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Connection Line -->
                <div class="relative pl-5">
                    <div class="absolute left-5 top-0 w-0.5 h-full {{ $hasEmployment ? 'bg-green-300' : 'bg-gray-300' }}"></div>
                </div>

                <!-- Step 3: Fill Questionnaire -->
                <div class="relative flex items-start space-x-4 p-4 rounded-lg border-2 {{ $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'bg-green-50 border-green-200' : ($canAccessQuestionnaire ? 'bg-purple-50 border-purple-200' : 'bg-gray-50 border-gray-200') }}">
                    <!-- Step Number/Icon -->
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'bg-green-500' : ($canAccessQuestionnaire ? 'bg-purple-500' : 'bg-gray-400') }}">
                            @if($surveyResponse && $surveyResponse->completion_status === 'completed')
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($canAccessQuestionnaire)
                                <span class="text-white font-bold text-lg">3</span>
                            @else
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                </svg>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-base font-semibold {{ $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'text-green-900' : ($canAccessQuestionnaire ? 'text-purple-900' : 'text-gray-500') }}">
                                    Isi Kuesioner Tracer Study
                                </h3>
                                <p class="text-sm {{ $surveyResponse && $surveyResponse->completion_status === 'completed' ? 'text-green-700' : ($canAccessQuestionnaire ? 'text-purple-700' : 'text-gray-500') }} mt-1">
                                    @if($surveyResponse && $surveyResponse->completion_status === 'completed')
                                        Terima kasih! Kuesioner tracer study Anda sudah terisi lengkap.
                                    @elseif($canAccessQuestionnaire)
                                        @if($surveyResponse)
                                            Lanjutkan mengisi kuesioner Survey {{ $activeSurveySession->year }}.
                                        @else
                                            Isi kuesioner tentang pengalaman kerja dan pendidikan Anda setelah lulus.
                                        @endif
                                    @else
                                        @if(!$activeSurveySession)
                                            Belum ada survey aktif saat ini.
                                        @else
                                            Selesaikan tahap sebelumnya terlebih dahulu untuk membuka kuesioner.
                                        @endif
                                    @endif
                                </p>
                            </div>
                            @if($canAccessQuestionnaire && (!$surveyResponse || $surveyResponse->completion_status !== 'completed'))
                                @if($surveyResponse)
                                    <a href="{{ route('alumni.survey.questionnaire', $surveyResponse) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        Lanjutkan Isi
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @else
                                    <a href="{{ route('alumni.survey.show', $activeSurveySession) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                                        Mulai Isi
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                @endif
                            @elseif($surveyResponse && $surveyResponse->completion_status === 'completed')
                                <a href="{{ route('alumni.survey.success', $surveyResponse) }}" class="ml-4 inline-flex items-center px-4 py-2 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors">
                                    <svg class="mr-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Lihat Detail
                                </a>
                            @else
                                <span class="ml-4 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                    <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Terkunci
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Progress Summary -->
                @php
                    $completedSteps = collect([$profileComplete, $hasEmployment, $hasCompletedSurvey])->filter()->count();
                    $totalSteps = 3;
                    $overallProgress = round(($completedSteps / $totalSteps) * 100);
                @endphp
                <div class="mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-sm font-medium text-gray-700">Progress Keseluruhan</span>
                        <span class="text-sm font-bold text-gray-900">{{ $completedSteps }}/{{ $totalSteps }} Tahap Selesai</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-blue-600 h-3 rounded-full transition-all duration-500" style="width: {{ $overallProgress }}%"></div>
                    </div>
                    @if($overallProgress == 100)
                        <p class="text-xs text-green-600 mt-2 font-medium">🎉 Selamat! Anda telah menyelesaikan semua tahapan.</p>
                    @else
                        <p class="text-xs text-gray-600 mt-2">Selesaikan {{ $totalSteps - $completedSteps }} tahap lagi untuk melengkapi data Anda.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>
</div>

@endsection
