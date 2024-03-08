<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- icon -->
    <link rel="icon" href="{{ asset('assets/application/logo mini.jpeg') }}">

    <style>
        input[type="search"] {
            font-size: 0.75rem;
        }

        .dataTables_length label select option {
            font-size: 0.75rem;
        }

        #tableContent_filter {
            margin-bottom: 10px;
            margin-left: auto;
        }
    </style>

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/rowreorder/1.3.3/css/rowReorder.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.jqueryui.min.css">

    <!-- Flowbite -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />

    @stack('css-internal')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-xs 2xl:text-sm overflow-hidden min-h-screen">

    <div class="bg-[#F7FAFC]">
        @include('admin.layouts.sidebar')
        @include('admin.layouts.header')
        <div class="p-4 sm:ml-64 h-screen overflow-y-auto">
            <div class="p-4 mb-12">
                {{ $slot }}
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>

    <!-- Sweetalert -->
    <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('js/select2.min.js') }}"></script>

    <!-- Datatable -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/rowreorder/1.3.3/js/dataTables.rowReorder.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.jqueryui.min.js"></script>

    <!-- Flowbite -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>

    <script type="module">
        $(function() {
            $('input[data-format="nominal"]').on('input', function() {
                var value = $(this).val();
                value = value.replace(/\D/g, '');
                value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
                $(this).val(value);
            });

            $('input[type="number"]').on('input', function(e) {
                this.value = this.value.replace(/[^0-9]/g, '');
            });
        });
    </script>

    <script>
        const hiddenElements = document.querySelectorAll('[aria-hidden="true"]');
        hiddenElements.forEach(element => {
            const focusableDescendents = element.querySelectorAll(
                'a[href], button, input, select, textarea, [tabindex]:not([tabindex="-1"])');
            focusableDescendents.forEach(descendent => {
                descendent.setAttribute('tabindex', '-1');
            });
        });
    </script>

    @include('sweetalert::alert')

    @stack('js-internal')
</body>

</html>
