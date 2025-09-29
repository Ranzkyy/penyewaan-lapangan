@extends('user.component.master')
@section('judul', 'Kontak')
@section('konten')

@include('user.component.navbar')

<div class="w-full bg-gradient-to-br from-[#fef6f0] via-[#fbe4d8] to-[#f8c4a5] min-h-screen pt-24 px-6">
    <!-- Judul -->
    <div class="text-center">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-[#ff7b54] to-[#ffb26b] bg-clip-text text-transparent drop-shadow-lg">
            Kontak Kami
        </h1>
        <p class="text-gray-600 mt-4 text-lg">Hubungi kami melalui platform favoritmu 👇</p>
    </div>

    <!-- Card Kontak -->
    <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
        <!-- WhatsApp -->
        <div class="group relative bg-white/70 backdrop-blur-xl rounded-2xl p-6 flex flex-col items-center shadow-lg hover:shadow-2xl transition duration-300 border border-white/20">
            <a href="https://wa.me/6282236234227?text=Assalamualaikum%20Kak,%20saya%20ingin%20tahu%20lebih%20detail%20tentang%20lapangan%20badminton%20FH%20Smash%20Mari%20Sama-sama."
               target="_blank" rel="noopener noreferrer"
               class="flex flex-col items-center">
                <img src="{{ asset('images/wa.png') }}" alt="WhatsApp"
                     class="w-16 h-16 group-hover:scale-110 transition-transform duration-300">
                <h1 class="mt-4 text-xl font-semibold text-gray-700 group-hover:text-[#25D366] transition">
                    0822-3623-4227
                </h1>
            </a>
        </div>

        <!-- Gmail -->
        <div class="group relative bg-white/70 backdrop-blur-xl rounded-2xl p-6 flex flex-col items-center shadow-lg hover:shadow-2xl transition duration-300 border border-white/20">
            <a href="mailto:fikri.haikal17062004@gmail.com" class="flex flex-col items-center">
                <img src="{{ asset('images/gmail.png') }}" alt="Gmail"
                     class="w-16 h-16 group-hover:scale-110 transition-transform duration-300">
                <h1 class="mt-4 text-xl font-semibold text-gray-700 group-hover:text-[#EA4335] transition">
                    fikri.haikal17062004@gmail.com
                </h1>
            </a>
        </div>

        <!-- Instagram -->
        <div class="group relative bg-white/70 backdrop-blur-xl rounded-2xl p-6 flex flex-col items-center shadow-lg hover:shadow-2xl transition duration-300 border border-white/20">
            <a href="https://www.instagram.com/fikrihaikal.17" class="flex flex-col items-center">
                <img src="{{ asset('images/instagram.png') }}" alt="Instagram"
                     class="w-16 h-16 group-hover:scale-110 transition-transform duration-300">
                <h1 class="mt-4 text-xl font-semibold text-gray-700 group-hover:text-[#E1306C] transition">
                    @fikrihaikal.17
                </h1>
            </a>
        </div>
    </div>
</div>

@include('user.component.footer')
@endsection
