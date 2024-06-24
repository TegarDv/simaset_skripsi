<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="{!! asset('admin3') !!}/" data-template="vertical-menu-template">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ asset('') }}">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Admin - {{ \Str::ucfirst(\Str::lower($__env->yieldContent('title'))) }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('save_image/logo_apk.png') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/fonts/tabler-icons.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/css/rtl/core.css?v=12" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/css/demo.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/animate-css/animate.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/sweetalert2/sweetalert2.css" />
    <link rel="stylesheet" href="{!! asset('admin3') !!}/vendor/libs/spinkit/spinkit.css" />
    <link rel="stylesheet" href="{{ asset('bootstrap-icons-1.10.5/font/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('fontawesome-free-6.4.2-web/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('select2-bootstrap-5-theme-1.3.0/select2-bootstrap-5-theme.min.css') }}">
    @stack('cssvendor')
    <script src="{!! asset('admin3') !!}/vendor/js/helpers.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/js/template-customizer.js"></script>
    <script src="{!! asset('admin3') !!}/js/config.js"></script>
    @stack('css')
    <style>
        .menu-icon {
            font-size: 1.475rem;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 4px;
            height: 3px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .swalBtnConfirm,
        .swalBtnCancel {
            @extend .swalButton; /* Optional, leverage SweetAlert base styles */
            border: none;
            background-color: transparent;
            color: inherit;
            padding: 8px 16px; /* Adjust padding as needed */
            cursor: pointer;
            border-radius: 4px; /* Add subtle border radius */
            transition: all 0.2s ease-in-out; /* Add smooth transitions */
        }

        .swalBtnConfirm {
            color: #e3e4e6;
            background-color: #3085d6;
        }

        .swalBtnCancel {
            color: #e3e4e6;
            background-color: #d33;
        }

        .swalBtnConfirm:hover {
            background-color: rgba(48, 133, 214, 0.1); /* Add slight hover background */
        }

        .swalBtnCancel:hover {
            background-color: rgba(211, 51, 51, 0.1); /* Add slight hover background */
        }
    </style>
    <script src="{!! asset('admin3/libvelixs/velixs.js') !!}"></script>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            @include('adminv3.menu')
            <div class="layout-page">
                @include('adminv3.header')
                <div class="content-wrapper">
                    <div class="container-fluid flex-grow-1 container-p-y">
                        @yield('content')
                    </div>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
        <div class="drag-target"></div>
    </div>

    <script src="{!! asset('admin3') !!}/vendor/libs/jquery/jquery.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/popper/popper.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/js/bootstrap.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/node-waves/node-waves.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/hammer/hammer.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/i18n/i18n.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/typeahead-js/typeahead.js"></script>
    <script src="{!! asset('admin3') !!}/vendor/libs/sweetalert2/sweetalert2.js"></script>
    @stack('jsvendor')
    <script src="{!! asset('admin3') !!}/vendor/js/menu.js"></script>
    <script src="{!! asset('admin3') !!}/js/main.js"></script>
    <script src="{{ asset('select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    @if ($errors->any())
    <script>
        (function() {
            Swal.fire({
                text: '{{ $errors->first() }}',
                icon: 'error',
                showClass: {
                    popup: 'animate__animated animate__shakeX'
                },
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            })
        })()
    </script>
    @endif
    @stack('js')
</body>

</html>