@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Delete Advert</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Delete Advert</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">
        {{-- Confirmation message --}}
        <p>
        <h1>Are you sure you want to delete the following advert? </h1>
        </p>

        @if ($advert)
            <div class="advert-details">
                <p><strong>Title:</strong> {{ $advert->title }}</p>
                <p><strong>Description:</strong> {{ $advert->description }}</p>
                <img src="{{ asset('advertImages/' . $advert->image) }}" alt="Advert Image"
                    style="max-width: 100%; height: 100px;">
            </div>

            <form method="POST" action="{{ route('deleteAdvert') }}">
                @csrf <!-- CSRF token for security -->
                <input type="hidden" name="advertId" value="{{ $advert->id }}">
                <button style="margin-top: 50px" type="submit" class="btn btn-danger">Delete</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/view-adverts') }}" class="btn btn-secondary" style="margin-top: 50px;">Cancel</a>
        @else
            <p>
            <h1> Advert not found.</h1>
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
