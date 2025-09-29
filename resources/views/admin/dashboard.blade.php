@extends('user.component.master')
@section('judul')
@section('konten')
<div class="flex">
    @include('admin.component.sidebar')
    <div class="w-full md:ml-64 bg-[#F8DFD4] min-h-screen pt-16 md:pt-0">
        <div class="place-items-center grid mb-16 px-4">
            <img src="{{asset('images/badminton_logo_-_Dibuat_dengan_PosterMyWall__1_-removebg-preview.png')}}" alt="" class="w-48 h-48 md:w-72 md:h-72">
            <h1 class="font-bold text-gray-600 text-center text-sm md:text-base px-4">Kamu Admin bekerja yang fokus dan baik karena senangnya pelanggan itu semua berkat kamu..!!</h1>
        </div>
        <div class="flex flex-wrap justify-center gap-4 md:justify-around px-4">

            <div class="bg-[#C69774] h-24 md:h-28 rounded-lg w-48 md:w-56 place-content-center items-center grid transition-transform transform hover:scale-110 shadow-2xl">
                <h1 class="text-white font-bold text-lg md:text-xl">Pengguna</h1>
                <h1 class="text-center text-white text-2xl md:text-4xl font-extrabold">{{$pengguna}}</h1>
            </div>
            <div class="bg-[#C69774] h-24 md:h-28 rounded-lg w-48 md:w-56 place-content-center items-center grid transition-transform transform hover:scale-110 shadow-2xl">
                <h1 class="text-white font-bold text-lg md:text-xl">Lapangan</h1>
                <h1 class="text-center text-white text-2xl md:text-4xl font-extrabold">{{$lapangan}}</h1>
            </div>
            <div class="bg-[#C69774] h-24 md:h-28 rounded-lg w-48 md:w-56 place-content-center items-center grid transition-transform transform hover:scale-110 shadow-2xl">
                <h1 class="text-white font-bold text-lg md:text-xl">Pesanan</h1>
                <h1 class="text-center text-white text-2xl md:text-4xl font-extrabold">{{$pesan}}</h1>
            </div>
            <div class="bg-[#C69774] h-24 md:h-28 rounded-lg w-48 md:w-56 place-content-center items-center grid transition-transform transform hover:scale-110 shadow-2xl">
                <h1 class="text-white font-bold text-lg md:text-xl">Konfirmasi</h1>
                <h1 class="text-center text-white text-2xl md:text-4xl font-extrabold">{{$konfir}}</h1>
            </div>
        </div>
    </div>
</div>


@endsection
