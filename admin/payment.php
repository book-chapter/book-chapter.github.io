<?php
session_start(); // Memulai session untuk mengecek status login

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

// Proses verifikasi pembayaran
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $order_id = $_POST['order_id'];
  $action = $_POST['action'];
  $status = ($action == 'approve') ? 'approved' : 'rejected';

  $sql = "UPDATE orders SET status = '$status' WHERE order_id = '$order_id'";
  if ($conn->query($sql) === TRUE) {
    header("Location: payment.php");
  } else {
    echo "Error updating order: " . $conn->error;
  }
}

// Query untuk pembayaran dalam status waiting_confirmation
$sql_waiting = "SELECT orders.order_id, users.username, chapters.title, orders.order_date, orders.payment_proof_path, orders.status 
                FROM orders 
                JOIN users ON orders.user_id = users.user_id 
                JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                WHERE orders.status = 'waiting_confirmation'";
$result_waiting = $conn->query($sql_waiting);

// Query untuk riwayat pembayaran (approved/rejected)
$sql_history = "SELECT orders.order_id, users.username, chapters.title, orders.order_date, orders.payment_proof_path, orders.status 
                FROM orders 
                JOIN users ON orders.user_id = users.user_id 
                JOIN chapters ON orders.chapter_id = chapters.chapter_id 
                WHERE orders.status IN ('approved', 'rejected')";
$result_history = $conn->query($sql_history);

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="../src/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../src/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="dashboard.php" class="text-nowrap logo-img">
            <img src="../src/assets/images/logos/logoadmin.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          <ul id="sidebarnav">
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Beranda</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="dashboard.php" aria-expanded="false">
                <span>
                  <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
              </a>
            </li>
            <li class="nav-small-cap">
              <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
              <span class="hide-menu">Manajemen</span>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="data-user.php" aria-expanded="false">
                <span>
                  <i class="ti ti-users"></i>
                </span>
                <span class="hide-menu">Data Pengguna</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="book-chapter.php" aria-expanded="false">
                <span>
                  <i class="ti ti-book-2"></i>
                </span>
                <span class="hide-menu">Bab Buku</span>
              </a>
            </li>
            <li class="sidebar-item">
              <a class="sidebar-link" href="payment.php" aria-expanded="false">
                <span>
                  <i class="ti ti-credit-card"></i>
                </span>
                <span class="hide-menu">Pembayaran</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          <ul class="navbar-nav">
            <li class="nav-item d-block d-xl-none">
              <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                <i class="ti ti-menu-2"></i>
              </a>
            </li>
          </ul>
          <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
            <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="../src/assets/images/profile/user-1.jpg" alt="" width="35" height="35" class="rounded-circle">
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                  <div class="message-body">
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-user fs-6"></i>
                      <p class="mb-0 fs-3">My Profile</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-mail fs-6"></i>
                      <p class="mb-0 fs-3">My Account</p>
                    </a>
                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                      <i class="ti ti-list-check fs-6"></i>
                      <p class="mb-0 fs-3">My Task</p>
                    </a>
                    <a href="index.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <div class="col-12">
                <h4 class="card-title fw-semibold mb-3">Verifikasi Pembayaran Buku</h4><br>
                <div class="card">
                  <div class="card-body p-4">
                    <?php if ($result_waiting->num_rows > 0): ?>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order ID</th>
                            <th>Username</th>
                            <th>Chapter Title</th>
                            <th>Order Date</th>
                            <th>Payment Proof</th>
                            <th>Status</th>
                            <th>Actions</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $result_waiting->fetch_assoc()): ?>
                            <tr>
                              <td><?= $row['order_id'] ?></td>
                              <td><?= htmlspecialchars($row['username']) ?></td>
                              <td><?= htmlspecialchars($row['title']) ?></td>
                              <td><?= $row['order_date'] ?></td>
                              <td>
                                <?php if (file_exists('../' . $row['payment_proof_path'])): ?>
                                  <a href="../<?= htmlspecialchars($row['payment_proof_path']) ?>" target="_blank">View Proof</a>
                                <?php else: ?>
                                  <span style="color: red;">Proof Not Found</span>
                                <?php endif; ?>
                              </td>
                              <td><?= $row['status'] ?></td>
                              <td>
                                <form method="POST">
                                  <input type="hidden" name="order_id" value="<?= $row['order_id'] ?>">
                                  <button type="submit" name="action" value="approve" class="btn btn-success">Approve</button>
                                  <button type="submit" name="action" value="reject" class="btn btn-danger">Reject</button>
                                </form>
                              </td>
                            </tr>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                    <?php else: ?>
                      <p>Tidak ada pembayaran yang perlu diverifikasi.</p>
                    <?php endif; ?>
                  </div>
                </div><br>
                <h4 class="card-title fw-semibold mb-3">Riwayat Pembelian Buku</h4><br>
                <div class="card mb-0">
                  <div class="card-body p-4">
                    <?php if ($result_history->num_rows > 0): ?>
                      <table class="table">
                        <thead>
                          <tr>
                            <th>Order ID</th>
                            <th>Username</th>
                            <th>Chapter Title</th>
                            <th>Order Date</th>
                            <th>Payment Proof</th>
                            <th>Status</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($row = $result_history->fetch_assoc()): ?>
                            <tr>
                              <td><?= $row['order_id'] ?></td>
                              <td><?= htmlspecialchars($row['username']) ?></td>
                              <td><?= htmlspecialchars($row['title']) ?></td>
                              <td><?= $row['order_date'] ?></td>
                              <td>
                                <?php if (file_exists('../' . $row['payment_proof_path'])): ?>
                                  <a href="../<?= htmlspecialchars($row['payment_proof_path']) ?>" target="_blank">View Proof</a>
                                <?php else: ?>
                                  <span style="color: red;">Proof Not Found</span>
                                <?php endif; ?>
                              </td>
                              <td><?= $row['status'] ?></td>
                            </tr>
                          <?php endwhile; ?>
                        </tbody>
                      </table>
                    <?php else: ?>
                      <p>Tidak ada riwayat pembelian.</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../src/assets/js/sidebarmenu.js"></script>
  <script src="../src/assets/js/app.min.js"></script>
  <script src="../src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>