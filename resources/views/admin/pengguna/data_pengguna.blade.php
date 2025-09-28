@extends('user.component.master')
@section('judul', 'Data Pengguna')
@section('konten')
    <div class="flex">
        @include('admin.component.sidebar')
        <div class="w-full md:ml-64 bg-[#F8DFD4] min-h-screen pt-16 md:pt-0">
            <h1 class="text-center w-full text-gray-600 font-extrabold text-2xl md:text-4xl py-5 px-4">Data Pengguna</h1>
            {{-- <div class="pl-10 pt-10">
                <a href="{{ route('tambah_pengguna') }}"
                    class="bg-[#C69774] py-3 px-3 rounded-lg text-white font-bold hover:bg-green-600 trancition duration-500 ">Tambah</a>
            </div> --}}
            <div class="px-4 md:pl-10 pt-10 flex flex-col md:flex-row justify-between items-center gap-4">
                <a href="{{ route('tambah_pengguna') }}"
                    class="bg-[#C69774] py-3 px-3 rounded-lg text-white font-bold hover:bg-green-600 transition duration-500">
                    Tambah
                </a>
                <form method="GET" action="{{ route('admin_pengguna') }}" class="flex items-center gap-2 w-full md:w-auto">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari berdasarkan nama..."
                        class="w-full max-w-xs px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#C69774] transition duration-300"
                    >
                    <button
                        type="submit"
                        class="bg-[#C69774] text-white font-bold px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-300 focus:outline-none focus:ring-2 focus:ring-[#C69774]">
                        Cari
                    </button>
                </form>
            </div>


            <div class="py-5 px-4 md:pl-10 md:pr-10 overflow-x-auto">
                <table class="border border-gray-700 w-full min-w-[600px]">
                    <thead>
                        <th class="border-gray-700 border">No</th>
                        <th class="border-gray-700 border">Nama</th>
                        <th class="border-gray-700 border">Username</th>
                        <th class="border-gray-700 border">Email</th>
                        <th class="border-gray-700 border">Nomor Wa</th>
                        <th class="border-gray-700 border">Aksi</th>
                    </thead>
                    <tbody class="text-center">
                        @if ($data->isEmpty())
                            <tr>
                                <td colspan="6" class="border-gray-700 border py-3 text-red-500 font-bold">
                                    Nama tidak ditemukan.
                                </td>
                            </tr>
                        @else
                            @foreach ($data as $index => $d)
                                <tr>
                                    <td class="border-gray-700 border">{{ $index + 1 }}</td>
                                    <td class="border-gray-700 border">{{ $d->name }}</td>
                                    <td class="border-gray-700 border">{{ $d->username }}</td>
                                    <td class="border-gray-700 border">{{ $d->email }}</td>
                                    <td class="border-gray-700 border">{{ $d->no_WA }}</td>
                                    <td class="border-gray-700 border py-3 font-semibold flex flex-col md:flex-row gap-2 md:gap-3 justify-center">
                                        <a href="{{ route('proses_editpengguna', $d->id) }}"
                                            class="bg-[#C69774] rounded-sm text-white px-5 py-1 hover:bg-blue-600 transition duration-300">
                                            Edit
                                        </a>
                                        <form action="{{ route('proses_hapuspengguna', $d->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-[#C69774] rounded-sm text-white px-5 py-1 hover:bg-red-600 transition duration-300">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>

        </div>

    </div>

@endsection
