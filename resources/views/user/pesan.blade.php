@extends('user.component.master')

@section('judul', 'Pemesanan')

@section('konten')

    @include('user.component.navbar')

    <div class="bg-[#F8DFD4] min-h-screen pt-20">
        <h1 class="text-3xl font-bold text-gray-600 text-center py-10">Pesan Lapangan Sekarang</h1>
        <div class="w-full flex items-center justify-center">

        <div class="bg-[#637E76] p-10 rounded-lg shadow-lg max-w-md w-1/2 flex justify-center items-center">
            <img src="{{ asset('images/' . $kategori->foto_222142) }}" alt="Badminton Court" class="w-80 h-80">
        </div>

        <div class="bg-[#637E76] ml-5 w-1/2 max-w-md px-10 py-3 shadow-lg rounded-lg">
            <div class="w-full items-center">
                <h1 class="text-white text-center text-2xl font-bold">Jadwal Yang Tersedia</h1>
            </div>
            <div class="mb-4">
                <div class="grid grid-cols-4 gap-4 text-white text-center mt-3">
                    @if ($operasional)
                        @php
                            $start = \Carbon\Carbon::createFromFormat('H:i:s', trim($operasional->jam_buka_222142));
                            $end = \Carbon\Carbon::createFromFormat('H:i:s', trim($operasional->jam_tutup_222142));
                            
                            // Get current time
                            $now = \Carbon\Carbon::now();
                            $currentTime = $now->format('H:i');
                            $selectedDate = \Carbon\Carbon::parse($tanggal);
                            $isToday = $selectedDate->isToday();
                            
                            $bookedIntervals = $jam
                                ->filter(function ($booking) {
                                    return $booking->status_222142 === 'aktif';
                                })
                                ->map(function ($booking) {
                                    $start = \Carbon\Carbon::createFromFormat('H:i:s', $booking->jam_mulai_222142);
                                    $end = \Carbon\Carbon::createFromFormat('H:i:s', $booking->jam_selesai_222142);
                                    $interval = [];
                                    while ($start < $end) {
                                        $interval[] = $start->format('H:i');
                                        $start->addHour();
                                    }
                                    return $interval;
                                })
                                ->flatten()
                                ->toArray();
                        @endphp

                        @while ($start < $end)
                            @php
                                $time = $start->format('H:i');
                                $isBooked = in_array($time, $bookedIntervals);
                                
                                // Check if time has passed (only for today)
                                $timeHasPassed = false;
                                if ($isToday) {
                                    $timeHasPassed = $time <= $currentTime;
                                }
                                
                                // Check if date is in the past
                                $dateInPast = $selectedDate->isPast() && !$selectedDate->isToday();
                                
                                $isDisabled = $isBooked || $timeHasPassed || $dateInPast;
                            @endphp

                            <button
                                class="{{ $isDisabled ? 'bg-red-600 cursor-not-allowed' : 'bg-[#C69774]' }} py-1 rounded-lg hover:scale-105 transition-transform select-time"
                                data-time="{{ $time }}" {{ $isDisabled ? 'disabled' : '' }}>
                                {{ $time }}
                            </button>

                            @php $start->addHour(); @endphp
                        @endwhile
                    @else
                        <p>Data operasional tidak ditemukan.</p>
                    @endif
                </div>


                {{-- Form Pemesanan --}}
                <form action="{{ route('detailpesanan') }}" method="POST" id="booking-form">
                    @csrf

                    <input type="hidden" name="selected_times" id="selected-times" value="">

                    {{-- Hidden Fields --}}
                    <input type="hidden" name="id_lapangan" value="{{ $id }}">
                    <input type="hidden" name="tgl_booking" value="{{ $tanggal }}">

                    {{-- Tombol Submit --}}
                    <div
                        class="bg-[#C69774] text-white py-3 px-2 flex justify-center rounded-lg hover:bg-blue-600 transition-transform transform hover:scale-105 mt-5">
                        <button type="submit" class="text-center font-bold text-xl">Pesan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    @include('user.component.footer')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const selectedTimesInput = document.getElementById('selected-times');
            const timeButtons = document.querySelectorAll('.select-time');

            const selectedTimes = new Set();

            timeButtons.forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    const time = button.getAttribute('data-time');

                    // Abaikan jika tombol sudah disabled (booked, lewat waktu, atau tanggal lewat)
                    if (button.disabled || button.classList.contains('bg-red-600')) {
                        return;
                    }

                    if (selectedTimes.has(time)) {
                        selectedTimes.delete(time);
                        button.classList.remove('bg-blue-500'); // Warna jika terpilih
                        button.classList.add('bg-[#C69774]'); // Warna default
                    } else {
                        selectedTimes.add(time);
                        button.classList.remove('bg-[#C69774]');
                        button.classList.add('bg-blue-500');
                    }

                    selectedTimesInput.value = Array.from(selectedTimes).join(',');
                    console.log("Selected Times:", selectedTimesInput.value); // Debugging
                });
            });

            // Disable form submission if no times selected
            const form = document.getElementById('booking-form');
            form.addEventListener('submit', (e) => {
                if (selectedTimes.size === 0) {
                    e.preventDefault();
                    alert('Silakan pilih minimal satu jadwal waktu!');
                }
            });
        });
    </script>
@endsection
