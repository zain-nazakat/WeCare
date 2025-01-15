<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Karachi');
session_start();

$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
}

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$admin_img=$row['admin_img'];

$_SESSION['admin_img'] = $admin_img;
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['username'] = $row['username'];

// Initialize variables for ambulance registration form
$ambulance_number = $driver_name = $driver_contact = $location = $status = "";
$success_message = $error_message = "";

// Handle deletion of an ambulance record
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Prepare and execute SQL to delete the ambulance
    $sql_delete = "DELETE FROM ambulances WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $delete_id);
        if ($stmt_delete->execute()) {
            $success_message = "Ambulance record deleted successfully.";
        } else {
            $error_message = "Error: " . $stmt_delete->error;
        }
        $stmt_delete->close();
    } else {
        $error_message = "Error preparing delete query: " . $conn->error;
    }
}

// Process form submission for adding new ambulance
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect form data
    $ambulance_number = $_POST['ambulance_number'];
    $driver_name = $_POST['driver_name'];
    $driver_contact = $_POST['driver_contact'];
    $location = $_POST['location'] ?? null; // Default to NULL if not provided
    $status = $_POST['status'];

    // Prepare SQL query (using prepared statements for security)
    $sql = "INSERT INTO ambulances (ambulance_number, driver_name, driver_contact, location, status)
            VALUES (?, ?, ?, ?, ?)";
    
    // Initialize prepared statement
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        // Bind parameters to the statement
        $stmt->bind_param("sssss", $ambulance_number, $driver_name, $driver_contact, $location, $status);

        // Execute the statement
        if ($stmt->execute()) {
            $success_message = "New ambulance record created successfully.";
        } else {
            $error_message = "Error: " . $stmt->error;
        }
        // Close statement
        $stmt->close();
    } else {
        $error_message = "Error preparing the query: " . $conn->error;
    }
}

// Fetch all ambulances for display
$ambulance_sql = "SELECT * FROM ambulances";
$ambulance_result = mysqli_query($conn, $ambulance_sql);
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare - Manage Ambulance</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sidebars.css">
</head>

<body>

    <section class="d-flex">
        <div class="header d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none"
                style="padding:5px 30px;">
                <img src="./img/logo.png" alt="">
            </a>
            <hr>
            <ul class="nav nav-pills flex-column mb-auto">
                <li class="nav-item">
                    <a href="admin_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="admin_donners.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-users" style="padding-right:14px;"></i>
                        Manage Donners
                    </a>
                </li>
                <li>
                    <a href="admin_ngos.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-building-ngo" style="padding-right:14px;"></i>
                        Manage NGOs
                    </a>
                </li>
                <li>
                    <a href="admin_causes.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Manage Causes
                    </a>
                </li>
                <li>
                    <a href="admin_donations.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-coins" style="padding-right:14px;"></i>
                        Donation History
                    </a>
                </li>
                <li>
                    <a href="admin_ambulance.php" class="nav-link active" aria-current="page"
                    style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-car" style="padding-right:14px;"></i>
                        Manage Ambulance
                    </a>
                </li>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./img/admin/<?php echo $admin_img?>" alt="" width="40" height="40"
                        class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="admin_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row d-flex justify-content-between">
                <div class="col-md-9">
                    <h2 style="font-weight:600">Manage Ambulance Services</h2>
                    <p><a href="admin_home.php">Dashboard</a> / <a href="admin_ambulance.php">Manage Ambulance</a> / View Ambulances</p>
                </div>
                <div class="col-md-3 text-end">
                    <!-- Button to open add new ambulance form -->
                    <button class="btn btn-secondary" id="addAmbulanceBtn">Add New Ambulance</button>
                </div>
            </div>

            <!-- Display success or error message -->
            <?php if (!empty($success_message)): ?>
                <div class="alert alert-success"><?= $success_message; ?></div>
            <?php elseif (!empty($error_message)): ?>
                <div class="alert alert-danger"><?= $error_message; ?></div>
            <?php endif; ?>

            <!-- Display Ambulances Table -->
            <table class="table table-bordered mt-4">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ambulance Number</th>
                        <th>Driver Name</th>
                        <th>Driver Contact</th>
                        <th>Location</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($ambulance_result)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['ambulance_number']; ?></td>
                            <td><?php echo $row['driver_name']; ?></td>
                            <td><?php echo $row['driver_contact']; ?></td>
                            <td><?php echo $row['location']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <!-- Delete Button -->
                                <a href="admin_ambulance.php?delete_id=<?php echo $row['id']; ?>"
                                   class="btn btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this ambulance?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- New Ambulance Form (initially hidden) -->
            <div id="addAmbulanceForm" class="mt-4" style="display:none;">
                <h4>Register New Ambulance</h4>
                <form action="admin_ambulance.php" method="POST">
                    <div class="mb-3">
                        <label for="ambulance_number" class="form-label">Ambulance Number</label>
                        <input type="text" class="form-control" id="ambulance_number" name="ambulance_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <input type="text" class="form-control" id="driver_name" name="driver_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="driver_contact" class="form-label">Driver Contact</label>
                        <input type="text" class="form-control" id="driver_contact" name="driver_contact" required>
                    </div>
                    <div class="mb-3">
    <label for="location" class="form-label">Location</label>
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
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Available">Available</option>
                            <option value="Not Available">Not Available</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Register Ambulance</button>
                    <button type="button" class="btn btn-secondary" id="cancelFormBtn">Cancel</button>
                </form>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>

    <script>
        // Toggle the form visibility when the "Add New Ambulance" button is clicked
        document.getElementById("addAmbulanceBtn").addEventListener("click", function() {
            document.getElementById("addAmbulanceForm").style.display = "block";
        });

        // Hide the form when the cancel button is clicked
        document.getElementById("cancelFormBtn").addEventListener("click", function() {
            document.getElementById("addAmbulanceForm").style.display = "none";
        });
    </script>

</body>

</html>
