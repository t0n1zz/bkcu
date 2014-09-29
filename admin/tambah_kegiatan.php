<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once('../includes/session_admin.php');
require_once("../includes/kegiatan.php");

if(!$session->is_logged_in()){
    $session->pesan("anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$kegiatan = new kegiatan();
$thispage = "tambah_kegiatan";

if(isset($_POST['simpan']) || isset($_POST['simpanbaru'])){
    $errors = array();
    $field_array = array('name','tempat','sasaran');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
        $kegiatan->name = $_POST['name'];
        $name = $_POST['name'];
        $kegiatan->wilayah = $_POST['wilayah'];
        $kegiatan->tempat = $_POST['tempat'];
        $kegiatan->sasaran = $_POST['sasaran'];
        $kegiatan->fasilitator = $_POST['fasilitator'];

        $kegiatan->penulis = $_SESSION['bkcu_user'];

        $timestamp = strtotime($_POST['tanggal']);
        $timestamp2 = strtotime($_POST['tanggal2']);
        $tanggal = date('Y-m-d',$timestamp);
        $tanggal2 = date('Y-m-d',$timestamp2);
        $kegiatan->tanggal = $tanggal;
        $kegiatan->tanggal2 = $tanggal2;
        try{
            if($kegiatan->save()){
                if(isset($_POST['simpan'])){
                    $session->pesan("Berhasil menambah kegiatan {$name}");
                    redirect_to("tampil_kegiatan.php");
                }
                if(isset($_POST['simpanbaru'])){
                    $session->pesan("Kegiatan {$name} berhasil di tambah");
                    redirect_to("tambah_kegiatan.php");
                }
            }else
                $message = "Gagal menambah kegiatan";
        }catch(PDOException $e){
            $message = "Gagal menambah kegiatan";
            error_notice($e);
        }
    }else
        $message = "Gagal menambah kegiatan";
}


if(isset($_POST['batal'])){
    redirect_to("tampil_kegiatan.php");
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Tambah Kegiatan</title>
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

    <!-- Bootstrap extended form CSS -->
    <link href="../BootstrapFormHelper/css/bootstrap-formhelpers.min.css" rel="stylesheet">

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
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <?php include_once("component/header.php"); ?>
            <?php include_once("component/sidebar.php"); ?>
        </nav>
             
        <!-- Content -->
        <div id="page-wrapper">
            <!-- header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span class="fa fa-plus"></span> Tambah Kegiatan</h1>
                </div>           
            </div>
            <!-- /header --> 
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
                <form role="form" method="post" action="tambah_kegiatan.php" >
                <div class="panel panel-default">
                    <!--button-->
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan kegiatan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="simpanbaru" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan kegiatan dan memulai menulis kegiatan baru" 
                                    class="btn btn-default"><span class="fa fa-save"></span> <span class="fa fa-plus"></span> Simpan dan buat baru</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal menambah kegiatan dan kembali ke halaman Kelola Kegiatan" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!--/button-->
                    <div class="panel-body">
                        <!--judul-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Nama Kegiatan</label>
                            <input type="text" name="name" class="form-control" 
                                    placeholder="Silahkan masukkan nama pelayanan"/>
                        </div>
                        </div>
                        <!--/judul-->
                        <!--mulai-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Tanggal Kegiatan Dimulai</label>
                            <div class="bfh-datepicker" data-min="today" data-name="tanggal" >
                                <input id="datepickers" type="text" class="datepicker" >
                            </div>
                        </div>
                        </div>
                        <!--/mulai-->
                        <!--Selesai-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Tanggal Kegiatan Selesai</label>
                            <div class="bfh-datepicker" data-min="today" data-name="tanggal2" >
                                <input id="datepickers" type="text" class="datepicker" >
                            </div>
                        </div>
                        </div>
                        <!--/Selesai-->
                        <!--status-->
                        <div class="col-lg-4">
                        <div class="form-group">
                            <label>Wilayah</label>
                            <select class="form-control" name="wilayah">
                                <option >Pilih Wilayah</option>
                                <option value="1" >Barat</option>
                                <option value="2" >Tengah</option>
                                <option value="3" >Timur</option>
                            </select>
                        </div>
                        </div>
                        <!--/status-->
                        <!--Tempat-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Tempat</label>
                            <input type="text" name="tempat" class="form-control" 
                                    placeholder="Silahkan masukkan nama tempat"/>
                        </div>
                        </div>
                        <!--/Tempat-->
                        <!--Sasaran-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Sasaran Peserta</label>
                            <input type="text" name="sasaran" class="form-control" 
                                    placeholder="Silahkan masukkan sasaran peserta"/>
                        </div>
                        </div>
                        <!--/Sasaran-->
                        <!--Fasilitator-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Fasilitator</label>
                            <input type="text" name="fasilitator" class="form-control" 
                                    placeholder="Silahkan masukkan nama fasilitator"/>
                        </div>
                        </div>
                        <!--/Fasilitator-->
                    </div>
                 </div>
                 </form>
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

    <script type="text/javascript" src="../js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        skin: 'light',
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ],
        toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
        toolbar2: "print preview media | forecolor backcolor emoticons | fontselect fontsizeselect",
        image_advtab: true,
        templates: [
            {title: 'Test template 1', content: 'Test 1'},
            {title: 'Test template 2', content: 'Test 2'}
        ],
        file_browser_callback: RoxyFileBrowser
    });


    function RoxyFileBrowser(field_name, url, type, win) {
      var roxyFileman = '../js/tinymce/plugins/fileman/index.html?integration=tinymce4';
      if (roxyFileman.indexOf("?") < 0) {     
        roxyFileman += "?type=" + type;   
      }
      else {
        roxyFileman += "&type=" + type;
      }
      roxyFileman += '&input=' + field_name + '&value=' + document.getElementById(field_name).value;
      tinyMCE.activeEditor.windowManager.open({
         file: roxyFileman,
         title: 'File Manager',
         width: 800, 
         height: 480,
         resizable: "yes",
         plugins: "media",
         inline: "yes",
         close_previous: "no"  
      }, {     window: win,     input: field_name    });
      return false; 
    }
    </script>

    <script src="../BootstrapFormHelper/js/bootstrap-formhelpers.min.js"></script>

    <script src="../js/myscript.js"></script>

</body>

</html>
