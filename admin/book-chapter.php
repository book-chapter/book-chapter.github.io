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

// Proses form input
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action'];

  if ($action == 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Validasi input
    if (empty($title) || empty($description) || empty($price)) {
      $_SESSION['error'] = "Semua field wajib diisi!";
      header("Location: book-chapter.php");
      exit;
    }

    // Mengupload file .docx
    $file_name = str_replace(' ', '_', basename($_FILES['chapter_file']['name'])); // Ganti spasi dengan _
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validasi tipe file
    $allowed_types = ['docx'];
    if (in_array($file_type, $allowed_types)) {
      $upload_dir = '../uploads/chapters/';
      if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

      $file_path = $upload_dir . $file_name;

      if (move_uploaded_file($_FILES['chapter_file']['tmp_name'], $file_path)) {
        // Mengupload gambar
        $image_name = str_replace(' ', '_', basename($_FILES['image_path']['name']));
        $image_dir = '../uploads/images/';
        if (!is_dir($image_dir)) mkdir($image_dir, 0777, true);

        $image_path = $image_dir . $image_name;

        if (move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path)) {
          // Path yang disimpan ke database
          $file_path_db = 'uploads/chapters/' . $file_name;
          $image_path_db = 'uploads/images/' . $image_name;

          // Simpan ke database
          $stmt = $conn->prepare("INSERT INTO chapters (title, description, price, file_path, image_path) VALUES (?, ?, ?, ?, ?)");
          $stmt->bind_param("ssdss", $title, $description, $price, $file_path_db, $image_path_db);

          if ($stmt->execute()) {
            $_SESSION['success'] = "Bab buku berhasil ditambahkan!";
          } else {
            $_SESSION['error'] = "Error: " . $stmt->error;
          }
          $stmt->close();
        } else {
          $_SESSION['error'] = "Gagal mengunggah gambar. Pastikan folder memiliki izin tulis.";
        }
      } else {
        $_SESSION['error'] = "Gagal mengunggah file bab buku. Pastikan folder memiliki izin tulis.";
      }
    } else {
      $_SESSION['error'] = "Hanya file DOCX yang diperbolehkan untuk bab buku.";
    }

    header("Location: book-chapter.php");
    exit;
  } elseif ($action == 'delete') {
    $chapter_id = $_POST['chapter_id'];
    $stmt = $conn->prepare("DELETE FROM chapters WHERE chapter_id = ?");
    $stmt->bind_param("i", $chapter_id);
    if ($stmt->execute()) {
      $_SESSION['success'] = "Bab buku berhasil dihapus!";
    } else {
      $_SESSION['error'] = "Error: " . $stmt->error;
    }
    $stmt->close();

    header("Location: book-chapter.php");
    exit;
  }
}

// Query untuk menampilkan daftar chapters
$chapters = $conn->query("SELECT * FROM chapters");
if (!$chapters) {
  die("Error: " . $conn->error);
}

// Hitung jumlah bab
$book_count = $conn->query("SELECT COUNT(*) as total_book FROM chapters")->fetch_assoc()['total_book'] ?? 0;

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
              <h4 class="card-title fw-semibold mb-3">Manajemen Bab Buku</h4><br>
              <div class="card">
                <div class="card-body p-4">
                  <h5 class="card-title">Jumlah Bab Buku</h5>
                  <p class="card-text">Total Buku: <?php echo $book_count; ?></p>
                </div>
              </div><br>
              <h4 class="card-title fw-semibold mb-3">Form Input Bab Buku</h4>
              <div class="card">
                <div class="card-body p-3">
                  <form method="POST" enctype="multipart/form-data">
                    <div class="form-floating mb-3">
                      <input type="text" class="form-control" id="title" name="title" placeholder="name@example.com">
                      <label for="floatingInput">Judul Bab Buku</label>
                    </div>
                    <div class="form-floating mb-3">
                      <textarea id="description" class="form-control" name="description" rows="4" placeholder="name@example.com"></textarea>
                      <label for="floatingPassword">Deskripsi</label>
                    </div>
                    <div class="form-floating mb-3">
                      <input type="number" class="form-control" id="price" name="price" placeholder="Password">
                      <label for="floatingPassword">Harga</label>
                    </div>
                    <div class="mb-3">
                      <label for="chapter_file">File Bab (.docx):</label>
                      <input class="form-control" type="file" id="chapter_file" name="chapter_file">
                    </div>
                    <div class="mb-3">
                      <label for="chapter_file">File Gambar Cover Bab (.jpg, .png):</label>
                      <input class="form-control" type="file" id="image_path" name="image_path">
                    </div><br>
                    <button type="submit" class="btn btn-primary" name="action" value="add">Tambah Bab</button>
                  </form>
                </div>
              </div>
              <h4 class="card-title fw-semibold mb-3">Daftar Bab Buku</h4>
              <div class="card">
                <div class="card-body p-2">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <tr>
                          <th scope="col">ID</th>
                          <th scope="col">Judul</th>
                          <th scope="col">Deskripsi</th>
                          <th scope="col">Harga</th>
                          <th scope="col">File</th>
                          <th scope="col">Gambar</th>
                          <th scope="col">Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php while ($chapter = $chapters->fetch_assoc()): ?>
                          <tr>
                            <td><?= $chapter['chapter_id'] ?></td>
                            <td><?= htmlspecialchars($chapter['title']) ?></td>
                            <td><?= htmlspecialchars($chapter['description']) ?></td>
                            <td>Rp<?= number_format($chapter['price'], 2, ',', '.') ?></td>
                            <td><a href="../<?= $chapter['file_path'] ?>" download>Unduh</a></td>
                            <td>
                              <?php if (file_exists('../' . $chapter['image_path'])) : ?>
                                <img src="../<?= htmlspecialchars($chapter['image_path']) ?>" alt="Gambar Bab" style="width: 100px;">
                              <?php else : ?>
                                Tidak ada gambar
                              <?php endif; ?>
                            </td>
                            <td>
                              <form method="POST" style="display:inline;">
                                <input type="hidden" name="chapter_id" value="<?= $chapter['chapter_id'] ?>">
                                <button type="submit" name="action" value="delete" onclick="return confirm('Yakin ingin menghapus user ini?');" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px;">Hapus</button>
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
  </div>
  <script src="../src/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../src/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../src/assets/js/sidebarmenu.js"></script>
  <script src="../src/assets/js/app.min.js"></script>
  <script src="../src/assets/libs/simplebar/dist/simplebar.js"></script>
</body>

</html>