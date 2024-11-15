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
          </div>
          <div class="col-lg-3 text-right">
            <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
              <!-- Jika sudah login, tampilkan nama pengguna dan opsi logout -->
              <div class="dropdown">
                <a href="#" class="small btn btn-primary px-4 py-2 rounded-0 dropdown-toggle" id="accountDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <?php echo htmlspecialchars($_SESSION['username']); ?>
                </a>
                <div class="dropdown-menu" aria-labelledby="accountDropdown">
                  <a class="dropdown-item" href="logout.php">Logout</a>
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
            <a href="index.php" class="d-block">
              BookChapter.
            </a>
          </div>
          <div class="mr-auto">
            <nav class="site-navigation position-relative text-right" role="navigation">
              <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                <li>
                  <a href="index.php" class="nav-link text-left">Beranda</a>
                </li>
                <li>
                  <a href="about.php" class="nav-link text-left">Tentang</a>
                </li>
                <li>
                  <a href="services.php" class="nav-link text-left">Layanan</a>
                </li>
                <li class="active">
                  <a href="contact.php" class="nav-link text-left">Hubungi Kami</a>
                </li>
              </ul>
            </nav>

          </div>
          <div class="ml-auto">
            <div class="social-wrap">

              <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black"><span
                  class="icon-menu h3"></span></a>
            </div>
          </div>

        </div>
      </div>

    </header>


    <div class="intro-section small" style="background-image: url('images/hero_2.jpg');">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-7 mx-auto text-center" data-aos="fade-up">
            <div class="intro">
              <h1>Hubungi Kami</h1>
              <p>"Tertarik bekerja sama atau punya pertanyaan? Hubungi kami untuk bantuan dan informasi lebih lanjut."</p>
              <p><a href="login.html" class="btn btn-primary">Mulai Sekarang</a></p>
            </div>
          </div>
        </div>
      </div>
    </div>



    <div class="site-section">
      <div class="container">
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="fname">First Name</label>
            <input type="text" id="fname" class="form-control form-control-lg">
          </div>
          <div class="col-md-6 form-group">
            <label for="lname">Last Name</label>
            <input type="text" id="lname" class="form-control form-control-lg">
          </div>
        </div>
        <div class="row">
          <div class="col-md-6 form-group">
            <label for="eaddress">Email Address</label>
            <input type="text" id="eaddress" class="form-control form-control-lg">
          </div>
          <div class="col-md-6 form-group">
            <label for="tel">Tel. Number</label>
            <input type="text" id="tel" class="form-control form-control-lg">
          </div>
        </div>
        <div class="row">
          <div class="col-md-12 form-group">
            <label for="message">Message</label>
            <textarea name="" id="message" cols="30" rows="10" class="form-control"></textarea>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <input type="submit" value="Send Message" class="btn btn-primary btn-lg px-5">
          </div>
        </div>
      </div>
    </div>


    <!-- Footer -->
    <div class="footer">
      <div class="container">
        <div class="row">
          <div class="col-12">
            <div class="copyright">
              <p>
                <a href="#" class="d-block" style="text-decoration: none;">
                  <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                  Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                  </script> All rights reserved | BookChapter.</a>
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
  <div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px">
      <circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee" />
      <circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#51be78" />
    </svg></div>

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




  <script src="js/main.js"></script>

</body>

</html>