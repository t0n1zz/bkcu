<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/artikel.php");
require_once("../includes/gambar_kegiatan.php");
require_once("../includes/kegiatan.php");
require_once("../includes/admin.php");
require_once("../includes/cuprimer.php");
require_once("../includes/saran.php");


if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$artikel = new artikel();
$kategori = new kategori_artikel();
$gambar_kegiatan = new gambar_kegiatan();
$kegiatan = new kegiatan();
$admin = new admin();
$cuprimer = new cuprimer();
$saran = new saran();
$thispage = "index";

$admin->id = $_SESSION['bkcu_user'];
$sel_admin = $admin->get_subject_by_id();

if(isset($_POST['btnhapus'])){
    $saran->id = $_POST['id2artikel'];
    if($saran->delete()){
        $session->pesan("Berhasil menghapus saran");
        redirect_to("index.php");
    }else
        $message = "Gagal menghapus saran : " . mysql_error();
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Dashboard</title>
    <link rel="shortcut icon" href="../images/logo.png"> 
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

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
        <nav class="navbar navbar-default  navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php include_once("component/header.php"); ?>
			<?php include_once("component/sidebar.php"); ?>
        </nav>
       
		<!-- Content -->
        <div id="page-wrapper">
           	<!-- header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
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
                </div>           
            </div>
            <!-- /header -->            
            <!-- 1st row -->
            <div class="row">
            	<!-- 1st huge button -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-book fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $total_artikel = $artikel->count_all();
                                ?>
                                    <div class="huge"><?php echo $total_artikel; ?></div>
                                    <div>Artikel</div>
                                </div>
                            </div>
                        </div>
                        <a href="tampil_artikel.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detil</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- /1st huge button -->
                <!-- 2nd huge button -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-image fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $total_gambar = $gambar_kegiatan->count_all();
                                ?>
                                    <div class="huge"><?php echo $total_gambar; ?></div>
                                    <div>Gambar Kegiatan</div>
                                </div>
                            </div>
                        </div>
                        <a href="tampil_gambar_kegiatan.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detil</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- /2nd huge button -->
                <!-- 3rd huge button -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-calendar fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $total_kegiatan = $kegiatan->count_all();
                                ?>
                                    <div class="huge"><?php echo $total_kegiatan; ?></div>
                                    <div>Agenda</div>
                                </div>
                            </div>
                        </div>
                        <a href="tampil_kegiatan.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detil</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- /3rd huge button -->
                <!-- 4th huge button -->
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-building fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                <?php
                                    $total_cuprimer = $cuprimer->count_all();
                                ?>
                                    <div class="huge"><?php echo $total_cuprimer; ?></div>
                                    <div>CU Primer</div>
                                </div>
                            </div>
                        </div>
                        <a href="tampil_cuprimer.php">
                            <div class="panel-footer">
                                <span class="pull-left">Detil</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <!-- 4th huge button -->
            </div>
            <!-- /1st row -->
            <!-- 2nd row -->
            <div class="row">
            <div class="col-lg-12">
                <hr />
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-eye fa-fw"></i> Admin online
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                        <?php
                            $sql_aktivitas_admin = "SELECT ad.id,ad.name,ad.cu,ad.online,cu.id as cuid,cu.name as cuname"; 
                            $sql_aktivitas_admin .=" FROM " .admin::$nama_tabel. " ad";
                            $sql_aktivitas_admin .=" LEFT JOIN " .cuprimer::$nama_tabel. " cu";
                            $sql_aktivitas_admin .=" ON ad.cu = cu.id";
                            $sql_aktivitas_admin .=" ORDER BY online desc";
                            $sql_aktivitas_admin .=" LIMIT 5";

                            $database->query($sql_aktivitas_admin);
                            $database->execute();
                            $nResults = $database->rowCount();
                            if($nResults > 0){
                                while($row = $database->fetch()){ 
                                    $output ="<div class=\"list-group-item\">";
                                        if($row['cuid'] == 0)
                                            $namacu = "BKCU";
                                        else
                                            $namacu = $row['cuname'];

                                        $output .=$row['name']. " dari <i>" .$namacu. "</i>";
                                        $phpdate = strtotime( $row['online'] );
                                        $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                        $output .="<span class=\"pull-right text-muted small\"><em>" .$mysqldate. "</em>";
                                        $output .="</span>";
                                    $output .="</div>";

                                    echo $output;
                                }
                            }else{
                                $output ="<div class=\"list-group-item\">";
                                    $output .="Belum terdapat aktivitas admin...";
                                $output .="</div>"; 

                                echo $output;
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-eye-slash fa-fw"></i> Admin offline
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="list-group">
                        <?php
                            $sql_aktivitas_admin = "SELECT ad.id,ad.name,ad.cu,ad.offline,cu.id as cuid,cu.name as cuname"; 
                            $sql_aktivitas_admin .=" FROM " .admin::$nama_tabel. " ad";
                            $sql_aktivitas_admin .=" LEFT JOIN " .cuprimer::$nama_tabel. " cu";
                            $sql_aktivitas_admin .=" ON ad.cu = cu.id";
                            $sql_aktivitas_admin .=" ORDER BY offline desc";
                            $sql_aktivitas_admin .=" LIMIT 5";

                            $database->query($sql_aktivitas_admin);
                            $database->execute();

                            $nResults = $database->rowCount();
                            if($nResults > 0){
                                while($row = $database->fetch()){ 
                                    $output ="<div class=\"list-group-item\">";
                                        if($row['cuid'] == 0)
                                            $namacu = "BKCU";
                                        else
                                            $namacu = $row['cuname'];

                                        $output .=$row['name']. " dari <i>" .$namacu. "</i>";
                                        $phpdate2 = strtotime( $row['offline'] );
                                        $mysqldate2 = date( 'd-m-Y H:i:s', $phpdate2 );
                                        $output .="<span class=\"pull-right text-muted small\"><em>" .$mysqldate2. "</em>";
                                        $output .="</span>";
                                    $output .="</div>";

                                    echo $output;
                                }
                            }else{
                                $output ="<div class=\"list-group-item\">";
                                    $output .="Belum terdapat aktivitas admin...";
                                $output .="</div>"; 

                                echo $output;
                            }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
            <?php

            $tabel = "stat_pengunjung";
            $tanggal = date("Ymd"); // Mendapatkan tanggal sekarang
            $waktu   = time();

            $database->query("SELECT * FROM {$tabel} WHERE tanggal=:tanggal GROUP BY ip");
            $database->bind(':tanggal',$tanggal);
            $database->execute();
            $pengunjung       = $database->rowCount();

            $database->query("SELECT COUNT(hits) FROM {$tabel}");
            $database->execute();
            $totalpengunjung  = $database->fetchColumn();

            $bataswaktu       = time() - 300;

            $database->query("SELECT * FROM {$tabel} WHERE online > :bataswaktu");
            $database->bind(':bataswaktu',$bataswaktu);
            $database->execute();
            $pengunjungonline = $database->rowCount();

            $tanggal_hariini  = date('d-m-Y');

            ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="glyphicon glyphicon-stats"></i> Statistik Website
                    </div>
                    <h3 style="text-align: center;" ><b>Pengunjung Hari Ini</b></h3>
                    <h4 style="text-align: center;" ><?php echo $tanggal_hariini; ?></h4>
                    <h3 style="text-align: center;" ><b><?php echo $pengunjung; ?> </b>orang</h3>
                    <hr />
                    <dl class="dl-horizontal">
                      <dt><b style="font-size: 13px" >Total Pengunjung : </b></dt>
                      <dd><b style="font-size: 13px" ><?php echo $totalpengunjung; ?> orang</b></dd>
                      <dt><b style="font-size: 13px" >Pengunjung Online : </b></dt>
                      <dd><b style="font-size: 13px" ><?php echo $pengunjungonline; ?> orang</b></dd>
                    </dl>
                </div>
            </div>

            <div class="col-lg-8">
            <div class="chat-panel panel panel-default" >
                <div class="panel-heading">
                   <span class="fa fa-comments"></span> Saran
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                <?php

                $sql_pengumuman = "SELECT * FROM " .saran::$nama_tabel; 
                $database->query($sql_pengumuman);
                $database->execute();
                $nResults = $database->rowCount();
                if($nResults > 0){
                    while($row = $database->fetch()){ 
                        $output ="<ul class=\"chat\">";
                            $output .="<li class=\"clearfix\">";
                                $output.="<div class=\"chat-body clearfix\">";
                                    $output .="<div class=\"header\">";
                                        $phpdate = strtotime( $row['tanggal'] );
                                        $mysqldate = date( 'd-m-Y H:i:s', $phpdate );
                                        $output.="<strong class=\"primary-font\"><i class=\"fa fa-clock-o fa-fw\"></i> {$mysqldate} </strong> ";
                                        $output .="<button class=\"btn btn-default modal2 pull-right\"
                                                        name=\"{$row['id']}\" 
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus artikel ini\" ><span 
                                                        class=\"glyphicon glyphicon-trash\"></span></button>";
                                    $output .="</div>";
                                    $output .="<p>{$row['content']}</p>";
                                $output .="</div>";
                            $output .="</li>";
                        $output .="</ul>";

                        echo $output;
                    }
                }else{
                    $output ="<div class=\"panel panel-default\">";
                        $output .="<div class=\"panel-heading\">";
                            $output .="<b class=\"pannel-title\" style=\"color:#6F6D5B;\">";
                            $output .="Belum terdapat saran...";
                            $output .="</b>";
                        $output .="</div>";

                    $output .="</div>"; 

                    echo $output;
                }
                ?>
                </div>
                <!-- /.panel-body -->
            </div>
            </div>

            </div>
            <!-- /2nd row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Hapus -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="index.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Saran</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus saran ini?</strong>
              <input type="text" name="id2artikel" value="" id="modal2id" hidden>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger" name="btnhapus"
                    id="modalbutton">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Batal</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
       </form>
    </div>
    <!-- /Hapus -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <script src="../js/myscript.js"></script>

</body>

</html>
