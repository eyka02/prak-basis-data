<?php

include "../config/session.php";
include "../config/database.php";

$search = '';

if(isset($_GET['search']))
{
    $search = $_GET['search'];
}

$query = mysqli_query(
$conn,
"SELECT *
FROM obat
WHERE nama_obat
LIKE '%$search%'
ORDER BY nama_obat ASC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Obat</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/obat.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<div class="page-header">

    <div>
        <h1>💊 Data Obat</h1>
        <p>Kelola stok dan persediaan obat klinik</p>
    </div>

    <button
    id="openModal"
    class="btn btn-success">

        ➕ Tambah Obat

    </button>

</div>

<div class="content-card">

    <form method="GET" class="search-form">

        <input
        type="text"
        name="search"
        class="form-control"
        placeholder="Cari nama obat..."
        value="<?= $search; ?>">

        <button
        type="submit"
        class="btn btn-primary">

            Cari

        </button>

    </form>

</div>

<br>

<div class="content-card">

    <table class="table">

        <thead>

        <tr>

            <th>Nama Obat</th>
            <th>Kategori</th>
            <th>Stok</th>
            <th>Harga</th>
            <th>Status</th>
            <th>Aksi</th>

        </tr>

        </thead>

        <tbody>

        <?php while($row=mysqli_fetch_assoc($query)){ ?>

        <tr>

            <td>
                <div class="medicine-name">
                    💊 <?= $row['nama_obat']; ?>
                </div>
            </td>

            <td><?= $row['kategori']; ?></td>

            <td>

                <span class="stock-number">

                    <?= $row['stok']; ?>

                </span>

            </td>

            <td>

                <span class="price-tag">

                    Rp <?= number_format($row['harga']); ?>

                </span>

            </td>

            <td>

            <?php

            switch($row['status_stok']){

                case 'Aman':
                    echo '<span class="badge-success">Aman</span>';
                break;

                case 'Menipis':
                    echo '<span class="badge-warning">Menipis</span>';
                break;

                case 'Kritis':
                    echo '<span class="badge-danger">Kritis</span>';
                break;

                default:
                    echo '<span class="badge-dark">Habis</span>';
            }

            ?>

            </td>

            <td>

                <div class="action-group">

                    <button
                    class="btn btn-warning btn-edit"
                    data-id="<?= $row['id_obat']; ?>">

                        Edit

                    </button>

                    <a
                    href="delete_obat.php?id=<?= $row['id_obat']; ?>"
                    onclick="return confirm('Hapus data?')"
                    class="btn btn-danger">

                        Hapus

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

<script src="../assets/js/obat.js"></script>
<script src="../assets/js/sidebar.js"></script>
