<?php
session_start();
include 'dbPengguna.php';
include 'header.php';

$id = $_GET['id'] ?? null;
if(!$id){
    echo "<h3>ID Admin tidak ditemukan.</h3>";
    include 'footer.php';
    exit;
}

// Jika pengguna sudah mengonfirmasi penghapusan
if(isset($_GET['confirm']) && $_GET['confirm'] == "yes"){

    $res = pg_query_params($conn, "DELETE FROM admin WHERE id_admin=$1", [$id]);

    if(!$res){
        $error = pg_last_error($conn);

        // Jika admin masih digunakan di peminjaman
        if(str_contains($error, "peminjaman")){
            echo "<script>
                alert('Admin tidak dapat dihapus karena masih digunakan pada data peminjaman.');
                window.location = 'readAdmin.php';
            </script>";
            exit;
        }

        echo "<script>
            alert('Gagal menghapus admin: ". addslashes($error) ."');
            window.location = 'readAdmin.php';
        </script>";
        exit;
    }

    // Jika berhasil
    echo "<script>
        alert('Admin berhasil dihapus!');
        window.location = 'readAdmin.php';
    </script>";
    exit;
}
?>

<h2>Konfirmasi Penghapusan Admin</h2>

<p>Apakah Anda yakin ingin menghapus admin dengan ID <b><?=htmlspecialchars($id)?></b>?</p>

<a href="deleteAdmin.php?id=<?=$id?>&confirm=yes">
    <button style="padding:8px 15px; background:red; color:white; border:none; cursor:pointer;">
        Ya, hapus admin
    </button>
</a>

<a href="readAdmin.php">
    <button style="padding:8px 15px; background:gray; color:white; border:none; cursor:pointer;">
        Batal
    </button>
</a>

<?php include 'footer.php'; ?>