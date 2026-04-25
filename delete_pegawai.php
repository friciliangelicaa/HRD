<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idpeg = $_POST['idpeg'];

    // Ambil path foto dari database sebelum menghapus pegawai
    $stmt = $conn->prepare("SELECT foto FROM pegawai WHERE idpeg = ?");
    $stmt->bind_param("s", $idpeg);
    $stmt->execute();
    $stmt->bind_result($foto);
    $stmt->fetch();
    $stmt->close();

    // Hapus pegawai dari database
    $stmt = $conn->prepare("DELETE FROM pegawai WHERE idpeg = ?");
    $stmt->bind_param("s", $idpeg);

    if ($stmt->execute()) {
        // Hapus file foto dari direktori
        if (file_exists($foto)) {
            unlink($foto);
        }
        $_SESSION['message'] = ['type' => 'success', 'text' => 'Pegawai dan foto berhasil dihapus.'];
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat menghapus data pegawai.'];
    }

    $stmt->close();
    header("Location: pegawai.php");
    exit();
}
?>