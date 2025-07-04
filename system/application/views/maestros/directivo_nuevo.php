<html>
    <head>	
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.js?=<?=JS;?>"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.metadata.js?=<?=JS;?>"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.validate.js?=<?=JS;?>"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>js/maestros/directivo.js?=<?=JS;?>"></script>		
        <script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js?=<?=JS;?>"></script>		
        <script type="text/javascript">
            jQuery(document).ready(function(){
                modo = $("#modo").val();
                //tipo = $("#tipo").val();
                if(modo=='insertar'){
                    //$("#nombres").val('No usado');
                    //$("#paterno").val('No usado');
                    $("#numero_documento").focus();
                }                
                else if(modo=='modificar'){
                    /*if(tipo=='0'){
                                $("#ruc").val('00000000000');
                        }
                        else if(tipo=='1'){
                     */
                    //$("#nombres").val('No usado');
                    //$("#paterno").val('No usado');				
                    //}
                }
                $('#idCompania').val($('#cboCompania').val())
            });		
            function cargar_ubigeo(ubigeo,valor){
                $("#cboNacimiento").val(ubigeo);
                $("#cboNacimientovalue").val(valor);
            }
            function cargar_ubigeo_complementario(departamento,provincia,distrito,valor,seccion,n){
                if(seccion=="sucursal"){
                    a = "dptoSucursal["+n+"]";
                    b = "provSucursal["+n+"]";
                    c = "distSucursal["+n+"]";
                    d = "distritoSucursal["+n+"]"
                    document.getElementById(a).value = departamento;
                    document.getElementById(b).value = provincia;
                    document.getElementById(c).value = distrito;
                    document.getElementById(d).value = valor;
                }
            }
        </script>
    </head>
    <body>
        <!-- Inicio -->
        <div id="VentanaTransparente" style="display:none;">
            <div class="overlay_absolute"></div>
            <div id="cargador" style="z-index:2000">
                <table width="100%" height="100%" border="0" class="fuente8">
                    <tr valign="middle">
                        <td> Por Favor Espere    </td>
                        <td><img src="<?php echo base_url(); ?>images/cargando.gif?=<?=IMG;?>"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>
                    </tr>
                </table>
            </div>
        </div>
        <!-- Fin -->	
        <div id="pagina">
            <div id="zonaContenido">
                <div align="center">
                    <div id="tituloForm" class="header"><?php echo $titulo; ?></div>
                    <div id="frmBusqueda">
                        <form id="frmDirectivo" name="frmDirectivo" method="post" action="" enctype= "multipart/form-data">
                            <input type="hidden" name="idCompania" id="idCompania" class="cajaMedia" value=""/>
                            <div id="container" class="container">
                                <ol>
                                    <h4>Primero debe completar los siguientes campos antes de enviar.</h4>						
                                    <div id="containerEmpresa">
                                        <li><label for="ruc" class="error">Por favor ingrese su ruc con sólo campos numéricos.</label></li>
                                        <li><label for="razon_social" class="error">Por favor ingrese un nombre o razon social.</label></li>
                                    </div>
                                    <div id="containerPersona">
                                        <li><label for="nombres" class="error">Por favor ingrese el nombre de la persona.</label></li>
                                        <li><label for="paterno" class="error">Por favor ingrese el apellido de la persona </label></li>
                                        <li><label for="email" class="error">Por favor ingrese el correo de la persona.</label></li>
                                        <li><label for="tipo_documento" class="error">Por favor seleccione un tipo de documento.</label></li>
                                        <li><label for="cboSexo" class="error">Por favor seleccione el sexo de la persona.</label></li>
                                        <li><label for="cboNacionalidad" class="error">Por favor seleccione una nacionalidad.</label></li>
                                    </div>
                                </ol>
                            </div>					
        <!--<div align="left"class="fuente8" style="<?php //echo $display_datosEmpresa;                ?>float:left;height:20px;border: 0px solid #000;margin-top:7px;margin-left: 15px;width: 300px;">
            <a href="#" id="idGeneral">General&nbsp;&nbsp;&nbsp;</a>
            <a href="#" id="idSucursales">|&nbsp;Sucursales&nbsp;&nbsp;&nbsp;|</a>&nbsp;
            <a href="#" id="idContactos">Cont&aacute;ctos&nbsp;&nbsp;&nbsp;</a>&nbsp;
            <a href="#" id="idAreas" style="display:none;">&Aacute;reas</a>
        </div>-->
        <!--<div id="nuevoRegistro" style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;"><a href="#">Nuevo <image src="<?php echo base_url(); ?>images/add.png?=<?=IMG;?>" name="agregarFila" id="agregarFila" border="0" alt="Agregar"></a></div><br><br>				
                            <div id="datosGenerales">
            <div id="tipoPersona">
                <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                    <tr <?php //echo $display;                ?>>
                        <td width="16%">Tipo Persona (*)</td>
                        <td width="42%">
                            <input type="radio" id="tipo_persona" name="tipo_persona" value="0" checked='checked'>Persona Natural
                            <input type="radio" id="tipo_persona" name="tipo_persona" value="1">Persona Jur&iacute;dica
                        </td>
                        <td width="42%" colspan="2" rowspan="1" align="left" valign="top"><ul id="lista-errores"></ul></td>
                    </tr>
                </table>
            </div>-->
           <!--<div id="datosEmpresa" style="<?php //echo $display_datosEmpresa;                ?>">
               <table class="fuente8" width="98%" cellspacing=0 cellpadding="6" border="0">
                <tr>
                  <td width="16%">Tipo de Código (*)</td>
                  <td colspan="3">
                    <select name="cboTipoCodigo" id="cboTipoCodigo" class="comboMedio">
                            <?php //echo $tipocodigo; ?>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td width="16%">RUC / NIC (*)</td>
                  <td colspan="3">
                        <input id="ruc" type="text" class="cajaPequena" NAME="ruc" maxlength="11" value="<?php //echo $datos->ruc;                ?>" onkeypress="return numbersonly('numero_documento',event);" onblur="buscar_empresa();">
                        <label id="empresa_msg" name="empresa_msg"></label>
                  </td>
                </tr>
                <tr>
                    <td width="16%">Nombre o Raz&oacute;n Social(*)</td>
                    <td colspan="3"><input name="razon_social" type="text" class="cajaGrande" id="razon_social" maxlength="150" value="<?php //echo $datos->nombre;                ?>"></td>
                </tr>
                <tr>
                    <td width="16%">Sector Comercial</td>
                    <td colspan="3"><select id="sector_comercial" name="sector_comercial" class="comboMedio" style="width:240px">
                            <?php //echo $cbo_sectorComercial; ?>
                                    </select></td>
                </tr>
            </table>
           </div>
                            -->
                            <div id="datosPersona" style="<?php echo $display_datosDirectivo; ?>">
                                <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                                    <tr>
                                        <td width="16%">Tipo de Documento&nbsp;(*)</td>
                                        <td>
                                            <select id="tipo_documento" name="tipo_documento" class="comboMedio" onchange="valida_tipoDocumento();">
                                                <?php echo $tipo_documento; ?>
                                            </select>
                                        </td>
                                        <td>Número de Documento</td>
                                        <td>
                                            <input name="numero_documento" type="text" class="cajaMedia" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero_documento; ?>" onkeypress="return numbersonly('numero_documento',event);" onblur="buscar_persona();">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4"><label id="persona_msg" name="persona_msg"></label></td>
                                    </tr>
                                    <tr>
                                        <td>Nombres&nbsp;(*)</td>
                                        <td><input id="nombres" type="text" class="cajaGrande" name="nombres" maxlength="45" value="<?php echo $nombres; ?>"></td>
                                        <td colspan="2" rowspan="7">
                                            <input name="foto" type="file" id="foto" value="<?php echo $imagen; ?>" size="50" />
                                            <?php if ($imagen == '') { ?>
                                                <div style="margin-left:100px; " >  <img src="<?php echo base_url() ?>images/persona.jpg?=<?=IMG;?>" /></div>
                                            <?php } if ($imagen != '') {
                                                ?>
                                                <div style="margin-left:100px; " >     <img style="width:160px;height:160px" src="<?php echo base_url() ?>images/<?php echo$imagen ?>" />  </div>
                                            <?php } ?> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Apellidos Paterno&nbsp;(*)</td>
                                        <td><input NAME="paterno" type="text" class="cajaGrande" id="paterno" size="45" maxlength="45" value="<?php echo $paterno; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Apellidos Materno</td>
                                        <td><input NAME="materno" type="text" class="cajaGrande" id="materno" size="45" maxlength="45" value="<?php echo $materno; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Fecha de Nacimiento</td>
                                        <td>                                            
                                            <input NAME="fechanac" type="text" class="cajaPequena" id="fechanac" value="<?php echo $fecnac; ?>" size="10" maxlength="10" readonly="readonly">
                                            <img height="16" border="0" width="16" id="Calendario3" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" style="cursor: pointer;"/>
                                            <script type="text/javascript">
                                                Calendar.setup({
                                                    inputField     :    "fechanac",      // id del campo de texto
                                                    ifFormat       :    "%Y/%m/%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                                    button         :    "Calendario3"   // el id del botón que lanzará el calendario
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Lugar de Nacimiento</td>
                                        <td>
                                            <input type="hidden" name="cboNacimiento" id="cboNacimiento" class="cajaMedia" value="<?php echo $cboNacimiento; ?>"/>
                                            <input type="text" name="cboNacimientovalue" id="cboNacimientovalue" class="cajaMedia cajaSoloLectura" readonly="readonly" value="<?php echo $cboNacimientovalue; ?>" ondblclick="abrir_formulario_ubigeo();"/>
                                            <a href="#" onclick="abrir_formulario_ubigeo();">
                                                <image src="<?php echo base_url(); ?>images/ver.png?=<?=IMG;?>" border='0'>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Sexo&nbsp;(*)</td>
                                        <td>
                                            <select name="cboSexo" id="cboSexo" class="comboMedio">
                                                <option value=''>::Seleccione::</option>
                                                <option value='0' <?php if ($sexo == '0') echo "selected='selected'"; ?>>MASCULINO</option>
                                                <option value='1' <?php if ($sexo == '1') echo "selected='selected'"; ?>>FEMENINO</option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Estado Civil</td>
                                        <td>
                                            <select name="cboEstadoCivil" id="cboEstadoCivil" class="comboMedio">
                                                <?php echo $cbo_estadoCivil; ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Nacionalidad&nbsp;(*)</td>
                                        <td>
                                            <select name="cboNacionalidad" id="cboNacionalidad" class="comboMedio">
                                                <?php echo $cbo_nacionalidad; ?>
                                            </select>
                                        </td>
                                        <td>RUC</td>   
                                        <td>
                                            <input id="ruc_persona" type="text" class="cajaMedia" name="ruc_persona" size="45" maxlength="11" value="<?php echo $ruc; ?>">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div id="divDireccion">

                                <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                                    <tr height="10px">
                                        <td colspan="4"><hr/></td>
                                    </tr>
                                    <tr>
                                        <td>Departamento&nbsp;</td>
                                        <td colspan="3">
                                            <div id="divUbigeo">
                                                <select id="cboDepartamento" name="cboDepartamento" class="comboMedio" onchange="cargar_provincia(this);">
                                                    <?php echo $cbo_dpto; ?>
                                                </select>&nbsp;	&nbsp;
                                                Provincia&nbsp;&nbsp;	&nbsp;
                                                <select id="cboProvincia" name="cboProvincia" class="comboMedio" onchange="cargar_distrito(this);">
                                                    <?php echo $cbo_prov; ?>
                                                </select>&nbsp;	&nbsp;
                                                Distrito&nbsp;&nbsp;	&nbsp;
                                                <select id="cboDistrito" name="cboDistrito" class="comboMedio">
                                                    <?php echo $cbo_dist; ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="16%">Direcci&oacute;n fiscal</td>
                                        <td colspan="3">
                                            <input NAME="direccion" type="text" class="cajaSuperGrande" id="direccion" size="45" maxlength="250" value="<?php echo $datos->direccion; ?>">
                                            TIPO VIA / NOMBRE VIA / N° / INTERIOR / ZONA
                                        </td>
                                    </tr>
                                    <tr height="10px">
                                        <td colspan="4"><hr/></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                            <table width="100%" class="fuente8" cellspacing=0 cellpadding=3 border="0">
                                                <tr>
                                                    <td width="16%">Tel&eacute;fono </td>
                                                    <td><input id="telefono" name="telefono" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->telefono; ?>"></td>
                                                    <td>M&oacute;vil</td>
                                                    <td><input id="movil" name="movil" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->movil; ?>"></td>
                                                    <td>Fax</td>
                                                    <td><input id="fax" name="fax" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->fax; ?>"></td>
                                                </tr>
                                                <tr>
                                                    <td>Correo electr&oacute;nico  </td>
                                                    <td><input NAME="email" type="text" class="cajaGrande" id="email" size="35" maxlength="50" value="<?php echo $datos->email; ?>"></td>
                                                    <td>Direcci&oacute;n web </td>
                                                    <td colspan="3">
                                                        <input NAME="web" type="text" class="cajaGrande" id="web" size="45" maxlength="50" value="<?php echo $datos->web; ?>">
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr height="10px">
                                        <td colspan="4"><hr></td>
                                    </tr>
                                    <tr>
                                        <td width="16%" valign="middle">Fecha Inicio</td>
                                        <td valign="middle">
                                            <input NAME="fechai" type="text" class="cajaPequena" id="fechai" value="<?php echo $fecini; ?>" size="10" maxlength="10" readonly="readonly">
                                            <img height="16" border="0" width="16" id="Calendario1" name="Calendario1" src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" />
                                            <script type="text/javascript">
                                                Calendar.setup({
                                                    inputField     :    "fechai",      // id del campo de texto
                                                    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                    button         :    "Calendario1"   // el id del botón que lanzará el calendario
                                                });
                                            </script>
                                        </td>
                                        <td width="16%" valign="middle">Fecha Fin</td>
                                        <td valign="middle"><input NAME="fechaf" type="text" class="cajaPequena" id="fechaf" value="<?php echo $fecfin; ?>" size="10" maxlength="10" readonly="readonly">
                                            <img height="16" border="0" width="16" id="Calendario2" name="Calendario2" src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" />
                                            <script type="text/javascript">
                                                Calendar.setup({
                                                    inputField     :    "fechaf",      // id del campo de texto
                                                    ifFormat       :    "%d/%m/%Y",       // formato de la fecha, cuando se escriba en el campo de texto
                                                    button         :    "Calendario2"   // el id del botón que lanzará el calendario
                                                });
                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="16%">Cargo</td>
                                        <td>
                                            <select id="cboCargo" name="cboCargo" class="comboMedio">
                                                <?php echo $cbo_cargo; ?>
                                            </select>
                                        </td>
                                        <td width="16%" style="display: none">Categoria de clientes</td>
                                        <td style="display: none">
                                            <select id="cboCategoria" name="cboCategoria" class="comboMedio">
                                                <?=$cbo_categoria;?>
                                            </select>


                                            <input name="contrato" type="hidden" class="cajaMedia" id="contrato" size="45" maxlength="50" value="<?=$contrato;?>"/>
                                        </td>
                                     <!--<tr>
                                        <td width="16%">Forma de pago</td>
                                        <td colspan="3">
                                           <select id="forma_pago" name="forma_pago" class="comboMedio">
                                        <?php //echo $cboFormaPago; ?>
                                           </select>
                                        </td>
                                     </tr>-->
                                    </tr>

                                    <tr>
                                        <td colspan="4">
                                            <input NAME="personacod" type="hidden" class="cajaMedia" id="personacod" size="45" maxlength="50" value="<?php echo $personacod; ?>" />
                                            <input id="modo" name="modo" type="hidden" value="<?php echo $modo; ?>">
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                        </td>
                                    </tr>
                                    <!--<tr>
                                       <td width="16%">Cta. Cte. Dolares</td>
                                       <td colspan="3">
                                          <input NAME="ctactedolares" type="text" class="cajaMedia" id="ctactedolares" size="45" maxlength="50" value="<?php //echo $datos->ctactedolares;                ?>" />
                                       </td>
                                    </tr>-->
                                </table>
                            </div>                    
                    </div>	  
                    <div id="datosContactos" style="display:none;">
                        <table id="tablaContacto" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="1">
                            <tr align="center" bgcolor="#BBBB20" height="10px;">
                                <td>Nro</td>
                                <td>Nombre del Contacto</td>
                                <td>Area</td>
                                <td>Cargo</td>
                                <td>Telefonos</td>
                                <td>E-mail</td>
                                <td>Borrar</td>
                                <td>Editar</td>
                            </tr>
                            <?php
                            $kk = 1;
                            $cantidad = count($listado_empresaContactos);
                            if ($cantidad > 0) {
                                foreach ($listado_empresaContactos as $indice => $valor) {
                                    $persona = $valor->persona;
                                    $telefono = $valor->telefono == '' ? '&nbsp;' : $valor->telefono;
                                    $movil = $valor->movil;
                                    $email = $valor->email == '' ? '&nbsp;' : $valor->email;
                                    if ($movil != '')
                                        $telefono = $telefono . "&nbsp;/" . $movil;
                                    ?>
                                    <tr bgcolor="#ffffff">
                                        <td align="center"><?php echo $kk; ?></td>
                                        <td align="left"><?php echo $valor->nombre_persona; ?></td>
                                        <td><?php echo $valor->nombre_area; ?></td>
                                        <td><?php echo $valor->nombre_cargo; ?></td>
                                        <td><?php echo $telefono; ?></td>
                                        <td><?php echo $valor->email; ?></td>
                                        <td align="center" <?php if ($modo == 'insertar') echo "style='display:none;'"; ?>>
                                            <a href="#" onclick="eliminar_contacto(<?php echo $persona; ?>);"><img src="<?php echo base_url(); ?>images/delete.gif?=<?=IMG;?>" border="0"></a>
                                        </td>
                                        <td align="center" <?php if ($modo == 'insertar') echo "style='display:none;'"; ?>>
                                            <div id="idEdit"><a href="#" onclick="editar_contacto(<?php echo $persona; ?>);"><img src="<?php echo base_url(); ?>images/edit.gif?=<?=IMG;?>" border="0"></a></div>
                                            <div id="idSave" style="display:none;"><a href="#"><img src="<?php echo base_url(); ?>images/save.gif?=<?=IMG;?>" border="0"></a></div>
                                        </td>
                                    </tr>						
                                    <?php
                                    $kk++;
                                }
                            }
                            ?>
                        </table>
                        <?php
                        $displayContactos = $cantidad != 0 ? "display:none;" : "";
                        ?>
                        <div id="msgRegistros" style="width:98%;text-align:center;height:20px;border:1px solid #000;<?php echo $displayContactos; ?>">NO EXISTEN REGISTROS</div>
                    </div>
                    <div id="datosSucursales" style="display:none;">
                        <table id="tablaSucursal" class="fuente8" width="98%" cellspacing="0" cellpadding="6" border="1">
                            <tr align="center" bgcolor="#BBBB20" height="10px;">
                                <td width="30">Nro</td>
                                <td width="70">Nombre</td>
                                <td width="120">Tipo Establecimiento</td>							
                                <td width="350">Direccion Sucursal (*)</td>
                                <td width="200">Departamento / Provincia / Distrito</td>
                                <td>Borrar</td>
                                <td colspan="2">Editar</td>
                            </tr>
                            <?php
                            $kk = 1;
                            $cantidad2 = count($listado_empresaSucursal);
                            if ($cantidad2 > 0) {
                                foreach ($listado_empresaSucursal as $indice => $valor) {
                                    $sucursal = $valor->sucursal;
                                    ?>
                                    <tr bgcolor="#ffffff">
                                        <td align="center"><?php echo $kk; ?></td>
                                        <td align="left"><?php echo $valor->descripcion; ?></td>
                                        <td><?php echo $valor->nombre_tipo; ?></td>							
                                        <td align="left"><?php echo $valor->direccion; ?></td>
                                        <td><?php echo $valor->des_ubigeo; ?></td>
                                        <td align="center" <?php if ($modo == 'insertar') echo "style='display:none;'"; ?>>
                                            <a href="#" onclick="eliminar_sucursal(<?php echo $sucursal; ?>);"><img src="<?php echo base_url(); ?>images/delete.gif?=<?=IMG;?>" border="0"></a>
                                        </td>
                                        <td align="center" <?php if ($modo == 'insertar') echo "style='display:none;'"; ?>>
                                            <div id="idEdit">
                                                <a href="#" onclick="editar_sucursal(<?php echo $sucursal; ?>);"><img src="<?php echo base_url(); ?>images/edit.gif?=<?=IMG;?>" border="0"></a>
                                            </div>
                                            <div id="idSave" style="display:none;"><a href="#"><img src="<?php echo base_url(); ?>images/save.gif?=<?=IMG;?>" border="0"></a></div>
                                        </td>
                                    </tr>						
                                    <?php
                                    $kk++;
                                }
                            }
                            ?>
                        </table>
                        <?php
                        $displaySucursal = $cantidad2 != '0' ? "display:none;" : "";
                        ?>
                        <div id="msgRegistros2" style="width:98%;text-align:center;height:20px;border:1px solid #000;<?php echo $displaySucursal; ?>">NO EXISTEN REGISTROS</div>
                    </div>
                    <div style="margin-top:20px; text-align: center">
                        <a href="#" id="imgGuardarDirectivo"><img src="<?php echo base_url(); ?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
                        <a href="#" id="imgLimpiarDirectivo"><img src="<?php echo base_url(); ?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
                        <a href="#" id="imgCancelarDirectivo"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
                        <input id="accion" name="accion" value="alta" type="hidden">
                        <input type="hidden" name="opcion" id="opcion" value="1">
                        <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
                        <input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_persona; ?>">					
                        <input type="hidden" name="empresa_persona" id="empresa_persona" value="<?php echo $datos->id; ?>" />
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
