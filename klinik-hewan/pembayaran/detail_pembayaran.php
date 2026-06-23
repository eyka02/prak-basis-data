<?php

include "../config/session.php";
include "../config/database.php";

$id = mysqli_real_escape_string($conn, $_GET['id']);

$query = mysqli_query(
$conn,
"SELECT

pb.id_pembayaran,
pb.invoice,
pb.total,
pb.metode,
pb.created_at,

h.nama_hewan,
h.jenis,
h.ras,

p.nama AS nama_pemilik,
p.no_hp,
p.email

FROM pembayaran pb

JOIN kunjungan k
ON pb.id_kunjungan = k.id_kunjungan

JOIN hewan h
ON k.id_hewan = h.id_hewan

JOIN pemilik p
ON h.id_pemilik = p.id_pemilik

WHERE pb.id_pembayaran = '$id'
LIMIT 1"
);

$data = mysqli_fetch_assoc($query);

if(!$data){
    die("Data pembayaran tidak ditemukan");
}

?>



    <h2 class="page-title">Detail Pembayaran</h2>

    <div class="detail-card invoice-card">

        <table class="table invoice-table">

            <tr>
                <td>Invoice</td>
                <td><strong><?= $data['invoice']; ?></strong></td>
            </tr>

            <tr>
                <td>Tanggal</td>
                <td><?= date('d M Y H:i', strtotime($data['created_at'])); ?></td>
            </tr>

            <tr>
                <td>Pemilik</td>
                <td><?= $data['nama_pemilik']; ?></td>
            </tr>

            <tr>
                <td>No HP</td>
                <td><?= $data['no_hp']; ?></td>
            </tr>

            <tr>
                <td>Email</td>
                <td><?= $data['email']; ?></td>
            </tr>

            <tr>
                <td>Nama Hewan</td>
                <td><?= $data['nama_hewan']; ?></td>
            </tr>

            <tr>
                <td>Jenis</td>
                <td><?= $data['jenis']; ?></td>
            </tr>

            <tr>
                <td>Ras</td>
                <td><?= $data['ras']; ?></td>
            </tr>

            <tr>
                <td>Metode</td>
                <td><?= $data['metode']; ?></td>
            </tr>

            <tr class="total-row">
                <td>Total</td>
                <td>
                    <span class="total-price">
                        Rp <?= number_format($data['total']); ?>
                    </span>
                </td>
            </tr>

        </table>

        <div class="invoice-action">

            <a href="cetak_invoice.php?id=<?= $data['id_pembayaran']; ?>"
               class="btn btn-success"
               target="_blank">
                🖨 Cetak Invoice
            </a>

            <a href="pembayaran.php"
               class="btn btn-secondary">
                ← Kembali
            </a>

        </div>

    </div>
