<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('public/fonts/Roboto/Roboto.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/perfect-scrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/index.css') }}">
</head>
<body class="@yield('bodyclass')">
    <div class="js-popup-openers d-none"></div>
    <div id="popup" class="hidden"></div>
    <div class="popup_stack">
        @include('public.layouts.parts.popupStack')
    </div>
    <header>
        @include('public.layouts.parts.header')
    </header>
    <main class="@yield('mainclass')">
        @yield('content')
    </main>
    <script>
        var user = {
            api_token: "{{ isset($currentUser) ? $currentUser->api_token : '' }}"
        };
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.12/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('public/js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('public/js/datepicker.min.js') }}"></script>
    <script src="{{ asset('public/js/date.format.js') }}"></script>
    <script src="{{ asset('public/js/datetime.js') }}"></script>
    <script src="{{ asset('public/js/index.js') }}"></script>
</body>
</html>