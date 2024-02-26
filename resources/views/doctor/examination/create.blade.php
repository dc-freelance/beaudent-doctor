<x-app-layout>

    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Daftar Antrian', 'url' => route('doctor.queues.index')],
        ['name' => 'Pemeriksaan Pasien'],
    ]" title="Pemeriksaan Pasien" />

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <div class="h-[36rem] overflow-y-auto lg:col-span-3">
            <x-card-container>
                <h3 class="text-sm font-semibold text-gray-800">PEMERIKSAAN</h3>
                <hr class="my-6">
                <h3 class="text-xs text-gray-500 font-semibold uppercase mb-6">DATA MEDIK YANG PERLU DIPERHATIKAN</h3>
                <form action="{{ route('doctor.examinations.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                    <input type="hidden" name="medical_record_id" value="{{ $medicalRecord->id }}">
                    <input type="hidden" name="customer_id" value="{{ $reservation->customer->id }}">
                    <input type="hidden" name="doctor_id" value="{{ $doctor->id }}">
                    <x-select id="blood_type" label="Golongan Darah" name="blood_type" required>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="AB">AB</option>
                        <option value="O">O</option>
                    </x-select>
                    <div>
                        <p class="uppercase font-semibold text-xs mb-4">Tekanan Darah</p>
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <x-input id="systolic_blood_pressure" label="Sistolik" type="number"
                                name="systolic_blood_pressure" required />
                            <x-input id="diastolic_blood_pressure" label="Diastolik" type="number"
                                name="diastolic_blood_pressure" required />
                        </div>
                    </div>
                    <x-select id="heart_disease" label="Riwayat Penyakit Jantung" name="heart_disease" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="diabetes" label="Riwayat Penyakit Diabetes" name="diabetes" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="blood_clotting_disorder" label="Riwayat Kelainan Pembekuan Darah"
                        name="blood_clotting_disorder" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="hepatitis" label="Riwayat Penyakit Hepatitis" name="hepatitis" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="digestive_diseases" label="Riwayat Penyakit Saluran Pencernaan"
                        name="digestive_diseases" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="other_diseases" label="Riwayat Penyakit Lainnya" name="other_diseases" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <x-select id="allergies_to_medicines" label="Alergi Obat" name="allergies_to_medicines" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <div class="hidden" id="medication_field">
                        <x-input id="medications" label="Obat-obatan" type="text" name="medications" />
                    </div>
                    <x-select id="allergies_to_food" label="Alergi Makanan" name="allergies_to_food" required>
                        <option value="0" selected>Tidak</option>
                        <option value="1">Ya</option>
                    </x-select>
                    <div class="hidden" id="foods_field">
                        <x-input id="foods" label="Makanan" type="text" name="foods" />
                    </div>
                    <div class="flex w-full">
                        <x-button type="submit" color="green">
                            Simpan Hasil Pemeriksaan
                        </x-button>
                    </div>
                </form>
            </x-card-container>
        </div>
    </div>

    @push('js-internal')
        <script>
            $(function() {
                $('#allergies_to_medicines').on('change', function() {
                    if ($(this).val() == 1) {
                        $('#medication_field').removeClass('hidden');
                        $('#medications').attr('required', true);
                    } else {
                        $('#medication_field').addClass('hidden');
                        $('#medications').attr('required', false);
                    }
                });

                $('#allergies_to_food').on('change', function() {
                    if ($(this).val() == 1) {
                        $('#foods_field').removeClass('hidden');
                        $('#foods').attr('required', true);
                    } else {
                        $('#foods_field').addClass('hidden');
                        $('#foods').attr('required', false);
                    }
                });

                $('select').select2({
                    width: '100%',
                });
            });
        </script>
    @endpush
</x-app-layout>
