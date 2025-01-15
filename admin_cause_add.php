
<?php
include_once("./database/config.php");
date_default_timezone_set('Asia/Karachi');

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


if(isset($_POST['submit'])){


    $cause_title = $_POST['cause_title'];
    $ngo_id = $_POST['ngo_id'];
    $category = $_POST['category'];
    $goal = $_POST['goal'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $date = date("Y-m-d l h:i:sa");

    $error = "";
    $cls="";
 
    $name = $_FILES['file']['name'];
    $target_dir = "img/causes/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
  
    // Select file type
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  
    // Valid file extensions
    $extensions_arr = array("jpg","jpeg","png","gif");

    
            $query = "SELECT * FROM causes WHERE poster_id = '$ngo_id' and role='NGO' AND cause_title = '$cause_title'";
            $query_run = mysqli_query($conn, $query);
            if(!$query_run->num_rows > 0){

                // Check extension
                if( in_array($imageFileType,$extensions_arr) ){

                    // Upload file
                    if(move_uploaded_file($_FILES['file']['tmp_name'],$target_dir.$name)){

                        // Convert to base64 
                        $image_base64 = base64_encode(file_get_contents('img/causes/'.$name));
                        $image = 'data:image/'.$imageFileType.';base64,'.$image_base64;

                        // Insert record

                        $query2 = "INSERT INTO causes(cause_title,cause_img,poster_id,category,goal,`description`,`location`, post_date, `role`)
                        VALUES ('$cause_title','$name','$ngo_id','$category','$goal', '$description', '$location', '$date','NGO')";
                        $query_run2 = mysqli_query($conn, $query2);
            
                        if ($query_run2) {
                            $cls="success";
                            $error = "Cause Successfully Added.";
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
                $error = "Cause Already Exists";
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
                    <a href="admin_ngos.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-building-ngo" style="padding-right:14px;"></i>
                        Manage NGOs
                    </a>
                </li>
                <li>
                    <a href="admin_causes.php" class="nav-link active" aria-current="page"
                        style="background:#fc6806;font-size:17px;">
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
                <div class="col-md-9" style="">
                    <h2 style="font-weight:600">Manage Cause</h2>
                    <p><a href="admin_home.php">Dashboard</a> / <a href="admin_causes.php">Manage Causes</a> / Add
                        Cause</p>
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
                                                <input type="file" name="file" id="file"
                                                    style="padding:30px 0px 0 60px;">

                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Cause Title</label>
                                                <input type="text" class="form-control" name="cause_title"
                                                    id="cause_title" placeholder="Cause Name">
                                            </div>
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Posted By</label>
                                                <select class="form-control" name="ngo_id" id="ngo_id" required>
                                                    <option>-- Select NGO --</option>
                                                    <?php
                                                            $option = "SELECT * FROM ngo";
                                                            $option_run = mysqli_query($conn, $option);

                                                            if (mysqli_num_rows($option_run) > 0) {
                                                                foreach ($option_run as $row2) {
                                                            ?>
                                                    <option value="<?php echo $row2['ngo_id']; ?>">
                                                        <?php echo $row2['ngo_name'];?> </option>
                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                </select>
                                            </div>
                                            <div class="form-group" style="padding:10px">
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
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Donation Goal</label>
                                                <input type="text" class="form-control" name="goal" id="goal"
                                                    placeholder="Donation Goal">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">Operation Location</label>
                                                <input type="text" class="form-control" name="location" id="location"
                                                    placeholder="Operation Location">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">About the Cause</label> <br>
                                                <textarea name="description" id="description" class="form-control" cols="90"
                                                    rows="6" placeholder="Write about the Cause"></textarea>
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
            </div>
    </section>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>