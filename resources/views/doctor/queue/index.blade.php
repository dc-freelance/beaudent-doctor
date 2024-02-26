<x-app-layout>

    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')], ['name' => 'Daftar Antrian']]" title="Daftar Antrian" />

    <x-card-container>
        <table id="reservationTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>No</th>
                    <th>Cabang</th>
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
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
