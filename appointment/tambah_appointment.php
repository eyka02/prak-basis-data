<?php

include "../config/session.php";
include "../config/database.php";


date_default_timezone_set('Asia/Jakarta');

$pemilik = mysqli_query(
$conn,
"SELECT *
FROM pemilik
ORDER BY nama ASC"
);

$hewan = [];

$q = mysqli_query(
$conn,
"SELECT *
FROM hewan
ORDER BY nama_hewan ASC"
);

while($h = mysqli_fetch_assoc($q))
{
    $hewan[] = $h;
}


if(isset($_POST['simpan']))
{

$id_pemilik = mysqli_real_escape_string(
$conn,
$_POST['id_pemilik']
);

$id_hewan = $_POST['id_hewan'];

$keluhan = mysqli_real_escape_string(
$conn,
$_POST['keluhan']
);

$tanggal = date("Y-m-d");
$jam = date("H:i:s");

if(
$id_pemilik=='' ||
empty($id_hewan)
)
{
    echo "<script>
    alert('Data wajib diisi!');
    history.back();
    </script>";
    exit;
}

mysqli_query(

$conn,

"INSERT INTO appointment
(
id_pemilik,
tanggal,
jam,
keluhan,
status
)

VALUES
(
'$id_pemilik',
'$tanggal',
'$jam',
'$keluhan',
'Pending'
)"

);

$id_appointment = mysqli_insert_id($conn);

foreach($id_hewan as $h)
{

mysqli_query(

$conn,

"INSERT INTO appointment_hewan
(
id_appointment,
id_hewan
)

VALUES
(
'$id_appointment',
'$h'
)"

);

}

header("Location: appointment.php");
exit;

}

?>

<div class="page-header">

    <div>

        <h2>📝 Tambah Pendaftaran</h2>

        <p>
            Daftarkan pasien untuk pemeriksaan
        </p>

    </div>

</div>

<div class="form-card">

    <div class="form-header">

        <h3>Form Pendaftaran</h3>

        <p>
            Lengkapi data pendaftaran pasien
        </p>

    </div>

<form
method="POST"
action="tambah_appointment.php">

    <!-- Pemilik -->

    <div class="form-group">

        <label>Pemilik</label>

        <select
        name="id_pemilik"
        id="id_pemilik"
        class="form-control"
        required>

            <option value="">
                -- Pilih Pemilik --
            </option>

            <?php while($p=mysqli_fetch_assoc($pemilik)){ ?>

            <option
            value="<?= $p['id_pemilik']; ?>">

                <?= $p['nama']; ?>

            </option>

            <?php } ?>

        </select>

    </div>

    <!-- Hewan -->

    <div class="form-group">

        <label>Pilih Hewan</label>

        <div
        id="list_hewan"
        style="
        border:1px solid #ddd;
        padding:10px;
        border-radius:8px;
        min-height:80px;
        ">

            Silakan pilih pemilik terlebih dahulu.

        </div>

    </div>

    <!-- Keluhan -->

    <div class="form-group">

        <label>Keluhan / Catatan</label>

        <textarea
        name="keluhan"
        class="form-control textarea"
        placeholder="Tuliskan keluhan atau catatan..."></textarea>

    </div>

    <!-- DATA HEWAN UNTUK JAVASCRIPT -->

    <input
    type="hidden"
    id="hewan_json"
    value='<?= json_encode($hewan); ?>'>

    <div class="form-action">

        <button
        type="submit"
        name="simpan"
        class="btn btn-success">

            Daftarkan

        </button>

        <a
        href="appointment.php"
        class="btn btn-danger">

            Kembali

        </a>

    </div>

</form>


</div>