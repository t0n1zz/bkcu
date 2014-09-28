<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once('../includes/session_admin.php');
require_once("../includes/pelayanan.php");

if(!$session->is_logged_in()){
    $session->pesan("anda harus login terlebih dahulu");
    redirect_to("login.php");
}

$max_file_size = 5048576;

$pelayanan = new pelayanan();
$thispage = "tambah_pelayanan";

if(isset($_POST['simpan']) || isset($_POST['simpanbaru'])){
    $errors = array();
    $field_array = array('name','content');
    $errors = array_merge($errors, cek_field($field_array,$_POST));

    if(empty($errors)){
        $pelayanan->name = $_POST['name'];
        $name = $_POST['name'];
        $pelayanan->upload_gambar($_FILES['upload_file']);

        $content = $_POST['content'];
        $entity_content = htmlentities($content);
        $entity_content = stripslashes(str_replace('\r\n', '',$entity_content));
        $pelayanan->content = $entity_content;

        date_default_timezone_set('Asia/Jakarta');
        $dt = time();
        $waktu = strftime("%Y-%m-%d %H:%M:%S", $dt);
        $pelayanan->tanggal = $waktu;
        try{
            if($pelayanan->save()){
                if(isset($_POST['simpan'])){
                    $session->pesan("Berhasil menambah pelayanan {$name}");
                    redirect_to("tampil_pelayanan.php");
                }
                if(isset($_POST['simpanbaru'])){
                    $session->pesan("Pelayanan {$name} berhasil di tambah");
                    redirect_to("tambah_pelayanan.php");
                }
            }else{
                $message = "Gagal menambah pelayanan";
            }
        }catch(PDOException $e){
            $message = "Gagal menambah pelayanan";
            error_notice($e);
        } 
    }else
        $message = "Gagal menambah pelayanan";
}


if(isset($_POST['batal'])){
    redirect_to("tampil_pelayanan.php");
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Tambah Pelayanan</title>
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
                    <h1 class="page-header"><span class="fa fa-plus"></span> Tambah Pelayanan</h1>
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
                <form role="form" method="post" action="tambah_pelayanan.php" enctype="multipart/form-data">
                <div class="panel panel-default">
                    <!--button-->
                    <div class="panel-heading tooltip-demo">
                        <button type="submit" name="simpan" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan layanan" class="btn btn-default"><span class="fa fa-save"></span> Simpan</button>
                        <button type="submit" name="simpanbaru" data-toggle="tooltip" data-placement="top" 
                                    title="Menyimpan layanan dan memulai menulis layanan baru" 
                                    class="btn btn-default"><span class="fa fa-save"></span> <span class="fa fa-plus"></span> Simpan dan buat baru</button>
                        <button type="submit" name="batal" data-toggle="tooltip" data-placement="top" 
                                    title="Batal menambah layanan dan kembali ke halaman Kelola Pelayanan" 
                                    class="btn btn-default"><span class="fa fa-times-circle"></span> Batal</button>
                    </div>
                    <!--/button-->
                    <div class="panel-body">
                        <!--judul-->
                        <div class="col-lg-10">
                        <div class="form-group">
                            <label>Nama Pelayanan</label>
                            <input type="text" name="name" class="form-control" 
                                    placeholder="Silahkan masukkan nama pelayanan"/>
                        </div>
                        </div>
                        <!--/judul-->
                        <!--gambar-->
                        <div class="col-lg-5">
                        <label>Upload Gambar</label>
                            <div class="thumbnail">
                                <img class="img-responsive" src="../images/no_image.jpg" id="tampilgambar"
                                        alt="Generic placeholder image" style="width: 300px;; height: 200px;">
                             <div class="caption">
                                <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_file_size; ?>" />
                                <input onChange="readURL(this);" type="file" name="upload_file" 
                                        accept="image/jpeg"/>
                             </div>
                            </div>
                        </div>
                        <!--/gambar-->
                        <!--content-->
                        <div class="col-lg-12">
                            <label>Deskripsi Pelayanan</label>
                            <textarea name="content" style="width:100%; height:300px">
                            </textarea>
                        </div>
                        <!--/content-->
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

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

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

    

    <script src="../js/myscript.js"></script>

</body>

</html>
