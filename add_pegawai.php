<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idpeg = $_POST['idpeg'];
    $nama = $_POST['nama'];
    $iddep = $_POST['iddep'];
    $idjab = $_POST['idjab'];
    $alamat = $_POST['alamat'];
    $telepon = $_POST['telepon'];
    $email = $_POST['email'];
    $gaji = $_POST['gaji'];
    $status = $_POST['status'];
    $jkelamin = $_POST['jkelamin'];
    $skerja = $_POST['skerja'];
    $jenjangpendidikan = $_POST['jenjangpendidikan'];
    $tglkerja = $_POST['tglkerja'];

    // Path direktori untuk menyimpan foto
    $target_dir = "C:/xampp/htdocs/lat_hrd/foto/";
    
    // Cek apakah ada file foto yang diupload
    if (!empty($_FILES['foto']['name'])) {
        // Dapatkan ekstensi file (misalnya jpg, png)
        $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));

        // Validasi ekstensi file
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowed_extensions)) {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Ekstensi file tidak diizinkan. Hanya JPG, JPEG, PNG, dan GIF yang diperbolehkan.'];
            header("Location: pegawai.php");
            exit();
        }

        // Nama file adalah ID pegawai ditambah ekstensi file
        $target_file = $target_dir . $idpeg . "." . $imageFileType;

        // Validasi file gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file ke direktori yang diinginkan
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Path yang akan disimpan di database (gunakan relative path)
                $foto = "foto/" . $idpeg . "." . $imageFileType;

                // Query untuk memasukkan data pegawai ke dalam database
                $stmt = $conn->prepare("INSERT INTO pegawai (idpeg, nama, iddep, idjab, alamat, telepon, email, gaji, status, foto, jkelamin, skerja, jenjangpendidikan, tglkerja) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssssssssssss", $idpeg, $nama, $iddep, $idjab, $alamat, $telepon, $email, $gaji, $status, $foto, $jkelamin, $skerja, $jenjangpendidikan, $tglkerja);

                if ($stmt->execute()) {
                    $_SESSION['message'] = ['type' => 'success', 'text' => 'Pegawai berhasil ditambahkan.'];
                } else {
                    $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menambahkan data pegawai.'];
                }
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal mengupload file gambar.'];
            }
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'File bukan gambar.'];
        }
    } else {
        // Jika tidak ada file foto, tetap lakukan insert
        $stmt = $conn->prepare("INSERT INTO pegawai (idpeg, nama, iddep, idjab, alamat, telepon, email, gaji, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssss", $idpeg, $nama, $iddep, $idjab, $alamat, $telepon, $email, $gaji, $status);
    }

    // Tutup statement dan redirect
    $stmt->close();
    header("Location: pegawai.php");
    exit();
}
?>