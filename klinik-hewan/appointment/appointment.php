<?php

include "../config/session.php";
include "../config/database.php";

$query = mysqli_query(
$conn,
"
SELECT

a.*,
p.nama AS pemilik,

GROUP_CONCAT(
h.nama_hewan
ORDER BY h.nama_hewan
SEPARATOR ', '
) AS daftar_hewan

FROM appointment a

JOIN pemilik p
ON a.id_pemilik=p.id_pemilik

LEFT JOIN appointment_hewan ah
ON a.id_appointment=ah.id_appointment

LEFT JOIN hewan h
ON ah.id_hewan=h.id_hewan

GROUP BY a.id_appointment

ORDER BY
a.tanggal DESC,
a.jam DESC
"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Pendaftaran</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/appointment.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">


<div class="page-header">

    <div>

        <h1>Pendaftaran</h1>

        <p>
            Kelola pendaftaran pasien dan kunjungan
        </p>
    </div>

    <button
    id="openAddModal"
    class="btn btn-success">

        + Tambah Pendaftaran

    </button>

</div>

<div class="content-card">

    <table class="table">

        <thead>

            <tr>

                <th>Tanggal</th>
                <th>Jam</th>
                <th>Pemilik</th>
                <th>Hewan</th>
                <th>Status</th>
                <th>Aksi</th>

            </tr>

        </thead>

        <tbody>

        <?php while($row=mysqli_fetch_assoc($query)){ ?>

            <tr>

                <td>
                    <?= date('d M Y', strtotime($row['tanggal'])); ?>
                </td>

                <td>
                    <?= substr($row['jam'],0,5); ?>
                </td>

                <td>
                    <?= $row['pemilik']; ?>
                </td>

                <td>
                    🐾 <?= $row['daftar_hewan']; ?>
                </td>

                <td>

                    <?php

                    switch($row['status'])
                    {

                        case 'Pending':
                            echo '<span class="badge-warning">Pending</span>';
                        break;

                        case 'Pemeriksaan':
                            echo '<span class="badge-primary">Pemeriksaan</span>';
                        break;

                        case 'Selesai':
                            echo '<span class="badge-success">Selesai</span>';
                        break;

                        case 'Batal':
                            echo '<span class="badge-danger">Batal</span>';
                        break;

                    }

                    ?>

                </td>

                <td>

                    <button
                    class="btn btn-primary btn-detail"
                    data-id="<?= $row['id_appointment']; ?>">

                        Detail

                    </button>

                    <button
                    class="btn btn-warning btn-edit"
                    data-id="<?= $row['id_appointment']; ?>">

                        Edit

                    </button>

                    <a
                    href="delete_appointment.php?id=<?= $row['id_appointment']; ?>"
                    onclick="return confirm('Yakin hapus pendaftaran?')"
                    class="btn btn-danger">

                        Hapus

                    </a>

                </td>

            </tr>

        <?php } ?>

        </tbody>

    </table>

</div>

<div class="modal-overlay" id="ajaxModal">

    <div class="modal-box large">

        <button
        id="closeAjaxModal"
        class="modal-close">

            ×

        </button>

        <div id="modalContent"></div>

    </div>

</div>
<script src="../assets/js/appointment.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>
</html>