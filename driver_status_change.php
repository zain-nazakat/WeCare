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

// Process form submission for updating ambulance status
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize form data
    $ambulance_number = $conn->real_escape_string($_POST['ambulance_number']); // Ambulance number entered by the user
    $code = $conn->real_escape_string($_POST['Code']); // Registration code entered by the user
    $status = $conn->real_escape_string($_POST['status']); // Status selected by the user

    // Validate inputs
    if (empty($ambulance_number) || empty($code)) {
        $error_message = "Ambulance number and registration code are required.";
    } else {
        // Prepare SQL query to check if ambulance with the given code exists
        $check_sql = "SELECT * FROM ambulances WHERE code = ?";
        if ($stmt = $conn->prepare($check_sql)) {
            // Bind parameters to the statement
            $stmt->bind_param("s", $code);

            // Execute the statement
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the ambulance exists
            if ($result->num_rows > 0) {
                // Prepare SQL query to update the status
                $update_sql = "UPDATE ambulances SET status = ? WHERE code = ?";
                if ($update_stmt = $conn->prepare($update_sql)) {
                    // Bind parameters to the statement
                    $update_stmt->bind_param("ss", $status, $code);

                    // Execute the statement
                    if ($update_stmt->execute()) {
                        $success_message = "Ambulance status updated successfully.";
                    } else {
                        $error_message = "Error updating status: " . $update_stmt->error;
                    }
                    // Close update statement
                    $update_stmt->close();
                } else {
                    $error_message = "Error preparing the update query: " . $conn->error;
                }
            } else {
                $error_message = "No ambulance found with the provided registration code.";
            }
            // Close check statement
            $stmt->close();
        } else {
            $error_message = "Error preparing the check query: " . $conn->error;
        }
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
            <h4>Change Availability Status</h4>

            <!-- Form Fields -->
            <div class="mb-3">
                <input type="text" class="form-control" id="ambulance_number" name="ambulance_number" placeholder="Ambulance Number" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="Code" name="Code" placeholder="Enter Registration Code" required>
            </div>
           
            <div class="mb-3">
                <select class="form-control" id="status" name="status" required>
                    <option value="Available">Available</option>
                    <option value="Not Available">Not Available</option>
                </select>
            </div>
            <button type="submit" name="submit" class="btn btn-success">Update Status</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='driver_registeration.php'">Cancel</button>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ku+QRQGcFhKm7BrTjtOkxj9gc/jEkrr5r6czXHXTN9ds98WQdsF51S8Zgf5b2Do9" crossorigin="anonymous"></script>
</body>
</html>
