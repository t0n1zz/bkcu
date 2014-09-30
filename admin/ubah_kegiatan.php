<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once('../includes/session_admin.php');
require_once("../includes/kegiatan.php");

if(!$session->is_logged_in()){
    $session->pesan("anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$max_file_size = 1048576;

$kegiatan = new kegiatan();
$thispage = "ubah_kegiatan";

if(isset($_POST['simpan'])){
    $errors = array();
    $field_array = array('name','tempat','sasaran');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
        $kegiatan->id = $_POST['id'];  
        $kegiatan->name = $_POST['name'];
        $name = $_POST['name'];
        $kegiatan->wilayah = $_POST['wilayah'];
        $kegiatan->tempat = $_POST['tempat'];
        $kegiatan->sasaran = $_POST['sasaran'];
        $kegiatan->fasilitator = $_POST['fasilitator'];

        $kegiatan->penulis = $_POST['penulis'];

        $timestamp = strtotime($_POST['tanggal']);
        $timestamp2 = strtotime($_POST['tanggal2']);
        $tanggal = date('Y-m-d',$timestamp);
        $tanggal2 = date('Y-m-d',$timestamp2);
        $kegiatan->tanggal = $tanggal;
        $kegiatan->tanggal2 = $tanggal2;

        try{
            if($kegiatan->save()){
                if(isset($_POST['simpan'])){
                    $session->pesan("Berhasil mengubah informasi kegiatan {$name}");
                    redirect_to("tampil_kegiatan.php");
                }
            }else{
                $message = "Gagal mengubah kegiatan";
            }
        }catch(PDOException $e){
            $message = "Gagal mengubah kegiatan";
            error_notice($e);
        }
    }else
        $message = "Gagal mengubah kegiatan";
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Ubah Kegiatan</title>
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
             
        <?php
            if(isset($_GET['kegiatan'])){
                $kegiatan->id = $_GET['kegiatan'];
                $sel_kegiatan = $kegiatan->get_subject_by_id();
            }else{
                redirect_to("wrong.php");
            }
        ?>
        
        <!-- Content -->
        <div id="page-wrapper">
            <!-- header -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header"><span class="fa fa-pencil"></span> Ubah Kegiatan</h1>
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
                <form role="form" method="post" action="ubah_kegiatan.php?kegiatan=<?php echo $sel_kegiatan['id']; ?>" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <!--button-->
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan layanan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal mengubah layanan dan kembali ke halaman Kelola Pelayanan" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!--/button-->
                    <div class="panel-body">
                        <input type="text" name="id" value="<?php echo $sel_kegiatan['id']; ?>" hidden />
                        <input type="text" name="penulis" value="<?php echo $sel_kegiatan['penulis']; ?>" hidden />
                        <!--judul-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Nama Pelayanan</label>
                            <?php
                                $show_name = $sel_kegiatan['name'];
                                if(!empty($show_name))
                                    echo "<input type=\"text\" name=\"name\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan nama layanan\" value=\"$show_name\" />";
                                else
                                    echo "<input type=\"text\" name=\"name\" class=\"form-control\" 
                                            placeholder=\"Silahkan masukkan nama layanan\" value=\"\" />";
                            ?>
                        </div>
                        </div>
                        <!--/judul-->
                        <!--mulai-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Tanggal Kegiatan Dimulai</label>
                            <div class="bfh-datepicker" data-name="tanggal"
                                 data-date="<?php
                                    if(!empty($sel_kegiatan['tanggal'])){
                                        $timestamp3 = strtotime($sel_kegiatan['tanggal']);
                                        $tanggal3 = date('m/d/Y',$timestamp3);
                                        echo $tanggal3;
                                    }
                                 ?>">
                                <input id="datepickers" type="text" class="datepicker" >
                            </div>
                        </div>
                        </div>
                        <!--/mulai-->
                        <!--Selesai-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Tanggal Kegiatan Selesai</label>
                            <div class="bfh-datepicker" data-name="tanggal2"
                                 data-date="<?php
                                    if(!empty($sel_kegiatan['tanggal2'])){
                                        $timestamp4 = strtotime($sel_kegiatan['tanggal2']);
                                        $tanggal4 = date('m/d/Y',$timestamp4);
                                        echo $tanggal4;
                                    }
                                 ?>">
                                <input id="datepickers" type="text" class="datepicker" >
                            </div>
                        </div>
                        </div>
                        <!--/Selesai-->
                        <!--wilayah-->
                        <div class="col-lg-4">
                        <div class="form-group">
                            <label>Status</label>
                            <select class="form-control" name="wilayah">
                            <option >Wilayah</option>
                            <option value="1"
                                <?php
                                    if($sel_kegiatan['wilayah'] == 1)
                                        echo " selected";
                                ?>
                            >Barat</option>
                            <option value="2" 
                                <?php
                                if($sel_kegiatan['wilayah'] == 2)
                                    echo " selected";
                                ?>
                            >Tengah</option>
                            <option value="3" 
                                <?php
                                if($sel_kegiatan['wilayah'] == 3)
                                    echo " selected";
                                ?>
                            >Timur</option>
                            </select>
                        </div>
                        </div>
                        <!--/wilayah-->
                        <!--tempat-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Tempat</div>
                              <input class="form-control" type="text" name="tempat" 
                                     placeholder="Masukkan nama tempat"
                                     value="<?php
                                     if(!empty($sel_kegiatan['tempat']))
                                        echo $sel_kegiatan['tempat'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <!--/tempat-->
                        <!--sasaran-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Sasaran</div>
                              <input class="form-control" type="text" name="sasaran" 
                                     placeholder="Masukkan sasaran"
                                     value="<?php
                                     if(!empty($sel_kegiatan['sasaran']))
                                        echo $sel_kegiatan['sasaran'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <!--/sasaran-->
                        <!--fasilitator-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <div class="input-group">
                              <div class="input-group-addon">Fasilitator</div>
                              <input class="form-control" type="text" name="fasilitator" 
                                     placeholder="Masukkan nama fasilitator"
                                     value="<?php
                                     if(!empty($sel_kegiatan['fasilitator']))
                                        echo $sel_kegiatan['fasilitator'];
                                     ?>">
                            </div>
                        </div>
                        </div>
                        <!--/fasilitator-->
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
