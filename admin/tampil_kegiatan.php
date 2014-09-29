<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/admin.php");
require_once("../includes/kegiatan.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$admin = new admin();
$kegiatan = new kegiatan();
$thispage = "tampil_kegiatan";

if(isset($_POST['btnhapus'])){
    $kegiatan->id = $_POST['id2artikel'];

    try{
        if($kegiatan->delete()){
            $session->pesan("Berhasil menghapus informasi kegiatan");
            redirect_to("tampil_kegiatan.php");
        }else
            $message = "Gagal menghapus informasi kegiatan";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal menghapus informasi kegiatan";
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Kegiatan</title>
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
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Kegiatan</h1>
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
                    <form class="form-inline" role="form" action="tampil_kegiatan.php">
                        <div class="form-group">
                            <a type="button" data-toggle="tooltip" data-placement="top" 
                                title="Tekan untuk menambah artikel baru" 
                                class="btn btn-default" href="tambah_kegiatan.php"><span class="fa fa-plus"></span> Tambah Kegiatan</a>
                        </div>
                    </form>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body tooltip-demo">
                    <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Kegiatan</th>
                                <th>Wilayah</th>
                                <th>Tempat</th>
                                <th>Sasaran</th>
                                <th>Fasilitator</th>
                                <th>Penulis</th>
                                <th>Tanggal Dimulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                            $sql_tampil = "SELECT k.id,k.name,k.wilayah,k.tempat,k.sasaran,k.fasilitator,k.penulis,k.tanggal,k.tanggal2,";
                            $sql_tampil .="ad.id as adid,ad.name as adname";
                            $sql_tampil .=" FROM " .kegiatan::$nama_tabel. " k";
                            $sql_tampil .=" LEFT JOIN " .admin::$nama_tabel. " ad";
                            $sql_tampil .=" ON k.penulis = ad.id";

                            $database->query($sql_tampil);
                            $database->execute();
                            while($row = $database->fetch()){
                               $output = "<tr>";
                                    if(!empty($row['id']))

                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >{$row['id']}</a></td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['name'])){
                                        $y = "";
                                        $x = $row['name'];
                                        if(strlen($x)<=40)
                                            $y = $x;
                                        else
                                            $y=substr($x,0,40) . '...';

                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"{$row['name']}\" 
                                                         href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                    > {$y} </td>";
                                    }else
                                        $output .="<td>-</td>";

                                    if($row['wilayah'] == 1)
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >Barat</a></td>";
                                    else if($row['wilayah'] == 2)
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >Tengah</a></td>";
                                    else if($row['wilayah'] == 3)
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >Timur</a></td>";
                                    else
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >-</a></td>";

                                    if(!empty($row['tempat']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >{$row['tempat']}</a></td>";
                                    else
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >-</a></td>";

                                    if(!empty($row['sasaran']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >{$row['sasaran']}</a></td>";
                                    else
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >-</a></td>";

                                    if(!empty($row['fasilitator']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >{$row['fasilitator']}</a></td>";
                                    else
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi kegiatan ini\" 
                                                        href=\"ubah_kegiatan.php?kegiatan={$row['id']}\"
                                                        >-</a></td>";

                                    if(!empty($row['penulis']))        
                                       $output .="<td>{$row['adname']}</td>";
                                    else
                                       $output .="<td>-</td>";

                                    if(!empty($row['tanggal']))
                                        $output .="<td>{$row['tanggal']}</td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['tanggal2']))
                                        $output .="<td>{$row['tanggal2']}</td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['id']))
                                        $output  .="<td><button class=\"btn btn-default modal2\"
                                                        name=\"{$row['id']}\" 
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus layanan ini\" ><span 
                                                        class=\"glyphicon glyphicon-trash\"></span></button></td>";
                                    else
                                        $output .="<td>-</td>";

                                $output .="</tr>";

                               echo $output;
                            }
                        ?>
                        </tr>
                        </tbody>
                    </table>
                    </div>
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
    <!-- foto -->
    <div class="modal fade" id="modalphotoshow">
        <div class="modal-body">
          <img style="cursor: pointer; cursor: hand;" src="" id="modalimage"/>
        </div>
    </div>
    <!-- /foto -->
    <!-- Hapus -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_kegiatan.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Kegiatan</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus kegiatan ini?</strong>
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
