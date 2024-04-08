@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Add Maqam Experience</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Maqam Experience</li>
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

        <form method="POST" action="{{ route('saveMaqamExp') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->

            <div class="form-group">
                <label for="thumbnail">Maqam Experience Thumbnail/Preview image (The image should be less than 1MB):</label>
                <input type="file" id="thumbnail" name="thumbnail" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="videoLink">Maqam Experience Video Link:</label>
                <input type="text" id="videoLink" name="videoLink" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="description">Maqam Experience Description:</label>
                <input type="text" id="description" name="description" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="detail">Maqam Experience Detail:</label>
                <textarea id="detail" name="detail" class="form-control" required></textarea>
            </div>

            <button style="margin-top: 30px" type="submit" class="btn btn-primary">Add Maqam Experience</button>
        </form>
    </div>
@endsection
