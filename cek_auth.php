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
if ($tipe_aksi == "login") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    // echo $email;

    // menyeleksi data admin dengan username dan password yang sesuai
    $data = mysqli_query($koneksi, "select * from user where email='$email' and password='$password'");

    // menghitung jumlah data yang ditemukan
    $cek = mysqli_num_rows($data);
    // var_dump($cek);
    if ($cek > 0) {
        $_SESSION['email'] = $email;
        $_SESSION['status'] = "login";

        header("location:index.php");
    } else {
        header("location:login.php?pesan=email atau password salah");
    }
} else if ($tipe_aksi == "register") {
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    // echo $email;
    // echo $nama;
    // echo $password;

    $data = mysqli_query($koneksi, "INSERT INTO user VALUES(NULL,'$nama','$email','$password','','','')");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:login.php");
    } else {
        // header("location:register.php?pesan=daftar gagal");
    }
} else if ($tipe_aksi == "logout") {
    // menghapus semua session
    session_destroy();

    // mengalihkan halaman sambil mengirim pesan logout
    header("location:./login.php?pesan=anda berhasil logout");
}
