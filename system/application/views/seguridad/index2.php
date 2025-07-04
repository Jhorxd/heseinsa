<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo TITULO; ?></title>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/estilos.css?=<?=CSS;?>" type="text/css"/>
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/theme.css?=<?=CSS;?>" type="text/css"/>		
    <script language="javaScript" src="<?php echo base_url(); ?>js/menu/JSCookMenu.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js?=<?=JS;?>"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.min.js?=<?=JS;?>"></script>
    <link rel="shortcut icon" href="images/ico/favicon.ico"> 
</head>

<body style="background:#818CA0;" onLoad="document.getElementById('txtUsuario').focus();">
    <!--<table style="background-repeat-y: no-repeat;" width="943" border="0" align="center" cellpadding="0" cellspacing="0" background="<?php echo base_url(); ?>images/login ferresat.jpg?=<?=IMG;?>">-->
        <!--DWLayoutTable-->
        <section class="login">
            <fieldset>
                <legend class="title-large"> Inicio de Sesión </legend>
                
                <form action="<?=base_url('usuario/login');?>" method="POST" id="frmLogin" action="<?php echo base_url() . 'index.php/index/ingresar_sistema';?>">
                    <section class="fieldform nbgck">
                        <input type="txtUsuario" name="txtUsuario" class="icon-user" placeholder="Nombre de Usuario" pattern="[A-Za-z0-9ÁÉÍÓÚáéíóúñÑ\.\-]{4,35}" title="Solo se permiten letras numeros puntos y guiones - El nombre de usuario no debe llevar espacios en blanco. El tamaño minimo permitido son 4 caracteres y el maximo son 35 caracteres" required autocomplete="off" autofocus/>
                    </section>
                    
                    <section class="fieldform nbgck">
                        <input type="txtClave" name="txtClave" class="icon-lock" placeholder="Contraseña" pattern="[A-Za-z0-9ÁÉÍÓÚñÑ\.\-]{6,17}" title="Solo se permiten letras numeros puntos y guiones - El nombre de usuario no debe llevar espacios en blanco. El tamaño minimo permitido son 6 caracteres y el maximo son 17 caracteres" required/>
                    </section>

                    <section class="fieldform nbgck">
                        <input name="ingresar" type="submit" class="texto" id="ingresar" value="Ingresar"/>
                        <input name="cancelar" type="reset" class="texto" id="cancelar" value="Limpiar" />
                    </section>
                </form>
            </fieldset>
        </section>
</body>
</html>