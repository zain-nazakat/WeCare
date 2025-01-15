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
$row = mysqli_fetch_assoc($result);

$ngo_id = $row['ngo_id'];
$image = $row['ngo_img'];
$ngo_name = $row['ngo_name'];
$registration_id = $row['registration_id'];
$about = $row['about'];
$established = $row['established'];
$email = $row['email'];
$contact = $row['contact'];
$address = $row['address'];
$city = $row['city'];
$zip = $row['zip'];
$reg_img = $row['reg_img'];

$sql22 = "SELECT * FROM messages WHERE ngo_id='$ngo_id' ORDER BY message_id DESC";
$result22 = mysqli_query($conn, $sql22);
$row22 = mysqli_fetch_assoc($result22);

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
        <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none" style="padding:5px 30px;">
            <img src="./img/logo.png" alt="">
        </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="ngo_causes.php" class="nav-link text-white" style="font-size:17px;">
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
                <a href="ngo_education.php" class="nav-link active" aria-current="page" style="background:#fc6806;font-size:17px;">
                    <i class="fa-solid fa-book" style="padding-right:14px;"></i>
                    Education Content
                </a>
            </li>
            <?php
            if ($ngo_read == 0) {
                $sql = "SELECT * from messages where ngo_id = $ngo_id and `ngo_read` = '0'";
                $result = mysqli_query($conn, $sql);
                $row_cnt = $result->num_rows;
            ?>
            <!-- <li>
                <a href="ngo_chat.php" class="nav-link text-white" style="font-size:17px;">
                    <i class="fa-solid fa-message" style="padding-right:14px;"></i>
                    Messages <span class="badge bg-danger" style="margin-bottom:2px"><?php echo $row_cnt ?></span>
                </a>
            </li> -->
            <?php
            } else {
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
                <img src="./img/ngos/<?php echo $image ?>" alt="" width="60" height="40" class="me-2" style="border-radius:10px">
                <strong><?php echo $username ?></strong>
            </a>
            <ul class="dropdown-menu dropdown-menu text-small shadow" aria-labelledby="dropdownUser1" style="width:200px;padding:20px;">
                <li><a class="dropdown-item" href="ngo_profile.php">Profile</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="row d-flex justify-content-between">
            <div class="col-md-12" style="padding-bottom:0px;">
                <h2 style="font-weight:600">ADD EDUCATION / INFORMATION</h2>
                <p>Education Content</p>
                <!-- Add/New Button -->
                <a href="ngo_education.php" class="btn btn-success">Add/New</a>
            </div>
        </div>
        
        <!-- Display Education Content Section -->
        <div class="row mt-4">
            <div class="col-md-12">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Heading</th>
                            <th>Description</th>
                            <th>Picture</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php
    // Fetch education content from the database
    $edu_sql = "SELECT * FROM education_content WHERE ngo_username='$username'";
    $edu_result = mysqli_query($conn, $edu_sql);

    if (mysqli_num_rows($edu_result) > 0) {
        while ($edu_row = mysqli_fetch_assoc($edu_result)) {
            $id = $edu_row['id']; // Assuming 'id' is the primary key in 'education_content'
            $heading = $edu_row['heading'];
            $description = $edu_row['description'];
            $picture = $edu_row['picture'];

            echo "<tr>
                    <td>$heading</td>
                    <td>$description</td>
                    <td><img src='./uploads/education/$picture' alt='image' width='100'></td>
                    <td>
                        
                        <a href='ngo_education_delete.php?id=$id' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to delete this item?\")'>Delete</a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='4'>No content available.</td></tr>";
    }
    ?>
</tbody>

                </table>
            </div>
        </div>
    </div>

</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

</body>

</html>
