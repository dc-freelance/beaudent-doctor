<x-app-layout>
    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')]]" :title="'Selamat Datang, ' . session('doctor')->name . '!'" />

    @if ($totalWaitingList > 0)
        <div class="flex items-center p-4 mb-4 text-sm text-yellow-800 rounded-lg bg-yellow-50" role="alert">
            <i class="fas fa-info-circle me-2 w-4 h-4"></i>
            <span class="sr-only">Info</span>
            <div>
                <span class="font-medium">
                    Menunggu
                </span> - Terdapat {{ $totalWaitingList }} pasien yang menunggu untuk diperiksa hari ini! <a
                    href="{{ route('doctor.queues.index') }}" class="underline text-yellow-800 font-medium">Lihat Daftar
                    Antrian</a>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-6">
        <x-card-stat title="Total Fee" :data="'Rp ' . number_format($totalFee, 0, ',', '.')" />
        <x-card-stat title="Total Pasien" :data="$totalPatient" />
        <x-card-stat title="Total Pemeriksaan" :data="$totalExamination" />
    </div>

    <x-card-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">
            <x-input id="start_date" label="Tanggal Awal" type="date" name="start_date" />
            <x-input id="end_date" label="Tanggal Akhir" type="date" name="end_date" />
            <button type="button" id="buttonFilter"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                <i class="fas fa-filter me-2"></i>
                Filter Fee
            </button>
            <div class="flex items-end w-full">
                <div class="border-r border-gray-300 h-10 me-6"></div>
                <div class="w-full">
                    <x-input id="month" label="Filter Menurut Bulan" type="month" name="month" />
                </div>
            </div>
        </div>
    </x-card-container>

    <div id="container"></div>

    @push('js-internal')
        <script>
            $('#buttonFilter').on('click', function() {
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();

                if (startDate === '' || endDate === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Tanggal awal dan tanggal akhir harus diisi!',
                    });
                    return false;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('doctor.dashboard') }}",
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(response) {
                        $('#container').html(response);
                        $('#incomeReportTable').DataTable({
                            autoWidth: false,
                            responsive: true,
                            processing: true,
                        });
                        return false;
                    },
                    complete: () => {
                        return false;
                    }
                });
            });

            $('#month').on('change', function() {
                $('#start_date').val('');
                $('#end_date').val('');

                let month = $(this).val();

                if (month === '') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Bulan harus diisi!',
                    });
                    return false;
                }

                $.ajax({
                    type: "GET",
                    url: "{{ route('doctor.dashboard') }}",
                    data: {
                        month: month
                    },
                    success: function(response) {
                        $('#container').html(response);
                        $('#incomeReportTable').DataTable({
                            autoWidth: false,
                            responsive: true,
                            processing: true,
                        });
                        return false;
                    },
                    complete: () => {
                        return false;
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
