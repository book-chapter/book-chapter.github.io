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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $action = $_POST['action'];

  if ($action == 'add') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Mengupload file .docx
    $file_name = basename($_FILES['chapter_file']['name']);
    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Validasi tipe file .docx
    $allowed_types = ['docx'];
    if (in_array($file_type, $allowed_types)) {
      $upload_dir = 'uploads/chapters/';
      // Buat folder jika belum ada
      if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
      }
      $file_path = $upload_dir . $file_name;

      // Pindahkan file .docx ke direktori tujuan
      if (move_uploaded_file($_FILES['chapter_file']['tmp_name'], $file_path)) {

        // Menangani upload gambar cover
        $image_name = basename($_FILES['image_path']['name']);
        $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $allowed_image_types = ['jpg', 'jpeg', 'png'];

        if (in_array($image_type, $allowed_image_types)) {
          $image_dir = 'uploads/images/';
          if (!is_dir($image_dir)) {
            mkdir($image_dir, 0777, true);
          }
          $image_path = $image_dir . $image_name;

          // Pindahkan gambar ke folder
          if (move_uploaded_file($_FILES['image_path']['tmp_name'], $image_path)) {
            // Menyimpan data ke database
            $sql = "INSERT INTO chapters (title, description, price, file_path, image_path) 
                              VALUES ('$title', '$description', '$price', '$file_path', '$image_path')";
            if ($conn->query($sql) === TRUE) {
              echo "<div class='alert alert-success'>Bab buku berhasil ditambahkan!</div>";
            } else {
              echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
            }
          } else {
            echo "<div class='alert alert-danger'>Gagal mengunggah gambar. Pastikan folder gambar memiliki izin tulis.</div>";
          }
        } else {
          echo "<div class='alert alert-warning'>Hanya file gambar JPG, JPEG, dan PNG yang diperbolehkan.</div>";
        }
      } else {
        echo "<div class='alert alert-danger'>Gagal mengunggah file bab buku. Pastikan folder memiliki izin tulis.</div>";
      }
    } else {
      echo "<div class='alert alert-warning'>Hanya file DOCX yang diperbolehkan untuk bab buku.</div>";
    }
  } elseif ($action == 'delete') {
    $chapter_id = $_POST['chapter_id'];
    $sql = "DELETE FROM chapters WHERE chapter_id = '$chapter_id'";
    $conn->query($sql);
  }
}

// Jangan menutup koneksi sebelum query berikutnya!
$chapters = $conn->query("SELECT * FROM chapters");

// Query for user count
$book = "SELECT COUNT(*) as total_book FROM chapters";
$hasil = $conn->query($book);
$book_count = 0;

if ($hasil->num_rows > 0) {
  $row = $hasil->fetch_assoc();
  $book_count = $row['total_book'];
}

// Query to fetch user details
$sql_users = "SELECT chapter_id, title, description, price, created_at, image_path FROM chapters";
$users = $conn->query($sql_users);

if ($users === false) {
  echo "Error: " . $conn->error;
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Dashboard</title>
  <link rel="shortcut icon" type="image/png" href="./src/assets/images/logos/logo_bc.png" />
  <link rel="stylesheet" href="./src/assets/css/styles.min.css" />
  <link rel="stylesheet" href="./src/assets/css/custom.css" />
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
            <?php

            ?>

            <!-- Menampilkan jumlah pengguna -->
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Jumlah Bab Buku</h5>
                <p class="card-text">Total Buku: <?php echo $book_count; ?></p>
              </div>
            </div>

            <!-- Menampilkan jumlah pengguna -->
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Monitoring Data Robots</h5><br>
                <form method="POST" enctype="multipart/form-data">
                  <label for="title">Judul Bab:</label>
                  <input type="text" id="title" name="title" required>

                  <label for="description">Deskripsi:</label>
                  <textarea id="description" name="description" rows="4" required></textarea>

                  <label for="price">Harga:</label>
                  <input type="number" id="price" name="price" required>

                  <label for="chapter_file">File Bab (.docx):</label>
                  <input type="file" id="chapter_file" name="chapter_file" required>

                  <label for="chapter_file">File Gambar Cover Bab (.jpg, .png):</label>
                  <input type="file" id="image_path" name="image_path" required>

                  <button type="submit" name="action" value="add">Tambah Bab</button>
                </form>

                <h5 class="card-title">Daftar Bab Buku</h5>
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
                          <td>Rp <?= number_format($chapter['price'], 2, ',', '.') ?></td>
                          <td><a href="<?= htmlspecialchars($chapter['file_path']) ?>" download>Unduh</a></td>
                          <td>
                            <?php if ($chapter['image_path']): ?>
                              <img src="<?= htmlspecialchars($chapter['image_path']) ?>" alt="Gambar Bab" style="width: 100px;">
                            <?php else: ?>
                              Tidak ada gambar
                            <?php endif; ?>
                          </td>
                          <td>
                            <form method="POST" style="display:inline;">
                              <input type="hidden" name="chapter_id" value="<?= $chapter['chapter_id'] ?>">
                              <button type="submit" name="action" value="delete" style="background-color: #dc3545; color: white; border: none; padding: 8px 12px; cursor: pointer; border-radius: 4px;">Hapus</button>
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