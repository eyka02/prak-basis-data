<?php

include "../config/session.php";
include "../config/database.php";

$id = $_GET['id'];

$query = mysqli_query(
$conn,
"SELECT *
FROM appointment
WHERE id_appointment='$id'"
);

$data = mysqli_fetch_assoc($query);

if(isset($_POST['update']))
{

    $tanggal = $_POST['tanggal'];
    $jam = $_POST['jam'];
    $keluhan = $_POST['keluhan'];
    $status = $_POST['status'];

    mysqli_query(
    $conn,
    "UPDATE appointment
    SET

    tanggal='$tanggal',
    jam='$jam',
    keluhan='$keluhan',
    status='$status'

    WHERE id_appointment='$id'"
    );

    header("Location: appointment.php");
    exit;
}

?>



<h2 class="page-title">
    Edit Appointment
</h2>

<div class="form-card">

    <div class="form-header">

        <h3>📅 Edit Jadwal Appointment</h3>

        <p>
            Perbarui jadwal, keluhan, dan status appointment.
        </p>

    </div>

    <form
    method="POST"
    action="edit_appointment.php?id=<?= $id ?>"
    enctype="multipart/form-data">

        <div class="form-group">

            <label>Tanggal</label>

            <input
            type="date"
            name="tanggal"
            class="form-control"
            value="<?= $data['tanggal']; ?>"
            required>

        </div>

        <div class="form-group">

            <label>Jam</label>

            <input
            type="time"
            name="jam"
            class="form-control"
            value="<?= $data['jam']; ?>"
            required>

        </div>

        <div class="form-group">

            <label>Keluhan</label>

            <textarea
            name="keluhan"
            class="form-control textarea-control"
            rows="5"><?= $data['keluhan']; ?></textarea>

        </div>

        <div class="form-group">

            <label>Status</label>

            <select
            name="status"
            class="form-control"
            required>

                <option value="Pending"
                <?= ($data['status']=='Pending') ? 'selected' : ''; ?>>
                    Menunggu
                </option>


                <option value="Pemeriksaan"
                <?= ($data['status']=='Pemeriksaan') ? 'selected' : ''; ?>>
                    Pemeriksaan
                </option>

                <option value="Selesai"
                <?= ($data['status']=='Selesai') ? 'selected' : ''; ?>>
                    Selesai
                </option>

                <option value="Batal"
                <?= ($data['status']=='Batal') ? 'selected' : ''; ?>>
                    Batal
                </option>

            </select>

        </div>

        <div class="form-action">

            <button
            type="submit"
            name="update"
            class="btn btn-success">

                Update Appointment

            </button>

            <a
            href="appointment.php"
            class="btn btn-danger">

                Batal

            </a>

        </div>

    </form>

</div>
