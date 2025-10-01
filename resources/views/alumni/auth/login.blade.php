@extends('alumni.layouts.app')

@section('title', 'Masuk')

@section('content')
<x-organisms.auth-layout 
    title="Selamat Datang"
    subtitle="Masuk ke akun alumni Anda untuk mengakses sumber daya eksklusif dan terhubung dengan sesama lulusan"
>
    <x-organisms.auth-form 
        :action="route('alumni.login')"
        submit-text="Masuk"
        :submit-icon="'<svg class=\'w-4 h-4 mr-2\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1\'></path></svg>'"
        footer-text="Belum punya akun?"
        :footer-link="route('alumni.register')"
        footer-link-text="Daftar di sini"
    >
        <!-- Email Field -->
        <x-molecules.form-field
            name="email"
            label="Alamat Email"
            type="email"
            placeholder="email@anda.com"
            :required="true"
            :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path d=\'M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z\'></path><path d=\'M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z\'></path></svg>'"
        />

        <!-- Password Field -->
        <x-molecules.form-field
            name="password"
            label="Kata Sandi"
            type="password"
            placeholder="Masukkan kata sandi"
            :required="true"
            :icon="'<svg fill=\'currentColor\' viewBox=\'0 0 20 20\'><path fill-rule=\'evenodd\' d=\'M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z\' clip-rule=\'evenodd\'></path></svg>'"
        />

        <!-- Remember Me Checkbox -->
        <x-molecules.checkbox-field
            name="remember"
            label="Ingat saya selama 30 hari"
        />
    </x-organisms.auth-form>
</x-organisms.auth-layout>
@endsection
