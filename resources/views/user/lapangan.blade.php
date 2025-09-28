@extends('user.component.master')
@section('judul', 'Lapangan')
@section('konten')

@include('user.component.navbar')
<div class="bg-[#F8DFD4] w-full pb-10 pt-20 min-h-screen">
    <h1 class="text-center font-bold text-2xl md:text-4xl text-gray-600 py-10 px-4">Pesan Lapangan</h1>

    <div class="flex flex-wrap justify-center gap-6 md:gap-10 w-full px-4 md:px-5">
        @foreach ($lapangan as $a)
            <div
                class="p-4 md:p-5 bg-[#C69774] rounded-lg shadow-2xl hover:bg-[#a37a5b] transition-transform transform hover:scale-105 duration-300 w-full max-w-sm md:w-72">
                <div>
                    <img src="{{ asset('images/' . $kategori->where('id', $a->id_kategori)->first()->foto_222142) }}"
                        alt="" class="w-full h-72 rounded-lg">
                </div>
                <div>
                    <h1 class="text-center text-xl md:text-2xl text-white font-bold mt-2">Lapangan
                        {{ $kategori->where('id', $a->id_kategori)->first()->name_222142 }}</h1>
                </div>
                <div>
                    <h1 class="text-center text-xl md:text-2xl text-white font-bold mt-2">Nomor {{ $a->urutan_222142 }}</h1>
                </div>
                <div class="mt-5 flex flex-col items-center text-white">
                    @if ($a->is_active_222142 == 1)
                        <form action="{{ route('pemesanan', $a->id) }}" method="POST" class="w-full">
                            @csrf
                            <input type="date" min="{{ now()->format('Y-m-d') }}" name="tanggal" required
                                class="w-full px-3 py-2 rounded-md bg-[#F8DFD4] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#a37a5b]">
                            </script>

                            <button type="submit"
                                class="mt-4 py-2 px-10 bg-[#637E76] rounded-lg hover:bg-[#F8DFD4] hover:text-gray-600 font-semibold w-full">
                                Pesan
                            </button>
                        </form>
                    @else
                        <div class="text-center py-2 px-4 bg-red-500 rounded-lg font-semibold w-full">
                            Lapangan sedang tidak bisa digunakan 😭
                        </div>
                    @endif
                    <a href="{{ route('detail', $a->id) }}"
                         class=" text-center mt-4 py-2 px-10 bg-[#637E76] rounded-lg hover:bg-[#F8DFD4] hover:text-gray-600 font-semibold w-full">
                        Detail
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@include('user.component.footer')
@endsection
