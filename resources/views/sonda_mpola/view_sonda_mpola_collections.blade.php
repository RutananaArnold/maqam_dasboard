@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>View Sonda Mpola</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">View Sonda Mpola</li>
                </ol>
            </nav>
        </div>
        <div>
            <!-- Create new sonda mpola button -->
            <a href="{{ route('redirect.sondaMpola.create') }}" class="btn btn-primary">
                Create New Sonda Mpola Record
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
            <h1>Sonda Mpola Records</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Created At</th>
                        <th>Reference No.</th>
                        <th>Balance</th>
                        <th>Process Status</th>
                        <th>Target Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sondaMpolas as $sondaMpola)
                        <tr>
                            <td>{{ $sondaMpola->name }}</td>
                            <td>{{ $sondaMpola->phone }}</td>
                            <td>{{ $sondaMpola->created_at }}</td>
                            <td>{{ $sondaMpola->reference }}</td>
                            <td></td>
                            <td>{{ $sondaMpola->process_status }}</td>
                            <td></td>
                            <td>
                                <a href="{{ route('sondaMpola.view.record', ['sondaMpolaId' => $sondaMpola->id]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-eye"
                                        aria-hidden="true"></i> View</a>
                                <a href="" class="btn btn-outline-warning btn-sm" style="width: 6em;"><i
                                        class="fa fa-edit" aria-hidden="true"></i> Edit</a>
                                <a href="" class="btn btn-outline-warning btn-sm" style="width: 2em;"><i
                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection
