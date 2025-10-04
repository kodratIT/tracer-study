<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Platform Tracer Study Alumni untuk melacak kesuksesan lulusan dan meningkatkan kualitas pendidikan tinggi di Indonesia.">
    <meta name="keywords" content="tracer study, alumni, pendidikan tinggi, akreditasi, BAN-PT, survei alumni">
    <meta name="author" content="Tracer Study Program">
    
    <!-- Open Graph -->
    <meta property="og:title" content="Tracer Study - Program Pelacakan Alumni">
    <meta property="og:description" content="Sistem pelacakan alumni untuk meningkatkan kualitas pendidikan tinggi">
    <meta property="og:type" content="website">
    
    <title>Tracer Study - Program Pelacakan Alumni | Akreditasi BAN-PT</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@300;400;700&family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        
        h1, h2, h3, h4 {
            font-family: 'Merriweather', serif;
        }
        
        .academic-header {
            background: linear-gradient(to bottom, #1e3a8a 0%, #1e40af 100%);
            border-bottom: 4px solid #fbbf24;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        
        .testimonial-card {
            border-left: 4px solid #1e40af;
            background: #f8fafc;
            transition: all 0.3s ease;
        }
        
        .testimonial-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        
        .timeline-dot {
            width: 16px;
            height: 16px;
            background: #fbbf24;
            border: 3px solid #1e40af;
            border-radius: 50%;
        }
        
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .benefit-card {
            transition: all 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        #back-to-top {
            transition: all 0.3s ease;
        }
        
        #back-to-top.hidden {
            opacity: 0;
            pointer-events: none;
        }

        /* WhatsApp button animation */
        #wa-button {
            animation: bounceIn 1s ease-out;
        }

        #wa-button:hover {
            transform: scale(1.1);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }
        
        .process-card {
            animation-duration: 0.6s;
            animation-fill-mode: both;
        }
        
        .process-card:hover .bg-white {
            transform: translateY(-5px);
        }
        
        @keyframes slideInFromBottom {
            from {
                opacity: 0;
                transform: translateY(50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .process-card.visible {
            animation-name: slideInFromBottom;
        }
        
        .portal-screen {
            position: relative;
            transition: opacity 0.5s ease;
        }
        
        .portal-screen.hidden {
            display: none;
        }
        
        .portal-tab {
            transition: all 0.3s ease;
        }
        
        .portal-tab.active {
            background-color: #1e3a8a !important;
            color: white !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Academic Header -->
    <header class="academic-header text-white py-4 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-blue-900 font-bold text-xl">TS</span>
                    </div>
                    <div>
                        <div class="font-bold text-lg">Tracer Study Program</div>
                        <div class="text-sm text-blue-200 hidden sm:block">Excellence in Education Tracking</div>
                    </div>
                </div>
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="#about" class="hover:text-yellow-300 transition font-medium">Tentang</a>
                    <a href="#benefits" class="hover:text-yellow-300 transition font-medium">Manfaat</a>
                    <a href="#process" class="hover:text-yellow-300 transition font-medium">Cara Kerja</a>
                    <a href="#faq" class="hover:text-yellow-300 transition font-medium">FAQ</a>
                    <a href="/admin" class="inline-flex items-center text-yellow-300 hover:text-yellow-400 transition font-medium">
                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        Admin
                    </a>
                    <a href="/alumni/login" class="bg-yellow-400 text-blue-900 px-6 py-2 rounded-lg font-semibold hover:bg-yellow-300 transition shadow-lg">
                        Portal Alumni
                    </a>
                </nav>
                <!-- Mobile menu button -->
                <button id="mobile-menu-button" class="md:hidden text-white p-2 hover:bg-blue-800 rounded-lg transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
            <!-- Mobile menu -->
            <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4 space-y-3">
                <a href="#about" class="block py-2 px-4 hover:bg-blue-800 rounded-lg transition font-medium">Tentang</a>
                <a href="#benefits" class="block py-2 px-4 hover:bg-blue-800 rounded-lg transition font-medium">Manfaat</a>
                <a href="#process" class="block py-2 px-4 hover:bg-blue-800 rounded-lg transition font-medium">Cara Kerja</a>
                <a href="#faq" class="block py-2 px-4 hover:bg-blue-800 rounded-lg transition font-medium">FAQ</a>
                <div class="border-t border-blue-700 pt-3">
                    <a href="/admin" class="flex items-center justify-center py-2 px-4 hover:bg-blue-800 rounded-lg transition font-medium">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        Dashboard Admin
                    </a>
                    <a href="/alumni/login" class="block text-center bg-yellow-400 text-blue-900 px-6 py-3 rounded-lg font-semibold hover:bg-yellow-300 transition shadow-lg mt-3">
                        Portal Alumni
                    </a>
                </div>
            </div>
        </div>
    </header>

    <script>
        // Mobile menu toggle
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking anchor links
        document.querySelectorAll('#mobile-menu a[href^="#"]').forEach(link => {
            link.addEventListener('click', () => {
                document.getElementById('mobile-menu').classList.add('hidden');
            });
        });
    </script>

    <!-- Hero Section with Academic Seal -->
    <section class="bg-gradient-to-br from-gray-50 to-white py-20 md:py-24 border-b-2 border-gray-200">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="fade-in-up">
                    <div class="inline-flex items-center bg-yellow-100 text-yellow-800 px-4 py-2 rounded-full text-sm font-semibold mb-6 animate-pulse">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Indonesia Emas 2045
                    </div>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6 leading-tight">
                        Program Tracer Study <span class="text-blue-900">Alumni</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-700 mb-4 leading-relaxed">
                        Sistem pelacakan alumni yang dirancang untuk meningkatkan kualitas pendidikan dan mengukur keberhasilan lulusan dalam dunia kerja.
                    </p>
                    <div class="flex items-start space-x-3 mb-6">
                        <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
                        <p class="text-base text-gray-600">
                            <strong class="text-gray-800">Dipercaya universitas</strong> di Indonesia untuk standar akreditasi BAN-PT
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <a href="/alumni/register" class="inline-flex items-center justify-center bg-blue-900 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Mulai Isi Survei
                        </a>
                        <a href="#process" class="inline-flex items-center justify-center border-2 border-blue-900 text-blue-900 px-8 py-4 rounded-lg font-bold hover:bg-blue-50 transition-all duration-300">
                            Lihat Cara Kerja
                            <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </a>
                    </div>
                    <div class="flex items-center space-x-6 text-sm text-gray-600">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-900 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                            </svg>
                            <span>10-15 menit</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-900 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Data aman & rahasia</span>
                        </div>
                    </div>
                </div>
                <div class="flex justify-center fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-full max-w-xl relative">
                        <!-- Tabs -->
                        <div class="flex justify-center space-x-2 mb-4">
                            <button onclick="switchPortal('alumni')" id="tab-alumni" class="portal-tab active px-6 py-2 rounded-lg font-semibold text-sm transition-all duration-300 bg-blue-900 text-white shadow-md">
                                Portal Alumni
                            </button>
                            <button onclick="switchPortal('admin')" id="tab-admin" class="portal-tab px-6 py-2 rounded-lg font-semibold text-sm transition-all duration-300 bg-gray-200 text-gray-700 hover:bg-gray-300">
                                Dashboard Admin
                            </button>
                        </div>
                        
                        <!-- Browser Frame Container -->
                        <div class="browser-frame bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-200">
                            <!-- Browser Header -->
                            <div class="browser-header bg-gray-100 px-4 py-3 flex items-center space-x-2 border-b border-gray-300">
                                <div class="flex space-x-2">
                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                </div>
                                <div class="flex-1 ml-4">
                                    <div class="bg-white rounded px-3 py-1 text-xs text-gray-600 flex items-center">
                                        <svg class="w-3 h-3 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                        </svg>
                                        <span id="browser-url">portal-alumni/dashboard</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Browser Content -->
                            <div class="browser-content relative bg-gray-50">
                                <!-- Portal Alumni Screenshot -->
                                <div id="portal-alumni" class="portal-screen">
                                    <img src="/images/portal-alumni.png" alt="Portal Alumni Screenshot" class="w-full h-auto">
                                </div>
                                
                                <!-- Dashboard Admin Screenshot -->
                                <div id="portal-admin" class="portal-screen hidden">
                                    <img src="/images/portal-admin.png" alt="Dashboard Admin Screenshot" class="w-full h-auto">
                                </div>
                                
                                <!-- Badge -->
                                <div class="absolute top-4 right-4 bg-yellow-400 text-blue-900 px-3 py-1 rounded-full text-xs font-bold shadow-lg">
                                    ⭐ LIVE DEMO
                                </div>
                            </div>
                        </div>
                        
                        <!-- Decorative elements -->
                        <div class="absolute -top-4 -right-4 w-24 h-24 bg-blue-100 rounded-full opacity-30 -z-10"></div>
                        <div class="absolute -bottom-6 -left-6 w-32 h-32 bg-yellow-100 rounded-full opacity-30 -z-10"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission Statement -->
    <section id="about" class="py-20 bg-gradient-to-r from-blue-900 via-blue-800 to-blue-900 text-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-64 h-64 bg-white rounded-full -translate-x-1/2 -translate-y-1/2"></div>
            <div class="absolute bottom-0 right-0 w-96 h-96 bg-white rounded-full translate-x-1/2 translate-y-1/2"></div>
        </div>
        <div class="max-w-5xl mx-auto px-4 text-center relative z-10">
            <div class="inline-block mb-4">
                <svg class="w-16 h-16 mx-auto text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Misi Kami</h2>
            <p class="text-lg md:text-xl leading-relaxed text-blue-100 max-w-3xl mx-auto">
                Memberikan data komprehensif tentang keberhasilan alumni untuk <span class="text-yellow-300 font-semibold">meningkatkan kualitas pendidikan</span>, 
                menyempurnakan kurikulum, dan memastikan lulusan siap menghadapi tantangan dunia kerja.
            </p>
            <div class="grid md:grid-cols-3 gap-8 mt-12">
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">1</div>
                    <p class="text-blue-200">Evaluasi Kurikulum</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">2</div>
                    <p class="text-blue-200">Akreditasi Unggul</p>
                </div>
                <div class="text-center">
                    <div class="text-4xl font-bold text-yellow-400 mb-2">3</div>
                    <p class="text-blue-200">Perbaikan Berkelanjutan</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Timeline -->
    <section id="process" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-4xl font-bold text-gray-900 mb-3">Proses Tracer Study</h2>
                <p class="text-lg text-gray-600">Langkah mudah untuk berkontribusi pada pengembangan almamater</p>
            </div>
            
            <div class="grid md:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="process-card fade-in-up relative">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-blue-900 h-full">
                        <div class="absolute -top-4 left-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                1
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                <svg class="w-7 h-7 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Registrasi</h3>
                            <p class="text-gray-600 text-sm text-center">Daftar dengan email alumni yang terdaftar</p>
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="process-card fade-in-up relative" style="animation-delay: 0.1s;">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-yellow-400 h-full">
                        <div class="absolute -top-4 left-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                2
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="w-14 h-14 bg-yellow-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Verifikasi</h3>
                            <p class="text-gray-600 text-sm text-center">Lengkapi dan verifikasi data pribadi Anda</p>
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="process-card fade-in-up relative" style="animation-delay: 0.2s;">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-blue-900 h-full">
                        <div class="absolute -top-4 left-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                3
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                <svg class="w-7 h-7 text-blue-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Isi Kuesioner</h3>
                            <p class="text-gray-600 text-sm text-center">Jawab pertanyaan tentang pengalaman kerja</p>
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="process-card fade-in-up relative" style="animation-delay: 0.3s;">
                    <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-xl transition-all duration-300 border-t-4 border-green-500 h-full">
                        <div class="absolute -top-4 left-6">
                            <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 text-white rounded-full flex items-center justify-center font-bold text-lg shadow-lg">
                                ✓
                            </div>
                        </div>
                        <div class="mt-6">
                            <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center mb-4 mx-auto">
                                <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2 text-center">Selesai</h3>
                            <p class="text-gray-600 text-sm text-center">Data Anda membantu almamater berkembang</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA below process -->
            <div class="text-center mt-10">
                <a href="/alumni/register" class="inline-flex items-center bg-blue-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition shadow-lg">
                    Mulai Sekarang
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    <!-- Preview Kuesioner Section -->
    <section class="py-20 bg-gradient-to-br from-blue-50 to-white relative overflow-hidden">
        <!-- Background decoration -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-blue-100 rounded-full opacity-20 -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-yellow-100 rounded-full opacity-20 translate-y-1/2 -translate-x-1/2"></div>
        
        <div class="max-w-7xl mx-auto px-4 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left: Content -->
                <div class="fade-in-up">
                    <div class="inline-block bg-blue-100 text-blue-900 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                        👁️ Preview Interface
                    </div>
                    <h2 class="text-4xl font-bold text-gray-900 mb-6">
                        Lihat Tampilan <span class="text-blue-900">Kuesioner</span>
                    </h2>
                    <p class="text-lg text-gray-700 mb-6 leading-relaxed">
                        Interface yang user-friendly dan modern memudahkan Anda mengisi survei dengan cepat dan nyaman.
                    </p>
                    
                    <!-- Feature highlights -->
                    <div class="space-y-4 mb-8">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Progress Tracking Real-time</h4>
                                <p class="text-sm text-gray-600">Lihat progress pengisian dengan progress bar yang jelas</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Auto-save Otomatis</h4>
                                <p class="text-sm text-gray-600">Jawaban tersimpan otomatis, lanjutkan kapanpun</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Navigasi Mudah</h4>
                                <p class="text-sm text-gray-600">Tombol simpan draft dan review jawaban tersedia</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-6 h-6 bg-green-500 rounded-full flex items-center justify-center mt-1">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900">Multiple Question Types</h4>
                                <p class="text-sm text-gray-600">Radio, dropdown, text input dan lainnya</p>
                            </div>
                        </div>
                    </div>
                    
                    <a href="/alumni/register" class="inline-flex items-center bg-blue-900 text-white px-8 py-4 rounded-lg font-bold hover:bg-blue-800 transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Coba Sekarang
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Right: Browser Mockup -->
                <div class="fade-in-up" style="animation-delay: 0.2s;">
                    <!-- Browser Frame -->
                    <div class="browser-frame bg-white rounded-lg shadow-2xl overflow-hidden border border-gray-200">
                        <!-- Browser Header -->
                        <div class="browser-header bg-gray-100 px-4 py-3 flex items-center space-x-2 border-b border-gray-300">
                            <div class="flex space-x-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-yellow-500 rounded-full"></div>
                                <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            </div>
                            <div class="flex-1 ml-4">
                                <div class="bg-white rounded px-3 py-1 text-xs text-gray-600 flex items-center">
                                    <svg class="w-3 h-3 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span>portal-alumni/tracer-study</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Browser Content (Screenshot) -->
                        <div class="browser-content relative">
                            <img src="/images/quiz.png" alt="Tracer Study Questionnaire Interface" class="w-full h-auto">
                            
                            <!-- Floating badges on screenshot -->
                            <div class="absolute top-4 left-4 bg-blue-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg animate-pulse">
                                100% Progress
                            </div>
                            <div class="absolute top-4 right-4 bg-green-600 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Tersimpan
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Key Benefits for Alumni -->
    <section id="benefits" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Manfaat Berpartisipasi</h2>
                <p class="text-xl text-gray-600">Keuntungan yang Anda dapatkan dengan mengisi tracer study</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-lg p-8 shadow-md border-t-4 border-blue-900 benefit-card fade-in-up">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3 text-gray-900">Networking Alumni</h3>
                    <p class="text-gray-700 text-center">Terhubung dengan sesama alumni dan memperluas jaringan profesional.</p>
                </div>

                <div class="bg-white rounded-lg p-8 shadow-md border-t-4 border-yellow-400 benefit-card fade-in-up">
                    <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-yellow-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"/>
                            <path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3 text-gray-900">Info Karir</h3>
                    <p class="text-gray-700 text-center">Akses informasi lowongan kerja dan program pengembangan karir.</p>
                </div>

                <div class="bg-white rounded-lg p-8 shadow-md border-t-4 border-blue-900 benefit-card fade-in-up">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-8 h-8 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-center mb-3 text-gray-900">Berkontribusi</h3>
                    <p class="text-gray-700 text-center">Membantu almamater meningkatkan kualitas pendidikan generasi mendatang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-20 bg-white">
        <div class="max-w-6xl mx-auto px-4">
            <div class="text-center mb-16">
                <div class="inline-block bg-blue-100 text-blue-900 px-4 py-2 rounded-full text-sm font-semibold mb-4">
                    ⭐ Testimoni Alumni
                </div>
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Kata Mereka</h2>
                <p class="text-xl text-gray-600">Pengalaman alumni yang telah berkontribusi</p>
            </div>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="testimonial-card p-8 rounded-xl shadow-md">
                    <!-- Rating stars -->
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">"Proses pengisian survei sangat mudah dan membantu saya merefleksikan pengalaman pasca kelulusan. Senang bisa berkontribusi untuk almamater!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            A
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Ahmad Ridwan</div>
                            <div class="text-sm text-gray-600">Teknik Informatika 2018 • Software Engineer</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card p-8 rounded-xl shadow-md">
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">"Data yang dikumpulkan sangat komprehensif. Saya harap feedback saya bisa membantu meningkatkan kualitas program studi."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            S
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Siti Nurhaliza</div>
                            <div class="text-sm text-gray-600">Manajemen 2019 • Business Analyst</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card p-8 rounded-xl shadow-md">
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">"Sistem yang user-friendly dan bisa disimpan draft. Tidak perlu selesai dalam satu kali duduk, sangat fleksibel!"</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            B
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Budi Santoso</div>
                            <div class="text-sm text-gray-600">Akuntansi 2017 • Senior Auditor</div>
                        </div>
                    </div>
                </div>

                <div class="testimonial-card p-8 rounded-xl shadow-md">
                    <div class="flex mb-4">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <p class="text-gray-700 mb-6 leading-relaxed">"Pertanyaannya sangat relevan dengan kondisi dunia kerja saat ini. Terima kasih sudah memfasilitasi feedback dari alumni."</p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gradient-to-br from-blue-900 to-blue-700 rounded-full flex items-center justify-center text-white font-bold text-lg">
                            D
                        </div>
                        <div class="ml-4">
                            <div class="font-bold text-gray-900">Dewi Lestari</div>
                            <div class="text-sm text-gray-600">Psikologi 2020 • HR Specialist</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold text-gray-900 mb-4">Pertanyaan Umum</h2>
                <p class="text-xl text-gray-600">Jawaban untuk pertanyaan yang sering diajukan</p>
            </div>
            <div class="space-y-4">
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="faq-question w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Siapa yang wajib mengisi tracer study ini?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white">
                        <p class="text-gray-700">Semua alumni yang telah lulus dari institusi diharapkan mengisi tracer study untuk membantu evaluasi dan pengembangan program pendidikan.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="faq-question w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Berapa lama waktu yang dibutuhkan untuk mengisi survei?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white">
                        <p class="text-gray-700">Rata-rata waktu pengisian adalah 10-15 menit. Anda dapat menyimpan progress dan melanjutkan nanti jika diperlukan.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="faq-question w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Apakah data saya aman dan bersifat rahasia?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white">
                        <p class="text-gray-700">Ya, semua data yang Anda berikan akan dijaga kerahasiaannya dan hanya digunakan untuk keperluan evaluasi institusional. Data individual tidak akan dipublikasikan.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="faq-question w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Bagaimana jika saya lupa password?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white">
                        <p class="text-gray-700">Anda dapat menggunakan fitur "Lupa Password" di halaman login. Link reset password akan dikirimkan ke email yang terdaftar.</p>
                    </div>
                </div>

                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <button class="faq-question w-full text-left px-6 py-4 bg-gray-50 hover:bg-gray-100 transition flex justify-between items-center">
                        <span class="font-semibold text-gray-900">Apakah saya bisa mengubah jawaban setelah submit?</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div class="faq-answer hidden px-6 py-4 bg-white">
                        <p class="text-gray-700">Setelah survei di-submit, jawaban tidak dapat diubah. Pastikan untuk mereview jawaban Anda sebelum mengirimkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 academic-header text-white">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h2 class="text-4xl font-bold mb-6">Jadilah Bagian dari Perubahan</h2>
            <p class="text-xl text-blue-100 mb-8">
                Partisipasi Anda sangat berarti untuk pengembangan kualitas pendidikan di almamater
            </p>
            <div class="flex justify-center space-x-4">
                <a href="/alumni/register" class="bg-yellow-400 text-blue-900 px-10 py-4 rounded-lg font-bold hover:bg-yellow-300 transition shadow-lg text-lg">
                    Mulai Isi Survei
                </a>
                <a href="#about" class="border-2 border-white text-white px-10 py-4 rounded-lg font-bold hover:bg-blue-800 transition text-lg">
                    Pelajari Lebih Lanjut
                </a>
            </div>
        </div>
    </section>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/6287869588263?text=Halo,%20saya%20ingin%20bertanya%20tentang%20Tracer%20Study" 
       target="_blank" 
       id="wa-button"
       class="fixed bottom-24 right-8 bg-green-500 text-white p-4 rounded-full shadow-lg hover:bg-green-600 transition-all duration-300 z-50 group"
       aria-label="Hubungi via WhatsApp">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
        <!-- Tooltip -->
        <span class="absolute right-16 top-1/2 -translate-y-1/2 bg-gray-900 text-white px-3 py-2 rounded-lg text-sm whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none">
            Chat dengan Kami
        </span>
        <!-- Notification badge -->
        <span class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
    </a>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="fixed bottom-8 right-8 bg-blue-900 text-white p-4 rounded-full shadow-lg hover:bg-blue-800 transition hidden z-40" aria-label="Kembali ke atas">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
        </svg>
    </button>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Tracer Study</h3>
                    <p class="text-gray-400">Program pelacakan alumni untuk meningkatkan kualitas pendidikan tinggi di Indonesia.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Layanan</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Survei Alumni</a></li>
                        <li><a href="#" class="hover:text-white transition">Dashboard Institusi</a></li>
                        <li><a href="#" class="hover:text-white transition">Laporan Akreditasi</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Informasi</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="#" class="hover:text-white transition">Tentang Program</a></li>
                        <li><a href="#" class="hover:text-white transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition">Panduan</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li>Email: kodratcoc@gmail.com</li>
                        <li>Phone: +62 87 8695 8863</li>
                        <li>Jambi, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 Tracer Study Program. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => observer.observe(el));
        document.querySelectorAll('.process-card').forEach(el => observer.observe(el));

        // FAQ Toggle
        document.querySelectorAll('.faq-question').forEach(button => {
            button.addEventListener('click', function() {
                const answer = this.nextElementSibling;
                const icon = this.querySelector('svg');
                
                // Close all other FAQs
                document.querySelectorAll('.faq-answer').forEach(otherAnswer => {
                    if (otherAnswer !== answer) {
                        otherAnswer.classList.add('hidden');
                        otherAnswer.previousElementSibling.querySelector('svg').classList.remove('rotate-180');
                    }
                });
                
                // Toggle current FAQ
                answer.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.remove('hidden');
            } else {
                backToTopButton.classList.add('hidden');
            }
        });

        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '#about') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        const offsetTop = target.offsetTop - 80;
                        window.scrollTo({
                            top: offsetTop,
                            behavior: 'smooth'
                        });
                    }
                }
            });
        });

        // Portal screenshot switcher
        function switchPortal(type) {
            const alumniScreen = document.getElementById('portal-alumni');
            const adminScreen = document.getElementById('portal-admin');
            const alumniTab = document.getElementById('tab-alumni');
            const adminTab = document.getElementById('tab-admin');
            const browserUrl = document.getElementById('browser-url');
            
            if (type === 'alumni') {
                alumniScreen.classList.remove('hidden');
                adminScreen.classList.add('hidden');
                alumniTab.classList.add('active');
                adminTab.classList.remove('active');
                if (browserUrl) browserUrl.textContent = 'portal-alumni/dashboard';
            } else {
                alumniScreen.classList.add('hidden');
                adminScreen.classList.remove('hidden');
                alumniTab.classList.remove('active');
                adminTab.classList.add('active');
                if (browserUrl) browserUrl.textContent = 'admin/dashboard';
            }
        }

        // Auto-switch portal screenshots every 5 seconds
        let currentPortal = 'alumni';
        setInterval(() => {
            currentPortal = currentPortal === 'alumni' ? 'admin' : 'alumni';
            switchPortal(currentPortal);
        }, 5000);
    </script>

</body>
</html>
