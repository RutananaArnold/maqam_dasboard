@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>User Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Booking Detail</li>
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
            <h1>Client Information</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Nationality</th>
                        <th>Residence</th>
                        <th>NIN/Passport</th>
                        <th>Passport</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($userBooking as $booking)
                        <tr>
                            <td>{{ $booking->name }}</td>
                            <td>{{ $booking->email }}</td>
                            <td>{{ $booking->phone }}</td>
                            <td>{{ $booking->nationality }}</td>
                            <td>{{ $booking->residence }}</td>
                            <td>{{ $booking->NIN_or_Passport }}</td>
                            <td><img src="{{ asset('bookingImages/' . $booking->passportPhoto) }}" alt="Advert Image"
                                    style="max-height: 50px; max-width: 80px"></td>
                            <td> <a href="{{ route('savePassport', ['userId' => $booking->idOfUser]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-pencil"
                                        aria-hidden="true"></i> Download Passport</a></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h1>Payment History</h1>
            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>When</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->paymentOption }}</td>
                            <td>{{ $payment->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- pdf upload form --}}
            <h1>Attach Client Travel Document</h1>
            <form action="{{ route('uploadTravelDocument') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="text" name="bookingId" value="{{ $bookingId }}" hidden>

                <input type="file" name="pdf_file" id="pdf_file" required>

                <button type="submit"
                    style="background-color: blue; color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px;">Upload
                    PDF</button>
            </form>

            <div id="pdf_preview" style="margin-top: 5%"></div>
        </div>

    </section>

    <script>
        document.getElementById('pdf_file').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const pdf_preview = document.getElementById('pdf_preview');
                pdf_preview.innerHTML = `
                    <embed src="${e.target.result}" type="application/pdf" width="100%" height="600px" />
                `;
            };

            reader.readAsDataURL(file);
        });
    </script>
@endsection
