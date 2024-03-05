<x-app-layout>
    <x-breadcrumb :links="[['name' => 'Dashboard', 'url' => route('doctor.dashboard')]]" title="Dashboard" />

    <x-card-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-end">
            <x-input id="start_date" label="Tanggal Awal" type="date" name="start_date" />
            <x-input id="end_date" label="Tanggal Akhir" type="date" name="end_date" />
            <button type="button" id="buttonFilter"
                class="focus:outline-none text-white bg-gray-800 hover:bg-gray-800 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2">
                Filter Data
            </button>
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
