<?php

include "../config/session.php";
include "../config/database.php";

/*
|--------------------------------------------------------------------------
| AMBIL DATA KUNJUNGAN
|--------------------------------------------------------------------------
*/

$kunjungan = mysqli_query(
$conn,
"SELECT 
k.id_kunjungan,
k.total_biaya,
h.nama_hewan,
p.nama AS pemilik

FROM kunjungan k

JOIN hewan h 
ON k.id_hewan = h.id_hewan

JOIN pemilik p 
ON h.id_pemilik = p.id_pemilik

ORDER BY k.id_kunjungan DESC"
);

/*
|--------------------------------------------------------------------------
| SIMPAN PEMBAYARAN
|--------------------------------------------------------------------------
*/

if(isset($_POST['simpan']))
{

$id_kunjungan = mysqli_real_escape_string($conn, $_POST['id_kunjungan']);
$metode       = mysqli_real_escape_string($conn, $_POST['metode']);

/*
|--------------------------------------------------------------------------
| AMBIL TOTAL DARI DATABASE (AMAN)
|--------------------------------------------------------------------------
*/

$get = mysqli_fetch_assoc(
mysqli_query(
$conn,
"SELECT total_biaya
FROM kunjungan
WHERE id_kunjungan='$id_kunjungan'"
));

$total = $get['total_biaya'];

/*
|--------------------------------------------------------------------------
| INVOICE AUTO
|--------------------------------------------------------------------------
*/

$invoice = "INV-" . date("YmdHis");

/*
|--------------------------------------------------------------------------
| INSERT PEMBAYARAN
|--------------------------------------------------------------------------
*/

mysqli_query(
$conn,
"INSERT INTO pembayaran
(
invoice,
id_kunjungan,
total,
metode,
tanggal_bayar
)
VALUES
(
'$invoice',
'$id_kunjungan',
'$total',
'$metode',
CURDATE()
)"
);

header("Location: pembayaran.php");
exit;

}

?>

<h2 class="page-title">
    Tambah Pembayaran
</h2>

<div class="form-card">

    <div class="form-header">

        <h3>💳 Tambah Pembayaran</h3>

        <p>
            Pilih kunjungan yang sudah selesai dan tentukan metode pembayaran.
        </p>

    </div>

    <form
    method="POST"
    action="tambah_pembayaran.php"
    enctype="multipart/form-data">

        <div class="form-group">

            <label>Kunjungan</label>

            <select
            name="id_kunjungan"
            class="form-control"
            required>

                <option value="">
                    -- Pilih Kunjungan --
                </option>

                <?php while($k=mysqli_fetch_assoc($kunjungan)){ ?>

                <option value="<?= $k['id_kunjungan']; ?>">

                    <?= $k['nama_hewan']; ?>
                    -
                    <?= $k['pemilik']; ?>
                    |
                    Rp <?= number_format($k['total_biaya']); ?>

                </option>

                <?php } ?>

            </select>

        </div>

        <div class="form-group">

            <label>Metode Pembayaran</label>

            <select
            name="metode"
            class="form-control"
            required>

                <option value="Cash">
                    Cash
                </option>

                <option value="Transfer">
                    Transfer Bank
                </option>

                <option value="QRIS">
                    QRIS
                </option>

            </select>

        </div>

        <div class="form-action">

            <button
            type="submit"
            name="simpan"
            class="btn btn-success">

                Simpan Pembayaran

            </button>

            <a
            href="pembayaran.php"
            class="btn btn-secondary">

                Kembali

            </a>

        </div>

    </form>

</div>