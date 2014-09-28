<?php
require_once("../includes/function.php");
require_once("../includes/database.php");
require_once("../includes/session_admin.php");
require_once("../includes/admin.php");
require_once("../includes/cu.php");

$admin = new admin();

if($session->is_logged_in()){
    redirect_to("index.php");
}

if(isset($_POST['submit'])){
    $errors = array();

    $field_array = array('username','password');
    $errors = array_merge($errors,cek_field($field_array,$_POST));

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if(empty($errors)){
        $found_user = admin::authenticate($username,$password);

        if($found_user){    
            $admin->id = $found_user->id;
            $admin->update_online();
            $session->login($found_user);
            redirect_to("index.php");
        }else{
            $session->pesan("Kombinasi username atau password tidak tepat.");
            redirect_to("login.php");
        }
    }else{
        $session->pesan("Gagal melakukan login.");
        redirect_to("login.php");
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

    <title>Puskopdit BKCU Kalimantan Admin Site -- Login</title>
    <link rel="shortcut icon" href="../images/logo.png"> 
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

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
    <style type="text/css"> 
        body{
            background: url(../images/wallpaper-1331538.jpg) no-repeat center center fixed;
            background-image: url(../images/wallpaper-1331538.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12 ">
            <h1 style="text-align: center; color:#FFFFFF;"><b>Puskopdit BCKU Kalimantan</b></h1>
            </div>  
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-primary" style="margin-top: 0px;">
                    <div class="panel-heading">
                        <h3 class="panel-title">Silahkan Login</h3>
                    </div>
                    <div class="panel-body">
                    <?php   
                    if(!empty($pesan)){
                        $output ="<div class=\"alert alert-danger alert-dismissable\">";
                        $output .="<button type=\"button\" class=\"close\" data-dismiss=\"alert\" 
                                    aria-hidden=\"true\">&times;</button>";
                        $output .=$pesan ."<br />";
                        if(!empty($errors)){
                            $output .="Ada kesalahan pada bagian : ";
                            foreach($errors as $error){
                            $output .= " - " . $error . "<br />";
                            }
                        }
                        $output .="</div>";
                        echo $output;
                    } 
                    ?>
                        <form role="form" action="login.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Username" name="username" type="text" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" name="password" type="password" value="">
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <button type="submit" class="btn btn-lg btn-primary btn-block" 
                                        name="submit"><i class="fa fa-sign-in fa-fw"></i>Login</button>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

</body>

</html>
