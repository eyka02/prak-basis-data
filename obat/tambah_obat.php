<?php

include "../config/session.php";
include "../config/database.php";

if(isset($_POST['simpan']))
{

$nama = $_POST['nama_obat'];

$kategori = $_POST['kategori'];

$stok = $_POST['stok'];

$harga = $_POST['harga'];

$supplier = $_POST['supplier'];

if($stok<=0)
{
$status='Habis';
}
elseif($stok<=5)
{
$status='Kritis';
}
elseif($stok<=10)
{
$status='Menipis';
}
else
{
$status='Aman';
}

mysqli_query(
$conn,
"INSERT INTO obat
(
nama_obat,
kategori,
stok,
harga,
supplier,
status_stok
)
VALUES
(
'$nama',
'$kategori',
'$stok',
'$harga',
'$supplier',
'$status'
)"
);

header("Location: obat.php");

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Tambah Obat</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/obat.css">

</head>

<body>

<div class="form-card">

    <div class="form-header">

        <h2>💊 Tambah Obat</h2>

        <p>
            Tambahkan data obat baru ke sistem
        </p>

    </div>

    <form
    method="POST"
    action="tambah_obat.php"
    enctype="multipart/form-data">

        <div class="form-group">

            <label>Nama Obat</label>

            <input
            type="text"
            name="nama_obat"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Kategori</label>

            <input
            type="text"
            name="kategori"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Stok</label>

            <input
            type="number"
            name="stok"
            min ="0"
            class="form-control"
            required>

        </div>

        <div class="form-group">

            <label>Harga</label>

            <input
            type="number"
            name="harga"
            min ="0"
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

                Simpan

            </button>

            <button
            type="button"
            onclick="document.getElementById('ajaxModal').classList.remove('show')"
            class="btn btn-secondary">

                Batal

            </button>

        </div>

    </form>

</div>

</body>
</html>
