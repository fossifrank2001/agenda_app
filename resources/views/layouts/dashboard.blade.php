<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda .:. @yield('title', ' Dashboard')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/images/logos/favicon.png') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css" />
    <link rel="stylesheet" href="{{ asset('assets/code/jquery.datetimepicker.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}" />
    <style type="text/css">

        .left-sidebar.hidde{
            left: -270px!important;
        }
    </style>
</head>
<body>
<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
     data-sidebar-position="fixed" data-header-position="fixed">
    @include('partials.aside')
    <div class="body-wrapper bg-light min-vh-100">
        @include('partials.header')
        <div class="d-flex flex-column justify-content-between" style="padding-top: 100px!important;">
            @yield('content')
            @include('partials.footer')
        </div>
    </div>
</div>
    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src="{{asset('assets/code/jquery.datetimepicker.full.min.js')}}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>


    <!-- Affichage du Toast -->
    @if (session('success'))
        <x-utils.toast type="success" :message="session('success')" />
    @endif

    @if (session('error'))
        <x-utils.toast type="error" :message="session('error')" />
    @endif

@php
    /**
     * @var \App\Models\Activity $activity
     */
@endphp
    <script>
        /*const btn_switcher = document.querySelector('.app-header .sidebar-switcher');
        const left_side = document.querySelector('.left-sidebar')

        btn_switcher.addEventListener('click', (e) => {
            left_side.classList.toggle('hidde')
        })*/

        $(document).ready(function() {
            // Variables PHP pour les valeurs de start_time et end_time de la ressource
            var startTime = '{{ $activity?->start_time ?? '' }}';
            var endTime = '{{ $activity?->end_time ?? '' }}';

            function setSecondsToZero(dateTimeString) {
                var dateTime = new Date(dateTimeString);
                dateTime.setSeconds(0);
                return dateTime.getFullYear() + '-' +
                    ('0' + (dateTime.getMonth() + 1)).slice(-2) + '-' +
                    ('0' + dateTime.getDate()).slice(-2) + ' ' +
                    ('0' + dateTime.getHours()).slice(-2) + ':' +
                    ('0' + dateTime.getMinutes()).slice(-2) + ':00';
            }

            // Si les valeurs sont vides, utiliser la date et l'heure actuelles avec les secondes à zéro
            var currentDate = new Date();
            var currentDateString = currentDate.getFullYear() + '-' +
                ('0' + (currentDate.getMonth() + 1)).slice(-2) + '-' +
                ('0' + currentDate.getDate()).slice(-2) + ' 00:00:00';

            startTime = startTime ? setSecondsToZero(startTime) : currentDateString;
            endTime = endTime ? setSecondsToZero(endTime) : currentDateString;

            $('#start_time').datetimepicker({
                format: 'Y-m-d H:i:s',
                formatTime: 'H:i:s',
                formatDate: 'Y-m-d',
                step: 1,
                value: startTime,
                onChangeDateTime: function(dp, $input) {
                    $input.val(setSecondsToZero($input.val()));
                }
            });

            $('#end_time').datetimepicker({
                format: 'Y-m-d H:i:s',
                formatTime: 'H:i:s',
                formatDate: 'Y-m-d',
                step: 1,
                value: endTime,
                onChangeDateTime: function(dp, $input) {
                    $input.val(setSecondsToZero($input.val()));
                }
            });
        });

        $('#descriptions').summernote({
            placeholder: 'Enter description',
            tabsize: 2,
            height: 100
        });
    </script>
    <script>
        window.addEventListener('DOMContentLoaded', (event) => {
            setTimeout(function() {
                var toast = new bootstrap.Toast(document.getElementById('liveToast'));
                toast.show();
            }, 500);
        });
    </script>
@yield('scripts')
</body>
</html>
