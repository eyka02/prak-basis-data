<?php

include "../config/session.php";
include "../config/database.php";


$id = $_GET['id'];


$data = mysqli_fetch_assoc(

mysqli_query(
$conn,
"SELECT *
FROM pemilik
WHERE id_pemilik='$id'"
)

);


if(isset($_POST['update']))
{
    die("POST MASUK");
}

?>

<h2>Edit Pemilik</h2>

<form 
method="POST"
action="edit_pemilik.php?id=<?= $id ?>">>

<div class="form-grid">

    <div class="input-group">
        <label>Nama</label>
        <input
        type="text"
        name="nama"
        value="<?= $data['nama']; ?>">
    </div>

    <div class="input-group">
        <label>No HP</label>
        <input
        type="number"
        name="no_hp"
        value="<?= $data['no_hp']; ?>">
    </div>

    <div class="input-group full">
        <label>Email</label>
        <input
        type="email"
        name="email"
        value="<?= $data['email']; ?>">
    </div>

    <div class="input-group full">
        <label>Alamat</label>
        <textarea
        name="alamat"><?= $data['alamat']; ?></textarea>
    </div>

</div>

    <div class="modal-action">

        <button
        type="submit"
        name="update"
        class="btn-save">

        Update Data

        </button>

    </div>

</form>