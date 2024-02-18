@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>View Bookings</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View Bookings List</li>
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
            <h1>Bookings List</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>name</th>
                        <th>phone</th>
                        <th>gender</th>
                        <th>nationality</th>
                        <th>residence</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->gender }}</td>
                            <td>{{ $booking->nationality }}</td>
                            <td>{{ $booking->residence }}</td>
                            <td>{{ $booking->bookingCategory }}</td>
                            <td>
                                <a href="" class="btn btn-outline-warning btn-sm" style="width: 6em;"><i
                                        class="fa fa-pencil" aria-hidden="true"></i> UPDATE</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection
