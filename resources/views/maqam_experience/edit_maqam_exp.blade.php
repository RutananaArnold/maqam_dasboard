@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Maqam Experience Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Maqam Experience Detail</li>
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
            <video controls>
                <source src="{{ $exp->videoLink }}" type="video/mp4">
                <source src="{{ $exp->videoLink }}" type="video/webm">
                <source src="{{ $exp->videoLink }}" type="video/ogg">
                Your browser does not support the video tag.
            </video>

            <img src="{{ asset('maqamExpImages/' . $exp->thumbnail) }}" alt="Advert Image"
                style="max-width: 50%; height: 50%;">

            <form method="POST" action="{{ route('editMaqamExp') }}" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <input type="text" name="id" value="{{ $exp->id }}" hidden>

                <div class="form-group">
                    <label for="description">Maqam Experience Description:</label>
                    <input type="text" id="description" name="description" value="{{ $exp->description }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="thumbnail">Change Maqam Experience Thumbnail:</label>
                    <input type="file" id="thumbnail" name="thumbnail" class="form-control">
                </div>

                <div class="form-group">
                    <label for="videoLink">Change Maqam Experience Video link:</label>
                    <input type="text" id="videoLink" name="videoLink" value="{{ $exp->videoLink }}"
                        class="form-control">
                </div>

                <div class="form-group">
                    <label for="detail">Maqam Experience Detail:</label>
                    <textarea id="detail" name="detail" class="form-control" required>{{ $exp->detail }}</textarea>
                </div>

                <button style="margin-top: 30px" type="submit" class="btn btn-primary">Edit Maqam Experience</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/maqam-experience-list') }}" class="btn btn-secondary" style="margin-left: 500px;">Cancel</a>
        </div>

    </div>
@endsection
