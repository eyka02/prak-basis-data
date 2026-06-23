<?php

include "../config/session.php";
include "../config/database.php";

if(!isset($_GET['id']))
{
    die("ID vaksin tidak ditemukan");
}

$id = (int)$_GET['id'];

$query = mysqli_query(
$conn,
"SELECT *
FROM vaksin
WHERE id_vaksin='$id'"
);

$data = mysqli_fetch_assoc($query);

if(!$data)
{
    die("Data vaksin tidak ditemukan");
}

if(isset($_POST['update']))
{

    $nama      = mysqli_real_escape_string($conn,$_POST['nama_vaksin']);
    $jenis     = mysqli_real_escape_string($conn,$_POST['jenis_vaksin']);
    $stok      = (int)$_POST['stok'];
    $harga     = (int)$_POST['harga'];
    $supplier  = mysqli_real_escape_string($conn,$_POST['supplier']);

    if($stok <= 0)
    {
        $status = 'Habis';
    }
    elseif($stok <= 5)
    {
        $status = 'Kritis';
    }
    elseif($stok <= 10)
    {
        $status = 'Menipis';
    }
    else
    {
        $status = 'Aman';
    }

    mysqli_query(
    $conn,
    "UPDATE vaksin SET

        nama_vaksin='$nama',
        jenis_vaksin='$jenis',
        stok='$stok',
        harga='$harga',
        supplier='$supplier',
        status_stok='$status'

    WHERE id_vaksin='$id'"
    );

    header("Location: vaksin.php?success=update");
    exit;
}

?>


<div class="form-card">

    <button
    type="button"
    class="modal-close"
    onclick="document.getElementById('ajaxModal').classList.remove('show')">

        ×

    </button>

    <div class="form-header">

        <h2>✏️ Edit Data Vaksin</h2>

        <p>
            Perbarui informasi vaksin yang tersedia di inventori klinik
        </p>

    </div>

    <form
    method="POST"
    action="edit_vaksin.php?id=<?= $id ?>"
    enctype="multipart/form-data">

        <div class="form-group">

            <label>Nama Vaksin</label>

            <input
            type="text"
            name="nama_vaksin"
            class="form-control"
            required
            value="<?= htmlspecialchars($data['nama_vaksin']); ?>">

        </div>

        <div class="form-group">

            <label>Jenis Vaksin</label>

            <input
            type="text"
            name="jenis_vaksin"
            class="form-control"
            required
            value="<?= htmlspecialchars($data['jenis_vaksin']); ?>">

        </div>

        <div class="form-group">

            <label>Stok</label>

            <input
            type="number"
            name="stok"
            class="form-control"
            required
            value="<?= $data['stok']; ?>">

        </div>

        <div class="form-group">

            <label>Harga</label>

            <input
            type="number"
            name="harga"
            class="form-control"
            required
            value="<?= $data['harga']; ?>">

        </div>

        <div class="form-group">

            <label>Supplier</label>

            <input
            type="text"
            name="supplier"
            class="form-control"
            value="<?= htmlspecialchars($data['supplier']); ?>">

        </div>

        <div class="form-group">

            <label>Status Stok Saat Ini</label>

            <input
            type="text"
            class="form-control readonly-status"
            readonly
            value="<?= $data['status_stok']; ?>">

        </div>

        <div class="form-action">

            <button
            type="submit"
            name="update"
            class="btn btn-success">

                Update Data

            </button>

            <button
            type="button"
            class="btn btn-secondary"
            onclick="document.getElementById('ajaxModal').classList.remove('show')">

                Tutup

            </button>

        </div>

    </form>

</div>