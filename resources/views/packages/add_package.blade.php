@extends('layouts.sidebar')

@section('content')
    <div class="pagetitle">
        <h1>Add Package</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Add Package</li>
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

        <form method="POST" action="{{ route('createPackage') }}" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->

            <div class="form-group">
                <label for="role">Package Category</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Select Category</option>
                    <option value="HAJJ">HAJJ</option>
                    <option value="UMRAH">UMRAH</option>
                </select>
            </div>

            <div class="form-group">
                <label for="role">Package Type</label>
                <select class="form-control" id="type" name="type" required onchange="togglePriceInputs()">
                    <option value="">Select Type</option>
                    <option value="Standard">STANDARD</option>
                    <option value="Economy">ECONOMY</option>
                    <option value="BOTH">BOTH</option>
                </select>
            </div>

            <div id="priceInputs">
                <div class="form-group">
                    <label for="standardPrice">Standard Price:</label>
                    <input type="text" id="standardPrice" name="standardPrice" class="form-control">
                </div>

                <div class="form-group">
                    <label for="economyPrice">Economy Price:</label>
                    <input type="text" id="economyPrice" name="economyPrice" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="title">Package Title:</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="packageDescription">Package Description</label>
                <textarea id="packageDescription" name="packageDescription" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="dateRange">Package DateRange:</label>
                <input type="text" id="dateRange" name="dateRange" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="packageImage">Package Image / Thumbnail (The image should be less than 1MB):</label>
                <input type="file" id="packageImage" name="packageImage" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="services">Package Services:</label>

                <div class="form-group">
                    <input type="checkbox" id="Accomodation" name="services[Accomodation][name]" value="Accomodation"
                        onchange="toggleServiceDescription('Accomodation')"> Accomodation
                    <textarea id="AccomodationDescription" name="services[Accomodation][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="AccomodationImages" name="services[Accomodation][images]" class="form-control"
                        style="display: none; margin-top: 20px" onchange="showSelectedImages('Accomodation')">
                    <div id="selectedImagesContainer_Accomodation" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_Accomodation"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="visaProcessing" name="services[visaProcessing][name]" value="visaProcessing"
                        onchange="toggleServiceDescription('visaProcessing')"> VISA Processing
                    <textarea id="visaProcessingDescription" name="services[visaProcessing][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="visaProcessingImages" name="services[visaProcessing][images]"
                        class="form-control" style="display: none; margin-top: 20px"
                        onchange="showSelectedImages('visaProcessing')">
                    <div id="selectedImagesContainer_visaProcessing" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_visaProcessing"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="returnFlight" name="services[returnFlight][name]" value="returnFlight"
                        onchange="toggleServiceDescription('returnFlight')"> Return Flight
                    <textarea id="returnFlightDescription" name="services[returnFlight][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="returnFlightImages" name="services[returnFlight][images]"
                        class="form-control" style="display: none; margin-top: 20px"
                        onchange="showSelectedImages('returnFlight')">
                    <div id="selectedImagesContainer_returnFlight" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_returnFlight"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="groundTransport" name="services[groundTransport][name]"
                        value="groundTransport" onchange="toggleServiceDescription('groundTransport')"> Ground Transport
                    <textarea id="groundTransportDescription" name="services[groundTransport][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="groundTransportImages" name="services[groundTransport][images]"
                        class="form-control" style="display: none; margin-top: 20px"
                        onchange="showSelectedImages('groundTransport')">
                    <div id="selectedImagesContainer_groundTransport" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_groundTransport"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="historicalSitesTour" name="services[historicalSitesTour][name]"
                        value="historicalSitesTour" onchange="toggleServiceDescription('historicalSitesTour')"> Historical
                    Sites Tour
                    <textarea id="historicalSitesTourDescription" name="services[historicalSitesTour][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="historicalSitesTourImages" name="services[historicalSitesTour][images]"
                        class="form-control" style="display: none; margin-top: 20px"
                        onchange="showSelectedImages('historicalSitesTour')">
                    <div id="selectedImagesContainer_historicalSitesTour" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_historicalSitesTour"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="breakfast_iftar" name="services[breakfast_iftar][name]"
                        value="breakfast_iftar" onchange="toggleServiceDescription('breakfast_iftar')"> Breakfast / Iftar
                    <textarea id="breakfast_iftarDescription" name="services[breakfast_iftar][description]" class="form-control"
                        style="display: none;"></textarea>
                    <input type="file" id="breakfast_iftarImages" name="services[breakfast_iftar][images]"
                        class="form-control" style="display: none; margin-top: 20px"
                        onchange="showSelectedImages('breakfast_iftar')">
                    <div id="selectedImagesContainer_breakfast_iftar" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_breakfast_iftar"></div>
                    </div>
                </div>

                <div class="form-group">
                    <input type="checkbox" id="train" name="services[train][name]" value="train"
                        onchange="toggleServiceDescription('train')"> Train
                    <textarea id="trainDescription" name="services[train][description]" class="form-control" style="display: none;"></textarea>
                    <input type="file" id="trainImages" name="services[train][images]" class="form-control"
                        style="display: none; margin-top: 20px" onchange="showSelectedImages('train')">
                    <div id="selectedImagesContainer_train" style="display: none;">
                        Selected Images:
                        <div id="selectedImages_train"></div>
                    </div>
                </div>
                <!-- Add more services as needed -->
            </div>

            <div class="form-group">
                <label for="endDateTime">Package End DateTime:</label>
                <input type="datetime-local" id="endDateTime" name="endDateTime" class="form-control" required>
            </div>

            <button style="margin-top: 30px" type="submit" class="btn btn-primary">Add New Package</button>
        </form>
    </div>

    <script>
        function togglePriceInputs() {
            var type = document.getElementById('type').value;
            var standardPriceInput = document.getElementById('standardPrice');
            var economyPriceInput = document.getElementById('economyPrice');

            if (type === 'BOTH') {
                standardPriceInput.style.display = 'block';
                economyPriceInput.style.display = 'block';
            } else if (type === 'Standard') {
                standardPriceInput.style.display = 'block';
                economyPriceInput.style.display = 'none';
            } else if (type === 'Economy') {
                standardPriceInput.style.display = 'none';
                economyPriceInput.style.display = 'block';
            } else {
                standardPriceInput.style.display = 'none';
                economyPriceInput.style.display = 'none';
            }
        }

        function toggleServiceDescription(service) {
            var descriptionTextarea = document.getElementById(service + 'Description');
            var imagesInput = document.getElementById(service + 'Images');
            var selectedImagesContainer = document.getElementById('selectedImagesContainer_' + service);
            var selectedImagesDiv = document.getElementById('selectedImages_' + service);

            if (document.getElementById(service).checked) {
                descriptionTextarea.style.display = 'block';
                imagesInput.style.display = 'block';

            } else {
                descriptionTextarea.style.display = 'none';
                imagesInput.style.display = 'none';
                selectedImagesContainer.style.display = 'none'; // Hide selected images container
            }
        }

        // Function to display selected images
        function showSelectedImages(service) {
            var imagesInput = document.getElementById(service + 'Images');
            var selectedImagesContainer = document.getElementById('selectedImagesContainer_' + service);
            var selectedImagesDiv = document.getElementById('selectedImages_' + service);

            selectedImagesDiv.innerHTML = ''; // Clear previous selected images

            for (var i = 0; i < imagesInput.files.length; i++) {
                var file = imagesInput.files[i];
                var imageElement = document.createElement('img');
                imageElement.src = URL.createObjectURL(file);
                imageElement.style.maxWidth = '200px'; // Set max width for the displayed image
                selectedImagesDiv.appendChild(imageElement);
            }

            selectedImagesContainer.style.display = 'block'; // Show selected images container
        }
    </script>
@endsection
