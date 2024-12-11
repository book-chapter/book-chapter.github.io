<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
  header('Location: index.php');
  exit();
}

// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = ""; // Ganti dengan password MySQL Anda
$dbname = "book_chapter";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Proses form input kategori
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action'])) {
  if ($_POST['action'] == 'add') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $category = trim($_POST['category']);

    if (empty($title) || empty($category)) {
      $_SESSION['error'] = "Judul dan kategori wajib diisi!";
      header("Location: category-chapter.php");
      exit;
    }

    $image_name = $_FILES['image_path']['name'];
    $image_tmp = $_FILES['image_path']['tmp_name'];
    $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
    $allowed_exts = ['jpg', 'png'];

    if (!empty($image_name)) {
      if (in_array($image_ext, $allowed_exts)) {
        $image_dir = '../uploads/images/';
        if (!is_dir($image_dir)) mkdir($image_dir, 0777, true);

        $new_image_name = uniqid() . '.' . $image_ext;
        $image_path = $image_dir . $new_image_name;

        if (move_uploaded_file($image_tmp, $image_path)) {
          $image_path_db = 'uploads/images/' . $new_image_name;
        } else {
          $_SESSION['error'] = "Gagal mengunggah gambar.";
          header("Location: category-chapter.php");
          exit;
        }
      } else {
        $_SESSION['error'] = "Hanya file JPG dan PNG yang diperbolehkan.";
        header("Location: category-chapter.php");
        exit;
      }
    } else {
      $image_path_db = NULL;
    }

    $stmt = $conn->prepare("INSERT INTO book_details (title, description, category, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $category, $image_path_db);

    if ($stmt->execute()) {
      $_SESSION['success'] = "Kategori berhasil ditambahkan!";
    } else {
      $_SESSION['error'] = "Terjadi kesalahan: " . $stmt->error;
    }
    $stmt->close();

    header("Location: category-chapter.php");
    exit;
  }

  if ($_POST['action'] == 'delete') {
    $id = $_POST['id'];
    $stmt = $conn->prepare("DELETE FROM book_details WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
      $_SESSION['success'] = "Kategori berhasil dihapus!";
    } else {
      $_SESSION['error'] = "Terjadi kesalahan: " . $stmt->error;
    }
    $stmt->close();

    header("Location: category-chapter.php");
    exit;
  }
}

// Query untuk menampilkan daftar kategori
$categories = $conn->query("SELECT * FROM book_details");
$category_count = $conn->query("SELECT COUNT(*) as total FROM book_details")->fetch_assoc()['total'] ?? 0;

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Modernize Free</title>
  <link rel="shortcut icon" type="image/png" href="../src/assets/images/logos/logo_bc.png" />
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
              <a class="sidebar-link" href="category-chapter.php" aria-expanded="false">
                <span>
                  <i class="ti ti-category"></i>
                </span>
                <span class="hide-menu">Kategori Buku</span>
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
                      <!-- Menampilkan nama admin dari session -->
                      <p class="mb-0 fs-3"><?php echo isset($_SESSION['admin_full_name']) ? $_SESSION['admin_full_name'] : 'Admin'; ?></p>
                    </a>
                    <a href="logout.php" onclick="confirmLogout(event)" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
              <h4 class="card-title fw-semibold mb-3">Kategori Buku</h4><br>
              <div class="card">
                <div class="card-body p-4">
                  <h5 class="card-title">Jumlah Kategori</h5>
                  <p class="card-text">Total Kategori: <?php echo $category_count; ?></p>
                </div>
              </div><br>
              <h4 class="card-title fw-semibold mb-3">Form Input Kategori Buku</h4>
              <div class="card">
                <div class="card-body p-3">
                  <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="add">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="title" name="title" placeholder="Judul">
                      <label for="title">Judul</label>
                    </div>
                    <div class="form-floating mb-3">
                      <textarea class="form-control" id="description" name="description" placeholder="Deskripsi"></textarea>
                      <label for="description">Deskripsi</label>
                    </div>
                    <div class="mb-3">
                      <label for="image_path">File Gambar Cover (.jpg, .png):</label>
                      <input type="file" class="form-control" id="image_path" name="image_path">
                    </div>
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="category" name="category" placeholder="Kategori">
                      <label for="category">Kategori</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah Kategori</button>
                  </form>
                </div>
              </div>
              <h4 class="card-title fw-semibold mb-3">Daftar Bab Buku</h4>
              <!-- Daftar Kategori -->
              <div class="card">
                <div class="card-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Cover</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php while ($row = $categories->fetch_assoc()): ?>
                        <tr>
                          <td><?php echo $row['id']; ?></td>
                          <td><?php echo htmlspecialchars($row['title']); ?></td>
                          <td><?php echo htmlspecialchars($row['category']); ?></td>
                          <td><?php echo htmlspecialchars($row['description']); ?></td>
                          <td>
                            <?php if ($row['image_path']): ?>
                              <img src="../<?php echo $row['image_path']; ?>" alt="Cover" style="width: 100px; height: auto;">
                            <?php else: ?>
                              Tidak ada gambar
                            <?php endif; ?>
                          </td>
                          <td>
                            <form method="POST" style="display: inline;">
                              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                              <button type="submit" name="action" value="delete" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</button>
                            </form>
                          </td>
                        </tr>
                      <?php endwhile; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function confirmLogout(event) {
      // Mencegah aksi default tombol
      event.preventDefault();

      // Tampilkan konfirmasi
      if (confirm("Apakah Anda yakin ingin logout?")) {
        // Jika OK ditekan, arahkan ke logout.php
        window.location.href = 'logout.php';
      }
      // Jika Cancel ditekan, tidak melakukan apa-apa
    }
  </script>
  <script src="../src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../src/assets/js/sidebarmenu.js"></script>
  <script src="../src/assets/js/app.min.js"></script>
  <script src="../src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>