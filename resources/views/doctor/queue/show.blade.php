<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Daftar Pemeriksaan', 'url' => route('doctor.examinations.index')],
        ['name' => $reservation->customer->name],
    ]" title="Detail Pemeriksaan" />

    <div class="lg:flex gap-6">
        <div class="lg:w-2/3">
            <x-card-container>
                <h3 class="text-sm font-semibold text-gray-800">INFORMASI PASIEN</h3>
                <hr class="my-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA PASIEN</h3>
                        <div class="space-y-6">
                            <div>
                                <h4 class="font-semibold mb-2">Nama</h4>
                                <p>{{ $reservation->customer->name }}</p>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2">Jadwal</h4>
                                <p>{{ date('H:i', strtotime($reservation->request_time)) }} WIB</p>
                                <p>{{ date('d/m/Y', strtotime($reservation->request_date)) }}</p>
                            </div>

                            <div>
                                <h4 class="font-semibold mb-2">Nakes</h4>
                                <p>{{ $examination->doctor->name }}</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div>
                            <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA UMUM</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold mb-2">Tanggal Lahir</h4>
                                    <p>
                                        {{ Carbon\Carbon::parse($reservation->customer->date_of_birth)->locale('id')->isoFormat('LL') }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Tempat Lahir</h4>
                                    <p>
                                        {{ $reservation->customer->place_of_birth }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Jenis Kelamin</h4>
                                    <p>{{ $reservation->customer->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div>
                        <div>
                            <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA PEMBAYARAN</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold mb-2">Deposit</h4>
                                    <p>
                                        {{ number_format($reservation->deposit, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Akun Bank</h4>
                                    <p>
                                        {{ $reservation->customer_bank_account }}
                                    </p>
                                    <p>
                                        {{ $reservation->customer_bank_account_name }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Tanggal Transfer</h4>
                                    <p>
                                        {{ date('d/m/Y', strtotime($reservation->transfer_date)) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div>
                        <div>
                            <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA LAYANAN</h3>
                            <div class="space-y-4">
                                <div>
                                    <h4 class="font-semibold mb-2">Layanan</h4>
                                    <p>
                                        {{ $reservation->treatment->name }}
                                    </p>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Kontrol</h4>
                                    <p>
                                        {{ $reservation->is_control ? 'Ya' : 'Tidak' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-card-container>
        </div>
        <div class="lg:w-1/3">
            <x-card-container>
                <h3 class="text-sm font-semibold text-gray-800">INFORMASI PEMERIKSAAN</h3>
                <hr class="my-6">

                <div class="space-y-3">
                    <!-- Detail Examination -->
                    <x-link-button color="blue" route="{{ route('doctor.examinations.edit', $examination->id) }}"
                        class="w-full py-2.5">
                        <div class="flex justify-between items-center w-full">
                            <span>Lihat Detail Pemeriksaan</span>
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                    </x-link-button>

                    <!-- Odontogram -->
                    @if ($odontogramResults->count() > 0 && $examination)
                        <x-link-button color="blue" route="{{ route('doctor.odontogram.show', $examination->id) }}"
                            class="w-full py-2.5">
                            <div class="flex justify-between items-center w-full">
                                <span>Lihat Odontogram</span>
                                <i class="fas fa-tooth"></i>
                            </div>
                        </x-link-button>
                    @else
                        <x-link-button color="gray" route="{{ route('doctor.odontogram.create', $examination->id) }}"
                            class="w-full py-2.5">
                            <div class="flex justify-between items-center w-full">
                                <span>Tambah Odontogram</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </x-link-button>
                    @endif

                    <!-- Transaction -->
                    @if ($transaction && $odontogramResults->count() > 0)
                        <x-link-button color="blue" class="w-full py-2.5">
                            <div class="flex justify-between items-center w-full">
                                <span>Lihat Layanan</span>
                                <i class="fas fa-money-check-alt"></i>
                            </div>
                        </x-link-button>
                    @else
                        <x-link-button color="gray"
                            route="{{ route('doctor.transactions.create', $examination->id) }}" class="w-full py-2.5">
                            <div class="flex justify-between items-center w-full">
                                <span>Tambah Pelayanan</span>
                                <i class="fas fa-arrow-right"></i>
                            </div>
                        </x-link-button>
                    @endif
                </div>
            </x-card-container>
        </div>
    </div>

</x-app-layout>
