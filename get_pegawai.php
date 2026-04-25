<?php
include 'config.php';

if (isset($_POST['idpeg'])) {
    $idpeg = $_POST['idpeg'];

    // Pastikan $idpeg benar-benar ada dan merupakan integer
    if (!empty($idpeg) && is_numeric($idpeg)) {
        // Query untuk mendapatkan data pegawai berdasarkan idpeg
        $query = "SELECT pegawai.idpeg, pegawai.nama, pegawai.departemen, pegawai.jabatan, pegawai.alamat, pegawai.telepon, 
                         pegawai.email, pegawai.gaji, pegawai.status, pegawai.jkelamin, pegawai.skerja, 
                         pegawai.jenjangpendidikan, pegawai.tglkerja
                  FROM pegawai
                  WHERE pegawai.idpeg = ?";
        
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("s", $idpeg);  // Bind parameter untuk idpeg (integer)
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $pegawai = $result->fetch_assoc();

                // Menampilkan data pegawai dalam format HTML dengan sanitasi untuk menghindari XSS
                echo "<table border='1'>
                        <tr><th>ID Pegawai</th><td>" . htmlspecialchars($pegawai['idpeg']) . "</td></tr>
                        <tr><th>Nama</th><td>" . htmlspecialchars($pegawai['nama']) . "</td></tr>
                        <tr><th>Departemen</th><td>" . htmlspecialchars($pegawai['departemen']) . "</td></tr>
                        <tr><th>Jabatan</th><td>" . htmlspecialchars($pegawai['jabatan']) . "</td></tr>
                        <tr><th>Alamat</th><td>" . htmlspecialchars($pegawai['alamat']) . "</td></tr>
                        <tr><th>Telepon</th><td>" . htmlspecialchars($pegawai['telepon']) . "</td></tr>
                        <tr><th>Email</th><td>" . htmlspecialchars($pegawai['email']) . "</td></tr>
                        <tr><th>Gaji</th><td>" . htmlspecialchars($pegawai['gaji']) . "</td></tr>
                        <tr><th>Status</th><td>" . htmlspecialchars($pegawai['status']) . "</td></tr>
                        <tr><th>Jenis Kelamin</th><td>" . htmlspecialchars($pegawai['jkelamin']) . "</td></tr>
                        <tr><th>Status Kerja</th><td>" . htmlspecialchars($pegawai['skerja']) . "</td></tr>
                        <tr><th>Jenjang Pendidikan</th><td>" . htmlspecialchars($pegawai['jenjangpendidikan']) . "</td></tr>
                        <tr><th>Tanggal Mulai Kerja</th><td>" . htmlspecialchars($pegawai['tglkerja']) . "</td></tr>
                      </table>";
            } else {
                echo "Data pegawai tidak ditemukan.";
            }
            $stmt->close();
        } else {
            echo "Terjadi kesalahan dalam mempersiapkan query.";
        }
    } else {
        echo "ID pegawai tidak valid.";
    }
}
?>