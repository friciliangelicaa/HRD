<?php
session_start();
require 'config.php';

// Cek apakah metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $id_cuti = isset($_POST['id_cuti']) ? $_POST['id_cuti'] : null;
    $idpeg = isset($_POST['idpeg']) ? $_POST['idpeg'] : null;
    $tanggal = isset($_POST['tanggal']) ? $_POST['tanggal'] : null;
    $daritgl = isset($_POST['daritgl']) ? $_POST['daritgl'] : null;
    $sampaitgl = isset($_POST['sampaitgl']) ? $_POST['sampaitgl'] : null;
    $lamacuti = isset($_POST['lamacuti']) ? $_POST['lamacuti'] : null;
    $alasan = isset($_POST['alasan']) ? $_POST['alasan'] : null;
    $ditetapkan = isset($_POST['ditetapkan']) ? $_POST['ditetapkan'] : null;
    $pembuat_surat = isset($_POST['pembuat_surat']) ? $_POST['pembuat_surat'] : null;


    // Validasi jika semua data ada
    if ($id_cuti && $idpeg && $tanggal && $alasan && $ditetapkan && $pembuat_surat) {
        // Query untuk memperbarui data peringatan
        $stmt = $conn->prepare("UPDATE cuti SET idpeg = ?, tanggal = ?, daritgl = ?, sampaitgl = ?, lamacuti = ?, alasan = ?, ditetapkan = ?, pembuat_surat = ? WHERE id_cuti = ?");
        $stmt->bind_param("sssssssss", $idpeg, $tanggal, $daritgl, $sampaitgl, $lamacuti, $alasan, $ditetapkan, $pembuat_surat, $id_cuti);

        // Mengeksekusi query dan memberikan feedback kepada user
        if ($stmt->execute()) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Data cuti berhasil diperbarui.'];
        } else {
            $_SESSION['message'] = ['type' => 'error', 'text' => 'Terjadi kesalahan saat memperbarui data cuti.'];
        }

        $stmt->close();
    } else {
        $_SESSION['message'] = ['type' => 'error', 'text' => 'Data yang dikirim tidak lengkap.'];
    }

    // Redirect kembali ke halaman peringatan setelah proses selesai
    header("Location: cuti.php");
    exit();
} else {
    // Jika request bukan POST, redirect ke halaman peringatan
    header("Location: cuti.php");
    exit();
}
?>