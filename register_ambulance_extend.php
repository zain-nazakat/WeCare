<?php
// Database connection
$servername = "localhost"; // Change to your server name or IP address
$username = "root";        // Change to your MySQL username
$password = "";            // Change to your MySQL password
$dbname = "wecare";       // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission for adding new ambulance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $ambulance_number = $_POST['ambulance_number'];
    $driver_name = $_POST['driver_name'];
    $driver_contact = $_POST['driver_contact'];
    $location = $_POST['location'] ?? null; // Default to NULL if not provided
    $status = $_POST['status'];

    // Generate a random 4-digit code
    $code = str_pad(rand(0, 9999), 4, "0", STR_PAD_LEFT);

    // Prepare SQL query (using prepared statements for security)
    $sql = "INSERT INTO ambulances (ambulance_number, driver_name, driver_contact, location, status, code)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    // Initialize prepared statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the statement
        $stmt->bind_param("ssssss", $ambulance_number, $driver_name, $driver_contact, $location, $status, $code);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "New ambulance record created successfully with code: $code";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        // Close statement
        $stmt->close();
    } else {
        $error_message = "Error preparing the query: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Rubik:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/signin.css">
    <title>WeCare - Ambulance Registration</title>
</head>
<body class="text-center">
<!-- Success or error message display -->

<main class="form-signin">
    <form action="" method="POST">
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php elseif (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
        <div id="addAmbulanceForm" class="mt-4">
            <h4>Register New Ambulance</h4>

            <!-- Form Fields -->
            <div class="mb-3">
                <input type="text" class="form-control" id="ambulance_number" name="ambulance_number" placeholder="Ambulance Number" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="driver_name" name="driver_name" placeholder="Driver Name" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="driver_contact" name="driver_contact" placeholder="Driver Contact" required>
            </div>
            <div class="mb-3">
            <select class="form-control" id="location" name="location" required>
        <option value="" disabled selected>Select Location</option>
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
            </div>
            <div class="mb-3">
                <select class="form-control" id="status" name="status" required>
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Register Ambulance</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='driver_registeration.php'">Cancel</button>
        </div>
    </form>

  
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ku+QRQGcFhKm7BrTjtOkxj9gc/jEkrr5r6czXHXTN9ds98WQdsF51S8Zgf5b2Do9" crossorigin="anonymous"></script>
</body>
</html>
