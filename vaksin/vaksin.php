<?php

include "../config/session.php";
include "../config/database.php";

$search = '';

if(isset($_GET['search']))
{
    $search = mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );
}

$query = mysqli_query(
$conn,
"SELECT *
FROM vaksin
WHERE nama_vaksin
LIKE '%$search%'
ORDER BY nama_vaksin ASC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Vaksin</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/vaksin.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<div class="page-header">

    <div>
        <h1>💉 Data Vaksin</h1>
        <p>Kelola stok dan persediaan vaksin klinik</p>
    </div>

    <button
    id="openModal"
    class="btn btn-success">

        ➕ Tambah Vaksin

    </button>

</div>

<div class="content-card">

    <form method="GET" class="search-form">

        <input
        type="text"
        name="search"
        value="<?= $search; ?>"
        placeholder="Cari vaksin..."
        class="form-control">

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

            <th>Nama Vaksin</th>
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

                <div class="vaccine-name">

                    💉 <?= $row['nama_vaksin']; ?>

                </div>

            </td>

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
                    data-id="<?= $row['id_vaksin']; ?>">

                        Edit

                    </button>

                    <a
                    href="delete_vaksin.php?id=<?= $row['id_vaksin']; ?>"
                    class="btn btn-danger"
                    onclick="return confirm('Hapus vaksin?')">

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


        <div id="modalContent"></div>

    </div>

</div>

<script src="../assets/js/vaksin.js"></script>
<script src="../assets/js/sidebar.js"></script>