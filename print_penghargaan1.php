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

// Ambil data penghargaan dari database
$query = "
    SELECT penghargaan.idpeg, pegawai.nama, penghargaan.alasan, penghargaan.tanggal
    FROM penghargaan
    JOIN pegawai ON penghargaan.idpeg = pegawai.idpeg
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
$pdf->Cell(0, 10, 'Daftar Penghargaan', 0, 1, 'L');
$pdf->Ln(2);

// Tambahkan header tabel
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(10, 10, 'No', 1, 0, 'C');
$pdf->Cell(30, 10, 'ID Pegawai', 1, 0, 'C');
$pdf->Cell(45, 10, 'Nama', 1, 0, 'C');
$pdf->Cell(85, 10, 'Alasan', 1, 0, 'C'); // Lebar kolom alasan lebih besar
$pdf->Cell(20, 10, 'Tanggal', 1, 1, 'C'); // Kolom tanggal

// Tambahkan data tabel
$pdf->SetFont('Arial', '', 12);
$no = 1;
while ($row = $result->fetch_assoc()) {
    $pdf->Cell(10, 10, $no++, 1, 0, 'C'); // No urut
    $pdf->Cell(30, 10, $row['idpeg'], 1, 0, 'C'); // ID Pegawai
    $pdf->Cell(45, 10, $row['nama'], 1, 0, 'C'); // Nama Pegawai
    
    // Gunakan MultiCell untuk alasan agar teks panjang terpotong otomatis
    $x = $pdf->GetX(); // Posisi X saat ini
    $y = $pdf->GetY(); // Posisi Y saat ini
    $pdf->MultiCell(85, 10, $row['alasan'], 1, 'L'); // Kolom alasan
    $pdf->SetXY($x + 85, $y); // Kembalikan posisi untuk kolom berikutnya
    
    $pdf->Cell(20, 10, date('d/m/Y', strtotime($row['tanggal'])), 1, 1, 'C'); // Kolom tanggal
}

// Output PDF
$pdf->Output('I', 'Daftar_Penghargaan.pdf');
?>
