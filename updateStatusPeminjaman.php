<?php
session_start();
include 'dbPengguna.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if(!$id) die("ID tidak ditemukan.");

$res = pg_query_params($conn, "SELECT * FROM peminjaman WHERE id_peminjaman=$1", [$id]);
$p = pg_fetch_assoc($res);

if(!$p) die("Data peminjaman tidak ditemukan.");

if(isset($_POST['submit'])){
    $status = $_POST['status'];

    pg_query_params($conn,
        "UPDATE peminjaman SET status=$1 WHERE id_peminjaman=$2",
        [$status, $id]
    );

    echo "<script>alert('Status diperbarui!'); window.location='readPeminjaman.php';</script>";
}
?>

<h2>Update Status Peminjaman</h2>

<form method="POST">
    Status:
    <select name="status">
        <option value="menunggu" <?=$p['status']=='menunggu'?'selected':''?>>Menunggu</option>
        <option value="disetujui" <?=$p['status']=='disetujui'?'selected':''?>>Disetujui</option>
        <option value="ditolak" <?=$p['status']=='ditolak'?'selected':''?>>Ditolak</option>
        <option value="selesai" <?=$p['status']=='selesai'?'selected':''?>>Selesai</option>
    </select>
    <br><br>

    <button class="btn btn-edit" name="submit">Update</button>
</form>

<?php include 'footer.php'; ?>