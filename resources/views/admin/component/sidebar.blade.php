<!-- Mobile Menu Button -->
<div class="md:hidden fixed top-4 left-4 z-50">
    <button id="admin-mobile-menu-button" class="bg-[#637E76] text-white p-2 rounded-lg shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<!-- Sidebar -->
<div id="admin-sidebar" class="fixed top-0 left-0 h-full bg-[#637E76] w-64 px-3 z-40 overflow-y-auto transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Header -->
    <div class="flex place-items-center font-semibold gap-2 place-content-center py-5 border-b-4">
        <img src="{{ asset('images/24fc9417-bbdd-4268-ad15-4874be8f411e.png') }}" alt="" class="w-8 md:w-12">
        <p class="font-sans text-lg md:text-2xl text-white hover:text-[#C69774]">Fikri Haikal</p>
    </div>

    <!-- Navigation Links -->
    <div class="py-4 space-y-2">
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{ route('admin') }}" class="text-white font-bold text-lg md:text-xl">Dasbor</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{ route('admin_operasional') }}" class="text-white font-bold text-lg md:text-xl">Operasional</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{ route('admin_pengguna') }}" class="text-white font-bold text-lg md:text-xl">Data Pengguna</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{ route('admin_kategori') }}" class="text-white font-bold text-lg md:text-xl">Data Kategori</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{ route('admin_lapangan') }}" class="text-white font-bold text-lg md:text-xl">Data Lapangan</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{route('admin_booking')}}" class="text-white font-bold text-lg md:text-xl">Data Booking</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{route('admin_konfirmasi')}}" class="text-white font-bold text-lg md:text-xl">Konfirmasi Pesanan</a>
        </div>
        <div class="grid pl-6 md:pl-10 my-2 py-3 hover:bg-[#C69774] transition duration-500 rounded-md">
            <a href="{{route('admin_scan_referral')}}" class="text-white font-bold text-lg md:text-xl">Scan Kode Referal</a>
        </div>
    </div>

    <!-- Logout Button -->
    <div class="absolute bottom-0 left-0 right-0 p-3 border-t-4">
        <div class="hover:bg-red-600 transition duration-500 rounded-md">
            <div class="grid pl-6 md:pl-10 my-2 py-3">
                <a href="{{ route('logout') }}" class="text-white font-bold text-lg md:text-xl">Keluar</a>
            </div>
        </div>
    </div>
</div>

<!-- Overlay for mobile -->
<div id="admin-sidebar-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden md:hidden"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('admin-mobile-menu-button');
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-sidebar-overlay');

    function toggleSidebar() {
        sidebar.classList.toggle('-translate-x-full');
        overlay.classList.toggle('hidden');
    }

    mobileMenuButton.addEventListener('click', toggleSidebar);
    overlay.addEventListener('click', toggleSidebar);

    // Close sidebar when clicking on a link (mobile)
    const sidebarLinks = sidebar.querySelectorAll('a');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        });
    });
});
</script>
