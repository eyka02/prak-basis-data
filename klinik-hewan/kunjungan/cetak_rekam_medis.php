<?php

include "../config/session.php";
include "../config/database.php";

if(!isset($_GET['id']))
{
    die("ID kunjungan tidak ditemukan");
}

$id = (int)$_GET['id'];

$query = mysqli_query(
$conn,
"SELECT

k.*,

h.nama_hewan,
h.jenis,
h.ras,

p.nama AS pemilik,
p.no_hp

FROM kunjungan k

JOIN hewan h
ON k.id_hewan = h.id_hewan

JOIN pemilik p
ON h.id_pemilik = p.id_pemilik

WHERE k.id_kunjungan = '$id'"
);

$data = mysqli_fetch_assoc($query);

if(!$data)
{
    die("Data kunjungan tidak ditemukan");
}

/*
|--------------------------------------------------------------------------
| DATA OBAT
|--------------------------------------------------------------------------
*/

$obat = mysqli_query(
$conn,
"SELECT

o.nama_obat,
d.jumlah,
d.subtotal

FROM detail_obat_kunjungan d

JOIN obat o
ON d.id_obat = o.id_obat

WHERE d.id_kunjungan = '$id'"
);

/*
|--------------------------------------------------------------------------
| DATA VAKSIN
|--------------------------------------------------------------------------
*/

$vaksin = mysqli_query(
$conn,
"SELECT

v.nama_vaksin,
d.jumlah,
d.subtotal

FROM detail_vaksin_kunjungan d

JOIN vaksin v
ON d.id_vaksin = v.id_vaksin

WHERE d.id_kunjungan = '$id'"
);

?>

<!DOCTYPE html>
<html lang="id">

<head>

<meta charset="UTF-8">

<title>Cetak Rekam Medis</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:"Segoe UI",Tahoma,sans-serif;
    background:#f3f5f9;
    color:#333;
    padding:40px;

}

.print-container{

    max-width:900px;
    margin:auto;
    background:#fff;
    padding:40px;
    border-radius:12px;
    box-shadow:0 10px 30px rgba(0,0,0,.08);

}

.header{

    text-align:center;
    margin-bottom:30px;
    border-bottom:3px solid #2563eb;
    padding-bottom:20px;

}

.header h1{

    font-size:34px;
    color:#2563eb;
    margin-bottom:8px;

}

.header p{

    color:#666;
    font-size:15px;

}

.info{

    width:100%;
    margin-top:20px;
    border-collapse:collapse;

}

.info td{

    padding:10px 6px;
    vertical-align:top;

}

.info td:first-child{

    width:220px;
    font-weight:600;
    color:#444;

}

.section{

    margin-top:28px;

}

.section h3{

    background:#2563eb;
    color:#fff;
    padding:10px 15px;
    border-radius:8px;
    font-size:17px;
    margin-bottom:12px;

}

.section p{

    background:#fafafa;
    border:1px solid #e5e7eb;
    padding:15px;
    border-radius:8px;
    line-height:1.7;

}

.data-table{

    width:100%;
    border-collapse:collapse;
    margin-top:12px;

}

.data-table th{

    background:#2563eb;
    color:#fff;
    padding:12px;
    text-align:left;
    font-size:14px;

}

.data-table td{

    padding:12px;
    border-bottom:1px solid #e5e7eb;

}

.data-table tr:nth-child(even){

    background:#f9fafb;

}

.total-box{

    margin-top:30px;
    display:flex;
    justify-content:flex-end;

}

.total{

    background:#2563eb;
    color:#fff;
    padding:15px 25px;
    border-radius:10px;
    font-size:24px;
    font-weight:bold;

}

.footer{

    margin-top:70px;
    display:flex;
    justify-content:space-between;
    align-items:flex-end;

}

.footer .note{

    color:#777;
    font-size:13px;

}

.footer .signature{

    text-align:center;

}

.footer .signature p{

    margin-top:70px;
    border-top:1px solid #333;
    padding-top:8px;
    width:220px;

}

@media print{

    body{

        background:#fff;
        padding:0;

    }

    .print-container{

        box-shadow:none;
        border-radius:0;
        padding:0;
        max-width:100%;

    }

}

</style>

</head>

<body onload="window.print()">

<h1>REKAM MEDIS KLINIK HEWAN</h1>

<hr>

<table class="info">

<tr>
<td width="180">Nama Hewan</td>
<td width="20">:</td>
<td><?= htmlspecialchars($data['nama_hewan']); ?></td>
</tr>

<tr>
<td>Jenis</td>
<td>:</td>
<td><?= htmlspecialchars($data['jenis']); ?></td>
</tr>

<tr>
<td>Ras</td>
<td>:</td>
<td><?= htmlspecialchars($data['ras']); ?></td>
</tr>

<tr>
<td>Pemilik</td>
<td>:</td>
<td><?= htmlspecialchars($data['pemilik']); ?></td>
</tr>

<tr>
<td>No HP</td>
<td>:</td>
<td><?= htmlspecialchars($data['no_hp']); ?></td>
</tr>

<tr>
<td>Tanggal Kunjungan</td>
<td>:</td>
<td><?= $data['tanggal_kunjungan']; ?></td>
</tr>

</table>

<div class="section">

<h3>Keluhan</h3>

<p>
<?= nl2br(htmlspecialchars($data['keluhan'])); ?>
</p>

</div>

<div class="section">

<h3>Diagnosa</h3>

<p>
<?= nl2br(htmlspecialchars($data['diagnosa'])); ?>
</p>

</div>

<div class="section">

<h3>Tindakan Medis</h3>

<p>
<?= nl2br(htmlspecialchars($data['tindakan'])); ?>
</p>

</div>

<div class="section">

<h3>Catatan Dokter</h3>

<p>
<?= nl2br(htmlspecialchars($data['catatan'])); ?>
</p>

</div>

<div class="section">

<h3>Obat Yang Digunakan</h3>

<table class="data-table">

<tr>

<th>Nama Obat</th>
<th>Jumlah</th>
<th>Subtotal</th>

</tr>

<?php

if(mysqli_num_rows($obat) > 0)
{

while($o = mysqli_fetch_assoc($obat))
{

?>

<tr>

<td><?= $o['nama_obat']; ?></td>

<td><?= $o['jumlah']; ?></td>

<td>
Rp <?= number_format($o['subtotal']); ?>
</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="3">
Tidak ada obat digunakan
</td>

</tr>

<?php

}

?>

</table>

</div>

<div class="section">

<h3>Vaksin Yang Digunakan</h3>

<table class="data-table">

<tr>

<th>Nama Vaksin</th>
<th>Jumlah</th>
<th>Subtotal</th>

</tr>

<?php

if(mysqli_num_rows($vaksin) > 0)
{

while($v = mysqli_fetch_assoc($vaksin))
{

?>

<tr>

<td><?= $v['nama_vaksin']; ?></td>

<td><?= $v['jumlah']; ?></td>

<td>
Rp <?= number_format($v['subtotal']); ?>
</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="3">
Tidak ada vaksin digunakan
</td>

</tr>

<?php

}

?>

</table>

</div>

<div class="section">

<h3>Total Biaya</h3>

<p class="total">

Rp
<?= number_format($data['total_biaya']); ?>

</p>

</div>

<div class="footer">

<p>
Dokumen dicetak dari Sistem Rekam Medis Klinik Hewan
</p>

</div>

</body>
</html>