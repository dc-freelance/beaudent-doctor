@if ($data->isNotEmpty())
    @foreach ($data as $record)
        <div id="P{{ $record['tooth_number'] }}" data-modal-target="default-modal" data-modal-toggle="default-modal"
            class="relative mb-8 tooth mr-8">
            <a href="{{ route('doctor.odontogram.destroy-diagnose', $record['id']) }}"
                class="absolute top-0 -right-2 w-5 h-5 rounded-full bg-primary text-white z-30 flex items-center justify-center"
                id="x-button" data-confirm-delete="true">
                <i class="fas fa-times" class="text-white"></i>
            </a>
            <div class="relative flex justify-center items-start" id="top">
                @if (array_key_exists('top', $record) && $record['top'])
                    <img src="{{ asset('image/' . $record['top'] . '_' . $record['side'] . '_side' . '_top.png') }}"
                        width="50" height="50" alt="" class="absolute pointer-events-none">
                @endif
            </div>
            <div class="relative flex justify-start" id="left">
                @if (array_key_exists('left', $record) && $record['left'])
                    <img src="{{ asset('image/' . $record['left'] . '_' . $record['side'] . '_side' . '_left.png') }}"
                        alt="" class="absolute pointer-events-none"
                        style="height:50px; width: {{ $record['side'] == 4 ? '20px' : '17px' }};">
                @endif
            </div>
            <div class="relative flex justify-center items-center">
                @if (array_key_exists('center', $record) && $record['center'])
                    <img src="{{ asset('image/' . $record['center'] . '_' . $record['side'] . '_side' . '_center.png') }}"
                        width="50" height="50" alt="" class="absolute pointer-events-none">
                @endif
                <img src="{{ asset('image/' . $record['img_name']) }}" alt="" height="50" width="50">
                @if (array_key_exists('all', $record) && $record['all'])
                    @if (array_key_exists('is_outside', $record) && $record['is_outside'] == 'yes')
                        <img src="{{ asset('image/' . $record['all'] . '.png') }}" width="20" height="20"
                            alt="" class="absolute pointer-events-none" style="top: -17px"
                            data-outside="{{ $record['is_outside'] }}">
                    @else
                        <img src="{{ asset('image/' . $record['all'] . '.png') }}" width="50" height="50"
                            alt="" class="absolute pointer-events-none">
                    @endif
                @endif
            </div>
            <div class="relative flex justify-end" id="right">
                @if (array_key_exists('right', $record) && $record['right'])
                    <img src="{{ asset('image/' . $record['right'] . '_' . $record['side'] . '_side' . '_right.png') }}"
                        alt="" class="absolute pointer-events-none top-[-50px]"
                        style="height:50px; width: {{ $record['side'] == 4 ? '20px' : '17px' }};">
                @endif
            </div>
            <div class="relative flex justify-center items-end" id="bottom">
                @if (array_key_exists('bottom', $record) && $record['bottom'])
                    <img src="{{ asset('image/' . $record['bottom'] . '_' . $record['side'] . '_side' . '_bottom.png') }}"
                        alt="" class="absolute pointer-events-none" width="50" height="50"
                        alt="">
                @endif
            </div>

            <p class="uppercase font-medium">
                @if (array_key_exists('top', $record) && $record['top'])
                    {{ $record['top'] }}
                @elseif (array_key_exists('left', $record) && $record['left'])
                    {{ $record['left'] }}
                @elseif (array_key_exists('center', $record) && $record['center'])
                    {{ $record['center'] }}
                @elseif (array_key_exists('right', $record) && $record['right'])
                    {{ $record['right'] }}
                @elseif (array_key_exists('bottom', $record) && $record['bottom'])
                    {{ $record['bottom'] }}
                @elseif (array_key_exists('all', $record) && $record['all'])
                    {{ $record['all'] }}
                @endif
            </p>
        </div>
    @endforeach
@endif
