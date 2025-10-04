<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tracer Study - Modern & Professional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="font-sans antialiased">
    
    <!-- Header/Navbar -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold gradient-bg bg-clip-text text-transparent">TracerStudy</span>
                </div>
                <div class="hidden md:flex space-x-8">
                    <a href="#features" class="text-gray-700 hover:text-purple-600 font-medium transition">Fitur</a>
                    <a href="#stats" class="text-gray-700 hover:text-purple-600 font-medium transition">Statistik</a>
                    <a href="#about" class="text-gray-700 hover:text-purple-600 font-medium transition">Tentang</a>
                    <a href="#contact" class="text-gray-700 hover:text-purple-600 font-medium transition">Kontak</a>
                </div>
                <div class="flex space-x-4">
                    <a href="/login" class="text-purple-600 hover:text-purple-700 font-medium">Login</a>
                    <a href="/register" class="bg-purple-600 text-white px-6 py-2 rounded-full hover:bg-purple-700 transition font-medium">Daftar</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="gradient-bg pt-32 pb-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="text-white animate-fade-in-up">
                    <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight">
                        Lacak Kesuksesan Alumni Anda
                    </h1>
                    <p class="text-xl mb-8 text-purple-100 leading-relaxed">
                        Platform survei tracer study modern untuk mengukur kualitas pendidikan dan kesuksesan alumni pasca kelulusan.
                    </p>
                    <div class="flex space-x-4">
                        <a href="/register" class="bg-white text-purple-600 px-8 py-4 rounded-full font-bold hover:bg-gray-100 transition shadow-lg">
                            Mulai Sekarang
                        </a>
                        <a href="#features" class="border-2 border-white text-white px-8 py-4 rounded-full font-bold hover:bg-white hover:text-purple-600 transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white rounded-2xl shadow-2xl p-8">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"/>
                                        <path fill-rule="evenodd" d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm9.707 5.707a1 1 0 00-1.414-1.414L9 12.586l-1.293-1.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                                    <div class="h-3 bg-gray-100 rounded w-1/2"></div>
                                </div>
                            </div>
                            <div class="border-t pt-6">
                                <div class="grid grid-cols-3 gap-4 text-center">
                                    <div>
                                        <div class="text-3xl font-bold text-purple-600">89%</div>
                                        <div class="text-sm text-gray-600">Response Rate</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-purple-600">2.5k</div>
                                        <div class="text-sm text-gray-600">Alumni</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold text-purple-600">15m</div>
                                        <div class="text-sm text-gray-600">Avg Time</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Fitur Unggulan</h2>
                <p class="text-xl text-gray-600">Solusi lengkap untuk tracer study institusi Anda</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Kuesioner Fleksibel</h3>
                    <p class="text-gray-600">Buat survei dengan berbagai tipe pertanyaan: pilihan ganda, essay, rating, dan lainnya.</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Analitik Real-time</h3>
                    <p class="text-gray-600">Dashboard analitik komprehensif dengan visualisasi data yang mudah dipahami.</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Keamanan Terjamin</h3>
                    <p class="text-gray-600">Data alumni terlindungi dengan enkripsi dan sistem autentikasi yang aman.</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Auto-save Progress</h3>
                    <p class="text-gray-600">Alumni dapat menyimpan draft dan melanjutkan pengisian survei kapan saja.</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Mobile Responsive</h3>
                    <p class="text-gray-600">Akses dan isi survei dari perangkat apapun - desktop, tablet, atau smartphone.</p>
                </div>

                <div class="bg-white rounded-xl p-8 shadow-lg card-hover">
                    <div class="w-14 h-14 bg-indigo-100 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-900">Laporan Lengkap</h3>
                    <p class="text-gray-600">Export data ke Excel, PDF, atau visualisasi grafik interaktif.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-20 gradient-bg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8 text-center text-white">
                <div>
                    <div class="text-5xl font-bold mb-2">5,000+</div>
                    <div class="text-purple-200">Alumni Terdaftar</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">92%</div>
                    <div class="text-purple-200">Response Rate</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">50+</div>
                    <div class="text-purple-200">Institusi</div>
                </div>
                <div>
                    <div class="text-5xl font-bold mb-2">15k+</div>
                    <div class="text-purple-200">Survei Terisi</div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-6 text-gray-900">Siap Memulai?</h2>
            <p class="text-xl text-gray-600 mb-8">Bergabunglah dengan ribuan institusi yang sudah menggunakan platform kami</p>
            <div class="flex justify-center space-x-4">
                <a href="/register" class="gradient-bg text-white px-10 py-4 rounded-full font-bold hover:opacity-90 transition shadow-lg text-lg">
                    Daftar Gratis
                </a>
                <a href="#contact" class="border-2 border-purple-600 text-purple-600 px-10 py-4 rounded-full font-bold hover:bg-purple-50 transition text-lg">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-2xl font-bold mb-4 gradient-bg bg-clip-text text-transparent">TracerStudy</h3>
                    <p class="text-gray-400">Platform tracer study terpercaya untuk institusi pendidikan di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Produk</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Fitur</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Demo</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Perusahaan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-white transition">Blog</a></li>
                        <li><a href="#" class="hover:text-white transition">Karir</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: info@tracerstudy.id</li>
                        <li>Phone: +62 21 1234 5678</li>
                        <li>Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2024 TracerStudy. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>
</html>
