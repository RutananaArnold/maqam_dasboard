@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Client Booking</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Client Booking Detail</li>
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
            <div class="pagetitle d-flex justify-content-between align-items-center">
                <div>
                    <h1>Client Information</h1>
                </div>
                <div>
                    <!-- Edit client information button -->
                    <a href="" class="btn btn-primary">
                        Edit Client Information
                    </a>
                </div>
            </div>
            <table class="table table-striped">
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
                            <td><img src="{{ asset('bookingImages/' . $booking->passportPhoto) }}" alt="passport"
                                    style="max-height: 50px; max-width: 80px"></td>
                            <td> <a href="{{ route('savePassport', ['userId' => $booking->idOfUser]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-download"
                                        aria-hidden="true"></i> Download Passport</a></td>

                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 50px"></div>

            <div class="pagetitle d-flex justify-content-between align-items-center">
                <div>
                    <h1>Payment History</h1>
                </div>
                <div>
                    <!-- Add Payment button -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateBookingPayment">
                        Add Payment
                    </a>
                </div>
            </div>

            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Mode</th>
                        <th>When</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->paymentOption }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->payment_status }}</td>
                            <td>
                                <a href="#" class="btn btn-outline-warning btn-sm"
                                    data-booking_payment-id="{{ $payment->id }}"
                                    data-bookingId="{{ $payment->bookingId }}" data-bs-toggle="modal"
                                    data-bs-target="#updatePaymentStatusModal" style="width: 10em;">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Update Status </a>
                            </td>
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

            {{-- to display an existing travel document of a user --}}
            @foreach ($userBooking as $booking)
                @if ($booking->travelDocument)
                    <h1 style="margin-top: 5%">Existing Travel Document PDF</h1>
                    <div id="pdf_preview">
                        <embed src="{{ asset('travelDocuments/' . $booking->travelDocument) }}" type="application/pdf"
                            width="100%" height="600px" />
                    </div>
                @endif
            @endforeach

            <div id="pdf_preview" style="margin-top: 5%"></div>
        </div>


        <!-- Update Payment Status Modal -->
        <div class="modal fade" id="updatePaymentStatusModal" tabindex="-1" aria-labelledby="updatePaymentStatusModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePaymentStatusModalLabel">Update Payment Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('update.Payment.Status') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" name="paymentId" id="paymentId">
                            <input type="hidden" name="bookingId" id="bookingId">
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status</label>
                                <select name="payment_status" id="payment_status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="Not_received">Not Received</option>
                                    <option value="Received">Received</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of payment status modal --}}


        <!-- Update Booking Payment Modal -->
        <div class="modal fade" id="updateBookingPayment" tabindex="-1" aria-labelledby="updateBookingPaymentLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateBookingPaymentLabel">Record Booking Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('create.bookings.payment') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="text" name="bookingId" value="{{ $bookingId }}" hidden>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" name="amount" id="amount" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="paymentOption" class="form-label">Payment Option</label>
                                <select name="paymentOption" id="paymentOption" class="form-select" required>
                                    <option value="">Select Option</option>
                                    <option value="Cash">Cash</option>
                                    <option value="mtn">MTN Merchant</option>
                                    <option value="airtel">AIRTEL Merchant</option>
                                    <option value="Bank">Bank</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Create Payment Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- end of booking payment modal --}}
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const updateButtons = document.querySelectorAll('a[data-bs-target="#updatePaymentStatusModal"]');

            updateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const paymentId = this.getAttribute('data-booking_payment-id');
                    const bookingId = this.getAttribute('data-bookingId');

                    document.getElementById('paymentId').value = paymentId;
                    document.getElementById('bookingId').value = bookingId;
                });
            });
        });
    </script>
@endsection
