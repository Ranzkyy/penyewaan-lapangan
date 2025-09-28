<div class="w-full flex flex-col md:flex-row h-screen bg-gradient-to-b from-[#C69774] to-[#F8DFD4] pt-20">

    <div class="w-full md:w-1/2 px-4 md:px-20 flex flex-col justify-center">
        <p class="text-2xl md:text-4xl font-bold text-center md:text-left">
            @auth
                Nikmati pengalaman bermain seru di lapangan bulu tangkis, {{ auth()->user()->name }}!
            @else
                Nikmati pengalaman bermain seru di lapangan bulu tangkis.
            @endauth
        </p>

        <p class="pt-3 text-lg md:text-xl text-center md:text-left"> Pesan sekarang dan rasakan keseruannya!</p>
        <div class="flex justify-center md:justify-start gap-5 pt-5">
            <div class="">
                <a href="{{route('lapangan')}}">
                    <div class="bg-[#F8DFD4] px-6 md:px-10 py-2 text-[#637E76] font-bold rounded-lg hover:text-[#F8DFD4] hover:bg-[#637E76] transition delay-150 duration-200 ease-in-out">Pesan</div>
                </a>
            </div>
        </div>
    </div>
    <div class="w-full md:w-1/2 grid place-items-center px-4">
        <img src="{{asset('images/3d-illustration-athletic-man-doing-sport-activities.png')}}" alt="" class="w-full max-w-[300px] md:max-w-[500px]">
    </div>

</div>
