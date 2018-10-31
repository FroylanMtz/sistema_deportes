<?php

//Invocamos el modelo que se utilizará en todos los archivos
require_once('Modells/Modelo.php');
require_once('Modells/crud.php');
require_once('Controllers/Controlador.php');

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Iniciar Sesión</title>

    <link rel="shortcut icon" href="Public/img/logo.jpg">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="Public/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="Public/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="Public/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="Public/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="Public/plugins/iCheck/square/blue.css">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">

<div class="login-box">
  
    <div class="login-box-body">
        
        <img class="center-block img-circle" src="Public/img/logo.jpg" width="150px" height="150px">
        <p class="login-box-msg " ><b><h3 align="center">Sistema de Deportes</h3><b></p>
        <!--<p class="login-box-msg"><b>INICIO DE SESIÓN<b></p>-->
        <form  method="post">

            <div class="form-group has-feedback">
                <input name="usuario" type="text" class="form-control" placeholder="Usuario">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            
            <div class="form-group has-feedback">
                <input name= "contrasena" type="password" class="form-control" placeholder="Contraseña">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                </div>
            </div>

        </form>

    </div>
    <!-- /.login-box-body -->

</div>


    <!-- jQuery 3 -->
    <script src="Public/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="Public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- iCheck -->
    <script src="Public/plugins/iCheck/icheck.min.js"></script>
    

</body>
</html>

<?php

    $controlador = new Controlador();
 
    $controlador -> iniciarSesion();
?>