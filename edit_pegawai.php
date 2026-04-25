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

    // Ambil foto lama dari database
    $stmt = $conn->prepare("SELECT foto FROM pegawai WHERE idpeg = ?");
    $stmt->bind_param("s", $idpeg);
    $stmt->execute();
    $stmt->bind_result($old_photo_url);
    $stmt->fetch();
    $stmt->close();

    // Path direktori untuk menyimpan foto
    $target_dir = "C:/xampp/htdocs/lat_hrd/foto/";

    // Cek apakah ada file foto yang diupload
    if (!empty($_FILES['foto']['name'])) {
        // Dapatkan ekstensi file (misalnya jpg, png)
        $imageFileType = strtolower(pathinfo($_FILES["foto"]["name"], PATHINFO_EXTENSION));
        // Nama file adalah ID pegawai ditambah ekstensi file
        $target_file = $target_dir . $idpeg . "." . $imageFileType;

        // Validasi file gambar
        $check = getimagesize($_FILES["foto"]["tmp_name"]);
        if ($check !== false) {
            // Pindahkan file ke direktori yang diinginkan
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                // Update database dengan foto baru
                $foto = "foto/" . $idpeg . "." . $imageFileType;
            } else {
                $_SESSION['message'] = ['type' => 'error', 'text' => 'Gagal mengupload file gambar.'];
                header("Location: pegawai.php");
                exit();
            }
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'File bukan gambar.'];
            header("Location: pegawai.php");
            exit();
        }
    } else {
        // Jika tidak ada foto baru, gunakan foto lama
        $foto = $old_photo_url;
    }

    // Update data pegawai
    $stmt = $conn->prepare("UPDATE pegawai SET nama = ?, iddep = ?, idjab = ?, alamat = ?, telepon = ?, email = ?, gaji = ?, status = ?, foto = ?, jkelamin = ?, skerja = ?, jenjangpendidikan = ?, tglkerja = ? WHERE idpeg = ?");
    $stmt->bind_param("ssssssssssssss", $nama, $iddep, $idjab, $alamat, $telepon, $email, $gaji, $status, $foto, $jkelamin, $skerja, $jenjangpendidikan, $tglkerja, $idpeg);

    // Eksekusi update statement
    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Data pegawai berhasil diperbarui.'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui data pegawai.'];
    }

    $stmt->close();
    header("Location: pegawai.php");
    exit();
} else {
    header("Location: pegawai.php");
    exit();
}
?>