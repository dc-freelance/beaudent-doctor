@if ($status == 'now')
    <span class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Hari Ini</span>
@elseif ($status == 'upcoming')
    <span
        class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">{{ $schedule->date->format('d M Y') }}</span>
@elseif ($status == 'done')
    <span class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Selesai</span>
@endif
