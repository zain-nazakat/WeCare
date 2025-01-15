<?php
include_once("./database/config.php");

session_start();
error_reporting(0);

// Check if session is valid
if (!isset($_SESSION['donnername'])) {
    header("Location: donner_login.php");
    exit;
}

$username = $_SESSION['donnername'];

// Fetch donor details using prepared statements
$stmt = $conn->prepare("SELECT * FROM donners WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();

if (!$row) {
    header("Location: donner_login.php");
    exit;
}

$donner_img = $row['donner_img'];

$_SESSION['donner_img'] = $donner_img;
$_SESSION['donner_id'] = $row['donner_id'];
$_SESSION['username'] = $row['username'];

$donner_id = $row['donner_id'];

// Fetch latest message
$stmt22 = $conn->prepare("SELECT * FROM messages WHERE donner_id=? ORDER BY message_id DESC LIMIT 1");
$stmt22->bind_param("i", $donner_id);
$stmt22->execute();
$result22 = $stmt22->get_result();
$row22 = $result22->fetch_assoc();
$stmt22->close();

$donner_read = $row22['donner_read'];

if(isset($_POST['submit'])){
    $cause_title = $conn->real_escape_string($_POST['cause_title']);
    $category = $conn->real_escape_string($_POST['category']);
    $goal = $conn->real_escape_string($_POST['goal']);
    $description = $conn->real_escape_string($_POST['description']);
    $location = $conn->real_escape_string($_POST['location']);
    $date = date('Y-m-d H:i:s'); // Store date in standard format

    $error = "";
    $cls = "";

    $name = $_FILES['file']['name'];
    $target_dir = "img/causes/";
    $target_file = $target_dir . basename($name);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $extensions_arr = array("jpg", "jpeg", "png", "gif");

    // Check if cause already exists
    $stmt_check = $conn->prepare("SELECT * FROM causes WHERE poster_id=? AND cause_title=?");
    $stmt_check->bind_param("is", $donner_id, $cause_title);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $stmt_check->close();

    if($result_check->num_rows == 0){
        if(in_array($imageFileType, $extensions_arr)){
            if(move_uploaded_file($_FILES['file']['tmp_name'], $target_dir.$name)){
                $stmt_insert = $conn->prepare("INSERT INTO causes (cause_title, cause_img, category, goal, description, location, post_date, poster_id, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Donner')");
                $stmt_insert->bind_param("sssisssi", $cause_title, $name, $category, $goal, $description, $location, $date, $donner_id);
                if($stmt_insert->execute()){
                    $cls = "success";
                    $error = "Cause Successfully Added.";
                } else {
                    $cls = "danger";
                    $error = "Database Error: " . $conn->error;
                }
                $stmt_insert->close();
            } else {
                $cls = "danger";
                $error = "Unknown Error Occurred.";
            }
        } else {
            $cls = "danger";
            $error = "Invalid File Type.";
        }
    } else {
        $cls = "danger";
        $error = "Cause Already Exists.";
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/sidebars.css">
</head>

<body>

    <section class="d-flex">
        <div class="header d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 280px;">
            <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none" style="padding:5px 30px;">
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
                    <a href="donner_causes.php" class="nav-link active" aria-current="page" style="background:#fc6806;font-size:17px;">
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
                <?php if($donner_read == 0): ?>
                <!-- <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $result22->num_rows ?></span>
                    </a>
                </li> -->
                <?php else: ?>
                <li>
                    <a href="donner_chat.php" class="nav-link text-white" style="font-size:17px;">
                        <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                        Messages
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <hr>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="./img/donners/<?php echo $donner_img?>" alt="" width="40" height="40" class="rounded-circle me-2">
                    <strong><?php echo $username?></strong>
                </a>
                <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1" style="width:200px;padding:10px;">
                    <li><a class="dropdown-item" href="donner_profile.php">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="donner_logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>

        <div class="main">
            <div class="row">
                <div class="col-md-9" style="padding-bottom:30px;">
                    <h2 style="font-weight:600">Add Cause</h2>
                    <p><a href="donner_home.php">Dashboard</a> / <a href="donner_causes.php">Manage Causes</a> / Add Cause</p>
                </div>
            </div>

            <form action="" method="POST" enctype='multipart/form-data'>
                <div class="row" style="margin-bottom:20px;">
                    <div class="col-md-12">
                        <div style="text-align:center;">
                            <div class="card-body" style="padding:0 20px;">
                                <div class="alert alert-<?php echo $cls;?>">
                                    <?php if (isset($_POST['submit'])) echo $error; ?>
                                </div>
                                <div class="row" style="padding-bottom:30px;">
                                    <div class="col-md-4">
                                        <div class="" style="width: 200px; height: 200px;">
                                            <img src="./img/add.jpg" width="100%" height="100%" style="text-align:center; margin-left:60px;">
                                            <input type="file" name="file" id="file" style="padding:30px 0px 0 60px;">
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Cause Title</label>
                                                    <input type="text" class="form-control" name="cause_title" id="cause_title" placeholder="Cause Name">
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
                                                    <input type="text" class="form-control" name="goal" id="goal" placeholder="Donation Goal">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group" style="padding:10px;margin-bottom:12px">
                                                    <label style="padding-bottom:10px;">Operation Location</label>
                                                    <input type="text" class="form-control" name="location" id="location" placeholder="Operation Location">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group" style="padding:10px">
                                                <label style="padding-bottom:10px;">About the Cause</label> <br>
                                                <textarea name="description" id="description" class="form-control" cols="90" rows="6" placeholder="Write about the Cause"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end" style="padding-top:10px;">
                                    <button type="submit" name="submit" class="btn btn-success" style="margin-right:10px;"><i class="fas fa-plus-square"></i>&nbsp;&nbsp;Add Cause</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
