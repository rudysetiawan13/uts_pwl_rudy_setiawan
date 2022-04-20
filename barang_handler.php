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
} else if ($tipe_aksi == "tambah") {
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    // echo $email;
    // echo $nama;
    // echo $password;





    $targetDir = "uploads/";
    $fileName = basename($_FILES["file"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    if (!empty($_FILES["file"]["name"])) {
        // file formats yang diperbolehkan
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');
        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {

                $statusMsg = "The file " . $fileName . " has been uploaded.";
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
        }
    } else {
        $statusMsg = 'Please select a file to upload.';
    }

    // cetak status message
    // echo $statusMsg;



    $data = mysqli_query($koneksi, "INSERT INTO `barang` (`kode_barang`, `nama`, `harga`, `gambar`, `jml_stok`) VALUES (NULL, '$nama', '$harga', 'uploads/$fileName', '$stok');");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        header("location:index.php?pesan=tambah barang gagal");
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
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $gambar = $_POST['gambar'];
    // echo $email;
    // echo $nama;
    // echo $password;







    // cetak status message
    // echo $statusMsg;



    $data = mysqli_query($koneksi, "UPDATE `barang` SET `nama` = '$nama', `harga` = '$harga', `gambar` = '$gambar', `jml_stok` = '$stok' WHERE `barang`.`kode_barang` = $id;");
    var_dump($data);
    // menghitung jumlah data yang ditemukan
    // $cek_register = mysqli_num_rows($data);
    // echo $data;
    if ($data) {
        // $_SESSION['email'] = $email;
        // $_SESSION['status'] = "login";
        header("location:index.php");
    } else {
        header("location:index.php?pesan=Edit barang gagal");
    }
}
