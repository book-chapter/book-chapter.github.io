<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['order_id'])) {
    header("Location: login.html");
    exit();
}

$order_id = $_GET['order_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $allowed_types = ['png', 'jpg', 'jpeg'];
    $file_name = basename($_FILES['payment_proof']['name']);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $upload_dir = 'uploads/';
    $payment_proof_path = $upload_dir . $file_name;

    if (in_array($file_type, $allowed_types)) {
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['payment_proof']['tmp_name'], $payment_proof_path)) {
            $sql = "UPDATE orders SET payment_proof_path = '$payment_proof_path', status = 'waiting_confirmation' WHERE order_id = '$order_id'";
            if ($conn->query($sql) === TRUE) {
                header("Location: dashboard_pending_confirmation.php");
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        } else {
            echo "Failed to upload file. Please check folder permissions.";
        }
    } else {
        echo "Only PNG, JPG, and JPEG files are allowed.";
    }
}
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
                        <a href="dashboard.php" class="d-block">
                            BookChapter.
                        </a>
                    </div>
                    <div class="mr-auto">
                        <nav class="site-navigation position-relative text-right" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                <li>
                                    <a href="dashboard.php" class="nav-link text-left">Beranda</a>
                                </li>
                                <li>
                                    <a href="dashboard_buku.php" class="nav-link text-left">Buku</a>
                                </li>
                                <li>
                                    <a href="dashboard_kontak.php" class="nav-link text-left">Bantuan</a>
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
                            <h1>Upload Bukti Pembayaran</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="site-section">
            <div class="container">
                <div class="row">

                </div>
                <div class="row">

                </div>
                <div class="row">

                </div>

                <div class="row">
                    <div class="col-12">
                        <form method="POST" enctype="multipart/form-data">
                            Upload Bukti Pembayaran (PNG, JPG, JPEG): <input type="file" name="payment_proof" required><br><br>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                        <!-- <a href="dashboard_bab_buku.php" class="btn btn-danger">Kembali</a> -->
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