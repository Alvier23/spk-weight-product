<?php
$koneksi = mysqli_connect("localhost", "root", "", "spk4_wp");

if ($koneksi->connect_errno) {
    echo "Failed to connect to MySQL: " . $koneksi->connect_error;
}
