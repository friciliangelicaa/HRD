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

// Ambil data izin dari database
$query = "
    SELECT i.id_izin, i.idpeg, p.nama, i.tanggal, i.jam, i.alasan, i.pembuat_surat
    FROM izin AS i
    JOIN pegawai AS p ON i.idpeg = p.idpeg
";
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
$pdf->Cell(0, 10, 'Daftar Izin', 0, 1, 'L');
$pdf->Ln(2);

// Tambahkan header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(25, 10, 'ID Izin', 1, 0, 'C');
$pdf->Cell(25, 10, 'ID Pegawai', 1, 0, 'C');
$pdf->Cell(40, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(25, 10, 'Tanggal', 1, 0, 'C');
$pdf->Cell(20, 10, 'Jam', 1, 0, 'C');
$pdf->Cell(45, 10, 'Alasan', 1, 1, 'C');

// Tambahkan data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C'); // No urut
    $pdf->Cell(25, 10, $row['id_izin'], 1, 0, 'C'); // ID Izin
    $pdf->Cell(25, 10, $row['idpeg'], 1, 0, 'C'); // ID Pegawai
    $pdf->Cell(40, 10, $row['nama'], 1, 0, 'C'); // Nama Pegawai
    $pdf->Cell(25, 10, date('d/m/Y', strtotime($row['tanggal'])), 1, 0, 'C'); // Tanggal
    $pdf->Cell(20, 10, $row['jam'], 1, 0, 'C'); // Jam
    $pdf->Cell(45, 10, $row['alasan'], 1, 1, 'L'); // Alasan
}

// Output PDF
$pdf->Output('I', 'Daftar_Izin.pdf');
?>
