@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Add Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Package</li>
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

        <form method="POST" action="{{ route('createPackage') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->

            <div class="form-group">
                <label for="title">Package Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="dateRange">Package DateRange:</label>
                <input type="text" id="dateRange" name="dateRange" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="image">Package Image:</label>
                <input type="file" id="image" name="image" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Package Price:</label>
                <input type="text" id="price" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="endDateTime">Package End DateTime:</label>
                <input type="datetime-local" id="endDateTime" name="endDateTime" class="form-control" required>
            </div>

            <button style="margin-top: 30px" type="submit" class="btn btn-primary">Add New Package</button>
        </form>
    </div>
@endsection
