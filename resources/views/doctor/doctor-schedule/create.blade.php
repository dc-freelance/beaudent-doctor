<x-app-layout>
    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('admin.dashboard.index')],
        ['name' => 'Manajemen Jadwal Dokter', 'url' => route('admin.doctor-schedule.index')],
        ['name' => 'Tambah Jadwal Dokter', 'url' => ''],
    ]" title="Tambah Jadwal Dokter" />

    <div class="lg:w-1/2">
        <x-card-container>
            <form action="{{ route('admin.doctor-schedule.store') }}" method="POST">
                @csrf
                <div class="space-y-6">
                    <div>
                        <p>Pilih Dokter</p>
                        <div class="mt-1">
                            <x-select id="doctor_id" name="doctor_id[]"
                                class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md"
                                multiple>
                                @foreach ($doctor as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </x-select>
                        </div>
                    </div>
                    <div>
                        <p>Pilih Cabang</p>
                        <div class="mt-1">
                            <select id="branch_id" name="branch_id"
                                class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                                @foreach ($branch as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <x-input id="date" label="Tgl. Praktik" name="date" type="date" required />
                    <div>
                        <p>Sesi</p>
                        <div class="mt-1">
                            <select id="shift" name="shift"
                                class="block w-full py-2 pl-3 pr-10 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                                <option value="Pagi">Pagi</option>
                                <option value="Sore">Sore</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="max-md:w-full md:w-1/2 lg:w-1/3 xl:w-1/3 pt-5">
                    <x-button type="submit">Tambah Jadwal Dokter</x-button>
                </div>
            </form>
        </x-card-container>
    </div>
</x-app-layout>
