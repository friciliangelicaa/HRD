<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $notelepon = $_POST['notelepon'];
    $fax = $_POST['fax'];
    $email = $_POST['email'];
    $npwp = $_POST['npwp'];
    $bank = $_POST['bank'];
    $noaccount = $_POST['noaccount'];
    $atasnama = $_POST['atasnama'];
    $pimpinan = $_POST['pimpinan'];

    // Menggunakan idusaha sebagai identifikasi baris yang akan diupdate
    $stmt = $conn->prepare("UPDATE namausaha SET nama = ?, alamat = ?, notelepon = ?, fax = ?, email = ?, npwp = ?, bank = ?, noaccount = ?, atasnama = ?, pimpinan = ? WHERE nama = ?");
    $stmt->bind_param("sssssssssss", $nama, $alamat, $notelepon, $fax, $email, $npwp, $bank, $noaccount, $atasnama, $pimpinan, $nama);

    if ($stmt->execute()) {
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Data Identitas Usaha berhasil diperbarui.'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui data.'];
    }

    $stmt->close();

    header("Location: namausaha.php");
    exit();
} else {
    header("Location: namausaha.php");
    exit();
}
?>
