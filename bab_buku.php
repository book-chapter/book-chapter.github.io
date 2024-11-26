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
                $file_name = basename($_FILES['chapter_file']['name']);
                $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

                // Validasi tipe file
                $allowed_types = ['docx'];
                if (in_array($file_type, $allowed_types)) {
                  $upload_dir = 'uploads/chapters/';
                  // Buat folder jika belum ada
                  if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                  }
                  $file_path = $upload_dir . $file_name;

                  // Pindahkan file ke direktori tujuan
                  if (move_uploaded_file($_FILES['chapter_file']['tmp_name'], $file_path)) {
                    $sql = "INSERT INTO chapters (title, description, price, file_path) VALUES ('$title', '$description', '$price', '$file_path')";
                    if ($conn->query($sql) === TRUE) {
                      echo "<div class='alert alert-success'>Bab buku berhasil ditambahkan!</div>";
                    } else {
                      echo "<div class='alert alert-danger'>Error: " . $sql . "<br>" . $conn->error . "</div>";
                    }
                  } else {
                    echo "<div class='alert alert-danger'>Gagal mengunggah file. Pastikan folder memiliki izin tulis.</div>";
                  }
                } else {
                  echo "<div class='alert alert-warning'>Hanya file DOCX yang diperbolehkan.</div>";
                }
              } elseif ($action == 'delete') {
                $chapter_id = $_POST['chapter_id'];
                $sql = "DELETE FROM chapters WHERE chapter_id = '$chapter_id'";
                $conn->query($sql);
              }
            }

            $chapters = $conn->query("SELECT * FROM chapters");

            $conn->close();
            ?>

            <!-- Menampilkan jumlah pengguna -->
            <div class="card">
              <div class="card-body">
                <h1>Manajemen Bab Buku</h1>

                <h2>Tambah Bab Baru</h2>
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
                  <input type="file" id="image_file" name="image_file" required>

                  <button type="submit" name="action" value="add">Tambah Bab</button>
                </form>

                <h2>Daftar Bab Buku</h2>
                <table>
                  <tr>
                    <th>ID</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Harga</th>
                    <th>File</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                  </tr>
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
                </table>
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