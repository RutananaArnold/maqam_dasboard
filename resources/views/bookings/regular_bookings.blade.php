@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>View Regular Bookings</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">View Regular Bookings</li>
                </ol>
            </nav>
        </div>
        <div>
            <!-- Add Booking button -->
            <a href="{{ route('add.bookings.regular') }}" class="btn btn-primary">
                Add Booking
            </a>
        </div>
    </div><!-- End Page Title -->

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

    <section class="section dashboard">
        <div class="row">
            <h1>Regular Bookings</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th>Booking Category</th>
                        <th>Package</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->created_at }}</td>
                            <td>{{ $booking->category }}</td>
                            <td>{{ $booking->title }}</td>
                            <td>
                                <a href="{{ route('showUserbooking', ['bookingId' => $booking->bookId]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 8em;"><i class="fa fa-edit"
                                        aria-hidden="true"></i> UPDATE</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection
