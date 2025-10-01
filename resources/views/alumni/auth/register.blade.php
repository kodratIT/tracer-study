@extends('alumni.layouts.app')

@section('title', 'Daftar')

@section('content')
<x-organisms.auth-layout 
    title="Bergabung dengan Jaringan Alumni"
    subtitle="Buat akun Anda untuk terhubung dengan sesama lulusan dan mengakses sumber daya eksklusif alumni"
    card-width="max-w-2xl"
>
    <x-organisms.auth-form 
        :action="route('alumni.register')"
        submit-text="Buat Akun"
        :submit-icon="'<svg class=\'w-4 h-4 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z\'></path></svg>'"
        footer-text="Sudah punya akun?"
        :footer-link="route('alumni.login')"
        footer-link-text="Masuk di sini"
    >
        <!-- Personal Information Section -->
        <div class="border-b border-gray-100 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Informasi Pribadi
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-molecules.form-field
                    name="student_id"
                    label="NIM"
                    type="text"
                    placeholder="contoh: 12345678"
                    :required="true"
                    help="Nomor Induk Mahasiswa unik Anda"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z\'></path></svg>'"
                />

                <x-molecules.form-field
                    name="name"
                    label="Nama Lengkap"
                    type="text"
                    placeholder="Ahmad Budi"
                    :required="true"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path fill-rule=\'evenodd\' d=\'M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z\' clip-rule=\'evenodd\'></path></svg>'"
                />
            </div>
        </div>

        <!-- Contact Information Section -->
        <div class="border-b border-gray-100 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Informasi Kontak
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-molecules.form-field
                    name="email"
                    label="Alamat Email"
                    type="email"
                    placeholder="ahmad@email.com"
                    :required="true"
                    help="Kami akan gunakan ini untuk notifikasi akun"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z\'></path><path d=\'M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z\'></path></svg>'"
                />

                <x-molecules.form-field
                    name="phone"
                    label="Nomor Telepon"
                    type="tel"
                    placeholder="+62 812-3456-7890"
                    help="Opsional - untuk update penting"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z\'></path></svg>'"
                />
            </div>
        </div>

        <!-- Academic Information Section -->
        <div class="border-b border-gray-100 pb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                </svg>
                Informasi Akademik
            </h3>
            
            <x-molecules.form-field
                name="graduation_year"
                label="Tahun Lulus"
                type="number"
                :placeholder="date('Y')"
                :required="true"
                min="1980"
                :max="date('Y')"
                help="Tahun Anda lulus dari institusi"
                :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path fill-rule=\'evenodd\' d=\'M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z\' clip-rule=\'evenodd\'></path></svg>'"
            />
        </div>

        <!-- Security Section -->
        <div>
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                Keamanan Akun
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-molecules.form-field
                    name="password"
                    label="Kata Sandi"
                    type="password"
                    placeholder="Masukkan kata sandi yang aman"
                    :required="true"
                    help="Minimal 8 karakter"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path fill-rule=\'evenodd\' d=\'M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z\' clip-rule=\'evenodd\'></path></svg>'"
                />

                <x-molecules.form-field
                    name="password_confirmation"
                    label="Konfirmasi Kata Sandi"
                    type="password"
                    placeholder="Ulangi kata sandi"
                    :required="true"
                    help="Harus sama dengan kata sandi"
                    :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path fill-rule=\'evenodd\' d=\'M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z\' clip-rule=\'evenodd\'></path></svg>'"
                />
            </div>
        </div>
    </x-organisms.auth-form>
</x-organisms.auth-layout>
@endsection
