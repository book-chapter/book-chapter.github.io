<?php
session_start(); // Memulai session untuk mengecek status login
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="./src/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="./src/assets/css/styles.min.css" />

  <!-- Tambahkan CSS untuk menggeser konten utama -->
  <style>
    .main-content {
      margin-left: 250px; /* Pastikan margin ini sesuai dengan lebar sidebar */
      padding: 20px;
    }
  </style>
</head>

<body>
  <!-- Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./dashboard_admin.php" class="text-nowrap logo-img">
            <img src="./src/assets/images/logos/dark-logo.svg" width="180" alt="Logo" />
          </a>
        </div>
        
        <!-- Sidebar navigation -->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Home</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="dashboard_admin.php" aria-expanded="false">
                <span>
                  <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Management User</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="bab_buku.php" aria-expanded="false">
                <span>
                  <i class="ti ti-book"></i>
                </span>
                <span class="hide-menu">Manajemen Bab Buku</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="verifikasi_pembayaran.php" aria-expanded="false">
                <span>
                  <i class="ti ti-credit-card"></i>
                </span>
                <span class="hide-menu">Verifikasi Pembayaran</span>
              </a>
            </li>
          </ul>
        </nav>
      </div>
    </aside>
    <!-- Sidebar End -->

    <!-- Main content -->
    <div class="main-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <!-- Ambil jumlah pengguna dari database -->
            <?php
            // Koneksi ke database
            $servername = "localhost";
            $username = "root";
            $password = ""; // Ganti dengan password MySQL Anda
            $dbname = "book_chapter"; // Nama database

            // Membuat koneksi
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Cek koneksi
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query untuk menghitung jumlah user
            $sql = "SELECT COUNT(*) as total_users FROM users";
            $result = $conn->query($sql);
            $user_count = 0;

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_count = $row['total_users'];
            }

            $conn->close();
            ?>
            
            <!-- Menampilkan jumlah pengguna -->
            <div class="card">
              <div class="card-body">
                <h4 class="card-title">Jumlah Pengguna Terdaftar</h4>
                <p class="card-text">Total pengguna: <?php echo $user_count; ?></p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Main content End -->
  </div>

  <!-- Scripts -->
  <script src="./src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="./src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./src/assets/js/sidebarmenu.js"></script>
  <script src="./src/assets/js/app.min.js"></script>
  <script src="./src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>
</html>
