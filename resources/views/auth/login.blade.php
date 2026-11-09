<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - StudentArchive</title>
    
    <!-- FAVICON BARU (SVG) -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%232563EB'%3E%3Crect width='24' height='24' rx='6' fill='%232563EB'/%3E%3Cpath d='M6 8h12v2H6V8zm0 3h12v7a1 1 0 01-1 1H7a1 1 0 01-1-1v-7zm3 3h6v2H9v-2z' fill='white'/%3E%3C/svg%3E">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<!-- ... sisa kode login ... -->
<body class="bg-[#f8f9fa] flex items-center justify-center min-h-screen p-4 text-gray-800">

    <div class="bg-white rounded-[1.5rem] shadow-[0_0_40px_rgba(0,0,0,0.05)] flex flex-col md:flex-row w-full max-w-4xl overflow-hidden min-h-[600px] border border-gray-100">
        
        <!-- Sisi Kiri (Biru Gelap) -->
        <div class="bg-[#11223F] md:w-5/12 p-12 flex flex-col justify-between text-white relative">
            <div>
                <div class="flex items-center space-x-4 mb-14">
                    <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <span class="text-2xl font-bold tracking-wide">StudentArchive</span>
                </div>

                <h1 class="text-[2.5rem] font-bold leading-[1.1] mb-6">
                    Dokumenmu.<br>
                    Tertata.<br>
                    <span class="text-[#60A5FA]">Siap kapan saja.</span>
                </h1>
                <p class="text-[15px] text-gray-300 leading-relaxed pr-4">
                    Portal manajemen dokumen akademik dan arsip kelulusan siswa.
                </p>
            </div>

            <div>
                <div class="space-y-3 mb-10">
                    <div class="h-2 w-full bg-white/10 rounded-full"></div>
                    <div class="h-2 w-2/3 bg-white/10 rounded-full"></div>
                </div>
                <p class="text-[13px] text-gray-400 font-medium">SMK Negeri 5 Surakarta • RPL</p>
            </div>
        </div>

        <!-- Sisi Kanan (Form Login) -->
        <div class="md:w-7/12 p-12 md:p-16 flex flex-col justify-center bg-white">
            
            <div class="mb-10">
                <h2 class="text-[2rem] font-bold text-gray-900 mb-2 flex items-center gap-2">Selamat datang <span class="text-3xl">👋</span></h2>
                <p class="text-[15px] text-gray-500">Masuk untuk mengakses StudentArchive</p>
            </div>

            <!-- Alert Error -->
            @if($errors->any())
                <div class="bg-red-50 text-red-600 p-3 rounded-lg mb-6 text-sm border border-red-100">
                    {{ $errors->first() }}
                </div>
            @endif

            <!-- Toggle Role -->
            <div class="mb-6">
                <label class="block text-[11px] font-bold text-gray-500 tracking-wider mb-3 uppercase">Role</label>
                <div class="flex gap-3 w-max">
                    <button type="button" id="btn-staff" onclick="setRole('staff')" class="px-6 py-2.5 rounded-lg text-[14px] font-bold bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE] transition-all shadow-sm">Admin / Guru</button>
                    <button type="button" id="btn-siswa" onclick="setRole('siswa')" class="px-6 py-2.5 rounded-lg text-[14px] font-bold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-all">Siswa</button>
                </div>
            </div>

            <form method="POST" action="/login" id="login-form">
                @csrf
                <input type="hidden" name="login_type" id="login_type" value="staff">

                <!-- Form Staff (Admin/Guru) - Pakai NIP -->
                <div id="form-staff">
                    <div class="mb-5">
                        <label class="block text-[11px] font-bold text-gray-500 tracking-wider mb-2 uppercase">NIP</label>
                        <!-- Placeholder diubah agar sesuai format tanpa spasi -->
                        <input type="text" name="nip" class="w-full border border-gray-300 rounded-xl px-4 py-3.5 text-[15px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition placeholder-gray-400" placeholder="Contoh: 198001012005011001">
                    </div>
                    <div class="mb-8">
                        <label class="block text-[11px] font-bold text-gray-500 tracking-wider mb-2 uppercase">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password-staff" class="w-full border border-gray-300 rounded-xl px-4 py-3.5 text-[15px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition pr-12 placeholder-gray-400" placeholder="••••••••••••">
                            <button type="button" onclick="togglePassword('password-staff')" class="absolute right-4 top-3.5 text-gray-400 hover:text-gray-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Form Siswa - Pakai NIS & Tgl Lahir -->
                <div id="form-siswa" class="hidden">
                    <div class="mb-5">
                        <label class="block text-[11px] font-bold text-gray-500 tracking-wider mb-2 uppercase">NIS</label>
                        <input type="text" name="nis" class="w-full border border-gray-300 rounded-xl px-4 py-3.5 text-[15px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition placeholder-gray-400" placeholder="Masukkan NIS">
                    </div>
                    <div class="mb-8">
                        <label class="block text-[11px] font-bold text-gray-500 tracking-wider mb-2 uppercase">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full border border-gray-300 rounded-xl px-4 py-3.5 text-[15px] focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition text-gray-700">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#2563EB] hover:bg-blue-800 text-white font-bold text-[15px] py-4 rounded-xl transition duration-200 shadow-md">
                    MASUK
                </button>
            </form>

        </div>
    </div>

    <script>
        function setRole(role) {
            document.getElementById('login_type').value = role;
            const btnStaff = document.getElementById('btn-staff');
            const btnSiswa = document.getElementById('btn-siswa');
            const formStaff = document.getElementById('form-staff');
            const formSiswa = document.getElementById('form-siswa');

            if (role === 'staff') {
                btnStaff.className = "px-6 py-2.5 rounded-lg text-[14px] font-bold bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE] transition-all shadow-sm";
                btnSiswa.className = "px-6 py-2.5 rounded-lg text-[14px] font-bold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-all";
                formStaff.classList.remove('hidden');
                formSiswa.classList.add('hidden');
            } else {
                btnSiswa.className = "px-6 py-2.5 rounded-lg text-[14px] font-bold bg-[#EFF6FF] text-[#2563EB] border border-[#BFDBFE] transition-all shadow-sm";
                btnStaff.className = "px-6 py-2.5 rounded-lg text-[14px] font-bold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition-all";
                formSiswa.classList.remove('hidden');
                formStaff.classList.add('hidden');
            }
        }

        function togglePassword(id) {
            const input = document.getElementById(id);
            input.type = input.type === "password" ? "text" : "password";
        }
    </script>
</body>
</html>