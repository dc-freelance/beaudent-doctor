<div class="relative flex justify-center items-start" id="top">
    @if (array_key_exists('top', $odontogramResult) && $odontogramResult['top'])
        <img src="{{ asset('image/' . $odontogramResult['top'] . '_' . $odontogramResult['side'] . '_side' . '_top.png') }}"
            width="50" height="50" alt="" class="absolute pointer-events-none">
    @endif
</div>
<div class="relative flex justify-start" id="left">
    @if (array_key_exists('left', $odontogramResult) && $odontogramResult['left'])
        <img src="{{ asset('image/' . $odontogramResult['left'] . '_' . $odontogramResult['side'] . '_side' . '_left.png') }}"
            alt="" class="absolute pointer-events-none"
            style="height:50px; width: {{ $odontogramResult['side'] == 4 ? '20px' : '17px' }};">
    @endif
</div>
<div class="relative flex justify-center items-center">
    <img src="{{ asset('image/' . $odontogramResult['img_name']) }}" alt="" height="50" width="50"
        id="main-image">
    @if (array_key_exists('center', $odontogramResult) && $odontogramResult['center'])
        <img src="{{ asset('image/' . $odontogramResult['center'] . '_' . $odontogramResult['side'] . '_side' . '_center.png') }}"
            width="50" height="50" alt="" class="absolute pointer-events-none">
    @endif

    @if (array_key_exists('all', $odontogramResult) && $odontogramResult['all'])
        @foreach ($odontogramResult['all'] as $data)
            @if ($data['is_outside'] == 'yes')
                <img src="{{ asset('image/' . $data['diagnosis'] . '.png') }}" width="20" height="20"
                    alt="" class="absolute pointer-events-none" style="top: -17px"
                    data-outside="{{ $data['is_outside'] }}" data-modal-target="default-modal"
                    data-modal-toggle="default-modal">
            @else
                <img src="{{ asset('image/' . $data['diagnosis'] . '.png') }}" width="50" height="50"
                    alt="" class="absolute pointer-events-none" data-modal-target="default-modal"
                    data-modal-toggle="default-modal">
            @endif
        @endforeach
    @endif
</div>
<div class="relative flex justify-end" id="right">
    @if (array_key_exists('right', $odontogramResult) && $odontogramResult['right'])
        <img src="{{ asset('image/' . $odontogramResult['right'] . '_' . $odontogramResult['side'] . '_side' . '_right.png') }}"
            alt="" class="absolute pointer-events-none"
            style="height:50px; width: {{ $odontogramResult['side'] == 4 ? '20px' : '17px' }}; top: -50px">
    @endif
</div>
<div class="relative flex justify-center items-end" id="bottom">
    @if (array_key_exists('bottom', $odontogramResult) && $odontogramResult['bottom'])
        <img src="{{ asset('image/' . $odontogramResult['bottom'] . '_' . $odontogramResult['side'] . '_side' . '_bottom.png') }}"
            alt="" class="absolute pointer-events-none" width="50" height="50" alt="">
    @endif
</div>
<p id="label" class="mt-2 text-center pointer">
    {{ $odontogramResult['tooth_number'] }}
</p>
