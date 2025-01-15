<?php
include_once("./database/config.php");
session_start();

if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
    exit();
}

$username = $_SESSION['ngoname'];

// Validate the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize form inputs
    $heading = mysqli_real_escape_string($conn, $_POST['heading']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    // Handle file upload for the picture
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
        $fileName = $_FILES['picture']['name'];
        $fileTmpName = $_FILES['picture']['tmp_name'];
        $fileSize = $_FILES['picture']['size'];
        $fileError = $_FILES['picture']['error'];
        $fileType = $_FILES['picture']['type'];

        // Get file extension
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExts = ['jpg', 'jpeg', 'png', 'gif'];

        // Check if the file is a valid image type
        if (in_array($fileExt, $allowedExts)) {
            // Generate a unique file name
            $fileNewName = uniqid('', true) . "." . $fileExt;

            // Specify the upload directory
            $uploadDir = './uploads/education/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  // Create the directory if it doesn't exist
            }

            // Define the full path to move the uploaded file
            $fileDestination = $uploadDir . $fileNewName;

            // Move the uploaded file to the specified directory
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                // Insert the form data into the database
                $sql = "INSERT INTO education_content (heading, picture, description, ngo_username) 
                        VALUES ('$heading', '$fileNewName', '$description', '$username')";

                if (mysqli_query($conn, $sql)) {
                    // Success message with the button
                    echo "Education content added successfully. <br>";
                    header("Location: ngo_education_data.php?message=Record added successfully");
                    echo "<a href='ngo_education_data.php' class='btn btn-success' style='padding: 10px 20px; font-size: 16px; border-radius: 5px; text-decoration: none;'>View Content</a>";

                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Error uploading the file.";
            }
        } else {
            echo "Invalid file type. Please upload a JPG, JPEG, PNG, or GIF image.";
        }
    } else {
        echo "No file selected or there was an error uploading the file.";
    }
} else {
    echo "Invalid request method.";
}
?>
