<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/admin.php");
require_once("../includes/cu.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$admin = new admin();
$cu = new cu();
$thispage = "tambah_admin";

if(isset($_POST['simpan']) || isset($_POST['simpanbaru'])){
    $errors = array();
    $field_array = array('username','password1','password2');

    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
        $password1 = trim($_POST['password1']);
        $password2 = trim($_POST['password2']);

        $admin->username = trim($_POST['username']);
        $admin->password = $password1;
        $admin->status = 1;

        try{
            if($password1 == $password2){
                $admin->cu = $_POST['cu'];
                if($admin->validasi_duplikat()){
                    if($admin->create()){
                        $session->pesan("Admin berhasil di tambah");
                        redirect_to("tampil_admin.php");
                    }else
                        $message = "Gagal menambah admin";
                }else
                    $message = "Gagal penambahan admin, username sudah dipakai";
            }else
                $message = "Gagal penambahan admin, password tidak cocok";
        }catch(PDOException $e){
            $message = "Gagal menambah admin";
            error_notice($e);
        } 
    }else
        $message = "Gagal menambah admin";
}


if(isset($_POST['batal'])){
    redirect_to("tampil_admin.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Puskopdit BKCU Kalimantan Admin Site -- Tambah Admin</title>
    <link rel="shortcut icon" href="../images/logo.png"> 
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../css/mystyle.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div id="wrapper">
        <!-- Navigation -->
        <nav class="navbar navbar-default  navbar-static-top " role="navigation" style="margin-bottom: 0">
            <?php include_once("component/header.php"); ?>
			<?php include_once("component/sidebar.php"); ?>
        </nav>
		<!-- Content -->
        <div id="page-wrapper">
       	<!-- header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><span class="fa fa-plus"></span> Tambah Admin</h1>
            </div>           
        </div>
        <!-- /header -->            

        <div class="row">
            <div class="col-lg-12">
            <!-- alert -->  
            <?php
                if(!empty($pesan)){
                    $output ="<div class=\"alert alert-success alert-dismissable\">";
                    $output .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" 
                            aria-hidden=\"true\">&times;</button>";
                    $output .=$pesan ."<br />";
                    $output .="</div>";
                    echo $output;
                }
            ?>
            <?php
                if(!empty($message)){
                    $output ="<div class=\"alert alert-warning alert-dismissible\" role=\"alert\">";
                    $output .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\"><span 
                                    aria-hidden=\"true\">&times;</span><span class=\"sr-only\">Close</span></button>";
                    $output .=$message ."<br />";
                    if(!empty($errors)){
                        $output .="Ada kesalahan pada bagian : <br />";
                        foreach($errors as $error){
                            $output .= " - " . $error . "<br />";
                        }
                    }
                    $output .="</div>";
                    echo $output;
                }
            ?>
            <!-- /alert --> 
                <form role="form" method="post" action="tambah_admin.php">
                <div class="panel panel-default">
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan data admin" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="simpanbaru" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan data admin dan memulai menambah admin baru" 
                                    class="btn btn-default"><span class="fa fa-save"></span> <span class="fa fa-plus"></span> Simpan dan buat baru</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal menambah admin dan kembali ke halaman Kelola Admin" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Username</div>
                              <input class="form-control" type="text" name="username" 
                                     placeholder="Masukkan username" maxlength="50">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Password</div>
                              <input class="form-control" type="password" name="password1" 
                                     placeholder="Masukkan password" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Tulis Ulang Password</div>
                              <input class="form-control" type="password" name="password2" 
                                     placeholder="Masukkan ulang password" maxlength="30">
                            </div>
                        </div>
                        <hr/>
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Asal Credit Union</div>
                              <select class="form-control" onchange="changeFunc(value);" name="cu">
                                  <option value="0">Pilih Asal Credit Union </option>
                                  <option value="0">BKCU </option>
                                  <?php
                                    $database->query("select * from ". cuprimer::$nama_tabel);
                                    $database->execute();
                                    while($row =$database->fetch()){
                                        $output = "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                        echo $output;
                                    }
                                  ?>
                              </select> 
                            </div>
                        </div>
                        <hr/>
                    <?php //include("component/hak_akses.php"); ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
                </form>
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->



    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>  
    <script src="../js/myscript.js"></script>

</body>

</html>
