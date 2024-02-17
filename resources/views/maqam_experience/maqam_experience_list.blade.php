@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>View Maqam Experience</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">View Maqam Experience List</li>
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
            <h1>Maqam Experience List</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Thumbnail</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($maqamExp as $exp)
                        <tr>
                            <td>{{ $exp->id }}</td>
                            <td><img src="{{ asset('maqamExpImages/' . $exp->thumbnail) }}" alt="experience Image"
                                    style="max-height: 50px; max-width: 80px"></td>
                            <td>{{ $exp->description }}</td>
                            <td>
                                <a href="{{ route('maqamExpDetail', ['expId' => $exp->id]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-pencil"
                                        aria-hidden="true"></i> Edit</a>
                                <a href="{{ route('toDeleteExp', ['expId' => $exp->id]) }}"
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
