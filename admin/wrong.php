<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/artikel.php");
require_once("../includes/gambar_kegiatan.php");
require_once("../includes/kegiatan.php");
require_once("../includes/admin.php");
require_once("../includes/cuprimer.php");

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
$thispage = "index";

$admin->id = $_SESSION['bkcu_user'];
$sel_admin = $admin->get_subject_by_id();

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
            <div class="row">
                <div class="jumbotron" style="margin-top: 10px;">
                    <h1><i class="fa fa-warning"></i>Oops, anda berada pada halaman yang salah</h1>
                    <p>Silahkan kembali ke dashboard</p>
                    <p><a href="index.php" class="btn btn-primary btn-lg" role="button">&laquo Dashboard</a></p>
                </div>         
            </div>
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

    <script src="../js/myscript.js"></script>

</body>

</html>
