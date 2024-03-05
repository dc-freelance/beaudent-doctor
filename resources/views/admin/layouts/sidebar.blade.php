<button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar" aria-controls="logo-sidebar" type="button"
    class="inline-flex items-center p-2 mt-2 ml-3 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:focus:ring-gray-600">
    <span class="sr-only">Open sidebar</span>
    <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path clip-rule="evenodd" fill-rule="evenodd"
            d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
        </path>
    </svg>
</button>

<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen border border-r transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-4 py-8 overflow-y-auto bg-white">
        {{-- Logo --}}
        {{-- <a href="#" class="flex items-center justify-center mb-4">
            <img src="{{ asset('assets/images/logo.png') }}" class="mr-3 object-contain h-20" alt="logo"
                class="mix-blend-multiply" />
        </a> --}}
        <ul class="space-y-1">
            <x-sidebar-item name="Dashboard" icon="fas fa-home" route="{{ route('doctor.dashboard') }}"
                active="{{ request()->routeIs('doctor.dashboard') }}" />
            <x-sidebar-item name="Daftar Antrian" icon="fas fa-user-group" route="{{ route('doctor.queues.index') }}"
                active="{{ request()->routeIs('doctor.queues.index') ||
                    request()->routeIs('doctor.examinations.*') ||
                    request()->routeIs('doctor.odontogram.*') }}" />
            <x-sidebar-item name="Jadwal" icon="fas fa-calendar-alt" route="{{ route('doctor.schedule.index') }}"
                active="{{ request()->routeIs('doctor.schedule.index') }}" />
            <x-sidebar-item name="Daftar Pasien" icon="fas fa-users" route="{{ route('doctor.patients.index') }}"
                active="{{ request()->routeIs('doctor.patients.index') || request()->routeIs('doctor.patients.*') }}" />
            <li>
                <form action="{{ route('sign-out') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center p-3 font-normal text-gray-900 rounded-md dark:text-white hover:bg-gray-100">
                        <i
                            class="fas fa-sign-out-alt w-4 h-4 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"></i>
                        <span class="ml-3">Keluar</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
