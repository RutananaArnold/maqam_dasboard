@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Delete Maqam Experience</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Delete Maqam Experience</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">
        {{-- Confirmation message --}}
        <p>
        <h1>Are you sure you want to delete the following Maqam Experience? </h1>
        </p>

        @if ($Mexperience)
            <div class="advert-details">
                <p><strong>Description:</strong> {{ $Mexperience->description }}</p>
                <p><strong>Detail:</strong> {{ $Mexperience->detail }}</p>
                <img src="{{ asset('maqamExpImages/' . $Mexperience->thumbnail) }}" alt="Image"
                    style="max-width: 100%; height: 100px;">
            </div>

            <form method="POST" action="{{ route('deleteMaqamExp') }}">
                @csrf <!-- CSRF token for security -->
                <input type="hidden" name="expId" value="{{ $Mexperience->id }}">
                <button style="margin-top: 50px" type="submit" class="btn btn-danger">Delete</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/maqam-experience-list') }}" class="btn btn-secondary" style="margin-top: 50px;">Cancel</a>
        @else
            <p>
            <h1> Maqam Experience not found.</h1>
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
