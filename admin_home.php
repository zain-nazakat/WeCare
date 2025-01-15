<?php
include_once("./database/config.php");

session_start();

$username = $_SESSION['adminname'];

if (!isset($_SESSION['adminname'])) {
    header("Location: admin_login.php");
}

$sql = "SELECT * FROM admin WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$admin_img=$row['admin_img'];

$_SESSION['admin_img'] = $admin_img;
$_SESSION['admin_id'] = $row['admin_id'];
$_SESSION['username'] = $row['username'];


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
                    <a href="admin_home.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="admin_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Dashboard</h2>
                    <p>Admin Dashboard</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:18px">Donners</h5>
                        <div class="card-body" style="text-align:center; font-size:15px;">
                            <?php
                                    $sql = "SELECT * from donners";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">NGOs</h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from ngo WHERE `verified`='1' ";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Donation Causes
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from causes";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>

                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card mx-auto"
                        style="text-align:center;padding:20px 0px;box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); height:12rem;">
                        <h5 class="card-title" style="font-family:poppins;color:black;font-size:20px">Donations Recieved
                        </h5>
                        <div class="card-body" style="text-align:center; font-size:18px;">
                            <?php
                                    $sql = "SELECT * from donation";
                                    $result = mysqli_query($conn, $sql);
                                    $row_cnt = $result->num_rows;
                                ?>
                            <h1 style="font-family:poppins;color:black;"><?php echo $row_cnt?></h1>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" style="padding-top:30px;margin-bottom:0px;">
                <div class="col-md-8">
                    <div
                        style="text-align:center;padding:30px 0px; height:500px;">
                        <h3 style="font-size:24px;">Recent NGOs
                        </h3>
                        <div style="padding:20px 40px; text-align:center;font-size:18px;">
                        <table class="table" style="font-size: 14px;color:#222;">
                                    <thead>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Established</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                    </thead>

                                    <tbody>
                                        <?php 
                                            $sql = "SELECT * FROM ngo";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $name=$row['ngo_name'];
                                                    $id=$row['ngo_id'];
                                                    $registration_id=$row['registration_id'];
                                                    $established=$row['established'];
                                                    $address=$row['address'].",".$row['city'].",".$row['zip'];
                                                    $contact=$row['contact'];
                                                    $email=$row['email'];
                                                    $verified=$row['verified'];
                                                    $image=$row['ngo_img'];

                                                    if($verified == 1){
                                                        $type = "success";
                                                        $msg = "Verified";
                                                    }else{
                                                        $type = "danger";
                                                        $msg = "Unverified";
                                                    }
                                        ?>
                                        <tr>
                                            <td><img src="./img/ngos/<?php echo $image?>"
                                                    style="width:90px;" alt="profile">
                                                <span style="padding-left:20px;"></span></td>
                                            <td><?php echo $name ?></td>
                                            <td><?php echo $established ?></td>
                                            <td><?php echo $contact ?></td>
                                            <td><?php echo $email ?></td>
                                            <td style="font-size:14px; font-weight:600;"><button
                                                style="border-radius: 40px; padding:7px 14px; font-size:10px; font-weight:600"
                                                class="btn btn-<?php echo $type?>"><?php echo $msg?></button></td>

                                        </tr>
                                        <?php 
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div
                        style="text-align:center;padding:30px 0px; height:500px;">
                        <h3 style="padding-top:20px;font-size:24px;">Latest Donners</h3>
                        <div style="padding:20px 40px; text-align:left;font-size:18px;">
                            <table class="table">
                                <tbody>
                                <?php 
                                            $sql = "SELECT * FROM donation";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $donation_id=$row['donation_id'];
                                                    $category=$row['category'];
                                                    $amount=$row['amount'];
                                                    $address=$row['address'];
                                                    $date=$row['date'];
                                                    $status=$row['status'];
                                                    $cause_id=$row['cause_id'];
                                                    $poster_id=$row['poster_id'];
                                                    $role=$row['role'];

                                                    if($status == 1){
                                                        $type = "success";
                                                        $msg = "Successfull";
                                                    }                                               
                                                    else if($status == 0){
                                                        $type = "warning";
                                                        $msg = "Processing";
                                                    }
                                                    else{
                                                        $type = "danger";
                                                        $msg = "Canclled";
                                                    }

                                                    $item = "";
      
                                                    if($category=="Food"){
                                                        $item = "Kg.";
                                                    }
                                                    else if($category == "Cloths"){
                                                        $item = "Item";
                                                    }
                                                    else if($category == "Medicine"){
                                                        $item = "Pack";
                                                        
                                                    }else if($category == "Money"){
                                                        $item = "Rs.";
                                                    }

                                 
                                                    
                                                    if($role=="Donner"){
                                                        $sql7 = "SELECT * from donners where donner_id = $poster_id";
                                                        $result7 = mysqli_query($conn, $sql7);
                                                        $row7 =mysqli_fetch_assoc($result7);
                                                        $name=$row7['firstname']." ".$row7['lastname'];
                                                        $img=$row7['donner_img'];

                                                        $dir="donners";
                                                
                                                    }else{
                                                        $sql7 = "SELECT * from ngo where ngo_id = $poster_id";
                                                        $result7 = mysqli_query($conn, $sql7);
                                                        $row7 =mysqli_fetch_assoc($result7);
                                                        $name=$row7['ngo_name'];
                                                        $img=$row7['ngo_img'];

                                                        $dir="ngos";

                                                    }



                                        ?>
                                    <tr>
                                    <td><img src="./img/<?php echo $dir."/".$img?>" style="width:60px;"
                                                alt="profile">
                                        <td><?php echo $name ?></td>
                                        <td><?php echo $amount." ".$item?></td>
                                    </tr>
                                    <?php 
                                                }
                                            }
                                        ?>
                                </tbody>
                            </table>
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