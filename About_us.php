<?php

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
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 " style="padding-left:31%">
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
                            <a class="nav-link active" href="About_us.php">About Us</a> 
                            
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
    <section class="about">
        <div class="container col-xxl-9 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-lg-12 text-center">
                    <h2>About Us</h2>
                    <h6 style="margin:20px;">What We Do?</h5>

                </div>
                <div class="col-lg-7">
                    <h4>Do you want to make a difference in the lives of those facing food insecurity? Look no further
                        than WeCare.
                        </h5><br>
                        <p>
                            This is our Final Year Project in which we are developing something that can help people.
                            Basic purpose of this Web Application is to Revolutionalize the <br><b>Wall Of Kindness</b>
                            <br><br>
                            </h6>
                </div>
                <div class="col-10 col-sm-8 col-lg-5">
                    <img src="img/about.jpg" class="d-block mx-lg-auto img-fluid" alt="Logo" width="700" height="500"
                        loading="lazy">
                </div>
                <div class="row g-4 py-5 row-cols-1 row-cols-lg-3">
                    <div class="col d-flex align-items-start">
                        <div>
                            <h2>Zain Ul Abadeen</h2>
                            <p>BSSE Final Year Student. <br>
                                Full Stack Developer
                            </p>
                        </div>
                    </div>
                    <div class="col d-flex align-items-start">
                        <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                            <svg class="bi" width="1em" height="1em">
                                <use xlink:href="#cpu-fill" />
                            </svg>
                        </div>
                        <div class="col d-flex align-items-start">
                            <div class="icon-square bg-light text-dark flex-shrink-0 me-3">
                                <svg class="bi" width="1em" height="1em">
                                    <use xlink:href="#tools" />
                                </svg>
                            </div>
                            <div class="Namess">
                                <h2>M Umair Ashfaq</h2>
                                <p>BSSE Final Year Student. <br>
                                    Full Stack Developer</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
    <section class="causes">
    <div class="container col-xxl-9 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-lg-12 text-center">
                <h2>Our Causes</h2>
                <p style="margin:20px;">Below is an overview of our causes and their impact.</p>
            </div>
            <div class="col-lg-12">
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">Causes</th>
                            <th scope="col">Total Donations</th>
                            <th scope="col">Total NGOs Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Food for Everyone</td>
                            <td>$10,000</td>
                            <td>50</td>
                        </tr>
                        <tr>
                            <td>Clothing Drives</td>
                            <td>$7,500</td>
                            <td>30</td>
                        </tr>
                        <tr>
                            <td>Medical Aid</td>
                            <td>$15,000</td>
                            <td>40</td>
                        </tr>
                        <tr>
                            <td>Educational Support</td>
                            <td>$20,000</td>
                            <td>70</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

    <section class="contact">
        <div class="container col-xxl-9 px-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-lg-12 text-center">
                    <h2>Contact Us</h2>
                    <h6 style="margin:20px;padding-bottom:50px;">Leave a Message</h5>

                </div>
                <div class="row">
                    <form action="" method="post">
                        <div class="row">

                            <div class="col-md-6">
                                <input class="form-control" name="name" placeholder="Name..." /><br />
                            </div>
                            <div class="col-md-6">
                                <input class="form-control" name="email" placeholder="E-mail..." /><br />
                            </div>
                        </div>
                        <div class="col-md-12">
                            <input class="form-control" name="subject" placeholder="Subject..." /><br />
                        </div>

                        <div class="col-md-12">

                            <textarea class="form-control" name="text" placeholder="How can we help you?"
                                style="height:150px;"></textarea><br />
                            <input class="btn btn-primary" type="submit" value="Send" /><br /><br />
                        </div>
                    </form>

                </div>
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

                            <p style="padding-right:60px;text-align:justify">Welcome to WeCare, the website dedicated to
                                providing food, clothing, and medicine to
                                those in need. We are a non-profit organization, and our mission is to help the less
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
                            <h5>Copyright : Zain Ul Abadeen</h5>
                            <p>Subscribe to our Newsletter</p>
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
        </script>
</body>

</html>