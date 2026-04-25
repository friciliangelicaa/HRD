<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idjab = $_POST['idjab'];
    $jabatan = $_POST['jabatan'];
    $iddep = $_POST['departemen']; // Ambil data departemen yang baru

    // Update nama jabatan di tabel jabatan
    $stmt = $conn->prepare("UPDATE jabatan SET jabatan = ? WHERE idjab = ?");
    $stmt->bind_param("ss", $jabatan, $idjab);

    if ($stmt->execute()) {
        // Update relasi departemen_jabatan
        $stmt = $conn->prepare("UPDATE departemen_jabatan SET iddep = ? WHERE idjab = ?");
        $stmt->bind_param("ss", $iddep, $idjab);
        if ($stmt->execute()) {
            $_SESSION['message'] = [
                'type' => 'success',
                'text' => 'Data jabatan dan departemen berhasil diperbarui.'
            ];
        } else {
            $_SESSION['message'] = [
                'type' => 'error',
                'text' => 'Terjadi kesalahan saat memperbarui departemen.'
            ];
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'error',
            'text' => 'Terjadi kesalahan saat memperbarui jabatan.'
        ];
    }

    $stmt->close();
    header("Location: jabatan.php");
    exit();
} else {
    header("Location: jabatan.php");
    exit();
}
?>
