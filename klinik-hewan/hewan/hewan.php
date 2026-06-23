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
"SELECT
h.*,
p.nama AS nama_pemilik
FROM hewan h
JOIN pemilik p
ON h.id_pemilik=p.id_pemilik
WHERE h.nama_hewan
LIKE '%$search%'
ORDER BY h.id_hewan DESC"
);

?>

<!DOCTYPE html>
<html>
<head>

<title>Data Hewan</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/hewan.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">


<div class="page-header">

    <div>

        <h1>Data Hewan</h1>

        <p>
            Kelola seluruh data hewan klinik
        </p>

    </div>

    <button
    id="openModal"
    class="btn btn-success">

    + Tambah Hewan

    </button>

</div>

<br><br>

<div class="content-card">

<form method="GET" class="search-form">

    <input
    type="text"
    name="search"
    value="<?= $search ?>"
    placeholder="Cari nama hewan..."
    class="form-control">

    <button
    class="btn btn-primary">

    Cari

    </button>

</form>

</div>

<br>

<table class="table">

<tr>

<th>Foto</th>
<th>Nama</th>
<th>Jenis</th>
<th>Ras</th>
<th>Pemilik</th>
<th>Status Vaksin</th>
<th>Aksi</th>

</tr>

<?php while($row=mysqli_fetch_assoc($query)){ ?>

<tr>

<td>

<img
src="../assets/img/uploads/hewan/<?= $row['foto']; ?>"
class="pet-avatar">

</td>

<td><?= $row['nama_hewan']; ?></td>

<td><?= $row['jenis']; ?></td>

<td><?= $row['ras']; ?></td>

<td><?= $row['nama_pemilik']; ?></td>

<td>

<?php

if($row['status_vaksin']=='Lengkap')
{
    echo '<span class="badge-success">Lengkap</span>';
}
elseif($row['status_vaksin']=='Belum')
{
    echo '<span class="badge-danger">Belum</span>';
}
else
{
    echo '<span class="badge-warning">'.$row['status_vaksin'].'</span>';
}

?>

</td>

<td>

<button
class="btn btn-primary btn-detail"
data-id="<?= $row['id_hewan']; ?>">

Detail

</button>

<button
class="btn btn-warning btn-edit"
data-id="<?= $row['id_hewan']; ?>">

Edit

</button>

<a
href="delete_hewan.php?id=<?= $row['id_hewan']; ?>"
class="btn btn-danger"
onclick="return confirm('Hapus Data?')">
Hapus
</a>

</td>

</tr>

<?php } ?>

</table>

</div>
<div class="modal-overlay" id="ajaxModal">

    <div class="modal-container modal-xl">

        <button
        class="modal-close"
        id="closeAjaxModal">

        ✕

        </button>

        <div id="modalContent"></div>

    </div>

</div>
<script src="../assets/js/hewan.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>
</html>