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
                    <a href="ngo_blog.php" class="nav-link text-white active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                <div class="col-md-9" style="padding-bottom:20px;">
                    <h2 style="font-weight:600">Blog Posts</h2>
                    <p><a href="ngo_home.php">Dashboard</a> / Blog Posts</p>
                </div>
                <div class="col-md-3" style="text-align:right; padding-right:70px; padding-top:20px;">
                    <a href="ngo_blog_add.php" class="btn btn-success">Add Blog</a>
                </div>
            </div>
            <div class="row align-items-start py-3">
                <div class="col-lg-12">
                    <div class="row">
                        <?php 

                            $sql = "SELECT * FROM blog ORDER BY blog_id";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                            while($row=mysqli_fetch_assoc($result)){
                                $id=$row['blog_id'];
                                $cause_id=$row['cause_id'];
                                $topic=$row['topic'];
                                $image=$row['post_img'];
                                $post_date=$row['post_date'];
                                $description=$row['description'];
                                $poster_id=$row['poster_id'];
                                $role=$row['role'];

                                $total = 0;
                                $count = 0;
                                $item = "";
                                
                                if($role=='Donner'){
                                    $sql3 = "SELECT * from donners where donner_id = $poster_id";
                                    $result3 = mysqli_query($conn, $sql3);
                                    $row3 =mysqli_fetch_assoc($result3);
                                    $name=$row3['firstname']." ".$row3['lastname'];

                                }
                                elseif($role=='NGO'){
                                    $sql4 = "SELECT * from ngo where ngo_id = $poster_id";
                                    $result4 = mysqli_query($conn, $sql4);
                                    $row4 =mysqli_fetch_assoc($result4);
                                    $name=$row4['ngo_name'];
                                }
                                
                                $dt = explode(" ", $post_date);

                            ?>
                        <div class="col-md-4">
                            <div class="card" >
                                <a href="ngo_blog_details.php?blog_id=<?php echo $id?>"><img src="img/posts/<?php echo $image?>" class="card-img-top" alt="..." style="height:300px; object-fit:cover"></a>
                                <div class="card-body" style="padding:30px">
                                    <p style="font-size:15px"><i class="fa fa-user text-success"></i> <?php echo $name?> &nbsp; &nbsp; &nbsp;</p>


                                    <h5 class="card-title"><a href="ngo_blog_details.php?blog_id=<?php echo $id?>" style="color:black"><?php echo $topic?></a></h5>
                                    <p class="card-text"><?php echo substr($description, 0, 100)?></p>
                                    <a href="ngo_blog_details.php?blog_id=<?php echo $id?>" class="btn btn-success">View Post</a>
                                    <?php
                                            if( $role=="NGO" && $poster_id==$ngo_id ){
                                            ?>
                                    <a href="ngo_blog_delete.php?blog_id=<?php echo $id?>" class="btn btn-danger">Delete Post</a>
                                    <?php
                                            }else{}
                                            ?>
                                </div>
                            </div>
                            
                        </div>
                        <?php 
                            }
                        }
                        ?>
                    </div>
                </div>


            </div>

    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>