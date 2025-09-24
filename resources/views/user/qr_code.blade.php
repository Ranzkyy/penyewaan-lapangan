@extends('user.component.master')
@section('judul', 'QR Code Booking')
@section('konten')
    @include('user.component.navbar')

    <div class="bg-[#F8DFD4] w-full p-6 space-y-8 min-h-[600px]">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg p-8">
            <h1 class="text-center text-2xl font-bold text-gray-700 mb-6">QR Code Booking</h1>

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ session('error') }}
                </div>
            @endif
            
            <div class="text-center space-y-4">
                <div class="bg-gray-100 p-4 rounded-lg">
                    <h2 class="text-lg font-semibold text-gray-800 mb-2">Informasi Booking</h2>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p><strong>ID Booking:</strong> {{ $booking->id }}</p>
                        <p><strong>Lapangan:</strong> {{ $lapangan->urutan_222142 ?? 'N/A' }}</p>
                        <p><strong>Kategori:</strong> {{ $kategori->name_222142 ?? 'N/A' }}</p>
                        <p><strong>Tanggal:</strong> {{ $booking->tgl_booking_222142 }}</p>
                        <p><strong>Jam:</strong> {{ $booking->jam_mulai_222142 }} - {{ $booking->jam_selesai_222142 }}</p>
                        <p><strong>Total Harga:</strong> Rp {{ number_format($booking->total_222142, 0, ',', '.') }}</p>
                        <p><strong>Status:</strong> 
                            <span class="px-2 py-1 rounded text-xs font-semibold text-white bg-green-600">
                                {{ ucfirst($booking->status_222142) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($booking->qr_code_222142)
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">QR Code</h3>
                        <div class="flex justify-center">
                            @if(str_ends_with($booking->qr_code_222142, '.svg'))
                                <div class="w-64 h-64 border border-gray-300 rounded-lg bg-white flex items-center justify-center">
                                    {!! file_get_contents(public_path('images/' . $booking->qr_code_222142)) !!}
                                </div>
                            @else
                                <img src="{{ asset('images/' . $booking->qr_code_222142) }}" 
                                     alt="QR Code Booking" 
                                     class="w-64 h-64 border border-gray-300 rounded-lg">
                            @endif
                        </div>
                        <p class="text-xs text-gray-500 mt-2">
                            Tunjukkan QR Code ini kepada petugas untuk verifikasi
                        </p>
                        <p class="text-xs text-gray-400 mt-1">
                            Dibuat pada: {{ $booking->updated_at->format('d/m/Y H:i') }}
                        </p>

                        <!-- Referral Code -->
                        @if($booking->referral_code_222142)
                            <div class="mt-4 p-3 bg-gray-100 rounded-lg">
                                <h4 class="text-sm font-semibold text-gray-800 mb-2">Kode Referal:</h4>
                                <div class="bg-white p-3 rounded border-2 border-dashed border-gray-300">
                                    <p class="text-lg font-bold text-center text-gray-800 tracking-wider">
                                        {{ $booking->referral_code_222142 }}
                                    </p>
                                </div>
                                <p class="text-xs text-gray-500 mt-2 text-center">
                                    Tunjukkan kode ini kepada admin sebagai alternatif QR code
                                </p>
                            </div>
                        @endif
                        <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                            <h4 class="text-sm font-semibold text-blue-800 mb-2">Cara Penggunaan:</h4>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li>• Tunjukkan QR Code ini kepada petugas</li>
                                <li>• Atau berikan kode referal di atas kepada petugas</li>
                                <li>• Petugas akan memindai QR Code atau input kode referal</li>
                                <li>• Setelah diverifikasi, Anda dapat menggunakan lapangan</li>
                                <li>• Simpan QR Code dan kode referal dengan aman</li>
                            </ul>
                        </div>
                    </div>
                @else
                    <div class="bg-yellow-100 p-4 rounded-lg border border-yellow-300">
                        <p class="text-yellow-800">QR Code belum tersedia</p>
                    </div>
                @endif

                {{-- Foto Lapangan --}}
                @if($kategori && $kategori->foto_222142)
                    <div class="bg-white p-4 rounded-lg border-2 border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Foto Lapangan</h3>
                        <div class="flex justify-center">
                            <img src="{{ asset('images/' . $kategori->foto_222142) }}" 
                                 alt="Foto Lapangan" 
                                 class="w-48 h-32 object-cover border border-gray-300 rounded-lg">
                        </div>
                    </div>
                @endif

                <div class="mt-6">
                    <a href="{{ route('riwayat') }}" 
                       class="bg-[#C69774] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#637E76] transition duration-300">
                        Kembali ke Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('user.component.footer')
@endsection 