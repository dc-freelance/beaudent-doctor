<x-app-layout>
    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')]]" title="Rekap Fee" />

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

    <div id="container"></div>

    @push('js-internal')
        <script>
            $(function() {
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
                        url: "{{ route('doctor.fee.index') }}",
                        data: {
                            start_date: startDate,
                            end_date: endDate
                        },
                        success: function(response) {
                            $('#container').html(response);
                            $('#feeTable').DataTable({
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
                        url: "{{ route('doctor.fee.index') }}",
                        data: {
                            month: month
                        },
                        success: function(response) {
                            $('#container').html(response);
                            $('#feeTable').DataTable({
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
            });
        </script>
    @endpush
</x-app-layout>
