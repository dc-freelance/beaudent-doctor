<x-app-layout>

    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')], ['name' => 'Daftar Antrian']]" title="Daftar Antrian" />

    {{-- <x-card-container>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <x-select id="customer" name="customer" label="Nama Pasien">
                <option value="">Semua Pasien</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                @endforeach
            </x-select>
            <x-select id="treatment" name="treatment" label="Layanan">
                <option value="">Semua Layanan</option>
                @foreach ($treatments as $treatment)
                    <option value="{{ $treatment->id }}">{{ $treatment->name }}</option>
                @endforeach
            </x-select>
            <x-input id="time" name="time" label="Waktu" type="time" name="time" />
        </div>
    </x-card-container> --}}

    <x-card-container>
        <table id="reservationTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Cabang</th>
                    <th>Layanan</th>
                    <th>Tanggal</th>
                    <th>Waktu</th>
                    <th>Pasien</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </x-card-container>

    @push('js-internal')
        <script>
            $(function() {
                $('#reservationTable').DataTable({
                    processing: true,
                    serverSide: true,
                    autoWidth: false,
                    responsive: true,
                    select: true,
                    ajax: '{{ route('doctor.queues.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'no',
                            name: 'no'
                        },
                        {
                            data: 'branch',
                            name: 'branch'
                        },
                        {
                            data: 'treatment',
                            name: 'treatment'
                        },
                        {
                            data: 'request_date',
                            name: 'request_date'
                        },
                        {
                            data: 'request_time',
                            name: 'request_time'
                        },
                        {
                            data: 'customer',
                            name: 'customer'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                });

                $('select.select-input').select2();

                // $('#customer').on('change', function() {
                //     $('#reservationTable').DataTable().ajax.url('{{ route('doctor.queues.index') }}?customer=' +
                //         $(this).val()).load();
                // });

                // $('#treatment').on('change', function() {
                //     $('#reservationTable').DataTable().ajax.url(
                //         '{{ route('doctor.queues.index') }}?treatment=' +
                //         $(this).val()).load();
                // });

                // $('#time').on('change', function() {
                //     $('#reservationTable').DataTable().ajax.url('{{ route('doctor.queues.index') }}?time=' +
                //         $(this).val()).load();
                // });
            });
        </script>
    @endpush
</x-app-layout>
