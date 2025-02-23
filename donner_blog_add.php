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

if(isset($_POST['submit'])){


    $title = $_POST['title'];
    $cause_id = $_POST['cause_id'];
    $description = $_POST['description'];
    $date=  date('d F Y h:i A');

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "img/posts/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    
            $query = "SELECT * FROM blog WHERE poster_id = '$donner_id' AND topic = '$title'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){

                    // Upload file
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

                        // Convert to base64 
                        $image_base64 = base64_encode(file_get_contents('img/posts/'.$name));
                        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                        // Insert record

                        $query2 = "INSERT INTO blog(topic,post_img,`description`,`cause_id`, post_date, poster_id, `role`)
                        VALUES ('$title','$name', '$description', '$cause_id', '$date', '$donner_id', 'Donner')";
                        $query_run2 = mysqli_query($conn, $query2);
            
                        if ($query_run2) {
                            $cls="success";
                            $error = "Post Successfully Added.";
                        } 
                        else {
                            $cls="danger";
                            $error = mysqli_error($conn);
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
            else{
                $cls="danger";
                $error = "Post Already Exists";
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
                    <h2 style="font-weight:600">Add Post</h2>
                    <p><a href="donner_home.php">Dashboard</a> / <a href="donner_causes.php">Blog Post</a>/ Add
                        Post</p>
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
                                            <div class="col-md-12">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Blog Title</label>
                                                    <input type="text" class="form-control" name="title"
                                                        id="title" placeholder="Blog Title">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Cause Name</label>
                                                    <select class="form-control" name="cause_id" id="cause_id" required>
                                                    <option value="1">-- Select Cause --</option>
                                                    <?php
                                                            $option = "SELECT * FROM causes where cause_id <> 1";
                                                            $option_run = mysqli_query($conn, $option);

                                                            if (mysqli_num_rows($option_run) > 0) {
                                                                foreach ($option_run as $row2) {
                                                            ?>
                                                    <option value="<?php echo $row2['cause_id']; ?>">
                                                        <?php echo $row2['cause_title'];?> </option>
                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">About the Cause</label> <br>
                                                <textarea name="description" id="description" class="form-control"
                                                    cols="90" rows="10" placeholder="Write about the Cause"></textarea>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div class="d-flex justify-content-end" style="padding-top:10px;">
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