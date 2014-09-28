<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/gambar_kegiatan.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$gambar_kegiatan = new gambar_kegiatan();
$thispage = "tampil_gambar_kegiatan";

if(isset($_POST['btnhapus'])){
    $gambar_kegiatan->id = $_POST['id2artikel'];
    $sel_gambar = $gambar_kegiatan->get_subject_by_id();
    $gambar_kegiatan->gambar = $sel_gambar['gambar'];
    if($gambar_kegiatan->delete()){
        $session->pesan("Berhasil menghapus gambar kegiatan");
        redirect_to("tampil_gambar_kegiatan.php");
    }else
        $message = "Gagal menghapus gambar kegiatan : " . mysql_error();
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Gambar Kegiatan</title>
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
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Gambar Kegiatan</h1>
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
                <div class="panel panel-default">
                    <div class="panel-heading tooltip-demo">
                    <form class="form-inline" role="form" action="tampil_artikel.php">
                        <div class="form-group">
                            <a type="button" data-toggle="tooltip" data-placement="top" 
                                title="Tekan untuk menambah artikel baru" 
                                class="btn btn-default" href="tambah_gambar_kegiatan.php"><span class="fa fa-plus"></span> Tambah Gambar</a>
                        </div>
                    </form>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                    <?php

                    $sql_tampil = "SELECT * FROM " . gambar_kegiatan::$nama_tabel;

                    $result = $database->query($sql_tampil);
                    while($row = $database->fetch_array($result)){
                        $output ="<div class=\"col-lg-4\">";
                            $output .="<div class=\" panel panel-default \">";
                                $output .="<div class=\"panel-heading\">";
                                    $output .="<a href=\"ubah_gambar_kegiatan.php?gambar={$row['id']}\" 
                                    			  title=\"Tekan untuk mengubah gambar kegiatan ini\"
                                                ><b>{$row['name']}</b></a>";
                                $output .="</div>";
                                $output .="<div class=\"panel-body\">";
                                    $gambar = $row['gambar'];
                                    $gambar = str_replace(' ', '%20', $gambar);
                                    $output .="<a class=\"\" href=\"ubah_gambar_kegiatan.php?gambar={$row['id']}\">";
                                    if(!empty($gambar) && is_file("../images_kegiatan/{$gambar}")){
                                        $output .="<img class=\"img-responsive\" src=\"../images_kegiatan/{$gambar}\" 
                                        				title=\"Tekan untuk mengubah gambar kegiatan ini\">";
                                    }else{
                                        $output .="<img class=\"img-responsive\" src=\"../images/no_image.jpg\" 
                                        				title=\"Tekan untuk mengubah gambar kegiatan ini\">";        
                                    }
                                    $output .="</a>";
                                        if(!empty($row['id']))
                                        $output  .="<button class=\"btn btn-default modal2 pull-right\"
                                                        name=\"{$row['id']}\" style=\"margin-top : 5px;\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus gambar kegiatan ini\" ><span 
                                                        class=\"glyphicon glyphicon-trash\"></span></button>";
                                $output .="</div>";
                            $output .="</div>";                           
                        $output .="</div>";

                        echo $output;
                    }
                    ?>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        </div>
        <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- modal -->
    <!-- Hapus -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_gambar_kegiatan.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Gambar Kegiatan</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus gambar kegiatan ini?</strong>
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
    <!-- /.modal -->


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
