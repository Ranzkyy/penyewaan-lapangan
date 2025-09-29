@extends('user.component.master')
@section('judul', 'Scan Kode Referal')
@section('konten')
    <div class="flex">
        @include('admin.component.sidebar')
        <div class="w-full ml-64 bg-[#F8DFD4] min-h-screen">
            <h1 class="text-center w-full text-gray-600 font-extrabold text-4xl py-5">Scan Kode Referal</h1>

            <div class="flex justify-center items-center min-h-[600px]">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
                    <div class="text-center mb-6">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Input Kode Referal</h2>
                        <p class="text-gray-600">Masukkan kode referal dari user untuk konfirmasi kedatangan.</p>
                    </div>

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('admin_process_referral') }}" method="POST">
                        @csrf
                        <div class="mb-6">
                            <label for="referral_code" class="block text-sm font-medium text-gray-700 mb-2">
                                Kode Referal
                            </label>
                            <input type="text" 
                                   id="referral_code" 
                                   name="referral_code" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center text-lg font-mono tracking-wider"
                                   placeholder="BK0001-XXXX"
                                   required
                                   autocomplete="off">
                            <p class="text-xs text-gray-500 mt-2">
                                Format: BK + 4 digit nomor booking + 4 karakter unik
                            </p>
                        </div>

                        <div class="flex justify-center space-x-4">
                            <button type="submit" class="bg-blue-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-600 transition duration-300 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari Booking
                            </button>
                            
                            <a href="{{ route('admin') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 transition duration-300 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Batal
                            </a>
                        </div>
                    </form>

                    <!-- Information -->
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-blue-800 font-medium">Informasi</span>
                        </div>
                        <p class="text-blue-700 text-sm mt-1">
                            Kode referal akan muncul di halaman riwayat user setelah admin mengkonfirmasi pembayaran.
                            Pastikan user sudah datang sesuai waktu booking yang telah ditentukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
