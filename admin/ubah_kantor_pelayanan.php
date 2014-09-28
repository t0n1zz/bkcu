<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/kantor_pelayanan.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$kantor_pelayanan = new kantor_pelayanan();
$thispage = "pelayanan";

if(isset($_POST['simpan']) || isset($_POST['simpanbaru'])){
    $errors = array();
    $field_array = array('name','alamat');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
    	$kantor_pelayanan->id = $_POST['id'];
    	$kantor_pelayanan->name = $_POST['name'];
      $name = $_POST['name'];
    	$kantor_pelayanan->alamat = $_POST['alamat'];
    	$kantor_pelayanan->alamat2 = $_POST['alamat2'];
    	$kantor_pelayanan->alamat3 = $_POST['alamat3'];
    	$kantor_pelayanan->pos = $_POST['pos'];
    	$kantor_pelayanan->telp = $_POST['telp'];
    	$kantor_pelayanan->fax = $_POST['fax'];
    	$kantor_pelayanan->email = $_POST['email'];

        if($kantor_pelayanan->save()){
            if(isset($_POST['simpan'])){
                $session->pesan("Kantor Pelayanan {$name} berhasil di ubah");
                redirect_to("tampil_kantor_pelayanan.php");
            }
        }else
             $message = "Gagal mengubah Kantor Pelayanan: " . mysql_error();
    }else
        $message = "Gagal mengubah Kantor Pelayanan" . mysql_error();
}


if(isset($_POST['batal'])){
    redirect_to("tampil_kantor_pelayanan.php");
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Ubah Kantor Pelayanan</title>
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
        <?php
            if(isset($_GET['kantor'])){
                $kantor_pelayanan->id = $_GET['kantor'];
                $sel_kantor = $kantor_pelayanan->get_subject_by_id();
            }else{
                redirect_to("wrong.php");
            }
        ?>
		<!-- Content -->
        <div id="page-wrapper">
       	<!-- header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><span class="fa fa-pencil"></span> Ubah Kantor Pelayanan</h1>
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
                <form role="form" method="post" action="ubah_kantor_pelayanan.php?kantor=<?php echo $sel_kantor['id']; ?>">
                <div class="panel panel-default">
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan data kantor pelayanan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal menambah kantor pelayanan dan kembali ke halaman Kelola Kantor Pelayanan" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    	<input type="text" name="id" value="<?php echo $sel_kantor['id']; ?>" hidden />
                    	<div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Nama</div>
                              <input class="form-control" type="text" name="name" 
                                     placeholder="Masukkan nama kantor pelayanan" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['name']))
                                     	echo $sel_kantor['name'];
                                     ?>">
                            </div>
                        </div>
                        <hr />
                        </div>
                        <div class="col-lg-12">
						<div class="form-group">
                          <label>Alamat</label>
                          <textarea class="form-control" name="alamat" placeholder="Masukkan alamat" style=" height:100px"
                          ><?php
                                 if(!empty($sel_kantor['alamat']))
                                 	echo $sel_kantor['alamat'];
                           ?>
                           </textarea>
                        </div>
                        </div>
                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Kota/Kecamatan/Kelurahan</div>
                              <input class="form-control" type="text" name="alamat2" 
                                     placeholder="Masukkan kota/kecamatan/kelurahan kantor pelayanan"
                                     value="<?php
                                     if(!empty($sel_kantor['alamat2']))
                                     	echo $sel_kantor['alamat2'];
                                     ?>">
                            </div>
                        </div>
                        <hr />
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Alamat Kode Pos</div>
                              <input class="form-control" type="text" name="alamat3" 
                                     placeholder="Masukkan alamat kode pos" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['alamat3']))
                                     	echo $sel_kantor['alamat3'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Kode Pos</div>
                              <input class="form-control" type="text" name="pos" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan kode pos" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['pos']))
                                     	echo $sel_kantor['pos'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">No. Telepon</div>
                              <input class="form-control" type="text" name="telp" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan nomor telepon" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['telp']))
                                     	echo $sel_kantor['telp'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-6">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">No. Fax</div>
                              <input class="form-control" type="text" name="fax" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan nomor fax" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['fax']))
                                     	echo $sel_kantor['fax'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <div class="col-lg-12">
                        <hr />
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Email</div>
                              <input class="form-control" type="text" name="email" 
                                     placeholder="Masukkan alamat email" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_kantor['email']))
                                     	echo $sel_kantor['email'];
                                     ?>">
                            </div>
                        </div>
                        </div>
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

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <script src="../js/myscript.js"></script>

</body>

</html>
