<?php
// mengaktifkan session php
session_start();

// menghubungkan dengan koneksi
include 'koneksi.php';

// menangkap data yang dikirim dari form
if (isset($_POST['tipe_aksi'])) {

    $tipe_aksi = $_POST['tipe_aksi'];
} else if (isset($_GET['tipe_aksi'])) {
    $tipe_aksi = $_GET['tipe_aksi'];
}
// echo $tipe_aksi;
if ($tipe_aksi == "tambah") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $password = $_POST['password'];
    $peran = $_POST['peran'];
    // echo $email;
    // echo $nama;
    // echo $password;







    // cetak status message
    // echo $statusMsg;



    $data = mysqli_query($koneksi, "INSERT INTO `user` (`kode_user`, `nama`, `email`, `telp`, `password`, `peran`) VALUES (NULL, '$nama', '$email', '$telp', '$password', '$peran');");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        header("location:index.php?pesan=tambah user gagal");
    }
} else if ($tipe_aksi == "hapus") {
    $id = $_GET['id'];


    $data = mysqli_query($koneksi,  "DELETE FROM `barang` WHERE `barang`.`kode_barang` = $id");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        header("location:index.php?pesan=hapus barang gagal");
    }
} else if ($tipe_aksi == "edit") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $telp = $_POST['telp'];
    $password = $_POST['password'];
    $peran = $_POST['peran'];
    // echo $email;
    // echo $nama;
    // echo $password;







    // cetak status message
    // echo $statusMsg;



    $data = mysqli_query($koneksi, "UPDATE `user` SET `nama` = '$nama', `email` = '$email', `telp` = '$telp', `password` = '$password', `peran` = '$peran' WHERE `user`.`kode_user` = $id;");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        header("location:index.php?pesan=Edit User gagal");
    }
}
