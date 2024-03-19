@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Package Detail</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Package Detail</li>
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

        {{-- Display package details --}}
        <div class="advert-details">
            <img src="{{ asset('packageImages/' . $package->packageImage) }}" alt="Package Image"
                style="max-width: 100%; height: auto;">

            <form method="POST" action="{{ route('packageUpdate') }}" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->

                <input type="text" name="id" value="{{ $package->id }}" hidden>

                <div class="form-group">
                    <label for="title">Package Title:</label>
                    <input type="text" id="title" name="title" value="{{ $package->title }}" class="form-control"
                        required>
                </div>

                <div class="form-group">
                    <label for="title">Package Description:</label>
                    <textarea id="description" name="description" class="form-control"> {{ $package->description }} </textarea>
                </div>

                <div class="form-group">
                    <label for="description">Package DateRange:</label>
                    <input type="text" id="dateRange" name="dateRange" value="{{ $package->dateRange }}"
                        class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="price">Package Type and Price:</label>
                    <input type="text" id="price" name="price"
                        value="{{ $package->type }} - Standard Price: {{ $package->standardPrice }}, Economy Price: {{ $package->economyPrice }}"
                        class="form-control" readonly>
                </div>


                <div class="form-group">
                    <label for="image">Change Package Image:</label>
                    <input type="file" id="image" name="image" class="form-control">
                </div>

                <div class="form-group">
                    <label for="endDateTime">Package End DateTime:</label>
                    <input type="datetime-local" id="endDateTime" name="endDateTime" value="{{ $package->endDateTime }}"
                        class="form-control" required>
                </div>

                <button style="margin-top: 30px" type="submit" class="btn btn-primary">Edit Package</button>
            </form>

            <!-- Cancel button -->
            <a href="{{ url('/view-packages') }}" class="btn btn-secondary"
                style="margin-left: 500px; margin-top:30px">Cancel</a>
        </div>

    </div>
@endsection
