<header class="w-full p-1 bg-white border-b">
    <div class="flex justify-between">
        <div class="p-1 w-full"></div>
        <div class="p-1 w-full flex justify-end">
            <div class="flex justify-end gap-4 items-center">
                <span class="ml-3">{{ session('doctor')->name }}</span>
                <img src="https://ui-avatars.com/api/?background=D04848&color=fff&name={{ session('doctor')->name }}"
                    class="w-8 h-8 rounded-full" alt="avatar">
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="flex w-full items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100">
                    <i
                        class="fas fa-sign-out-alt w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                    <span class="ml-3">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>
