@extends('alumni.layouts.app')

@section('title', 'Tracer Study - Pengantar')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('alumni.survey.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Survey
            </a>
        </div>

        <!-- Main Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-purple-600 px-8 py-10 text-center">
                <div class="mx-auto w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">Tracer Study {{ $session->year }}</h1>
                <p class="text-blue-100">Survey Pelacakan Alumni</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-8">
                
                <!-- Welcome Message -->
                <div class="mb-8">
                    <h2 class="text-xl font-semibold text-gray-900 mb-3">Selamat Datang!</h2>
                    <p class="text-gray-700 leading-relaxed">
                        Tracer study ini bertujuan untuk mengetahui kondisi alumni setelah lulus dari program studi. 
                        Data yang Anda berikan akan membantu institusi dalam meningkatkan kualitas pendidikan dan 
                        relevansi kurikulum dengan kebutuhan dunia kerja.
                    </p>
                </div>

                @if($session->description)
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-100 rounded-lg">
                        <p class="text-sm text-blue-900">{{ $session->description }}</p>
                    </div>
                @endif

                <!-- Survey Info -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-blue-100 rounded-lg">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Pertanyaan</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $questionCount }} Pertanyaan</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Estimasi Waktu</p>
                                <p class="text-lg font-semibold text-gray-900">{{ ceil($questionCount / 2.5) }}-{{ ceil($questionCount / 1.5) }} menit</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 rounded-lg">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Batas Akhir</p>
                                <p class="text-lg font-semibold text-gray-900">{{ $session->end_date->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="mb-8 p-6 bg-amber-50 border border-amber-200 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-amber-600 mt-0.5 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="flex-1">
                            <h3 class="text-sm font-semibold text-amber-900 mb-2">Informasi Penting</h3>
                            <ul class="space-y-1.5 text-sm text-amber-800">
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Data yang Anda berikan akan dijaga kerahasiaannya</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Jawablah semua pertanyaan dengan jujur dan lengkap</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Anda dapat menyimpan draft dan melanjutkan pengisian nanti</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="mr-2">•</span>
                                    <span>Pastikan koneksi internet Anda stabil selama mengisi survey</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Status Message if response exists -->
                @if($response)
                    <div class="mb-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-sm font-medium text-blue-900">
                                    Anda memiliki draft yang tersimpan
                                </p>
                                <p class="text-sm text-blue-700 mt-1">
                                    Klik tombol di bawah untuk melanjutkan dari terakhir kali Anda mengisi.
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                    <a href="{{ route('alumni.survey.index') }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        Kembali
                    </a>
                    
                    <form action="{{ route('alumni.survey.start', $session) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-medium rounded-lg transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                            {{ $response ? 'Lanjutkan Mengisi Survey' : 'Mulai Mengisi Survey' }}
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
