<?php
include 'koneksi.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("location:./login.php?pesan=belum login");
}

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

$id_edit_barang = null;
$id_edit_user = null;
$barang = query("SELECT * FROM barang");
$user = query("SELECT * FROM user");

if (isset($_GET['id_edit_barang'])) {
    $id_edit_barang = $_GET['id_edit_barang'];
    $edit_barang = query("SELECT * FROM barang WHERE kode_barang = $id_edit_barang")[0];
    // var_dump($edit_barang);
}
if (isset($_GET['id_edit_user'])) {
    $id_edit_user = $_GET['id_edit_user'];
    $edit_user = query("SELECT * FROM user WHERE kode_user = $id_edit_user")[0];
    // var_dump($edit_barang);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Toko ABC</title>
</head>

<body class="w-full h-screen bg-gray-100 flex flex-col">
    <!-- This is an example component -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css" rel="stylesheet">
    <div class="w-screen flex flex-row items-center p-1 justify-between bg-gray-200 shadow-xs">
        <div class="ml-8 text-lg text-gray-700 hidden md:flex">Toko ABC</div>
        <!-- <span class="w-screen md:w-1/3 h-10 bg-gray-200 cursor-pointer border border-gray-300 text-sm rounded-full flex">
            <input type="search" name="serch" placeholder="Search" class="flex-grow px-4 rounded-l-full rounded-r-full text-sm focus:outline-none">
            <i class="fas fa-search m-3 mr-5 text-lg text-gray-700 w-4 h-4">
            </i>
        </span> -->
        <div class="flex flex-row-reverse mr-4 ml-4 md:hidden">
            <i class="fas fa-bars"></i>
        </div>
        <div class="flex flex-row mr-8 hidden md:flex">
            <a href="./index.php">

                <div class="px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">Home</div>
            </a>
            <a href="./cek_auth.php?tipe_aksi=logout">

                <div class="ml-10 px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">Logout</div>
            </a>
        </div>
    </div>
    <div class="flex flex-row mt-10 mx-5 justify-between " style="height: 40vh;">
        <div class="w-5/12 overflow-y-scroll">
            <table class="border-collapse w-full ">
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nama</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">harga</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Gambar</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Stok</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($barang as $b) {
                    ?>



                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nama</span>
                                <?= $b['nama'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Harga</span>
                                <?= $b['harga'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static w-20 flex overflow-hidden">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Gambar</span>
                                <img src="<?= $b['gambar'] ?>" class="w-26" alt="">
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Stok</span>
                                <?= $b['jml_stok'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800  border border-b text-center block lg:table-cell relative lg:static flex flex-col items-center">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                                <a href="./index.php?id_edit_barang=<?= $b['kode_barang'] ?>" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
                                <a href="./barang_handler.php?tipe_aksi=hapus&id=<?= $b['kode_barang'] ?>" class="text-blue-400 hover:text-blue-600 underline pl-6">Hapus</a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>


                </tbody>
            </table>
        </div>
        <div class="w-5/12">
            <table class="border-collapse w-full">
                <thead>
                    <tr>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Nama</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Email</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Telp</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Peran</th>
                        <th class="p-3 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($user as $u) {
                    ?>

                        <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Nama</span>
                                <?= $u['nama'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Email</span>
                                <?= $u['email'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Telp</span>
                                <?= $u['telp'] ?>
                            </td>

                            <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b text-center block lg:table-cell relative lg:static">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Peran</span>
                                <?= $u['peran'] ?>
                            </td>
                            <td class="w-full lg:w-auto p-3 text-gray-800  border border-b text-center block lg:table-cell relative lg:static flex flex-col items-center">
                                <span class="lg:hidden absolute top-0 left-0 bg-blue-200 px-2 py-1 text-xs font-bold uppercase">Actions</span>
                                <a href="./index.php?id_edit_user=<?= $u['kode_user'] ?>" class="text-blue-400 hover:text-blue-600 underline">Edit</a>
                                <a href="./user_handler.php?tipe_aksi=hapus&id=<?= $u['kode_user'] ?>" class="text-blue-400 hover:text-blue-600 underline pl-6">Hapus</a>
                            </td>
                        </tr>

                    <?php
                    }
                    ?>

                </tbody>
            </table>
        </div>


    </div>
    <div class="w-full mt-10 flex flex-row bg-blue px-5 justify-between">
        <div class="w-5/12">
            <?php
            if ($id_edit_barang != null) {
            ?>
                <form action="./barang_handler.php" method="post" enctype="multipart/form-data" class="mt-5 bg-white rounded-lg shadow">
                    <div class="flex">
                        <div class="flex-1 py-5 pl-5 overflow-hidden">
                            <svg class="inline align-text-top" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g>
                                    <path d="m4.88889,2.07407l14.22222,0l0,20l-14.22222,0l0,-20z" fill="none" id="svg_1" stroke="null"></path>
                                    <path d="m7.07935,0.05664c-3.87,0 -7,3.13 -7,7c0,5.25 7,13 7,13s7,-7.75 7,-13c0,-3.87 -3.13,-7 -7,-7zm-5,7c0,-2.76 2.24,-5 5,-5s5,2.24 5,5c0,2.88 -2.88,7.19 -5,9.88c-2.08,-2.67 -5,-7.03 -5,-9.88z" id="svg_2"></path>
                                    <circle cx="7.04807" cy="6.97256" r="2.5" id="svg_3"></circle>
                                </g>
                            </svg>
                            <h1 class="inline text-2xl font-semibold leading-none">Edit Barang</h1>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <input placeholder="Nama" name="tipe_aksi" value="edit" class=" hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Nama" name="id" value="<?= $edit_barang['kode_barang'] ?>" class=" hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Nama" name="nama" value="<?= $edit_barang['nama'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Harga" name="harga" value="<?= $edit_barang['harga'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <div class="flex">
                            <div class="flex-grow w-1/4 pr-2"><input placeholder="Stok" name="stok" value="<?= $edit_barang['jml_stok'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                            <div class="flex-grow"><input placeholder="url" name="gambar" value="<?= $edit_barang['gambar'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                            <!-- <div class="flex-grow"><input type="file" name="file" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div> -->
                        </div>
                        <!-- <div class="flex items-center pt-3"><input type="checkbox" class="w-4 h-4 text-black bg-gray-300 border-none rounded-md focus:ring-transparent"><label for="safeAdress" class="block ml-2 text-sm text-gray-900">Save as default address</label></div> -->
                    </div>
                    <div class="flex-initial pl-5 pb-5">
                        <button type="submit" class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            <span class="pl-2 mx-1">Simpan</span>
                        </button>
                    </div>

                </form>


            <?php
            } else {
            ?>
                <form action="./barang_handler.php" method="post" enctype="multipart/form-data" class="mt-5 bg-white rounded-lg shadow">
                    <div class="flex">
                        <div class="flex-1 py-5 pl-5 overflow-hidden">
                            <svg class="inline align-text-top" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g>
                                    <path d="m4.88889,2.07407l14.22222,0l0,20l-14.22222,0l0,-20z" fill="none" id="svg_1" stroke="null"></path>
                                    <path d="m7.07935,0.05664c-3.87,0 -7,3.13 -7,7c0,5.25 7,13 7,13s7,-7.75 7,-13c0,-3.87 -3.13,-7 -7,-7zm-5,7c0,-2.76 2.24,-5 5,-5s5,2.24 5,5c0,2.88 -2.88,7.19 -5,9.88c-2.08,-2.67 -5,-7.03 -5,-9.88z" id="svg_2"></path>
                                    <circle cx="7.04807" cy="6.97256" r="2.5" id="svg_3"></circle>
                                </g>
                            </svg>
                            <h1 class="inline text-2xl font-semibold leading-none">Tambah Barang</h1>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <input placeholder="Nama" name="tipe_aksi" value="tambah" class=" hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Nama" name="nama" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Harga" name="harga" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <div class="flex">
                            <div class="flex-grow w-1/4 pr-2"><input placeholder="Stok" name="stok" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                            <!-- <div class="flex-grow"><input placeholder="City" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div> -->
                            <div class="flex-grow"><input type="file" name="file" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                        </div>
                        <!-- <div class="flex items-center pt-3"><input type="checkbox" class="w-4 h-4 text-black bg-gray-300 border-none rounded-md focus:ring-transparent"><label for="safeAdress" class="block ml-2 text-sm text-gray-900">Save as default address</label></div> -->
                    </div>
                    <div class="flex-initial pl-5 pb-5">
                        <button type="submit" class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            <span class="pl-2 mx-1">Tambah</span>
                        </button>
                    </div>

                </form>


            <?php
            }

            ?>

        </div>



        <div class="w-5/12">
            <?php
            if ($id_edit_user != null) {
            ?>
                <form action="./user_handler.php" method="post" enctype="multipart/form-data" class="mt-5 bg-white rounded-lg shadow">
                    <div class="flex">
                        <div class="flex-1 py-5 pl-5 overflow-hidden">
                            <svg class="inline align-text-top" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g>
                                    <path d="m4.88889,2.07407l14.22222,0l0,20l-14.22222,0l0,-20z" fill="none" id="svg_1" stroke="null"></path>
                                    <path d="m7.07935,0.05664c-3.87,0 -7,3.13 -7,7c0,5.25 7,13 7,13s7,-7.75 7,-13c0,-3.87 -3.13,-7 -7,-7zm-5,7c0,-2.76 2.24,-5 5,-5s5,2.24 5,5c0,2.88 -2.88,7.19 -5,9.88c-2.08,-2.67 -5,-7.03 -5,-9.88z" id="svg_2"></path>
                                    <circle cx="7.04807" cy="6.97256" r="2.5" id="svg_3"></circle>
                                </g>
                            </svg>
                            <h1 class="inline text-2xl font-semibold leading-none">Edit User</h1>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <input placeholder="aksi" name="tipe_aksi" value="edit" class=" hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="id" name="id" value="<?= $edit_user['kode_user'] ?>" class="hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Nama" name="nama" value="<?= $edit_user['nama'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Email" name="email" value="<?= $edit_user['email'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Telp" value="<?= $edit_user['telp'] ?>" name="telp" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Password" value="<?= $edit_user['password'] ?>" name="password" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Peran" name="peran" value="<?= $edit_user['peran'] ?>" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <!-- <div class="flex">
                            <div class="flex-grow w-1/4 pr-2"><input placeholder="Stok" name="stok" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                            <div class="flex-grow"><input type="file" name="file" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                        </div> -->
                    </div>
                    <div class="flex-initial pl-5 pb-5">
                        <button type="submit" class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            <span class="pl-2 mx-1">Simpan</span>
                        </button>
                    </div>

                </form>


            <?php
            } else {
            ?>
                <form action="./user_handler.php" method="post" enctype="multipart/form-data" class="mt-5 bg-white rounded-lg shadow">
                    <div class="flex">
                        <div class="flex-1 py-5 pl-5 overflow-hidden">
                            <svg class="inline align-text-top" height="24px" viewBox="0 0 24 24" width="24px" xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                <g>
                                    <path d="m4.88889,2.07407l14.22222,0l0,20l-14.22222,0l0,-20z" fill="none" id="svg_1" stroke="null"></path>
                                    <path d="m7.07935,0.05664c-3.87,0 -7,3.13 -7,7c0,5.25 7,13 7,13s7,-7.75 7,-13c0,-3.87 -3.13,-7 -7,-7zm-5,7c0,-2.76 2.24,-5 5,-5s5,2.24 5,5c0,2.88 -2.88,7.19 -5,9.88c-2.08,-2.67 -5,-7.03 -5,-9.88z" id="svg_2"></path>
                                    <circle cx="7.04807" cy="6.97256" r="2.5" id="svg_3"></circle>
                                </g>
                            </svg>
                            <h1 class="inline text-2xl font-semibold leading-none">Tambah User</h1>
                        </div>
                    </div>
                    <div class="px-5 pb-5">
                        <input placeholder="Nama" name="tipe_aksi" value="tambah" class=" hidden text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Nama" name="nama" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Email" name="email" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Telp" name="telp" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Password" name="password" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <input placeholder="Peran" name="peran" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400">
                        <!-- <div class="flex">
                            <div class="flex-grow w-1/4 pr-2"><input placeholder="Stok" name="stok" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                            <div class="flex-grow"><input type="file" name="file" class=" text-black placeholder-gray-600 w-full px-4 py-2.5 mt-2 text-base    transform border-transparent rounded-lg bg-gray-200  focus:border-blueGray-500 focus:bg-white  focus:outline-none focus:shadow-outline focus:ring-2 ring-offset-current ring-offset-2 ring-gray-400"></div>
                        </div> -->
                    </div>
                    <div class="flex-initial pl-5 pb-5">
                        <button type="submit" class="flex items-center px-5 py-2.5 font-medium tracking-wide text-white capitalize   bg-black rounded-md hover:bg-gray-800  focus:outline-none focus:bg-gray-900  transition duration-300 transform active:scale-95 ease-in-out">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF">
                                <path d="M0 0h24v24H0V0z" fill="none"></path>
                                <path d="M5 5v14h14V7.83L16.17 5H5zm7 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3zm3-8H6V6h9v4z" opacity=".3"></path>
                                <path d="M17 3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V7l-4-4zm2 16H5V5h11.17L19 7.83V19zm-7-7c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3zM6 6h9v4H6z"></path>
                            </svg>
                            <span class="pl-2 mx-1">Tambah</span>
                        </button>
                    </div>

                </form>


            <?php
            }

            ?>

        </div>
    </div>


</body>

</html>