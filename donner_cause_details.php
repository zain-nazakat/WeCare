<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Karachi');
error_reporting(0);


session_start();

$username = $_SESSION['donnername'];

if (!isset($_SESSION['donnername'])) {
    header("Location: donner_login.php");
}

$date = date("Y-m-d l h:i:sa");

$sql1 = "SELECT * FROM donners WHERE username='$username'";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);

$donner_id=$row1['donner_id'];
$donner_img=$row1['donner_img'];
$firstname=$row1['firstname'];
$lastname=$row1['lastname'];
$address=$row1['address'];
$city=$row1['city'];
$zip=$row1['zip'];

$_SESSION['donner_img'] = $donner_img;
$_SESSION['donner_id'] = $row1['donner_id'];
$_SESSION['username'] = $row1['username'];

$cause_id =  $_GET['id'];

$sql = "SELECT * FROM causes WHERE `cause_id`= $cause_id ";
$result = mysqli_query($conn, $sql);
$row=mysqli_fetch_assoc($result);

    $id=$row['cause_id'];
    $poster_id=$row['poster_id'];
    $role=$row['role'];
    $cause_title=$row['cause_title'];
    $category=$row['category'];
    $location=$row['location'];
    $goal=$row['goal'];
    $cause_img=$row['cause_img'];
    $description=$row['description'];

      $total = 0;
      $count = 0;
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
          $item = "RS.";
      }

      $sql1 = "SELECT SUM(amount) as total FROM donation WHERE `cause_id`= $id AND `status` = 1";
      $result1 = mysqli_query($conn, $sql1);
      $row1 =mysqli_fetch_assoc($result1);

      $total=$row1['total'];
      if(empty($total))
      {
          $total = 0;
      }

      $sql2 = "SELECT COUNT(amount) as count FROM donation WHERE `cause_id`= $id AND `status` = 1";
      $result2 = mysqli_query($conn, $sql2);
      $row2 =mysqli_fetch_assoc($result2);
      $count=$row2['count'];
      if(empty($count))
      {
          $count = 0;
      }

                                  
    if($role=="Donner"){
        $sql3 = "SELECT * from donners where donner_id = $poster_id";
        $result3 = mysqli_query($conn, $sql3);
        $row3 =mysqli_fetch_assoc($result3);
        $pname=$row3['firstname']." ".$row3['lastname'];

    }else{
        $sql4 = "SELECT * from ngo where ngo_id = $poster_id";
        $result4 = mysqli_query($conn, $sql4);
        $row4 =mysqli_fetch_assoc($result4);
        $pname=$row4['ngo_name'];
    }
    


    if(isset($_POST['submit_money'])){

        $amount = $_POST['amount'];
        $card_number = $_POST['card_number'];
        $card_month = $_POST['card_month'];
        $card_year = $_POST['card_year'];
        $card_cv = $_POST['card_cv'];
    
        $error = "";
        $cls="";
    
        $query2 = "INSERT INTO donation( cause_id, poster_id, `role`, amount, `status`, `date`, card_number, card_month, card_year, card_cv, category)
        VALUES ('$cause_id','$donner_id', 'Donner', '$amount','1', '$date', '$card_number', '$card_month', '$card_year', '$card_cv', 'Money')";
        $query_run2 = mysqli_query($conn, $query2);
                
        if ($query_run2) {
            $cls="success";
            $error = "Donation Successfully Recieved.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
    
    
    }

    if(isset($_POST['submit_item'])){

        $amount = $_POST['amount'];
        $pickup_date = $_POST['date']." ".$_POST['time'];
        $address = $_POST['address']." ".$_POST['city']."-".$_POST['zip'];
    
        $error = "";
        $cls="";
    
        $query2 = "INSERT INTO donation(poster_id,`role`, cause_id,amount, `status`, `date`, `address`,category, pickup_date)
        VALUES ('$donner_id','Donner', '$cause_id', '$amount','0', '$date', '$address','$category','$pickup_date')";
        $query_run2 = mysqli_query($conn, $query2);
                
        if ($query_run2) {
            $cls="success";
            $error = "Donation Successfully Recieved.";
        } 
        else {
            $cls="danger";
            $error = mysqli_error($conn);
        }
    
    
    }

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
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css"
        media="screen">
    <script src="//cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
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
                    <a href="donner_causes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-ribbon" style="padding-right:14px;"></i>
                        Donation Causes
                    </a>
                </li>
                <li>
                    <a href="donner_blog.php" class="nav-link text-white" style="font-size:17px;">
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
                <div class="col-md-12" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Manage Causes</h2>
                    <p><a href="donner_home.php">Dashboard</a> / <a href="donner_causes.php">Manage Causes</a> / Cause
                        Details</p>
                </div>
            </div>
            <div class="row py-3">

                <div class="col-md-12">
                    <img src="img/causes/<?php echo $cause_img?>" class="card-img-top" alt="Cause" height="312"
                        style="object-fit: cover;">
                </div>
                <div class="col-lg-8">
                    <div class="card-body d-flex" style="margin: 20px">
                        <div style="width:100%">

                            <span class="badge text-bg-success"
                                style="margin-right:10px; padding: 6px 15px;"><?php echo $location?></span>
                            <span class="badge text-bg-success" style="padding: 6px 15px;"><?php echo $category?></span>

                            <h4 class="card-title"><?php echo $cause_title?></h4>

                            <div class="progress">
                                <div class="progress-bar" role="progressbar"
                                    style="width: <?php echo ($total/$goal)*100?>%;"
                                    aria-valuenow="<?php echo ($total/$goal)*100?>" aria-valuemin="0"
                                    aria-valuemax="100"><?php echo ($total/$goal)*100?>%</div>
                            </div>

                            <div class="d-flex justify-content-between"
                                style="font-size:16px; font-weight:600;margin-top:30px">
                                <p style="font-size:16px">Recieved: <?php echo $total." ".$item?></p>
                                <p>Target: <?php echo $goal." ".$item?></p>
                            </div>
                            <div class="d-flex justify-content-between"
                                style="font-size:16px; font-weight:600;margin-top:30px">
                                <p style="font-size:16px">Post By: <?php echo $pname?></p>
                            </div>
                            <hr>
                            <div>
                                <h5>Cause Description</h5>
                                <hr>
                                <p class="card-text"><?php echo $description?></p>
                            </div>
                            <?php
                            if($role=="NGO"){
                            ?>
                            <div class="d-flex justify-content-between">
                                <div>

                                </div>
                                <div style="margin-top:12px">
                                    <!-- <a href="donner_create_chat.php?ngo_id=<?php echo $poster_id?>&donner_id=<?php echo $donner_id?>"
                                        class="btn btn-primary">Send Message</a> -->

                                </div>
                            </div>
                            <?php
                            }else{}
                            ?>
                            <hr>

                            <div>
                                <div class="row" style="padding-top:10px">
                                    <div class="col-md-8">
                                        <h5 style="">Cause Images</h5>
                                    </div>
                                  
                                </div>
                                <hr>

                                <div class="row">
                                    <?php 
                                        $sql = "SELECT * from cause_img where cause_id = '$cause_id'";
                                        $result = mysqli_query($conn, $sql);
                                        if($result){
                                            while($row=mysqli_fetch_assoc($result)){
                                            $cause_img=$row['image'];
                                    ?>
                                    <div class="col-lg-6 col-md-4 col-xs-6 thumb">
                                        <a href="img/cause_img/<?php echo $cause_img?>" class="fancybox" rel="ligthbox">
                                            <img src="img/cause_img/<?php echo $cause_img?>" class="zoom img-fluid "
                                                alt="">

                                        </a>
                                    </div>
                                    <?php
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                            <div>
                                <hr>
                                <h5 style="padding-bottom:10px">Blog Posts</h5>
                                <hr>
                                <div class="row">
                                    <div class="container">
                                        <div class="row">
                                            <?php 

                            $sql = "SELECT * FROM blog where cause_id=$cause_id";
                            $result = mysqli_query($conn, $sql);
                            if($result){
                            while($row=mysqli_fetch_assoc($result)){
                                $id=$row['blog_id'];
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
                                
                                $dt = explode(" ", $post_date);

                            ?>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <a href="donner_blog_details.php?blog_id=<?php echo $id?>"><img
                                                            src="img/posts/<?php echo $image?>" class="card-img-top"
                                                            alt="..." style=""></a>
                                                    <div class="card-body" style="padding:30px">
                                                        <p style="font-size:15px"><i
                                                                class="fa fa-user text-success"></i> <?php echo $name?>
                                                            &nbsp; &nbsp; &nbsp;<i class="fa fa-clock text-success"></i>
                                                            <?php echo $dt[0]." ".$dt[1]?></p>


                                                        <h5 class="card-title"><a
                                                                href="donner_blog_details.php?blog_id=<?php echo $id?>"
                                                                style="color:black"><?php echo $topic?></a></h5>
                                                        <p class="card-text"><?php echo substr($description, 0, 100)?>
                                                        </p>
                                                        <a href="donner_blog_details.php?blog_id=<?php echo $id?>"
                                                            class="btn btn-success">View Post</a>
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

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div>
                        <?php
                                if($category=="Money"){
                            ?>
                        <div class="row card" style="padding: 40px 25px; margin-top:50px;">
                            <h5 style="margin-bottom:20px">Donate Now</h5>
                            <div class="alert alert-<?php echo $cls;?>">
                                <?php 
									if (isset($_POST['submit_money']) || isset($_POST['submit_item'])){
										echo $error;
									}
								?>
                            </div>
                            <form action="" method="Post">

                                <div class="col-lg-12">
                                    <div class="form-group" style="padding:10px">
                                        <label for="Amount" style="padding-bottom:10px;">Amount</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="Amount" name="amount"
                                                placeholder="Rs. 1000 Min" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label for="cardNumber" style="padding-bottom:10px;">Card Number</label>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="cardNumber" name="card_number"
                                                placeholder="Valid Card Number" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="padding:10px">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label for="expMonth" style="padding-bottom:10px;">Expiration
                                                    Date</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" class="form-control" id="expMonth" name="card_month"
                                                    placeholder="MM" required data-stripe="exp_month" />
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <input type="text" class="form-control" id="expYear" name="card_year"
                                                    placeholder="YY" required data-stripe="exp_year" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 pull-right">
                                    <div class="form-group" style="padding:10px">
                                        <label for="cvCode" style="padding-bottom:10px;">CV Code</label>
                                        <input type="password" class="form-control" id="cvCode" placeholder="CV"
                                            name="card_cv" required data-stripe="cvc" />
                                    </div>
                                </div>
                                <div class="col-md-12" style="margin-top:20px">
                                    <button name="submit_money" class="btn btn-success">Donate Now</button>
                                </div>
                            </form>
                        </div>
                        <?php
                                }else{
                            ?>
                        <div class="row card" style="padding: 40px 25px; margin-top:50px;">
                            <h5 style="margin-bottom:20px">Donate Now</h5>
                            <div class="alert alert-<?php echo $cls;?>">
                                <?php 
									if (isset($_POST['submit_money']) || isset($_POST['submit_item'])){
										echo $error;
									}
								?>
                            </div>
                            <form action="" method="Post">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="Amount" style="padding-left:10px;">Donation Item</label>
                                        <div class="form-group" style="padding:10px">

                                            <select name="item" id="item" class="form-control">
                                                <option><?php echo $category?></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group" style="padding:10px">
                                        <label style="padding-bottom:10px;">Donation Amount</label>
                                        <input type="text" class="form-control" id="Amount" name="amount"
                                            placeholder="Enter Amount in <?php echo $item?>" required>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="padding:10px">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label for="cardNumber" style="padding-bottom:10px;">Pickup Date</label>
                                                <input type="date" class="form-control" id="date" name="date"/>
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label for="cardNumber" style="padding-bottom:10px;">Pickup Time</label>
                                                <input type="time" class="form-control" id="expYear" name="time"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group" style="padding:10px">
                                        <label for="cardNumber" style="padding-bottom:10px;">Pick-Up Address</label>
                                        <div class="input-group">
                                            <textarea class="form-control" id="cardNumber" name="address"
                                                placeholder="Address" rows="3"><?php echo $address?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="form-group" style="padding:10px">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label for="cardNumber" style="padding-bottom:10px;">City</label>
                                                <input type="text" class="form-control" id="expMonth" name="city"
                                                    placeholder="City" required data-stripe="exp_month"
                                                    value="<?php echo $city?>" />
                                            </div>
                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                <label for="cardNumber" style="padding-bottom:10px;">Zip</label>

                                                <input type="text" class="form-control" id="expYear" name="zip"
                                                    placeholder="Zip" required data-stripe="exp_year"
                                                    value="<?php echo $zip?>" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12" style="margin-top:20px;">
                                    <button class="btn btn-success" name="submit_item">Donate Now</button>
                                </div>
                            </form>

                        </div>
                        <?php
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
    <script>
        $(document).ready(function () {
            $(".fancybox").fancybox({
                openEffect: "none",
                closeEffect: "none"
            });

            $(".zoom").hover(function () {

                $(this).addClass('transition');
            }, function () {

                $(this).removeClass('transition');
            });
        });
    </script>
</body>

</html>