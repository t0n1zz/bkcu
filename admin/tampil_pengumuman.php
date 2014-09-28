<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/artikel.php");
require_once("../includes/pengumuman.php");
require_once("../includes/admin.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$pengumuman = new pengumuman();
$admin = new admin();
$thispage = "tampil_pengumuman";

if(isset($_POST['btntambah'])){
    $errors = array();
    $field_array = array('name');
    $errors = array_merge($errors, cek_field($field_array,$_POST));
    if(empty($errors)){
        date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

        $pengumuman->name = $_POST['name'];
        $pengumuman->penulis = $_SESSION['user_id'];
        $pengumuman->tanggal = $waktu;
        if($pengumuman->save()){
            $session->pesan("Berhasil menambah pengumuman baru");
            redirect_to("tampil_pengumuman.php");
        }else{
            $message = "Gagal menambah pengumuman : " . mysql_error();
        }
    }else
        $message = "Gagal menambah pengumuman : " . mysql_error();
}

if(isset($_POST['btnubah'])){
    $errors = array();
    $field_array = array('name');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
        date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);

        $pengumuman->id = $_POST['idkategori'];
        $sel_pengumuman = $pengumuman->get_subject_by_id();
        $pengumuman->name = $_POST['kategori'];
        $pengumuman->penulis = $sel_pengumuman['penulis'];
        $pengumuman->tanggal = $waktu;
        if($pengumuman->save()){
            $session->pesan("Berhasil mengubah pengumuman");
            redirect_to("tampil_kategori_artikel.php");
        }else{
            $message = "Gagal mengubah pengumuman : " . mysql_error();
        }
    }else
        $message = "Gagal mengubah pengumuman : " . mysql_error();
}

if(isset($_POST['btnhapus'])){
    $id2kategori = $_POST['id2kategori'];
    $pengumuman->id = $id2kategori;
    if($pengumuman->delete()){
        $session->pesan("Berhasil Menghapus pengumuman");
        redirect_to("tampil_pengumuman.php");
    }else
        $message = "Gagal menghapus pengumuman : " . mysql_error();
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Pengumuman</title>
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
        <nav class="navbar navbar-default  navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php include_once("component/header.php"); ?>
			<?php include_once("component/sidebar.php"); ?>
        </nav>
		<!-- Content -->
        <div id="page-wrapper">
       	<!-- header -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Pengumuman</h1>
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
                    <form class="form-inline" role="form">
                        <div class="form-group">
                            <button type="button" data-toggle="tooltip" data-placement="top" 
                                    title="Tekan untuk menambah kategori artikel" 
                                    class="btn btn-default modal2"><span class="fa fa-plus"></span> Tambah Pengumuman</button>
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
                                <th>Pengumuman </th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th style="width: 5em  ">Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php

                            $sql_tampil = "SELECT * FROM " .pengumuman::$nama_tabel;
                            $result = $database->query($sql_tampil);
                            while($row = $database->fetch_array($result)){
                               $output = "<tr>";
                                    if(!empty($row['id']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah pengumuman ini\" 
                                                        href=\"#\"  class=\"modal1\" name=\"{$row['id']}\"
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
                                                          title=\"{$row['name']}\" class=\"modal1\" 
                                                          href=\"#\" name=\"{$row['id']}\"
                                                        > {$y} </td>";
                                    }else
                                        $output .="<td>-</td>";

                                    $admin->id = $row['penulis'];
                                    $sel_penulis =$admin->get_subject_by_id();
                                    if(!empty($sel_penulis))        
                                       $output .="<td>{$sel_penulis['name']}</td>";
                                    else
                                       $output .="<td>-</td>";

                                    if(!empty($row['tanggal']))
                                        $output .="<td>{$row['tanggal']}</td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['id']))
                                        $output .="<td><button data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus kategori artikel ini\" 
                                                        class=\"btn btn-default modal3\" name=\"{$row['id']}\"
                                                        ><span class=\"glyphicon glyphicon-trash\"></span></button></td>";
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
    <!-- tambah kategori -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_pengumuman.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Tambah Pengumuman</h4>
            </div>
            <div class="modal-body">
              <strong>Menambah Pengumuman</strong> 
              <br />
              <br />
                    <input type="text" class="form-control" name="name" placeholder="Silahkan masukkan pengumuman" maxlength="160" />
               <br />
               <br />
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="btntambah"
                    id="modalbutton">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Batal</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
       </form>
    </div>
    <!-- /tambah kategori -->
    <!-- ubah kategori -->
    <div class="modal fade" id="modal1show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_pengumuman.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Mengubah Pengumuman</h4>
            </div>
            <div class="modal-body">
              <strong>Mengubah pengumuman </strong> 
              <br />
              <br />
                    <input type="text" name="idkategori" value="" id="modal1id" hidden>
                    <input type="text" class="form-control" name="name" placeholder="Silahkan masukkan pengumuman" maxlength="160" />
               <br />
               <br />
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="btnubah"
                    id="modalbutton">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Batal</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
       </form>
    </div>
    <!-- /ubah kategori -->
    <!-- Hapus kategori-->
    <div class="modal fade" id="modal3show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_pengumuman.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Pengumuman</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus pengumuman?</strong>
              <blockquote>
                <p class="text-warning" style="font-size: 16px">
                    <span class="fa fa-warning"
                    ></span> Peringatan : pengumuman yang sudah dihapus tidak bisa di kembalikan lagi
                </p>
              </blockquote> 
              <input type="text" name="id2kategori" value="" id="modal3id" hidden>
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
    <!-- /Hapus kategori-->
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
