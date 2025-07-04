<html>
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">
 <style>
        #mapa{
            width: 900px;
            height: 300px;
            background: green;
        }
        #infor{
            width: 400px;
            height: 400px;
            float:left;
        }
        
        #tablaG {
    		font-family: arial, sans-serif;
    		border-collapse: collapse;
    		width: 100%;
    		border-style: solid;
		}

		td, th {
    		border: 1px solid #dddddd;
    		text-align: left;
    		padding: 8px;
    		border-style: solid;
		}

    .bootstrap table th,
    .bootstrap table td {
      border : 1px solid transparent;
    }
    </style>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validate.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/maestros/proyecto.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/funciones.js?=<?=JS;?>"></script>
		<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
		<script>
  			function cargar_ubigeo(ubigeo,valor){
  			   $("#cboNacimiento").val(ubigeo);
  			   $("#cboNacimientovalue").val(valor);
  			}


			function editar_direccion(posicion){
				limpiarDireccion();
				
				a='descripcionDireccion['+posicion+']';
				b='referenciaDireccion['+posicion+']';
				
				c='cboDepartamentoD['+posicion+']';
				d='cboProvinciaD['+posicion+']';
				e='cboDistritoD['+posicion+']';
				
				f='cordenadaY['+posicion+']';
				g='cordenadaX['+posicion+']';
				
				h='direccionCodigo['+posicion+']';
				
				descripcion=document.getElementById(a).value;
 				referencia=document.getElementById(b).value;
				
				cboDepartamento=document.getElementById(c).value;
     			cboProvincia=document.getElementById(d).value;
     			cboDistrito=document.getElementById(e).value;
    			
     			cordY=document.getElementById(f).value;
    			cordX=document.getElementById(g).value;
    			codigoDireccion=document.getElementById(h).value;
				
				$('#descripcion').val(descripcion);
 				$('#referencia').val(referencia);
 				$('#cboDepartamento').val(cboDepartamento);
 				cargar_provincia(document.getElementById(c));
 				$('#cboProvincia').val(cboProvincia);
 				cargar_distrito(document.getElementById(d));
 				$('#cboDistrito').val(cboDistrito);
				$('#cordY').val(cordY);
 				$('#cordX').val(cordX);
 				
 				$('#codigoDireccion').val(codigoDireccion);
 				$('#posicionEditar').val(posicion);
 				
 				mostrarMapasPrevia(3);
			}

			function mostrarMapasPrevia(tipo){
				if(tipo==0 || tipo==3){
				idLcordY=$('#cordY').val();
				$('#idLcordY').html(idLcordY);	
				}
				
				if(tipo==1 || tipo==3){
					idLcordX=$('#cordX').val();
					$('#idLcordX').html(idLcordX);
				}
				

			}

			
  		</script>
  		<script>
			//VARIABLES GENERALES
			//declaras fuera del ready de jquery
			var nuevos_marcadores = [];
			//FUNCION PARA QUITAR MARCADORES DE MAPA
			function limpiar_marcadores(lista){
				for(i in lista){
			//QUITAR MARCADOR DEL MAPA
				lista[i].setMap(null);
				}
			}
			$(document).on("ready", function(){
			//VARIABLE DE FORMULARIO
			var formulario = $("#frmProyecto");
			var punto = new google.maps.LatLng(-13.163622,-72.545926);
			var config = {
				zoom:16,
				center:punto,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var mapa = new google.maps.Map( $("#mapa")[0], config );
			  google.maps.event.addListener(mapa, "click", function(event){
				var coordenadas = event.latLng.toString();
				coordenadas = coordenadas.replace("(", "");
				coordenadas = coordenadas.replace(")", "");
				var lista = coordenadas.split(",");
				var direccion = new google.maps.LatLng(lista[0], lista[1]);
				//PASAR LA INFORMACI覰 AL FORMULARIO
				formulario.find("input[name='cordeX']").val(lista[0]);
				formulario.find("input[name='cordeY']").val(lista[1]);
				var marcador = new google.maps.Marker({
				//titulo:prompt("Titulo del marcador?"),
					position:direccion,
					map: mapa,
					animation:google.maps.Animation.DROP,
					draggable:false
				});
				//ALMACENAR UN MARCADOR EN EL ARRAY nuevos_marcadores
				nuevos_marcadores.push(marcador);
				google.maps.event.addListener(marcador, "click", function(){
				});
				//BORRAR MARCADORES NUEVOS
				limpiar_marcadores(nuevos_marcadores);
				marcador.setMap(mapa);
		  	});
		 });
</script>
</head>
<body>
<!-- Inicio -->
<div id="VentanaTransparente" style="display:none;">
  <div class="overlay_absolute"></div>
  <div id="cargador" style="z-index:2000">
    <input type="hidden" id="id-proyecto" value="<?php echo $id_proyecto ?>">
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
				<form id="frmProyecto" name="frmProyecto" method="post" action='<?php echo $url_action; ?>'>
					<div id="container" class="container">
						<ol>
						<h4>Primero debe completar los siguientes campos antes de enviar.</h4>						
							<div id="containerProyecto">								
							</div>
						</ol>
					</div>
					<div id="tabs">
  						<ul>
    						<li><a href="#tabs-1">Proyecto</a></li>
    						<li><a href="#tabs-2">Direcciones</a></li>
                <?php if($modo == "modificar"): ?>
                <li><a onclick="verEstados()" href="#tabs-3">Estado</a></li>
                <li><a onclick="verBalance()" href="#tabs-4">Balance</a></li>
                <?php endif; ?>
  						</ul>
  						<div id="tabs-1">
                <div id="datosProyecto" >
                  <table class="fuente8" style="width:100% !important">
                    <tr>
                      <td>Nombre del Proyecto</td>
                      <td>
                        <input name="nombreProyecto" type="text" class="cajaGrande" id="nombres" maxlength="150" value="<?php echo $nombreProyecto;?>">
                      </td>
                    </tr>
                    <tr>
                      <td>Descripcion</td>
                      <td>                                 
                        <textarea name="descpProyecto" id="descpProyecto" cols="45" rows="5"><?php echo $descpProyecto;?></textarea>
                      </td>
                    </tr>
                    <tr>
                      <td>Cliente</td>
                      <td>
                        <select name="cbo_clientes" id="cboClientes" class="comboMedio">
                          <?php echo $cbo_clientes;?>
                        </select>
                      </td>
                    </tr>
                    <tr>
                      <td align='left' width="15%">Fecha inicial</td>
                      <td align='left' width="15%">
                        <?php echo $fechai?>
                        <img src="<?php echo base_url();?>images/calendario.png?=<?=IMG;?>" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                        <script type="text/javascript">
                          Calendar.setup({
                            inputField     :    "fechai",      // id del campo de texto
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "Calendario1"   // el id del bot贸n que lanzar谩 el calendario
                          });
                        </script>
                      </td>
                      <td align='left' width="10%">Fecha final</td>
                      <td align='left' width="60%">
                        <?php echo $fechaf?>
                        <img src="<?php echo base_url();?>images/calendario.png?=<?=IMG;?>" name="Calendario2" id="Calendario2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                        <script type="text/javascript">
                          Calendar.setup({
                            inputField     :    "fechaf",      // id del campo de texto
                            ifFormat       :    "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                            button         :    "Calendario2"   // el id del bot贸n que lanzar谩 el calendario
                          });
                        </script>
                      </td>
                    </tr>
                  </table >
                </div>
              </div>
              <div id="tabs-2">  
                <div id="datosDireccion" >
                  <table class="fuente8" style="width:100% !important">
                    <tr>
                      <td>Direcci&#243;n</td>
                      <td>
                        <input type="hidden" name="codigoDireccion" id="codigoDireccion" value="0"  />
                        <input type="hidden" name="posicionEditar" id="posicionEditar"  />
                        <input name="descripcion" type="text" class="cajaGrande" id="descripcion" maxlength="150" value="<?php echo $descripcionDireccion;?>">
                      </td>
                    </tr>
                    <tr>
                      <td>Referencia</td>
                      <td>
                        <input name="referencia" type="text" class="cajaGrande" id="referencia" maxlength="150" value="<?php echo $referenciaDireccion;?>">
                      </td>
                    </tr>
                    <tr>
                      <td>Departamento&nbsp;</td>
                      <td colspan="3">
                        <div id="divUbigeo">
                          <select id="cboDepartamento" name="cboDepartamento" class="comboMedio" onchange="cargar_provincia(this);">
                            <?php echo $cboDepartamento; ?>
                          </select>&nbsp; &nbsp;
                          Provincia&nbsp;&nbsp; &nbsp;
                          <select id="cboProvincia" name="cboProvincia" class="comboMedio" onchange="cargar_distrito(this);">
                            <?php echo $cboProvincia; ?>
                          </select>&nbsp; &nbsp;
                          Distrito&nbsp;&nbsp; &nbsp;
                          <select id="cboDistrito" name="cboDistrito" class="comboMedio">
                            <?php echo $cboDistrito; ?>
                          </select>
                        </div>
                      </td>
                    </tr>
                    <tr>
                      <td>Mapa</td>
                      <td colspan="2">
                        <textarea name="cordeY"  id="cordY" rows="10" cols="50" onblur="mostrarMapasPrevia(0)">
                        </textarea>
                      <td>
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <label id="idLcordY"></label>
                      <td>
                    </tr>
                    <tr>
                      <td>Calle</td>
                      <td colspan="2">
                        <textarea name="cordX" id="cordX" rows="10" cols="50" onblur="mostrarMapasPrevia(1)">
                        </textarea>
                       <td>	
                    </tr>
                    <tr>
                      <td></td>
                      <td colspan="2">
                        <label id="idLcordX"></label>
                      <td>
                    </tr>
                    <tr>
                      <td colspan="2" >
                        <div style="margin-top:20px; text-align: center">
                          <a href="javascript:;" onClick="agregar_direccion_proyecto();"><img src="<?php echo base_url(); ?>images/botonagregar.jpg?=<?=IMG;?>" border="1" align="absbottom"></a>
                           <a href="javascript:;" onClick="limpiarDireccion();"><img src="<?php echo base_url(); ?>images/botoncancelar.jpg?=<?=IMG;?>" border="1" align="absbottom"></a>
                        </div>
                      </td>
                    </tr>
                  </table>
                  <div id="frmBusqueda" style="width:100% !important">
                    <table class="fuente8" style="width:100% !important" >
                      <tr class="cabeceraTabla">
                        <td width="2%">
                          <div align="center">&nbsp;</div>
                        </td>
                        <td width="2%">
                          <div align="center">ITEM</div>
                        </td>
                        <td width="5%">
                          <div align="center">DIRECCION</div>
                        </td>
                        <td width="5%">
                          <div align="center">REFERENCIA</div>
                        </td>
                        <td width="10%">
                          <div align="center">DEPARTAMENTO / PROVINCIA /DISTRITO</div>

                        </td>
                        <td width="5%">
                          <div align="center">Acciones</div>
                        </td>
                      </tr>
                    </table>
                    <div>
                      <table id="tblDetalleDireccionProyecto" class="fuente8" style="width:100% !important" >
                       <?php
                       if (count($detalle_direccion) > 0) {
                        foreach ($detalle_direccion as $indice => $valor) {
                         $direccionCodigo = $valor->DIRECC_Codigo;
                         $descripcionDireccion = $valor->DIRECC_Descrip;
                         $referenciaDireccion = $valor->DIRECC_Referen;
                         $ubigeo_domicilio = $valor->UBIGP_Domicilio;
                         $cboDepartamento = substr($ubigeo_domicilio, 0, 2);
                         $cboProvincia = substr($ubigeo_domicilio, 2, 2);
                         $cboDistrito = substr($ubigeo_domicilio, 4, 2);
                         $cordenadaX = $valor->DIRECC_Mapa;
                         $cordenadaY = $valor->DIRECC_StreetView;
                         if (($indice + 1) % 2 == 0) {
                          $clase = "itemParTabla";
                        } else {
                          $clase = "itemImparTabla";
                        }
                        ?>
                        <tr>
                          <td width="2%">
                            <div align="center"  style="width: 70%;" >
                              <font color="red"  style="width: 100%;" >
                                <strong>
                                  <a href="javascript:;" onclick="eliminar_direccion(<?php echo $indice; ?>);">
                                    <span style="border:1px solid red;background: #ffffff;">&nbsp;X&nbsp;</span>
                                  </a>
                                </strong>
                              </font>
                            </div>
                          </td>
                          <td width="2%"> <?php  echo $indice; ?></td>
                          <input type="hidden" name="direccionCodigo[<?php echo $indice; ?>]" id="direccionCodigo[<?php echo $indice; ?>]" value="<?php echo $direccionCodigo; ?>" />
                          <td width="5%"> 
                            <div align="left" style="width: 60%;" >
                              <label id="idlDescripcionDireccion<?php echo $indice; ?>" ><?php echo $descripcionDireccion; ?></label>
                              <input type="hidden" maxlength="250" name="descripcionDireccion[<?php echo $indice; ?>]" id="descripcionDireccion[<?php echo $indice; ?>]" value="<?php echo $descripcionDireccion; ?>"/>
                            </div>
                          </td>
                          <td width="5%">
                            <div align="left"  style="width: 60%;" >
                              <label id="idlReferenciaDireccion<?php echo $indice; ?>"><?php echo $referenciaDireccion; ?></label>
                              <input type="hidden" 
                              maxlength="250" name="referenciaDireccion[<?php echo $indice; ?>]"
                              id="referenciaDireccion[<?php echo $indice; ?>]"
                              value="<?php echo $referenciaDireccion; ?>"/>
                            </div>
                          </td>
                          <td width="10%">
                            <input type="hidden" maxlength="250" name="cboDepartamentoD[<?php echo $indice; ?>]" id="cboDepartamentoD[<?php echo $indice; ?>]" value="<?php echo $cboDepartamento; ?>"/>
                            <input type="hidden" maxlength="250" name="cboProvinciaD[<?php echo $indice; ?>]" id="cboProvinciaD[<?php echo $indice; ?>]" value="<?php echo $cboProvincia; ?>"/>
                            <input type="hidden" maxlength="250" name="cboDistritoD[<?php echo $indice; ?>]" id="cboDistritoD[<?php echo $indice; ?>]" value="<?php echo $cboDistrito; ?>"/>	
                            <label id="idlNombresUbigeo<?php echo $indice; ?>"><?php  echo $nombreDepartamentoD[$indice].' / '.$nombreProvinciaD[$indice].' / '.$nombreDistritoD[$indice];?></label>
                            <textarea name="cordenadaX[<?php echo $indice; ?>]" style="display:none;" id="cordenadaX[<?php echo $indice; ?>]">
                              <?php echo $cordenadaX; ?>
                            </textarea>
                            <textarea name="cordenadaY[<?php echo $indice; ?>]" style="display:none;" id="cordenadaY[<?php echo $indice; ?>]">
                              <?php echo $cordenadaY; ?>
                            </textarea>
                            <input type="hidden" name="direaccion[<?php echo $indice; ?>]" id="direaccion[<?php echo $indice; ?>]" value="m"/>
                          </td>
                          <td width="5%">
                            <div align="left"  style="width: 60%;" >
                              <a href='javascript:;' onclick='editar_direccion(<?php echo $indice; ?>)'>
                                <img src='<?php echo base_url(); ?>images/modificar.png?=<?=IMG;?>' width='16' height='16' border='0' title='Modificar'>
                              </a>
                            </div>
                          </td>
                        </tr>

                        <?php }} ?>                            			
                      </table>
                    </div>
                  </div>
                </div>
              </div>
              <?php if($modo =="modificar"): ?>
              <div class="bootstrap" id="tabs-3" align="left">
                <div>
                  <h3 style="text-transform: uppercase;">Ordenes de venta</h3>
                  <div style="max-height: 400px;overflow-y: auto;">
                    <div class="loading">Cargando ...</div>
                    <table width="100%" class="table table-hover table-condensed" style="font-size: 1rem;" id="tblOrdenesVenta">
                      <colgroup>
                        <col span="4">
                        <col span="2" style="background-color: #f5f5f5;">
                        <col span="2">
                        <col span="2" style="background-color: #f5f5f5;">
                      </colgroup>
                      <thead>
                        <tr>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;">CLIENTE</th>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;"><div align="center">O.V.</div></th>
                          <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle;">MONTO</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">CONVERSION</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">FACTURACION (USD)</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">PAGOS (USD)</th>
                        </tr>
                        <tr>
                          <th style="text-align: center;vertical-align: middle;">SOLES</th>
                          <th style="text-align: center;vertical-align: middle;">DOLARES</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot style="font-weight: bold;">
                        <tr>
                          <td colspan="4" style="text-align: center;vertical-align: middle;"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-soles"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-dolares"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado-saldo"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado-saldo"></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <hr>
                <div>
                  <h3 style="text-transform: uppercase;">Ordenes de Compra</h3>
                  <div style="max-height: 400px;overflow-y: auto;">
                    <div class="loading">Cargando ...</div>
                    <table width="100%" class="table table-hover table-condensed" style="font-size: 1rem;" id="tblOrdenesCompra">
                      <colgroup>
                        <col span="4">
                        <col span="2" style="background-color: #f5f5f5;">
                        <col span="2">
                        <col span="2" style="background-color: #f5f5f5;">
                      </colgroup>
                      <thead>
                        <tr>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;">PROVEEDOR</th>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;"><div align="center">O.C.</div></th>
                          <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle;">MONTO</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">CONVERSION</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">FACTURACION (USD)</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">PAGOS (USD)</th>
                        </tr>
                        <tr>
                          <th style="text-align: center;vertical-align: middle;">SOLES</th>
                          <th style="text-align: center;vertical-align: middle;">DOLARES</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot style="font-weight: bold;">
                        <tr>
                          <td colspan="4" style="text-align: center;vertical-align: middle;"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-soles"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-dolares"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado-saldo"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado-saldo"></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <hr>
                <div>
                  <h3 style="text-transform: uppercase;">Ordenes de servicio</h3>
                  <div style="max-height: 400px;overflow-y: auto;">
                    <div class="loading">Cargando ...</div>
                    <table width="100%" class="table table-hover table-condensed" style="font-size: 1rem;" id="tblOrdenesServicio">
                      <colgroup>
                        <col span="4">
                        <col span="2" style="background-color: #f5f5f5;">
                        <col span="2">
                        <col span="2" style="background-color: #f5f5f5;">
                      </colgroup>
                      <thead>
                        <tr>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;">PROVEEDOR</th>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;"><div align="center">O.S.</div></th>
                          <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle;">MONTO</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">CONVERSION</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">FACTURACION (USD)</th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">PAGOS (USD)</th>
                        </tr>
                        <tr>
                          <th style="text-align: center;vertical-align: middle;">SOLES</th>
                          <th style="text-align: center;vertical-align: middle;">DOLARES</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">SALDO</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot style="font-weight: bold;">
                        <tr>
                          <td colspan="4" style="text-align: center;vertical-align: middle;"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-soles"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-conv-dolares"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-facturado-saldo"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-pagado-saldo"></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <div id="tabs-4" align="left">
                <div class="bootstrap">
                  <div>
                    <div class="loading">Cargando ...</div>
                    <table width="100%" class="table table-hover table-condensed" style="font-size: 1rem;" id="tblBalance">
                      <colgroup>
                        <col span="5">
                        <col span="3" style="background-color: #f5f5f5;">
                      </colgroup>
                      <thead>
                        <tr>
                          <th rowspan="2" style="text-align: center;vertical-align: middle;">CLIENTE</th>
                          <th rowspan="2" colspan="2" style="text-align: center;vertical-align: middle;"><div align="center">O.V.</div></th>
                          <th colspan="2" style="text-align: center;vertical-align: middle;">PRECIO (USD)</th>
                          <th colspan="3" style="text-align: center;vertical-align: middle;">BALANCE</th>
                        </tr>
                        <tr>
                          <th style="text-align: center;vertical-align: middle;">UNITARIO</th>
                          <th style="text-align: center;vertical-align: middle;">TOTAL</th>
                          <th style="text-align: center;vertical-align: middle;">INGRESOS</th>
                          <th style="text-align: center;vertical-align: middle;">EGRESOS</th>
                          <th style="text-align: center;vertical-align: middle;">UTILIDAD</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot style="font-weight: bold;border-top: 2px solid #000000;">
                        <tr>
                          <td colspan="4" style="text-align: center;vertical-align: middle;"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-precio-dolares"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-ingresos"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-egresos"></td>
                          <td style="text-align: right;vertical-align: middle;" class="total-liquidez"></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
              <?php endif; ?>
                    
                    <div id="nuevoRegistro" style="display:none;float:right;width:150px;height:20px;border:0px solid #000;margin-top:7px;">
                    	<a href="#">Nuevo <image src="<?php echo base_url();?>images/add.png?=<?=IMG;?>" name="agregarFila" id="agregarFila" border="0" alt="Agregar"></a>
                    </div><br><br>				
           
                <div id="datosProyecto" >
		 		</div>
				<div style="margin-top:20px; text-align: center">
                    <a href="#" id="imgGuardarProyecto"><img src="<?php echo base_url();?>images/botonaceptar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgLimpiarProyecto"><img src="<?php echo base_url();?>images/botonlimpiar.jpg?=<?=IMG;?>" width="69" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<a href="#" id="imgCancelarProyecto"><img src="<?php echo base_url();?>images/botoncancelar.jpg?=<?=IMG;?>" width="85" height="22" class="imgBoton" onMouseOver="style.cursor=cursor"></a>
					<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
                    <input id="modo" name="modo" type="hidden" value="<?php echo $modo;?>">                                       
                    <input type="hidden" name="proyecto" id="proyecto" value="<?php echo $datos->id; ?>" />
                </div>
			  </form>
		  </div>
		  </div>
		</div></div>
	</body>
</html>

<script>
  $( function() {
          $( "#tabs" ).tabs();
        } );
</script>