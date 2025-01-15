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

$blog_id = $_GET['blog_id'];

$sql = "SELECT * FROM blog WHERE blog_id = $blog_id";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

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


    if(isset($_POST['submit_comment'])){

        $comment = $_POST['comment'];
        $date = date("l jS \ F Y");
    
        $error = "";
        $cls="";
    
        $query2 = "INSERT INTO comments(commenter_id, blog_id, `message`, reply_date, `role`)
        VALUES ('$ngo_id', '$blog_id', '$comment', '$date','NGO')";
        $query_run2 = mysqli_query($conn, $query2);
                
        if ($query_run2) {
            $cls="success";
            $error = "Comment Successfully Posted.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
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
                    <a href="ngo_causes.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="ngo_blog.php" class="nav-link active" aria-current="page"
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
                    <li><a class="dropdown-item" href="ngo_logout.php">Sign out</a></li>
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
                <div class="col-md-12">
                    <img src="img/posts/<?php echo $image?>" class="card-img-top" alt="Cause" height="412"
                        style="object-fit: cover;">
                </div>
                <div class="col-lg-12">
                    <div class="card-body d-flex" style="margin: 20px">
                        <div style="width:100%">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <p style="font-size:15px"><i class="fa fa-user text-success"></i> <?php echo $name?>
                                        &nbsp;
                                       
                                    </p>
                                </div>
                                <div>
                                    <?php
                                            if( $role=="NGO" && $poster_id==$ngo_id ){
                                            ?>
                                    <a href="ngo_blog_delete.php?blog_id=<?php echo $id?>"
                                        class="btn btn-danger">Delete Post</a>
                                    <?php
                                            }else{}
                                            ?>
                                </div>
                            </div>


                            <h4 class="card-title"><?php echo $topic?></h4>

                            <div class="d-flex justify-content-between"
                                style="font-size:16px; font-weight:600;margin-top:30px">
                                <p style="font-size:16px">Post By: <?php echo $name?></p>
                            </div>
                            <hr>
                            <div>
                                <h5>Cause Description</h5>
                                <hr>
                                <p class="card-text"><?php echo substr($description, 0, 100)?></p>
                            </div>
                            <?php
                            if($role=="Donner"){
                            ?>
                            <div class="d-flex justify-content-between">
                                <div>

                                </div>
                                <div style="margin-top:12px">
                                    <!-- <a href="ngo_create_chat.php?ngo_id=<?php echo $poster_id?>&donner_id=<?php echo $donner_id?>"
                                        class="btn btn-primary">Send Message</a> -->

                                </div>
                            </div>
                            <?php
                            }else{}
                            ?>
                            <hr>

                            <div>
                                <h5>Post Comments</h5>
                                <hr>
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                        $sql = "SELECT  * FROM comments where blog_id ='$blog_id' order by `blog_id` desc";
                                        $result = mysqli_query($conn, $sql);
                                        if ($result) {
                                            while ($row = mysqli_fetch_assoc($result)) {

                                                $commenter_id = $row["commenter_id"];
                                                $role = $row["role"];
                                                $date = $row["reply_date"];
                                                $comment = $row["message"];

                                                if($role=="NGO"){
                                                    $sql11 = "SELECT * FROM ngo WHERE ngo_id='$commenter_id'";
                                                    $result11 = mysqli_query($conn, $sql11);
                                                    $row11=mysqli_fetch_assoc($result11);

                                                    $cimg=$row11['ngo_img'];
                                                    $cname=$row11['ngo_name'];
                                                    $ctype="ngos";
                                                    
                                                }else{
                                                    $sql10 = "SELECT * FROM donners WHERE donner_id='$commenter_id'";
                                                    $result10 = mysqli_query($conn, $sql10);
                                                    $row10=mysqli_fetch_assoc($result10);

                                                    $cimg=$row10['donner_img'];
                                                    $cname=$row10['firstname']." ".$row10['lastname'];
                                                    $ctype="donners";

                                                }



                                    ?>
                                            <div class="media d-flex">
                                                <img src="img/<?php echo $ctype."/".$cimg?>" class="mr-3" alt="..."
                                                    style="height:64px;width:64px;object-fit: cover;">
                                                <div class="media-body" style="margin-left:20px">
                                                    <h5 class="mt-0"><?php echo $cname?></h5>
                                                    <!-- <p style="font-size:13px"><?php echo $date?></p> -->
                                                    <p><?php echo $comment?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <?php
                                                }
                                            }
                                        ?>
                                            <div class="alert alert-<?php echo $cls;?>">
                                                <?php 
                                                    if (isset($_POST['submit_comment'])){
                                                        echo $error;
                                                    }
                                                ?>
                                            </div>
                                            <h5 style="padding-bottom:10px">Leave a Comment</h5>
                                            <form action="" class="contact-comments" method="POST">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group comments">
                                                            <!-- Comment -->
                                                            <textarea class="form-control"
                                                                placeholder="Write Your Comment" rows="8" name="comment"
                                                                required></textarea>
                                                        </div>
                                                        <div class="form-group full-width submit">
                                                            <button type="submit" name="submit_comment"
                                                                class="btn btn-success" style="margin-top:30px">
                                                                Post Comment
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

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