<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WeCare - Blog Details</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,400;0,500;0,600;1,400;1,500;1,600&family=Rubik:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header>
        <nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
            <div class="container-fluid">
                <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                    <img src="./img/logo.png" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="padding-left:15%">
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="education.php">Education Corner</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="ambulance.php">Ambulance Service</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="blogs.php">Blogs</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="About_us.html">About Us</a> 
                        </li>
                    </ul>
                    <div class="d-flex ">
                        <div class="dropdown" style="margin-right:20px;">
                            <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Log In
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="donner_login.php">Donners</a></li>
                                <li><a class="dropdown-item" href="ngo_login.php">NGOs</a></li>
                                <li><a class="dropdown-item" href="admin_login.php">Admin</a></li>
                            </ul>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                Sign Up
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item" href="donner_signup.php">Donners</a></li>
                                <li><a class="dropdown-item" href="ngo_signup.php">NGOs</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main class="container mt-5" style="padding-top: 100px; padding-bottom:30px;">
        <div class="row">
            <?php
            // Include database configuration
            include_once("./database/config.php");

            // Retrieve blog_id from URL parameter
            $blog_id = $_GET['blog_id'];

            // Query to fetch the specific blog post
            $sql = "SELECT * FROM blog WHERE blog_id = $blog_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $topic = $row['topic'];
                $image = $row['post_img'];
                $post_date = $row['post_date'];
                $description = $row['description'];
                $poster_id = $row['poster_id'];
                $role = $row['role'];

                // Example: Fetching the author's name based on their role (Donner or NGO)
                if ($role == 'Donner') {
                    $author_sql = "SELECT firstname, lastname FROM donners WHERE donner_id = $poster_id";
                } elseif ($role == 'NGO') {
                    $author_sql = "SELECT ngo_name FROM ngo WHERE ngo_id = $poster_id";
                } else {
                    // Handle other roles if needed
                }

                $author_result = mysqli_query($conn, $author_sql);
                $author_row = mysqli_fetch_assoc($author_result);
                $author_name = $author_row['firstname'] . ' ' . $author_row['lastname']; // Adjust based on your database schema

                // Display the blog post details
                ?>
                <div class="col-md-8 mx-auto">
                    <div class="card">
                        <img src="img/posts/<?php echo $image ?>" class="card-img-top" alt="Blog Image">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $topic ?></h5>
                            <p class="card-text"><?php echo $description ?></p>
                            <p class="card-text"><small class="text-muted">Posted by <?php echo $author_name ?></small></p>
                        </div>
                    </div>
                </div>
            <?php
            } else {
                echo "<div class='col-md-8 mx-auto'><p class='text-center'>No blog post found.</p></div>";
            }
            ?>
        </div>
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
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Home</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">About Us</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Contact</a></li>
                            <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Our Causes</a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>
