<?php

session_start();

include './database/config.php'; // Include your database configuration file

if (isset($_GET['code'])) {
    $code = mysqli_real_escape_string($conn, $_GET['code']);

    $query = "SELECT * FROM donners WHERE code = '$code'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run && mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
        $username = $row['username'];
        $email = $row['email'];

        $update_query = "UPDATE donners SET verified = 1 WHERE code = '$code'";
        $update_run = mysqli_query($conn, $update_query);

        if ($update_run) {
            echo "<h1 style='color: green; text-align: center;'>Email Verification Successful</h1>";
            echo "<p style='text-align: center;'>Thank you, $username! Your email ($email) has been verified.</p>";
            echo "<p style='text-align: center;'>You can now <a href='donner_login.php'>login here</a>.</p>";
        } else {
            echo "<h1 style='color: red; text-align: center;'>Error</h1>";
            echo "<p style='text-align: center;'>Failed to update verification status. Please contact support.</p>";
        }
    } else {
        echo "<h1 style='color: red; text-align: center;'>Error</h1>";
        echo "<p style='text-align: center;'>Invalid verification code or user not found.</p>";
    }
} else {
    echo "<h1 style='color: red; text-align: center;'>Error</h1>";
    echo "<p style='text-align: center;'>Verification code not provided.</p>";
}

?>
