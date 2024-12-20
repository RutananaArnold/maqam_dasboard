<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Maqam - Admin</title>
    <meta name="robots" content="noindex, nofollow">
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- Add the favicon link -->
    <link rel="icon" href="{{ asset('images/maqamLogo.jpg') }}" type="image/x-icon">

    {{-- Country code CSS --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Vendor CSS Files -->
    <link type="text/css" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }} " rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/boxicons/css/boxicons.min.css') }} " rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/remixicon/remixicon.css') }} " rel="stylesheet">
    <link type="text/css" href="{{ asset('vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">


</head>

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('images/maqamLogo.jpg') }}" alt="logo">
                <span class="d-none d-lg-block">MAQAM ADMIN</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        {{-- include nav bar here --}}
        @include('layouts.appbar')

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link " href="{{ route('dashboard') }} ">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-bookmark"></i><span>Bookings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('bookingsNow') }}">
                            <i class="bi bi-circle"></i><span>App Bookings</span>
                        </a>
                    </li>
                </ul>
                <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('bookings.regular') }}">
                            <i class="bi bi-circle"></i><span>Regular Bookings</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#advert-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-megaphone"></i><span>Adverts</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="advert-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('advertsList') }}">
                            <i class="bi bi-circle"></i><span>View Adverts</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('toAddAdvert') }}">
                            <i class="bi bi-circle"></i><span>Add Advert</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#packages-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-box-seam"></i><span>Packages</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="packages-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('packagesList') }}">
                            <i class="bi bi-circle"></i><span>View Packages</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('toAddPackage') }}">
                            <i class="bi bi-circle"></i><span>Add Package</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#experience-nav" data-bs-toggle="collapse"
                    href="#">
                    <i class="bi bi-camera"></i><span>Maqam Experience</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="experience-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('maqamExpList') }}">
                            <i class="bi bi-circle"></i><span>View Maqam Experiences</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('showAddMaqamExp') }}">
                            <i class="bi bi-circle"></i><span>Add Maqam Experience</span>
                        </a>
                    </li>

                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#Sonda-nav" data-bs-toggle="collapse" href="#">
                    <i class="bi bi-wallet"></i><span>Sonda Mpola</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Sonda-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="{{ route('sondaMpola.collections') }}">
                            <i class="bi bi-circle"></i><span>Sonda Mpola Accounts</span>
                        </a>
                    </li>
                </ul>
            </li>



            {{-- registration page  for those with permission to access the dashboard --}}

            @auth
                @if (auth()->user()->role == 1)
                    <li class="nav-heading">Users</li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('register') }}">
                            <i class="bi bi-person"></i>
                            <span>Register System User</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link collapsed" href="{{ route('system.users') }}">
                            <i class="bi bi-person"></i>
                            <span>System Users</span>
                        </a>
                    </li>
                @endif
            @endauth


        </ul>

    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        {{-- content in other pages --}}
        @yield('content')

    </main><!-- End #main -->


    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>MAQAM TRAVELS</span></strong>. All Rights Reserved
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('vendor/apexcharts/apexcharts.min.js') }} "></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }} "></script>
    <script src="{{ asset('vendor/chart.js/chart.umd.js') }} "></script>
    <script src="{{ asset('vendor/echarts/echarts.min.js') }} "></script>
    <script src="{{ asset('vendor/quill/quill.min.js') }} "></script>
    <script src="{{ asset('vendor/simple-datatables/simple-datatables.js') }} "></script>
    <script src="{{ asset('vendor/tinymce/tinymce.min.js') }} "></script>
    <script src="{{ asset('vendor/php-email-form/validate.js') }} "></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('js/main.js') }}"></script>


    <script async src='https://www.googletagmanager.com/gtag/js?id=G-P7JSYB1CSP'></script>
    <script>
        if (window.self == window.top) {
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());
            gtag('config', 'G-P7JSYB1CSP');
        }
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v8b253dfea2ab4077af8c6f58422dfbfd1689876627854"
        integrity="sha512-bjgnUKX4azu3dLTVtie9u6TKqgx29RBwfj3QXYt5EKfWM/9hPSAI/4qcV5NACjwAo8UtTeWefx6Zq5PHcMm7Tg=="
        data-cf-beacon='{"rayId":"80c650a02b5d4929","token":"68c5ca450bae485a842ff76066d69420","version":"2023.8.0","si":100}'
        crossorigin="anonymous"></script>
    <!-- Include jQuery and DataTables here if not already included -->
    @yield('scripts')

</body>

</html>
