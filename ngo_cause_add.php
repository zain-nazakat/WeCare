<?php
include_once("./database/config.php");
error_reporting(0);

session_start();

// Redirect if NGO is not logged in
if (!isset($_SESSION['ngoname'])) {
    header("Location: ngo_login.php");
    exit;
}

$username = $_SESSION['ngoname'];

// Fetch NGO details
$sql = "SELECT * FROM ngo WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$ngo_id = $row['ngo_id'];

// Fetch unread messages count
$sql22 = "SELECT COUNT(*) as unread_count FROM messages WHERE ngo_id='$ngo_id' AND ngo_read = 0";
$result22 = mysqli_query($conn, $sql22);
$row22 = mysqli_fetch_assoc($result22);
$unread_count = $row22['unread_count'];

if(isset($_POST['submit'])){
    $cause_title = mysqli_real_escape_string($conn, $_POST['cause_title']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $goal = mysqli_real_escape_string($conn, $_POST['goal']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $date = date('Y-m-d H:i:s');

    $error = "";
    $cls = "";

    // File upload handling
    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_type = $_FILES['file']['type'];
    $file_size = $_FILES['file']['size'];

    $target_dir = "img/causes/";
    $target_file = $target_dir . basename($file_name);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($file_tmp);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
            $error = "File is not an image.";
        }
    }

    // Check file size
    if ($file_size > 500000) {
        $uploadOk = 0;
        $error = "Sorry, your file is too large.";
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
        $uploadOk = 0;
        $error = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $cls = "danger";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($file_tmp, $target_file)) {
            $image = $file_name;

            $query = "INSERT INTO causes (cause_title, cause_img, category, goal, `description`, `location`, post_date, poster_id, `role`)
                      VALUES ('$cause_title', '$image', '$category', '$goal', '$description', '$location', '$date', '$ngo_id', 'NGO')";
            $query_run = mysqli_query($conn, $query);

            if ($query_run) {
                $cls = "success";
                $error = "Cause Successfully Added.";
            } else {
                $cls = "danger";
                $error = mysqli_error($conn);
            }
        } else {
            $cls = "danger";
            $error = "Unknown Error Occurred.";
        }
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
                    <a href="ngo_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="ngo_causes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                    <img src="./img/ngos/<?php echo $image?>" alt="" width="60" height="40" class="me-2"
                        style="border-radius:10px">
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
            <div class="row">
                <div class="col-md-9">
                    <h2 style="font-weight:600">Manage Causes</h2>
                    <p><a href="ngo_home.php">Dashboard</a> / <a href="ngo_causes.php">Manage Causes</a> / Add Cause</p>
                </div>

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
                                            <input type="file" name="file" id="file" style="padding:30px 0px 0 60px;">

                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group " style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Cause Title</label>
                                                    <input type="text" class="form-control" name="cause_title"
                                                        id="cause_title" placeholder="Cause Name">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Donation Category</label>
                                                    <select class="form-control" name="category" id="category" required>
                                                        <option>-- Select Donation Category --</option>
                                                        <option value="Money">Money</option>
                                                        <option value="Food">Food</option>
                                                        <option value="Cloths">Cloths</option>
                                                        <option value="Medicine">Medicine</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Donation Goal</label>
                                                    <input type="text" class="form-control" name="goal" id="goal"
                                                        placeholder="Donation Goal">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Operation Location</label>
                                                    <input type="text" class="form-control" name="location"
                                                        id="location" placeholder="Operation Location">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">About the Cause</label> <br>
                                                <textarea name="description" id="description" class="form-control"
                                                    cols="90" rows="6" placeholder="Write about the Cause"></textarea>
                                            </div>
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

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>