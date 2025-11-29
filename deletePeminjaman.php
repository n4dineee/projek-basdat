<?php
session_start();
include 'dbPengguna.php';

if (!isset($_GET['id'])) {
    die("ID peminjaman tidak ditemukan.");
}

$id = $_GET['id'];

// Cek apakah id valid
$cek = pg_query_params($conn, "SELECT id_peminjaman FROM peminjaman WHERE id_peminjaman=$1", [$id]);
if (!pg_fetch_assoc($cek)) {
    die("Data peminjaman tidak ditemukan.");
}

echo "
<script>
    if (confirm('Apakah Anda yakin ingin menghapus peminjaman ini?')) {
        window.location = 'deletePeminjamanProcess.php?id=$id';
    } else {
        window.location = 'readPeminjaman.php';
    }
</script>
";