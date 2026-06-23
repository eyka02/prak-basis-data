
<?php

include "../config/session.php";
include "../config/database.php";

$id = $_GET['id'];

$data = mysqli_fetch_assoc(
    mysqli_query(
        $conn,
        "SELECT
            k.*,
            h.nama_hewan,
            h.jenis,
            h.ras,
            p.nama AS pemilik
        FROM kunjungan k
        JOIN hewan h
            ON k.id_hewan=h.id_hewan
        JOIN pemilik p
            ON h.id_pemilik=p.id_pemilik
        WHERE k.id_kunjungan='$id'"
    )
);

$obat = mysqli_query(
    $conn,
    "SELECT
        o.nama_obat,
        d.jumlah,
        d.subtotal
    FROM detail_obat_kunjungan d
    JOIN obat o
        ON d.id_obat=o.id_obat
    WHERE d.id_kunjungan='$id'"
);

$vaksin = mysqli_query(
    $conn,
    "SELECT
        v.nama_vaksin,
        d.jumlah,
        d.subtotal
    FROM detail_vaksin_kunjungan d
    JOIN vaksin v
        ON d.id_vaksin=v.id_vaksin
    WHERE d.id_kunjungan='$id'"
);
?>


<title>Detail Rekam Medis</title>

<div class="page-header">

    <div>

        <h2>📋 Detail Rekam Medis</h2>

        <p>
            Informasi lengkap pemeriksaan pasien
        </p>

    </div>

    <a
    href="cetak_rekam_medis.php?id=<?= $data['id_kunjungan']; ?>"
    target="_blank"
    class="btn btn-success">

        Cetak Rekam Medis

    </a>

</div>

<!-- INFORMASI PASIEN -->

<div class="medical-card">

<h3>Informasi Pasien</h3>

<div class="info-grid">

<div class="info-item">

    <span class="info-label">
        Nama Hewan
    </span>

    <span class="info-value">
        <?= $data['nama_hewan']; ?>
    </span>

</div>

<div class="info-item">
    <span class="info-label">
        Jenis
    </span>

    <span class="info-value">
        <?= $data['jenis']; ?>
    </span>
</div>

<div class="info-item">
    <span class="info-label">
        Ras
    </span>
    
    <span class="info-value">
        <?= $data['ras']; ?>
    </span>
</div>

<div class="info-item">
    <span class="info-label">
        Pemilik
    </span>
    
    <span class="info-value">
        <?= $data['pemilik']; ?>
    </span>
</div>

<div class="info-item">
    <span class="info-label">
        Tanggal Kunjungan
    </span>
    
    <span class="info-value">
        <?= $data['tanggal_kunjungan']; ?>
    </span>
</div>

<div class="info-item total-card">

    <span class="info-label">
        Total Biaya
    </span>

    <span class="price">
        Rp <?= number_format($data['total_biaya']); ?>
    </span>

</div>

</div>

</div>

<!-- PEMERIKSAAN -->

<div class="medical-card">

<h3>Hasil Pemeriksaan</h3>

<div class="detail-section">

<label>Keluhan</label>

<div class="detail-box">
<?= nl2br($data['keluhan']); ?>
</div>

<label>Diagnosa</label>

<div class="detail-box">
<?= nl2br($data['diagnosa']); ?>
</div>

<label>Tindakan Medis</label>

<div class="detail-box">
<?= nl2br($data['tindakan']); ?>
</div>

<label>Catatan Dokter</label>

<div class="detail-box">
<?= nl2br($data['catatan']); ?>
</div>

</div>

</div>

<!-- OBAT -->

<div class="medical-card">

<h3>Obat Digunakan</h3>

<table class="table">

<thead>

<tr>
<th>Nama Obat</th>
<th>Jumlah</th>
<th>Subtotal</th>
</tr>

</thead>

<tbody>

<?php if(mysqli_num_rows($obat)>0){ ?>

<?php while($o=mysqli_fetch_assoc($obat)){ ?>

<tr>
    <td><?= $o['nama_obat']; ?></td>
    <td><?= $o['jumlah']; ?></td>
    <td>Rp <?= number_format($o['subtotal']); ?></td>
</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="3" class="empty-data">

Tidak ada obat digunakan

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- VAKSIN -->

<div class="medical-card">

<h3>Vaksin Digunakan</h3>

<table class="table">

<thead>

<tr>
<th>Nama Vaksin</th>
<th>Jumlah</th>
<th>Subtotal</th>
</tr>

</thead>

<tbody>

<?php if(mysqli_num_rows($vaksin)>0){ ?>

<?php while($o=mysqli_fetch_assoc($vaksin)){ ?>

<tr>
    <td><?= $o['nama_vaksin']; ?></td>
    <td><?= $o['jumlah']; ?></td>
    <td>Rp <?= number_format($o['subtotal']); ?></td>
</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="3" class="empty-data">

Tidak ada Vaksin digunakan

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- LAMPIRAN -->

<div class="attachment-card">

    <div>

        <strong>📄 Hasil Laboratorium</strong>

        <p>
            File hasil pemeriksaan laboratorium
        </p>

    </div>

    <a
    href="../assets/img/uploads/lab/<?= $data['hasil_lab']; ?>"
    target="_blank"
    class="btn btn-primary">

        Buka File

    </a>

</div>

<br><br>

<?php if($data['foto_medis'] != ''){ ?>

<a
href="../assets/img/uploads/medis/<?= $data['foto_medis']; ?>"
target="_blank">

<img
src="../assets/img/uploads/medis/<?= $data['foto_medis']; ?>"
class="medical-image">

</a>

<?php } else { ?>

<p>Tidak ada foto medis.</p>

<?php } ?>

</div>
