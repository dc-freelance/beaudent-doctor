<x-app-layout>
    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')], ['name' => 'Jadwal']]" title="Jadwal" />

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
            });
        </script>
    @endpush
</x-app-layout>
