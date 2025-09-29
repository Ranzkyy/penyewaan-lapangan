@extends('user.component.master')
@section('judul', 'Konfirmasi Booking')
@section('konten')
    <div class="flex">
        @include('admin.component.sidebar')
        <div class="w-full ml-64 bg-[#F8DFD4] min-h-screen">
            <h1 class="text-center w-full text-gray-600 font-extrabold text-4xl py-5">Konfirmasi Booking</h1>

            <div class="flex justify-center items-center min-h-[600px]">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-2xl w-full">
                    <div class="text-center mb-6">
                        <div class="mb-4">
                            <svg class="mx-auto h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Kode Referal Valid!</h2>
                        <p class="text-gray-600">Detail booking ditemukan. Silakan konfirmasi kedatangan user.</p>
                    </div>

                    <!-- Booking Information -->
                    <div class="bg-gray-50 rounded-lg p-6 mb-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Booking</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">ID Booking:</span>
                                    <span class="text-gray-800 font-semibold">#{{ $booking->id }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Nama User:</span>
                                    <span class="text-gray-800">{{ $user->name }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Email:</span>
                                    <span class="text-gray-800">{{ $user->email }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">No. WA:</span>
                                    <span class="text-gray-800">{{ $user->no_WA ?? 'Tidak ada' }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Lapangan:</span>
                                    <span class="text-gray-800">{{ $lapangan->urutan_222142 }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Kategori:</span>
                                    <span class="text-gray-800">{{ $kategori->name_222142 }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Tanggal:</span>
                                    <span class="text-gray-800">{{ $booking->tgl_booking_222142 }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Jam:</span>
                                    <span class="text-gray-800">{{ $booking->jam_mulai_222142 }} - {{ $booking->jam_selesai_222142 }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Total Harga:</span>
                                    <span class="text-gray-800 font-semibold">Rp {{ number_format($booking->total_222142, 0, ',', '.') }}</span>
                                </div>
                                
                                <div class="flex justify-between">
                                    <span class="text-gray-600 font-medium">Status:</span>
                                    <span class="px-2 py-1 rounded text-xs font-semibold text-white bg-green-600">
                                        {{ ucfirst($booking->status_222142) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Time Validation -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-green-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-green-800 font-medium">Waktu Booking Valid</span>
                        </div>
                        <p class="text-green-700 text-sm mt-1">
                            Waktu saat ini: <strong>{{ \Carbon\Carbon::now('Asia/Jakarta')->format('d/m/Y H:i') }}</strong><br>
                            Rentang booking: <strong>{{ $booking->jam_mulai_222142 }} - {{ $booking->jam_selesai_222142 }}</strong><br>
                            <span class="text-xs">✓ Kode referal dapat diproses dalam rentang waktu booking</span>
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-center space-x-4">
                        <form action="{{ route('admin_confirm_booking', $booking->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="bg-green-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-green-600 transition duration-300 flex items-center">
                                <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Konfirmasi Kedatangan
                            </button>
                        </form>
                        
                        <a href="{{ route('admin_scan_referral') }}" class="bg-gray-500 text-white px-8 py-3 rounded-lg font-semibold hover:bg-gray-600 transition duration-300 flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Batal
                        </a>
                    </div>

                    <!-- Confirmation Message -->
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-yellow-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                            </svg>
                            <span class="text-yellow-800 font-medium">Peringatan</span>
                        </div>
                        <p class="text-yellow-700 text-sm mt-1">
                            Setelah dikonfirmasi, status booking akan berubah dari "aktif" menjadi "berjalan". 
                            User dapat mulai menggunakan lapangan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 