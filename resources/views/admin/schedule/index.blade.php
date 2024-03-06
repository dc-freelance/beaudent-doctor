<x-app-layout>
    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')], ['name' => 'Jadwal Dokter']]" title="Jadwal Dokter" />

    <x-card-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">
            <x-input id="start_date" label="Tanggal Awal" type="date" name="start_date" />
            <x-input id="end_date" label="Tanggal Akhir" type="date" name="end_date" />
            <button type="button" id="buttonFilter"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                <i class="fas fa-filter me-2"></i>
                Filter Data
            </button>
            <div class="flex items-end w-full">
                <div class="border-r border-gray-300 h-10 me-6"></div>
                <div class="w-full">
                    <x-input id="month" label="Filter Menurut Bulan" type="month" name="month" />
                </div>
            </div>
        </div>
    </x-card-container>

    <x-card-container>
        <table id="scheduleTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Cabang</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
                $('#scheduleTable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: '{{ route('doctor.schedule.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'time',
                            name: 'time'
                        },
                        {
                            data: 'branch',
                            name: 'branch'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        }
                    ]
                });

                $('#buttonFilter').on('click', function(e) {
                    e.preventDefault();
                    let startDate = $('#start_date').val();
                    let endDate = $('#end_date').val();

                    if (startDate === '' && endDate === '') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Tanggal awal dan tanggal akhir harus diisi!',
                        });
                        return false;
                    }

                    if (Date.parse(startDate) > Date.parse(endDate)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Tanggal awal tidak boleh lebih besar dari tanggal akhir!',
                        });
                        return false;
                    }

                    $('#scheduleTable').DataTable().ajax.url(
                            `{{ route('doctor.schedule.index') }}?start_date=${startDate}&end_date=${endDate}`)
                        .load();
                })

                $('#month').on('change', function() {
                    $('#start_date').val('');
                    $('#end_date').val('');

                    let month = $(this).val();
                    $('#scheduleTable').DataTable().ajax.url(
                            `{{ route('doctor.schedule.index') }}?month=${month}`)
                        .load();
                });
            });
        </script>
    @endpush
</x-app-layout>
