<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/admin.php");
require_once("../includes/cuprimer.php");

if(!$session->is_logged_in()){
    $session->pesan("anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$admin = new admin();
$cu = new cuprimer();
$thispage = "tampil_admin";

if(isset($_POST['btnstatus'])){
    $admin->id = $_POST['idadmin'];
    $admin->status = $_POST['status'];

    try{
        if($admin->update_status()){
            $session->pesan("Berhasil mengubah status admin");
            redirect_to("tampil_admin.php");
        }else
            $message = "Gagal mengubah status admin";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal mengubah status admin";
    } 
}

if(isset($_POST['btnhapus'])){
    $admin->id = $_POST['id2admin'];

    try{
        if($admin->delete()){
            $session->pesan("Berhasil menghapus admin");
            redirect_to("tampil_admin.php");
        }else
            $message = "Gagal menghapus admin";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal menghapus admin";
    } 
}

if(isset($_POST['btnkategori'])){
    $admin->id = $_POST['idadmin'];
    $admin->cu = $_POST['kategori'];

    try{
        if($admin->update_cu()){
            $session->pesan("Berhasil mengubah asal cu");
            redirect_to("tampil_admin.php");
        }else
            $message = "Gagal mengubah asal cu";
    }catch(PDOException $e){
        error_notice($e);
        $message = "Gagal mengubah asal cu";
    } 
}

if(isset($_POST['btnakses'])){
    $admin->id = $_POST['id3admin'];
    $admin->akses_artikel = $_POST['akses_artikel'];
    $admin->tambah_artikel = $_POST['tambah_artikel'];
    $admin->ubah_artikel = $_POST['ubah_artikel'];
    $admin->ubah_status_artikel = $_POST['ubah_status_artikel'];
    $admin->hapus_artikel = $_POST['hapus_artikel'];
    $admin->akses_kategori = $_POST['akses_kategori'];
    $admin->tambah_kategori = $_POST['tambah_kategori'];
    $admin->ubah_kategori = $_POST['ubah_kategori'];
    $admin->hapus_kategori = $_POST['hapus_kategori'];
    $admin->akses_admin = $_POST['akses_admin'];
    if($admin->save()){
        $session->pesan("Berhasil mengubah hak akses admin");
        redirect_to("tampil_admin.php");
    }else
        $message = "Gagal mengubah hak akses admin : " . mysql_error();
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Kelola Admin</title>
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
                <h1 class="page-header"><span class="fa fa-archive"></span> Kelola Admin</h1>
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
                                class="btn btn-default" href="tambah_admin.php"><span class="fa fa-plus"></span> Tambah Admin</a>
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
                                <th>Username </th>
                                <th>Asal CU</th>
                                <th>Status</th>
                                <th>Online</th>
                                <th>Offline</th>
                                <!--<th>Hak Akses</th>-->
                                <th>Hapus</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $y = "";
                            function custom_echo($x)
                            {
                              if(strlen($x)<=5)
                                $y = $x;
                              else
                                $y=substr($x,0,5) . '...';
                            }

                            $sql_tampil = "SELECT ad.id,ad.username,ad.cu,ad.status,ad.online,ad.offline,";
                            $sql_tampil .="cu.id as cuid,cu.name as cuname";
                            $sql_tampil .=" FROM " .admin::$nama_tabel. " ad";
                            $sql_tampil .=" LEFT JOIN " .cuprimer::$nama_tabel. " cu";
                            $sql_tampil .=" ON ad.cu = cu.id";

                            $database->query($sql_tampil);
                            $database->execute();
                            while($row = $database->fetch()){
                               $output = "<tr>";
                                    if(!empty($row['id']))
                                        $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi admin ini\" 
                                                        href=\"ubah_artikel.php?artikel={$row['id']}\"
                                                        >{$row['id']}</a></td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['username']))
                                       $output .="<td><a data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi admin ini\" 
                                                        href=\"ubah_admin.php?admin={$row['id']}\"
                                                        >{$row['username']}</a></td>";
                                    else
                                       $output .="<td>-</td>";

                                    if(!empty($row['cuid']))
                                        $output .="<td><a href=\"#\" class=\"modal3\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi asal cu \"
                                                        name={$row['id']}>{$row['cuname']}</a></td>";
                                    else
                                        $output .="<td><a href=\"#\" class=\"modal3\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah informasi asal cu \"
                                                        name={$row['id']}>-</a></td>";

                                    if($row['status'] == 0)
                                       $output .="<td><a href=\"#\" class=\"modal1\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah status admin ini\"  
                                                        name={$row['id']}>Tidak Aktif</a</td>";
                                    else if($row['status'] == 1)
                                        $output .="<td><a href=\"#\" class=\"modal1\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah status admin ini\" 
                                                        name={$row['id']}>Aktif</a></td>";
                                    else
                                        $output .="<td><a href=\"#\" class=\"modal1\"
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah status admin ini\" 
                                                        name={$row['id']}>-</a></td>"; 

                                    if(!empty($row['online']))
                                        $output .="<td>{$row['online']}</td>";
                                    else
                                        $output .="<td>-</td>";

                                    if(!empty($row['offline']))
                                        $output .="<td>{$row['offline']}</td>";
                                    else
                                        $output .="<td>-</td>";

/*
                                    if(!empty($row['id']))
                                        $output  .="<td><a class=\"btn btn-default\"
                                                        href=\"ubah_akses_admin.php?admin={$row['id']}\" 
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk mengubah hak akses admin ini\" ><span 
                                                        class=\"glyphicon glyphicon-eye-open \"></span></a></td>";
                                    else
                                        $output .="<td>-</td>"; 
*/
                                    if(!empty($row['id']))
                                        $output  .="<td><button class=\"btn btn-default modal2\"
                                                        name=\"{$row['id']}\" 
                                                        data-toggle=\"tooltip\" data-placement=\"top\" 
                                                        title=\"Tekan untuk menghapus admin ini\" ><span 
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
       <form role="form" action="tampil_admin.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Status Admin</h4>
            </div>
            <div class="modal-body">
              <strong>Mengubah status admin</strong> 
              <br />
              <br />
                    <input type="text" name="idadmin" value="" id="modal1id" hidden>
                    <select class="form-control" name="status">
                        <option >- Non-aktifkan</option>
                        <option value="1" >- Aktifkan</option>
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
       <form role="form" action="tampil_admin.php" method="post">
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
              <input type="text" name="id2admin" value="" id="modal2id" hidden>
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
    <!-- cu -->
    <div class="modal fade" id="modal3show" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
       <form role="form" action="tampil_admin.php" method="post">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h4 class="modal-title ">Asal Credit Union</h4>
            </div>
            <div class="modal-body">
              <strong>Mengubah Asal Credit Union</strong> 
              <br />
              <br />
                    <input type="text" name="idadmin" value="" id="modal3id" hidden>
                    <select class="form-control" name="kategori">
                            <option >Pilih Asal Credit Union</option>
                            <?php
                                $database->query("select * from ". cuprimer::$nama_tabel);
                                $database->execute();
                                while($row =$database->fetch()){
                                    $output = "<option value=\"{$row['id']}\">{$row['name']}</option>";
                                    echo $output;
                                }
                            ?>
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
    <!-- /cu -->
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
