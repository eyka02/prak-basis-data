<?php

include "../config/session.php";
include "../config/database.php";

if(isset($_POST['simpan']))
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
    "INSERT INTO vaksin
    (
        nama_vaksin,
        jenis_vaksin,
        stok,
        harga,
        supplier,
        status_stok
    )
    VALUES
    (
        '$nama',
        '$jenis',
        '$stok',
        '$harga',
        '$supplier',
        '$status'
    )"
    );

    header("Location: vaksin.php?success=tambah");
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

        <h2>💉 Tambah Data Vaksin</h2>

        <p>
            Tambahkan vaksin baru ke inventori klinik
        </p>

    </div>

    <form 
    method="POST"
    action="tambah_vaksin.php"
    enctype="multipart/form-data">

        <div class="form-group">

            <label>Nama Vaksin</label>

            <input
            type="text"
            name="nama_vaksin"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Jenis Vaksin</label>

            <input
            type="text"
            name="jenis_vaksin"
            class="form-control"
            placeholder="Contoh: Rabies, Distemper"
            required>

        </div>

        <div class="form-group">

            <label>Stok</label>

            <input
            type="number"
            name="stok"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Harga</label>

            <input
            type="number"
            name="harga"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Supplier</label>

            <input
            type="text"
            name="supplier"
            class="form-control">

        </div>

        <div class="form-action">

            <button
            type="submit"
            name="simpan"
            class="btn btn-success">

                Simpan Data

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
