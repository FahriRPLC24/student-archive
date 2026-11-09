<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentArchive - Portal Manajemen Dokumen</title>

    <!-- FAVICON BARU (SVG) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563EB'%3E%3Crect width='24' height='24' rx='6' fill='%232563EB'/%3E%3Cpath d='M6 8h12v2H6V8zm0 3h12v7a1 1 0 01-1 1H7a1 1 0 01-1-1v-7zm3 3h6v2H9v-2z' fill='white'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; scroll-behavior: smooth; } </style>
</head>
<!-- ... sisa kode landing page ... -->
<body class="bg-gray-50 text-gray-800 overflow-x-hidden">

    <!-- NAVBAR LANDING (Warna Navy) -->
    <nav class="fixed w-full top-0 z-50 bg-[#11223F] shadow-lg">
        <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-white/10 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <span class="text-xl font-bold text-white">StudentArchive</span>
            </div>
            <div class="hidden md:flex gap-8 text-sm font-semibold text-gray-300">
                <a href="#pengenalan" class="hover:text-white transition">Pengenalan</a>
                <a href="#fitur" class="hover:text-white transition">Fitur</a>
                <a href="#peran" class="hover:text-white transition">Peran Pengguna</a>
            </div>
            <a href="{{ route('login') }}" class="bg-[#2563EB] hover:bg-blue-600 text-white text-sm font-bold px-6 py-2.5 rounded-lg transition shadow-lg shadow-blue-500/30">
                Masuk Sistem
            </a>
        </div>
    </nav>

    <!-- WRAPPER UTAMA (Jarak atas diperlebar) -->
    <div class="pt-36 md:pt-40 pb-16 px-4 md:px-6 max-w-7xl mx-auto space-y-6 md:space-y-8">

        <!-- SECTION 1: PENGENALAN (HERO) - Dibungkus Card -->
        <section id="pengenalan" class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-gray-100 relative overflow-hidden">
            <!-- Ornamen Background -->
            <div class="absolute top-0 right-0 w-[400px] h-[400px] bg-blue-50 rounded-full blur-3xl -mr-20 -mt-20 opacity-60"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row items-center gap-10 md:gap-16">
                <div class="md:w-1/2 text-center md:text-left">
                    <span class="inline-block py-1 px-3 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-6">SISTEM INFORMASI AKADEMIK</span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-[#11223F] leading-tight mb-6">
                        Dokumenmu.<br>Tertata.<br><span class="text-[#2563EB]">Siap Kapan Saja.</span>
                    </h1>
                    <p class="text-gray-500 text-base md:text-lg mb-8 max-w-lg mx-auto md:mx-0">
                        StudentArchive adalah portal manajemen dokumen akademik dan arsip kelulusan siswa. Simpan, kelola, dan pantau seluruh berkas pentingmu dalam satu genggaman.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="{{ route('login') }}" class="bg-[#2563EB] hover:bg-blue-800 text-white font-bold px-8 py-3.5 rounded-xl shadow-lg shadow-blue-500/30 transition text-base">
                            Mulai Sekarang
                        </a>
                        <a href="#fitur" class="bg-white border border-gray-300 text-gray-700 font-bold px-8 py-3.5 rounded-xl hover:bg-gray-50 transition text-base flex items-center justify-center gap-2">
                            Pelajari Fitur
                        </a>
                    </div>
                </div>
                
                <div class="md:w-1/2 relative w-full mt-10 md:mt-0">
                    <!-- Mockup Ilustrasi -->
                    <div class="bg-[#11223F] rounded-2xl p-5 shadow-2xl relative z-10 border border-white/10">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="w-3 h-3 rounded-full bg-red-500"></div>
                            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                            <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 mb-4 border border-white/10">
                            <div class="w-1/3 h-2 bg-white/20 rounded mb-2"></div>
                            <div class="w-2/3 h-2 bg-white/20 rounded"></div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 mb-4 border border-white/10">
                            <div class="w-1/4 h-2 bg-green-400/50 rounded mb-2"></div>
                            <div class="w-3/4 h-2 bg-white/20 rounded"></div>
                        </div>
                        <div class="bg-white/5 rounded-xl p-4 border border-white/10">
                            <div class="w-1/2 h-2 bg-blue-400/50 rounded mb-2"></div>
                            <div class="w-1/2 h-2 bg-white/20 rounded"></div>
                        </div>
                    </div>
                    <div class="absolute -bottom-6 -right-6 w-32 h-32 bg-[#2563EB] rounded-2xl z-0 opacity-10"></div>
                </div>
            </div>
        </section>

        <!-- SECTION 2: FITUR - Dibungkus Card -->
        <section id="fitur" class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-gray-100">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#11223F] mb-4">Fitur Unggulan</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Dirancang untuk mempermudah pengelolaan administrasi sekolah dengan teknologi modern.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Fitur 1 -->
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Filing Digital</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Simpan seluruh dokumen akademik seperti Ijazah, Rapor, dan Sertifikat dalam satu repositori terpusat yang aman.</p>
                </div>

                <!-- Fitur 2 -->
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Verifikasi Berkas</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Alur verifikasi berjenjang. Guru mengunggah, Kurikulum memverifikasi, dan Siswa mendapatkan notifikasi secara real-time.</p>
                </div>

                <!-- Fitur 3 -->
                <div class="bg-gray-50 p-6 md:p-8 rounded-2xl border border-gray-100 hover:shadow-md transition duration-300">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Upload Kolektif</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Efisiensi waktu dengan fitur unggah massal. Unggah satu file ZIP, dan sistem akan mendistribusikan dokumen secara otomatis.</p>
                </div>
            </div>
        </section>

        <!-- SECTION 3: PERAN PENGGUNA - Dibungkus Card -->
        <section id="peran" class="bg-white rounded-[2rem] p-8 md:p-12 shadow-sm border border-gray-100">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-extrabold text-[#11223F] mb-4">Satu Sistem, Tiga Peran</h2>
                <p class="text-gray-500 max-w-2xl mx-auto">Akses yang terisolasi dan aman sesuai dengan kebutuhan pengguna.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8">
                <!-- Kurikulum -->
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-200 text-center">
                    <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kurikulum</h3>
                    <p class="text-sm text-gray-500">Verifikasi berkas, kelola data master (Guru/Siswa), dan pantau rekapitulasi kelengkapan seluruh sekolah.</p>
                </div>

                <!-- Guru -->
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-200 text-center md:transform md:-translate-y-2 shadow-md border-t-4 border-t-[#2563EB]">
                    <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Guru / Wali Kelas</h3>
                    <p class="text-sm text-gray-500">Mengunggah dan mengelola dokumen akademik siswa di kelas yang diampu, serta memantau progres siswa.</p>
                </div>

                <!-- Siswa -->
                <div class="bg-gray-50 rounded-2xl p-6 md:p-8 border border-gray-200 text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-5">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Siswa</h3>
                    <p class="text-sm text-gray-500">Memantau secara real-time status kelengkapan dokumen pribadi, melihat isi berkas, dan mengunduh salinan digital.</p>
                </div>
            </div>
        </section>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#11223F] text-white py-10 mt-8">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-white/10 rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                </div>
                <span class="text-lg font-bold">StudentArchive</span>
            </div>
            <p class="text-gray-400 text-xs md:text-sm text-center">&copy; 2026 SMK Negeri 5 Surakarta. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>