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
                            </td>
                            <td class="px-8 text-center">

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
                                -
                            </td>
                            <td class="px-8 text-center">
                                -
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

        <div class="flex justify-center mt-6">
            <x-link-button route="{{ route('doctor.examinations.show', $examination->id) }}" color="green">
                Kembali
            </x-link-button>
        </div>
    </x-card-container>
</x-app-layout>
