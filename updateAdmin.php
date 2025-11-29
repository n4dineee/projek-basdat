<?php
session_start();
include 'dbPengguna.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if(!$id) die("Admin tidak ditemukan.");

// Ambil data admin
$res = pg_query_params($conn, "SELECT * FROM admin WHERE id_admin = $1", [$id]);
$admin = pg_fetch_assoc($res);

if(!$admin) die("Admin tidak ditemukan.");

if(isset($_POST['submit'])){
    $nama = trim($_POST['nama_admin']);
    $kontak = trim($_POST['kontak']);
    $peran = trim($_POST['peran']);

    pg_query_params($conn,
        "UPDATE admin SET nama_admin=$1, kontak=$2, peran=$3 WHERE id_admin=$4",
        [$nama, $kontak, $peran, $id]
    );

    echo "<script>alert('Admin berhasil diperbarui!'); window.location='readAdmin.php';</script>";
}
?>

<h2>Update Admin</h2>

<form method="POST">
    Nama: <input name="nama_admin" value="<?=$admin['nama_admin']?>" required><br><br>
    Kontak: <input name="kontak" value="<?=$admin['kontak']?>" required><br><br>
    peran: <input name="peran" value="<?=$admin['peran']?>" required><br><br>

    <button class="btn btn-edit" name="submit">Update</button>
</form>

<?php include 'footer.php'; ?>