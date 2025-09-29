@extends('user.component.master')
@section('judul')
@endsection
@section('konten')
<div class="flex">
    @include('admin.component.sidebar')

    <!-- Kontainer Utama -->
    <div class="w-full md:ml-64 bg-gradient-to-br from-[#F8DFD4] via-white to-[#fefefe] min-h-screen pt-16 md:pt-0">

        <!-- Header -->
        <div class="grid place-items-center text-center mb-16 px-6">
            <img src="{{ asset('images/badminton_logo_-_Dibuat_dengan_PosterMyWall__1_-removebg-preview.png') }}"
                 alt="Logo"
                 class="w-40 h-40 md:w-64 md:h-64 drop-shadow-lg transition-transform hover:scale-105 duration-300">
            <h1 class="font-semibold text-gray-700 text-base md:text-lg leading-relaxed mt-4 max-w-xl">
                Kamu <span class="font-bold text-[#C69774]">Admin</span> yang bekerja dengan fokus dan baik.
                Senangnya pelanggan semua berkat kamu..!!
            </h1>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 px-6 pb-12">

            <!-- Card Pengguna -->
            <div class="bg-gradient-to-tr from-[#C69774] to-[#a67855] rounded-2xl p-6 shadow-xl hover:shadow-2xl
                        transform hover:scale-105 transition duration-300 flex flex-col items-center">
                <h1 class="text-white font-semibold text-lg md:text-xl">Pengguna</h1>
                <h1 class="text-white text-3xl md:text-4xl font-extrabold mt-2">{{$pengguna}}</h1>
            </div>

            <!-- Card Lapangan -->
            <div class="bg-gradient-to-tr from-[#C69774] to-[#a67855] rounded-2xl p-6 shadow-xl hover:shadow-2xl
                        transform hover:scale-105 transition duration-300 flex flex-col items-center">
                <h1 class="text-white font-semibold text-lg md:text-xl">Lapangan</h1>
                <h1 class="text-white text-3xl md:text-4xl font-extrabold mt-2">{{$lapangan}}</h1>
            </div>

            <!-- Card Pesanan -->
            <div class="bg-gradient-to-tr from-[#C69774] to-[#a67855] rounded-2xl p-6 shadow-xl hover:shadow-2xl
                        transform hover:scale-105 transition duration-300 flex flex-col items-center">
                <h1 class="text-white font-semibold text-lg md:text-xl">Pesanan</h1>
                <h1 class="text-white text-3xl md:text-4xl font-extrabold mt-2">{{$pesan}}</h1>
            </div>

            <!-- Card Konfirmasi -->
            <div class="bg-gradient-to-tr from-[#C69774] to-[#a67855] rounded-2xl p-6 shadow-xl hover:shadow-2xl
                        transform hover:scale-105 transition duration-300 flex flex-col items-center">
                <h1 class="text-white font-semibold text-lg md:text-xl">Konfirmasi</h1>
                <h1 class="text-white text-3xl md:text-4xl font-extrabold mt-2">{{$konfir}}</h1>
            </div>

        </div>
    </div>
</div>
@endsection
