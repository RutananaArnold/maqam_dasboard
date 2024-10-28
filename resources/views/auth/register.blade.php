@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Register New system user</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Register New system user</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @else
            <div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">Register</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('registeruser') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>

                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="phone" class="form-control" id="phone" name="phone" required>
                            </div>

                            <div class="form-group">
                                <label for="gender">Gender</label>
                                <select class="form-control" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">MALE</option>
                                    <option value="female">FEMALE</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="dob">Date of Birth:</label>
                                <input type="text" id="dob" name="dob" class="form-control"
                                    placeholder="DD/MM/YYYY" required>
                            </div>

                            <div class="form-group">
                                <label for="nationality">Nationality:</label>
                                <input type="text" id="nationality" name="nationality" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="residence">Residence:</label>
                                <input type="text" id="residence" name="residence" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="nin_or_passport">NIN / Passport Number:</label>
                                <input type="text" id="nin_or_passport" name="nin_or_passport" class="form-control"
                                    required>
                            </div>

                            <div class="form-group">
                                <label for="image">Passport Image (The image should be less than 1MB):</label>
                                <input type="file" id="image" name="image" class="form-control" required>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Confirm Password</label>
                                <input type="password" class="form-control" id="password-confirm" name="password-confirm"
                                    required>
                            </div>
                            {{-- choose role --}}
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->Role }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button style="margin-top: 50px" type="submit" class="btn btn-primary">Register</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery UI CSS and JS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $(function() {
            $("#dob").datepicker({
                dateFormat: 'dd/mm/yy',
                changeMonth: true,
                changeYear: true,
                yearRange: "1900:c" // Adjust the range as needed
            });
        });
    </script>
@endsection
