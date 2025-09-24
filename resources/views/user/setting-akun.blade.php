@extends('user.component.master')
@section('judul', 'Setting Akun')
@section('konten')

@include('user.component.navbar')

<div class="bg-[#F8DFD4] w-full min-h-screen py-10">
    <h1 class="text-center font-bold text-4xl text-gray-600">Setting Akun</h1>

    <div class="max-w-xl mx-auto mt-8 bg-white p-6 rounded-lg shadow-lg">
        @if(session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tampilkan hitung mundur jika masih dalam waktu pembatasan -->
        @if($remainingTime > 0)
            <div id="countdown-container" class="bg-gray-500 text-white p-4 rounded-lg mb-4 text-center">
                Anda hanya dapat memperbarui akun kembali dalam <span id="countdown-timer"></span>.
            </div>
        @endif

        <form action="{{ route('updateAkun') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold">Nama</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                    class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <div class="mb-4">
                <label for="username" class="block text-gray-700 font-semibold">Username</label>
                <input type="text" id="username" name="username" value="{{ old('username', $user->username) }}" required
                    class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                    class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <div class="mb-4">
                <label for="no_WA" class="block text-gray-700 font-semibold">Nomor WA</label>
                <input type="text" id="no_WA" name="no_WA" value="{{ old('no_WA', $user->no_WA) }}"
                    class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold">Password (Opsional)</label>
                <input type="password" id="password" name="password" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-semibold">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="w-full mt-2 p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#a37a5b]"
                    {{ $remainingTime > 0 ? 'disabled' : '' }}>
            </div>

            <button type="submit"
                class="w-full bg-[#C69774] text-white py-3 rounded-lg hover:bg-[#a37a5b] transition-transform transform hover:scale-105"
                {{ $remainingTime > 0 ? 'disabled' : '' }}>
                Simpan Perubahan
            </button>
        </form>
    </div>
</div>

@include('user.component.footer')

@if($remainingTime > 0)
    <script>
        // Hitung mundur dalam milidetik
        let remainingTime = {{ $remainingTime }};

        // Fungsi untuk format waktu
        function formatTime(milliseconds) {
            const seconds = Math.floor(milliseconds / 1000);
            const minutes = Math.floor(seconds / 60);
            const secs = seconds % 60;
            return `${minutes} menit ${secs} detik`;
        }

        // Update hitung mundur setiap detik
        const timerElement = document.getElementById('countdown-timer');
        const countdownContainer = document.getElementById('countdown-container');

        function updateCountdown() {
            if (remainingTime > 0) {
                timerElement.textContent = formatTime(remainingTime);
                remainingTime -= 1000; // Kurangi setiap detik
            } else {
                countdownContainer.textContent = "Anda sekarang dapat memperbarui akun!";
                document.querySelectorAll('input, button').forEach(el => el.disabled = false); // Aktifkan kembali form
            }
        }
        // Jalankan hitung mundur
        updateCountdown(); // Update pertama kali
        setInterval(updateCountdown, 1000); // Update setiap 1 detik
    </script>
@endif
@endsection
