<?php
include_once("./database/config.php");
error_reporting(0);
session_start();
$username = $_SESSION['ngoname'];

if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
}

$sql = "SELECT * FROM ngo WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$ngo_id = $row['ngo_id'];
$image = $row['ngo_img'];
$ngo_name=$row['ngo_name'];
$registration_id=$row['registration_id'];
$about=$row['about'];
$established=$row['established'];
$email=$row['email'];
$contact=$row['contact'];
$address=$row['address'];
$city=$row['city'];
$zip=$row['zip'];
$reg_img=$row['reg_img'];

if (isset($_POST['submit_img'])) {

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "img/ngos/";
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
            $image_base64 = base64_encode(file_get_contents('img/ngos/'.$name));
            $image = 'data:img/'.$imageFileType.';base64,'.$image_base64;

            // Update Record
            $query2 = "UPDATE ngo SET `ngo_img`='$name' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            if ($query_run2) {
                echo "<script> alert('Profile Image Successfully Updated.');
                window.location.href='ngo_home.php';</script>";
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

if (isset($_POST['submit_reg'])) {

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "img/reg/";
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
            $image_base64 = base64_encode(file_get_contents('img/reg/'.$name));
            $image = 'data:img/'.$imageFileType.';base64,'.$image_base64;

            // Update Record
            $query2 = "UPDATE ngo SET `reg_img`='$name' WHERE username='$username'";
            $query_run2 = mysqli_query($conn, $query2);

            if ($query_run2) {
                $cls="success";
                $error = "Registration Documents Submitted.";
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

    
    $ngo_name = $_POST['ngo_name'];
    $established = $_POST['established'];
    $registration_id=$_POST['registration_id'];
    $about=$_POST['about'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $address=$_POST['address'];
    $city=$_POST['city'];
    $zip=$_POST['zip'];

    $error = "";
    $cls="";

        // Update Record
        $query2 = "UPDATE ngo SET ngo_name='$ngo_name',established='$established', 
        about='$about', email='$email', contact='$contact',registration_id='$registration_id',
        `address`='$address', city='$city', zip='$zip' WHERE username='$username'";
        $query_run2 = mysqli_query($conn, $query2);
        
        if ($query_run2) {
            $cls="success";
            $error = "Profile Successfully Updated.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }

}
$sql22 = "SELECT * FROM messages WHERE ngo_id='$ngo_id' order by message_id desc";
$result22 = mysqli_query($conn, $sql22);
$row22=mysqli_fetch_assoc($result22);

$ngo_read = $row22['ngo_read'];

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
                    <a href="ngo_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="ngo_causes.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="ngo_blog.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-blog" style="padding-right:14px;"></i>
                        Blog Posts
                    </a>
                </li>
                <li>
                    <a href="ngo_pickup.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-list" style="padding-right:14px;"></i>
                        Pick-up Requests
                    </a>
                </li>
                <li>
                    <a href="ngo_donation.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-coins" style="padding-right:14px;"></i>
                        Donation History
                    </a>
                </li>
                <li>
                    <a href="ngo_education.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-book" style="padding-right:14px;"></i>
                        Education Content
                    </a>
                </li>
                <?php
                    if($ngo_read==0){
                        $sql = "SELECT * from messages where ngo_id = $ngo_id and `ngo_read` = '0'";
                        $result = mysqli_query($conn, $sql);
                        $row_cnt = $result->num_rows;
                ?>
                <!-- <li>
                    <a href="ngo_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt?></span>
                    </a>
                </li> -->
                <?php
                    }else{
                ?>
                <li>
                    <a href="ngo_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages
                    </a>
                </li>
                <?php
                    }
                ?>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                    id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./img/ngos/<?php echo $image?>" alt="" width="60" height="40"
                        class="me-2" style="border-radius:10px">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:20px;">
                    <li><a class="dropdown-item" href="ngo_profile.php">Profile</a></li>
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
                    <p><a href="ngo_home.php">Dashboard</a> / My Profile</p>
                </div>


                <div class="row">
                    <div class="col-md-4">
                        <div style="text-align:center;padding-bottom:50px;margin-top:50px;">
                            <h4 style="padding-bottom:20px;">Profile Image</h4>
                            <div>
                                <form action="" method="POST" enctype='multipart/form-data' style="margin-bottom:50px;">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12" style="width: 340px; height: 200px;">
                                                <img src="./img/ngos/<?php echo $image?>" width="100%" height="100%"
                                                    style="text-align:center; margin-left:10px;">
                                            </div>
                                            <div class="col-md-12" style="padding-top:20px;">
                                                <div class="d-flex justify-content-center"
                                                    style="padding-top:10px; padding-left:30px;">
                                                    <input type="file" name="file" id="file" style="padding-left:40px;">

                                                </div>

                                                <div class="d-flex justify-content-center" style="padding-top:10px;">
                                                    <button type="submit_img" name="submit_img" class="btn btn-success"
                                                        style="margin-top:20px;"><i class="fa fa-edit"></i> Update
                                                        Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            if(empty($reg_img))
                            {
                        ?>
                        <div style="text-align:center;padding-bottom:30px; ">
                            <h4>Licence Image</h4>

                            <div>
                                <form action="" method="POST" enctype='multipart/form-data'>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-12" style="padding-top:20px;">
                                                <div class="col-md-12" style="width: 200px; height: 200px;">
                                                    <img src="./img/add.jpg" width="100%" height="100%"
                                                        style="text-align:center; margin-left:80px;">
                                                </div>

                                                <div class="d-flex justify-content-center"
                                                    style="padding-top:10px; padding-left:30px;">
                                                    <input type="file" name="file" id="file"
                                                        style="padding-left:40px;padding-top:20px;">
                                                </div>

                                                <div class="d-flex justify-content-center" style="padding-top:10px;">
                                                    <button type="submit_reg" name="submit_reg" class="btn btn-success"
                                                        style="margin-top:20px;"><i class="fa fa-edit"></i> Add
                                                        Image</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <?php
                            }
                        ?>
                    </div>
                    <div class="col-md-8">
                        <div style="text-align:center;padding-top:50px; padding-bottom:20px">
                            <h4>My Profile</h4>
                            <div style="padding:0 40px;">
                                <form action="" method="POST" enctype='multipart/form-data'>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="alert alert-<?php echo $cls;?>">
                                                <?php 
                                                    if (isset($_POST['submit']) || isset($_POST['submit_img'])|| isset($_POST['submit_reg'])){
                                                        echo $error;
                                                }?>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">NGO Name</label>
                                                <input type="text" class="form-control" name="ngo_name" id="ngo_name"
                                                    value="<?php echo $ngo_name ?>" placeholder="NGO Name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Regestration Id</label>
                                                <input type="text" class="form-control" name="registration_id"
                                                    id="registration_id" value="<?php echo $registration_id ?>"
                                                    placeholder="Regestration Id" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Established Date</label>
                                                <input type="date" class="form-control" name="established"
                                                    id="established" value="<?php echo $established ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Email</label>
                                                <input type="text" class="form-control" name="email" id="email"
                                                    placeholder="Email Address" value="<?php echo $email ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Contact</label>
                                                <input type="text" class="form-control" name="contact" id="contact"
                                                    value="<?php echo $contact ?>" placeholder="contact" required>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Address</label>
                                                <input type="text" class="form-control" name="address" id="address"
                                                    value="<?php echo $address ?>" placeholder="Address" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">City</label>
                                                <input type="text" class="form-control" name="city" id="city"
                                                    value="<?php echo $city ?>" placeholder="City" required>

                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Zip</label>
                                                <input type="text" class="form-control" name="zip" id="zip"
                                                    value="<?php echo $zip ?>" placeholder="Zip" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">About the NGO</label>

                                                <textarea class="form-control" id="about" name="about" rows="8"
                                                    placeholder="About the NGO..."><?php echo $about ?></textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end" style="padding-top:10px;">
                                        <button type="submit" name="submit" class="btn btn-success"
                                            style="margin-right:10px;margin-top:10px;"><i class="fa fa-edit"></i>
                                            Update</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>