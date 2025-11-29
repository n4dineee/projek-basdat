<?php
session_start();
include 'dbPengguna.php';
include 'header.php';

$q = pg_query($conn, "
    SELECT 
        p.id_peminjaman,
        p.tanggal_peminjaman,
        p.waktu_mulai,
        p.waktu_selesai,
        p.status,

        r.nama_ruangan,
        k.nama_kegiatan,

        u.nama AS nama_pengguna

    FROM peminjaman p
    JOIN ruangan r ON r.id_ruangan = p.id_ruangan
    JOIN kegiatan k ON k.id_kegiatan = p.id_kegiatan
    JOIN pengguna u ON u.id_pengguna = k.id_pengguna
    ORDER BY p.id_peminjaman DESC
");

$data = pg_fetch_all($q);
?>

<h2>Daftar Peminjaman Ruangan</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Pengguna</th>
        <th>Ruangan</th>
        <th>Kegiatan</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

<?php if($data){ foreach($data as $d){ ?>
    <tr>
        <td><?=$d['id_peminjaman']?></td>
        <td><?=$d['nama_pengguna']?></td>
        <td><?=$d['nama_ruangan']?></td>
        <td><?=$d['nama_kegiatan']?></td>
        <td><?=$d['tanggal_peminjaman']?></td>
        <td><?=$d['waktu_mulai']?> - <?=$d['waktu_selesai']?></td>
        <td><?=$d['status']?></td>

        <td>
            <a class="btn btn-edit" href="updateStatusPeminjaman.php?id=<?=$d['id_peminjaman']?>">Edit</a>
            <a class="btn btn-delete" href="deletePeminjaman.php?id=<?=$d['id_peminjaman']?>"
               onclick="return confirm('Hapus peminjaman ini?')">Hapus</a>
        </td>
    </tr>
<?php }} ?>
</table>

<?php include 'footer.php'; ?>