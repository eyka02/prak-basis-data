
<?php

include "../config/session.php";
include "../config/database.php";



/*
|--------------------------------------------------------------------------
| SEARCH
|--------------------------------------------------------------------------
*/

$keyword = '';

if(isset($_GET['search']))
{
    $keyword =
    mysqli_real_escape_string(
        $conn,
        $_GET['search']
    );
}

/*
|--------------------------------------------------------------------------
| DATA PEMILIK
|--------------------------------------------------------------------------
*/

$query = mysqli_query(
    $conn,
    "SELECT *
    FROM pemilik
    WHERE nama LIKE '%$keyword%'
    ORDER BY id_pemilik ASC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Pemilik</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/pemilik.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

    <div class="page-header">

        <div>
            <h1>Data Pemilik</h1>
            <p>Kelola seluruh data pemilik hewan</p>
        </div>

        <button
        type="button"
        id="openModal"
        class="btn btn-success">

        + Tambah Pemilik

        </button>

    </div>

    <br><br>

    <div class="content-card">
    <form method="GET">

    <input
    type="text"
    name="search"
    placeholder="Cari Nama Pemilik"
    class="form-control">

    <br>

    <button class="btn btn-primary">
    Cari
    </button>

    </form>
    </div>

    <br>
    <div class="content-card">
    <table class="table">

    <tr>

    <th>ID</th>
    <th>Nama</th>
    <th>No HP</th>
    <th>Email</th>
    <th>Registrasi</th>
    <th>Aksi</th>

    </tr>

    <?php while($row = mysqli_fetch_assoc($query)){ ?>

    <tr>

    <td><?= $row['id_pemilik']; ?></td>

    <td><?= $row['nama']; ?></td>

    <td><?= $row['no_hp']; ?></td>

    <td><?= $row['email']; ?></td>

    <td><?= $row['tanggal_registrasi']; ?></td>

    <td>

    <button
    class="btn btn-primary btn-detail"
    data-id="<?= $row['id_pemilik']; ?>">

    Detail

    </button>

    <button
    class="btn btn-warning btn-edit"
    data-id="<?= $row['id_pemilik']; ?>">

    Edit

    </button>

    <a
    href="delete_pemilik.php?id=<?= $row['id_pemilik']; ?>"
    class="btn btn-danger"
    onclick="return confirm('Hapus data?')">
    Hapus
    </a>

    </td>

    </tr>

    <?php } ?>

    </table>
    </div>



<div class="modal-overlay" id="modalPemilik">

    <div class="modal-container">

        <div class="modal-top">

            <div>

                <span class="modal-badge">
                    PEMILIK BARU
                </span>

                <h2>
                    Tambah Data Pemilik
                </h2>

                <p>
                    Masukkan informasi pemilik hewan dengan lengkap.
                </p>

            </div>

            <button
            id="closeModal"
            class="modal-close">

            ✕

            </button>

        </div>

        <form 
            method="POST"
            action="tambah_pemilik.php"
            enctype="multipart/form-data">

            <div class="form-grid">

                <div class="input-group">

                    <label>Nama Lengkap</label>

                    <input
                    type="text"
                    name="nama"
                    placeholder="Masukkan nama lengkap"
                    required>

                </div>

                <div class="input-group">

                    <label>No HP</label>

                    <input
                    type="number"
                    name="no_hp"
                    placeholder="08xxxxxxxxxx">

                </div>

                <div class="input-group full">

                    <label>Email</label>

                    <input
                    type="email"
                    name="email"
                    placeholder="nama@email.com">

                </div>

                <div class="input-group full">

                    <label>Alamat</label>

                    <textarea
                    name="alamat"
                    placeholder="Masukkan alamat lengkap"></textarea>

                </div>

            </div>

            <div class="modal-action">

                <button
                type="button"
                id="cancelModal"
                class="btn-cancel">

                Batal

                </button>

                <button
                type="submit"
                name="simpan"
                class="btn-save">

                Simpan Data

                </button>

            </div>

        </form>


    </div>

</div>

<div class="modal-overlay" id="ajaxModal">

    <div class="modal-container modal-xl">

        <button
        class="modal-close"
        id="closeAjaxModal">

        ✕

        </button>

        <div id="modalContent">

        </div>

    </div>

</div>


</div>
<script src="../assets/js/pemilik.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>
</html>