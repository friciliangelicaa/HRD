<?php
session_start();
require 'config.php';
require 'fpdf.php';

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit();
}

// Ambil data nama usaha dan alamat dari database
$stmt = $conn->prepare("SELECT nama, alamat FROM namausaha LIMIT 1");
$stmt->execute();
$stmt->bind_result($namaUsaha, $alamatUsaha);
$stmt->fetch();
$stmt->close();

// Ambil data pegawai dengan nama departemen dan jabatan dari database
$query = "
    SELECT peringatan.idpeg, pegawai.nama, peringatan.alasan
    FROM peringatan
    JOIN pegawai ON peringatan.idpeg = pegawai.idpeg
"; // Perbaiki tanda kutip di sini
$result = $conn->query($query);

// Buat PDF
$pdf = new FPDF();
$pdf->AddPage();

// Tambahkan kop dokumen
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, $namaUsaha, 0, 1, 'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, $alamatUsaha, 0, 1, 'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, 'Daftar Peringatan', 0, 1, 'L');
$pdf->Ln(2);

// Tambahkan header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(40, 10, 'ID Pegawai', 1, 0, 'C');
$pdf->Cell(50, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(40, 10, 'Alasan', 1, 0, 'C');

// Tambahkan data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C'); // No urut
    $pdf->Cell(40, 10, $row['idpeg'], 1, 0, 'C'); // ID Pegawai
    $pdf->Cell(50, 10, $row['nama'], 1, 0, 'C'); // Nama Pegawai
    $pdf->Cell(40, 10, $row['alasan'], 1, 0, 'C'); // Alasan
}

// Output PDF
$pdf->Output('I', 'Daftar_Peringatan.pdf');
?>
