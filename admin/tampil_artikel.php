<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/artikel.php");
require_once("../includes/kategori_artikel.php");
require_once("../includes/admin.php");

if(!$session->is_logged_in()){
    $session->pesan("Anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$artikel = new artikel();
$kategori = new kategori_artikel();
$admin = new admin();
$thispage = "tampil_artikel";

if(isset($_POST['btnkategori'])){
    $artikel->id = $_POST['id3artikel'];
    $artikel->kategori = $_POST['kategori'];

    try{
        if($artikel->update_kategori()){
            $session->pesan("Berhasil mengubah kategori");
            redirect_to("tampil_artikel.php");
        }else
            $message = "Gagal mengubah kategori";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal mengubah kategori";
    }  
}

if(isset($_POST['btnstatus'])){
    $artikel->id = $_POST['idartikel'];
    $artikel->status = $_POST['status'];

    try{
        if($artikel->update_status()){
            $session->pesan("Berhasil mengubah status");
            redirect_to("tampil_artikel.php");
        }else
            $message = "Gagal mengubah status";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal mengubah status";
    }  
}

if(isset($_POST['btnhapus'])){
    $artikel->id = $_POST['id2artikel'];

    try{
        if($artikel->delete()){
            $session->pesan("Berhasil menghapus artikel");
            redirect_to("tampil_artikel.php");
        }else
            $message = "Gagal menghapus artikel";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal menghapus artikel";
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Artikel</title>
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
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Artikel</h1>
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
                                class="btn btn-default" href="tambah_artikel.php"><span class="fa fa-plus"></span> Tambah Artikel</a>
                            <?php
                                if(isset($_GET['kategori']))
                                   echo "<a type=\"button\" class=\"btn btn-default\" 
                                            data-toggle=\"tooltip\" data-placement=\"top\" 
                                            title=\"Tekan untuk menampilkan semua artikel\" 
                                            href=\"tampil_artikel.php\"><span class=\"fa fa-refresh\"> Tampilkan Semua Artikel</a>"
                            ?>
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
                                <th>Judul </th>
                                <th>Kategori</th>
                                <th>Penulis</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $y = "";

                            $sql_tampil = "SELECT ar.id,ar.judul,ar.content,ar.status,ar.kategori,ar.penulis,ar.tanggal,";
                            $sql_tampil .="k.id as kid,k.name as kname,ad.id as adid,ad.name as adname"; 
                            $sql_tampil .=" FROM " . artikel::$nama_tabel. " ar ";
                            $sql_tampil .=" LEFT JOIN " .kategori_artikel::$nama_tabel. " k ";
                            $sql_tampil .=" ON ar.kategori = k.id";
                            $sql_tampil .=" LEFT JOIN " .admin::$nama_tabel. " ad ";
                            $sql_tampil .=" ON ar.penulis = ad.id";

                            if(isset($_GET['kategori'])){
                                $kategori_id = $_GET['kategori'];
                                $sql_tampil .=" WHERE kategori='" .$kategori_id. "'";
                            }

                           $database->query($sql_tampil);
                           $database->execute();
                            while($row = $database->fetch()){
                               $output = "<tr>";
                                    if(!empty($row['id']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah artikel ini\" 
                                                        href=\"ubah_artikel.php?artikel={$row['id']}\"
                                                        >{$row['id']}</a></td>";
                                    else
                                        $output .="<td>-</td>";


                                    if(!empty($row['judul'])){
                                        $x = $row['judul'];
                                        if(strlen($x)<=40)
                                            $y = $x;
                                        else
                                            $y=substr($x,0,40) . '...';

                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"{$row['judul']}\" 
                                                         href=\"ubah_artikel.php?artikel={$row['id']}\"
                                                    > {$y} </td>";

                                    }else
                                        $output .="<td>-</td>";

                                    if(!empty($row['kid'])) 
                                       $output .="<td><a href=\"#\" class=\"modal3\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah kategori artikel ini\"  
                                                        name={$row['id']}>{$row['kname']}</a></td>";
                                    else
                                       $output .="<td><a href=\"#\" class=\"modal3\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah kategori artikel ini\"  
                                                        name={$row['id']}>Tak Terkategori</a></td>";

                                    if(!empty($row['penulis']))        
                                       $output .="<td>{$row['adname']}</td>";
                                    else
                                       $output .="<td>-</td>";

                                    if(!empty($row['tanggal']))
                                        $output .="<td>{$row['tanggal']}</td>";
                                    else
                                        $output .="<td>-</td>";

                                    if($row['status'] == 0)
                                       $output .="<td><a href=\"#\" class=\"modal1\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah status artikel ini\"  
                                                        name={$row['id']}>Tidak terbit</a</td>";
                                    else if($row['status'] == 1)
                                        $output .="<td><a href=\"#\" class=\"modal1\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah status artikel ini\" 
                                                        name={$row['id']}>Terbit</a></td>";
                                    else
                                        $output .="<td>-</td>";  

                                    if(!empty($row['id']))
                                        $output  .="<td><button class=\"btn btn-default modal2\"
                                                        name=\"{$row['id']}\" 
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus artikel ini\" ><span 
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
    <!-- status -->
    <div class="modal fade" id="modal1show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_artikel.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Status Artikel</h4>
            </div>
            <div class="modal-body">
              <strong>Mengubah status artikel</strong> 
              <br />
              <br />
                    <input type="text" name="idartikel" value="" id="modal1id" hidden>
                    <select class="form-control" name="status">
                    	<option >Pilih Status Publikasi Artikel</option>
                        <option >Tidak diterbitkan</option>
                        <option value="1" >Terbitkan</option>
                    </select>
               <br />
               <br />
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="btnstatus"
                    id="modalbutton">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Batal</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
       </form>
    </div>
    <!-- /status -->
    <!-- Hapus -->
    <div class="modal fade" id="modal2show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_artikel.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title">Hapus Artikel</h4>
            </div>
            <div class="modal-body">
              <strong style="font-size: 16px">Menghapus artikel ini?</strong>
              <blockquote>
                <p class="text-warning" style="font-size: 16px">
                    <span class="fa fa-warning"
                    ></span> Peringatan : artikel yang sudah dihapus tidak bisa di kembalikan lagi
                </p>
              </blockquote> 
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
    <!-- kategori -->
    <div class="modal fade" id="modal3show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_artikel.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Kategori Artikel</h4>
            </div>
            <div class="modal-body">
              <strong>Mengubah kategori artikel</strong> 
              <br />
              <br />
                    <input type="text" name="id3artikel" value="" id="modal3id" hidden>
                    <select class="form-control" name="kategori">
                            <option >Pilih Kategori Artikel</option>
                            <?php
                                $database->query("select * from ". kategori_artikel::$nama_tabel);
                                $database->execute();
                                while($row =$database->fetch()){
                                    $output = "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                    echo $output;
                                }
                            ?>
                            <option >Lain-lain</option>
                            </select>
               <br />
               <br />
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary" name="btnkategori"
                    id="modalbutton">Ok</button>
              <button type="button" class="btn btn-default" data-dismiss="modal"> Batal</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
       </form>
    </div>
    <!-- /status -->
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
