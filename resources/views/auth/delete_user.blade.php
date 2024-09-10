<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User Information</title>
    <!-- Add the favicon link -->
    <link rel="icon" href="{{ asset('images/maqamLogo.jpg') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

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
    <main>
        <div class="container">

            <section
                class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="d-flex justify-content-center py-4">
                                <a href="index.html" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ asset('images/maqamLogo.jpg') }}" alt="">
                                    <span class="d-none d-lg-block">Maqam App | Delete User Information</span>
                                </a>
                            </div><!-- End Logo -->

                            <div class="card mb-3">

                                <div class="card-body">

                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Delete User
                                            information</h5>
                                        <p class="text-center small">Enter your phone number to delete your information
                                        </p>
                                    </div>

                                    <form method="POST" action="{{ route('deleteUser') }}"
                                        class="row g-3 needs-validation" novalidate>
                                        @csrf
                                        <div class="col-12">
                                            <label for="phone" class="form-label">Phone</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend"><i
                                                        class="bi bi-phone"></i></span>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    required>
                                                <div class="invalid-feedback">Please enter your phone.</div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Delete</button>
                                        </div>
                                    </form>

                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </section>

        </div>
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.min.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
