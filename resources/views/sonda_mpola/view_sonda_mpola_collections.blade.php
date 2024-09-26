@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle d-flex justify-content-between align-items-center">
        <div>
            <h1>View Sonda Mpola Accounts</h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">View Sonda Mpola Accounts</li>
                </ol>
            </nav>
        </div>
        <div>
            <!-- Create new sonda mpola button -->
            <a href="{{ route('redirect.sondaMpola.create') }}" class="btn btn-primary">
                Create Account
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

    <style>
        .clickable-name {
            text-decoration: none;
            color: inherit;
            /* Inherit color from parent */
        }

        .clickable-name:hover {
            color: blue;
            /* Change color on hover */
        }
    </style>

    <section class="section dashboard">
        <div class="row">
            <h1>Sonda Mpola Accounts</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Created</th>
                        <th>Reference No.</th>
                        <th>Amount Deposited Uptodate</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sondaMpolas as $sondaMpola)
                        <tr>
                            <td>
                                <a href="{{ route('sondaMpola.view.record', ['sondaMpolaId' => $sondaMpola->id]) }}"
                                    class="clickable-name">
                                    {{ $sondaMpola->name }}
                                </a>
                            </td>
                            <td>{{ $sondaMpola->phone }}</td>
                            <td>{{ $sondaMpola->created_at }}</td>
                            <td>{{ $sondaMpola->reference }}</td>
                            <td>UGX {{ number_format($sondaMpola->total_amount_saved) }}</td>
                            <td>{{ $sondaMpola->process_status }}</td>
                            <td>{{ $sondaMpola->target_amount_status }}</td>
                            <td>
                                <a href="{{ route('sondaMpola.view.record', ['sondaMpolaId' => $sondaMpola->id]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 4em;"><i class="fa fa-eye"
                                        aria-hidden="true"></i> </a>
                                {{-- <a href="" class="btn btn-outline-warning btn-sm" style="width: 6em;"><i
                                        class="fa fa-edit" aria-hidden="true"></i> Edit</a> --}}
                                <a href="" class="btn btn-outline-warning btn-sm" style="width: 4em;"><i
                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </section>
@endsection
