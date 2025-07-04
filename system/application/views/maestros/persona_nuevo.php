<html>
	<head>	
        <script type="text/javascript" src="<?php echo base_url();?>js/jquery.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.metadata.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/maestros/persona.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js?=<?=JS;?>"></script>		
		<script type="text/javascript">		
		function cargar_ubigeo(ubigeo,valor){
		   $("#cboNacimiento").val(ubigeo);
		   $("#cboNacimientovalue").val(valor);
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
			<td><img src="<?php echo base_url();?>images/cargando.gif?=<?=IMG;?>"  border="0" title="CARGANDO" /><a href="#" id="hider2"></a>	</td>
		</tr>
    </table>
  </div>
</div>
	<div id="pagina">

			<div id="zonaContenido">
				<div align="center">
				<div id="tituloForm" class="header"><?php echo $titulo;?></div>
				<div id="frmBusqueda">
				<form id="frmPersona" name="frmPersona" method="post" action="">
					<div id="container" class="container">
						<ol>
						<h4>Primero debe completar los siguientes campos antes de enviar.</h4>						
							<div id="containerPersona">
								<li><label for="nombres" class="error">Por favor ingrese el nombre de la persona.</label></li>
								<li><label for="paterno" class="error">Por favor ingrese el apellido de la persoa.</label></li>
								<li><label for="email" class="error">Por favor ingrese el correo de la persona.</label></li>
								<li><label for="tipo_documento" class="error">Por favor seleccione un tipo de documento.</label></li>
								<li><label for="cboSexo" class="error">Por favor seleccione el sexo de la persona.</label></li>
								<li><label for="cboNacionalidad" class="error">Por favor seleccione una nacionalidad.</label></li>
							</div>
						</ol>
					</div>					
                    
                    <div id="nuevoRegistro" style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;"><a href="#">Nuevo <image src="<?php echo base_url();?>images/add.png?=<?=IMG;?>" name="agregarFila" id="agregarFila" border="0" alt="Agregar"></a></div>			 <div align="left" class="fuente8" style="float:left;border: 0px solid #000;margin-left: 15px;width: 100%;">
                      <?php
                     if($datos->id!="" || $datos->id!="" ){
                        ?>
                        <a href="#" id="idGeneral">&nbsp;&nbsp;General&nbsp;&nbsp;&nbsp;</a>&nbsp;
                        <a href="#" id="idCuentas">|&nbsp;&nbsp;Cuentas&nbsp;&nbsp;&nbsp;</a>&nbsp;
                        <?php
                      }
                        ?> 
<input type="hidden" name="personaCodigo" id="personaCodigo"  value="<?=$datos->id?>">   
<input type="hidden" name="indentifPersona" id="indentifPersona" value="<?=$indetif?>">
<input type="hidden" name="txtModificar" id="txtModificar" value="<?=$datos->id?>">


                </div>   
					<div id="datosGenerales">

                     
                      
                       <div id="datosPersona" >
                    
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                                <tr>
                                    <td width="16%">Tipo de Documento&nbsp;(*)</td>
                                    <td>
                                        <select id="tipo_documento" name="tipo_documento" class="comboMedio" onchange="valida_tipoDocumento();">
                                           <?php echo $tipo_documento;?>
                                        </select>
                                    </td>
                                  <td>Número de Documento</td>
                                  <td><input name="numero_documento" type="text" class="cajaMedia" id="numero_documento" size="15" maxlength="8" value="<?php echo $numero_documento;?>" onkeypress="return numbersonly('numero_documento',event);">
                                  </td>
                                </tr>
                                <tr>
                                  <td>Nombres&nbsp;(*)</td>
                                  <td>
                                      <input id="nombres" type="text" class="cajaGrande" name="nombres" maxlength="45" value="<?php echo $nombres;?>">
                                  </td>
                                  <td>Lugar de Nacimiento</td>
                                  <td>
                                      <input type="hidden" name="cboNacimiento" id="cboNacimiento" class="cajaMedia" value="<?php echo $cboNacimiento;?>"/>
                                      <input type="text" name="cboNacimientovalue" id="cboNacimientovalue" class="cajaMedia" readonly="readonly" value="<?php echo $cboNacimientovalue;?>" ondblclick="abrir_formulario_ubigeo();"/>
                                      <a href="#" onclick="abrir_formulario_ubigeo();"><image src="<?php echo base_url();?>images/ver.png?=<?=IMG;?>" border='0'></a>
                                  </td>
                                </tr>
                                <tr>
                                    <td>Apellidos Paterno&nbsp;(*)</td>
                                    <td><input NAME="paterno" type="text" class="cajaGrande" id="paterno" size="45" maxlength="45" value="<?php echo $paterno;?>"></td>
                                  <td>Sexo&nbsp;(*)</td>
                                  <td>
                                      <select name="cboSexo" id="cboSexo" class="comboMedio">
                                          <option value=''>::Seleccione::</option>
										  <option value='0' <?php if($sexo=='0') echo "selected='selected'";?>>MASCULINO</option>
										  <option value='1' <?php if($sexo=='1') echo "selected='selected'";?>>FEMENINO</option>
                                      </select>
                                  </td>
                                </tr>
                                <tr>
                                    <td>Apellidos Materno</td>
                                    <td><input NAME="materno" type="text" class="cajaGrande" id="materno" size="45" maxlength="45" value="<?php echo $materno;?>"></td>
                                  <td>Estado Civil</td>
                                  <td>
                                      <select name="cboEstadoCivil" id="cboEstadoCivil" class="comboMedio">
                                          <?php echo $cbo_estadoCivil;?>
                                      </select>
                                  </td>

                                </tr>
                                
                                <tr>
                                  <td>Nacionalidad&nbsp;(*)</td>
                                  <td>
                                      <select name="cboNacionalidad" id="cboNacionalidad" class="comboMedio">
                                          <?php echo $cbo_nacionalidad;?>
                                      </select>
                                  </td>
                                   <td>RUC</td>   
                                   <td><input id="ruc_persona" type="text" class="cajaMedia" name="ruc_persona" size="45" maxlength="11" value="<?php echo $ruc;?>"></td>
                                </tr>
                        </table>
                        </div>
			  <div id="divDireccion">
                        <table class="fuente8" width="98%" cellspacing="0" cellpadding="4" border="0">
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                            <tr><td>Departamento&nbsp;</td>
                              <td colspan="3">							  	<div id="divUbigeo">
                                    <select id="cboDepartamento" name="cboDepartamento" class="comboMedio" onchange="cargar_provincia(this);">
                                        <?php echo $cbo_dpto;?>
                                    </select>&nbsp;	&nbsp;
                                    Provincia&nbsp;&nbsp;	&nbsp;
                                    <select id="cboProvincia" name="cboProvincia" class="comboMedio" onchange="cargar_distrito(this);">
                                        <?php echo $cbo_prov;?>
                                    </select>&nbsp;	&nbsp;
                                    Distrito&nbsp;&nbsp;	&nbsp;
                                    <select id="cboDistrito" name="cboDistrito" class="comboMedio">
                                        <?php echo $cbo_dist;?>
                                    </select>
								</div>
                              </td>
                          </tr>
                            <tr>
                              <td width="16%">Direcci&oacute;n fiscal</td>
                              <td colspan="3"><input NAME="direccion" type="text" class="cajaSuperGrande" id="direccion" size="45" maxlength="100" value="<?php echo $datos->direccion;?>" />
                              TIPO VIA / NOMBRE VIA / N° / INTERIOR / ZONA
                              </td>
                           </tr>
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                          <tr>
                            <td colspan="4">
                                <table width="100%" class="fuente8" cellspacing=0 cellpadding=3 border="0">
                                    <tr>
                                        <td width="16%">Tel&eacute;fono </td>
                                        <td><input id="telefono" name="telefono" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->telefono;?>"></td>
                                        <td>M&oacute;vil</td>
                                        <td><input id="movil" name="movil" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->movil;?>"></td>
                                        <td>Fax</td>
                                        <td><input id="fax" name="fax" type="text" class="cajaPequena" maxlength="15" value="<?php echo $datos->fax;?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Correo electr&oacute;nico  </td>
                                        <td><input NAME="email" type="text" class="cajaGrande" id="email" size="35" maxlength="50" value="<?php echo $datos->email;?>"></td>
                                        <td>Direcci&oacute;n web </td>
                                        <td colspan="3">
                                                <input NAME="web" type="text" class="cajaGrande" id="web" size="45" maxlength="50" value="<?php echo $datos->web;?>">
                                        </td>
                                    </tr>
                                </table>
                            </td>
                          </tr>
                          <tr height="10px">
                            <td colspan="4"><hr></td>
                          </tr>
                          <tr>
                              <td width="16%">Cta. Cte. Soles</td>
                              <td colspan="3">
                                 <input NAME="ctactesoles" type="text" class="cajaMedia" id="ctactesoles" size="45" maxlength="50" value="<?php echo $datos->ctactesoles;?>" />
                              </td>
                           </tr>
                           <tr>
                              <td width="16%">Cta. Cte. Dolares</td>
                              <td colspan="3">
                                 <input NAME="ctactedolares" type="text" class="cajaMedia" id="ctactedolares" size="45" maxlength="50" value="<?php echo $datos->ctactedolares;?>" />
                              </td>
                           </tr>
                        </table>
                  </div>
				 </div>	  
				<div style="margin-top:20px; text-align: center">
                                        <a href="#" id="imgGuardarPersona"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgLimpiarPersona"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgCancelarPersona"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<input id="accion" name="accion" value="alta" type="hidden">
					<input id="modo" name="modo" type="hidden" value="<?php echo $modo;?>">
					<input type="hidden" name="opcion" id="opcion" value="1">
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
					<input type="hidden" id="tipo" name="tipo" value="<?php echo $tipo_persona;?>">
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>">

         <input type="hidden" name="persona" id="persona" value="<?php echo $datos->id; ?>" />
                                </div>

                                <div id="popup" style="display: none; ">
    <div class="content-popup">

        <div class="close"><a href="#" id="close"><img src="<?=base_url()?>images/icono_desaprobar.png?=<?=IMG;?>"/></a></div>
        <div>
           <h2>Registro de Chekera</h2>
          <table border="0" width="100%">
<tr>
  <td>Cuenta Empresa</td>
  <td>
  <input type="hidden" name="txtCodCuentaEmpre" id="txtCodCuentaEmpre" />
  <input type="text" name="txtnumeroEmpr" id="txtnumeroEmpr" disabled="disabled"/>
</td>
   <td>Moneda</td>
   <td>
    <input name="txtMonedaChekera" id="txtMonedaChekera" disabled="disabled">
   </td>
</tr>
<tr>
<td>Numero</td>
<td>
 <input maxlength="6" name="txtSerieChekera"  id="txtSerieChekera" type="text" size="4"   onkeypress="return soloLetras_andNumero(event)" autofocus/>
 <input maxlength="10" name="txtNumeroChek"   id="txtNumeroChek"   type="text" size="10"   onkeypress="return soloLetras_andNumero(event)">
</td>
<td colspan="2">
  <a href="#" onclick="insertChekera()"><img src="<?=base_url()?>images/botonagregar.jpg?=<?=IMG;?>"></a>
  <a href="#" id="LimpiarChikera"><img src="<?=base_url()?>images/botoncancelar.jpg?=<?=IMG;?>"></a>
</td>
</tr></table>
<div id="contenedorTableChekera">
<table id="tablechekera" width="100%"
 cellpadding="6" border="0" >
 <thead>
 <tr style="background-color:#5F5F5F;color:#ffffff;font-weight: bold;">
<td>Item</td>
<td>Fecha</td>
<td>Cuenta Empresa</td>
<td>Serie</td>
<td>Numero</td>
<td>Accion</td>
 </tr>
 </thead>
 <tbody id="listarChekera" style="color:black">
<tr>
</tr>
</tbody>
</table>
</div>
</div>
</div>
</div>
<style type="text/css">
.paging-nav {
  text-align: right;
  padding-top: 2px;
}

.paging-nav a {
  margin: auto 1px;
  text-decoration: none;
  display: inline-block;
  padding: 1px 7px;
  background: #91b9e6;
  color: white;
  border-radius: 3px;
}

.paging-nav .selected-page {
  background: #187ed5;
  font-weight: bold;
}

#popup {
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 1001;

}

.content-popup {
    margin:0px auto;
    margin-top:-5%;
    position:relative;
    padding:10px;
    width:50%;
    min-height:250px;
    border-radius:4px;
    background-color:#f5fffd;
    box-shadow: 0 2px 5px #666666;
}

.content-popup h2 {
    color:#48484B;
    border-bottom: 1px solid #48484B;
    margin-top: 0;
    padding-bottom: 4px;
}

.popup-overlay {
    left: 0;
    position: absolute;
    top: 0;
    width: 100%;
    z-index: 999;
    display:none;
    background-color: #777777;
    cursor: pointer;
    opacity: 0.7;
}

.close {
    position: absolute;
    right: 15px;
}
          </style>
			  </form>
		  </div>
		  </div>
		</div></div>
	</body>
</html>