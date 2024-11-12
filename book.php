<?php
session_start(); // Memulai session untuk mengecek status login
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>BookKeeping &mdash; Website by Colorlib</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <link rel="stylesheet" href="css/jquery.fancybox.min.css">

    <link rel="stylesheet" href="css/bootstrap-datepicker.css">

    <link rel="stylesheet" href="fonts/flaticon/font/flaticon.css">

    <link rel="stylesheet" href="css/aos.css">
    <link href="css/jquery.mb.YTPlayer.min.css" media="all" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="css/style.css">



</head>

    <body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="site-wrap">

        <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
            <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
        </div>


        <div class="py-2 bg-light">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-lg-9 d-none d-lg-block">
                <a href="#" class="small mr-3"><span class="icon-question-circle-o mr-2"></span> Have a questions?</a> 
                <a href="#" class="small mr-3"><span class="icon-phone2 mr-2"></span> 10 20 123 456</a> 
                <a href="#" class="small mr-3"><span class="icon-envelope-o mr-2"></span> info@mydomain.com</a> 
            </div>
            <div class="col-lg-3 text-right">
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                <!-- Jika sudah login, tampilkan nama pengguna dan opsi logout -->
                <div class="dropdown">
                    <a href="#" class="small btn btn-primary px-4 py-2 rounded-0 dropdown-toggle" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php echo htmlspecialchars($_SESSION['username']); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="accountDropdown">
                    <a class="dropdown-item" href="/php/logout.php">Logout</a>
                    </div>
                </div>
                <?php else: ?>
                <!-- Jika belum login, tampilkan tombol login dan register -->
                <a href="login.html" class="small mr-3"><span class="icon-unlock-alt"></span> Log In</a>
                <a href="register.html" class="small btn btn-primary px-4 py-2 rounded-0"><span class="icon-users"></span> Register</a>
                <?php endif; ?>
            </div>
            </div>
        </div>
        </div>
        
        <header class="site-navbar py-4 js-sticky-header site-navbar-target" role="banner">

        <div class="container">
            <div class="d-flex align-items-center">
            <div class="site-logo">
                <a href="index.html" class="d-block">
                <img src="images/logo.png" alt="Image" class="img-fluid">
                </a>
            </div>
            <div class="mr-auto">
                <nav class="site-navigation position-relative text-right" role="navigation">
                <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                    <li>
                    <a href="index.php" class="nav-link text-left">Home</a>
                    </li>
                    <li>
                    <a href="about.php" class="nav-link text-left">About</a>
                    </li>
                    <li class="active">
                        <a href="book.php" class="nav-link text-left">Book</a>
                    </li>
                    <li>
                    <a href="services.php" class="nav-link text-left">Services</a>
                    </li>
                    <li>
                    <a href="blog.php" class="nav-link text-left">Blog</a>
                    </li>
                    <li>
                    <a href="contact.php" class="nav-link text-left">Contact</a>
                    </li>
                </ul>                                                                
                </nav>

            </div>
            <div class="ml-auto">
                <div class="social-wrap">
                <a href="#"><span class="icon-facebook"></span></a>
                <a href="#"><span class="icon-twitter"></span></a>
                <a href="#"><span class="icon-linkedin"></span></a>

                <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                    class="icon-menu h3"></span></a>
                </div>
                </div>

            </div>
            </div>

        </header>


        <div class="intro-section small" style="background-image: url('images/hero_1.jpg');">
            <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7 mx-auto text-center" data-aos="fade-up">
                <div class="intro">
                <h1>Book</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sit, nihil.</p>
                <p><a href="#" class="btn btn-primary">Get Started</a></p>
                </div>
                </div>
            </div>
            </div>
        </div>


        <div class="site-section pb-0">
            <div class="container">
    
                <div class="row">
                    <div class="col-lg-4 mb-5">
                        <div class="project-item" data-id="1">
                            <a href="review.html" class="thumbnail">
                                <img src="images/img_1.jpg" alt="Project 1" class="img-fluid">
                                <div class="project-title">Project 1</div>
                            </a>
                            <p>Project 1 - Penjelasan singkat tentang proyek ini.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="project-item" data-id="2">
                            <a href="review.html" class="thumbnail">
                                <img src="images/img_2.jpg" alt="Project 2" class="img-fluid">
                                <div class="project-title">Project 2</div>
                            </a>
                            <p>Project 2 - Penjelasan singkat tentang proyek ini.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-5">
                        <div class="project-item" data-id="3">
                            <a href="#" class="thumbnail">
                                <img src="images/img_3.jpg" alt="Project 3" class="img-fluid">
                                <div class="project-title">Project 3</div>
                            </a>
                            <p>Project 3 - Penjelasan singkat tentang proyek ini.</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>

        <div class="footer">
            <div class="container">
            <div class="row">
                <div class="col-lg-3">
                <p class="mb-4"><img src="images/logo_footer.png" alt="Image" class="img-fluid"></p>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Beatae nemo minima qui dolor, iusto iure.</p>  
                <p><a href="#">Learn More</a></p>
                </div>
                <div class="col-lg-3">
                <h3 class="footer-heading"><span>Solutions</span></h3>
                <ul class="list-unstyled">
                    <li><a href="#">Investment Bonds</a></li>
                    <li><a href="#">Financial Funds</a></li>
                    <li><a href="#">Growth Business</a></li>
                    <li><a href="#">Lifetime Support</a></li>
                    <li><a href="#">Advanced Accounting</a></li>
                </ul>
                </div>
                <div class="col-lg-3">
                <h3 class="footer-heading"><span>Services</span></h3>
                <ul class="list-unstyled">
                    <li><a href="#">Investment Bonds</a></li>
                    <li><a href="#">Financial Funds</a></li>
                    <li><a href="#">Growth Business</a></li>
                    <li><a href="#">Lifetime Support</a></li>
                    <li><a href="#">Advanced Accounting</a></li>
                </ul>
                </div>
                <div class="col-lg-3">
                <h3 class="footer-heading"><span>Contact</span></h3>
                <ul class="list-unstyled">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Support Community</a></li>
                    <li><a href="#">Press</a></li>
                    <li><a href="#">Share Your Story</a></li>
                    <li><a href="#">Our Supporters</a></li>
                </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                <div class="copyright">
                    <p>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
                </div>
            </div>
            </div>
        </div>


        </div>
        <!-- .site-wrap -->


        <!-- loader -->
        <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78"/></svg></div>

        <script src="js/jquery-3.3.1.min.js"></script>
        <script src="js/jquery-migrate-3.0.1.min.js"></script>
        <script src="js/jquery-ui.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/owl.carousel.min.js"></script>
        <script src="js/jquery.stellar.min.js"></script>
        <script src="js/jquery.countdown.min.js"></script>
        <script src="js/bootstrap-datepicker.min.js"></script>
        <script src="js/jquery.easing.1.3.js"></script>
        <script src="js/aos.js"></script>
        <script src="js/jquery.fancybox.min.js"></script>
        <script src="js/jquery.sticky.js"></script>
        <script src="js/jquery.mb.YTPlayer.min.js"></script>
        <script src="js/project-navigation.js"></script>




        <script src="js/main.js"></script>

    </body>

    </html>