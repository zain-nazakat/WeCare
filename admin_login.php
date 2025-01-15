<?php

include "./database/config.php";
error_reporting(0);

session_start();

if (isset($_SESSION["adminname"])) {
    header("Location: admin_home.php");
}

if (isset($_POST["signin"])) {
    $error = "";
    $cls = "";

    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM `admin` WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result->num_rows > 0) {
        $sql = "SELECT * FROM `admin` WHERE `password`='$password'";
        $result = mysqli_query($conn, $sql);

        if ($result->num_rows > 0) {
            $sql = "SELECT * FROM `admin` WHERE username='$username' AND password='$password'";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $_SESSION["adminname"] = $_POST["username"];
                    header("Location: admin_home.php");
            } else {
                $error = "Woops! Someting Went Wrong.";
                $cls = "danger";
            }
        } else {
            $error = "Woops! Password is Incorrect.";
            $cls = "danger";
        }
    } else {
        $error = "Woops! Username is Incorrect.";
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
      <h1 class="h3 mb-5 fw-normal" style="fontt-weight:700">Sign In</h1>
      <div class="alert alert-<?php echo $cls;?>">
        <?php 
          if (isset($_POST['signin'])){
            echo $error;
          }
        ?>
      </div>
      <div class="form-floating">
        <input type="text" class="form-control" name="username" id="username" placeholder="Enter Username">
        <label for="username">Username</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" name="password" id="password" placeholder="Enetr Password">
        <label for="password">Password</label>
      </div>

      <div class="d-flex justify-content-between" style="margin:20px;">
        <div>
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <div>
          <a href="">Forgot Password?</a>
        </div>
      </div>
      <button class="w-100 btn btn-lg btn-orange" type="submit" name="signin">Sign in</button>
      <p class="mt-5 mb-3 text-muted">New User? Create an Account <a href="user_signup.php">Now</a></p>
    </form>
  </main>



</body>

</html>