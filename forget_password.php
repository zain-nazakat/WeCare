<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

// Check if user is already logged in
if (isset($_SESSION['donnername'])) {
    header("Location: donner_home.php");
    exit();
}

require 'vendor/autoload.php'; // Load Composer's autoloader
include './database/config.php'; // Include database configuration

$cls = ''; // Variable to hold alert class
$error = ''; // Variable to hold error message
$success_message = ''; // Variable to hold success message

if (isset($_POST['reset_password'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    $query = "SELECT * FROM donners WHERE email = '$email'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run && mysqli_num_rows($query_run) == 1) {
        $donner = mysqli_fetch_assoc($query_run);
        $username = $donner['username'];
        $reset_code = md5(rand()); // Generate a random reset code
        
        // Update reset code in database
        $update_query = "UPDATE donners SET reset_code = '$reset_code' WHERE email = '$email'";
        $update_query_run = mysqli_query($conn, $update_query);

        if ($update_query_run) {
            // Send reset password email
            $mail = new PHPMailer(true);

            try {
                // Server settings
                $mail->isSMTP();                        // Set mailer to use SMTP
                $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
                $mail->SMTPAuth = true;                 // Enable SMTP authentication
                $mail->Username = 'usama.hsn56@gmail.com'; // SMTP username (your Gmail address)
                $mail->Password = 'scmenfxaaeuxnfzb';     // SMTP password (your Gmail password)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption, `ssl` also accepted
                $mail->Port = 465;                     // TCP port to connect to

                // Recipients
                $mail->setFrom('usama.hsn56@gmail.com', 'Your Name');
                $mail->addAddress($email);             // Add a recipient

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Password Reset';
                $mail->Body = "Hello $username,<br>Click <a href='http://localhost/wecare/reset_password.php?code=$reset_code'>here</a> to reset your password.";

                $mail->send();
                
                // Set success message and class
                $success_message = "Password reset link sent successfully to $email.";
                $cls = 'success';

                // Redirect to password reset page
                $_SESSION['reset_email'] = $email; // Store email in session
                // header("Location: reset_password.php"); // You might redirect here after showing the alert
                // exit();
            } catch (Exception $e) {
                $error = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                $cls = 'danger';
            }
        } else {
            $error = "Unable to process your request. Please try again later.";
            $cls = 'danger';
        }
    } else {
        $error = "No user found with that email address.";
        $cls = 'danger';
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
    <title>WeCare</title>
</head>

<body class="text-center">

    <main class="form-signin">
        <form action="" method="POST">
            <h1 class="h3 mb-5 fw-normal" style="font-weight:700">Donner Forgot Password</h1>
            <?php if (!empty($error)): ?>
            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>
            <?php elseif (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
            <?php endif; ?>
            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="Email Address" required>
                <label for="floatingInput">Email address</label>
            </div>
            <button class="w-100 btn btn-lg btn-orange" type="submit" name="reset_password">Reset Password</button>
            <p class="mt-5 mb-3 text-muted">Remembered your password? Sign In <a href="donner_login.php">Now</a></p>
        </form>
    </main>

</body>

</html>
