<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    // Periksa apakah username atau email sudah ada
    $check_admin = $conn->query("SELECT * FROM admins WHERE username = '$username' OR email = '$email'");
    if ($check_admin->num_rows > 0) {
        echo "Username atau email sudah terdaftar sebagai admin.";
    } else {
        $sql = "INSERT INTO admins (username, password, email, full_name) VALUES ('$username', '$password', '$email', '$full_name')";
        if ($conn->query($sql) === TRUE) {
            echo "Registrasi admin berhasil! <a href='login_admin.php'>Login di sini</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<h1>Registrasi Admin</h1>
<form method="POST">
    Nama Lengkap: <input type="text" name="full_name" required><br>
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    Email: <input type="email" name="email" required><br>
    <button type="submit">Register</button>
</form>