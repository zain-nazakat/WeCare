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

// Process form submission for deleting ambulance record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and sanitize form data
    $ambulance_number = $conn->real_escape_string($_POST['ambulance_number']); // Ambulance number entered by the user
    $code = $conn->real_escape_string($_POST['Code']); // Registration code entered by the user

    // Validate inputs
    if (empty($ambulance_number) || empty($code)) {
        $error_message = "Ambulance number and registration code are required.";
    } else {
        // Prepare SQL query to check if ambulance with the given code exists
        $check_sql = "SELECT * FROM ambulances WHERE code = ? AND ambulance_number = ?";
        if ($stmt = $conn->prepare($check_sql)) {
            // Bind parameters to the statement
            $stmt->bind_param("ss", $code, $ambulance_number);

            // Execute the statement
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if the ambulance exists
            if ($result->num_rows > 0) {
                // Prepare SQL query to delete the ambulance record
                $delete_sql = "DELETE FROM ambulances WHERE code = ? AND ambulance_number = ?";
                if ($delete_stmt = $conn->prepare($delete_sql)) {
                    // Bind parameters to the statement
                    $delete_stmt->bind_param("ss", $code, $ambulance_number);

                    // Execute the statement
                    if ($delete_stmt->execute()) {
                        $success_message = "Ambulance record deleted successfully.";
                    } else {
                        $error_message = "Error deleting record: " . $delete_stmt->error;
                    }
                    // Close delete statement
                    $delete_stmt->close();
                } else {
                    $error_message = "Error preparing the delete query: " . $conn->error;
                }
            } else {
                $error_message = "No ambulance found with the provided registration code and number.";
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
    <title>WeCare - Delete Ambulance Record</title>
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
        
        <div id="deleteAmbulanceForm" class="mt-4">
            <h4>Delete Ambulance Record</h4>

            <!-- Form Fields -->
            <div class="mb-3">
                <input type="text" class="form-control" id="ambulance_number" name="ambulance_number" placeholder="Ambulance Number" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" id="Code" name="Code" placeholder="Enter Registration Code" required>
            </div>

            <button type="submit" name="submit" class="btn btn-orange">Delete Record</button>
            <button type="button" class="btn btn-secondary" onclick="window.location.href='driver_registeration.php'">Cancel</button>
        </div>
    </form>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ku+QRQGcFhKm7BrTjtOkxj9gc/jEkrr5r6czXHXTN9ds98WQdsF51S8Zgf5b2Do9" crossorigin="anonymous"></script>
</body>
</html>
