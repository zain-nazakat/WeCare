<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>WeCare</title>
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
            background-color: #f2f2f2;
        }

        main {
            padding: 20px;
        }

        section {
            margin-bottom: 30px;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: disc;
            margin-left: 20px;
        }

        .hero-image {
            width: 100%;
            height: 400px;
            background: url('img/food-waste.jpg') center center / cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.8);
        }

        .hero-image h1 {
            background: rgba(0, 0, 0, 0.5);
            padding: 10px 20px;
            border-radius: 8px;
        }

        .navbar-brand img {
            max-height: 40px;
        }

        .footer-logo {
            max-height: 50px;
            padding-bottom: 15px;
        }
        .img-fluid {
    width: 550px;
    height: 350px;
    object-fit: cover;
    margin-bottom: 1rem; /* mb-3 from Bootstrap corresponds to 1rem */
}
    </style>
</head>

<body>

<nav class="navbar navbar-dark navbar-expand-lg bg-dark fixed-top">
    <div class="container-fluid">
        <a href="index.php" class="navbar-brand d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
            <img src="img/logo.png" alt="WeCare Logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="padding-left:15%">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="education.php">Education Corner</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="ambulance.php">Ambulance Service</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="blogs.php">Blogs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="About_us.html">About Us</a>
                </li>
            </ul>
            <div class="d-flex">
                <div class="dropdown" style="margin-right:20px;">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                        Log In
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="donner_login.php">Donors</a></li>
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
                        <li><a class="dropdown-item" href="donner_signup.php">Donors</a></li>
                        <li><a class="dropdown-item" href="ngo_signup.php">NGOs</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>

<div class="hero-image">
    <h1>WeCare: Reducing Food Waste</h1>
</div>

<main>
    <section id="introduction">
        <h2>Introduction to Food Waste</h2>
        <img src="img/c2.png" alt="Introduction to Food Waste" class="img-fluid mb-3">
        <p>Food waste occurs at every stage of the food supply chain, from production to consumption. It refers to the disposal of food that is still safe and nutritious for human consumption. According to the Food and Agriculture Organization (FAO) of the United Nations, approximately one-third of all food produced worldwide is lost or wasted each year, amounting to about 1.3 billion tons.</p>
        <p>Food waste has significant environmental, social, and economic implications. It contributes to greenhouse gas emissions, wasted resources such as water and land, and exacerbates global hunger and poverty.</p>
    </section>

    <section id="causes">
        <h2>Causes of Food Waste</h2>
        <img src="img/c.png" alt="Causes of Food Waste" class="img-fluid mb-3">
        <ul>
            <li>Overproduction and excess inventory</li>
            <li>Consumer behavior, including buying more than needed and improper storage</li>
            <li>Strict cosmetic standards leading to the rejection of imperfect produce</li>
            <li>Inefficient supply chain management</li>
            <li>Lack of infrastructure for food preservation and distribution</li>
        </ul>
    </section>

    <section id="impact">
        <h2>Impact of Food Waste</h2>
        <img src="img/w.png" alt="Impact of Food Waste" class="img-fluid mb-3">
        <p>Food waste has far-reaching consequences:</p>
        <ul>
            <li>Environmental impact: Contributes to greenhouse gas emissions, land and water degradation, and biodiversity loss.</li>
            <li>Social impact: Exacerbates food insecurity, perpetuates poverty, and strains limited resources.</li>
            <li>Economic impact: Wastes valuable resources used in food production and distribution, leading to economic losses for producers, businesses, and consumers.</li>
        </ul>
    </section>

    <section id="tips">
        <h2>Tips to Reduce Food Waste</h2>
        <img src="img/av.png" alt="Tips to Reduce Food Waste" class="img-fluid mb-3">
        <p>Here are some practical tips to minimize food waste:</p>
        <ul>
            <li>Plan meals and create shopping lists to buy only what you need.</li>
            <li>Store food properly to extend its shelf life.</li>
            <li>Use leftovers creatively in new recipes.</li>
            <li>Compost food scraps instead of throwing them away.</li>
        </ul>
    </section>

    <section id="donation">
        <h2>Importance of Donation</h2>
        <img src="img/donate.png" alt="Importance of Donation" class="img-fluid mb-3">
        <p>Donating excess food to those in need can help reduce food waste and alleviate hunger. Food donations support community organizations such as food banks, shelters, and soup kitchens, providing nutritious meals to individuals and families facing food insecurity.</p>
    </section>

    <section id="resources">
        <h2>Resources and Further Reading</h2>
       
        <p>Here are some additional resources to learn more about food waste and donation:</p>
        <ul>
            <li><a href="#">Food and Agriculture Organization (FAO) - Food Loss and Waste</a></li>
            <li><a href="#">Environmental Protection Agency (EPA) - Food Recovery Hierarchy</a></li>
            <li><a href="#">Feeding America - Hunger and Food Waste</a></li>
        </ul>
    </section>
</main>

<footer class="bg-dark text-light" style="padding:30px;">
    <div class="container">
        <footer class="py-5">
            <div class="row">
                <div class="col-md-4">
                    <form>
                        <img src="img/logo.png" alt="WeCare Logo" class="footer-logo">
                        <p>Welcome to WeCare, the website dedicated to providing food, clothing, and medicine to those in need. Our mission is to help the less fortunate in our community and around the world.</p>
                    </form>
                </div>
                <div class="col-md-2">
                    <h5>Quick Links</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Home</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">About Us</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Contact</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Our Causes</a></li>
                        <li class="nav-item mb-2"><a href="#" class="nav-link p-0 text-light">Blog</a></li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <form>
                        <h5>Subscribe to our Newsletter</h5>
                        <p>Monthly digest of what's new and exciting from us.</p>
                        <div class="d-flex flex-column flex-sm-row w-100 gap-2">
                            <label for="newsletter1" class="visually-hidden">Email address</label>
                            <input id="newsletter1" type="text" class="form-control" placeholder="Email address">
                            <button class="btn btn-warning" type="button">Subscribe</button>
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
