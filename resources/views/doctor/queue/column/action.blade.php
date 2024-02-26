<div class="lg:flex gap-x-2">
    @if (isset($data->examination))
        <a href="{{ route('doctor.examinations.show', $data->examination->id) }}"
            class="text-white bg-blue-500 focus:ring-4 focus:outline-none font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
            <span>Detail</span>
        </a>
    @else
        <a href="{{ route('doctor.examinations.create', $data->id) }}"
            class="text-white bg-green-500 focus:ring-4 focus:outline-none font-medium rounded-md text-sm p-2 text-center inline-flex items-center">
            <span>Pemeriksaan</span>
        </a>
    @endif
</div>
