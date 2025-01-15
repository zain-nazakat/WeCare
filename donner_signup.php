<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
if (isset($_SESSION['donnername'])) {
    header("Location: donner_home.php");
    die();
}

require 'vendor/autoload.php'; // Load Composer's autoloader
include './database/config.php'; // Include database configuration

if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));
    $cpassword = mysqli_real_escape_string($conn, md5($_POST['cpassword']));
    $p = $_POST['password'];
    $code = md5(rand()); // Generate a random verification code
    $error = "";
    $cls = "";

    if ($password == $cpassword) {
        if (strlen($p) > 5) {
            $query = "SELECT * FROM donners WHERE username = '$username' OR email = '$email'";
            $query_run = mysqli_query($conn, $query);

            if ($query_run && mysqli_num_rows($query_run) == 0) {
                $query2 = "INSERT INTO donners(username, email, `password`, code) VALUES ('$username', '$email', '$password', '$code')";
                $query_run2 = mysqli_query($conn, $query2);

                if ($query_run2) {
                    // Send confirmation email
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();                        // Set mailer to use SMTP
                        $mail->Host = 'smtp.gmail.com';         // Specify main and backup SMTP servers
                        $mail->SMTPAuth = true;                 // Enable SMTP authentication
                        $mail->Username = 'usama.hsn56@gmail.com'; // SMTP username
                        $mail->Password = 'scmenfxaaeuxnfzb';     // SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable TLS encryption, `ssl` also accepted
                        $mail->Port = 465;                     // TCP port to connect to

                        // Recipients
                        $mail->setFrom('usama.hsn56@gmail.com', 'weCare');
                        $mail->addAddress($email);             // Add a recipient

                        // Content
                        $mail->isHTML(true);                                  // Set email format to HTML
                        $mail->Subject = 'Registration Confirmation';
                        $mail->Body = "Welcome, $username!<br>Click <a href='http://localhost/wecare/verify.php?code=$code'>here</a> to verify your email.";

                        $mail->send();
                        echo "<script>
                            alert('Registration successful. A confirmation email has been sent to your email.');
                            window.location.href='donner_profile.php';
                        </script>";
                    } catch (Exception $e) {
                        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }
                } else {
                    $error = "Cannot Register";
                    $cls = "danger";
                }
            } else {
                $error = "Username or Email Already Exists";
                $cls = "danger";
            }
        } else {
            $error = "Password has to be a minimum of 6 characters";
            $cls = "danger";
        }
    } else {
        $error = 'Passwords did not match.';
        $cls = "danger";
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
            <h1 class="h3 mb-5 fw-normal" style="font-weight:700">Sign Up</h1>
            <div class="alert alert-<?php echo $cls; ?>">
                <?php
                if (isset($_POST['signup'])) {
                    echo $error;
                }
                ?>
            </div>
            <div class="form-floating">
                <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username" required>
                <label for="floatingInput">Username</label>
            </div>
            <div class="form-floating">
                <input type="email" class="form-control" name="email" id="floatingInput" placeholder="Email Address" required>
                <label for="floatingInput">Email address</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password" required>
                <label for="floatingPassword">Password</label>
            </div>
            <div class="form-floating">
                <input type="password" class="form-control" name="cpassword" id="floatingPassword" placeholder="Confirm Password" required>
                <label for="floatingPassword">Confirm Password</label>
            </div>
            <div class="d-flex justify-content-between" style="margin: 20px;">
                <div>
                    <label>
                        <input type="checkbox" value="remember-me"> &nbsp; I Agree to all the Terms and Conditions
                    </label>
                </div>
            </div>
            <button class="w-100 btn btn-lg btn-orange" type="submit" name="signup">Sign Up</button>
            <p class="mt-5 mb-3 text-muted">Already a User? Sign In <a href="donner_login.php">Now</a></p>
        </form>
    </main>

</body>

</html>
