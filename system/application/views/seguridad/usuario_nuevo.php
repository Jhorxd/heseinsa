<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js?=<?=JS;?>"></script>   
<script type="text/javascript" src="<?php echo base_url(); ?>js/seguridad/usuario.js?=<?=JS;?>"></script>

<style type="text/css">
    fieldset{
        float: left;
        width: 30%;
        margin-left: 1em; 
    }

    legend{
        font-weight: bold;
    }

    fieldset section{
        display: block;
        width: 100%;
        text-align: left;
        padding: 0.2em 0.2em 1em 1em;
    }

    fieldset section label{
        display: block;
        width: 100%;
        font-weight: bold;
    }

    fieldset section input{
        padding: 0.5em;
        font-style: italic;
    }
</style>

<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
            <div id="frmBusqueda">
                <?php echo validation_errors("<div class='error'>", '</div>'); ?>
                <form id="<?php echo $formulario; ?>" method="post" action="<?php echo $action; ?>">
                    <div id="datosGenerales">
                        <fieldset>
                            <legend>Información del empleado</legend>

                            <section>
                                <input type="hidden" id="idPersona" value="<?=$idPersona; ?>" name="idPersona"/>
                                <label for="persona">Empleado *</label>
                                <select name="persona" id="persona" class="cboDirectivo" <?=( $codigo != "" ) ? " disabled " : "";?> >
                                    <option value=""> :: SELECCIONE :: </option><?php
                                    foreach($cboDirectivo as $indice => $val){ ?>
                                        <option value="<?=$val->PERSP_Codigo;?>" <?=( isset($idPersona) && $idPersona == $val->PERSP_Codigo ) ? " selected" : "";?>><?=$val->nombre;?></option><?php
                                    } ?>
                                </select>
                            </section>

                            <section>
                                <label for="txtNombres">Nombres</label>
                                <input type="text" name="txtNombres" id="txtNombres" maxlength="30" class="cajaGrande cajaSoloLectura" value="<?=$nombres;?>" readonly="readonly" placeholder="Nombres">
                            </section>
                            
                            <section>
                                <label for="txtPaterno">Apellido paterno</label>
                                <input type="text" name="txtPaterno" id="txtPaterno" maxlength="30" class="cajaGrande cajaSoloLectura" value="<?=$paterno;?>" readonly="readonly" placeholder="Apellido paterno">
                            </section>
                            
                            <section>
                                <label for="txtMaterno">Apellido materno</label>
                                <input type="text" name="txtMaterno" id="txtMaterno" maxlength="30" class="cajaGrande cajaSoloLectura" value="<?=$materno;?>" readonly="readonly" placeholder="Apellido Materno">
                            </section>

                        </fieldset>

                        <fieldset>
                            <legend>Datos de usuario</legend>
                                <section>
                                    <label for="txtUsuario">Usuario *</label>
                                    <input type="text" name="txtUsuario" id="txtUsuario" maxlength="30" class="cajaMedia <?=($idPersona != '') ? 'cajaSoloLectura' : ''?>" value="<?=$usuario;?>" placeholder="USUARIO" autocomplete="off" <?=($idPersona != '') ? 'readonly' : '';?>>
                                </section>
                                
                                <section>
                                    <label for="txtClave">Clave *</label>
                                    <input type="password" name="txtClave" id="txtClave" maxlength="30" class="cajaMedia" value="<?=$clave;?>" autocomplete="off" placeholder="**********">
                                </section>
                                
                                <section>
                                    <label for="txtClave2">Repetir clave *</label>
                                    <input type="password" name="txtClave2" id="txtClave2" maxlength="30" class="cajaMedia" value="<?=$clave2;?>" autocomplete="off" placeholder="**********">
                                </section>
                        </fieldset>

                        <br>

                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="0">
                            <tr>
                                <td>                                   
                                    <a href="javascript:;" id="nuevoRegistro">Nuevo <image src="<?=base_url();?>images/add.png?=<?=IMG;?>" name="agregarFila" id="agregarFila"/></a>
                                    <table id="tblEstablec" width="50%" class="fuente8" cellspacing="0" cellpadding="6" border="1">
                                        <tr style="background: #337ab7; text-align: center; color: white; font-weight: bold;">
                                            <td>Establecimiento</td>
                                            <td>Rol</td>
                                            <td>Default</td>
                                            <td>Borrar</td>
                                        </tr>
                                        <?php
                                        if (count($lista) > 0) {
                                            foreach ($lista as $indice => $valor) {
                                                $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla';
                                                ?>
                                                <tr class="<?php echo $class; ?>">
                                                    <td><div align="left"><?php echo $valor[0]; ?></div></td>
                                                    <td><div align="left"><?php echo $valor[1]; ?></div></td>
                                                    <td><div align="center"><?php echo $valor[2]; ?></div></td>
                                                    <td><div align="center"><?php echo $valor[3]; ?></div></td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <img id="loading" src="<?php echo base_url(); ?>images/loading.gif?=<?=IMG;?>"  style="visibility: hidden" />
                        <a href="javascript:;" id="grabarUsuario"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="limpiarUsuario"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" ></a>
                        <a href="javascript:;" id="cancelarUsuario"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton"></a>
                            <?php echo $oculto ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>