<?php
session_start();
require 'config.php';

if (!isset($_SESSION['iduser'])) {
    header("Location: login.php");
    exit();
}

$iduser = $_SESSION['iduser'];

// Ambil data user dari database
$stmt = $conn->prepare("SELECT username, email FROM login WHERE iduser = ?");
$stmt->bind_param("i", $iduser);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();

// Ambil data nama usaha dan alamat dari database
$stmt = $conn->prepare("SELECT nama, alamat FROM namausaha LIMIT 1");
$stmt->execute();
$stmt->bind_result($namaUsaha, $alamatUsaha);
$stmt->fetch();
$stmt->close();

// Ambil data pegawai dengan LEFT JOIN ke departemen dan jabatan
$result = $conn->query("SELECT 
        pegawai.idpeg, pegawai.nama, pegawai.iddep, departemen.departemen, pegawai.idjab, 
        jabatan.jabatan, pegawai.alamat, pegawai.telepon, pegawai.email, pegawai.gaji, 
        pegawai.status, pegawai.skerja, pegawai.cuti, pegawai.tglkerja, pegawai.jkelamin, 
        pegawai.jenjangpendidikan, pegawai.foto
    FROM pegawai
    LEFT JOIN departemen ON pegawai.iddep = departemen.iddep
    LEFT JOIN jabatan ON pegawai.idjab = jabatan.idjab
");

// Generate idpeg otomatis
$stmt = $conn->query("SELECT idpeg FROM pegawai ORDER BY idpeg DESC LIMIT 1");
$latestidpeg = $stmt->fetch_assoc();
$urut = 1;
if ($latestidpeg) {
    $latestNumber = (int) substr($latestidpeg['idpeg'], 7);
    $urut = $latestNumber + 1;
}
$newidpeg = 'P' . date('Y') . date('m') . str_pad($urut, 3, '0', STR_PAD_LEFT);

// Simpan pesan ke variabel dan hapus dari session
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<?php require 'head.php'; ?>
<div class="wrapper">
    <header>
        <h4><?php echo htmlspecialchars($namaUsaha); ?></h4>
        <p><?php echo htmlspecialchars($alamatUsaha); ?></p>
    </header>

    <?php include 'sidebar.php'; ?>
    <div class="content" id="content">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between align-items-center">
                    <h4>Pegawai</h4>
                    <div>
                        <button type="button" class="btn btn-primary mb-3 mr-2" data-bs-toggle="modal" data-bs-target="#addpegawaiModal"><i class='fas fa-plus'></i> Add </button>
                        <button type="button" class="btn btn-secondary mb-3" id="printButton"><i class='fas fa-print'></i> Print</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="departemenTable" class="table table-bordered table-striped table-hover">    
                            <thead class="text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>ID Pegawai</th>
                                    <th>Nama</th>
                                    <th>Departemen</th>
                                    <th>Kd. Departemen</th>
                                    <th>Jabatan</th>
                                    <th>Kd. Jabatan</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Alamat</th>
                                    <th>No.Hp</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Pendidikan</th>
                                    <th>S.Kepegawaian</th>
                                    <th>Gaji</th>
                                    <th>Tgl Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if ($result && $result->num_rows > 0) {
                                    $no = 1;
                                    // echo "<td class='text-center'><img style='height: 50px; width: 50px;' src='foto/" . htmlspecialchars($pegawai['idpeg']) . ".jpg' alt='foto'></td>";
                                    while ($pegawai = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td class='text-center'>" . $no++ . "</td>";
                                        // echo "<td class='text-center'><img style='height: 50px; width: 50px;' src='foto/" . htmlspecialchars($pegawai['idpeg']) . "' alt='foto'></td>";
                                        // echo "<td class='text-center'><img style='height: 50px; width: 50px;' src='" . htmlspecialchars($pegawai['foto']) . "' alt='foto'></td>";
                                        echo "<td class='text-center'><img style='height: 50px; width: 50px;' src='foto/" . htmlspecialchars($pegawai['idpeg']) . ".jpg' alt='foto'></td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['idpeg']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['nama']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['departemen']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['iddep']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['jabatan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['idjab']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['jkelamin']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['alamat']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['telepon']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['email']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['status']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['jenjangpendidikan']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['skerja']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['gaji']) . "</td>";
                                        echo "<td class='text-center'>" . htmlspecialchars($pegawai['tglkerja']) . "</td>";
                                        echo "<td class='text-center'>";
                                        echo "<div class='d-flex justify-content-center'>";
                                        echo "<button class='btn btn-warning btn-sm edit-btn mr-1'
                                        data-bs-toggle= 'modal' 
                                        data-bs-target='#editpegawaiModal'
                                        data-idpeg=  '" . htmlspecialchars($pegawai['idpeg']) . "'
                                        data-nama=  '" . htmlspecialchars($pegawai['nama']) . "'
                                        data-departemen=  '" . htmlspecialchars($pegawai['departemen']) . "'
                                        data-iddep=   '" . htmlspecialchars($pegawai['iddep']) . "'
                                        data-jabatan=   '" . htmlspecialchars($pegawai['jabatan']) . "'
                                        data-idjab=   '" . htmlspecialchars($pegawai['idjab']) . "
                                        data-jkelamin=   '" . htmlspecialchars($pegawai['jkelamin']) . "
                                        data-alamat=   '" . htmlspecialchars($pegawai['alamat']) . "
                                        data-telepon=   '" . htmlspecialchars($pegawai['telepon']) . "
                                        data-email=   '" . htmlspecialchars($pegawai['email']) . "
                                        data-status=   '" . htmlspecialchars($pegawai['status']) . "
                                        data-jenjangpendidikan=   '" . htmlspecialchars($pegawai['jenjangpendidikan']) . "
                                        data-skerja=   '" . htmlspecialchars($pegawai['skerja']) . "
                                        data-gaji=   '" . htmlspecialchars($pegawai['gaji']) . "
                                        data-tglkerja=   '" . htmlspecialchars($pegawai['tglkerja']) . "
                                        <i class='fas fa-edit'></i> Edit
                                        </button>";
                                        echo "<button class='btn btn-danger btn-sm delete-btn' data-id='" . htmlspecialchars($pegawai['idpeg']) . "'><i class='fas fa-trash'></i> Delete</button>";
                                        echo "</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='14' class='text-center'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php'; ?>
</div>

<!-- Tambah Pegawai Modal -->
<div class="modal fade" id="addpegawaiModal" tabindex="-1" aria-labelledby="addpegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addpegawaiModalLabel">Tambah Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="add_pegawai.php" method="post" enctype="multipart/form-data">                    
                    <div class="mb-3">
                        <label for="idpeg" class="form-label">ID Pegawai</label>
                        <input type="text" class="form-control" id="idpeg" name="idpeg" value="<?php echo htmlspecialchars($newidpeg); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Pegawai</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan Nama Pegawai">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="alamat" name="alamat" required placeholder="Masukkan Alamat">
                    </div>
                    <div class="mb-3">
                        <label for="telepon" class="form-label">No. Telp</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" required placeholder="Masukkan Nomor Telepon">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan Email">
                    </div>
                    <div class="mb-3">
                        <label for="jkelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="jkelamin" name="jkelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-Laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jenjangpendidikan" class="form-label">Jenjang Pendidikan</label>
                        <select class="form-control" id="jenjangpendidikan" name="jenjangpendidikan" required>
                            <option value="">Pilih Jenjang Pendidikan</option>
                            <option value="SMA/SMK Sederajat">SMA/SMK Sederajat</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="departemen" class="form-label">Departemen</label>
                        <select class="form-control" id="departemen" name="iddep" required>
                            <option value="">Pilih Departemen</option>
                            <?php
                            // Ambil data departemen dari database
                            $departemenResult = $conn->query("SELECT iddep, departemen FROM departemen");
                            while ($departemen = $departemenResult->fetch_assoc()) {
                                echo "<option value='" . htmlspecialchars($departemen['iddep']) . "'>" . htmlspecialchars($departemen['departemen']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan" class="form-label">Jabatan</label>
                        <select class="form-control" id="jabatan" name="idjab" required>
                            <option value="">Pilih Jabatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="skerja" class="form-label">Status Kerja</label>
                        <select class="form-control" id="skerja" name="skerja" required>
                            <option value="">Pilih Status Kerja</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="gaji" class="form-label">Gaji</label>
                        <input type="text" class="form-control" id="gaji" name="gaji" required placeholder="Masukkan Gaji">
                    </div>
                    <div class="mb-3">
                        <label for="tglkerja" class="form-label">Tanggal Kerja</label>
                        <input type="date" class="form-control" id="tglkerja" name="tglkerja" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- AJAX Untuk Pilih Jabatan -->
<script>
$(document).ready(function() {
    $('#departemen').change(function() {
        var iddep = $(this).val();
        if (iddep !== "") {
            $.ajax({
                url: 'get_jabatan.php',
                method: 'POST',
                data: {iddep: iddep},
                beforeSend: function() {
                    $('#jabatan').html('<option>Loading...</option>');
                },
                success: function(response) {
                    $('#jabatan').html(response);
                },
                error: function() {
                    $('#jabatan').html('<option>Error loading jabatan</option>');
                }
            });
        } else {
            $('#jabatan').html('<option value="">Pilih Jabatan</option>');
        }
    });
});
</script>

<!-- Modal Edit Pegawai -->
<div class="modal fade" id="editpegawaiModal" tabindex="-1" aria-labelledby="editpegawaiModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editpegawaiModalLabel">Edit Pegawai</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_pegawai.php" method="post">
                    <div class="mb-3">
                        <label for="edit_idpeg" class="form-label">ID Pegawai</label>
                        <input type="text" class="form-control" id="edit_idpeg" name="idpeg" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="edit_foto" class="form-label">Foto Pegawai</label>
                        <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nama" class="form-label">Nama Pegawai</label>
                        <input type="text" class="form-control" id="edit_nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_telepon" class="form-label">No. Telp</label>
                        <input type="text" class="form-control" id="edit_telepon" name="telepon" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jkelamin" class="form-label">Jenis Kelamin</label>
                        <select class="form-control" id="edit_jkelamin" name="jkelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value=" Laki-Laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status</label>
                        <select class="form-control" id="edit_status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="Belum Menikah">Belum Menikah</option>
                            <option value="Menikah">Menikah</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jenjangpendidikan" class="form-label">Jenjang Pendidikan</label>
                        <select class="form-control" id="edit_jenjangpendidikan" name="jenjangpendidikan" required>
                            <option value="">Pilih Jenjang Pendidikan</option>
                            <option value="SMA/SMK Sederajat">SMA/SMK Sederajat</option>
                            <option value="D3">D3</option>
                            <option value="S1">S1</option>
                            <option value="S2">S2</option>
                            <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_departemen" class="form-label">Departemen</label>
                        <select class="form-control" id="edit_departemen" name="departemen" required>
                            <option value="">Pilih Departemen</option>
                            <?php
                            // Ambil data departemen dari database
                            $departemenResult = $conn->query("SELECT iddep, departemen FROM departemen");
                            while ($departemen = $departemenResult->fetch_assoc()) {
                                echo "<option value='" . $departemen['iddep'] . "'>" . htmlspecialchars($departemen['departemen']) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_jabatan" class="form-label">Jabatan</label>
                        <select class="form-control" id="edit_jabatan" name="jabatan" required>
                            <option value="">Pilih Jabatan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_skerja" class="form-label">Status Kerja</label>
                        <select class="form-control" id="edit_skerja" name="skerja" required>
                            <option value="">Pilih Status Kerja</option>
                            <option value="Tetap">Tetap</option>
                            <option value="Internship">Internship</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_gaji" class="form-label">Gaji</label>
                        <input type="text" class="form-control" id="edit_gaji" name="gaji" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- jQuery and AJAX Script for dynamic jabatan selection -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add event listener to all edit buttons
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function () {
                // Get data attributes from the button
                const idpeg = this.getAttribute('data-idpeg');
                const iddep = this.getAttribute('data-iddep');
                const idjab = this.getAttribute('data-idjab');
                const nama = this.getAttribute('data-nama');
                const alamat = this.getAttribute('data-alamat');
                const telepon = this.getAttribute('data-telepon');
                const email = this.getAttribute('data-email');
                const gaji = this.getAttribute('data-gaji');
                const status = this.getAttribute('data-status');
                const jkelamin = this.getAttribute('data-jkelamin'); // Assuming you have a data attribute for this
                const skerja = this.getAttribute('data-skerja'); // Assuming you have a data attribute for this
                const cuti = this.getAttribute('data-cuti'); // Assuming you have a data attribute for this
                const jenjangpendidikan = this.getAttribute('data-jenjangpendidikan'); // Assuming you have a data attribute for this
                const tglkerja = this.getAttribute('data-tglkerja'); // Assuming you have a data attribute for this

                // Set values in the modal
                document.getElementById('edit_idpeg').value = idpeg;
                document.getElementById('edit_iddep').value = iddep;
                document.getElementById('edit_idjab').value = idjab;
                document.getElementById('edit_nama').value = nama;
                document.getElementById('edit_alamat').value = alamat;
                document.getElementById('edit_telepon').value = telepon;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_gaji').value = gaji;
                document.getElementById('edit_status').value = status;
                document.getElementById('edit_jkelamin').value = jkelamin;
                document.getElementById('edit_skerja').value = skerja;
                document.getElementById('edit_cuti').value = cuti;
                document.getElementById('edit_jenjangpendidikan').value = jenjangpendidikan;
                document.getElementById('edit_tglkerja').value = tglkerja;
            });
        });
    });
$(document).ready(function() {
    // Dynamic Jabatan Selection for both Add and Edit Forms
    function loadJabatan(departemenSelector, jabatanSelector) {
        var departemenID = $(departemenSelector).val();
        if (departemenID) {
            $.ajax({
                type: 'POST',
                url: 'get_jabatan.php',
                data: { iddep: departemenID },
                success: function(html) {
                    $(jabatanSelector).html(html);
                },
                error: function(xhr) {
                    Swal.fire('Error!', 'Failed to load jabatan.', 'error');
                }
            });
        } else {
            $(jabatanSelector).html('<option value="">Pilih Jabatan</option>');
        }
    }

    // Trigger jabatan load for both Add and Edit
    $('#departemen, #edit_departemen').on('change', function() {
        var jabatanSelector = $(this).attr('id') === 'departemen' ? '#jabatan' : '#edit_jabatan';
        loadJabatan(this, jabatanSelector);
    });

    // Fetch and fill Edit form
    $(document).on('click', '.edit-button', function() {
        var idpeg = $(this).data('idpeg');
        console.log('Fetching data for ID:', idpeg); // Debugging

        $.ajax({
            url: 'get_pegawai.php',
            type: 'POST',
            data: { idpeg: idpeg },
            success: function(data) {
                // Asumsikan 'data' adalah format HTML langsung (bukan JSON)
                $('#edit_pegawai_data').html(data); // Mengisi data ke dalam modal edit
                
                // Setelah data pegawai diisi, tampilkan modal edit
                $('#editpegawaiModal').modal('show');
            },
            error: function(xhr) {
                console.error('Error fetching data:', xhr); // Debugging
                Swal.fire('Error!', 'Failed to load pegawai data.', 'error');
            }
        });
    });

    // Adjust DataTables' scrolling to avoid overlapping with the footer
    function adjustTableHeight() {
        var footerHeight = $('footer').outerHeight();
        var tableHeight = 'calc(100vh - 290px - ' + footerHeight + 'px)';

        $('#departemenTable').DataTable().destroy();
        $('#departemenTable').DataTable({
            "pagingType": "simple_numbers",
            "scrollY": tableHeight,
            "scrollCollapse": true,
            "paging": true
        });
    }

    // Call the function to adjust table height initially
    adjustTableHeight();

    // Adjust table height on window resize
    $(window).resize(function() {
        adjustTableHeight();
    });

    // Show SweetAlert message if session has a message
    <?php if ($message): ?>
        Swal.fire({
            title: '<?php echo $message['type'] === 'success' ? 'Success!' : 'Error!'; ?>',
            text: '<?php echo $message['text']; ?>',
            icon: '<?php echo $message['type'] === 'success' ? 'success' : 'error'; ?>'
        });
    <?php endif; ?>

    // Handle delete button click
    $(document).on('click', '.delete-btn', function() {
        var idpeg = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'Apa benar data tersebut dihapus',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'delete_pegawai.php',
                    type: 'POST',
                    data: { idpeg: idpeg },
                    success: function(response) {
                        console.log('Delete response:', response); // Debugging
                        if (response.includes('Success')) {
                            Swal.fire('Deleted!', 'Data berhasil dihapus.', 'success').then(function() {
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error!', response, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred: ' + error, 'error');
                    }
                });
            }
        });
    });

    //Print ke PDF        
    $('#printButton').click(function() {
        window.location.href = 'print_pegawai.php';
    });
});
</script>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>