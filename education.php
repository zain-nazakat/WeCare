<?php
// Database connection
$servername = "localhost"; // Change if your DB server is different
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "wecare"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from education_content table
$sql = "SELECT * FROM education_content";
$result = $conn->query($sql);

// Check if any results are returned
if ($result->num_rows > 0) {
    $education_content = [];
    while($row = $result->fetch_assoc()) {
        $education_content[] = $row;
    }
} else {
    $education_content = [];
}

$conn->close();
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare: Reducing Food Waste</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }

        main {
            padding: 60px 20px;
        }

        section {
            margin-bottom: 40px;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .img-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-between;
        }

        .img-small {
            width: 48%;
            margin-bottom: 20px;
        }

        .hero-image {
            width: 100%;
            height: 600px;
            background: url('https://stanfordbloodcenter.org/wp-content/uploads/2024/03/special-donations-banner.png') center center / cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.6);
        }

        .hero-image h1 {
            background: rgba(0, 0, 0, 0.4);
            padding: 15px 25px;
            border-radius: 8px;
            font-size: 2rem;
        }


        @media (max-width: 768px) {
            .hero-image h1 {
                font-size: 1.8rem;
            }

            .img-small {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none">
            <img src="./img/logo.png" alt="WeCare Logo" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="education.php">Education Corner</a></li>
                <li class="nav-item"><a class="nav-link" href="ambulance.php">Ambulance Service</a></li>
                <li class="nav-item"><a class="nav-link" href="blogs.php">Blogs</a></li>
                <li class="nav-item"><a class="nav-link" href="stats.php">Stats</a></li>
                <li class="nav-item"><a class="nav-link" href="About_us.html">About Us</a></li>
            </ul>
            <div class="d-flex">
                <div class="dropdown mx-2">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="loginDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                        <li><a class="dropdown-item" href="donner_login.php">Donors</a></li>
                        <li><a class="dropdown-item" href="ngo_login.php">NGOs</a></li>
                        <li><a class="dropdown-item" href="admin_login.php">Admin</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="signupDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        Sign Up
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="signupDropdown">
                        <li><a class="dropdown-item" href="donner_signup.php">Donors</a></li>
                        <li><a class="dropdown-item" href="ngo_signup.php">NGOs</a></li>
                        <li><a class="dropdown-item" href="driver_registeration.php">Request Services</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="hero-image">
    <h1>WeCare: Live Happy</h1>
</div>

<main>
    <section id="form-section">
        <h2>Awareness/Education Corner</h2>

        <?php if (!empty($education_content)): ?>
            <div class="img-container">
                <?php foreach ($education_content as $content): ?>
                    <div class="img-small">
                        <h3><?php echo htmlspecialchars($content['heading']); ?></h3>
                        <!-- Display the image from the 'uploads/education' directory -->
                        <img src="uploads/education/<?php echo htmlspecialchars($content['picture']); ?>" alt="Image" class="img-fluid">
                        <p><?php echo nl2br(htmlspecialchars($content['description'])); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>No educational content available at the moment.</p>
        <?php endif; ?>
    </section>
</main>

<footer class="bg-dark text-light" style="padding:30px;">
        <div class="container">
            <footer class="py-5">
                <div class="row">
                    <div class="col-md-4">
                        <form>
                            <img src="./img/logo.png" alt="" style="padding-bottom:15px;">

                            <p style="padding-right:60px;text-align:justify">Welcome to WeCare, the website dedicated to providing food, clothing, and medicine to
                                those in need. Our mission is to help the less
                                fortunate in our community and around the world.

                            </p>

                        </form>
                    </div>

                    <div class="col-md-2 ">
                        <h5>Quick Links</h5>
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="index.php" class="nav-link p-0 text-light">Home</a></li>
                            <li class="nav-item mb-2"><a href="About_us.html" class="nav-link p-0 text-light">About Us</a></li>
                           
                            <li class="nav-item mb-2"><a href="stats.php" class="nav-link p-0 text-light">Our Causes</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Contact</a></li>
                            
                        </ul>
                    </div>


                    <div class="col-md-6">
                        <form>
                            <h5>Subscribe to our Newsletter</h5>
                            <p>Monthly digest of what's new and exciting from us.</p>
                            <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                                <label for="newsletter1" class="visually-hidden">Email address</label>
                                <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                                <button class="btn btn-orange" type="button">Subscribe</button>
                            </div>
                        </form>
                    </div>
                </div>

            </footer>
        </div>
    </footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
