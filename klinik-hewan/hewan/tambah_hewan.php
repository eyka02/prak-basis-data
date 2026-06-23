<?php

include "../config/session.php";
include "../config/database.php";

$pemilik = mysqli_query(
$conn,
"SELECT * FROM pemilik
ORDER BY nama ASC"
);



if(isset($_POST['simpan']))
{

$foto = $_FILES['foto']['name'];

$tmp = $_FILES['foto']['tmp_name'];

move_uploaded_file(
$tmp,
"../assets/img/uploads/hewan/".$foto
);

$id_pemilik = $_POST['id_pemilik'];

$nama_hewan = $_POST['nama_hewan'];

$jenis = $_POST['jenis'];

$ras = $_POST['ras'];

$tanggal_lahir = $_POST['tanggal_lahir'];

$berat = $_POST['berat'];

$warna = $_POST['warna'];

$jenis_kelamin = $_POST['jenis_kelamin'];

$alergi = $_POST['alergi'];

$status_vaksin = $_POST['status_vaksin'];

mysqli_query(
$conn,
"INSERT INTO hewan
(
id_pemilik,
foto,
nama_hewan,
jenis,
ras,
tanggal_lahir,
berat,
warna,
jenis_kelamin,
alergi,
status_vaksin
)
VALUES
(
'$id_pemilik',
'$foto',
'$nama_hewan',
'$jenis',
'$ras',
'$tanggal_lahir',
'$berat',
'$warna',
'$jenis_kelamin',
'$alergi',
'$status_vaksin'
)"
);

header("Location: hewan.php");

}

?>

<form
method="POST"
action="tambah_hewan.php"
enctype="multipart/form-data"
class="pet-form">

    <div class="modal-header">
        <h2>🐾 Tambah Hewan</h2>
        <p>Tambahkan data hewan peliharaan baru</p>
    </div>

    <div class="photo-upload">

        <input
        type="file"
        name="foto"
        id="fotoInput"
        class="form-control">

    </div>

    <div class="form-grid">

        <div class="input-group">
            <label>Pemilik</label>

            <select
            name="id_pemilik"
            class="form-control"
            required>

                <option value="">
                    Pilih Pemilik
                </option>

                <?php while($p=mysqli_fetch_assoc($pemilik)){ ?>

                <option value="<?= $p['id_pemilik']; ?>">
                    <?= $p['nama']; ?>
                </option>

                <?php } ?>

            </select>
        </div>

        <div class="input-group">
            <label>Nama Hewan</label>

            <input
            type="text"
            name="nama_hewan"
            class="form-control"
            required>
        </div>

        <div class="input-group">
            <label>Jenis</label>

            <input
            type="text"
            name="jenis"
            class="form-control">
        </div>

        <div class="input-group">
            <label>Ras</label>

            <input
            type="text"
            name="ras"
            class="form-control">
        </div>

        <div class="input-group">
            <label>Tanggal Lahir</label>

            <input
            type="date"
            name="tanggal_lahir"
            class="form-control">
        </div>

        <div class="input-group">
            <label>Berat (Kg)</label>

            <input
            type="number"
            step="0.01"
            name="berat"
            class="form-control">
        </div>

        <div class="input-group">
            <label>Warna</label>

            <input
            type="text"
            name="warna"
            class="form-control">
        </div>

        <div class="input-group">
            <label>Jenis Kelamin</label>

            <select
            name="jenis_kelamin"
            class="form-control">

                <option value="Jantan">
                    Jantan
                </option>

                <option value="Betina">
                    Betina
                </option>

            </select>
        </div>

        <div class="input-group">
            <label>Status Vaksin</label>

            <select
            name="status_vaksin"
            class="form-control">

                <option value="Lengkap">
                    Lengkap
                </option>

                <option value="Belum Lengkap">
                    Belum Lengkap
                </option>

                <option value="Belum Pernah">
                    Belum Pernah
                </option>

            </select>
        </div>

    </div>

    <div class="input-group">

        <label>Riwayat Alergi</label>

        <textarea
        name="alergi"
        class="form-control"></textarea>

    </div>

    <div class="modal-action">

        <button
        type="button"
        class="btn-cancel"
        onclick="document.getElementById('ajaxModal').classList.remove('show')">

            Batal

        </button>

        <button
        type="submit"
        name="simpan"
        class="btn-save">

            💾 Simpan Data

        </button>

    </div>

</form>
