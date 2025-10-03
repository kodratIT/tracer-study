@extends('alumni.layouts.app')

@section('title', 'Profile')

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
@endphp

<!-- Modern Profile Layout -->
<div class="bg-gray-50 min-h-screen">
    
    <!-- Page Header -->
    <div class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Pengaturan Profil</h1>
                    <p class="mt-1 text-sm text-gray-600">Kelola informasi pribadi dan data akademik Anda</p>
                </div>
                <div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Kelengkapan Profil</div>
                        <div class="flex items-center mt-1">
                            <div class="flex-1 mr-3">
                                <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                                    <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-500" 
                                         style="width: {{ $profileCompletion }}%"></div>
                                </div>
                            </div>
                            <span class="text-lg font-bold text-gray-900">{{ $profileCompletion }}%</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start">
            <svg class="w-5 h-5 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-sm font-medium text-green-800">Berhasil!</h3>
                <p class="text-sm text-green-700 mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('alumni.profile.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Personal Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h2>
                            <p class="text-sm text-gray-600">Data diri dan kontak Anda</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Student ID (Read Only) -->
                        <div>
                            <label for="student_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Induk Mahasiswa (NIM)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                    </svg>
                                </div>
                                <input type="text" name="student_id" id="student_id" readonly
                                       value="{{ $alumni->student_id }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">NIM tidak dapat diubah</p>
                        </div>

                        <!-- Full Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <input type="text" name="name" id="name" required
                                       value="{{ old('name', $alumni->name) }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('name') border-red-300 @enderror"
                                       placeholder="Masukkan nama lengkap Anda">
                            </div>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" required
                                       value="{{ old('email', $alumni->email) }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('email') border-red-300 @enderror"
                                       placeholder="email@example.com">
                            </div>
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                Nomor Telepon
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input type="text" name="phone" id="phone"
                                       value="{{ old('phone', $alumni->phone) }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('phone') border-red-300 @enderror"
                                       placeholder="+62 812-3456-7890">
                            </div>
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Gender -->
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">
                                Jenis Kelamin
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                    </svg>
                                </div>
                                <select name="gender" id="gender"
                                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('gender') border-red-300 @enderror">
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="male" {{ old('gender', $alumni->gender) == 'male' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="female" {{ old('gender', $alumni->gender) == 'female' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Birth Date -->
                        <div>
                            <label for="birth_date" class="block text-sm font-medium text-gray-700 mb-2">
                                Tanggal Lahir
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <input type="date" name="birth_date" id="birth_date"
                                       value="{{ old('birth_date', $alumni->birth_date ? $alumni->birth_date->format('Y-m-d') : '') }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('birth_date') border-red-300 @enderror">
                            </div>
                            @error('birth_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            <!-- Address Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Alamat</h2>
                            <p class="text-sm text-gray-600">Informasi tempat tinggal Anda</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 gap-6">
                        
                        <!-- Street Address -->
                        <div>
                            <label for="street" class="block text-sm font-medium text-gray-700 mb-2">
                                Alamat Lengkap
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-3 pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                </div>
                                <textarea name="street" id="street" rows="2"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('street') border-red-300 @enderror"
                                       placeholder="Jl. Contoh No. 123, RT/RW 01/02">{{ old('street', $alumni->address->street ?? '') }}</textarea>
                            </div>
                            @error('street')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Province -->
                            <div>
                                <label for="province" class="block text-sm font-medium text-gray-700 mb-2">
                                    Provinsi <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                        </svg>
                                    </div>
                                    <select name="province" id="province" onchange="loadRegencies(this.value)"
                                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('province') border-red-300 @enderror">
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                    <input type="hidden" id="province_code" value="{{ old('province', $alumni->address->province ?? '') }}">
                                </div>
                                @error('province')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kota/Kabupaten <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                    </div>
                                    <select name="city" id="city" onchange="loadDistricts(this.value)"
                                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('city') border-red-300 @enderror">
                                        <option value="">Pilih Provinsi terlebih dahulu</option>
                                    </select>
                                    <input type="hidden" id="city_code" value="{{ old('city', $alumni->address->city ?? '') }}">
                                </div>
                                @error('city')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- District -->
                            <div>
                                <label for="district" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kecamatan
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <select name="district" id="district" onchange="loadVillages(this.value)"
                                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('district') border-red-300 @enderror">
                                        <option value="">Pilih Kota/Kabupaten terlebih dahulu</option>
                                    </select>
                                    <input type="hidden" id="district_code" value="{{ old('district', $alumni->address->district ?? '') }}">
                                </div>
                                @error('district')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Village -->
                            <div>
                                <label for="village" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kelurahan/Desa
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                        </svg>
                                    </div>
                                    <select name="village" id="village"
                                            class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('village') border-red-300 @enderror">
                                        <option value="">Pilih Kecamatan terlebih dahulu</option>
                                    </select>
                                    <input type="hidden" id="village_code" value="{{ old('village', $alumni->address->village ?? '') }}">
                                </div>
                                @error('village')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Postal Code -->
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Kode Pos
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="postal_code" id="postal_code" maxlength="5"
                                           value="{{ old('postal_code', $alumni->address->postal_code ?? '') }}"
                                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('postal_code') border-red-300 @enderror"
                                           placeholder="12345">
                                </div>
                                @error('postal_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Country -->
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                                    Negara
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" name="country" id="country"
                                           value="{{ old('country', $alumni->address->country ?? 'Indonesia') }}"
                                           class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('country') border-red-300 @enderror"
                                           placeholder="Indonesia">
                                </div>
                                @error('country')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Academic Information Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-b border-gray-100">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">Informasi Akademik</h2>
                            <p class="text-sm text-gray-600">Data pendidikan dan prestasi akademik</p>
                        </div>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Program Study -->
                        <div>
                            <label for="program_id" class="block text-sm font-medium text-gray-700 mb-2">
                                Program Studi
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                </div>
                                <select name="program_id" id="program_id"
                                        class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('program_id') border-red-300 @enderror">
                                    <option value="">Pilih Program Studi</option>
                                    @foreach($programs as $program)
                                        <option value="{{ $program->program_id }}" 
                                                {{ old('program_id', $alumni->program_id) == $program->program_id ? 'selected' : '' }}>
                                            {{ $program->program_name }}
                                            @if($program->department)
                                                - {{ $program->department->department_name }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('program_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Pilih program studi yang Anda ambil</p>
                        </div>

                        <!-- Graduation Year (Read Only) -->
                        <div>
                            <label for="graduation_year" class="block text-sm font-medium text-gray-700 mb-2">
                                Tahun Kelulusan
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 14l9-5-9-5-9 5 9 5z"/>
                                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"/>
                                    </svg>
                                </div>
                                <input type="number" name="graduation_year" id="graduation_year" readonly
                                       value="{{ $alumni->graduation_year }}"
                                       class="pl-10 block w-full rounded-lg border-gray-300 bg-gray-50 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5">
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Tahun kelulusan tidak dapat diubah</p>
                        </div>

                        <!-- GPA -->
                        <div>
                            <label for="gpa" class="block text-sm font-medium text-gray-700 mb-2">
                                IPK (Indeks Prestasi Kumulatif)
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </div>
                                <input type="number" name="gpa" id="gpa" step="0.01" min="0" max="4"
                                       value="{{ old('gpa', $alumni->gpa) }}"
                                       placeholder="Contoh: 3.50"
                                       class="pl-10 block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('gpa') border-red-300 @enderror">
                            </div>
                            @error('gpa')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">Masukkan IPK dengan skala 0.00 - 4.00</p>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        <div class="text-sm text-gray-600">
                            <p class="font-medium">Pastikan data yang Anda masukkan benar dan lengkap</p>
                            <p class="mt-1">Field dengan tanda <span class="text-red-500">*</span> wajib diisi</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('alumni.dashboard') }}" 
                           class="px-6 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <span class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan Perubahan
                            </span>
                        </button>
                    </div>
                </div>
            </div>

        </form>

        <!-- Security Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="bg-gradient-to-r from-red-50 to-pink-50 px-6 py-4 border-b border-gray-100">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-semibold text-gray-900">Keamanan Akun</h2>
                        <p class="text-sm text-gray-600">Kelola kata sandi dan pengaturan keamanan</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-900">Kata Sandi</h3>
                        <p class="mt-1 text-sm text-gray-500">Terakhir diubah: {{ $alumni->updated_at->diffForHumans() }}</p>
                    </div>
                    <button type="button" 
                            onclick="alert('Fitur ubah password akan segera tersedia')"
                            class="px-4 py-2 border border-red-300 rounded-lg text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Ubah Kata Sandi
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    // Global variables for API cache
    let provincesData = [];
    let regenciesCache = {};
    let districtsCache = {};
    let villagesCache = {};
    let isInitialLoad = true;

    // Load provinces on page load
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Page loaded, starting cascade...');
        loadProvinces();
    });

    // Fetch provinces from API
    async function loadProvinces() {
        const provinceSelect = document.getElementById('province');
        const selectedProvinceCode = document.getElementById('province_code').value;
        
        console.log('Loading provinces... Selected CODE:', selectedProvinceCode);
        
        try {
            provinceSelect.innerHTML = '<option value="">Memuat provinsi...</option>';
            
            const response = await fetch('{{ route("api.wilayah.provinces") }}');
            const data = await response.json();
            
            provincesData = data.data;
            
            // Populate dropdown
            provinceSelect.innerHTML = '<option value="">Pilih Provinsi</option>';
            provincesData.forEach(province => {
                const option = document.createElement('option');
                option.value = province.code;
                option.textContent = province.name;
                provinceSelect.appendChild(option);
            });
            
            // Auto-select by CODE directly
            if (selectedProvinceCode && isInitialLoad) {
                console.log('Auto-selecting province CODE:', selectedProvinceCode);
                provinceSelect.value = selectedProvinceCode; // Select by CODE
                await loadRegencies(selectedProvinceCode);
            }
        } catch (error) {
            console.error('Error loading provinces:', error);
            provinceSelect.innerHTML = '<option value="">Gagal memuat provinsi</option>';
        }
    }

    // Fetch regencies based on province code
    async function loadRegencies(provinceCode) {
        const citySelect = document.getElementById('city');
        const districtSelect = document.getElementById('district');
        const villageSelect = document.getElementById('village');
        const selectedCityCode = document.getElementById('city_code').value;
        
        if (!provinceCode) {
            citySelect.innerHTML = '<option value="">Pilih Provinsi terlebih dahulu</option>';
            districtSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>';
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
            citySelect.disabled = false;
            districtSelect.disabled = true;
            villageSelect.disabled = true;
            return;
        }
        
        try {
            citySelect.innerHTML = '<option value="">Memuat kota/kabupaten...</option>';
            citySelect.disabled = true;
            
            if (regenciesCache[provinceCode]) {
                await populateRegencies(regenciesCache[provinceCode], selectedCityCode);
                return;
            }
            
            const response = await fetch(`{{ url('/api/wilayah/regencies') }}/${provinceCode}`);
            const data = await response.json();
            
            regenciesCache[provinceCode] = data.data;
            await populateRegencies(data.data, selectedCityCode);
        } catch (error) {
            console.error('Error loading regencies:', error);
            citySelect.innerHTML = '<option value="">Gagal memuat kota/kabupaten</option>';
            citySelect.disabled = false;
        }
    }

    // Populate regencies dropdown
    async function populateRegencies(regencies, selectedCityCode) {
        const citySelect = document.getElementById('city');
        
        console.log('Populating regencies... Selected city CODE:', selectedCityCode);
        
        // Populate dropdown
        citySelect.innerHTML = '<option value="">Pilih Kota/Kabupaten</option>';
        regencies.forEach(regency => {
            const option = document.createElement('option');
            option.value = regency.code;
            option.textContent = regency.name;
            citySelect.appendChild(option);
        });
        
        citySelect.disabled = false;
        
        // Auto-select by CODE directly
        if (selectedCityCode && isInitialLoad) {
            console.log('Auto-selecting city CODE:', selectedCityCode);
            citySelect.value = selectedCityCode; // Select by CODE
            await loadDistricts(selectedCityCode);
        }
    }

    // Fetch districts based on regency code
    async function loadDistricts(regencyCode) {
        const districtSelect = document.getElementById('district');
        const villageSelect = document.getElementById('village');
        const selectedDistrictCode = document.getElementById('district_code').value;
        
        if (!regencyCode) {
            districtSelect.innerHTML = '<option value="">Pilih Kota/Kabupaten terlebih dahulu</option>';
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
            districtSelect.disabled = true;
            villageSelect.disabled = true;
            return;
        }
        
        try {
            districtSelect.innerHTML = '<option value="">Memuat kecamatan...</option>';
            districtSelect.disabled = true;
            
            if (districtsCache[regencyCode]) {
                await populateDistricts(districtsCache[regencyCode], selectedDistrictCode);
                return;
            }
            
            const response = await fetch(`{{ url('/api/wilayah/districts') }}/${regencyCode}`);
            const data = await response.json();
            
            districtsCache[regencyCode] = data.data;
            await populateDistricts(data.data, selectedDistrictCode);
        } catch (error) {
            console.error('Error loading districts:', error);
            districtSelect.innerHTML = '<option value="">Gagal memuat kecamatan</option>';
            districtSelect.disabled = false;
        }
    }

    // Populate districts dropdown
    async function populateDistricts(districts, selectedDistrictCode) {
        const districtSelect = document.getElementById('district');
        
        console.log('Populating districts... Selected district CODE:', selectedDistrictCode);
        console.log('Districts data:', districts);
        
        // Populate dropdown
        districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
        districts.forEach(district => {
            const option = document.createElement('option');
            option.value = district.code;
            option.textContent = district.name;
            districtSelect.appendChild(option);
        });
        
        districtSelect.disabled = false;
        
        // Auto-select by CODE directly
        if (selectedDistrictCode && isInitialLoad) {
            console.log('Auto-selecting district CODE:', selectedDistrictCode);
            districtSelect.value = selectedDistrictCode; // Select by CODE
            await loadVillages(selectedDistrictCode);
            isInitialLoad = false; // Done with initial load
        }
    }

    // Fetch villages based on district code
    async function loadVillages(districtCode) {
        const villageSelect = document.getElementById('village');
        const selectedVillageCode = document.getElementById('village_code').value;
        
        if (!districtCode) {
            villageSelect.innerHTML = '<option value="">Pilih Kecamatan terlebih dahulu</option>';
            villageSelect.disabled = true;
            return;
        }
        
        try {
            villageSelect.innerHTML = '<option value="">Memuat kelurahan/desa...</option>';
            villageSelect.disabled = true;
            
            if (villagesCache[districtCode]) {
                populateVillages(villagesCache[districtCode], selectedVillageCode);
                return;
            }
            
            const response = await fetch(`{{ url('/api/wilayah/villages') }}/${districtCode}`);
            const data = await response.json();
            
            villagesCache[districtCode] = data.data;
            populateVillages(data.data, selectedVillageCode);
        } catch (error) {
            console.error('Error loading villages:', error);
            villageSelect.innerHTML = '<option value="">Gagal memuat kelurahan/desa</option>';
            villageSelect.disabled = false;
        }
    }

    // Populate villages dropdown
    function populateVillages(villages, selectedVillageCode) {
        const villageSelect = document.getElementById('village');
        
        console.log('Populating villages... Selected village CODE:', selectedVillageCode);
        console.log('Villages data:', villages);
        
        // Populate dropdown
        villageSelect.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
        villages.forEach(village => {
            const option = document.createElement('option');
            option.value = village.code;
            option.textContent = village.name;
            villageSelect.appendChild(option);
        });
        
        villageSelect.disabled = false;
        
        // Auto-select by CODE directly
        if (selectedVillageCode) {
            console.log('Auto-selecting village CODE:', selectedVillageCode);
            villageSelect.value = selectedVillageCode; // Select by CODE
        }
        
        console.log('Initial load completed!');
    }

    // Form sudah langsung submit CODE (tidak perlu konversi lagi)
</script>
@endpush

@endsection
