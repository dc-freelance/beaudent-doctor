<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => $transaction->code, 'url' => route('doctor.examinations.show', $examination->id)],
        ['name' => 'Layanan'],
    ]" title="Layanan" />

    <div class="lg:w-3/5 mx-auto">
        <x-card-container>
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold mb-1">Nomor Pembayaran</h3>
                    <p class="text-gray-500">{{ $transaction->code }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-1">No. Rekam Medis</h3>
                    <p class="text-gray-500">{{ $examination->medicalRecord->medical_record_number }}</p>
                </div>
                <div>
                    <h3 class="font-semibold mb-1">Tanggal Pemeriksaan</h3>
                    <p class="text-gray-500">{{ date('d/m/Y', strtotime($examination->created_at)) }}</p>
                </div>
            </div>
            <hr class="my-3">
            <div id="accordion-collapse" data-accordion="collapse">
                <!-- Patient -->
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 rounded-t-sm focus:ring-4 focus:ring-gray-2000 gap-3">
                        <span>Pasien</span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-1" aria-labelledby="accordion-collapse-heading-1">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <div class="space-y-2">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="font-semibold mb-2">Nama</h4>
                                <p class="col-span-2">: {{ $examination->reservation->customer->name }}</p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="font-semibold mb-2">Jadwal</h4>
                                <p class="col-span-2">:
                                    {{ date('d/m/Y', strtotime($examination->reservation->request_date)) }}
                                    {{ date('H:i', strtotime($examination->reservation->request_time)) }}
                                    WIB
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="font-semibold mb-2">Tanggal Lahir</h4>
                                <p class="col-span-2">:
                                    {{ Carbon\Carbon::parse($examination->reservation->customer->date_of_birth)->locale('id')->isoFormat('LL') }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="font-semibold mb-2">Tempat Lahir</h4>
                                <p class="col-span-2">:
                                    {{ $examination->reservation->customer->place_of_birth }}
                                </p>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <h4 class="font-semibold mb-2">Jenis Kelamin</h4>
                                <p class="col-span-2">:
                                    {{ $examination->reservation->customer->gender == 'Male' ? 'Laki-laki' : 'Perempuan' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Treatment -->
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3">
                        <span>Layanan</span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-2" aria-labelledby="accordion-collapse-heading-2">
                    <div class="p-5 border border-b-0 border-gray-200">
                        <div class="" id="treatmentContainer">
                            @forelse ($examinationTreatments as $data)
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h4 class="font-semibold mb-1">{{ $data->treatment->name }}</h4>
                                        <p class="text-gray-500">Jumlah: {{ $data->qty }}</p>
                                    </div>
                                    <div class="text-center">
                                        <a href="{{ asset('storage/exmtreatment-proof/' . $data->proof) }}"
                                            target="_blank" class="text-gray-500 hover:underline inline-block">
                                            <i class="fas fa-file"></i> Lihat Dokumentasi Pemeriksaan
                                        </a>
                                    </div>
                                    <div class="flex items-center">
                                        <p class="text-gray-500">Rp.
                                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">Tidak ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Medicine -->
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3">
                        <span>Obat</span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" aria-labelledby="accordion-collapse-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200">
                        <div class="" id="itemsContainer">
                            @forelse ($examinationItems as $data)
                                <div class="flex justify-between items-start mb-4">
                                    <div class="space-y-1">
                                        <h4 class="font-semibold">{{ $data->item->name }}</h4>
                                        <p class="text-gray-500">
                                            Jumlah: {{ $data->qty . ' ' . $data->item->unit->name }}
                                        </p>
                                        <p class="text-gray-500">
                                            Dosis:
                                            {{ $data->amount_a_day . ' x ' . $data->day . ' ' . $data->item->unit->name . ' selama ' . $data->duration . ' ' . $data->period }}
                                        </p>
                                    </div>
                                    <div class="flex items-center">
                                        <p class="text-gray-500">Rp.
                                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">Tidak ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Addon -->
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3">
                        <span>Addon</span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" aria-labelledby="accordion-collapse-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200">
                        <div id="listAddon">
                            @forelse ($examinationAddons as $data)
                                <div class="flex justify-between items-start mb-4">
                                    <div class="space-y-1">
                                        <h4 class="font-semibold">{{ $data->addon->name }}</h4>
                                        <p class="text-gray-500">Jumlah: {{ $data->qty }}</p>
                                        <p class="text-gray-500">+fee :
                                            {{ number_format($data->fee, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <p class="text-gray-500">Rp.
                                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center">Tidak ada data</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Summary -->
                <h2>
                    <button type="button"
                        class="flex items-center justify-between w-full p-5 font-medium rtl:text-right text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 gap-3">
                        <span>Total</span>
                    </button>
                </h2>
                <div id="accordion-collapse-body-3" aria-labelledby="accordion-collapse-heading-3">
                    <div class="p-5 border border-t-0 border-gray-200 space-y-4">
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold">Layanan</h4>
                            <p class="text-gray-500">Rp.
                                {{ number_format($transactionSummary['treatments'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold">Obat</h4>
                            <p class="text-gray-500">Rp.
                                {{ number_format($transactionSummary['items'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold">Addon</h4>
                            <p class="text-gray-500">Rp.
                                {{ number_format($transactionSummary['addons'], 0, ',', '.') }}</p>
                        </div>
                        <div class="flex justify-between items-center">
                            <h4 class="font-semibold">Biaya</h4>
                            <p class="text-gray-500">Rp.
                                {{ number_format($transactionSummary['total'], 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </x-card-container>

        <div class="flex justify-center space-x-2 mt-6">
            <div>
                <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                    class="text-gray-900 hover:text-white border-2 border-gray-200 hover:bg-blue-900 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    id="addTreatmentModal" type="button">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
