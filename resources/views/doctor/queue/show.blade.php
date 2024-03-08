<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Daftar Pemeriksaan', 'url' => route('doctor.patients.index')],
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
                    <div>
                        <div>
                            <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA LAYANAN</h3>
                            <div class="space-y-4">
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

                <!-- Examination History -->
                <div class="mt-12">
                    <h3 class="text-sm font-semibold text-gray-800">RIWAYAT PEMERIKSAAN SEBELUMNYA</h3>
                    <hr class="my-6">
                    <div class="grid grid-cols-1 lg:grid-cols-4">
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Tanggal</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Dokter</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Branch</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Lihat</h3>
                    </div>
                    @forelse ($examinationHistories as $data)
                        @if ($data->id != $examination->id)
                            <x-examination-history :examination="$data" />
                        @endif
                    @empty
                        <p class="text-gray-500">Tidak ada riwayat pemeriksaan</p>
                    @endforelse
                </div>
            </x-card-container>
        </div>
        <div class="lg:w-1/3">
            <x-card-container>
                <h3 class="text-sm font-semibold text-gray-800">INFORMASI PEMERIKSAAN</h3>
                <hr class="my-6">

                <div class="space-y-3">
                    <!-- Detail Examination -->
                    <a href="{{ route('doctor.examinations.edit', $examination->id) }}"
                        class="block text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 w-full">
                        Lihat Detail Pemeriksaan
                    </a>

                    <!-- Odontogram -->
                    @if ($odontogramResults->count() > 0 && $examination)
                        <a href="{{ route('doctor.odontogram.show', $examination->id) }}"
                            class="block text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 w-full">
                            Lihat Detail Odontogram
                        </a>
                    @else
                        <a href="{{ route('doctor.odontogram.create', $examination->id) }}"
                            class="block text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 w-full">
                            Tambah Odontogram
                        </a>
                    @endif

                    <!-- Transaction -->
                    @if ($transaction && $odontogramResults->count() > 0)
                        <a href="{{ route('doctor.transactions.show', $examination->id) }}"
                            class="block text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 w-full">
                            Lihat Detail Layanan
                        </a>
                    @elseif ($odontogramResults->count() > 0 && $examination)
                        <a href="{{ route('doctor.transactions.create', $examination->id) }}"
                            class="block text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 me-2 mb-2 w-full">
                            Tambah Layanan
                        </a>
                    @endif
                </div>
            </x-card-container>
        </div>
    </div>

</x-app-layout>
