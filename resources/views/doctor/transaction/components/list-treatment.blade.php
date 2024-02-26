@foreach ($examinationTreatments as $data)
    <div class="flex justify-between items-start mb-4">
        <div>
            <h4 class="font-semibold mb-1">{{ $data->treatment->name }}</h4>
            <p class="text-gray-500">Jumlah: {{ $data->qty }}</p>
        </div>
        <div class="flex items-center">
            <p class="text-gray-500">Rp.
                {{ number_format($data->sub_total, 0, ',', '.') }}</p>
            <div class="flex items-center gap-2 ms-2">
                <div class="flex items-center">
                    <p class="text-gray-500">Rp.
                        {{ number_format($data->sub_total, 0, ',', '.') }}</p>
                    <button type="submit" onclick="removeTreatment({{ $data->id }})"
                        class="text-red-600 hover:text-red-900 focus:ring-4 focus:outline-none ms-4 font-medium">
                        Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
@endforeach
