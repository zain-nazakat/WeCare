<?php
include_once("./database/config.php");

session_start();
error_reporting(0);

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
                    <a href="admin_ngos.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
            <div class="row d-flex justify-content-between">
                <div class="col-md-6" style="padding-bottom:20px;">
                    <h2 style="font-weight:600">Verify NGOs</h2>
                    <p><a href="admin_home.php">Dashboard</a> / <a href="admin_ngos.php">Manage NGOs</a> / Verify NGO
                    </p>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div style="text-align:center;">

                            <div class="card-body" style="text-align:left;font-size:18px;">
                                <table class="table" style="font-size: 14px;color:#222;">
                                    <thead>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Registration No.</th>
                                        <th>Contact</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Licence</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody>
                                        <?php 
                                            $sql = "SELECT * FROM ngo WHERE `verified`='0'";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                $name=$row['ngo_name'];
                                                $id=$row['ngo_id'];
                                                $ngo_reg_id=$row['registration_id'];
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
                                            <td><img src="./img/ngos/<?php echo $image ?>"
                                                    style="width:80px;border-radius: 20%;" alt="profile"> <span
                                                    style="padding-left:20px;"></span></td>

                                            <td><a href="#"><?php echo $name ?></a></td>
                                            <td><?php echo $ngo_reg_id ?></td>
                                            <td><?php echo $contact ?></td>
                                            <td><?php echo $email ?></td>
                                            <td><?php echo $address ?></td>
                                            <td>
                                                <a href="admin_ngo_licence.php?id=<?php echo $id ?>"
                                                    class="btn btn-success">View</a>
                                            </td>
                                            <td>
                                                <a href="admin_ngo_verification.php?id=<?php echo $id ?>"
                                                    class="btn btn-success" style="margin-bottom:8px;">Verify</a>
                                                <a href="admin_ngo_delete.php?id=<?php echo $id ?>"
                                                    class="btn btn-danger" style="padding:5px;">Delete</a>
                                            </td>

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