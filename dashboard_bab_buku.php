<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = ""; // Use your MySQL password if any
$dbname = "book_chapter"; // Ensure this matches your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk data buku
$sqlBooks = "SELECT id AS book_id, title, category FROM book_details ORDER BY category, title ASC";
$resultBooks = $conn->query($sqlBooks);
if (!$resultBooks) {
    die("Error in SQL Query (Books): " . $conn->error);
}


// Query untuk data bab buku
$sqlChapters = "SELECT * FROM chapters";
$resultChapters = $conn->query($sqlChapters);
if (!$resultChapters) {
    die("Error in SQL Query (Chapters): " . $conn->error);
}


// Kelompokkan bab buku berdasarkan book_id
$chapters = [];
if ($resultChapters->num_rows > 0) {
    while ($row = $resultChapters->fetch_assoc()) {
        if (!empty($row['book_id'])) {
            $chapters[$row['book_id']][] = $row;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Book Chapter &mdash; Buku</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">


    <link href="https://fonts.googleapis.com/css?family=Muli:300,400,700,900" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="shortcut icon" type="image/png" href="./src/assets/images/logos/logo_bc.png" />
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



</head>

<body data-spy="scroll" data-target=".site-navbar-target" data-offset="300">

    <div class="site-wrap">

        <!-- Header and Navigation Code Here -->
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
                        <?php if (isset($_SESSION['user_id'])): ?>
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
                    <!-- Logo -->
                    <div class="site-logo">
                        <a href="dashboard.php" class="d-block">BookChapter.</a>
                    </div>
                    
                    <!-- Navigation (for Desktop and Mobile) -->
                    <div class="mr-auto">
                        <!-- Navbar for mobile devices -->
                        <nav class="site-navigation position-relative text-right" role="navigation">
                            <ul class="site-menu main-menu js-clone-nav mr-auto d-none d-lg-block">
                                <li><a href="dashboard.php" class="nav-link text-left">Beranda</a></li>
                                <li class="active"><a href="dashboard_buku.php" class="nav-link text-left">Buku</a></li>
                                <li><a href="dashboard_kontak.php" class="nav-link text-left">Bantuan</a></li>
                            </ul>
                        </nav>

                        <!-- Mobile Navbar Toggle Button -->
                        <nav class="navbar navbar-expand-lg navbar-light d-lg-none">
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarNav">
                                <ul class="navbar-nav ml-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="dashboard.php">Beranda</a>
                                    </li>
                                    <li class="nav-item active">
                                        <a class="nav-link" href="dashboard_buku.php">Buku</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="dashboard_kontak.php">Bantuan</a>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    
                    <!-- User Account Menu (for logged-in users) -->
                    <div class="ml-auto">
                        <!-- <div class="">
                            <a class="">
                                <span class=""></span>
                            </a>
                        </div> -->
                    </div>
                </div>
            </div>
        </header>

        <div class="intro-section small" style="background-image: url('images/hero_1.jpg');">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 mx-auto text-center">
                        <div class="intro">
                            <h1>Daftar Buku</h1>
                            <p>Pilih buku berdasarkan kategori dan judul, lalu pilih bab yang ingin Anda checkout.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="site-section pb-0">
            <div class="container">
                <div class="row">
                    <?php if ($resultBooks->num_rows > 0): ?>
                        <?php while ($row = $resultBooks->fetch_assoc()): ?>
                            <div class="col-lg-4 mb-5">
                                <div class="news-entry-item">
                                    <h3 class="mb-0">
                                        <a href="#" class="text-dark" data-toggle="modal" data-target="#bookModal<?php echo $row['book_id']; ?>">
                                            <?php echo htmlspecialchars($row['title']); ?>
                                        </a>
                                    </h3>
                                    <p><strong>Kategori: </strong><?php echo htmlspecialchars($row['category']); ?></p>
                                </div>
                            </div>

                            <!-- Modal untuk detail buku -->
                            <div class="modal fade" id="bookModal<?php echo $row['book_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel<?php echo $row['book_id']; ?>" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="bookModalLabel<?php echo $row['book_id']; ?>"><?php echo htmlspecialchars($row['title']); ?></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <h6>Bab Buku:</h6>
                                            <?php if (!empty($chapters[$row['book_id']])): ?>
                                                <ul>
                                                    <?php foreach ($chapters[$row['book_id']] as $chapter): ?>
                                                        <li>
                                                            <strong><?php echo htmlspecialchars($chapter['title']); ?></strong><br>
                                                            Deskripsi: <?php echo htmlspecialchars($chapter['description']); ?><br>
                                                            Harga: Rp<?php echo number_format($chapter['price'], 2, ',', '.'); ?><br>
                                                            <a href="checkout.php?chapter_id=<?php echo $chapter['chapter_id']; ?>" class="btn btn-primary btn-sm mt-2">Checkout</a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <p>Tidak ada bab yang tersedia untuk buku ini.</p>
                                            <?php endif; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <p class="text-center">Tidak ada buku yang tersedia saat ini.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Footer Code Here -->
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

    <!-- jQuery, Bootstrap, and other JavaScript files -->
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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

<?php
$conn->close();
?>