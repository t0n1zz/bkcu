<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/pelayanan.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$max_file_size = 1048576;

$pelayanan = new pelayanan();
$thispage = "tampil_pelayanan";

if(isset($_POST['btnhapus'])){
    $pelayanan->id = $_POST['id2artikel'];
    $sel_pelayanan = $pelayanan->get_subject_by_id();
    $pelayanan->gambar = $sel_pelayanan['gambar'];
    if($pelayanan->delete()){
        $session->pesan("Berhasil menghapus informasi layanan");
        redirect_to("tampil_pelayanan.php");
    }else
        $message = "Gagal menghapus informasi layanan : " . mysql_error();
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Pelayanan</title>
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
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Pelayanan</h1>
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
                                class="btn btn-default" href="tambah_pelayanan.php"><span class="fa fa-plus"></span> Tambah Layanan</a>
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
                                <th>Nama Pelayanan</th>
                                <th>Gambar</th>
                                <th>Deskripsi Pelayanan</th>
                                <th>Tanggal</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php


                            $sql_tampil = "SELECT * FROM " . pelayanan::$nama_tabel;

                            $result = $database->query($sql_tampil);
                            while($row = $database->fetch_array($result)){
                               $output = "<tr>";
                                    if(!empty($row['id']))

                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi layanan ini\" 
                                                        href=\"ubah_pelayanan.php?pelayanan={$row['id']}\"
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
                                                         href=\"ubah_pelayanan.php?pelayanan={$row['id']}\"
                                                    > {$y} </td>";
                                    }else
                                        $output .="<td>-</td>";

                                    $gambar = $row['gambar'];
                                    $gambar = str_replace(' ', '%20', $gambar);

                                    if(!empty($gambar) && is_file("../images/{$gambar}")){
                                        $output .="<td class=\"modalphotos\">
                                                    <img style=\"cursor: pointer; cursor: hand;\" src=\"../images/{$gambar}\" width=\"100\">
                                                   </td>";
                                    }else{
                                        $output .="<td><img src=\"../images/no_image.jpg\" width=\"100\"></td>";        
                                    }

                                    if(!empty($row['content'])){
                                        $content = html_entity_decode($row['content']);
                                        $z = "";
                                        $v = $content;
                                        if(strlen($v)<=40)
                                            $z = $v;
                                        else
                                            $z=substr($v,0,40) . '...';

                                        $output .="<td> {$z} </td>";
                                    }else
                                        $output .="<td>-</td>";

                                    if(!empty($row['tanggal']))
                                        $output .="<td>{$row['tanggal']}</td>";
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
          <img style="cursor: pointer; cursor: hand;" class="img-responsive" src="" id="modalimage"/>
        </div>
    </div>
    <!-- /foto -->
    <!-- Hapus -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_pelayanan.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Layanan</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus layanan ini?</strong>
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
