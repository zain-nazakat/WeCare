<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Dhaka');
error_reporting(0);

session_start();

$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
}

$sql = "SELECT * FROM `admin` WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$admin_img = $row['admin_img'];
$firstname=$row['firstname'];
$lastname=$row['lastname'];
$gender=$row['gender'];
$birthday=$row['birthday'];
$contact=$row['contact'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];

if (isset($_POST['submit_img'])) {

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "img/admin/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    // Check extension
    if( in_array($imageFileType,$extensions_arr) ){

        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

            // Convert to base64 
            $image_base64 = base64_encode(file_get_contents('img/admin/'.$name));
            $image = 'data:img/'.$imageFileType.';base64,'.$image_base64;

            // Update Record
            $query2 = "UPDATE `admin` SET `admin_img`='$name' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            $query3 = "UPDATE `logged` SET `image`='$name' WHERE `name`='$username'";
            $query_run3 = mysqli_query($conn, $query3);

            if ($query_run2 && $query_run3) {
                echo "<script> alert('Profile Image Successfully Updated.');
                window.location.href='admin_home.php';</script>";
            } 
            else {
                $cls="danger";
                $error = "Cannot Update Profile Image";
            }

        }else{
            $cls="danger";
            $error = 'Unknown Error Occurred.';
        }
    }else{
        $cls="danger";
        $error = 'Invalid File Type';
    }   
}

if (isset($_POST['submit'])) {

    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $gender=$_POST['gender'];
    $birthday=$_POST['birthday'];
    $contact=$_POST['contact'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];

    $error = "";
    $cls="";

        // Update Record
        $query2 = "UPDATE `admin` SET firstname='$firstname',lastname='$lastname',
        birthday='$birthday', gender='$gender', contact='$contact',
        `address`='$address', city='$city', zip='$zip' WHERE username='$username'";
        $query_run2 = mysqli_query($conn, $query2);
        
        if ($query_run2) {
            $cls="success";
            $error = "Profile Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = "Cannot Update Profile";
        }

}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare</title>
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
                    <a href="admin_ambulance.php" class="nav-link text-white" style="font-size:17px;">
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
                    style="width:200px;padding:20px;">
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
                <div class="col-md-9" style="">
                    <h2 style="font-weight:600">My Profile</h2>
                    <p><a href="admin_home.php">Dashboard</a> / My Profile</p>
                </div>


                <form action="" method="POST" enctype='multipart/form-data'>
                    <div class="row" style="margin-bottom:20px;">

                        <div class="col-md-12">

                            <div style="text-align:center;">
                                <div class="card-body" style="padding:0 20px;">

                                    <div class="alert alert-<?php echo $cls;?>">
                                        <?php 
                                            if (isset($_POST['submit'])){
                                                echo $error;
                                            }
                                        ?>
                                    </div>
                                    <div class="row" style="padding-bottom:30px;">
                                        <div class="col-md-4">
                                            <div class="" style="width: 200px; height: 200px;">
                                                <img src="./img/add.jpg" width="100%" height="100%"
                                                    style="text-align:center; margin-left:60px;">
                                                <input type="file" name="file" id="file"
                                                    style="padding:30px 0px 0 60px;">

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group" style="padding:15px">
                                                <label style="padding-bottom:10px;">First Name</label>
                                                <input type="text" class="form-control" name="firstname" id="firstname"
                                                    value="<?php echo $firstname ?>" placeholder="Firstname" required>
                                            </div>
                                            <div class="form-group" style="padding:15px">
                                                <label style="padding-bottom:10px;">Last Name</label>
                                                <input type="text" class="form-control" name="lastname" id="lastname"
                                                    value="<?php echo $lastname ?>" placeholder="Lastname" required>
                                            </div>
                                            <div class="form-group" style="padding:15px">
                                                <label style="padding-bottom:10px;">Date of Birth</label>
                                                <input type="date" class="form-control" name="birthday" id="birthday"
                                                    value="<?php echo $brithday?>" required>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact"
                                                    value="<?php echo $contact ?>" placeholder="Contact" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Gender</label>
                                                <input type="text" class="form-control" name="gender" id="gender"
                                                    value="<?php echo $gender ?>" placeholder="Gender" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:20px">
                                                <label style="padding-bottom:10px;">Address</label>
                                                <input type="text" class="form-control" name="address" id="address"
                                                    value="<?php echo $address ?>" placeholder="Address" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding:20px">
                                            <label style="padding-bottom:10px;">City</label>
                                            <input type="text" class="form-control" name="city" id="city" value="<?php echo $city ?>"
                                                placeholder="City" required>

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group" style="padding:20px">
                                            <label style="padding-bottom:10px;">Zip</label>
                                            <input type="text" class="form-control" name="zip" id="zip" value="<?php echo $zip ?>"
                                                placeholder="Zip" required>

                                        </div>
                                    </div>
                                    </div>


                                    <div class="d-flex justify-content-end" style="padding-top:20px;">
                                        <button type="submit" name="submit" class="btn btn-success"
                                            style="margin-right:10px;"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Add
                                            Cause</button>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>

                </form>
            </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>