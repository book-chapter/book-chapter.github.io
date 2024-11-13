<?php
session_start();
include 'db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login_admin.php");
    exit();
}

// Proses tambah, edit, dan hapus bab
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $file_name = basename($_FILES['chapter_file']['name']);
        $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Validasi tipe file bab
        $allowed_types = ['docx'];
        if (in_array($file_type, $allowed_types)) {
            $upload_dir = 'uploads/chapters/';
            // Buat folder jika belum ada
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            $file_path = $upload_dir . $file_name;

            // Pindahkan file bab ke direktori tujuan
            if (move_uploaded_file($_FILES['chapter_file']['tmp_name'], $file_path)) {

                // Proses upload gambar
                $image_path = null;
                if (isset($_FILES['chapter_image']) && $_FILES['chapter_image']['error'] == 0) {
                    $image_name = basename($_FILES['chapter_image']['name']);
                    $image_type = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
                    $allowed_image_types = ['jpg', 'jpeg', 'png', 'gif'];

                    if (in_array($image_type, $allowed_image_types)) {
                        $image_upload_dir = 'uploads/images/';
                        if (!is_dir($image_upload_dir)) {
                            mkdir($image_upload_dir, 0777, true);
                        }
                        $image_path = $image_upload_dir . $image_name;

                        if (!move_uploaded_file($_FILES['chapter_image']['tmp_name'], $image_path)) {
                            echo "Gagal mengunggah gambar.";
                            $image_path = null;
                        }
                    } else {
                        echo "Tipe gambar tidak valid. Hanya diperbolehkan JPG, JPEG, PNG, dan GIF.";
                    }
                }

                // Simpan data bab buku ke database
                $sql = "INSERT INTO chapters (title, description, price, file_path, image_path) VALUES (?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssdss", $title, $description, $price, $file_path, $image_path);

                if ($stmt->execute()) {
                    echo "Bab buku berhasil ditambahkan!";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $stmt->close();
            } else {
                echo "Gagal mengunggah file. Pastikan folder memiliki izin tulis.";
            }
        } else {
            echo "Hanya file DOCX yang diperbolehkan.";
        }
    } elseif ($action == 'delete') {
        $chapter_id = $_POST['chapter_id'];
        $sql = "SELECT file_path, image_path FROM chapters WHERE chapter_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $chapter_id);
        $stmt->execute();
        $stmt->bind_result($file_path, $image_path);
        $stmt->fetch();
        $stmt->close();

        if (file_exists($file_path)) unlink($file_path);
        if ($image_path && file_exists($image_path)) unlink($image_path);

        $sql = "DELETE FROM chapters WHERE chapter_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $chapter_id);
        if ($stmt->execute()) {
            echo "Bab buku berhasil dihapus.";
        }
        $stmt->close();
    }
}

$chapters = $conn->query("SELECT * FROM chapters");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Bab Buku</title>
</head>

<body>
    <h1>Manajemen Bab Buku</h1>

    <h2>Tambah Bab Baru</h2>
    <form method="POST" enctype="multipart/form-data">
        Judul Bab: <input type="text" name="title" required><br>
        Deskripsi: <textarea name="description" required></textarea><br>
        Harga: <input type="number" name="price" required><br>
        File Bab (.docx): <input type="file" name="chapter_file" accept=".docx" required><br>
        Gambar Bab (JPG, PNG, GIF): <input type="file" name="chapter_image" accept="image/*"><br>
        <button type="submit" name="action" value="add">Tambah Bab</button>
    </form>

    <h2>Daftar Bab Buku</h2>
    <table border="1" cellpadding="10">
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
                        <button type="submit" name="action" value="delete">Hapus</button>
                    </form>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    <a href="admin_dashboard.php">Kembali ke Dashboard Admin</a>
</body>

</html>