<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Detail Pemeriksaan', 'url' => route('doctor.examinations.show', $examination->id)],
        ['name' => 'Layanan'],
    ]" title="Layanan" />

    <div class="xl:w-3/5 mx-auto">
        <x-card-container>
            <div class="flex justify-between">
                <div>
                    <h3 class="font-semibold mb-1">Nomor Pembayaran</h3>
                    <p class="text-gray-500">{{ $transactionCode }}</p>
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
                            @foreach ($examinationTreatments as $data)
                                <div
                                    class="grid grid-cols-1 lg:grid-cols-3 items-center mb-4 @if (!$loop->last) pb-4 border-b border-gray-200 @endif">
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
                                    <div class="flex items-center justify-end">
                                        <p class="text-gray-500">Rp.
                                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                                        <button type="button" onclick="removeTreatment({{ $data->id }})"
                                            class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-8">
                            <button data-modal-target="modal-treatment" data-modal-toggle="modal-treatment"
                                class="text-gray-900 hover:text-white border-2 border-gray-200 hover:bg-blue-900 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                id="addTreatmentModal" type="button">
                                <i class="fas fa-plus"></i> Tambah Layanan
                            </button>
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
                            @foreach ($examinationItems as $data)
                                <div
                                    class="flex justify-between items-start mb-4 @if (!$loop->last) pb-4 border-b border-gray-200 @endif">
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
                                        <button type="button"
                                            onclick="removeItem('{{ $data->id }}', '{{ $data->item->name }}')"
                                            class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-8">
                            <button data-modal-target="modal-items" data-modal-toggle="modal-items" id="addItemModal"
                                class="text-gray-900 hover:text-white border-2 border-gray-200 hover:bg-blue-900 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="button">
                                <i class="fas fa-plus"></i> Tambah Obat
                            </button>
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
                            @foreach ($examinationAddons as $data)
                                <div
                                    class="flex justify-between items-start mb-4 @if (!$loop->last) pb-4 border-b border-gray-200 @endif">
                                    <div class="space-y-1">
                                        <h4 class="font-semibold">{{ $data->addon->name }}</h4>
                                        <p class="text-gray-500">Jumlah: {{ $data->qty }}</p>
                                        <p class="text-gray-500">+fee :
                                            {{ number_format($data->fee, 0, ',', '.') }}</p>
                                    </div>
                                    <div class="flex items-center">
                                        <p class="text-gray-500">Rp.
                                            {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                                        <button type="button" onclick="removeAddon({{ $data->id }})"
                                            class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="flex justify-center mt-8">
                            <button data-modal-target="modal-addon" data-modal-toggle="modal-addon"
                                id="addAddonModal"
                                class="text-gray-900 hover:text-white border-2 border-gray-200 hover:bg-blue-900 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                                type="button">
                                <i class="fas fa-plus"></i> Tambah Addon
                            </button>
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
            @if (!$transaction)
                <button id="submitTransaction"
                    class="text-white bg-blue-900 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                    type="submit">
                    Selesaikan Pembayaran
                </button>
            @endif
        </div>
    </div>

    <!-- Modal Items -->
    <div id="modal-items" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Obat
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-items">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-6">
                    <x-select id="item_id" label="Obat" name="item_id" required>
                        <option value="0" selected>Pilih Obat</option>
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}" data-unit="{{ $item->unit->name }}">
                                {{ $item->name }} ({{ $item->unit->name }})
                            </option>
                        @endforeach
                    </x-select>
                    <x-input id="note_interaction" label="Catatan Interaksi Obat" name="note_interaction"
                        type="text" />
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">
                            Dosis <span class="text-red-600">*</span>
                        </label>
                        <div class="flex gap-2 items-center">
                            <div class="flex items-center gap-2 col-span-1 w-fit">
                                <input type="number" id="amount_a_day" name="amount_a_day"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-2 w-[4em]" />
                                <i class="fas fa-times"></i>
                                <input type="number" id="day" name="day"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-2 w-[4em]" />
                            </div>
                            <p class="me-7" id="unit-label">Satuan</p>
                            <x-select id="period" name="period">
                                <option value="0">Pilih Periode</option>
                                <option value="hari">Hari</option>
                                <option value="minggu">Minggu</option>
                                <option value="bulan">Bulan</option>
                            </x-select>
                        </div>
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-semibold text-gray-900">
                            Durasi <span class="text-red-600">*</span>
                        </label>
                        <div class="flex items-center gap-2">
                            <input type="number" id="duration" name="duration"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-primary focus:border-primary block p-2 w-[4em]" />
                            <p class="me-7" id="choose-period">Periode yang dipilih</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <x-input id="item_qty" label="Jumlah" name="qty" type="number" required />
                        <x-input id="item_price" label="Harga" name="price" type="text" readonly />
                    </div>
                    <x-input id="item_discount" label="Diskon" name="discount" type="text" readonly />
                    <x-input id="item_sub_total" label="Sub Total" name="sub_total" type="text" readonly />
                    <x-input id="guide" label="Petunjuk Penggunaan" name="guide" type="text" />
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modal-items" type="button" id="addItem"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    <button data-modal-hide="modal-items" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Treatment -->
    <div id="modal-treatment" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Layanan
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-treatment">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-6">
                    <x-select id="treatment_id" name="treatment_id" label="Layanan" required>
                        <option selected value="0">Pilih Layanan</option>
                        @foreach ($treatments as $treatment)
                            <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input-file id="proof" label="Dokumentasi Pemeriksaan" name="proof" required />
                    <x-input id="treatment_code" label="Kode Layanan" name="code" type="text" readonly />
                    <x-input id="treatment_price" label="Harga" name="price" type="text" readonly />
                    <x-input id="treatment_discount" label="Diskon" name="discount" type="text" readonly />
                    <x-input id="qty" label="Jumlah" name="qty" type="number" required />
                    <x-input id="sub_total" label="Sub Total" name="sub_total" type="text" readonly />
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modal-treatment" type="button" id="addTreatment"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    <button data-modal-hide="modal-treatment" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Batal</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Addon -->
    <div id="modal-addon" tabindex="-1"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">
                        Tambah Addon
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modal-addon">
                        <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-6">
                    <x-select id="addon_id" name="addon_id" label="Addon" required>
                        <option value="">Pilih Addon</option>
                        @foreach ($addons as $addon)
                            <option value="{{ $addon->id }}" data-price="{{ $addon->price }}"
                                data-fee-percentage="{{ $addon->fee_percentage }}">{{ $addon->name }}</option>
                        @endforeach
                    </x-select>
                    <x-input id="price" label="Harga" name="price" type="text" readonly />
                    <x-input id="fee_percentage" label="Persentase Biaya" name="fee_percentage" type="text"
                        readonly />
                    <x-input id="qty" label="Jumlah" name="qty" type="number" required />
                    <x-input id="fee" label="Fee Dokter" name="fee" type="text" readonly />
                    <x-input id="sub_total" label="Sub Total" name="sub_total" type="text" readonly />
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="modal-addon" type="button" id="addAddon"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Tambah</button>
                    <button data-modal-hide="modal-addon" type="button"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 ">Batal</button>
                </div>
            </div>
        </div>
    </div>

    @push('js-internal')
        <script>
            $(function() {
                $('#submitTransaction').on('click', function(e) {
                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Pembayaran ini akan disimpan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, simpan!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let formData = {
                                _token: '{{ csrf_token() }}',
                                branch_id: '{{ $branchId }}',
                                examination_id: '{{ $examination->id }}',
                                doctor_id: '{{ $doctorId }}',
                                customer_id: '{{ $customerId }}',
                                total: '{{ $transactionSummary['total'] }}',
                            };

                            $.ajax({
                                type: "POST",
                                url: "{{ route('doctor.transactions.store') }}",
                                data: formData,
                                dataType: "json",
                                success: function(response) {
                                    if (response.status == true) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil',
                                            text: 'Pembayaran berhasil disimpan',
                                            showConfirmButton: false,
                                        });
                                        setTimeout(() => {
                                            location.href =
                                                '{{ route('doctor.patients.examinations', $customerId) }}';
                                        }, 500);
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal',
                                            text: response.message,
                                            showConfirmButton: false,
                                        });
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <script>
            $(function() {
                $('select.select-input').select2();
            });
        </script>

        <!-- treatment -->
        <script>
            $('#addTreatmentModal').on('click', function(e) {
                e.preventDefault();
                $('#modal-treatment').find('input').val('');
                $('#treatment_id').val('0').trigger('change');
                $('#treatment_code').val('');
                $('#treatment_price').val('');
                $('#treatment_discount').val('');
                $('#qty').val('1');
                $('#sub_total').val('');
            });

            function rupiahFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });

                return formatter.format(value);
            }

            function removeRupiahFormat(value) {
                return value.toString().replace(/Rp|\.|/g, '');
            }

            function percentageFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'percent',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2,
                });

                return formatter.format(value / 100);
            }

            function removePercentageFormat(value) {
                return value.toString().replace(/%|/g, '');
            }

            function removeTreatment(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Layanan ini akan dihapus dari daftar layanan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('doctor.transactions.remove-treatment') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Layanan berhasil dihapus',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        });
                    }
                });
            };

            $(function() {
                let examinationTreatmentsFormData = null;

                function resetFormTreatment() {
                    $('#modal-treatment').find('input').val('');
                    $('#treatment_id').val('');
                    examinationTreatmentsFormData = null;
                }

                $('#treatment_id').on('change', function() {
                    let treatmentId = $(this).val();
                    let treatments = @json($treatments);
                    let treatmentSelected = treatments.find(treatment => treatment.id == treatmentId);

                    if (treatmentSelected != undefined) {
                        $('#treatment_code').val(treatmentSelected.code ?? '');
                        $('#treatment_price').val(rupiahFormat(treatmentSelected.price));
                        let isDiscountActive = treatmentSelected.discount_treatment;
                        let hasDiscount = treatmentSelected.discount_treatment;

                        if (treatmentSelected.discount_treatment == null) {
                            $('#treatment_discount').val('0');
                            $('#sub_total').val(rupiahFormat(treatmentSelected.price));
                            return;
                        }

                        let discountType = hasDiscount ? treatmentSelected.discount_treatment.discount_type :
                            null;
                        let discountRate = hasDiscount ? treatmentSelected.discount_treatment.discount_rate : 0;

                        if (hasDiscount) {
                            if (treatmentSelected.discount_treatment.discount_type == 'Percentage') {
                                $('#treatment_discount').parent().find('label').text('Diskon (%)');
                                $('#treatment_discount').val(percentageFormat(discountRate));
                                $('#sub_total').val(rupiahFormat(treatmentSelected.price - (treatmentSelected
                                    .price * discountRate / 100)));
                            } else {
                                $('#treatment_discount').parent().find('label').text('Diskon (Rp)');
                                $('#treatment_discount').val(rupiahFormat(discountRate));
                                $('#sub_total').val(rupiahFormat(treatmentSelected.price - hasDiscount
                                    .discount_rate));
                            }
                        } else {
                            $('#treatment_discount').parent().find('label').text('Diskon');
                            $('#treatment_discount').val('0');
                            $('#sub_total').val(rupiahFormat(treatmentSelected.price));
                        }

                        $('#qty').on('input', function() {
                            const qty = $(this).val();
                            const price = removeRupiahFormat($('#treatment_price').val());
                            const discount = discountType == 'Percentage' ? removePercentageFormat(
                                $('#treatment_discount').val()) : removeRupiahFormat($(
                                '#treatment_discount').val());
                            if (discountType == 'Percentage') {
                                const subTotal = price * qty - (price * qty * discount / 100);
                                $('#sub_total').val(rupiahFormat(subTotal));
                            } else {
                                const subTotal = price * qty - discount;
                                $('#sub_total').val(rupiahFormat(subTotal));
                            }
                        });
                    }
                });

                $('#proof').on('change', function() {
                    const proof = $(this).prop('files')[0];
                    let allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                    if (proof) {
                        if (!allowedExtensions.exec(proof.name)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: 'Pastikan file yang diupload adalah gambar',
                                showConfirmButton: false,
                            });
                            // clear input file
                            $(this).val('');
                            return;
                        }
                    }
                });

                $('button#addTreatment').on('click', function() {
                    const treatmentId = $('#treatment_id option:selected').val();
                    const proof = $('#proof').prop('files')[0];

                    if (treatmentId == 0 || proof == undefined || $('#qty').val() == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Pastikan semua data terisi',
                            showConfirmButton: false,
                        });
                        return;
                    }

                    let formData = new FormData();
                    formData.append('proof', proof);
                    formData.append('examination_id', '{{ $examination->id }}');
                    formData.append('treatment_id', treatmentId);
                    formData.append('qty', $('#qty').val());
                    formData.append('sub_total', removeRupiahFormat($('#sub_total').val()));
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        type: "POST",
                        url: "{{ route('doctor.transactions.add-treatment') }}",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        success: function(response) {
                            if (response.status == true) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Layanan berhasil ditambahkan',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: response.message,
                                    showConfirmButton: false,
                                });
                            }
                        }
                    });
                });
            });
        </script>

        <!-- items -->
        <script>
            $('#addItemModal').on('click', function(e) {
                e.preventDefault();
                $('#modal-items').find('input').val('');
                $('#item_id').val('0').trigger('change');
                $('#period').val('0').trigger('change');
                $('#item_qty').val('1');
                $('#item_price').val('');
                $('#item_discount').val('');
                $('#item_sub_total').val('');
                $('#note_interaction').val('');
                $('#amount_a_day').val('');
                $('#day').val('');
                $('#duration').val('');
                $('#guide').val('');
                $('#unit-label').text('Satuan');
                examinationItemsFormData = null;
            });

            function removeItem(id, name) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Obat " + name + " akan dihapus dari daftar obat!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('doctor.transactions.remove-item') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Obat berhasil dihapus',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        });
                    }
                });
            };

            function rupiahFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });

                return formatter.format(value);
            }

            function removeRupiahFormat(value) {
                return value.toString().replace(/Rp|\.|/g, '');
            }

            function percentageFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'percent',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2,
                });

                return formatter.format(value / 100);
            }

            function removePercentageFormat(value) {
                return value.toString().replace(/%|/g, '');
            }

            let examinationItemsFormData = null;

            $('#period').on('change', function() {
                const period = $(this).val();
                const day = $('#day').val();
                const amountADay = $('#amount_a_day').val();
                const unit = $('#item_id option:selected').attr('data-unit');

                if (period && day && amountADay) {
                    $('#unit-label').text(unit + ' / ' + period);
                }
            });

            $('#duration').on('input', function() {
                const duration = $(this).val();
                const period = $('#period').val();
                const unit = $('#unit-label').text();
                const amountADay = $('#amount_a_day').val();
                const day = $('#day').val();

                if (duration && period) {
                    $('#choose-period').text(amountADay + ' kali se' + period + ' selama ' + duration + ' ' + period);
                }
            });

            $('#item_id').on('change', function() {
                let itemId = $(this).val();
                let item = @json($items);
                let itemSelected = item.find(item => item.id == itemId);
                if (itemSelected != undefined) {
                    let price = itemSelected.price;
                    let hasDiscount = itemSelected.discount_item ? itemSelected.discount_item.discount : false;
                    let discountType = hasDiscount ? itemSelected.discount_item.discount_type : null;
                    let discountPrice = hasDiscount ? itemSelected.discount_item.discount_rate : 0;

                    $('#item_price').val(rupiahFormat(price));
                    $('#item_discount').val(discountType == 'Percentage' ? percentageFormat(discountPrice) :
                        rupiahFormat(
                            discountPrice));
                    $('#item_discount').parent().find('label').text(discountType == 'Percentage' ? 'Diskon (%)' :
                        'Diskon (Rp)');

                    let priceAfterDiscount = 0;
                    if (discountType == 'Percentage') {
                        discountPrice = discountPrice / 100;
                        priceAfterDiscount = price - (price * discountPrice);
                        $('#item_sub_total').val(rupiahFormat(priceAfterDiscount));
                    } else {
                        priceAfterDiscount = price - discountPrice;
                        $('#item_sub_total').val(rupiahFormat(priceAfterDiscount));
                    }
                    examinationItemsFormData = {
                        subTotal: priceAfterDiscount
                    }
                }
            });

            $('#item_qty').on('input', function() {
                let qty = $(this).val();
                // if qty is empty
                if (!qty) {
                    qty = 1;
                } else {
                    let subTotal = examinationItemsFormData.subTotal * qty;
                    $('#item_sub_total').val(rupiahFormat(subTotal));
                }
            });

            $('#addItem').on('click', function() {
                let itemId = $('#item_id').val();
                let qty = $('#item_qty').val();
                let subTotal = removeRupiahFormat($('#item_sub_total').val());
                let noteInteraction = $('#note_interaction').val();
                let amountADay = $('#amount_a_day').val();
                let day = $('#day').val();
                let period = $('#period').val();
                let duration = $('#duration').val();
                let guide = $('#guide').val();

                // BEGIN: ed8c6549bwf9
                if (itemId == 0 || amountADay == '' || day == '' || period == 0 || duration == '' || qty == '') {
                    let emptyFields = [];
                    if (itemId == 0) {
                        emptyFields.push('Jenis Obat');
                    }
                    if (amountADay == '') {
                        emptyFields.push('Dosis Obat');
                    }
                    if (day == '') {
                        emptyFields.push('Jumlah Hari');
                    }
                    if (period == 0) {
                        emptyFields.push('Periode');
                    }
                    if (duration == '') {
                        emptyFields.push('Durasi');
                    }
                    if (qty == '') {
                        emptyFields.push('Jumlah Obat');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Lengkapi data pada kolom berikut: ' + emptyFields.join(', '),
                        showConfirmButton: false,
                    });
                    return;
                }
                // END: ed8c6549bwf9

                examinationItemsFormData = {
                    _token: '{{ csrf_token() }}',
                    examination_id: '{{ $examination->id }}',
                    item_id: itemId,
                    qty: qty,
                    sub_total: subTotal,
                    note_interaction: noteInteraction,
                    amount_a_day: amountADay,
                    day: day,
                    period: period,
                    duration: duration,
                    guide: guide
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('doctor.transactions.add-item') }}",
                    data: examinationItemsFormData,
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Obat berhasil ditambahkan',
                            showConfirmButton: false,
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                });
            });
        </script>

        <!-- Addon -->
        <script>
            let examinationAddonsFormData = null;

            function removeAddon(id) {
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Addon ini akan dihapus dari daftar addon!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "{{ route('doctor.transactions.remove-addon') }}",
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            dataType: "json",
                            success: function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Addon berhasil dihapus',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 500);
                            }
                        });
                    }
                });
            };

            $('#btnAddAddon').on('click', function(e) {
                e.preventDefault();
                $('#modal-addon').find('input').val('');
                $('#addon_id').val('0').trigger('change');
                examinationAddonsFormData = null;
            });

            function rupiahFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 0,
                });

                return formatter.format(value);
            }

            function removeRupiahFormat(value) {
                return value.toString().replace(/Rp|\.|/g, '');
            }

            function percentageFormat(value) {
                const formatter = new Intl.NumberFormat('id-ID', {
                    style: 'percent',
                    minimumFractionDigits: 0,
                    maximumFractionDigits: 2,
                });

                return formatter.format(value / 100);
            }

            function removePercentageFormat(value) {
                return value.toString().replace(/%|/g, '');
            }

            $('#addon_id').on('change', function() {
                $('#modal-addon').find('input').val('');

                let addonId = $(this).val();
                let addon = @json($addons);
                let addonSelected = addon.find(addon => addon.id == addonId);
                let price = addonSelected.price;
                let feePercentage = addonSelected.fee_percentage;

                $('#price').val(rupiahFormat(price));
                $('#fee_percentage').val(percentageFormat(feePercentage));
            });

            $('#modal-addon #qty').on('input', function() {
                let qty = $(this).val();
                let price = removeRupiahFormat($('#price').val());
                if (!qty) {
                    qty = 1;
                } else {
                    let feePercentage = removePercentageFormat($('#fee_percentage').val());
                    let subTotal = price * qty;
                    let fee = subTotal * feePercentage / 100;

                    $('#modal-addon #sub_total').val(rupiahFormat(subTotal));
                    $('#fee').val(rupiahFormat(fee));

                    console.log(subTotal);
                }
            });

            $('#addAddon').on('click', function() {
                let addonId = $('#addon_id').val();
                let qty = $('#modal-addon #qty').val();
                let subTotal = removeRupiahFormat($('#modal-addon #sub_total').val());
                let fee = removeRupiahFormat($('#fee').val());

                examinationAddonsFormData = {
                    _token: '{{ csrf_token() }}',
                    examination_id: '{{ $examination->id }}',
                    addon_id: addonId,
                    qty: qty,
                    sub_total: subTotal,
                    fee: fee
                };

                $.ajax({
                    type: "POST",
                    url: "{{ route('doctor.transactions.add-addon') }}",
                    data: examinationAddonsFormData,
                    dataType: "json",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Addon berhasil ditambahkan',
                            showConfirmButton: false,
                        });
                        setTimeout(() => {
                            location.reload();
                        }, 500);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
