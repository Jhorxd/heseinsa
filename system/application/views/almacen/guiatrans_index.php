<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/guiatrans.js?=<?=JS;?>"></script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
<input id="compkardex" name="compkardex" type="hidden" class="" maxlength="30" value="<?=$compkardex;?>">           
<form id="form_busqueda" name="form_busqueda" method="post" >
	<div class="row">
		<div class="col-sm-2 col-md-2 col-lg-2 form-group">
			<label for="fechai">Fecha inicio: </label>
			<input id="fechai" name="fechai" type="date" class="form-control w-porc-90 h-1" placeholder="fecha inicial" maxlength="30" value="<?=$fechai;?>">
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2 form-group">
			<label for="fechaf">Fecha fin: </label>
			<input id="fechaf" name="fechaf" type="date" class="form-control w-porc-90 h-1" maxlength="100" placeholder="fecha fin" value="<?php echo $fechaf; ?>">
		</div>
	
		<div class="col-sm-2 col-md-2 col-lg-2 form-group">
			<label for="serie">Serie: </label>
			<input id="serie" name="serie" type="text" class="form-control w-porc-90 h-1" maxlength="8" placeholder="SERIE" value="<?php echo $serie; ?>">
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
			<label for="numero">Numero: </label>
			<input id="numero" type="text" class="form-control w-porc-90 h-1" name="numero" maxlength="100" placeholder="NUMERO" value="<?=$numero;?>">
		</div>
		<div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
		<label for="movimiento">Movimiento: </label>
		 	<select class="form-control w-porc-90 h-2" name="movimiento" id="movimiento" >
          <option value="">TODOS</option>
          <option value="0">Pendiente</option>
          <option value="1">Enviado/Transito</option>
          <option value="2">Recibido</option>
          <option value="3">Devolucion</option>
      </select>
		</div>
		
		<input id="codigoInterno" name="codigoInterno" type="hidden" class="cajaGrande" maxlength="100" placeholder="Codigo original" value="<?=$codigoInterno;?>">
	</div>
</form>
                
           
            <div class="acciones">
                <span id="mensajeTransferencia" style="margin-top: 10px"></span>

                <div id="botonBusqueda">
                   
                    <ul id="nuevaGuiatrans" class="lista_botones">
                        <li id="nuevo">Nueva</li>
                    </ul>
                    <ul id="limpiarG" class="lista_botones">
                        <li id="limpiar">Limpiar</li>
                    </ul>
                    <ul id="buscarG" class="lista_botones">
                        <li id="buscar">Buscar</li>
                    </ul>
                </div>
            </div>
            <div id="cabeceraResultado" class="header"><label style="margin-right:140px;">TRANSFERENCIAS
                    REALIZADAS</label> <label style="margin-left:135px;">TRANSFERENCIAS RECIBIDAS</label></div>
            <div id="frmResultado" class="row">
                <div style="width:40%; float: left;">
                   <table class="fuente8 " id="table-guiatrans-salida" data-page-length='25'>
                        <thead>
                            <tr class="cabeceraTabla">
                                <th style="width: 15%" >FECHA</th>
                                <th style="width: 10%" >SERIE</th>
                                <th style="width: 10%" >NUMERO</th>
                                <th style="width: 30%" >ALMACEN DESTINO</th>
                                <th style="width: 20%" >MOVIMIENTO</th>
                                <th style="width: 5%" ></th>
                                <th style="width: 5%" ></th>
                                <th style="width: 5%" ></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div style="width:45%; float: right;">
                    <table class="fuente8 " id="table-guiatrans-ingreso" data-page-length='25'>
                        <thead>
                            <tr class="cabeceraTabla">
                                <th style="width: 15%" >FECHA</th>
                                <th style="width: 10%" >SERIE</th>
                                <th style="width: 15%" >NUMERO</th>
                                <th style="width: 30%" >ALMACEN ORIGEN</th>
                                <th style="width: 20%" >MOVIMIENTO</th>
                                <th style="width: 10%" ></th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <?php echo $oculto; ?>
            
        </div>
         </div>
    </div>

  <script type="text/javascript">
  	$(document).ready(function() {
  	    $('#table-guiatrans-salida').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_salida/",
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                    },
                    error: function(){
                    }
            },
            language: spanish
        });
        $('#table-guiatrans-ingreso').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_ingreso/",
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                    },
                    error: function(){
                    }
            },
            language: spanish
        });

        $("#buscarG").click(function(){
            fechai 			= $('#fechai').val();
            fechaf 			= $('#fechaf').val();
            serie 			= $('#serie').val();
            numero 			= $('#numero').val();
            movimiento 	= $('#movimiento').val();

            $('#table-guiatrans-salida').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_salida/",
                        type: "POST",
                        data: { fechai: fechai, fechaf: fechaf, serie: serie, numero: numero, movimiento: movimiento },
                        error: function(){
                        }
                },
                language: spanish
            });
            $('#table-guiatrans-ingreso').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_ingreso/",
                        type: "POST",
                        data: { fechai: fechai, fechaf: fechaf, serie: serie, numero: numero, movimiento: movimiento },
                        error: function(){
                        }
                },
                language: spanish
            });
        });

        $("#limpiarG").click(function(){

            $("#fechai").val("");
            $("#fechaf").val("");
            $("#serie").val("");
            $("#numero").val("");
            $("#movimiento").val("");

            fechai = "";
            fechaf = "";
            serie = "";
            numero = "";
            movimiento = "";

            $('#table-guiatrans-salida').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_salida/",
                        type: "POST",
                        data: { fechai: fechai, fechaf: fechaf, serie: serie, numero: numero, movimiento: movimiento },
                        error: function(){
                        }
                },
                language: spanish
            });
            $('#table-guiatrans-ingreso').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_ingreso/",
                        type: "POST",
                        data: { fechai: fechai, fechaf: fechaf, serie: serie, numero: numero, movimiento: movimiento },
                        error: function(){
                        }
                },
                language: spanish
            });
        });
		});

  </script>