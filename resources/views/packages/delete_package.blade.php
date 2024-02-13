@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Delete Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Delete Package</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">
        {{-- Confirmation message --}}
        <p>
        <h1>Are you sure you want to delete the following Package? </h1>
        </p>

        @if ($package)
            <div class="advert-details">
                <p><strong>Title:</strong> {{ $package->title }}</p>
                <p><strong>DateRange:</strong> {{ $package->dateRange }}</p>
                <p><strong>Price:</strong> {{ $package->price }}</p>
                <img src="{{ asset('packageImages/' . $package->image) }}" alt="package Image"
                    style="max-width: 100%; height: 100px;">
            </div>

            <form method="POST" action="{{ route('packageDelete') }}">
                @csrf <!-- CSRF token for security -->
                <input type="hidden" name="packageId" value="{{ $package->id }}">
                <button style="margin-top: 50px" type="submit" class="btn btn-danger">Delete</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/view-packages') }}" class="btn btn-secondary" style="margin-top: 50px;">Cancel</a>
        @else
            <p>
            <h1> Package not found.</h1>
            </p>
        @endif

        {{-- Display success or error message --}}
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
    </div>
@endsection
