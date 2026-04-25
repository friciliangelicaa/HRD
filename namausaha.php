<?php
session_start();
require 'config.php';
include('head.php'); 

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

// Ambil data dari tabel departemen
$result = $conn->query("SELECT * FROM namausaha");
$usaha = $result->fetch_assoc();

// Simpan pesan ke variabel dan hapus dari session
$message = null;
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identitas Usaha</title>
    <style>
        .identitas-usaha {
            width: 80%;
            margin: 0;
            background-color: #f7f7f7;
            padding: 1rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

    </style>
</head>
<body>
    <?php
    // Isi data identitas usaha kamu dalam HTML
    echo '
    <div class="identitas-usaha">
    </div>';
    ?>
</body>
</html>

<header>
        <h4><?php echo htmlspecialchars($usaha["nama"]); ?></h4>
        <p><?php echo htmlspecialchars($usaha["alamat"]); ?></p>
    </header>
 <?php include 'sidebar.php'; ?>

 //Identitas Usaha
 <div class="content" id="content">
 <button type="button" class="btn btn-primary mb-3 mr-2" data-bs-toggle="modal" data-bs-target="#adddepartemenModal"><i class='fas fa-plus'></i> Edit </button>
 <div class="card col-md-11">
                <div class="card-title card-header">
                    <b>Identitas Usaha</b>
                </div>
                <div class="table table-bordered">
                    <table class="col-md-11">
                        <tr>
                            <th width="20%" >Nama</th>
                            <td width="80%"> <?php echo $usaha["nama"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Alamat</th>
                            <td width="80%"> <?php echo $usaha["alamat"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">No. Telepon</th>
                            <td width="80%"> <?php echo $usaha["notelepon"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Fax</th>
                            <td width="80%"> <?php echo $usaha["fax"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Email</th>
                            <td width="80%"> <?php echo $usaha["email"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">NPWP</th>
                            <td width="80%"> <?php echo $usaha["npwp"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Bank</th>
                            <td width="80%"> <?php echo $usaha["bank"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">No. Account</th>
                            <td width="80%"> <?php echo $usaha["noaccount"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Atas Nama</th>
                            <td width="80%"> <?php echo $usaha["atasnama"]; ?> </td>
                        </tr>
                        <tr>
                            <th width="20%">Pimpinan</th>
                            <td width="80%"> <?php echo $usaha["pimpinan"]; ?> </td>
                        </tr>
                    </table>
                </div>
            </div>
    <?php require 'footer.php'; ?>
 </div>

 //Modal Edit Identitas Usaha
 <div class="modal fade" id="adddepartemenModal" tabindex="-1" aria-labelledby="adddepartemenModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="adddepartemenModalLabel">Edit Usaha</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_usaha.php" method="post">
                <div class="form-group">
        <label>Nama Perusahaan :</label> 
            <input type="txt" name="nama" value="<?php echo $usaha["nama"];?>" class="form-control" readonly/>
    </div>

    <div class="form-group">
        <label>Alamat :</label> 
            <input type="txt" name="alamat" value="<?php echo $usaha["alamat"];?>" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>Nomor Telepon :</label> 
            <input type="txt" name="notelepon" value="<?php echo $usaha["notelepon"];?>" class="form-control" required/>
    </div>

    <div class="form-group">
        <label>FAX :</label> 
            <input type="txt" name="fax" value="<?php echo $usaha["fax"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>E-mail :</label> 
            <input type="txt" name="email" value="<?php echo $usaha["email"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>NPWP :</label> 
            <input type="txt" name="npwp" value="<?php echo $usaha["npwp"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>Bank :</label> 
            <input type="txt" name="bank" value="<?php echo $usaha["bank"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>Nomor Account :</label> 
            <input type="txt" name="noaccount" value="<?php echo $usaha["noaccount"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>Atas Nama :</label> 
            <input type="txt" name="atasnama" value="<?php echo $usaha["atasnama"];?>" class="form-control" required/>
    </div>
    <div class="form-group">
        <label>Pimpinan :</label> 
            <input type="txt" name="pimpinan" value="<?php echo $usaha["pimpinan"];?>" class="form-control" required/>
    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>



</body>
</html>