<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    
    <title><?php echo TITULO; ?></title>
    <link rel="shortcut icon" href="<?=base_url()?>images/favicon.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/theme.css?=<?=CSS;?>" type="text/css"/>        
    <script language="javaScript" src="<?php echo base_url(); ?>js/menu/JSCookMenu.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js?=<?=JS;?>"></script>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/bootstrap/css/bootstrap.min.css">  
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/look.css">    
  
    <link rel="shortcut icon" href="<?=base_url(); ?>assets/img/favicon.png"> 
</head>

<body class="hold-transition fondo-login" onload="dontBack();">    
    <div class="login-box">  
        <div class="login-logo">
            <a href="#"><img src="<?php echo base_url();?>assets/img/demoosa.png" alt="Logo Empresa" width="53px"><b>OSA</b>ERP</a> 
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <center>
                <img src="<?=base_url();?>assets/img/logo.png" alt="Logo Empresa" style="width: 100%; padding-bottom: 1.5em;">
            </center>
            
            <p class="login-box-msg">Identifiquese para ingresar</p>

            <form method="POST" id="frmLogin" action="<?php echo base_url() . 'index.php/index/ingresar_sistema';?>">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="txtUsuario" id="txtUsuario" placeholder="Ingrese su usuario">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="txtClave" id="txtClave" placeholder="Contraseña">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>
                <div class="form-group has-feedback">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" id="ingresar">Ingresar</button>
                </div>
            </form>

            <center> <img src="<?php echo base_url();?>assets/img/osa-fact.jpg" alt="Logo osa-fact" width="100px"><br> &copy;OSA-Fact | Facturador Electrónico Integrado</center>
            <!--
                <div class="social-auth-links text-center">
                    <p>- OR -</p>
                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign in using Facebook</a>
                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign in using Google+</a>
                </div>
            -->
            <!-- /.social-auth-links -->

            <!--  <a href="#">Olvidé my contraseña</a><br> -->
            <!-- <a href="register.html" class="text-center">Register a new membership</a><br> -->
            <?php
                if ( isset($msg) && $msg != NULL){ ?>
                    <section style="color: red">
                        <?=$msg;?>
                    </section> <?php
                } 

                $yr = "&copy;".date('Y');
            ?>
        </div>
        <!-- /.login-box-body -->
    </div>
    
    <div class="login-copy" >
        <a href="http://www.ccapasistemas.com"><?php echo $yr; ?>  Todos los derechos reservados | www.ccapasistemas.com</a>
    </div>
    <!-- /.login-box -->

    <!-- Bootstrap 3.3.6 -->
    <script src="<?php echo base_url();?>assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>