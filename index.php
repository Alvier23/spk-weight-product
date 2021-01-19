<?php
include 'template/head.php';
include 'template/nav-top.php';
include 'template/nav-side.php';

include 'koneksi.php';
$sql = mysqli_query($koneksi, "SELECT * FROM alternatif");
$sql2 = mysqli_query($koneksi, "SELECT * FROM bobot");
$jumlahdata_alternatif = mysqli_num_rows($sql);
$jumlahdata_bobot = mysqli_num_rows($sql2);

?>


<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">

    <h3 class="p-2" align="center">APLIKASI SISTEM PENDUKUNG KEPUTUSAN MENGGUNAKAN METODE WP BERBASIS WEB </h3>
    <h5 align="center">MENENTUKAN SEKOLAH MENENGAH PERTAMA NEGERI (SMPN) UNGGULAN DI WILAYAH SURABAYA</h5>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3><?= $jumlahdata_alternatif; ?></h3>
                        <p>Jumlah Data Alternatif</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="alternatif.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3><?= $jumlahdata_bobot; ?></h3>
                        <p>Jumlah Data Bobot Kriteria</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="bobot.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-4 col-6">
                <!-- small box -->
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Hasil</h3>
                        <p>Perhitungan</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="hitung.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->






        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Analisa</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body">
                <div>
                    <canvas id="chartAkhir"></canvas>
                </div>

                <!-- Memanggil semua fungsi -->
                <?php
                $jml_kriteria = jml_kriteria();
                $jml_bobot = jumlah_tabel_bobot();
                $get_bobot = get_bobot();
                $costbenefit = get_costbenefit();
                $get_alternatif = get_alternatif();
                end($get_alternatif);
                $alter = key($get_alternatif) + 1;
                $get_bobotkriteria = bobot_setiap_kriteria();
                $tbl_kepentingan = 0;
                $tbl_bobot = 0;

                for ($i = 0; $i < $jml_kriteria; $i++) {
                    $tbl_kepentingan = $tbl_kepentingan + $get_bobot[$i];
                }
                for ($i = 0; $i < $jml_kriteria; $i++) {
                    $wj[$i] = ($get_bobot[$i] / $tbl_kepentingan);
                }
                for ($i = 0; $i < $jml_kriteria; $i++) {
                    if ($costbenefit[$i] == "cost") {
                        $resultwj[$i] = (-1) * $wj[$i];
                    } else {
                        $resultwj[$i] = $wj[$i];
                    }
                }
                for ($j = 0; $j < $jml_bobot; $j++) {
                    for ($i = 0; $i < $jml_kriteria; $i++) {
                        $si[$j][$i] = pow(($get_bobotkriteria[$j][$i]), $resultwj[$i]);
                    }
                    $resultsi[$j] = $si[$j][0] * $si[$j][1] * $si[$j][2] * $si[$j][3] * $si[$j][4];
                }
                $totalsi = 0;
                for ($i = 0; $i < $jml_bobot; $i++) {
                    $totalsi = $totalsi + $resultsi[$i];
                }
                for ($i = 0; $i < $jml_bobot; $i++) {
                    $resultvi[$i] = round($resultsi[$i] / $totalsi, 6);
                }
                ?>

            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                Kelompok 4 SPK UTM
            </div>
            <!-- /.card-footer-->
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- Fungsi perhitungan -->
<?php
// memanggil fungsi cost dan benefit pada tabel kriteria
function get_costbenefit()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
    $i = 0;
    while ($row = $query->fetch_assoc()) {
        @$cost_benefit[$i] = $row['jenis'];
        $i++;
    }
    return $cost_benefit;
}

// menghitung jumlah isi pada tabel kriteria
function jml_kriteria()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
    $result = mysqli_num_rows($query);
    return $result;
}

// Mendapatkan nilai kolom bobot pada tabel kriteria
function get_bobot()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM kriteria");
    $i = 0;
    while ($row = $query->fetch_assoc()) {
        @$bobot[$i] = $row['bobot'];
        $i++;
    }
    return $bobot;
}

// menghitung jumlah isi pada tabel bobot
function jumlah_tabel_bobot()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM bobot");
    $result = mysqli_num_rows($query);
    return $result;
}

// mendapatkan nilai c1 c2 c3 c4 c5 pada tabel bobot
function bobot_setiap_kriteria()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM bobot");
    $i = 0;
    while ($row = $query->fetch_assoc()) {
        @$bobot_kriteria[$i][0] = $row['c1'];
        @$bobot_kriteria[$i][1] = $row['c2'];
        @$bobot_kriteria[$i][2] = $row['c3'];
        @$bobot_kriteria[$i][3] = $row['c4'];
        @$bobot_kriteria[$i][4] = $row['c5'];
        $i++;
    }
    return $bobot_kriteria;
}

// mendapatkan nama alternatif dar tabel bobot
function get_alternatif()
{
    include 'koneksi.php';
    $query = mysqli_query($koneksi, "SELECT * FROM bobot a JOIN alternatif b 
                                            ON a.id_alter=b.id_alter");
    $i = 0;
    while ($row = $query->fetch_assoc()) {
        @$col_alternatif[$i][0] = $row['alternatif'];
        @$col_alternatif[$i][1] = $row['code'];
        $i++;
    }
    return $col_alternatif;
}

?>
<?php
include 'template/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script>
    var ctx = document.getElementById('chartAkhir').getContext('2d');
    var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'bar',

        // The data for our dataset
        data: {
            labels: [
                <?php
                for ($i = 0; $i < $jml_bobot; $i++) {
                    echo "'" . $get_alternatif[$i][0] . "',";
                }
                ?>
            ],
            datasets: [{
                label: 'Data Vi',
                backgroundColor: 'rgb(255, 99, 0)',
                borderColor: 'rgb(255, 99, 0)',
                data: [
                    <?php
                    for ($i = 0; $i < $jml_bobot; $i++) {
                        echo $resultvi[$i] . ',';
                    }
                    ?>
                ]
            }]
        },

        // Configuration options go here
        options: {}
    });
</script>