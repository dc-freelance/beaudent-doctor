<x-app-layout>
    @push('css-internal')
        <link rel="stylesheet" href="{{ asset('css/teeth.css') }}">
        <style>
            table {
                border-collapse: collapse;
                width: 100%;
            }
        </style>
    @endpush

    <x-breadcrumb :links="[
        ['name' => 'Dashboard', 'url' => route('doctor.dashboard')],
        ['name' => 'Detail Pemeriksaan', 'url' => route('doctor.examinations.show', $examination->reservation->id)],
        ['name' => 'Detail Odontogram'],
    ]" title="Detail Odontogram" />

    <x-card-container>
        <div class="relative overflow-x-auto max-w-3xl mx-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <tbody>
                    @foreach (range(11, 18) as $i)
                        <tr class="bg-white border-b">
                            <td class="text-start">
                                {{ $i }} @if ($i <= 15)
                                    [{{ $i + 40 }}]
                                @endif
                            </td>
                            <td class="px-8 text-center">
                                @if (isset($odontogramForTable[$i]))
                                    <x-row-tooth :toothNumber="$i" :data="$odontogramForTable[$i]" />
                                @endif
                                @if ($i <= 15 && isset($odontogramForTable[$i + 40]))
                                    <x-row-tooth :toothNumber="$i + 40" :data="$odontogramForTable[$i + 40]" />
                                @endif
                            </td>
                            <td class="px-8 text-center">
                                @if ($i <= 15 && isset($odontogramForTable[$i + 50]))
                                    <x-row-tooth :toothNumber="$i + 50" :data="$odontogramForTable[$i + 50]" />
                                @endif
                                @if (isset($odontogramForTable[$i + 10]))
                                    <x-row-tooth :toothNumber="$i + 10" :data="$odontogramForTable[$i + 10]" />
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($i <= 15)
                                    [{{ $i + 50 }}]
                                @endif {{ $i + 10 }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-12 pointer-events-none">
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
        <div class="relative overflow-x-auto max-w-3xl mx-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                <tbody>
                    @foreach (range(48, 41, -1) as $i)
                        <tr class="bg-white border-b">
                            <td class="text-start">
                                {{ $i }} @if ($i <= 45)
                                    [{{ $i + 40 }}]
                                @endif
                            </td>
                            <td class="px-8 text-center">
                                @if (isset($odontogramForTable[$i]))
                                    <x-row-tooth :toothNumber="$i" :data="$odontogramForTable[$i]" />,
                                @endif
                                @if ($i <= 45 && isset($odontogramForTable[$i + 40]))
                                    <x-row-tooth :toothNumber="$i + 40" :data="$odontogramForTable[$i + 40]" />
                                @endif
                            </td>
                            <td class="px-8 text-center">
                                @if ($i <= 45 && isset($odontogramForTable[$i + 30]))
                                    <x-row-tooth :toothNumber="$i + 30" :data="$odontogramForTable[$i + 30]" />
                                @endif
                                @if (isset($odontogramForTable[$i - 10]))
                                    <x-row-tooth :toothNumber="$i - 10" :data="$odontogramForTable[$i - 10]" />
                                @endif
                            </td>
                            <td class="text-end">
                                @if ($i <= 45)
                                    [{{ $i + 30 }}]
                                @endif {{ $i - 10 }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-center mt-6 space-x-2">
            <a href="{{ route('doctor.examinations.show', $examination->id) }}"
                class="bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                Kembali
            </a>
            <a href="{{ route('doctor.odontogram.create', $examination->id) }}"
                class="bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2">
                Edit Odontogram
            </a>
        </div>
    </x-card-container>
</x-app-layout>
