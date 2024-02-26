<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teeth App</title>
    <link rel="stylesheet" href="{{ asset('css/teeth.css') }}">
</head>

<body>
    <div id="odontogram">
        <div class="cuadrant">
            @for ($i = 18; $i >= 11; $i--)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 13 ? '1' : '0' }}" />
            @endfor
            @for ($i = 21; $i <= 28; $i++)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 23 ? '1' : '0' }}" />
            @endfor
        </div>
        <br>
        <div class="cuadrant">
            @for ($i = 55; $i >= 51; $i--)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 53 ? '1' : '0' }}" />
            @endfor
            @for ($i = 61; $i <= 65; $i++)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 63 ? '1' : '0' }}" />
            @endfor
        </div>
        <br>
        <div class="cuadrant">
            @for ($i = 85; $i >= 81; $i--)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 83 ? '1' : '0' }}" />
            @endfor
            @for ($i = 71; $i <= 75; $i++)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 73 ? '1' : '0' }}" />
            @endfor
        </div>
        <br>
        <div class="cuadrant">
            @for ($i = 48; $i >= 41; $i--)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 43 ? '1' : '0' }}" />
            @endfor
            @for ($i = 31; $i <= 38; $i++)
                <x-teeth label="{{ $i }}" number="{{ $i }}" left="1" right="1"
                    top="1" bottom="1" center="{{ $i > 33 ? '1' : '0' }}" />
            @endfor
        </div>
    </div>

    <script>
        const teeth = document.querySelectorAll('.tooth');
        teeth.forEach(tooth => {
            tooth.addEventListener('click', e => {
                const side = e.target.dataset.side;
                const toothId = tooth.dataset.id;
                alert(`Tooth ${toothId} was clicked on the ${side} side`);
            });
        });
    </script>
</body>

</html>
