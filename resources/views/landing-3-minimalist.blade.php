<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Minimalist & Clean</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Inter', sans-serif;
        }
        
        .minimal-hover {
            transition: all 0.2s ease;
        }
        
        .minimal-hover:hover {
            transform: translateY(-2px);
        }
        
        .section-divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e5e7eb, transparent);
        }
    </style>
</head>
<body class="bg-white text-gray-900">
    
    <!-- Simple Header -->
    <nav class="border-b border-gray-200 bg-white sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="font-semibold text-xl text-gray-900">TracerStudy</div>
                <div class="flex items-center space-x-8">
                    <a href="#features" class="text-gray-600 hover:text-gray-900 transition text-sm">Fitur</a>
                    <a href="#how" class="text-gray-600 hover:text-gray-900 transition text-sm">Cara Kerja</a>
                    <a href="/login" class="text-gray-900 font-medium text-sm">Masuk</a>
                    <a href="/register" class="bg-gray-900 text-white px-5 py-2 rounded-lg hover:bg-gray-800 transition text-sm font-medium">
                        Mulai
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section - Minimalist -->
    <section class="py-24 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-6">
                <span class="inline-block px-4 py-1 bg-gray-100 text-gray-700 rounded-full text-sm font-medium">
                    Platform Tracer Study Sederhana
                </span>
            </div>
            <h1 class="text-6xl font-bold mb-6 text-gray-900 tracking-tight">
                Lacak Alumni<br/>dengan Mudah
            </h1>
            <p class="text-xl text-gray-600 mb-12 max-w-2xl mx-auto leading-relaxed">
                Sistem survei alumni yang simpel, cepat, dan efektif. 
                Tanpa kompleksitas yang tidak perlu.
            </p>
            <div class="flex justify-center space-x-4">
                <a href="/register" class="bg-gray-900 text-white px-8 py-3 rounded-lg hover:bg-gray-800 transition font-medium minimal-hover">
                    Mulai Gratis
                </a>
                <a href="#how" class="border border-gray-300 text-gray-900 px-8 py-3 rounded-lg hover:border-gray-900 transition font-medium minimal-hover">
                    Lihat Demo
                </a>
            </div>
        </div>
    </section>

    <!-- Stats - Minimal -->
    <section class="py-16 px-4 bg-gray-50">
        <div class="max-w-5xl mx-auto">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">5,000+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Alumni</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">92%</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Response</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">15 Min</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Avg Time</div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900 mb-2">50+</div>
                    <div class="text-sm text-gray-600 uppercase tracking-wide">Institusi</div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Features - Clean Grid -->
    <section id="features" class="py-24 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Utama</h2>
                <p class="text-lg text-gray-600">Semua yang Anda butuhkan, tidak lebih</p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Survei Fleksibel</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Buat kuesioner dengan berbagai tipe pertanyaan</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Data Aman</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Enkripsi end-to-end untuk keamanan data</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Analitik Real-time</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Dashboard dengan visualisasi data interaktif</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Mobile First</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Optimal di semua perangkat mobile dan desktop</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Auto-save</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Progress tersimpan otomatis setiap waktu</p>
                </div>

                <div class="text-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mx-auto mb-6">
                        <svg class="w-6 h-6 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2 text-gray-900">Export Data</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">Download laporan dalam format Excel atau PDF</p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- How It Works -->
    <section id="how" class="py-24 px-4 bg-gray-50">
        <div class="max-w-4xl mx-auto">
            <div class="text-center mb-20">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Cara Kerja</h2>
                <p class="text-lg text-gray-600">Tiga langkah sederhana untuk memulai</p>
            </div>
            
            <div class="space-y-16">
                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold">
                            1
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">Daftar Akun</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Buat akun menggunakan email alumni Anda. Proses registrasi hanya membutuhkan waktu 2 menit.
                        </p>
                    </div>
                </div>

                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold">
                            2
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">Isi Survei</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Jawab pertanyaan tentang pengalaman kerja dan pendidikan Anda. Estimasi waktu: 10-15 menit.
                        </p>
                    </div>
                </div>

                <div class="flex items-start space-x-6">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-gray-900 text-white rounded-full flex items-center justify-center font-bold">
                            3
                        </div>
                    </div>
                    <div>
                        <h3 class="text-xl font-semibold mb-2 text-gray-900">Selesai</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Terima kasih! Data Anda akan membantu meningkatkan kualitas pendidikan almamater.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Simple Testimonial -->
    <section class="py-24 px-4">
        <div class="max-w-3xl mx-auto text-center">
            <blockquote class="text-2xl font-medium text-gray-900 mb-6 leading-relaxed">
                "Interface yang bersih dan mudah digunakan. Pengisian survei menjadi pengalaman yang menyenangkan."
            </blockquote>
            <div class="text-gray-600">
                <div class="font-semibold text-gray-900">Andi Wijaya</div>
                <div class="text-sm">Teknik Informatika 2019 • Product Manager at Tokopedia</div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- FAQ Section -->
    <section class="py-24 px-4 bg-gray-50">
        <div class="max-w-3xl mx-auto">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">FAQ</h2>
                <p class="text-lg text-gray-600">Pertanyaan yang sering diajukan</p>
            </div>
            
            <div class="space-y-6">
                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Berapa lama waktu yang dibutuhkan?</h3>
                    <p class="text-gray-600 text-sm">Rata-rata 10-15 menit untuk menyelesaikan seluruh kuesioner.</p>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Apakah data saya aman?</h3>
                    <p class="text-gray-600 text-sm">Ya, semua data dienkripsi dan hanya digunakan untuk keperluan penelitian institusional.</p>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Bisakah saya menyimpan progress?</h3>
                    <p class="text-gray-600 text-sm">Tentu, sistem akan otomatis menyimpan jawaban Anda dan dapat dilanjutkan kapan saja.</p>
                </div>

                <div class="bg-white rounded-lg p-6 border border-gray-200">
                    <h3 class="font-semibold text-gray-900 mb-2">Apakah wajib mengisi semua pertanyaan?</h3>
                    <p class="text-gray-600 text-sm">Ada beberapa pertanyaan wajib yang harus dijawab, tetapi sebagian besar bersifat opsional.</p>
                </div>
            </div>
        </div>
    </section>

    <div class="section-divider"></div>

    <!-- Simple CTA -->
    <section class="py-24 px-4">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Mulai Hari Ini</h2>
            <p class="text-xl text-gray-600 mb-10">
                Bergabung dengan ribuan alumni yang telah berkontribusi
            </p>
            <div class="flex justify-center space-x-4">
                <a href="/register" class="bg-gray-900 text-white px-10 py-4 rounded-lg hover:bg-gray-800 transition font-medium minimal-hover">
                    Daftar Sekarang
                </a>
                <a href="/login" class="border border-gray-300 text-gray-900 px-10 py-4 rounded-lg hover:border-gray-900 transition font-medium minimal-hover">
                    Sudah Punya Akun
                </a>
            </div>
        </div>
    </section>

    <!-- Minimal Footer -->
    <footer class="border-t border-gray-200 py-12 px-4">
        <div class="max-w-6xl mx-auto">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="font-semibold text-lg text-gray-900 mb-4">TracerStudy</div>
                    <p class="text-gray-600 text-sm">Platform survei alumni yang sederhana dan efektif.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-sm">Produk</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li><a href="#" class="hover:text-gray-900 transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Harga</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Demo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-sm">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li><a href="#" class="hover:text-gray-900 transition">Tentang</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Blog</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 mb-4 text-sm">Legal</h4>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li><a href="#" class="hover:text-gray-900 transition">Privacy</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Terms</a></li>
                        <li><a href="#" class="hover:text-gray-900 transition">Contact</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-8 text-center text-gray-600 text-sm">
                <p>&copy; 2024 TracerStudy. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
