<x-guest-layout>
    @push('css-internal')
    <!-- Alert -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" />
@endpush

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <form method="POST" action="{{ route('sign-in') }}">
        @csrf
        <div class="lg:mt-[15vh] mt-[10vh]">  
            <img src="{{ asset('assets/image/logo.jpg') }}" class="max-w-[200px] mx-auto" alt="">
            <div class="lg:p-12 p-5 rounded-md lg:max-w-lg max-w-full mx-auto space-y-5">        
                <div class="head">
                    <div class="space-y-3">
                        <h2 class="text-2xl font-bold tracking-tighter">Selamat datang kembali</h2>
                        <p class="text-gray-400 text-sm">Silahkan masukkan email dan password untuk melanjutkan</p>
                    </div>
                </div>
                <div class="w-full text-left flex justify-center flex-col space-y-5 ">
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="floating_email" class="font-poppins block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray78 dark:focus:bor7r-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer" placeholder=" " required />
                        <label for="floating_email" class="font-poppins peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-red-600 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                        {{-- <x-input-error :messages="$errors->get('email')" class="mt-2 block" /> --}}
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        
                        <input type="password" name="password" id="floating_repeat_password" class="font-poppins block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-red-500 focus:outline-none focus:ring-0 focus:border-red-600 peer" placeholder=" " required />
                        <label for="floating_repeat_password" class="font-poppins peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-red-600 peer-focus:dark:text-red-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                        {{-- <x-input-error :messages="$errors->get('password')" class="mt-2" /> --}}
                    </div>
                    <div class="flex items-center justify-between mt-4" style="gap: 16px">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox"
                                class="rounded dark:bg-gray-900 border-gray-300 text-primary shadow-sm focus:ring-primary hover:cursor-pointer"
                                name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Ingat Saya') }}</span>
                        </label>
        
                        @if (Route::has('password.request'))
                            <a class="text-primary text-sm focus:text-red-800" href="{{ route('password.request') }}">
                                {{ __('lupa sandi?') }}
                            </a>
                        @endif
                    </div>
                    <div class="flex justify-end ">
                        <button type="submit"
                            class="w-full px-5 py-3 font-poppins font-semibold text-white bg-[#D04848] rounded-full hover:bg-[#D04848]/90 focus:bg-[#D04848]/90">
                            Masuk
                        </button>
                    </div>
                    <div class="flex justify-center">
                        <p class="text-sm font-medium text-gray-500">&copy; Copyright Beaudent  {{ date('Y') }}</p>
                    </div>
                </div>
            </div>          
        </div>   
    </form>
@push('js-internal')
    <!-- Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <script>
        @if (Session::has('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ Session::get('error') }}',
            });
        @endif
    </script>
@endpush
</x-guest-layout>
