<?php
session_start();

include './database/config.php'; // Include database configuration

$cls = ''; // Variable to hold alert class
$error = ''; // Variable to hold error message
$success_message = ''; // Variable to hold success message
$email = ''; // Variable to hold email

// Check if reset code is provided in the URL
if (isset($_GET['code'])) {
    $reset_code = mysqli_real_escape_string($conn, $_GET['code']);
    
    // Verify if the reset code exists in the database
    $query = "SELECT * FROM donners WHERE reset_code = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $reset_code);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) == 1) {
        $donner = mysqli_fetch_assoc($result);
        $_SESSION['reset_email'] = $donner['email']; // Store email in session for later use
        $email = $donner['email']; // Assign email to variable for display
    } else {
        $error = "Invalid reset code or link has expired.";
        $cls = 'danger';
    }
} else {
    $error = "Reset code not found.";
    $cls = 'danger';
}

// Handle password reset form submission
if (isset($_POST['update_password'])) {
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
        $cls = 'danger';
    } else {
        // Store password in plain text
        $plain_text_password = $password;

        // Update password in the database
        $email = $_SESSION['reset_email'];
        $update_query = "UPDATE donners SET password = ?, reset_code = NULL WHERE email = ?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ss", $plain_text_password, $email);
        $update_query_run = mysqli_stmt_execute($stmt);

        if ($update_query_run) {
            // Password updated successfully
            $success_message = "Password updated successfully. You can now <a href='donner_login.php'>login</a> with your new password.";
            $cls = 'success';
            // Clear/reset session variables
            unset($_SESSION['reset_email']);
        } else {
            $error = "Unable to update password. Please try again later.";
            $cls = 'danger';
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
    <title>WeCare - Reset Password</title>
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="POST">
            <h1 class="h3 mb-5 fw-normal" style="font-weight:700">Reset Password</h1>
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php elseif (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($_SESSION['reset_email'])): ?>
            <div class="alert alert-success">
                <strong>Email:</strong> <?php echo htmlspecialchars($_SESSION['reset_email']); ?>
            </div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                <label for="password">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <label for="confirm_password">Confirm Password</label>
            </div>
            <button class="w-100 btn btn-lg btn-orange mt-3" type="submit" name="update_password">Update Password</button>
            <p class="mt-5 mb-3 text-muted">Remembered your password? Sign In <a href="donner_login.php">Now</a></p>
        </form>
    </main>

</body>

</html>
