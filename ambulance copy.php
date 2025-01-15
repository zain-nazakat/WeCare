<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeCare - Ambulance Service</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/style.css">

    <style>
        /* Add any custom styles here */
        #map {
    margin-top: 20px;
    height: 570px;
}

        body {
            font-family: 'Rubik', sans-serif;
        }

        .text-center {
            text-align: center;
        }

        .form-signin {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            margin: auto;
        }

        .form-floating {
            margin-bottom: 20px;
            margin-top: -63px;
        }

        .form-floating select {
            width: 100%;
            height: calc(2.5rem + 2px);
            padding: .375rem 0.75rem;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .form-floating select:focus {
            border-color: #fd7e14;
            outline: 0;
            box-shadow: 0 0 0 0.25rem rgba(253, 126, 20, 0.25);
        }

        label {
            font-size: 0.875rem;
        }

        .btn-orange {
            color: #fff;
            background-color: #fd7e14;
            border-color: #fd7e14;
        }

        .card {
            box-shadow: 4px 6px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
        }

        .card-body {
            padding: 5px;
        }

        .table {
            font-size: 14px;
            color: #222;
            vertical-align: middle;
        }

        .table th,
        .table td {
            padding: 5px;
        }

        .table-container {
            text-align: right;
        }

        .content-container {
            margin-top: 200px;
        }

        .image-container img {
            width: 100%;
            height: auto;
            max-width: 300px;
        }

       
    </style>

</head>

<body>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
            <div class="container-fluid">
                <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="./img/logo.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="padding-left:15%">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="education.php">Education Corner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="ambulance.php">Ambulance Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="blogs.php">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="About_us.html">About Us</a> 
                            
                        </li>
                    </ul>
                    <div class="d-flex ">
                        <div class="dropdown" style="margin-right:20px;">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Log In
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="donner_login.php">Donners</a></li>
                                <li><a class="dropdown-item" href="ngo_login.php">NGOs</a></li>
                                <li><a class="dropdown-item" href="admin_login.php">Admin</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Sign Up
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="donner_signup.php">Donners</a></li>
                                <li><a class="dropdown-item" href="ngo_signup.php">NGOs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </nav>

    <!-- Content Section -->
    <div class="container content-container">
        <div class="row">
            <div class="col-md-6">
                <main class="form-signin">
                    <form>
                        <div class="alert alert">
                            <!-- Alert messages can go here -->
                        </div>
                        <div class="form-floating">
                            <select class="form-control" name="location" id="location">
                                <option value="">Select a location</option>
                                <option value="Adiala Road">Adiala Road</option>
                                <option value="Saddar">Saddar</option>
                                <option value="Satellite Town">Satellite Town</option>
                                <option value="Bahria Town Rawalpindi">Bahria Town Rawalpindi</option>
                                <option value="Westridge">Westridge</option>
                                <option value="Affandi Colony">Affandi Colony</option>
                                <option value="Afshan Colony">Afshan Colony</option>
                                <option value="Air Force Housing Society">Air Force Housing Society</option>
                                <option value="Airport Housing Society">Airport Housing Society</option>
                                <option value="Akalgarh">Akalgarh</option>
                                <option value="Al-Haram City">Al-Haram City</option>
                                <option value="Allama Iqbal Colony">Allama Iqbal Colony</option>
                                <option value="Army Officers Colony">Army Officers Colony</option>
                                <option value="Asghar Mall Road">Asghar Mall Road</option>
                                <option value="Askari">Askari</option>
                                <option value="Ayub National Park">Ayub National Park</option>
                                <option value="Bahria Phase 7">Bahria Phase 7</option>
                                <option value="Bahria Phase 8">Bahria Phase 8</option>
                                <option value="Bank Road">Bank Road</option>
                                <option value="Cantt">Cantt</option>
                                <option value="Chak Beli Khan">Chak Beli Khan</option>
                                <option value="Chaklala">Chaklala</option>
                                <option value="Chaklala Scheme 3">Chaklala Scheme 3</option>
                                <option value="Chakri Road">Chakri Road</option>
                                <option value="Chandni Chowk">Chandni Chowk</option>
                                <option value="Committee Chowk">Committee Chowk</option>
                                <option value="Cricket Stadium Road">Cricket Stadium Road</option>
                                <option value="Defence Phase-I">Defence Phase-I</option>
                                <option value="Dhamyal Road">Dhamyal Road</option>
                                <option value="Dheri Hassanabad">Dheri Hassanabad</option>
                                <option value="Dhok Kala Khan">Dhok Kala Khan</option>
                                <option value="Dhok Kashmirian">Dhok Kashmirian</option>
                                <option value="Dhok Mangtal">Dhok Mangtal</option>
                                <option value="Dhok Paracha">Dhok Paracha</option>
                                <option value="Dhok Sayedan Road">Dhok Sayedan Road</option>
                                <option value="Faizabad">Faizabad</option>
                                <option value="Fazaia Colony">Fazaia Colony</option>
                                <option value="Fazal Town">Fazal Town</option>
                                <option value="G.H.Q">G.H.Q</option>
                                <option value="Gawal Mandi">Gawal Mandi</option>
                                <option value="Ghauri Town">Ghauri Town</option>
                                <option value="Gulistan Colony">Gulistan Colony</option>
                                <option value="Gulrez Housing Scheme">Gulrez Housing Scheme</option>
                                <option value="Gulshan Abad">Gulshan Abad</option>
                                <option value="Gulzar-e-Quaid Housing Society">Gulzar-e-Quaid Housing Society</option>
                                <option value="Harley Street">Harley Street</option>
                                <option value="High Court Road">High Court Road</option>
                                <option value="Jhanda Chichi">Jhanda Chichi</option>
                                <option value="KRL Road">KRL Road</option>
                                <option value="Kahuta Road">Kahuta Road</option>
                                <option value="Kallar Syedan">Kallar Syedan</option>
                                <option value="Kamala Abad">Kamala Abad</option>
                                <option value="Khanna Pul">Khanna Pul</option>
                                <option value="Khayaban-e-Sir-Syed">Khayaban-e-Sir-Syed</option>
                                <option value="Kurri Road">Kurri Road</option>
                                <option value="Lalazar">Lalazar</option>
                                <option value="Lalkurti">Lalkurti</option>
                            </select>
                            <label for="location">Location</label>
                        </div>
                        <button class="w-100 btn btn-lg btn-orange" type="button" onclick="searchForAmbulance()">Search For Ambulance</button>
                    </form>
                </main>
                <!-- <div>
                    <img src="img/ambulance.jpg" alt="" width="70%" height="auto" style="float: left;">
                </div> -->
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-body" style="font-size: 18px;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>NGO Name</th>
                                    <th>Contact No</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>01</td>
                                    <td>KWS</td>
                                    <td>03215645987</td>
                                    <td>Free</td>
                                </tr>
                                <!-- Additional rows can go here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Map Section -->
    <div id="map"></div>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+1k+Ml5Y1pVV8CV+1RWU" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <!-- Custom JavaScript -->
    <script>
       // Initialize the map
var map = L.map('map').setView([33.6844, 73.0479], 13); // Islamabad coordinates

// Add OpenStreetMap tile layer
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
}).addTo(map);

// Variable to hold the marker
var marker = null;

// Function to handle selection change in the dropdown
function searchForAmbulance() {
    var location = document.getElementById('location').value;
    var coordinates = [33.6844, 73.0479]; // Default to Islamabad coordinates

    // Example: Define coordinates for specific locations
    var locationCoordinates = {
      'Adiala Road': [33.5194, 73.0272],
'Saddar': [33.5943, 73.0497],
'Satellite Town': [33.6118, 73.0691],
'Bahria Town Rawalpindi': [33.5084, 73.0790],
'Westridge': [33.6011, 73.0291],
'Affandi Colony': [33.5996, 73.0653],
'Afshan Colony': [33.5960, 73.0288],
'Air Force Housing Society': [33.5642, 73.0734],
'Airport Housing Society': [33.5814, 73.0970],
'Akalgarh': [33.5932, 73.0691],
'Al-Haram City': [33.5585, 73.0844],
'Allama Iqbal Colony': [33.5868, 73.0535],
'Army Officers Colony': [33.6014, 73.0358],
'Asghar Mall Road': [33.6154, 73.0578],
'Askari': [33.5983, 73.0496],
'Ayub National Park': [33.5372, 73.0641],
'Bahria Phase 7': [33.5116, 73.1073],
'Bahria Phase 8': [33.5160, 73.1164],
'Bank Road': [33.5932, 73.0538],
'Cantt': [33.5968, 73.0485],
'Chak Beli Khan': [33.4142, 73.1914],
'Chaklala': [33.5748, 73.0914],
'Chaklala Scheme 3': [33.5791, 73.1094],
'Chakri Road': [33.5320, 73.0442],
'Chandni Chowk': [33.6120, 73.0672],
'Committee Chowk': [33.6122, 73.0600],
'Cricket Stadium Road': [33.6135, 73.0685],
'Defence Phase-I': [33.5168, 73.1154],
'Dhamyal Road': [33.5645, 73.0262],
'Dheri Hassanabad': [33.5790, 73.0541],
'Dhok Kala Khan': [33.6084, 73.0810],
'Dhok Kashmirian': [33.6114, 73.0664],
'Dhok Mangtal': [33.6145, 73.0435],
'Dhok Paracha': [33.6206, 73.0484],
'Dhok Sayedan Road': [33.6013, 73.0365],
'Faizabad': [33.6513, 73.0642],
'Fazaia Colony': [33.5660, 73.0924],
'Fazal Town': [33.5634, 73.1060],
'G.H.Q': [33.6015, 73.0350],
'Gawal Mandi': [33.5920, 73.0462],
'Ghauri Town': [33.6101, 73.1274],
'Gulistan Colony': [33.6081, 73.0670],
'Gulrez Housing Scheme': [33.5675, 73.0830],
'Gulshan Abad': [33.5700, 73.0708],
'Gulzar-e-Quaid Housing Society': [33.5842, 73.1060],
'Harley Street': [33.5880, 73.0572],
'High Court Road': [33.6090, 73.0831],
'Jhanda Chichi': [33.5803, 73.0680],
'KRL Road': [33.5976, 73.0706],
'Kahuta Road': [33.5695, 73.1203],
'Kallar Syedan': [33.3707, 73.3053],
'Kamala Abad': [33.6144, 73.0612],
'Khanna Pul': [33.6224, 73.0954],
'Khayaban-e-Sir-Syed': [33.6333, 73.0433],
'Kurri Road': [33.6251, 73.0958],
'Lalazar': [33.5724, 73.0831],
'Lalkurti': [33.5854, 73.0487],

        // Add coordinates for other locations as needed
    };

    // Check if the selected location has predefined coordinates
    if (locationCoordinates.hasOwnProperty(location)) {
        coordinates = locationCoordinates[location];
    }

    // Remove previous marker if it exists
    if (marker !== null) {
        map.removeLayer(marker);
    }

    // Add new marker to the selected location
    marker = L.marker(coordinates).addTo(map)
        .bindPopup(location) // Optional: Bind a popup with the location name
        .openPopup();

    // Center the map on the selected location
    map.setView(coordinates, 13);
}


    </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</html>
