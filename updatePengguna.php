<?php
session_start();
include 'dbPengguna.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if(!$id) die("Pengguna tidak ditemukan.");

$res = pg_query_params($conn, "SELECT * FROM pengguna WHERE id_pengguna=$1", [$id]);
$user = pg_fetch_assoc($res);

if(!$user) die("Pengguna tidak ditemukan.");

if(isset($_POST['submit'])){
    $nama = trim($_POST['nama_pengguna']);
    $email = trim($_POST['email']);

    pg_query_params($conn,
        "UPDATE pengguna SET nama_pengguna=$1, email=$2 WHERE id_pengguna=$3",
        [$nama, $email, $id]
    );

    echo "<script>alert('Pengguna berhasil diperbarui!'); window.location='readPengguna.php';</script>";
}
?>

<h2>Update Pengguna</h2>

<form method="POST">
    Nama: <input name="nama_pengguna" value="<?=$user['nama_pengguna']?>" required><br><br>
    Email: <input name="email" value="<?=$user['email']?>" required><br><br>

    <button class="btn btn-edit" name="submit">Update</button>
</form>

<?php include 'footer.php'; ?>
