@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Add Regular Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Regular Booking</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">

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

        <form method="POST" action="{{ route('save.booking.regular') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->

            <div class="form-group">
                <label for="name">Client Name:</label>
                <input type="text" id="name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Client phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" required>
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
                <input type="date" id="dob" name="dob" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Client Email:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="nationality">Client Nationality:</label>
                <input type="text" id="nationality" name="nationality" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="residence">Client Residence:</label>
                <input type="text" id="residence" name="residence" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="package">Package</label>
                <select class="form-control" id="packageId" name="packageId" required>
                    <option value="">Select Package</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}">{{ $package->category }} | {{ $package->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="nin_or_passport">Client NIN / Passport Number:</label>
                <input type="text" id="nin_or_passport" name="nin_or_passport" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Passport Image (The image should be less than 1MB):</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>

            <button style="margin-top: 30px" type="submit" class="btn btn-primary">Add New Regular Booking</button>
        </form>
    </div>
@endsection
