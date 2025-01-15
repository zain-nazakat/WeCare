<?php
include './database/config.php';
error_reporting(0);

session_start();

if (isset($_SESSION['ngoname'])) {
    header("Location: ngo_home.php");
    exit(); // Ensure script stops execution after redirect
}

if (isset($_POST['signin'])) {

    $error = "";
    $cls = "";

    $username = $_POST['username'];
    $password = $_POST['password']; // Get plain text password input

    // Retrieve user information
    $sql = "SELECT * FROM ngo WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Check if password is hashed in the database
        if ($user['password'] === md5($password)) {
            // Login successful with hashed password
            if ($user['is_verified'] == 1) {
                $_SESSION['ngoname'] = $username;
                header("Location: ngo_home.php");
                exit(); // Ensure script stops execution after redirect
            } else {
                $error = "Your email is not verified yet. Please check your email for verification instructions.";
                $cls = "danger";
            }
        } else if ($user['password'] === $password) {
            // Login successful with plain text password
            if ($user['is_verified'] == 1) {
                $_SESSION['ngoname'] = $username;
                header("Location: ngo_home.php");
                exit(); // Ensure script stops execution after redirect
            } else {
                $error = "Your email is not verified yet. Please check your email for verification instructions.";
                $cls = "danger";
            }
        } else {
            $error = "Incorrect password.";
            $cls = "danger";
        }
    } else {
        // User does not exist
        $error = "Oops! Username not found.";
        $cls = "danger";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap"
    rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="css/signin.css">

  <title>WeCare</title>

</head>

<body class="text-center">

  <main class="form-signin">
    <form action="" method="post">
      <h1 class="h3 mb-5 fw-normal" style="font-weight:700">Sign In</h1>
      <div class="alert alert-<?php echo $cls; ?>">
        <?php 
          if (isset($_POST['signin'])){
            echo $error;
          }
        ?>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" name="username" id="floatingInput" placeholder="Username">
        <label for="floatingInput">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="floatingPassword" placeholder="Password">
        <label for="floatingPassword">Password</label>
      </div>

      <div class="d-flex justify-content-between" style="margin:20px;">
        <div>
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <div>
          <a href="ngo_forget_password.php">Forgot Password?</a>
        </div>
      </div>
      <button class="w-100 btn btn-lg btn-orange" type="submit" name="signin">Sign In</button>
      <p class="mt-5 mb-3 text-muted">New User? Create an Account <a href="ngo_signup.php">Now</a></p>
    </form>
  </main>

</body>

</html>
