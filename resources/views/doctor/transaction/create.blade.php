<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Detail Pemeriksaan', 'url' => route('doctor.examinations.show', $examination->id)],
        ['name' => 'Transaksi'],
    ]" title="Pembayaran" />

    <div class="lg:w-3/5 mx-auto">
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
            <form action="" method="POST" class="space-y-6">
                @csrf
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
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="font-semibold mb-1">{{ $data->treatment->name }}</h4>
                                            <p class="text-gray-500">Jumlah: {{ $data->qty }}</p>
                                        </div>
                                        <div class="flex items-center">
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
                            <div class="flex justify-center">
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
                                            <button type="button"
                                                onclick="removeItem('{{ $data->id }}', '{{ $data->item->name }}')"
                                                class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center">
                                <button data-modal-target="modal-items" data-modal-toggle="modal-items"
                                    id="addItemModal"
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
                                            <button type="button" onclick="removeAddon({{ $data->id }})"
                                                class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="flex justify-center">
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
                            <span>Rincian</span>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-3" aria-labelledby="accordion-collapse-heading-3">
                        <div class="p-5 border border-t-0 border-gray-200">

                        </div>
                    </div>
                </div>
            </form>
        </x-card-container>
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
                        <option value="">Pilih Layanan</option>
                        @foreach ($treatments as $treatment)
                            <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                        @endforeach
                    </x-select>
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
                    const treatmentId = $(this).val();
                    const treatment = @json($treatments);
                    const treatmentSelected = treatment.find(treatment => treatment.id == treatmentId);

                    resetFormTreatment();

                    $('#treatment_code').val(treatmentSelected.code ?? '');
                    $('#treatment_price').val(rupiahFormat(treatmentSelected.price));
                    let hasDiscount = treatmentSelected.discount_treatment;
                    let discountType = hasDiscount ? hasDiscount.discount.discount_type : null;
                    hasDiscount = hasDiscount ? hasDiscount.discount : 0;

                    if (hasDiscount) {
                        if (hasDiscount.discount_type == 'Percentage') {
                            $('#treatment_discount').parent().find('label').text('Diskon (%)');
                            $('#treatment_discount').val(percentageFormat(hasDiscount.discount));
                        } else {
                            $('#treatment_discount').parent().find('label').text('Diskon (Rp)');
                            $('#treatment_discount').val(rupiahFormat(hasDiscount.discount));
                        }
                    } else {
                        $('#treatment_discount').parent().find('label').text('Diskon');
                        $('#treatment_discount').val('0');
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

                        examinationTreatmentsFormData = {
                            _token: '{{ csrf_token() }}',
                            examination_id: '{{ $examination->id }}',
                            treatment_id: treatmentId,
                            qty: qty,
                            sub_total: removeRupiahFormat($('#sub_total').val())
                        };
                    });
                });

                $('button#addTreatment').on('click', function() {
                    const treatmentId = $('#treatment_id option:selected').val();
                    $.ajax({
                        type: "POST",
                        url: "{{ route('doctor.transactions.add-treatment') }}",
                        data: examinationTreatmentsFormData,
                        dataType: "json",
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Layanan berhasil ditambahkan',
                                showConfirmButton: false,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 500);
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
                let price = itemSelected.price;
                let hasDiscount = itemSelected.discount_item ?? null;
                let discountType = hasDiscount ? hasDiscount.discount.discount_type : null;
                let discountPrice = hasDiscount ? hasDiscount.discount.discount : 0;

                $('#item_price').val(rupiahFormat(price));
                $('#item_discount').val(discountType == 'Percentage' ? percentageFormat(discountPrice) : rupiahFormat(
                    discountPrice));
                $('#item_discount').parent().find('label').text(discountType == 'Percentage' ? 'Diskon (%)' :
                    'Diskon (Rp)');

                let priceAfterDiscount = 0;
                if (discountType == 'Percentage') {
                    discountPrice = discountPrice / 100;
                    priceAfterDiscount = price - (price * discountPrice);
                } else {
                    priceAfterDiscount = price - discountPrice;
                }
                examinationItemsFormData = {
                    subTotal: priceAfterDiscount
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
