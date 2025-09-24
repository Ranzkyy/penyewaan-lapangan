@extends('user.component.master')
@section('judul', 'Scan QR Code')
@section('konten')
    <div class="flex bg-[#F8DFD4]">
        @include('admin.component.sidebar')
        <div class="w-full">
            <h1 class="text-center w-full text-gray-600 font-extrabold text-4xl py-5">Scan QR Code</h1>

            @if(session('error'))
                <div class="mx-10 mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div class="mx-10 mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-center items-center min-h-[600px]">
                <div class="bg-white rounded-lg shadow-lg p-8 max-w-md w-full">
                    <div class="text-center">
                        <div class="mb-6">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V6a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1zm12 0h2a1 1 0 001-1V6a1 1 0 00-1-1h-2a1 1 0 00-1 1v1a1 1 0 001 1zM5 20h2a1 1 0 001-1v-1a1 1 0 00-1-1H5a1 1 0 00-1 1v1a1 1 0 001 1z"/>
                            </svg>
                        </div>
                        
                        <h2 class="text-2xl font-bold text-gray-800 mb-4">Scan QR Code / Kode Referal</h2>
                        <p class="text-gray-600 mb-6">Scan QR code atau masukkan kode referal dari user untuk mengkonfirmasi kedatangan</p>

                        <!-- Tab Navigation -->
                        <div class="flex border-b border-gray-200 mb-6">
                            <button type="button" id="qr-tab" class="flex-1 py-2 px-4 text-center border-b-2 border-blue-500 text-blue-600 font-medium" onclick="switchTab('qr')">
                                QR Code
                            </button>
                            <button type="button" id="referral-tab" class="flex-1 py-2 px-4 text-center border-b-2 border-transparent text-gray-500 font-medium" onclick="switchTab('referral')">
                                Kode Referal
                            </button>
                        </div>

                        <!-- QR Code Form -->
                        <form action="{{ route('admin_process_qr') }}" method="POST" id="qr-form" class="space-y-4">
                            @csrf
                            <div>
                                <label for="qr_data" class="block text-sm font-medium text-gray-700 mb-2">
                                    Masukkan Data QR Code (JSON)
                                </label>
                                <textarea 
                                    id="qr_data" 
                                    name="qr_data" 
                                    rows="4" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder='{"booking_id": 1, "user_id": 1, "lapangan_id": 1, "tanggal": "2024-07-30", "jam_mulai": "10:00", "jam_selesai": "12:00", "status": "aktif", "total": 100000, "timestamp": "2024-07-30T10:00:00Z"}'
                                ></textarea>
                            </div>
                            
                            <button type="submit" class="w-full bg-blue-500 text-white py-2 px-4 rounded-md hover:bg-blue-600 transition duration-300">
                                Proses QR Code
                            </button>
                        </form>

                        <!-- Referral Code Form -->
                        <form action="{{ route('admin_process_qr') }}" method="POST" id="referral-form" class="space-y-4 hidden">
                            @csrf
                            <div>
                                <label for="referral_code" class="block text-sm font-medium text-gray-700 mb-2">
                                    Masukkan Kode Referal
                                </label>
                                <input 
                                    type="text" 
                                    id="referral_code" 
                                    name="referral_code" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="Contoh: BK0001-A1B2"
                                >
                            </div>
                            
                            <button type="submit" class="w-full bg-green-500 text-white py-2 px-4 rounded-md hover:bg-green-600 transition duration-300">
                                Proses Kode Referal
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="my-6">
                            <div class="relative">
                                <div class="absolute inset-0 flex items-center">
                                    <div class="w-full border-t border-gray-300"></div>
                                </div>
                                <div class="relative flex justify-center text-sm">
                                    <span class="px-2 bg-white text-gray-500">Atau</span>
                                </div>
                            </div>
                        </div>

                        <!-- Instructions -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-800 mb-2">Cara Penggunaan:</h3>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Metode 1: QR Code</h4>
                                <ol class="text-sm text-gray-600 space-y-1 text-left">
                                    <li>1. Buka aplikasi kamera di HP</li>
                                    <li>2. Arahkan ke QR code yang ditunjukkan user</li>
                                    <li>3. Copy data JSON yang muncul</li>
                                    <li>4. Paste ke form QR Code di atas</li>
                                    <li>5. Klik "Proses QR Code"</li>
                                </ol>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Metode 2: Kode Referal</h4>
                                <ol class="text-sm text-gray-600 space-y-1 text-left">
                                    <li>1. Minta user menunjukkan kode referal</li>
                                    <li>2. Masukkan kode referal ke form di atas</li>
                                    <li>3. Klik "Proses Kode Referal"</li>
                                </ol>
                            </div>
                        </div>

                        <!-- Test Data -->
                        <div class="mt-6 p-4 bg-yellow-50 rounded-lg">
                            <h3 class="text-lg font-semibold text-yellow-800 mb-2">Data Test:</h3>
                            
                            <div class="mb-4">
                                <h4 class="text-sm font-semibold text-yellow-700 mb-2">QR Code Test:</h4>
                                <p class="text-sm text-yellow-700 mb-2">Untuk testing, gunakan data QR code ini:</p>
                                <div class="bg-white p-3 rounded border text-xs text-gray-600 font-mono">
                                    {"booking_id": 1, "user_id": 1, "lapangan_id": 1, "tanggal": "{{ date('Y-m-d') }}", "jam_mulai": "10:00", "jam_selesai": "12:00", "status": "aktif", "total": 100000, "timestamp": "{{ now()->toISOString() }}"}
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-semibold text-yellow-700 mb-2">Kode Referal Test:</h4>
                                <p class="text-sm text-yellow-700 mb-2">Untuk testing, gunakan kode referal ini:</p>
                                <div class="bg-white p-3 rounded border text-xs text-gray-600 font-mono">
                                    BK0001-A1B2
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Hide all forms
            document.getElementById('qr-form').classList.add('hidden');
            document.getElementById('referral-form').classList.add('hidden');
            
            // Remove active class from all tabs
            document.getElementById('qr-tab').classList.remove('border-blue-500', 'text-blue-600');
            document.getElementById('qr-tab').classList.add('border-transparent', 'text-gray-500');
            document.getElementById('referral-tab').classList.remove('border-blue-500', 'text-blue-600');
            document.getElementById('referral-tab').classList.add('border-transparent', 'text-gray-500');
            
            // Show selected form and activate tab
            if (tab === 'qr') {
                document.getElementById('qr-form').classList.remove('hidden');
                document.getElementById('qr-tab').classList.remove('border-transparent', 'text-gray-500');
                document.getElementById('qr-tab').classList.add('border-blue-500', 'text-blue-600');
            } else if (tab === 'referral') {
                document.getElementById('referral-form').classList.remove('hidden');
                document.getElementById('referral-tab').classList.remove('border-transparent', 'text-gray-500');
                document.getElementById('referral-tab').classList.add('border-blue-500', 'text-blue-600');
            }
        }
    </script>
@endsection 