@extends('user.component.master')
@section('judul', 'Data Pengguna')
@section('konten')
    <div class="flex">
        @include('admin.component.sidebar')

        <!-- Kontainer Utama -->
        <div class="w-full md:ml-64 bg-gradient-to-br from-[#F8DFD4] via-white to-[#fefefe] min-h-screen p-6">
            <!-- Judul -->
            <h1 class="text-center text-gray-700 font-extrabold text-3xl md:text-4xl py-6 tracking-wide">
                Operasional
            </h1>

            <!-- Card Jam Buka & Tutup -->
            <div class="flex flex-col md:flex-row justify-center items-center gap-6 md:gap-12 mb-10">

                <!-- Card Jam Buka -->
                <div class="bg-gradient-to-tr from-orange-400 to-orange-500 rounded-2xl shadow-xl
                            hover:shadow-2xl transform hover:scale-105 transition duration-300
                            w-64 md:w-72 h-36 flex flex-col justify-center items-center text-white">
                    <h1 class="font-semibold text-lg md:text-xl">Jam Buka</h1>
                    <h1 class="font-extrabold text-2xl md:text-3xl mt-2">
                        {{ $operasional->jam_buka_222142 }}
                    </h1>
                </div>

                <!-- Card Jam Tutup -->
                <div class="bg-gradient-to-tr from-orange-400 to-orange-500 rounded-2xl shadow-xl
                            hover:shadow-2xl transform hover:scale-105 transition duration-300
                            w-64 md:w-72 h-36 flex flex-col justify-center items-center text-white">
                    <h1 class="font-semibold text-lg md:text-xl">Jam Tutup</h1>
                    <h1 class="font-extrabold text-2xl md:text-3xl mt-2">
                        {{ $operasional->jam_tutup_222142 }}
                    </h1>
                </div>
            </div>

            <!-- Tombol Edit -->
            <div class="flex justify-center">
                <a href="{{ route('proses_editoperasional', $operasional->id) }}"
                   class="bg-gradient-to-r from-green-400 to-green-500 hover:from-green-500 hover:to-green-600
                          text-white font-bold text-lg md:text-xl text-center py-3 px-6
                          rounded-xl shadow-lg transform hover:scale-105 transition duration-300">
                    ✏️ Edit Jam Operasional
                </a>
            </div>

        </div>
    </div>
@endsection
