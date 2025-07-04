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
           <p style="text-align:center">ESTIMADO CLIENTE, USTED PRESENTA UN CORTE POR DEMORA EN EL PAGO DE NUESTROS SERVICIOS, POR FAVOR CONTACTAR CON SU <b>ASISTENTE COMERCIAL<b></p>
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