@extends('alumni.layouts.app')

@section('title', 'Edit Pekerjaan')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('alumni.employment.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
            </div>
            <h1 class="text-3xl font-bold text-gray-900">Edit Data Pekerjaan</h1>
            <p class="mt-2 text-sm text-gray-600">Perbarui informasi pekerjaan atau kegiatan Anda</p>
        </div>

        <!-- Form -->
        <form action="{{ route('alumni.employment.update', $employment) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Status Pekerjaan Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Kegiatan Saat Ini</h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <label class="relative flex items-center p-4 rounded-lg border-2 cursor-pointer transition-all hover:border-blue-300 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                        <input type="radio" name="employment_status" value="employed" class="peer sr-only" {{ old('employment_status', $employment->employment_status) == 'employed' ? 'checked' : '' }} required>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m8 0h4a2 2 0 012 2v9a2 2 0 01-2 2H6a2 2 0 01-2-2V8a2 2 0 012-2h4"></path>
                            </svg>
                            <div>
                                <span class="block font-medium text-gray-900">Bekerja</span>
                                <span class="block text-xs text-gray-500">Full time / Part time / Freelance</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-lg border-2 cursor-pointer transition-all hover:border-purple-300 has-[:checked]:border-purple-500 has-[:checked]:bg-purple-50">
                        <input type="radio" name="employment_status" value="entrepreneur" class="peer sr-only" {{ old('employment_status', $employment->employment_status) == 'entrepreneur' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-purple-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <span class="block font-medium text-gray-900">Wirausaha</span>
                                <span class="block text-xs text-gray-500">Pemilik usaha sendiri</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-lg border-2 cursor-pointer transition-all hover:border-yellow-300 has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-50">
                        <input type="radio" name="employment_status" value="studying" class="peer sr-only" {{ old('employment_status', $employment->employment_status) == 'studying' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                                <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                            </svg>
                            <div>
                                <span class="block font-medium text-gray-900">Melanjutkan Studi</span>
                                <span class="block text-xs text-gray-500">S2, S3, atau lainnya</span>
                            </div>
                        </div>
                    </label>

                    <label class="relative flex items-center p-4 rounded-lg border-2 cursor-pointer transition-all hover:border-gray-300 has-[:checked]:border-gray-500 has-[:checked]:bg-gray-50">
                        <input type="radio" name="employment_status" value="unemployed" class="peer sr-only" {{ old('employment_status', $employment->employment_status) == 'unemployed' ? 'checked' : '' }}>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <div>
                                <span class="block font-medium text-gray-900">Belum Bekerja</span>
                                <span class="block text-xs text-gray-500">Sedang mencari pekerjaan</span>
                            </div>
                        </div>
                    </label>
                </div>

                @error('employment_status')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Company Information (Conditional) -->
            <div id="company-section" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    Informasi Perusahaan/Usaha
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Perusahaan/Usaha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $employment->employer?->employer_name) }}"
                                   class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('company_name') border-red-300 @enderror"
                                   placeholder="Ketik nama perusahaan..."
                                   autocomplete="off">
                            <input type="hidden" id="selected_employer_id" name="employer_id" value="{{ old('employer_id', $employment->employer_id) }}">
                            
                            <!-- Dropdown suggestions -->
                            <div id="company_suggestions" class="absolute z-10 w-full bg-white border border-gray-300 rounded-lg shadow-lg mt-1 max-h-60 overflow-y-auto hidden">
                                <!-- Suggestions will be populated here -->
                            </div>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Ketik untuk mencari perusahaan yang sudah terdaftar, atau isi manual untuk perusahaan baru</p>
                        @error('company_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="industry_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Bidang Industri <span class="text-red-500">*</span>
                        </label>
                        <select name="industry_type" id="industry_type"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('industry_type') border-red-300 @enderror">
                            <option value="">Pilih bidang industri</option>
                            <option value="Technology" {{ old('industry_type', $employment->employer?->industry_type) == 'Technology' ? 'selected' : '' }}>Teknologi/IT</option>
                            <option value="Finance" {{ old('industry_type', $employment->employer?->industry_type) == 'Finance' ? 'selected' : '' }}>Keuangan/Perbankan</option>
                            <option value="Education" {{ old('industry_type', $employment->employer?->industry_type) == 'Education' ? 'selected' : '' }}>Pendidikan</option>
                            <option value="Healthcare" {{ old('industry_type', $employment->employer?->industry_type) == 'Healthcare' ? 'selected' : '' }}>Kesehatan</option>
                            <option value="Manufacturing" {{ old('industry_type', $employment->employer?->industry_type) == 'Manufacturing' ? 'selected' : '' }}>Manufaktur</option>
                            <option value="Retail" {{ old('industry_type', $employment->employer?->industry_type) == 'Retail' ? 'selected' : '' }}>Retail/Perdagangan</option>
                            <option value="Construction" {{ old('industry_type', $employment->employer?->industry_type) == 'Construction' ? 'selected' : '' }}>Konstruksi</option>
                            <option value="Transportation" {{ old('industry_type', $employment->employer?->industry_type) == 'Transportation' ? 'selected' : '' }}>Transportasi/Logistik</option>
                            <option value="Hospitality" {{ old('industry_type', $employment->employer?->industry_type) == 'Hospitality' ? 'selected' : '' }}>Hotel/Pariwisata</option>
                            <option value="Media" {{ old('industry_type', $employment->employer?->industry_type) == 'Media' ? 'selected' : '' }}>Media/Komunikasi</option>
                            <option value="Government" {{ old('industry_type', $employment->employer?->industry_type) == 'Government' ? 'selected' : '' }}>Pemerintahan</option>
                            <option value="Other" {{ old('industry_type', $employment->employer?->industry_type) == 'Other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('industry_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="website" class="block text-sm font-medium text-gray-700 mb-2">
                            Website Perusahaan
                        </label>
                        <input type="url" name="website" id="website" value="{{ old('website', $employment->employer?->website) }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('website') border-red-300 @enderror"
                               placeholder="https://www.example.com">
                        @error('website')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="company_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            No. Telepon Perusahaan
                        </label>
                        <input type="tel" name="company_phone" id="company_phone" value="{{ old('company_phone', $employment->company_phone) }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('company_phone') border-red-300 @enderror"
                               placeholder="021-1234567 atau 0812345678">
                        @error('company_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Job Position (Conditional) -->
            <div id="position-section" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Informasi Posisi & Jabatan
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="job_title" class="block text-sm font-medium text-gray-700 mb-2">
                            Jabatan/Posisi <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="job_title" id="job_title" value="{{ old('job_title', $employment->job_title) }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('job_title') border-red-300 @enderror"
                               placeholder="Software Engineer, Marketing Manager, dll">
                        @error('job_title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="job_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Level Jabatan <span class="text-red-500">*</span>
                        </label>
                        <select name="job_level" id="job_level"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('job_level') border-red-300 @enderror">
                            <option value="">Pilih level</option>
                            <option value="entry" {{ old('job_level', $employment->job_level) == 'entry' ? 'selected' : '' }}>Entry Level</option>
                            <option value="junior" {{ old('job_level', $employment->job_level) == 'junior' ? 'selected' : '' }}>Junior</option>
                            <option value="mid" {{ old('job_level', $employment->job_level) == 'mid' ? 'selected' : '' }}>Mid Level</option>
                            <option value="senior" {{ old('job_level', $employment->job_level) == 'senior' ? 'selected' : '' }}>Senior</option>
                            <option value="lead" {{ old('job_level', $employment->job_level) == 'lead' ? 'selected' : '' }}>Lead</option>
                            <option value="supervisor" {{ old('job_level', $employment->job_level) == 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="manager" {{ old('job_level', $employment->job_level) == 'manager' ? 'selected' : '' }}>Manager</option>
                            <option value="director" {{ old('job_level', $employment->job_level) == 'director' ? 'selected' : '' }}>Director</option>
                            <option value="vp" {{ old('job_level', $employment->job_level) == 'vp' ? 'selected' : '' }}>Vice President</option>
                            <option value="ceo" {{ old('job_level', $employment->job_level) == 'ceo' ? 'selected' : '' }}>C-Level (CEO/CTO/CFO/dll)</option>
                        </select>
                        @error('job_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="contract_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipe Kontrak <span class="text-red-500">*</span>
                        </label>
                        <select name="contract_type" id="contract_type"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('contract_type') border-red-300 @enderror">
                            <option value="">Pilih tipe kontrak</option>
                            <option value="full_time" {{ old('contract_type', $employment->contract_type) == 'full_time' ? 'selected' : '' }}>Full Time</option>
                            <option value="part_time" {{ old('contract_type', $employment->contract_type) == 'part_time' ? 'selected' : '' }}>Part Time</option>
                            <option value="contract" {{ old('contract_type', $employment->contract_type) == 'contract' ? 'selected' : '' }}>Contract/Project Based</option>
                            <option value="freelance" {{ old('contract_type', $employment->contract_type) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="internship" {{ old('contract_type', $employment->contract_type) == 'internship' ? 'selected' : '' }}>Internship</option>
                        </select>
                        @error('contract_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="job_description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi Pekerjaan
                        </label>
                        <textarea name="job_description" id="job_description" rows="4"
                                  class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('job_description') border-red-300 @enderror"
                                  placeholder="Jelaskan tanggung jawab dan tugas utama Anda...">{{ old('job_description', $employment->job_description) }}</textarea>
                        @error('job_description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Study Information (Conditional) -->
            <div id="study-section" class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hidden">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path>
                    </svg>
                    Informasi Studi Lanjut
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Institusi/Universitas <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="institution_name" id="institution_name" value="{{ old('institution_name', $employment->institution_name) }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('institution_name') border-red-300 @enderror"
                               placeholder="Universitas Indonesia, ITB, dll">
                        @error('institution_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="study_level" class="block text-sm font-medium text-gray-700 mb-2">
                            Jenjang Studi <span class="text-red-500">*</span>
                        </label>
                        <select name="study_level" id="study_level"
                                class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('study_level') border-red-300 @enderror">
                            <option value="">Pilih jenjang</option>
                            <option value="S2" {{ old('study_level', $employment->study_level) == 'S2' ? 'selected' : '' }}>S2 (Master)</option>
                            <option value="S3" {{ old('study_level', $employment->study_level) == 'S3' ? 'selected' : '' }}>S3 (Doktor)</option>
                            <option value="Profesi" {{ old('study_level', $employment->study_level) == 'Profesi' ? 'selected' : '' }}>Profesi</option>
                            <option value="Spesialis" {{ old('study_level', $employment->study_level) == 'Spesialis' ? 'selected' : '' }}>Spesialis</option>
                            <option value="Lainnya" {{ old('study_level', $employment->study_level) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('study_level')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="major" class="block text-sm font-medium text-gray-700 mb-2">
                            Program Studi/Jurusan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="major" id="major" value="{{ old('major', $employment->major) }}"
                               class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-2.5 @error('major') border-red-300 @enderror"
                               placeholder="Teknik Informatika, Manajemen, dll">
                        @error('major')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status Aktif -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Status Pekerjaan</h2>
                <div class="flex items-start">
                    <div class="flex items-center h-5">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $employment->is_active) ? 'checked' : '' }}
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                    </div>
                    <div class="ml-3">
                        <label for="is_active" class="font-medium text-gray-900 cursor-pointer">
                            Pekerjaan/Kegiatan Aktif Saat Ini
                        </label>
                        <p class="text-sm text-gray-500 mt-1">
                            Centang jika ini adalah pekerjaan atau kegiatan yang sedang Anda jalani saat ini. Hanya satu pekerjaan yang bisa aktif pada satu waktu.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('alumni.employment.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Perbarui Data Pekerjaan
                </button>
            </div>

        </form>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusRadios = document.querySelectorAll('input[name="employment_status"]');
    const companySection = document.getElementById('company-section');
    const positionSection = document.getElementById('position-section');
    const studySection = document.getElementById('study-section');

    // Handle employment status change
    function updateSections() {
        const selectedStatus = document.querySelector('input[name="employment_status"]:checked')?.value;
        
        // Hide all sections first
        companySection.classList.add('hidden');
        positionSection.classList.add('hidden');
        studySection.classList.add('hidden');

        // Show relevant sections based on status
        if (selectedStatus === 'employed' || selectedStatus === 'entrepreneur') {
            companySection.classList.remove('hidden');
            positionSection.classList.remove('hidden');
        } else if (selectedStatus === 'studying') {
            studySection.classList.remove('hidden');
        }
    }

    // Add event listeners
    statusRadios.forEach(radio => {
        radio.addEventListener('change', updateSections);
    });

    // Initial state
    updateSections();

    // Company Autocomplete
    const companyNameInput = document.getElementById('company_name');
    const companySuggestions = document.getElementById('company_suggestions');
    const selectedEmployerId = document.getElementById('selected_employer_id');
    const industryTypeSelect = document.getElementById('industry_type');
    const websiteInput = document.getElementById('website');
    let searchTimeout;

    companyNameInput.addEventListener('input', function() {
        const query = this.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length < 2) {
            companySuggestions.classList.add('hidden');
            companySuggestions.innerHTML = '';
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`{{ route('alumni.employment.search-employers') }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        companySuggestions.innerHTML = data.map(employer => `
                            <div class="px-4 py-3 hover:bg-gray-50 cursor-pointer border-b border-gray-100 last:border-b-0 employer-suggestion"
                                 data-id="${employer.employer_id}"
                                 data-name="${employer.employer_name}"
                                 data-industry="${employer.industry_type || ''}"
                                 data-website="${employer.website || ''}">
                                <div class="font-medium text-gray-900">${employer.employer_name}</div>
                                <div class="text-sm text-gray-500">${employer.industry_type || 'Industri tidak tersedia'}</div>
                            </div>
                        `).join('');
                        companySuggestions.classList.remove('hidden');

                        // Add click listeners to suggestions
                        document.querySelectorAll('.employer-suggestion').forEach(suggestion => {
                            suggestion.addEventListener('click', function() {
                                const employerId = this.dataset.id;
                                const employerName = this.dataset.name;
                                const industry = this.dataset.industry;
                                const website = this.dataset.website;

                                // Fill form fields
                                companyNameInput.value = employerName;
                                selectedEmployerId.value = employerId;
                                
                                if (industry) {
                                    industryTypeSelect.value = industry;
                                }
                                
                                if (website) {
                                    websiteInput.value = website;
                                }

                                // Hide suggestions
                                companySuggestions.classList.add('hidden');
                            });
                        });
                    } else {
                        companySuggestions.innerHTML = `
                            <div class="px-4 py-3 text-sm text-gray-500">
                                Perusahaan tidak ditemukan. Anda bisa menambahkan perusahaan baru dengan mengisi form di bawah.
                            </div>
                        `;
                        companySuggestions.classList.remove('hidden');
                        selectedEmployerId.value = '';
                    }
                })
                .catch(error => {
                    console.error('Error fetching employers:', error);
                    companySuggestions.classList.add('hidden');
                });
        }, 300);
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(event) {
        if (!companyNameInput.contains(event.target) && !companySuggestions.contains(event.target)) {
            companySuggestions.classList.add('hidden');
        }
    });

    // Clear hidden employer_id when user manually changes company name
    companyNameInput.addEventListener('change', function() {
        const currentValue = this.value;
        const selectedValue = selectedEmployerId.value;
        
        if (selectedValue && currentValue) {
            setTimeout(() => {
                if (!companySuggestions.querySelector('.employer-suggestion')) {
                    selectedEmployerId.value = '';
                }
            }, 100);
        }
    });
});
</script>
@endpush
@endsection
