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
                    <h1>Bobot Kriteria</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Bobot Kriteria</li>
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
                        <h3 class="card-title">Tabel Bobot</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fas fa-minus"></i></button>
                        </div>
                    </div>
                    <!-- Tabel alternatif -->
                    <div class="card-body">
                        <button type="button" class="btn btn-info mb-3" data-toggle="modal" data-target="#addModal"><i class="far fa-plus-square"></i> Tambah Data</button>
                        <!-- Modal -->
                        <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data Bobot Kriteria</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="" method="post">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="kode">Alternatif</label>
                                                <select name="id_alternatif" class="form-control">
                                                    <?php
                                                    include 'koneksi.php';
                                                    $sql = mysqli_query($koneksi, "SELECT * FROM alternatif");
                                                    while ($data = mysqli_fetch_assoc($sql)) {
                                                    ?>
                                                        <option value="<?= $data['id_alter'] ?>"><?= $data['alternatif']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="C1">C1 Jumlah Siswa per Kelas</label>
                                                <input type="text" class="form-control" name="c1" id="C1" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="C2">C2 Fasilitas (100-500)</label>
                                                <input type="number" min="100" max="500" class="form-control" name="c2" id="C2" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="C3">C3 Adiwiyata (10-100)</label>
                                                <input type="number" min="10" max="100" class="form-control" name="c3" id="C3" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="C4">C4 Presentase Lulus UN (0-100%)</label>
                                                <input type="number" min="0" max="100" class="form-control" name="c4" id="C4" required>
                                            </div>
                                            <div class="form-group">
                                                <label>C5 Akreditasi</label>
                                                <select name="c5" class="form-control" required>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" name="add_bobot" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- tutup modal -->
                        <!-- tabel data -->
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="20px">No.</th>
                                    <th>Alternatif</th>
                                    <th>C1</th>
                                    <th>C2</th>
                                    <th>C3</th>
                                    <th>C4</th>
                                    <th>C5</th>
                                    <th width="120px">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'koneksi.php';
                                $no = 1;
                                $sql = mysqli_query($koneksi, "SELECT * FROM bobot a JOIN alternatif b 
                                                                    ON a.id_alter=b.id_alter");
                                while ($data = mysqli_fetch_assoc($sql)) {
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $data['alternatif']; ?></td>
                                        <td><?= $data['c1']; ?></td>
                                        <td><?= $data['c2']; ?></td>
                                        <td><?= $data['c3']; ?></td>
                                        <td><?= $data['c4']; ?></td>
                                        <td><?= $data['c5']; ?></td>
                                        <td align="center">
                                            <button class="btn btn-warning sm"><i class="far fa-edit"></i></button>
                                            <button class="btn btn-danger sm"><i class="far fa-trash-alt"></i></button>
                                        </td>
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
    </section>
</div>

<?php
// tambah data tabel bobot
if (isset($_POST['add_bobot'])) {
    $id = $_POST['id_alternatif'];
    $c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $c4 = $_POST['c4'];
    $c5 = $_POST['c5'];

    // mengacek apakah alternatif sudah di ada atau belum
    $sql3 = mysqli_query($koneksi, "SELECT id_alter FROM bobot WHERE id_alter=$id");
    $cek = mysqli_num_rows($sql3);
    if ($cek == 0) {
        mysqli_query($koneksi, "INSERT INTO bobot VALUES(NULL,$id,'$c1','$c2','$c3','$c4','$c5')");
        if (mysqli_affected_rows($koneksi) > 0) {
            echo "<script>
                alert('data berhasil di tambahkan');
                document.location.href = 'bobot.php';
                </script>";
        } else {
            echo "<script>
                alert('data gagal di tambahkan');
                document.location.href = 'bobot.php';
                </script>";
        }
    } else {
        echo "<script>
                alert('data alternatif sudah di ada, silahkan pilih data lain !!!');
                document.location.href = 'bobot.php';
                </script>";
    }
}

?>
<?php
include 'template/footer.php';
?>