@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Sonda Mpola Record</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Sonda Mpola Record Detail</li>
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
            <div class="pagetitle">
                <div>
                    <h1>Client Information</h1>
                </div>
            </div>

            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="sondaMpolaTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="account-tab" data-bs-toggle="tab" href="#account" role="tab"
                        aria-controls="account" aria-selected="false">Account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="applicant-details-tab" data-bs-toggle="tab" href="#applicant-details"
                        role="tab" aria-controls="applicant-details" aria-selected="true">Applicant Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="bio-data-tab" data-bs-toggle="tab" href="#bio-data" role="tab"
                        aria-controls="bio-data" aria-selected="false">Bio Data</a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="sondaMpolaTabContent">
                <!-- Account Tab -->
                <div class="tab-pane fade" id="account" role="tabpanel" aria-labelledby="account-tab">
                    <table class="table table-striped">
                        <tr>
                            <th>Name:</th>
                            <td>{{ $sondaMpolaRecord->name }}</td>
                        </tr>
                        <tr>
                            <th>Reference:</th>
                            <td>{{ $sondaMpolaRecord->reference }}</td>
                        </tr>
                        <tr>
                            <th>Target:</th>
                            <td>{{ $sondaMpolaRecord->umrahSavingTarget ?? $sondaMpolaRecord->hajjSavingTarget }}</td>
                        </tr>
                        <tr>
                            <th>Target Amount:</th>
                            <td>UGX {{ number_format($sondaMpolaRecord->targetAmount) }}</td>
                        </tr>

                    </table>
                </div>

                <!-- Applicant Details Tab -->
                <div class="tab-pane fade show active" id="applicant-details" role="tabpanel"
                    aria-labelledby="applicant-details-tab">
                    <table class="table table-striped">
                        <tr>
                            <th>Identification Type:</th>
                            <td>{{ $sondaMpolaRecord->identificationType }}</td>
                        </tr>
                        <tr>
                            <th>NIN / passport:</th>
                            <td>{{ $sondaMpolaRecord->nin_or_passport }}</td>
                        </tr>
                        <tr>
                            <th>Date Of Expiry:</th>
                            <td>{{ $sondaMpolaRecord->dateOfExpiry }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $sondaMpolaRecord->phone }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $sondaMpolaRecord->email }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Bio Data Tab -->
                <div class="tab-pane fade" id="bio-data" role="tabpanel" aria-labelledby="bio-data-tab">
                    <table class="table table-striped">
                        <tr>
                            <th>Gender:</th>
                            <td>{{ $sondaMpolaRecord->gender }}</td>
                        </tr>
                        <tr>
                            <th>occupation:</th>
                            <td>{{ $sondaMpolaRecord->occupation }}</td>
                        </tr>
                        <tr>
                            <th>position:</th>
                            <td>{{ $sondaMpolaRecord->position }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth:</th>
                            <td>{{ $sondaMpolaRecord->dob }}</td>
                        </tr>
                        <tr>
                            <th>Place of Birth:</th>
                            <td>{{ $sondaMpolaRecord->placeOfBirth }}</td>
                        </tr>
                        <tr>
                            <th>fatherName:</th>
                            <td>{{ $sondaMpolaRecord->fatherName }}</td>
                        </tr>
                        <tr>
                            <th>motherName:</th>
                            <td>{{ $sondaMpolaRecord->motherName }}</td>
                        </tr>
                        <tr>
                            <th>maritalStatus:</th>
                            <td>{{ $sondaMpolaRecord->maritalStatus }}</td>
                        </tr>
                        <tr>
                            <th>country:</th>
                            <td>{{ $sondaMpolaRecord->country }}</td>
                        </tr>
                        <tr>
                            <th>Nationality:</th>
                            <td>{{ $sondaMpolaRecord->nationality }}</td>
                        </tr>
                        <tr>
                            <th>residence:</th>
                            <td>{{ $sondaMpolaRecord->residence }}</td>
                        </tr>
                        <tr>
                            <th>district:</th>
                            <td>{{ $sondaMpolaRecord->district }}</td>
                        </tr>
                        <tr>
                            <th>county:</th>
                            <td>{{ $sondaMpolaRecord->county }}</td>
                        </tr>
                        <tr>
                            <th>subcounty:</th>
                            <td>{{ $sondaMpolaRecord->subcounty }}</td>
                        </tr>
                        <tr>
                            <th>parish:</th>
                            <td>{{ $sondaMpolaRecord->parish }}</td>
                        </tr>
                        <tr>
                            <th>village:</th>
                            <td>{{ $sondaMpolaRecord->village }}</td>
                        </tr>
                        <tr>
                            <th>nextOfKin:</th>
                            <td>{{ $sondaMpolaRecord->nextOfKin }}</td>
                        </tr>
                        <tr>
                            <th>relationship:</th>
                            <td>{{ $sondaMpolaRecord->relationship }}</td>
                        </tr>
                        <tr>
                            <th>nextOfKinAddress:</th>
                            <td>{{ $sondaMpolaRecord->nextOfKinAddress }}</td>
                        </tr>
                        <tr>
                            <th>mobileNo:</th>
                            <td>{{ $sondaMpolaRecord->mobileNo }}</td>
                        </tr>
                        <tr>
                            <th>Passport Photo:</th>
                            <td><img src="{{ asset('sondaMpola/' . $sondaMpolaRecord->image) }}" alt="passport"
                                    style="max-height: 50px; max-width: 80px"></td>
                        </tr>
                    </table>
                </div>
            </div>


            <div class="mt-5"></div>

            <div class="pagetitle d-flex justify-content-between align-items-center">
                <div>
                    <h1>Payment History</h1>
                </div>
                <div>
                    <!-- Add Payment button -->
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#newSondaMpolaPayment">
                        Add Payment
                    </a>
                </div>
            </div>

            <table class="table datatable">
                <thead>
                    <tr>
                        <th>Paid (UGX)</th>
                        <th>Mode</th>
                        <th>Created at</th>
                        <th>Target</th>
                        <th>Balance</th>
                        <th>Receipted By</th>
                        <th>Issued By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payments as $payment)
                        <tr>
                            <td>{{ $payment->amount }}</td>
                            <td>{{ $payment->payment_option }}</td>
                            <td>{{ $payment->created_at }}</td>
                            <td>{{ $payment->umrahSavingTarget ?? $payment->hajjSavingTarget }}</td>
                            <td>UGX {{ number_format($payment->balance) }}</td>
                            <td>{{ $payment->receipted_by_name }}</td>
                            <td>{{ $payment->issued_by_name }}</td>
                            <td>
                                {{-- update payment status and target amount status --}}
                                <a href="#" class="btn btn-outline-warning btn-sm"
                                    data-payment-id="{{ $payment->id }}" data-bs-toggle="modal"
                                    data-bs-target="#updatePaymentStatusModal" style="width: 10em;">
                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                    Update Status </a>
                                {{-- download receipt --}}
                                <a href="{{ route('sondaMpola.receipt.download', ['paymentId' => $payment->id, 'authId' => auth()->user()->id, 'sondaMpolaId' => $sondaMpolaId]) }}"
                                    class="btn btn-outline-warning btn-sm" style="width: 6em;"><i class="fa fa-download"
                                        aria-hidden="true"></i> Receipt</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Update Payment Status Modal -->
        <div class="modal fade" id="updatePaymentStatusModal" tabindex="-1" aria-labelledby="updatePaymentStatusModalLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updatePaymentStatusModalLabel">Update Payment Status and Target Amount
                            Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('sondaMpola.payment.status.update') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="text" name="paymentId" id="paymentId" hidden>
                            <input type="text" name="sondaMpolaId" value="{{ $sondaMpolaId }}" hidden>
                            <div class="mb-3">
                                <label for="payment_status" class="form-label">Payment Status (Was Payment Received
                                    ?)</label>
                                <select name="payment_status" id="payment_status" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="Not_received">Not Received</option>
                                    <option value="Received">Received</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="targetAmountStatus" class="form-label">Target Amount Status</label>
                                <select name="targetAmountStatus" id="targetAmountStatus" class="form-select" required>
                                    <option value="">Select Status</option>
                                    <option value="on_going">On going</option>
                                    <option value="refund">Refund</option>
                                    <option value="un_finished">Un finished</option>
                                    <option value="complete">Complete</option>
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


        <!-- new sonda mpola Payment Modal -->
        <div class="modal fade" id="newSondaMpolaPayment" tabindex="-1" aria-labelledby="newSondaMpolaPaymentLabel"
            aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="newSondaMpolaPaymentLabel">Record Sonda Mpola Payment</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('sondaMpola.payment.save') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <input type="text" name="authId" value="{{ auth()->user()->id }}" hidden>
                            <input type="text" name="sondaMpolaId" value="{{ $sondaMpolaId }}" hidden>

                            <div class="mb-3">
                                <label for="amount" class="form-label">Amount (without commas)</label>
                                <input type="text" name="amount" id="amount" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="currency" class="form-label">Currency</label>
                                <select name="currency" id="currency" class="form-select" required
                                    onchange="toggleCurrency()">
                                    <option value="">Select Option</option>
                                    <option value="UGX">UGX</option>
                                    <option value="USD">USD</option>
                                </select>
                            </div>

                            <div class="mb-3" id="rate" style="display: none;">
                                <label for="rate" class="form-label">rate (without commas)</label>
                                <input type="text" name="rate" id="rate" class="form-control">
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
        document.addEventListener('DOMContentLoaded', function() {
            const updateButtons = document.querySelectorAll('a[data-bs-target="#updatePaymentStatusModal"]');

            updateButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const paymentId = this.getAttribute('data-payment-id');

                    document.getElementById('paymentId').value = paymentId;
                });
            });
        });
    </script>

    <script>
        function toggleCurrency() {
            var currency = document.getElementById("currency").value;
            document.getElementById("rate").style.display = (currency === "USD") ? "block" : "none";
        }
    </script>
@endsection
