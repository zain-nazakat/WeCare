<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "wecare");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total number of causes
$sql_total_causes = "SELECT COUNT(*) AS total_causes FROM causes";
$result_total_causes = mysqli_query($conn, $sql_total_causes);
$total_causes = mysqli_fetch_assoc($result_total_causes)['total_causes'] ?? 0;

// Fetch total donations
$sql_total_donations = "SELECT SUM(amount) AS total_donations FROM donation";
$result_total_donations = mysqli_query($conn, $sql_total_donations);
$total_donations = mysqli_fetch_assoc($result_total_donations)['total_donations'] ?? 0;

// Fetch total verified NGOs
$sql_total_ngos = "SELECT COUNT(*) AS total_ngos FROM ngo WHERE verified = 1";
$result_total_ngos = mysqli_query($conn, $sql_total_ngos);
$total_ngos = mysqli_fetch_assoc($result_total_ngos)['total_ngos'] ?? 0;

// Fetch categories and their counts
$sql_categories = "SELECT category, COUNT(*) AS count FROM causes GROUP BY category";
$result_categories = mysqli_query($conn, $sql_categories);

$categories = [];
$counts = [];

while ($row = mysqli_fetch_assoc($result_categories)) {
    $categories[] = $row['category'];
    $counts[] = $row['count'];
}

// Convert data to JSON for use in JavaScript
$categories_json = json_encode($categories);
$counts_json = json_encode($counts);

// Close the database connection
$conn->close();
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare Stats</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
<header>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
    <div class="container-fluid">
        <a href="" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="./img/logo.png" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
            aria-expanded="false" aria-label="Toggle navigation">
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
                    <a class="nav-link" href="blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="stats.html">Stats</a> 
                    
                </li>
            </ul>
            <div class="d-flex ">
                <div class="dropdown" style="margin-right:20px;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="donner_login.php">Donners</a></li>
                        <li><a class="dropdown-item" href="ngo_login.php">NGOs</a></li>
                        <li><a class="dropdown-item" href="admin_login.php">Admin</a></li>
                    </ul>
                </div>
                <div class="dropdown">
                    <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton1"
                        data-bs-toggle="dropdown" aria-expanded="false">
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
    <section class="stats" style="margin-top: 120px;">
        <div class="container text-center">
            <h2>WeCare Statistics</h2>
           
          <div class="row mt-4">
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total Causes</h4>
                    <p class="display-6 text-primary "><?php echo $total_causes; ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total Donations</h4>
                    <p class="display-6 text-success ">Rs:<?php echo number_format($total_donations, 2); ?></p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-3 shadow">
                    <h4>Total NGOs Registered</h4>
                    <p class="display-6 text-warning "><?php echo $total_ngos; ?></p>
                </div>
            </div>
          </div>
            
            <!-- Pie Chart -->
            <div class="mt-5">
                <h3 class="text-center">Distribution of Causes by Category</h3>
                <canvas id="statsChart" style="max-height: 400px;"></canvas>
            </div>
        </div>
    </section>

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
    <script>
    const categories = <?php echo $categories_json; ?>;
    const counts = <?php echo $counts_json; ?>;

    const ctx = document.getElementById('statsChart').getContext('2d');
    const statsChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categories,
            datasets: [{
                data: counts,
                backgroundColor: [
                    '#fc6806', '#17a2b8', '#ffc107', '#17a2b8', '#6c757d', 
                    '#ff6347', '#9370db', '#ff7f50', '#4682b4', '#32cd32'
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
</body>

</html>
