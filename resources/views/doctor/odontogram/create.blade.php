<x-app-layout>
    @push('css-internal')
        <link rel="stylesheet" href="{{ asset('css/teeth.css') }}">
    @endpush

    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Detail Pemeriksaan', 'url' => route('doctor.examinations.show', $examination->reservation->id)],
        ['name' => 'Odontogram'],
    ]" title="Tambah Odontogram" />

    <x-card-container>
        <div class="mt-12">
            <!-- Baris 1 -->
            <div class="flex justify-center">
                <!-- kiri -->
                @foreach (range(18, 11, -1) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
                <!-- kanan -->
                @foreach (range(21, 28) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
            </div>

            <!-- Baris 2 -->
            <div class="flex justify-center">
                <!-- Baris 2 kiri -->
                @foreach (range(55, 51, -1) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
                <!-- Baris 2 kanan -->
                @foreach (range(61, 65) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
            </div>

            <!-- Baris 3 -->
            <div class="flex justify-center">
                <!-- Baris 2 kiri -->
                @foreach (range(85, 81, -1) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
                <!-- Baris 2 kanan -->
                @foreach (range(71, 75) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
            </div>

            <!-- Baris 1 -->
            <div class="flex justify-center">
                <!-- kiri -->
                @foreach (range(48, 41, -1) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
                <!-- kanan -->
                @foreach (range(31, 38) as $i)
                    @if (isset($odontogramGroup[$i]))
                        <x-tooth-with-data :toothNumber="$i" :odontogramGroup="$odontogramGroup[$i]" />
                    @else
                        <x-tooth-without-data :i="$i" />
                    @endif
                @endforeach
            </div>
        </div>

        <div class="flex justify-center mt-6">
            <x-link-button route="{{ route('doctor.examinations.show', $examination->id) }}" color="green">
                Simpan & Kembali
            </x-link-button>
        </div>
    </x-card-container>

    <x-modal>
        <div id="detailOdontogramById"></div>
        <x-select id="diagnose_id" label="Pilih Diagnosa" name="diagnose_id" class="w-full">
            <option disabled value="0" selected>Pilih Diagnosa</option>
            @foreach ($odontograms as $data)
                <option value="{{ $data->id }}" data-symbol="{{ $data->symbol }}"
                    data-placement="{{ $data->placement }}">
                    {{ $data->name . ' - ' . $data->symbol }}</option>
            @endforeach
        </x-select>
        <div class="hidden space-y-6" id="description">
            <x-select id="position" label="Pilih Bagian Gigi" name="position"></x-select>
            <x-input id="remark" label="Tindakan" name="remark" type="text" />
        </div>
    </x-modal>

    @push('js-internal')
        <script>
            $(function() {
                $('select.select-input').select2();
            });
            let declineButton = document.getElementById('decline');
            if (declineButton) {
                declineButton.addEventListener('click', function() {
                    $('#diagnose_id').val(0);
                    $('#position').html(`<option disabled selected>Pilih Posisi</option>`);
                    $('button.submit').attr('disabled', true);
                    $('#description').addClass('hidden');
                    $('#remark').val('');
                });
            }
        </script>
        <script>
            $(function() {
                function resetForm() {
                    $('#diagnose_id').val(0);
                    $('#position').html(`<option disabled selected>Pilih Posisi</option>`);
                    $('#description').addClass('hidden');
                    $('#remark').val('');
                    $('button.submit').attr('disabled', true);
                }

                let toothNumber = 0;
                let imgName = '';
                let side = '';

                $('.tooth').on('click', function() {
                    resetForm();
                    $('#detailOdontogramById').html('');

                    toothNumber = $(this).attr('id').replace('P', '');
                    imgName = $(this).find('img#main-image').attr('src');
                    side = imgName.split('/').pop().split('_').shift();

                    console.log(toothNumber, imgName, side);

                    $('#position').html('');

                    const positionOptions =
                        `<option disabled selected>Pilih Posisi</option>${side == 4 ? '' : '<option value="center">Tengah</option>'}
                    `;

                    $('#position').html(positionOptions);

                    $('#modal-header').html('Diagnosa Gigi : ' + toothNumber + ' | Sisi : ' + side);
                    $.ajax({
                        url: '{{ route('doctor.odontogram.get-by-tooth-number', ':toothNumber') }}'
                            .replace(':toothNumber', toothNumber),
                        type: 'GET',
                        data: {
                            tooth_number: toothNumber,
                            examination_id: '{{ $examination->id }}',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#detailOdontogramById').html(response);
                            return false
                        }
                    });
                });

                $('#diagnose_id').on('change', function() {
                    const placement = $(this).find('option:selected').attr('data-placement');
                    const positionOptions = placement == 'partial' ? `
                        <option disabled selected>Pilih Posisi</option>
                        <option value="top">Atas</option>
                        <option value="left">Kiri</option>
                        <option value="right">Kanan</option>
                        <option value="bottom">Bawah</option>
                        ${side != 4 ? '<option value="center">Tengah</option>' : ''}
                    ` : `
                        <option disabled selected>Pilih Posisi</option>
                        <option value="all">Semua</option>
                    `;

                    $('#position').html(positionOptions);

                    const selectedOption = $(this).val();
                    if (selectedOption != 0) {
                        $('#description').removeClass('hidden');
                    } else {
                        $('#description').addClass('hidden');
                    }
                });

                $('#position').on('change', function() {
                    const selectedOption = $(this).val();
                    if (selectedOption != 0) {
                        $('button.submit').attr('disabled', false);
                    } else {
                        $('button.submit').attr('disabled', true);
                    }
                });

                $('button.submit').on('click', function(e) {
                    e.preventDefault();
                    const diagnose_id = $('#diagnose_id').val();
                    const symbol = $('#diagnose_id option:selected').attr('data-symbol');
                    const action = $('#remark').val();
                    const position = $('#position').val();

                    if (diagnose_id == 0 || position == '') {
                        alert('Semua input harus diisi');
                        return false;
                    }

                    $.ajax({
                        url: '{{ route('doctor.odontogram.store-diagnose') }}',
                        type: 'POST',
                        data: {
                            examination_id: '{{ $examination->id }}',
                            tooth_number: toothNumber,
                            odontogram_id: diagnose_id,
                            diagnosis: symbol,
                            action: action ? action : null,
                            tooth_position: position,
                            img_name: imgName,
                            side: side,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#P' + toothNumber).html(response); // Remove this line
                        },
                        complete: function() {
                            return false;
                        }
                    });

                    return false;
                });
            });
        </script>
    @endpush
</x-app-layout>
