<?php
include 'template/head.php';
include 'template/nav-top.php';
include 'template/nav-side.php';
?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Perhitungan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Perhitungan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <!-- Default box -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Matriks Bobot</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- Tabel alternatif -->
                    <div class="card-body">
                        <!-- tabel data -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th>C1</th>
                                    <th>C2</th>
                                    <th>C3</th>
                                    <th>C4</th>
                                    <th>C5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'koneksi.php';
                                $sql = mysqli_query($koneksi, "SELECT * FROM bobot a JOIN alternatif b 
                                                                    ON a.id_alter=b.id_alter");
                                while ($data = mysqli_fetch_assoc($sql)) {
                                ?>
                                    <tr>
                                        <td><?= $data['code']; ?></td>
                                        <td><?= $data['c1']; ?></td>
                                        <td><?= $data['c2']; ?></td>
                                        <td><?= $data['c3']; ?></td>
                                        <td><?= $data['c4']; ?></td>
                                        <td><?= $data['c5']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
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
        ?>
        <!-- tabel Tahap 1  -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tahap 1</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- Tabel alternatif -->
                    <div class="card-body">
                        <p>Mencari nilai Wj</p>
                        <!-- nilai wj -->
                        <?php
                        for ($i = 0; $i < $jml_kriteria; $i++) {
                            $tbl_kepentingan = $tbl_kepentingan + $get_bobot[$i];
                        }
                        echo '<p>⨊ Wj =' . $tbl_kepentingan . '</p>';
                        ?>
                        <!-- tabel data -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Keterangan</th>
                                    <th>C1</th>
                                    <th>C2</th>
                                    <th>C3</th>
                                    <th>C4</th>
                                    <th>C5</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Cost / Benefit</th>
                                    <?php
                                    for ($i = 0; $i < $jml_kriteria; $i++) {
                                        echo '<td>' . ucwords($costbenefit[$i]) . '</td>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th>Bobot</th>
                                    <?php
                                    for ($i = 0; $i < $jml_kriteria; $i++) {
                                        echo '<td>' . $get_bobot[$i] . '</td>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th>Wj</th>
                                    <?php
                                    for ($i = 0; $i < $jml_kriteria; $i++) {
                                        $wj[$i] = ($get_bobot[$i] / $tbl_kepentingan);
                                        echo '<td>' . round($wj[$i], 6) . '</td>';
                                    }
                                    ?>
                                </tr>
                                <tr>
                                    <th>Wj Ternormalisasi</th>
                                    <?php
                                    for ($i = 0; $i < $jml_kriteria; $i++) {
                                        if ($costbenefit[$i] == "cost") {
                                            $resultwj[$i] = (-1) * $wj[$i];
                                            echo '<td>' . round($resultwj[$i], 6) . '</td>';
                                        } else {
                                            $resultwj[$i] = $wj[$i];
                                            echo '<td>' . round($resultwj[$i], 6) . '</td>';
                                        }
                                    }
                                    ?>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Tabel Tahap 2 -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tahap 2</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- Tabel alternatif -->
                    <div class="card-body">
                        <p>Mencari Nilai Si</p>
                        <!-- tabel data -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Alternatif</th>
                                    <th>Nilai Si</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($j = 0; $j < $jml_bobot; $j++) {
                                ?>
                                    <tr>
                                        <th><?= $get_alternatif[$j][1]; ?></th>
                                        <?php
                                        for ($i = 0; $i < $jml_kriteria; $i++) {
                                            $si[$j][$i] = pow(($get_bobotkriteria[$j][$i]), $resultwj[$i]);
                                        }
                                        $resultsi[$j] = $si[$j][0] * $si[$j][1] * $si[$j][2] * $si[$j][3] * $si[$j][4];
                                        echo '<td>' . round($resultsi[$j], 6) . '</td>'
                                        ?>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>

        <!-- Tahap 3 -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tahap 3</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- Tabel alternatif -->
                    <div class="card-body">
                        <p>Mencari nilai Vi</p>
                        <?php
                        $totalsi = 0;
                        for ($i = 0; $i < $jml_bobot; $i++) {
                            $totalsi = $totalsi + $resultsi[$i];
                        }
                        echo '<p>⨊ Si =' . $totalsi . '</p>';
                        ?>
                        <!-- tabel data -->
                        <table id="example2" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Kode Alternatif</th>
                                    <th>Nama Alternatif</th>
                                    <th>Vi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                for ($i = 0; $i < $jml_bobot; $i++) {
                                ?>
                                    <tr>
                                        <th><?= $get_alternatif[$i][1]; ?></th>
                                        <th><?= $get_alternatif[$i][0]; ?></th>
                                        <?php
                                        $resultvi[$i] = round($resultsi[$i] / $totalsi, 6);
                                        ?>
                                        <td><?= $resultvi[$i]; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <!-- tabel rangking -->
                        <br>
                        <h3>Tabel Perangkingan Menentukan Sekolah Unggulan "SPK WP"</h3>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Rangking</th>
                                    <th>Nama Sekolah</th>
                                    <th>Vi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                uasort($resultvi, 'cmp');
                                for ($i = 0; $i < $alter; $i++) {
                                    if ($i == 0) {
                                        echo '<tr><td>' . $no++ . '</td>';
                                        echo '<td>' . $get_alternatif[array_search(end($resultvi), $resultvi)][0] . '</td>';
                                        echo '<td>' . current($resultvi) . '</td></tr>';
                                    } elseif ($i == ($alter - 1)) {
                                        echo '<tr><td>' . $no++ . '</td>';
                                        echo '<td>' . $get_alternatif[array_search((prev($resultvi)), $resultvi)][0] . '</td>';
                                        echo '<td>' . current($resultvi) . '</td></tr>';
                                    } else {
                                        echo '<tr><td>' . $no++ . '</td>';
                                        echo '<td>' . $get_alternatif[array_search(prev($resultvi), $resultvi)][0] . '</td>';
                                        echo '<td>' . current($resultvi) . '</td></tr>';
                                    }
                                }
                                function cmp($aku, $kamu)
                                {
                                    if ($aku == $kamu) {
                                        return 0;
                                    }
                                    return ($aku < $kamu) ? -1 : 1;
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </section>
</div>


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