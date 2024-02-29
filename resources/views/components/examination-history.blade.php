@props(['examination'])

<div class="grid grid-cols-4 items-center">
    <div>
        <p>{{ date('d/m/Y', strtotime($examination->created_at)) }}</p>
        <p class="text-gray-500">
            {{ \Carbon\Carbon::parse($examination->created_at)->locale('id')->isoFormat('H:mm') }} WIB
        </p>
    </div>
    <p>{{ $examination->doctor->name }}</p>
    <p>{{ $examination->reservation->branch->name }}</p>
    <a href="{{ route('doctor.examinations.show', $examination->id) }}"
        class="text-center text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-full text-sm px-5 py-2.5 w-fit">
        Lihat Detail
    </a>
</div>
