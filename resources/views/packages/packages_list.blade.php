@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>View Packages</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View Packages List</li>
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
            <h1>Packages List</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>image</th>
                        <th>title</th>
                        <th>category</th>
                        <th>type</th>
                        <th>dateRange</th>
                        <th>endDate</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $package->id }}</td>
                            <td><img src="{{ asset('packageImages/' . $package->packageImage) }}" alt="Package Image"
                                    style="max-height: 50px; max-width: 80px"></td>
                            <td>{{ $package->title }}</td>
                            <td>{{ $package->category }}</td>
                            <td>{{ $package->type }}</td>
                            <td>{{ $package->dateRange }}</td>
                            <td>{{ $package->endDateTime }}</td>

                            <td>
                                <a href="{{ route('packageDetails', ['packageId' => $package->id]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-pencil"
                                        aria-hidden="true"></i> Edit</a>
                                <a href="{{ route('showDeletePage', ['packageId' => $package->id]) }}"
                                    class="btn btn btn-outline-danger btn-outline btn-sm" style="width: 6em;"><i
                                        class="fa fa-trash" aria-hidden="true"></i> Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection
