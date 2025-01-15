<?php
include_once("./database/config.php");

session_start();
error_reporting(0);

$username = $_SESSION['donnername'];

if (!isset($_SESSION['donnername'])) {
    header("Location: donner_login.php");
}

$sql = "SELECT * FROM donners WHERE username='$username'";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

$donner_img=$row['donner_img'];

$_SESSION['donner_img'] = $donner_img;
$_SESSION['donner_id'] = $row['donner_id'];
$_SESSION['username'] = $row['username'];

$donner_id=$row['donner_id'];
$sql22 = "SELECT * FROM messages WHERE donner_id='$donner_id' order by message_id desc";
$result22 = mysqli_query($conn, $sql22);
$row22=mysqli_fetch_assoc($result22);

$donner_read = $row22['donner_read'];
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
                    <a href="donner_home.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-house" style="padding-right:14px;"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="donner_causes.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="donner_blog.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-blog" style="padding-right:14px;"></i>
                        Blog Posts
                    </a>
                </li>
                <li>
                    <a href="donner_pickup.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-list" style="padding-right:14px;"></i>
                        Pick-up Requests
                    </a>
                </li>
                <li>
                    <a href="donner_donation.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-coins" style="padding-right:14px;"></i>
                        Donation History
                    </a>
                </li>
                <?php
                    if($donner_read==0){
                        $sql = "SELECT * from messages where donner_id = $donner_id and `donner_read` = '0'";
                        $result = mysqli_query($conn, $sql);
                        $row_cnt = $result->num_rows;
                ?>
                <!-- <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt?></span>
                    </a>
                </li> -->
                <?php
                    }else{
                ?>
                <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
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
                    <img src="./img/donners/<?php echo $donner_img?>" alt="" width="40" height="40"
                        class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1"
                    style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="donner_profile.php">Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="donner_logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-9" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Blog Posts</h2>
                    <p><a href="donner_home.php">Dashboard</a> / Blog Posts</p>
                </div>
                <div class="col-md-3" style="text-align:right; padding-right:70px; padding-top:20px;">
                    <a href="donner_blog_add.php" class="btn btn-success">Add Post</a>
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
                                
                                if($role=='NGO'){
                                    $sql4 = "SELECT * from ngo where ngo_id = $poster_id";
                                    $result4 = mysqli_query($conn, $sql4);
                                    $row4 =mysqli_fetch_assoc($result4);
                                    $name=$row4['ngo_name'];
                                }
                                
                                // $dt = explode(" ", $post_date);

                            ?>
                        <div class="col-md-4">
                            <div class="card" >
                                <a href="donner_blog_details.php?blog_id=<?php echo $id?>"><img src="img/posts/<?php echo $image?>" class="card-img-top" alt="..." style="height:300px; object-fit:cover"></a>
                                <div class="card-body" style="padding:30px">
                                    <p style="font-size:15px"><i class="fa fa-user text-success"></i> <?php echo $name?> &nbsp; &nbsp; &nbsp;<i class="fa fa-clock text-success"></i> <?php echo $dt[0]." ".$dt[1]." ".$dt[2]?></p>


                                    <h5 class="card-title"><a href="donner_blog_details.php?blog_id=<?php echo $id?>" style="color:black"><?php echo $topic?></a></h5>
                                    <p class="card-text"><?php echo substr($description, 0, 100)?></p>
                                    <a href="donner_blog_details.php?blog_id=<?php echo $id?>" class="btn btn-success">View Post</a>
                                    <?php
                                            if( $role=="Donner" && $poster_id==$donner_id ){
                                            ?>
                                    <a href="donner_blog_delete.php?blog_id=<?php echo $id?>" class="btn btn-danger">Delete Post</a>
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
        </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>