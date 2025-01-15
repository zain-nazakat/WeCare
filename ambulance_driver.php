<?php
// Database connection variables
$servername = "localhost";  // Change to your server name or IP if necessary
$username = "root";         // Change to your database username
$password = "";             // Change to your database password
$dbname = "wecare";         // Database name: 'wecare'

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Define variables and initialize with empty values
$ambulance_number = $driver_name = $driver_contact = $location = $status = "";

// Process the form when it is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $ambulance_number = $_POST['ambulance_number'];
    $driver_name = $_POST['driver_name'];
    $driver_contact = $_POST['driver_contact'];
    $location = $_POST['location'] ?? null;  // Default to NULL if not provided
    $status = $_POST['status'];

    // Prepare SQL query
    $sql = "INSERT INTO ambulances (ambulance_number, driver_name, driver_contact, location, status)
            VALUES ('$ambulance_number', '$driver_name', '$driver_contact', '$location', '$status')";

    // Execute the query
    if ($conn->query($sql) === TRUE) {
        $success_message = "New ambulance record created successfully.";
    } else {
        $error_message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Close the connection
$conn->close();

// List of locations for the dropdown (just names, no coordinates)
$locations = [
    'Adiala Road', 'Saddar', 'Satellite Town', 'Bahria Town Rawalpindi', 'Westridge', 'Affandi Colony', 
    'Afshan Colony', 'Air Force Housing Society', 'Airport Housing Society', 'Akalgarh', 'Al-Haram City', 
    'Allama Iqbal Colony', 'Army Officers Colony', 'Asghar Mall Road', 'Askari', 'Ayub National Park', 
    'Bahria Phase 7', 'Bahria Phase 8', 'Bank Road', 'Cantt', 'Chak Beli Khan', 'Chaklala', 'Chaklala Scheme 3',
    'Chakri Road', 'Chandni Chowk', 'Committee Chowk', 'Cricket Stadium Road', 'Defence Phase-I', 
    'Dhamyal Road', 'Dheri Hassanabad', 'Dhok Kala Khan', 'Dhok Kashmirian', 'Dhok Mangtal', 'Dhok Paracha',
    'Dhok Sayedan Road', 'Faizabad', 'Fazaia Colony', 'Fazal Town', 'G.H.Q', 'Gawal Mandi', 'Ghauri Town', 
    'Gulistan Colony', 'Gulrez Housing Scheme', 'Gulshan Abad', 'Gulzar-e-Quaid Housing Society', 
    'Harley Street', 'High Court Road', 'Jhanda Chichi', 'KRL Road', 'Kahuta Road', 'Kallar Syedan', 
    'Kamala Abad', 'Khanna Pul', 'Khayaban-e-Sir-Syed', 'Kurri Road', 'Lalazar', 'Lalkurti'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ambulance Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        h2 {
            color: #333;
        }
        .form-container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Register Ambulance</h2>

        <!-- Display success or error message -->
        <?php if (!empty($success_message)): ?>
            <div class="message success"><?= $success_message; ?></div>
        <?php elseif (!empty($error_message)): ?>
            <div class="message error"><?= $error_message; ?></div>
        <?php endif; ?>

        <!-- Form to insert ambulance data -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label for="ambulance_number">Ambulance Number:</label>
            <input type="text" id="ambulance_number" name="ambulance_number" value="<?= $ambulance_number; ?>" required>

            <label for="driver_name">Driver Name:</label>
            <input type="text" id="driver_name" name="driver_name" value="<?= $driver_name; ?>" required>

            <label for="driver_contact">Driver Contact:</label>
            <input type="text" id="driver_contact" name="driver_contact" value="<?= $driver_contact; ?>" required>

            <label for="location">Location:</label>
            <select id="location" name="location" required>
                <option value="" disabled selected>Select Location</option>
                <?php foreach ($locations as $location_name): ?>
                    <option value="<?= $location_name; ?>" <?= $location == $location_name ? "selected" : ""; ?>><?= $location_name; ?></option>
                <?php endforeach; ?>
            </select>

            <label for="status">Status:</label>
            <select id="status" name="status">
                <option value="Available" <?= $status == "Available" ? "selected" : ""; ?>>Available</option>
                <option value="Not Available" <?= $status == "Not Available" ? "selected" : ""; ?>>Not Available</option>
            </select>

            <input type="submit" value="Register Ambulance">
        </form>
    </div>

</body>
</html>
