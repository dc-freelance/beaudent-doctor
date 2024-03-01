<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Jadwal Dokter', 'url' => route('doctor-schedule.index')],
    ]" title="Jadwal Dokter" />

    <x-card-container>
        <div class="mb-2">
        </div>
        <table id="reservationTable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Dokter</th>
                    <th>Nama Cabang</th>
                    <th>Tanggal Praktik</th>
                    <th>Sesi</th>
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
                    ajax: '{{ route('doctor-schedule.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'branch',
                            name: 'branch'
                        },
                        {
                            data: 'date',
                            name: 'date'
                        },
                        {
                            data: 'shift',
                            name: 'shift'
                        },
                    ]
                });
            });
        </script>
    @endpush
</x-app-layout>
