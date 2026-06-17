<?php

include "../config/session.php";
include "../config/database.php";



/*
|--------------------------------------------------------------------------
| STATISTIK
|--------------------------------------------------------------------------
*/

$totalPemilik = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM pemilik"));
$totalHewan   = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM hewan"));
$totalObat    = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM obat"));
$totalVaksin  = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM vaksin"));

$totalKunjunganHariIni = mysqli_num_rows(mysqli_query($conn, "
    SELECT *
    FROM kunjungan
    WHERE DATE(tanggal_kunjungan) = CURDATE()
"));

$totalAppointmentHariIni = mysqli_num_rows(mysqli_query($conn, "
    SELECT *
    FROM appointment
    WHERE tanggal = CURDATE()
"));

$stokMenipis = mysqli_num_rows(mysqli_query($conn, "
    SELECT *
    FROM obat
    WHERE status_stok IN ('Menipis','Kritis','Habis')
"));

$pendapatan = mysqli_fetch_assoc(mysqli_query($conn, "
    SELECT IFNULL(SUM(total),0) AS total
    FROM pembayaran
    WHERE MONTH(tanggal_bayar)=MONTH(CURDATE())
    AND YEAR(tanggal_bayar)=YEAR(CURDATE())
"));

/*
|--------------------------------------------------------------------------
| APPOINTMENT HARI INI
|--------------------------------------------------------------------------
*/

$jadwalHariIni = mysqli_query($conn, "
SELECT
    a.*,
    p.nama AS pemilik,
    GROUP_CONCAT(h.nama_hewan SEPARATOR ', ') AS daftar_hewan
FROM appointment a
JOIN pemilik p ON a.id_pemilik = p.id_pemilik
LEFT JOIN appointment_hewan ah ON a.id_appointment = ah.id_appointment
LEFT JOIN hewan h ON ah.id_hewan = h.id_hewan
WHERE a.tanggal = CURDATE()
GROUP BY a.id_appointment, p.nama, a.id_appointment, a.jam, a.status
ORDER BY a.jam ASC
");

/*
|--------------------------------------------------------------------------
| STOK KRITIS
|--------------------------------------------------------------------------
*/

$stokAlert = mysqli_query($conn, "
SELECT nama_obat, stok, status_stok
FROM obat
WHERE status_stok IN ('Menipis','Kritis','Habis')
ORDER BY stok ASC
");

/*
|--------------------------------------------------------------------------
| LINE CHART - PENDAPATAN MINGGUAN
|--------------------------------------------------------------------------
*/

$pendapatanMingguan = mysqli_query($conn, "
SELECT 
    DATE(tanggal_bayar) AS tanggal,
    IFNULL(SUM(total),0) AS total
FROM pembayaran
WHERE tanggal_bayar >= DATE_SUB(CURDATE(), INTERVAL 7 DAY)
GROUP BY DATE(tanggal_bayar)
ORDER BY tanggal ASC
");

/*
|--------------------------------------------------------------------------
| PIE CHART - TOP KUNJUNGAN
|--------------------------------------------------------------------------
*/

$topKunjungan = mysqli_query($conn, "
    SELECT 
        CONCAT(
            h.nama_hewan,
            ' - ',
            p.nama
        ) AS label,
        COUNT(a.id_appointment) AS total
    FROM appointment a
    LEFT JOIN appointment_hewan ah
        ON a.id_appointment = ah.id_appointment
    LEFT JOIN hewan h
        ON ah.id_hewan = h.id_hewan
    LEFT JOIN pemilik p
        ON h.id_pemilik = p.id_pemilik
    GROUP BY
        h.id_hewan,
        h.nama_hewan,
        p.nama
    ORDER BY total DESC
    LIMIT 5
");

/*
|--------------------------------------------------------------------------
| CONVERT RESULT (BIAR CHART GA ERROR)
|--------------------------------------------------------------------------
*/

$pendapatanMingguanData = [];
while ($row = mysqli_fetch_assoc($pendapatanMingguan)) {
    $pendapatanMingguanData[] = $row;
}

$topKunjunganData = [];
while ($row = mysqli_fetch_assoc($topKunjungan)) {
    $topKunjunganData[] = $row;
}

$chartData = [];

$queryChart = mysqli_query($conn,"
SELECT
DATE_FORMAT(tanggal_bayar,'%d/%m') as tanggal,
IFNULL(SUM(total),0) as total
FROM pembayaran
WHERE tanggal_bayar >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
GROUP BY tanggal_bayar
ORDER BY tanggal_bayar
");

while($row=mysqli_fetch_assoc($queryChart))
{
    $chartData[] = $row;
}



?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Dashboard</title>

<link rel="stylesheet"
href="../assets/css/global.css">

<link rel="stylesheet"
href="../assets/css/sidebar.css">

<link rel="stylesheet"
href="../assets/css/header.css">

<link rel="stylesheet"
href="../assets/css/dashboard.css">

</head>

<body>

<?php include "../includes/sidebar.php"; ?>

<div class="main-content">

<div class="page-header">

    <div>
        <h1>Dashboard Admin</h1>

        <p>
            Monitoring Klinik Hewan secara real-time
        </p>
    </div>

    <div class="header-badge">
        Live Dashboard
    </div>

</div>

<!-- CARD STATISTIK -->

<div class="card-container">

<div class="stat-card">

<div class="stat-icon">
👤
</div>

<div>
<p>Total Pemilik</p>
<h2 class="counter"
data-target="<?= $totalPemilik; ?>">
0
</h2>
</div>

</div>

<div class="stat-card">

<div class="stat-icon">
🐾
</div>

<div>
<p>Total Hewan</p>
<h2 class="counter"
data-target="<?= $totalHewan; ?>">
0
</h2>
</div>

</div>

<div class="stat-card">

<div class="stat-icon">
📅
</div>

<div>
<p>Kunjungan Hari Ini</p>
<h2 class="counter"
data-target="<?= $totalKunjunganHariIni; ?>">
0
</h2>
</div>

</div>

<div class="stat-card">

<div class="stat-icon">
💊
</div>

<div>
<p>Total Obat</p>
<h2 class="counter"
data-target="<?= $totalObat; ?>">
0
</h2>
</div>

</div>

<div class="stat-card">

<div class="stat-icon">
💉
</div>

<div>
<p>Total Vaksin</p>
<h2 class="counter"
data-target="<?= $totalVaksin; ?>">
0
</h2>
</div>

</div>

<div class="stat-card">

<div class="stat-icon">
🗓️
</div>

<div>
<p>Pendaftaran</p>
<h2 class="counter"
data-target="<?= $totalAppointmentHariIni; ?>">
0
</h2>
</div>

</div>

<div class="stat-card warning">

<div class="stat-icon">
⚠️
</div>

<div>
<p>Stok Menipis</p>
<h2 class="counter"
data-target="<?= $stokMenipis; ?>">
0
</h2>
</div>

</div>

<div class="stat-card success">

<div class="stat-icon">
💰
</div>

<div>
<p>Pendapatan</p>

<h2>
Rp <?= number_format($pendapatan['total']); ?>
</h2>

</div>

</div>

</div>

<br>

<br>

<div class="analytics-grid">

    <!-- Revenue -->
    <div class="chart-card">

        <div class="chart-header">

            <div>
                <span class="card-label">
                    Revenue Analytics
                </span>

                <h2>
                    Pendapatan Mingguan
                </h2>
            </div>

            <div class="chart-total">

                <h3>
                    Rp <?= number_format($pendapatan['total']); ?>
                </h3>

            </div>

        </div>

        <div class="chart-wrapper">

            <svg
            class="revenue-chart"
            viewBox="0 0 600 300">

                <defs>

                    <linearGradient
                    id="lineGradient">

                        <stop
                        offset="0%"
                        stop-color="#4F46E5"/>

                        <stop
                        offset="100%"
                        stop-color="#06B6D4"/>

                    </linearGradient>

                </defs>

                <polyline
                id="incomeChartLine"
                points="">
                </polyline>

            </svg>

        </div>

        <div
        class="chart-labels"
        id="chartLabels">
        </div>

    </div>

    <!-- Donut -->
    <div class="category-card">

        <div class="card-header">

            <div>

                <span class="card-label">
                    Popular Animal
                </span>

                <h3>
                    Hewan Terbanyak
                </h3>

            </div>

        </div>

        <div class="donut-wrapper">

            <div
            class="donut-chart"
            id="donutChart">

                <div class="donut-center">

                    <h2 id="donutPercent">
                        0%
                    </h2>

                    <span>
                        Terbanyak
                    </span>

                </div>

            </div>

        </div>

        <div
        class="category-list"
        id="categoryList">
        </div>

    </div>

</div>



<br>

<!-- ALERT STOK -->

<div class="detail-card">

<h3>Alert Stok Obat</h3>

<table class="table">

<tr>
<th>Nama Obat</th>
<th>Stok</th>
<th>Status</th>
</tr>

<?php while($s=mysqli_fetch_assoc($stokAlert)){ ?>

<tr>

<td><?= $s['nama_obat']; ?></td>

<td><?= $s['stok']; ?></td>

<td>

<?php

switch($s['status_stok'])
{
    case 'Menipis':
        echo '<span class="badge-warning">Menipis</span>';
    break;

    case 'Kritis':
        echo '<span class="badge-danger">Kritis</span>';
    break;

    case 'Habis':
        echo '<span class="badge-dark">Habis</span>';
    break;
}

?>

</td>

</tr>

<?php } ?>

</table>

</div>

<br>

<!-- APPOINTMENT -->

<div class="detail-card">

<h3>Jadwal Pemeriksaan Hari Ini</h3>

<table class="table">

<tr>
<th>Jam</th>
<th>Nama Hewan</th>
<th>Status</th>
</tr>

<?php while($j=mysqli_fetch_assoc($jadwalHariIni)){ ?>

<tr>

<td><?= $j['jam']; ?></td>

<td>
    <?php
        $hewan = explode(',', $j['daftar_hewan']);
        foreach($hewan as $h){
            echo '<span class="badge-primary" style="margin-right:5px;">🐾 '.trim($h).'</span>';
        }
    ?>
</td>

<td>
    <?php
    $status = $j['status'];

    if ($status == 'Pending') {
        echo '<span class="badge badge-pending">Pending</span>';
    } elseif ($status == 'Pemeriksaan') {
        echo '<span class="badge badge-proses">Pemeriksaan</span>';
    } elseif ($status == 'Selesai') {
        echo '<span class="badge badge-success">Selesai</span>';
    } elseif ($status == 'Batal') {
        echo '<span class="badge badge-batal">Batal</span>';
    }
    ?>
</td>

</tr>

<?php } ?>

</table>

</div>

<br>




<script>

document.addEventListener(
'DOMContentLoaded',
() => {

const counters =
document.querySelectorAll('.counter');

counters.forEach(counter=>{

const target =
+counter.dataset.target;

let count=0;

const update=()=>{

count += target/80;

if(count<target){

counter.innerText =
Math.ceil(count);

requestAnimationFrame(update);

}else{

counter.innerText =
target.toLocaleString();

}

};

update();

});

});

</script>

<script>
/* =========================
   SVG LINE CHART
========================= */

const pieData =
<?= json_encode($topKunjunganData); ?>;

const revenueData =
<?= json_encode(array_map('floatval', array_column($pendapatanMingguanData,'total'))); ?>;

const revenueLabels =
<?= json_encode(array_column($pendapatanMingguanData,'tanggal')); ?>;

const chartLine =
document.getElementById('incomeChartLine');

const chartLabels =
document.getElementById('chartLabels');

if(chartLine && revenueData.length > 0)
{
    let points = '';

    const width = 600;
    const height = 250;

    const maxValue =
    Math.max(...revenueData,1);

    if(revenueData.length === 1)
    {
        const y =
        height -
        ((revenueData[0]/maxValue)*200);

        points = `100,${y} 500,${y}`;
    }
    else
    {
        revenueData.forEach((value,index)=>{

            const x =
            index * (width/(revenueData.length-1));

            const y =
            height -
            ((value/maxValue)*200);

            points += `${x},${y} `;
        });
    }

    chartLine.setAttribute(
        'points',
        points
    );

    chartLine.style.fill = 'none';
    chartLine.style.stroke = '#4F46E5';
    chartLine.style.strokeWidth = '5';
}


/* =========================
   LABEL TANGGAL
========================= */

if(chartLabels)
{
    chartLabels.innerHTML = '';

    revenueLabels.forEach(label=>{

        const span =
        document.createElement('span');

        span.innerHTML =
        label.substring(5);

        chartLabels.appendChild(span);

    });
}
</script>

<script>

/*
=========================
DONUT CHART
=========================
*/

const donutChart =
document.getElementById('donutChart');

const donutPercent =
document.getElementById('donutPercent');

const categoryList =
document.getElementById('categoryList');

if(pieData.length > 0){

    const total =
    pieData.reduce(
        (sum,item)=>
        sum + Number(item.total),
        0
    );

    const top =
    pieData[0];

    const percent =
    Math.round(
        (Number(top.total) / total) * 100
    );

    donutPercent.textContent =
    percent + '%';

    let currentAngle = 0;

    const colors = [
        '#4F46E5',
        '#06B6D4',
        '#10B981',
        '#F59E0B',
        '#EF4444'
    ];

    const gradients = [];

    pieData.forEach((item,index)=>{

        const value =
        Number(item.total);

        const slice =
        (value / total) * 360;

        gradients.push(
            `${colors[index % colors.length]}
            ${currentAngle}deg
            ${currentAngle + slice}deg`
        );

        currentAngle += slice;

        categoryList.innerHTML += `
            <div class="category-item">
                <span>${item.label}</span>
                <strong>${value}</strong>
            </div>
        `;

    });

    donutChart.style.background =
    `conic-gradient(
        ${gradients.join(',')}
    )`;

}

</script>

<script src="../assets/js/dashboard.js"></script>
<script src="../assets/js/sidebar.js"></script>
</body>
</html>