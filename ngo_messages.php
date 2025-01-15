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
$ngo_img = $row['ngo_img'];
$ngo_name=$row['ngo_name'];


$room_id= $_GET['room_id'];

#room info
$sql1 = "SELECT * from messages WHERE room_id=$room_id";
$result1 = mysqli_query($conn, $sql1);
$row1=mysqli_fetch_assoc($result1);

$ngo_id=$row1['ngo_id'];
$donner_id=$row1['donner_id'];
$message=$row1['message'];
$send_time=$row1['send_time'];


#set message view to 1
$query2 = "UPDATE messages SET ngo_read = 1 Where ngo_id=$ngo_id AND room_id=$room_id";
$query_run2 = mysqli_query($conn, $query2);

#ngo info
$sql2 = "SELECT * from donners WHERE donner_id=$donner_id";
$result2 = mysqli_query($conn, $sql2);
$row2=mysqli_fetch_assoc($result2);

$donner_name=$row2['firstname']." ".$row2['lastname'];
$donner_img=$row2['donner_img'];
$status=$row2['status'];

if(isset($_POST['submit'])){

    $message = $_POST['message'];
    $date = date("h:i:sa");


        // Insert record

        $query2 = "INSERT INTO messages(room_id,donner_id,ngo_id,message,send_time,sender,ngo_read)
        VALUES ('$room_id', '$donner_id','$ngo_id','$message', '$date', '1', '1')";
        $query_run2 = mysqli_query($conn, $query2);
            
        if ($query_run2) {
            $cls="success";
            $error = "Message Successfully Added.";
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
                    <a href="ngo_chat.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt?></span>
                    </a>
                </li> -->
                <?php
                    }else{
                ?>
                <li>
                    <a href="ngo_chat.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                    <img src="./img/ngos/<?php echo $ngo_img?>" alt="" width="60" height="40" class="me-2"
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
                    <h2 style="font-weight:600">Manage Causes</h2>
                    <p><a href="ngo_home.php">Dashboard</a> / My Chats</p>
                </div>
            </div>
            <div class="card-body">
                <div class="col-12 col-lg-12 col-xl-12" style="height:57vh; overflow-y: scroll;">

                    <div class="position-relative">
                        <div class="chat-messages p-3" style="display: flex;
flex-direction: column-reverse;">
                            <?php
                                            #getting message data from the database
                                            $sql = "SELECT * from messages WHERE donner_id=$donner_id AND ngo_id =$ngo_id";
                                            $result = mysqli_query($conn, $sql);
                                            if($result){
                                                while($row=mysqli_fetch_assoc($result)){
                                                    $message = $row['message'];
                                                    $send_time = $row['send_time'];
                                                    $sender = $row['sender'];

                                                    if($sender == 0){

                                        ?>
                                                                    <div class="d-flex pb-4" style="padding-top:10px;">
                                <div style="margin-right:20px;">
                                    <img src="img/donners/<?php echo $donner_img?>" class="rounded-circle mr-1"
                                        alt="Sanjida Jalal" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2"><?php echo $send_time ?></div>
                                </div>
                                <div class="flex-shrink-1 bg-light rounded py-2 px-3 ml-3">
                                    <div class="font-weight-bold mb-1" style="font-weight:600;">
                                        <?php echo $donner_name?></div>
                                    <?php echo $message?>
                                </div>
                            </div>


                            <?php
                                                    }else{

                                        ?>
                            <div class="d-flex justify-content-end mb-4" style="padding-top:10px;">
                                <div class="bg-light rounded py-2 px-3 mr-3" style="margin-right:20px;">
                                    <div class="mb-1" style="font-weight:600;">You</div>
                                    <?php echo $message?>
                                </div>
                                <div>
                                    <img src="img/ngos/<?php echo $ngo_img?>" class="rounded-circle mr-1"
                                        alt="Chris Wood" width="40" height="40">
                                    <div class="text-muted small text-nowrap mt-2"><?php echo $send_time ?></div>
                                </div>

                            </div>

                            <?php
                                                    }
                                                }
                                            }
                                        ?>
                        </div>
                    </div>
                </div>

                <form action="" method="POST">
                    <div class="flex-grow-0 py-3 px-4 border-top">
                        <div class="input-group">
                            <input type="text" name="message" class="form-control" placeholder="Type your message">
                            <button class="btn btn-primary" type="submit" name="submit">Send</button>
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