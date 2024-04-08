@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Advert Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Advert Detail</li>
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

        {{-- Display advert details --}}
        <div class="advert-details">
            <img src="{{ asset('advertImages/' . $advert->image) }}" alt="Advert Image"
                style="max-width: 100%; height: auto;">

            <form method="POST" action="{{ route('updateAdvert') }}" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <input type="text" name="id" value="{{ $advert->id }}" hidden>

                <div class="form-group">
                    <label for="title">Advert Title:</label>
                    <input type="text" id="title" name="title" value="{{ $advert->title }}" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="description">Advert Description:</label>
                    <input type="text" id="description" name="description" value="{{ $advert->description }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="image">Change Advert Image (The image should be less than 1MB):</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="endDateTime">Advert End DateTime:</label>
                    <input type="datetime-local" id="endDateTime" name="endDateTime" value="{{ $advert->endDateTime }}"
                        class="form-control" required>
                </div>

                <button style="margin-top: 30px" type="submit" class="btn btn-primary">Edit Advert</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/view-adverts') }}" class="btn btn-secondary"
                style="margin-left: 500px; margin-top:30px">Cancel</a>
        </div>

    </div>
@endsection
