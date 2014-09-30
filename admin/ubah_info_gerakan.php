<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/info_gerakan.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$info_gerakan = new info_gerakan();
$thispage = "info_gerakan";

if(isset($_POST['simpan'])){
  	$info_gerakan->id = $_POST['id'];
    $info_gerakan->tanggal = $_POST['tanggal'];
  	$info_gerakan->jumlah_anggota = $_POST['jumlah_anggota'];
  	$info_gerakan->jumlah_cu = $_POST['jumlah_cu'];
    $info_gerakan->jumlah_staff_cu = $_POST['jumlah_staff_cu'];
    $info_gerakan->piutang_beredar = $_POST['piutang_beredar'];
    $info_gerakan->piutang_lalai_1 = $_POST['piutang_lalai_1'];
    $info_gerakan->piutang_lalai_2 = $_POST['piutang_lalai_2'];
    $info_gerakan->piutang_bersih = $_POST['piutang_bersih'];
  	$info_gerakan->asset= $_POST['asset'];
  	$info_gerakan->shu = $_POST['shu'];

    try{
      if($info_gerakan->save()){
          if(isset($_POST['simpan'])){
              $session->pesan("Informasi Gerakan berhasil di ubah");
              redirect_to("ubah_info_gerakan.php");
          }
      }else
           $message = "Gagal mengubah Informasi Gerakan";
    }catch(PDOException $e){
        $message = "Gagal mengubah Informasi Gerakan";
        error_notice($e);
    } 
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Ubah Informasi Gerakan</title>
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
            $info_gerakan->id = 1;
            $sel_info_gerakan = $info_gerakan->get_subject_by_id();
        ?>
		<!-- Content -->
        <div id="page-wrapper">
       	<!-- header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><span class="fa fa-pencil"></span> Ubah Informasi Gerakan</h1>
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
                <form role="form" method="post" action="ubah_info_gerakan.php">
                <div class="panel panel-default">
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan data informasi gerakan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    	<input type="text" name="id" value="<?php echo $sel_info_gerakan['id']; ?>" hidden/>

                      <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Per Tanggal</div>
                              <input class="form-control" type="text" name="tanggal" 
                                     placeholder="Masukkan tanggal"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['tanggal']))
                                      echo $sel_info_gerakan['tanggal'];
                                     ?>">
                            </div>
                        </div>
                      </div>

                    	<div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Anggota</div>
                              <input class="form-control" type="text" name="jumlah_anggota" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah anggota"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['jumlah_anggota']))
                                     	echo $sel_info_gerakan['jumlah_anggota'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah CU Primer</div>
                              <input class="form-control" type="text" name="jumlah_cu" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah cu primer"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['jumlah_cu']))
                                     	echo $sel_info_gerakan['jumlah_cu'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Staff CU Primer</div>
                              <input class="form-control" type="text" name="jumlah_staff_cu" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah staff cu primer"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['jumlah_staff_cu']))
                                      echo $sel_info_gerakan['jumlah_staff_cu'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Piutang Beredar</div>
                              <input class="form-control" type="text" name="piutang_beredar" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah piutang beredar"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['piutang_beredar']))
                                      echo $sel_info_gerakan['piutang_beredar'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Piutang Lalai 1 s.d. 12 Bulan</div>
                              <input class="form-control" type="text" name="piutang_lalai_1" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah piutang lalai 1 s.d. 12 bulan"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['piutang_lalai_1']))
                                      echo $sel_info_gerakan['piutang_lalai_1'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Piutang Lalai > 12 Bulan</div>
                              <input class="form-control" type="text" name="piutang_lalai_2" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah piutang lalai > 12 bulan"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['piutang_lalai_2']))
                                      echo $sel_info_gerakan['piutang_lalai_2'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Jumlah Piutang Bersih</div>
                              <input class="form-control" type="text" name="piutang_bersih" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah piutang bersih"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['piutang_bersih']))
                                      echo $sel_info_gerakan['piutang_bersih'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Asset</div>
                              <input class="form-control" type="text" name="asset" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan jumlah asset"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['asset']))
                                     	echo $sel_info_gerakan['asset'];
                                     ?>">
                            </div>
                        </div>
                        </div>

                        <div class="col-lg-12">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">SHU</div>
                              <input class="form-control" type="text" name="shu" onKeyPress="return isNumberKey(event)"
                                     placeholder="Masukkan SHU" maxlength="30"
                                     value="<?php
                                     if(!empty($sel_info_gerakan['shu']))
                                     	echo $sel_info_gerakan['shu'];
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
