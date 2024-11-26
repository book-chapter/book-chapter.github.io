<?php
session_start(); // Memulai session untuk mengecek status login
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="./src/assets/images/logos/logo_bc.png" />
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
            <img src="./src/assets/images/logos/logoadmin.svg" width="220" alt="Logo" />
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
    
    <!-- Main Content -->
    <div class="main-content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <h3>Verifikasi Pembayaran</h3>

            <!-- Ambil dan tampilkan data pembayaran dengan status 'waiting_confirmation' dari database -->
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

            // Proses update status verifikasi jika ada permintaan POST
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
              $order_id = $_POST['order_id'];
              $action = $_POST['action'];
              $status = ($action == 'approve') ? 'approved' : 'rejected';
          
              $sql = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
              if ($conn->query($sql) === TRUE) {
                  header("Location: verifikasi_pembayaran.php");
              } else {
                  echo "Error updating order: " . $conn->error;
              }
            }

            // Query untuk mengambil data pembayaran dengan status 'waiting_confirmation' dan username serta title dari chapters
            $sql = "SELECT orders.order_id, users.username, chapters.title, orders.order_date, orders.payment_proof_path, orders.status 
                    FROM orders 
                    JOIN users ON orders.user_id = users.user_id 
                    JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                    WHERE orders.status = 'waiting_confirmation'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>Order ID</th><th>Username</th><th>Chapter Title</th><th>Order Date</th><th>Payment Proof</th><th>Status</th><th>Actions</th></tr></thead>";
                echo "<tbody>";
                
                // Output data setiap row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td><a href='" . $row["payment_proof_path"] . "' target='_blank'>View Proof</a></td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "<td>
                        <form method='POST' action=''>
                            <input type='hidden' name='order_id' value='" . $row["order_id"] . "'>
                            <button type='submit' name='action' value='approve' class='btn btn-success'>Approve</button>
                            <button type='submit' name='action' value='reject' class='btn btn-danger'>Reject</button>
                        </form>
                        </td>";
                    echo "</tr>";
                }
                
                echo "</tbody></table>";
            } else {
                echo "<p>Tidak ada pembayaran yang perlu diverifikasi.</p>";
            }
            ?>

            <h3>Riwayat Pembelian</h3>

            <!-- Ambil dan tampilkan data pembayaran yang statusnya 'approved' atau 'rejected' dari database -->
            <?php
            // Query untuk mengambil data riwayat pembelian (approved dan rejected) dengan username serta title dari chapters
            $sql = "SELECT orders.order_id, users.username, chapters.title, orders.order_date, orders.payment_proof_path, orders.status 
                    FROM orders 
                    JOIN users ON orders.user_id = users.user_id 
                    JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                    WHERE orders.status IN ('approved', 'rejected')";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo "<table class='table'>";
                echo "<thead><tr><th>Order ID</th><th>Username</th><th>Chapter Title</th><th>Order Date</th><th>Payment Proof</th><th>Status</th></tr></thead>";
                echo "<tbody>";
                
                // Output data setiap row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["username"] . "</td>";
                    echo "<td>" . $row["title"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td><a href='" . $row["payment_proof_path"] . "' target='_blank'>View Proof</a></td>";
                    echo "<td>" . $row["status"] . "</td>";
                    echo "</tr>";
                }
                
                echo "</tbody></table>";
            } else {
                echo "<p>Tidak ada riwayat pembelian.</p>";
            }

            $conn->close();
            ?>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts -->
    <script src="./src/assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="./src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./src/assets/js/sidebarmenu.js"></script>
    <script src="./src/assets/js/app.min.js"></script>
    <script src="./src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>
</html>
