<?php

include "../config/session.php";
include "../config/database.php";

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"SELECT
h.*,
p.nama,
p.no_hp,
p.email,
p.alamat
FROM hewan h
JOIN pemilik p
ON h.id_pemilik = p.id_pemilik
WHERE h.id_hewan = '$id'"
);

$data = mysqli_fetch_assoc($query);

?>

<div class="pet-profile">

    <div class="pet-cover">

        <img
        src="../assets/img/uploads/hewan/<?= $data['foto']; ?>"
        class="pet-detail-photo">

    </div>

    <div class="pet-info">

        <h2>
            <?= $data['nama_hewan']; ?>
        </h2>

        <span class="pet-type">
            <?= $data['jenis']; ?>
        </span>

    </div>

</div>

<div class="detail-grid">

    <div class="info-card">
        <h4>Ras</h4>
        <span><?= $data['ras']; ?></span>
    </div>

    <div class="info-card">
        <h4>Berat</h4>
        <span><?= $data['berat']; ?> Kg</span>
    </div>

    <div class="info-card">
        <h4>Jenis Kelamin</h4>
        <span><?= $data['jenis_kelamin']; ?></span>
    </div>

    <div class="info-card">
        <h4>Tanggal Lahir</h4>
        <span><?= $data['tanggal_lahir']; ?></span>
    </div>

    <div class="info-card">
        <h4>Warna</h4>
        <span><?= $data['warna']; ?></span>
    </div>

    <div class="info-card">
        <h4>Status Vaksin</h4>

        <?php
        if($data['status_vaksin']=='Lengkap'){
            echo '<span class="badge-success">Lengkap</span>';
        }elseif($data['status_vaksin']=='Belum Lengkap'){
            echo '<span class="badge-warning">Belum Lengkap</span>';
        }else{
            echo '<span class="badge-danger">Belum Pernah</span>';
        }
        ?>
    </div>

    <div class="info-card full">
        <h4>Riwayat Alergi</h4>
        <span><?= $data['alergi']; ?></span>
    </div>

</div>

<h3 class="section-title">
Pemilik Hewan
</h3>

<div class="owner-card">

    <h3><?= $data['nama']; ?></h3>

    <p><?= $data['email']; ?></p>

    <p><?= $data['no_hp']; ?></p>

    <small><?= $data['alamat']; ?></small>

</div>


