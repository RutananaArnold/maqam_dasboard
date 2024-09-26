@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Create Sonda Mpola Account</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Create Sonda Mpola Account</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="form-container">

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
            .iti {
                width: 100%;
            }
        </style>

        <form id="multiStepForm" method="POST" action="{{ route('sondaMpola.save') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->
            <input type="text" name="authId" value="{{ auth()->user()->id }}" hidden>
            <!-- Step 1: Applicant Details -->
            <div id="step1" class="form-step">
                <h1>Applicant Details</h1>
                <div class="form-group">
                    <label for="name">Client Name:</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="identificationType">Identification Type</label>
                    <select class="form-control" id="identificationType" name="identificationType" required>
                        <option value="">Identification Type</option>
                        <option value="NIN">NIN</option>
                        <option value="passport">Passport</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nin_or_passport">Client NIN / Passport Number:</label>
                    <input type="text" id="nin_or_passport" name="nin_or_passport" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="dateOfExpiry">Date of Expiry:</label>
                    <input type="date" id="dateOfExpiry" name="dateOfExpiry" class="form-control" required>
                </div>

                <!-- Collapsible Section -->
                <div class="form-group collapsible">
                    <h5>Contact Information</h5>
                    <div class="collapsible-content">
                        <div class="form-group">
                            <label for="phone">Client phone:</label>
                            <input type="text" id="phone" name="phone" value="756xxxxxx" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="otherPhone">Client other Phone:</label>
                            <input type="text" id="otherPhone" name="otherPhone" value="756xxxxxx" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">Client Email:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Step 2: Saving Target -->
            <div id="step2" class="form-step" style="display:none;">
                <h1>Saving Target</h1>
                <div class="form-group">
                    <label for="savingFor">Saving For</label>
                    <select class="form-control" id="savingFor" name="savingFor" required onchange="toggleSavingTarget()">
                        <option value="">Saving For</option>
                        <option value="Umrah">Umrah</option>
                        <option value="Hajj">Hajj</option>
                    </select>
                </div>

                <!-- Umrah target -->
                <div class="form-group" id="umrahTarget" style="display: none;">
                    <label for="umrahSavingTarget">Estimated Umrah Saving Target</label>
                    <select class="form-control" id="umrahSavingTarget" name="umrahSavingTarget">
                        <option value="">Umrah Saving Target</option>
                        <option value="Ramadhan_13200000">Ramadhan - 13,200,000</option>
                        <option value="December_10300000">December - 10,300,000</option>
                        <option value="otherMonths_8400000">Other Months - 8,400,000</option>
                    </select>
                </div>

                <!-- Hajj target -->
                <div class="form-group" id="hajjTarget" style="display: none;">
                    <label for="hajjSavingTarget">Estimated Hajj Saving Target</label>
                    <select class="form-control" id="hajjSavingTarget" name="hajjSavingTarget">
                        <option value="">Hajj Saving Target</option>
                        <option value="Class_A_31800000">Class A - 31,800,000</option>
                        <option value="Class_B_21500000">Class B - 21,500,000</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="targetAmount">Target Amount (UGX without commas):</label>
                    <input type="text" id="targetAmount" name="targetAmount" class="form-control" required>
                </div>
            </div>

            <!-- Step 3: Bio Data -->
            <div id="step3" class="form-step" style="display:none;">
                <h1>Bio Data</h1>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="male">MALE</option>
                        <option value="female">FEMALE</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="occupation">Client occupation:</label>
                    <input type="text" id="occupation" name="occupation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="position">Client position:</label>
                    <input type="text" id="position" name="position" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="dob">Date of Birth:</label>
                    <input type="date" id="dob" name="dob" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="placeOfBirth">Place of Birth:</label>
                    <input type="text" id="placeOfBirth" name="placeOfBirth" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="fatherName">Father's name:</label>
                    <input type="text" id="fatherName" name="fatherName" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="motherName">Mother's name:</label>
                    <input type="text" id="motherName" name="motherName" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="maritalStatus">Marital Status:</label>
                    <input type="text" id="maritalStatus" name="maritalStatus" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="country">Country:</label>
                    <input type="text" id="country" name="country" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nationality">Nationality:</label>
                    <input type="text" id="nationality" name="nationality" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="residence">Residence:</label>
                    <input type="text" id="residence" name="residence" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="district">District:</label>
                    <input type="text" id="district" name="district" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="county">County:</label>
                    <input type="text" id="county" name="county" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="subcounty">Sub County:</label>
                    <input type="text" id="subcounty" name="subcounty" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="parish">Parish:</label>
                    <input type="text" id="parish" name="parish" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="village">Village:</label>
                    <input type="text" id="village" name="village" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nextOfKin">Next Of Kin:</label>
                    <input type="text" id="nextOfKin" name="nextOfKin" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="relationship">Relationship:</label>
                    <input type="text" id="relationship" name="relationship" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nextOfKinAddress">Next Of Kin Address:</label>
                    <input type="text" id="nextOfKinAddress" name="nextOfKinAddress" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="mobileNo">Next Of Kin Mobile No:</label>
                    <input type="text" id="mobileNo" name="mobileNo" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="image">Passport Image (The image should be less than 1MB):</label>
                    <input type="file" id="image" name="image" class="form-control" required>
                </div>
            </div>

            <div class="mt-4"></div>

            <div class="form-navigation">
                <button type="button" id="prevBtn" onclick="prevStep()" class="btn btn-secondary"
                    style="display: none;">Previous</button>
                <button type="button" id="nextBtn" onclick="nextStep()" class="btn btn-primary">Next</button>
                <button type="submit" id="submitBtn" class="btn btn-success" style="display: none;">Submit</button>
            </div>
        </form>
    </div>

    <script>
        var currentStep = 1;

        function showStep(step) {
            document.getElementById("step" + currentStep).style.display = "none";
            document.getElementById("step" + step).style.display = "block";
            currentStep = step;
            updateButtons();
        }

        function nextStep() {
            showStep(currentStep + 1);
        }

        function prevStep() {
            showStep(currentStep - 1);
        }

        function updateButtons() {
            document.getElementById("prevBtn").style.display = (currentStep > 1) ? "inline-block" : "none";
            document.getElementById("nextBtn").style.display = (currentStep < 3) ? "inline-block" : "none";
            document.getElementById("submitBtn").style.display = (currentStep === 3) ? "inline-block" : "none";
        }

        function toggleSavingTarget() {
            var savingFor = document.getElementById("savingFor").value;
            document.getElementById("umrahTarget").style.display = (savingFor === "Umrah") ? "block" : "none";
            document.getElementById("hajjTarget").style.display = (savingFor === "Hajj") ? "block" : "none";
        }

        // Collapsible section script
        document.querySelectorAll('.collapsible h3').forEach((header) => {
            header.addEventListener('click', function() {
                const content = this.nextElementSibling;
                content.style.display = content.style.display === 'block' ? 'none' : 'block';
            });
        });
    </script>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
    <script>
        // Initialize the first phone input field
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            initialCountry: "UG", // Set default country to 'US'
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // for formatting
        });

        // Initialize the second phone input field
        var otherPhoneInput = document.querySelector("#otherPhone");
        window.intlTelInput(otherPhoneInput, {
            initialCountry: "UG", // Set default country to 'US'
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js" // for formatting
        });
    </script>
@endsection
