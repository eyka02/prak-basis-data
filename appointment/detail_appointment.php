<?php

include "../config/session.php";
include "../config/database.php";

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"
SELECT

a.*,
p.nama,
p.no_hp,
p.email,
p.alamat,

GROUP_CONCAT(h.nama_hewan SEPARATOR ', ') AS daftar_hewan,
GROUP_CONCAT(h.jenis SEPARATOR ', ') AS jenis_hewan,
GROUP_CONCAT(h.ras SEPARATOR ', ') AS ras_hewan

FROM appointment a

JOIN pemilik p
ON a.id_pemilik = p.id_pemilik

LEFT JOIN appointment_hewan ah
ON a.id_appointment = ah.id_appointment

LEFT JOIN hewan h
ON ah.id_hewan = h.id_hewan

WHERE a.id_appointment = '$id'

GROUP BY a.id_appointment
"
);

$data = mysqli_fetch_assoc($query);

?>

<div class="page-header">


<div>

    <h2 class="page-title">
        📅 Detail Appointment
    </h2>

    <p class="page-subtitle">
        Informasi lengkap jadwal pemeriksaan hewan
    </p>

</div>


</div>

<!-- DATA HEWAN -->

<div class="detail-card">

    <h3>🐾 Data Hewan</h3>

    <div class="info-grid">

        <div class="info-item">
            <span class="info-label">Hewan</span>
            <span class="info-value"><?= $data['daftar_hewan']; ?></span>
        </div>

        <div class="info-item">
            <span class="info-label">Jenis</span>
            <span class="info-value"><?= $data['jenis_hewan']; ?></span>
        </div>

        <div class="info-item">
            <span class="info-label">Ras</span>
            <span class="info-value"><?= $data['ras_hewan']; ?></span>
        </div>

    </div>

</div>

<!-- DATA PEMILIK -->

<div class="detail-card">


<h3>👤 Data Pemilik</h3>

<div class="info-grid">

    <div class="info-item">
        <span class="info-label">Nama</span>
        <span class="info-value">
            <?= $data['nama']; ?>
        </span>
    </div>

    <div class="info-item">
        <span class="info-label">No HP</span>
        <span class="info-value">
            <?= $data['no_hp']; ?>
        </span>
    </div>

    <div class="info-item">
        <span class="info-label">Email</span>
        <span class="info-value">
            <?= $data['email']; ?>
        </span>
    </div>

    <div class="info-item">
        <span class="info-label">Alamat</span>
        <span class="info-value">
            <?= $data['alamat']; ?>
        </span>
    </div>

</div>


</div>

<!-- DATA APPOINTMENT -->

<div class="detail-card">


<h3>📋 Data Appointment</h3>

<div class="info-grid">

    <div class="info-item">
        <span class="info-label">Tanggal</span>
        <span class="info-value">
            <?= $data['tanggal']; ?>
        </span>
    </div>

    <div class="info-item">
        <span class="info-label">Jam</span>
        <span class="info-value">
            <?= $data['jam']; ?>
        </span>
    </div>

    <div class="info-item">
        <span class="info-label">Status</span>

        <span class="badge badge-success">
            <?= $data['status']; ?>
        </span>

    </div>

</div>

<br>

<span class="info-label">
    Keluhan
</span>

<div class="note-box">

    <?= nl2br($data['keluhan']); ?>

</div>


</div>

<div class="action-group">




</div>


