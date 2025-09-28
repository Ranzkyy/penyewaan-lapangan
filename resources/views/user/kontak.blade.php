@extends('user.component.master')
@section('judul', 'Kontak')
@section('konten')

@include('user.component.navbar')

<div class="w-full bg-gradient-to-b from-[#f8c4a5] to-[#f4e3d6] min-h-screen pt-20">
    <h1 class="text-4xl text-gray-700 font-extrabold text-center py-10">Kontak Kami</h1>
    <div class="flex justify-center space-x-16 mt-10">
        <div class="transition-transform transform hover:scale-105 hover:shadow-xl rounded-lg p-4 bg-white flex items-center space-x-4">
            <a href="https://wa.me/6282236234227?text=Assalamualaikum%20Kak,%20saya%20ingin%20tahu%20lebih%20detail%20tentang%20lapangan%20badminton%20FH%20Smash%20Mari%20Sama-sama."
                class="flex items-center"
                target="_blank"
                rel="noopener noreferrer">
                    <img src="{{ asset('images/wa.png') }}" alt="WhatsApp Logo" class="w-14 h-14">
                    <h1 class="ml-4 text-2xl font-semibold text-gray-600">0822-3623-4227</h1>
            </a>

        </div>
        <div class="transition-transform transform hover:scale-105 hover:shadow-xl rounded-lg p-4 bg-white flex items-center space-x-4">
            <a href="mailto:fikri.haikal17062004@gmail.com" class="flex items-center">
                <img src="{{asset('images/gmail.png')}}" alt="Gmail" class="w-14 h-14">
                <h1 class="ml-4 text-2xl font-semibold text-gray-600">fikri.haikal17062004@gmail.com</h1>
            </a>
        </div>

        <div class="transition-transform transform hover:scale-105 hover:shadow-xl rounded-lg p-4 bg-white flex items-center space-x-4">
            <a href="https://www.instagram.com/fikrihaikal.17" class="flex items-center">
                <img src="{{asset('images/instagram.png')}}" alt="Instagram" class="w-14 h-14">
                <h1 class="ml-4 text-2xl font-semibold text-gray-600">fikrihaikal.17</h1>
            </a>
        </div>


    </div>
</div>

@include('user.component.footer')

@endsection
