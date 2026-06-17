<?php

include "../config/session.php";
include "../config/database.php";

$query = mysqli_query(
$conn,
"SELECT
k.*,
h.nama_hewan,
p.nama AS nama_pemilik

FROM kunjungan k

JOIN hewan h
ON k.id_hewan=h.id_hewan

JOIN pemilik p
ON h.id_pemilik=p.id_pemilik

ORDER BY k.id_kunjungan DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Riwayat Kunjungan</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/kunjungan.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<div class="page-header">

    <div>
        <h1>🩺 Riwayat Kunjungan</h1>
        <p>Kelola seluruh rekam medis dan kunjungan pasien</p>
    </div>

    <button
    id="openModal"
    class="btn btn-success">

        ➕ Tambah Kunjungan

    </button>

</div>

<div class="content-card">

    <table class="table">

        <thead>

        <tr>

            <th>Tanggal</th>
            <th>Hewan</th>
            <th>Pemilik</th>
            <th>Diagnosa</th>
            <th>Total Biaya</th>
            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        <?php while($row=mysqli_fetch_assoc($query)){ ?>

        <tr>

            <td>

                <div class="date-box">
                    <?= date('d M Y',strtotime($row['tanggal_kunjungan'])) ?>
                </div>

            </td>

            <td>

                <div class="pet-name">
                    🐾 <?= $row['nama_hewan']; ?>
                </div>

            </td>

            <td>

                <?= $row['nama_pemilik']; ?>

            </td>

            <td>

                <span class="diagnosa">

                    <?= $row['diagnosa']; ?>

                </span>

            </td>

            <td>

                <span class="money">

                    Rp <?= number_format($row['total_biaya']); ?>

                </span>

            </td>

            <td>

                <div class="action-group">

                    <button
                    class="btn btn-primary btn-detail"
                    data-id="<?= $row['id_kunjungan']; ?>">

                        Detail

                    </button>

                    <a
                    href="cetak_rekam_medis.php?id=<?= $row['id_kunjungan']; ?>"
                    target="_blank"
                    class="btn btn-success">

                        Cetak

                    </a>

                </div>

            </td>

        </tr>

        <?php } ?>

        </tbody>

    </table>

</div>
<div
class="modal-overlay"
id="ajaxModal">

    <div class="modal-container">

        <button
        id="closeAjaxModal"
        class="btn btn-danger">

            ✕

        </button>

        <div id="modalContent"></div>

    </div>

</div>

<script src="../assets/js/sidebar.js"></script>
<script src="../assets/js/kunjungan.js"></script>