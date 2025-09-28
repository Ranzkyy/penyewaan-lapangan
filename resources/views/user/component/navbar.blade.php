<div class="w-full bg-[#637E76] shadow-2xl fixed top-0 left-0 right-0 z-50">
    <div class="flex justify-between items-center py-4 px-4">
        <!-- Logo -->
        <div class="flex items-center font-semibold gap-2">
            <img src="{{ asset('images/24fc9417-bbdd-4268-ad15-4874be8f411e.png') }}" alt="" class="w-8 md:w-12">
            <p class="font-sans text-lg md:text-2xl text-white hover:text-[#C69774]">Fikri Haikal</p>
        </div>

        <!-- Desktop Menu -->
        <div class="hidden md:flex gap-8 lg:gap-20 text-white font-bold">
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out">
                <a href="{{ route('user') }}">Beranda</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out">
                <a href="{{ route('lapangan') }}">Lapangan</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out">
                <a href="{{ route('kontak') }}">Kontak</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out">
                <a href="{{ route('riwayat') }}">Riwayat</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out">
                <a href="{{ route('settingAkun') }}">Setting Akun</a>
            </div>
        </div>

        <!-- Desktop Login/Logout -->
        <div class="hidden md:block">
            @if (auth()->check())
                <a href="{{ route('logout') }}">
                    <div class="bg-[#C69774] px-6 lg:px-10 py-2 text-white font-bold rounded-lg hover:text-[#637E76] hover:bg-[#F8DFD4] transition delay-150 duration-200 ease-in-out">
                        Logout
                    </div>
                </a>
            @else
                <a href="{{ route('login') }}">
                    <div class="bg-[#C69774] px-6 lg:px-10 py-2 text-white font-bold rounded-lg hover:text-[#637E76] hover:bg-[#F8DFD4] transition delay-150 duration-200 ease-in-out">
                        Login
                    </div>
                </a>
            @endif
        </div>

        <!-- Mobile Menu Button -->
        <button id="mobile-menu-button" class="md:hidden text-white focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-[#637E76] border-t border-[#C69774]">
        <div class="px-4 py-2 space-y-2">
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out py-2">
                <a href="{{ route('user') }}" class="block text-white font-bold">Beranda</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out py-2">
                <a href="{{ route('lapangan') }}" class="block text-white font-bold">Lapangan</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out py-2">
                <a href="{{ route('kontak') }}" class="block text-white font-bold">Kontak</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out py-2">
                <a href="{{ route('riwayat') }}" class="block text-white font-bold">Riwayat</a>
            </div>
            <div class="hover:text-[#C69774] transition delay-150 duration-200 ease-in-out py-2">
                <a href="{{ route('settingAkun') }}" class="block text-white font-bold">Setting Akun</a>
            </div>
            <div class="pt-4 border-t border-[#C69774]">
                @if (auth()->check())
                    <a href="{{ route('logout') }}">
                        <div class="bg-[#C69774] px-4 py-2 text-white font-bold rounded-lg hover:text-[#637E76] hover:bg-[#F8DFD4] transition delay-150 duration-200 ease-in-out text-center">
                            Logout
                        </div>
                    </a>
                @else
                    <a href="{{ route('login') }}">
                        <div class="bg-[#C69774] px-4 py-2 text-white font-bold rounded-lg hover:text-[#637E76] hover:bg-[#F8DFD4] transition delay-150 duration-200 ease-in-out text-center">
                            Login
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    mobileMenuButton.addEventListener('click', function() {
        mobileMenu.classList.toggle('hidden');
    });
});
</script>
