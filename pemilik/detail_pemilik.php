<?php

include "../config/session.php";
include "../config/database.php";

$id = $_GET['id'];

$pemilik = mysqli_fetch_assoc(

mysqli_query(
$conn,
"SELECT *
FROM pemilik
WHERE id_pemilik='$id'"
)

);

$hewan = mysqli_query(
$conn,
"SELECT *
FROM hewan
WHERE id_pemilik='$id'"
);

?>

<div class="detail-header">

    <h2>
        <?= $pemilik['nama']; ?>
    </h2>

    <p>
        Detail Data Pemilik
    </p>

</div>

<div class="info-grid">

    <div class="info-card">
        <h4>No HP</h4>
        <span><?= $pemilik['no_hp']; ?></span>
    </div>

    <div class="info-card">
        <h4>Email</h4>
        <span><?= $pemilik['email']; ?></span>
    </div>

    <div class="info-card full">
        <h4>Alamat</h4>
        <span><?= $pemilik['alamat']; ?></span>
    </div>

</div>

<h3>Hewan Peliharaan</h3>

<table class="table">

<tr>

<th>Nama Hewan</th>
<th>Jenis</th>
<th>Ras</th>

</tr>

<?php while($h=mysqli_fetch_assoc($hewan)){ ?>

<tr>

<td><?= $h['nama_hewan']; ?></td>
<td><?= $h['jenis']; ?></td>
<td><?= $h['ras']; ?></td>

</tr>

<?php } ?>

</table>