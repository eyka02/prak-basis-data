<?php

include "../config/session.php";
include "../config/database.php";

$query = mysqli_query(
$conn,
"SELECT

pb.id_pembayaran,
pb.invoice,
pb.total,
pb.metode,
pb.created_at,

h.nama_hewan,
p.nama AS pemilik

FROM pembayaran pb

JOIN kunjungan k
ON pb.id_kunjungan = k.id_kunjungan

JOIN hewan h
ON k.id_hewan = h.id_hewan

JOIN pemilik p
ON h.id_pemilik = p.id_pemilik

ORDER BY pb.id_pembayaran DESC"
);

?>

<!DOCTYPE html>
<html>

<head>

<title>Data Pembayaran</title>
<link rel="stylesheet" href="../assets/css/global.css">
<link rel="stylesheet" href="../assets/css/sidebar.css">
<link rel="stylesheet" href="../assets/css/header.css">
<link rel="stylesheet" href="../assets/css/pembayaran.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<div class="page-header">

    <div>

        <h1>Pembayaran</h1>

        <p>
            Kelola transaksi dan invoice klinik
        </p>

    </div>

    <button
    id="openAddModal"
    class="btn btn-success">

        + Tambah Pembayaran

    </button>

</div>

<div class="content-card">

    <table class="table">

        <thead>

            <tr>

                <th>Invoice</th>
                <th>Tanggal</th>
                <th>Pemilik</th>
                <th>Hewan</th>
                <th>Total</th>
                <th>Metode</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

        <?php while($row=mysqli_fetch_assoc($query)){ ?>

        <tr>

            <td>
                <?= $row['invoice']; ?>
            </td>

            <td>
                <?= date('d M Y',strtotime($row['created_at'])); ?>
            </td>

            <td>
                <?= $row['pemilik']; ?>
            </td>

            <td>
                🐾 <?= $row['nama_hewan']; ?>
            </td>

            <td>
                Rp <?= number_format($row['total']); ?>
            </td>

            <td>

                <span class="badge-primary">
                    <?= $row['metode']; ?>
                </span>

            </td>

            <td>

                <button
                class="btn btn-primary btn-detail"
                data-id="<?= $row['id_pembayaran']; ?>">

                    Detail

                </button>

                <a
                href="cetak_invoice.php?id=<?= $row['id_pembayaran']; ?>"
                target="_blank"
                class="btn btn-success">

                    Invoice

                </a>

            </td>

        </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<div
class="modal-overlay"
id="ajaxModal">

    <div class="modal-box large">

        <button
        id="closeAjaxModal"
        class="modal-close">

            ×

        </button>

        <div id="modalContent"></div>

    </div>

</div>
<script src="../assets/js/pembayaran.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>

</html>