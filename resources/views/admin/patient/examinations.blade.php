<x-app-layout>

    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Daftar Pasien', 'url' => route('doctor.patients.index')],
        ['name' => 'Pemeriksaan', 'url' => route('doctor.patients.examinations', $data->id)],
    ]" title="Riwayat Pemeriksaan" />

    <x-card-container>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-0">
            <div>
                <h3 class="text-sm font-semibold mb-4">INFORMASI PASIEN</h3>
                <hr class="my-3">
                <div class="space-y-6">
                    <div>
                        <h4 class="font-semibold mb-2">Nama</h4>
                        <p>{{ $data->name }}</p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Tanggal Lahir</h4>
                        <p>
                            {{ Carbon\Carbon::parse($data->date_of_birth)->locale('id')->isoFormat('LL') }}
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Tempat Lahir</h4>
                        <p>
                            {{ $data->place_of_birth }}
                        </p>
                    </div>
                    <div>
                        <h4 class="font-semibold mb-2">Jenis Kelamin</h4>
                        <p>{{ $data->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-2">
                <!-- Examination History -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-800">RIWAYAT PEMERIKSAAN</h3>
                    <hr class="my-6">
                    <div class="grid grid-cols-4">
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Tanggal</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Dokter</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Branch</h3>
                        <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">Lihat</h3>
                    </div>
                    @forelse ($examinationHistories as $history)
                        <x-examination-history :examination="$history" />
                    @empty
                        <p class="text-gray-500">Tidak ada riwayat pemeriksaan</p>
                    @endforelse
                </div>
            </div>
        </div>
    </x-card-container>
</x-app-layout>
