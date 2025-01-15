<?php
include_once("./database/config.php");
session_start();

if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
    exit();
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the record to delete the associated file if necessary
    $query = "SELECT picture FROM education_content WHERE id='$id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $picture = $row['picture'];

        // Delete the record
        $deleteQuery = "DELETE FROM education_content WHERE id='$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Delete the file if it exists
            if (file_exists("./uploads/education/" . $picture)) {
                unlink("./uploads/education/" . $picture);
            }
            header("Location: ngo_education_data.php?message=Record deleted successfully");
        } else {
            header("Location: ngo_education_data.php?message=Failed to delete record");
        }
    } else {
        header("Location: ngo_education_data.php?message=Record not found");
    }
} else {
    header("Location: ngo_education_data.php?message=Invalid request");
}
?>
