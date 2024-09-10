@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>View App Bookings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View App Bookings List</li>
            </ol>
        </nav>
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
            <h1>App Bookings List</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Residence</th>
                        <th>Category</th>
                        <th>CreatedAt</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->gender }}</td>
                            <td>{{ $booking->nationality }}</td>
                            <td>{{ $booking->residence }}</td>
                            <td>{{ $booking->category }}</td>
                            <td>{{ $booking->created_at }}</td>
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
