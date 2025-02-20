<!-- Sidebar -->
<aside id="sidebar h-[100vh]"
    class="fixed left-0 w-[15%] top-0 h-full bg-white shadow-lg transform transition-transform duration-300">
    <div class="flex items-center justify-center flex-col pt-10 pb-5 border-b-2 mx-3">
        <img src="{{ Auth::user()->avatar }}" alt="User Avatar" class="rounded-full border-2 border-gray-400 p-1" />
        <p class="text-[1.2rem] font-medium leading-3 mt-2">{{ Auth::user()->name }}</p>
        <p class="text-gray-500">{{ Auth::user()->email }}</p>
    </div>
    <ul class="p-4 space-y-2">
        <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-200">Beranda</a></li>
        <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-200">Profil</a></li>
        <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-200">Pengaturan</a></li>
        <li><a href="#" class="block p-2 rounded-lg hover:bg-gray-200">Keluar</a></li>
    </ul>
    <div class="border-t mx-3 fixed bottom-5 flex justify-center w-[90%] pt-5">
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none cursor-pointer">
            <button class="w-full text-red-600" type="submit">
                {{ __('Logout') }}
            </button>
            @csrf
        </form>
    </div>
</aside>