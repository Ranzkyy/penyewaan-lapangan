@extends('user.component.master')
@section('judul', 'Login')
@section('konten')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#637E76] via-[#7E8D85] to-[#C69774] p-4">
    <div class="w-full max-w-5xl bg-white/90 backdrop-blur-md rounded-2xl shadow-2xl overflow-hidden grid grid-cols-1 lg:grid-cols-2">

        <!-- Left Column: Illustration / Welcome -->
        <div class="hidden lg:flex flex-col items-center justify-center bg-gradient-to-br from-[#637E76] to-[#4B6357] text-white p-10 space-y-6 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32 text-[#C69774] animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 16l-4-4m0 0l4-4m-4 4h14
                         m-5 4v1a3 3 0 01-3 3H6a3 3 0
                         01-3-3V7a3 3 0 013-3h7a3 3 0
                         013 3v1" />
            </svg>
            <h2 class="text-4xl font-bold drop-shadow">Selamat Datang Kembali</h2>
            <p class="text-sm opacity-80">Masuk untuk melanjutkan perjalanan Anda 🚀</p>
        </div>

        <!-- Right Column: Login Form -->
        <div class="p-10 flex flex-col justify-center space-y-6">
            <h1 class="text-center font-extrabold text-4xl text-[#637E76] tracking-wide">Login</h1>

            {{-- Error Message --}}
            @error('gagalpesan')
                <p class="text-red-600 text-sm text-center bg-red-100 p-2 rounded-lg">{{ $message }}</p>
            @enderror
            @error('login_gagal')
                <p class="text-red-600 text-sm text-center bg-red-100 p-2 rounded-lg">{{ $message }}</p>
            @enderror

            <form action="{{ route('proses_login') }}" method="POST" id="logForm" class="space-y-6">
                @csrf

                <!-- Username -->
                <div class="space-y-2">
                    <label for="username" class="block text-gray-700 text-sm font-semibold">Username</label>
                    <input
                        class="w-full px-4 py-3 rounded-lg border {{ $errors->has('username') ? 'border-red-500' : 'border-gray-300' }}
                               focus:outline-none focus:ring-2 focus:ring-[#C69774] focus:border-[#C69774]
                               transition duration-300 placeholder-gray-400 placeholder:italic placeholder:tracking-wide"
                        type="text" name="username" id="username"
                        placeholder="👤 Masukkan username Anda"
                        value="{{ old('username') }}"
                        required>
                    @error('username')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-2">
                    <label for="password" class="block text-gray-700 text-sm font-semibold">Password</label>
                    <input
                        class="w-full px-4 py-3 rounded-lg border {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}
                               focus:outline-none focus:ring-2 focus:ring-[#C69774] focus:border-[#C69774]
                               transition duration-300 placeholder-gray-400 placeholder:italic placeholder:tracking-wide"
                        type="password" name="password" id="password"
                        placeholder="🔑 Masukkan password Anda"
                        required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-[#C69774] to-[#637E76] text-white py-3 rounded-lg font-semibold shadow-md
                           hover:shadow-lg hover:scale-[1.03] transition-all duration-300 ease-in-out focus:outline-none focus:ring-2 focus:ring-[#C69774]">
                    Masuk
                </button>
            </form>

            <!-- Register Link -->
            <div class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-[#C69774] font-semibold hover:underline">Daftar Sekarang</a>
            </div>
        </div>
    </div>
</div>
@endsection
