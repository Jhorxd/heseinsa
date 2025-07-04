<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/guiarem.js?=<?=JS;?>"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/funciones.js?=<?=JS;?>"></script>

<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>
<script language="javascript">
    $(document).ready(function () {
        $("a#linkVerCliente, a#linkVerProveedor, a#linkVerProducto").fancybox({
            'width': 700,
            'height': 450,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': true,
            'type': 'iframe'
        });
        
        $("a#ocompra, a#comprobante").fancybox({
            'width': 800,
            'height': 500,
            'autoScale': false,
            'transitionIn': 'none',
            'transitionOut': 'none',
            'showCloseButton': true,
            'modal': false,
            'type': 'iframe'
        });

        //agregado autocompletar gcbq
        $("#nombre_producto").autocomplete({

            source: function (request, response) {

                $.ajax({
                    //contiene flagbs-bien o servicio
                    //url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/"+$("#flagBS").val()+"/"+$("#compania").val(),

                    url: "<?php echo base_url(); ?>index.php/almacen/producto/autocomplete/B/" + $("#compania").val(),
                    type: "POST",
                    data: {term: $("#nombre_producto").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }

                });

            },

            select: function (event, ui) {

                $("#buscar_producto").val(ui.item.codinterno);
                $("#producto").val(ui.item.codigo)
                $("#codproducto").val(ui.item.codinterno);
            },

            minLength: 2

        });

        $("#nombre_cliente").autocomplete({
            source: function (request, response) {

                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete/",
                    type: "POST",
                    data: {term: $("#nombre_cliente").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },

            select: function (event, ui) {
                $("#buscar_cliente").val(ui.item.ruc)
                $("#cliente").val(ui.item.codigo);
                $("#ruc_cliente").val(ui.item.ruc);
            },

            minLength: 2

        });


        $("#nombre_proveedor").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/compras/proveedor/autocomplete/",
                    type: "POST",
                    data: {term: $("#nombre_proveedor").val()},
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }

                });

            },
            select: function (event, ui) {
                $("#buscar_proveedor").val(ui.item.ruc)
                $("#proveedor").val(ui.item.codigo);
                $("#ruc_proveedor").val(ui.item.ruc);
            },

            minLength: 2

        });

        /////////////////7
    });
    function seleccionar_cliente(codigo, ruc, razon_social, empresa, persona) {
        $("#cliente").val(codigo);
        $("#ruc_cliente").val(ruc);
        $("#nombre_cliente").val(razon_social);
    }
    function seleccionar_proveedor(codigo, ruc, razon_social) {
        $("#proveedor").val(codigo);
        $("#ruc_proveedor").val(ruc);
        $("#nombre_proveedor").val(razon_social);
    }
    function seleccionar_producto(codigo, interno, familia, stock, costo) {
        $("#producto").val(codigo);
        $("#codproducto").val(interno);

        base_url = $("#base_url").val();
        url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + codigo;
        $.getJSON(url, function (data) {
            $.each(data, function (i, item) {
                nombre_producto = item.PROD_Nombre;
            });
            $("#nombre_producto").val(nombre_producto);
        });
    }

    function relacionado_comprobante(numero){
        alert('Guia de remision relacionada con el numero ' + numero);
    }

</script>
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda; ?></div>
            <div id="frmBusqueda">
                <form id="form_busqueda" name="form_busqueda" method="post" action="<?php echo $accion; ?>">
                    <input name="compania" type="hidden" id="compania" value="<?=$compania?>">
                    <table class="fuente8" width="98%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td align='left' width="10%">Fecha inicial</td>
                            <td align='left' width="90%">
                                <input name="fechai" id="fechai" value="" type="text" class="cajaGeneral" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" name="Calendario1" id="Calendario1" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechai",      // id del campo de texto
                                        ifFormat: "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario1"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                                <label style="margin-left: 90px;">Fecha final</label>
                                <input name="fechaf" id="fechaf" value="" type="text" class="cajaGeneral" size="10" maxlength="10"/>
                                <img src="<?php echo base_url(); ?>images/calendario.png?=<?=IMG;?>" name="Calendario2" id="Calendario2" width="16" height="16" border="0" onMouseOver="this.style.cursor='pointer'" title="Calendario2"/>
                                <script type="text/javascript">
                                    Calendar.setup({
                                        inputField: "fechaf",      // id del campo de texto
                                        ifFormat: "%Y-%m-%d",       // formato de la fecha, cuando se escriba en el campo de texto
                                        button: "Calendario2"   // el id del botón que lanzará el calendario
                                    });
                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td align='left'>Número</td>
                            <td align='left'> <?php
                            	if ($tipo_oper == 'V'){ ?>
	                            	<select id="seriei" name="seriei" class="cajaPequena h2"><?php
	                            		if ($series_emitidas != NULL){
			                            	foreach ($series_emitidas as $i => $val){ ?>
			                            		<option value="<?=$val->GUIAREMC_Serie;?>" <?=($val->serie_actual == $val->GUIAREMC_Serie) ? "selected" : "";?>><?=$val->GUIAREMC_Serie;?></option> <?php
			                            	}
			                            } ?>
		                            </select> <?php
		                          }
		                          else{ ?>
                              	<input type="text" name="seriei" id="seriei" value="" placeholder="Serie" class="cajaPequena"/> <?php
		                          } ?>
                              <input type="text" name="numero" id="numero" value="" placeholder="Numero" class="cajaGeneral" size="10"/>
                            </td>
                        </tr>
                        <tr>
                            <?php if ($tipo_oper == 'V') { ?>
                                <td align='left'>Cliente</td>
                                <td align='left'>
                                    <input type="hidden" name="cliente" value="" id="cliente" size="5"/>
                                    <input type="text" name="ruc_cliente" value="" class="cajaGeneral" id="ruc_cliente" size="10" maxlength="11" onblur="obtener_cliente();" onkeypress="return numbersonly(this,event,'.');" readonly="readonly" placeholder="Ruc"/>
                                    <input type="text" name="nombre_cliente" value="" class="cajaGrande cajaSoloLectura" id="nombre_cliente" size="40" placeholder="Nombre cliente"/>
                                </td>
                            <?php } else { ?>
                                <td align='left'>Proveedor</td>
                                <td align='left'>
                                    <input type="hidden" name="proveedor" value="" id="proveedor" size="5"/>
                                    <input type="text" name="ruc_proveedor" value="" class="cajaGeneral" id="ruc_proveedor" size="10" maxlength="11" onblur="obtener_proveedor();" onkeypress="return numbersonly(this,event,'.');" readonly="readonly" placeholder="Ruc"/>
                                    <input type="text" name="nombre_proveedor" value="" class="cajaGrande cajaSoloLectura" id="nombre_proveedor" size="40" placeholder="Nombre proveedor"/>
                                </td>
                            <?php } ?>
                        </tr>
                        <tr hidden>
                            <td align='left'>Artículo</td>
                            <td align='left'>
                                
                                <input name="producto" type="hidden" class="cajaPequena" id="producto" value="<?=$producto;?>" size="10" maxlength="11"/>
                                <input name="codproducto" type="text" class="cajaGeneral" id="codproducto" value="<?=$codproducto;?>" size="10" maxlength="20" onblur="obtener_producto();" readonly="readonly" placeholder="Codigo"/>
                                <input name="buscar_producto" type="hidden" class="cajaGeneral" id="buscar_producto" size="40"/>
                                <input name="nombre_producto" type="text" value="<?=$nombre_producto;?>" class="cajaGrande cajaSoloLectura" id="nombre_producto" size="40" placeholder="Nombre producto"/>
                                <!--<a href="<?php echo base_url(); ?>index.php/almacen/producto/ventana_busqueda_producto/" id="linkVerProducto"><img height='16' width='16' src='<?php echo base_url(); ?>/images/ver.png?=<?=IMG;?>' title='Buscar' border='0'/></a>-->
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="acciones">
                <?php if ($tipo_oper == 'V') { ?>
                    <ul id="reporteGuia" class="lista_botones">
                        <li id="excel">Reporte</li>
                    </ul>
                <?php } ?>
                
                <div id="botonBusqueda">
                   
                    <ul id="nuevaGuiarem" class="lista_botones">
                        <li id="nuevo">Guia de Remisión</li>
                    </ul>
                    <ul id="limpiarG" class="lista_botones">
                        <li id="limpiar">Limpiar</li>
                    </ul>
                    <ul id="buscarG" class="lista_botones">
                        <li id="buscar">Buscar</li>
                    </ul>
                    
                    <!--#############################################-->
                    <?php if ($tipo_oper == 'V') { ?>
                    <ul id="FormatoGuias" class="lista_botones">
                        <li id="excel">Formato Guías</li>
                    </ul>
                    <?php } else { ?>
                        <ul id="FormatoGuias_compras" class="lista_botones">
                        <li id="excel">Formato Guías</li>
                        </ul>
                    <?php } ?>
                    <?php if ($tipo_oper == 'V') { ?>
                    <ul id="SubirFormato" class="lista_botones">
                        <li id="subir">Cargar Formato</li>
                    </ul>
                    <?php } else { ?>
                    <ul id="SubirFormato_compras" class="lista_botones">
                        <li id="subir">Cargar Formato</li>
                    </ul>
                    <?php } ?> 
                    <!--#############################################-->
                    
                </div>
                <div id="lineaResultado">
                    <table class="fuente7" width="100%" cellspacing="0" cellpadding="3" border="0">
                        <tr>
                            <td width="50%" align="left">Guias de remisión</td>
                        </tr>
                    </table>
                </div>
            </div>
            <div id="cabeceraResultado" class="header"><?php echo $titulo_tabla; ?></div>
            <div id="frmResultado">
                <table class="fuente8 display" width="100%" cellspacing="0" cellpadding="3" border="0" id="table-guiarem">
                    <div id="cargando_datos" class="loading-table">
                        <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                    </div>
                    <thead>
                        <tr class="cabeceraTabla">
                            
                            <th style="width:07%;" data-orderable="true">FECHA</th>
                            <th style="width:05%;" data-orderable="true">SERIE</th>
                            <th style="width:07%;" data-orderable="true">NUMERO</th>
                            <th style="width:31.5%;" data-orderable="true">RAZON SOCIAL</th>
                            <th style="width:06%;" data-orderable="false">BOLETA</th>
                            <th style="width:06%;" data-orderable="false">FACTURA</th>
                            <th style="width:06%;" data-orderable="false">COTIZACIÓN</th>
                            <th style="width:10.5%;" data-orderable="false">O. C.</th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:2.5%;" data-orderable="false"></th>
                            <th style="width:06%;" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        /*if (count($lista) < 0) {
                            foreach ($lista as $indice => $valor) {
                                $class = $indice % 2 == 0 ? 'itemParTabla' : 'itemImparTabla'; ?>
                                <tr class="<?php echo $class; ?>">
                                    <td>
                                        <div align="center"><?php echo $valor[0]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[1]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[2]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[3]; ?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?php echo $valor[6]; ?></div>
                                    </td>
                                    <td>
                                    <!--No  visualiza la factura-->
                                        <div align="center"><?php echo $valor[14]; ?></div>
                                    </td>
                                    
                                    <td>
                                    <!--NO visualiza la guia de remision-->
                                        <div align="center"><?php echo $valor[13]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[12]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center" style="cursor:pointer; color:#003399; font-weight: normal; font-size: 11px;"><?php echo $valor[18]; ?></div> <!--HERE DATA OC -->
                                    </td>
                                    <td>
                                        <div align="center"><?php echo $valor[11]; ?></div>
                                    </td>
                                    <td>
                                        <div align="center" class="editar_data_<?=$valor[0]?>"><?=$valor[8];?></div>
                                    </td>
                                    <td>
                                        <div align="center"><?=$valor[9];?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?=$valor[10];?></div>
                                    </td>
                                    <td>
                                        <div align="left"><?=$valor[20];?></div>
                                    </td>
                                    <td>
                                        <div align="left" class="pdfSunat_<?=$valor[0]?>">
                                            <span class="icon-loading"></span>
                                            <span class="pdfSunat_data_<?=$valor[0]?>"><?=$valor[19];?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <div align="center"><?=$valor[17];?></div>
                                    </td>
                                    <td>
                                        <div align="center" class="disparador_<?=$valor[0]?>"> <!-- APROBAR -->
                                            <span class='icon-loading'></span>
                                            <span class="disparador_data_<?=$valor[0]?>"><?=$valor[15];?></span>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                        }*/?>
                    </tbody>
                </table>
            </div>
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
            <?php echo $oculto ?>
        </div>
    </div>
</div>
<!--ANULACION DE DOCUMENTO-->
    <div class="modal fade modal-anulacion" tabindex="-1" role="dialog" data-backdrop="static" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="width: 700px; padding: 1em 3em 1em 3em; height: auto; margin: auto; font-family: Trebuchet MS, sans-serif; font-size: 10pt;">
                <form method="post" id="form-mail">
                    <div class="contenido" style="width: 100%; margin: auto; height: auto; overflow: auto;">
                        <div class="tempde_head">

                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11" style="text-align: center;">
                                    <h3>DESHABILITAR GUIA (INTERNO)</h3>
                                </div>
                            </div>

                            <input type="hidden" id="idDocAnula" name="idDocAnula">
                        </div>

                        <div class="tempde_body">
                            
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <label for="anulaSerie">SERIE:</label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <label for="anulaNumero">NUMERO:</label>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <span id="anulaSerie" name="anulaSerie" style="font-size: 20pt;"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    <span id="anulaNumero" name="anulaNumero" style="font-size: 20pt;"></span>
                                </div>
                                <div class="col-sm-3 col-md-3 col-lg-3">
                                    
                                </div>
                                
                            </div>
                            <br>

                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11">
                                    <label for="motivo">MOTIVO (opcional):</label>
                                    <span class="mail-contactos"></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-11 col-md-11 col-lg-11">
                                    <input type="text" class="form-control" id="motivo" name="motivo" value="" placeholder="motivo">
                                </div>
                            </div>
                            <br>
                        </div>

                        <div class="tempde_footer">
                            <div class="row">
                                <div class="col-sm-6 col-md-6 col-lg-6"></div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <span class="icon-loading-md"></span>
                                    <div style="float: right">
                                        <span class="btn btn-success btn-sendAnulacion">Enviar</span>
                                        &nbsp;
                                        <span class="btn btn-danger btn-close-sendAnulacion">Cerrar</span>
                                    </div>
                                </div>
                            </div>
                            <br>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- FIN ANULACION DE DOCUMENTO-->

<!--#############################COM##################################-->
<div class="modal" tabindex="-1" role="dialog" id="modal_carga_masiva">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cargar Guías</h5>
        
      </div>
      <div class="modal-body">
        <div class="row">
            <input type="file" id="archivo_guias" class="form-control w-porc-90">
        </div>
      </div>
      <div class="modal-footer">
        <?php if ($tipo_oper == 'V') { ?>
        <button type="button" class="btn btn-primary subir_formato">Cargar</button>
        <?php } else { ?>
        <button type="button" class="btn btn-primary subir_formato_compras">Cargar</button>
        <?php } ?>  
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!--#############################FIN##################################-->

<script>
    $(document).ready(function(){
        /*ANULACION*/
            $(".btn-sendAnulacion").click(function(){
                
                codigo = $("#idDocAnula").val();
                motivo = $("#motivo").val();

                
                var url = "<?=base_url();?>index.php/almacen/guiarem/deshabilitar_guia";
                $.ajax({
                    url:url,
                    type:"POST",
                    data:{ guia: codigo, motivo: motivo},
                    dataType:"json",
                    error:function(data){
                    },
                    beforeSend: function(){
                        $(".tempde_footer .icon-loading-md").show();
                        $(".btn-sendAnulacion").hide();
                    },
                    success:function(data){
                        if (data.result == "success"){
                            Swal.fire({
                                icon: "success",
                                title: data.msj,
                                showConfirmButton: true,
                                timer: 2000
                            });
                            $("#buscarG").click();
                            $(".modal-anulacion").modal("hide");
                        }
                        
                        if(data.result == "error"){
                            Swal.fire({
                                icon: "error",
                                title: data.msj,
                                html: "<b>Comuníquese con SOPORTE TÉCNICO</b>",
                                showConfirmButton: true
                            });
                        }
                        if (data.result == "observacion"){
                            Swal.fire({
                                icon: "error",
                                title: data.msj,
                                html: "",
                                showConfirmButton: true
                            });
                        }
                    },
                    complete: function(){
                        $(".tempde_footer .icon-loading-md").hide();
                        $(".btn-sendAnulacion").show();
                    }
                });
            });

            $(".btn-close-sendAnulacion").click(function(){
                $(".modal-anulacion").modal("hide");
            });
        /*FIN ANULACION*/
        $("#nombre_producto").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/B//",
                    type: "POST",
                    data: {
                        term: $("#nombre_producto").val(), TipCli: "", marca: "", modelo: "" 
                    },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $("#producto").val(ui.item.codigo);
                $("#nombre_producto").val(ui.item.descripcion);
                $("#codproducto").val(ui.item.codinterno);
            },
            minLength: 2
        });

        $("#nombre_producto").keyup(function(){
            var cadena = $("#nombre_producto").val();
            if ( cadena.length == 0 ){
                $("#producto").val("");
                $("#codproducto").val("");
            }
        });
    
        $('#table-guiarem').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
            },
            language: spanish,
            order: [[ 0, "desc" ]]
        });

        $("#buscarG").click(function(){

            fechai          = $("#fechai").val();
            fechaf          = $("#fechaf").val();

            seriei           = $("#seriei").val();
            numero          = $("#numero").val();

            ruc_cliente     = $("#ruc_cliente").val();
            nombre_cliente  = $("#nombre_cliente").val();

            ruc_proveedor   = $("#ruc_proveedor").val();
            nombre_proveedor = $("#nombre_proveedor").val();

            producto        = $("#producto").val();

            
            $('#table-guiarem').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { fechai: fechai, 
                                fechaf: fechaf,
                                seriei: seriei,
                                numero: numero,
                                ruc_cliente: ruc_cliente,
                                nombre_cliente: nombre_cliente,
                                ruc_proveedor: ruc_proveedor,
                                nombre_proveedor: nombre_proveedor,
                                producto: producto },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
                },
                language: spanish,
                order: [[ 0, "desc" ]]
            });
        });
        
        ///#############################COM##################################
        $("#limpiarG").click(function(){

            $("#form_busqueda")[0].reset();
            $("#cliente").val("");
            $("#proveedor").val("");
            $("#producto").val("");
            
            fechai = "";
            fechaf = "";
            seriei = "";
            numero = "";
            cliente = "";
            ruc_cliente = "";
            nombre_cliente = "";
            proveedor = "";
            ruc_proveedor = "";
            nombre_proveedor = "";
            producto = "";

            $('#table-guiarem').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiarem/datatable_guiarem/<?="$tipo_oper";?>',
                    type: "POST",
                    data: { fechai: fechai, 
                                fechaf: fechaf,
                                seriei: seriei,
                                numero: numero,
                                ruc_cliente: ruc_cliente,
                                nombre_cliente: nombre_cliente,
                                ruc_proveedor: ruc_proveedor,
                                nombre_proveedor: nombre_proveedor,
                                producto: producto },
                    beforeSend: function(){
                        $(".loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $(".loading-table").hide();

                    }
                },
                language: spanish,
                order: [[ 0, "desc" ]]
            });
        });
        $("#FormatoGuias").click(function()
            {
                postForm(base_url+"index.php/almacen/guiarem/formato_guias/", {pase: '1'});
            });
        $("#FormatoGuias_compras").click(function()
            {
                postForm(base_url+"index.php/almacen/guiarem/formato_guias_compras/", {pase: '1'});
            });

        $("#reporteGuia").click(function () {
            let startDate = $("#fechai").val();
            let endDate = $("#fechaf").val();

            if(startDate == "" || endDate== ""){
                Swal.fire({
                    icon: "warning",
                    title: 'Por favor, seleccione un rango de fecha',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            location.href = base_url+"index.php/almacen/guiarem/reportGuia/"+startDate+"/"+endDate;
        })
        $("#SubirFormato").click(function()
            {
                $("#archivo_guias").val("");
                $("#modal_carga_masiva").modal("show");
            });
        $(".subir_formato").click(function()
            {
                if ($("#archivo_guias").val()=="") 
                {
                            Swal.fire(
                              'Verifique el Archivo',
                              'Debe seleccionar primero el Excel',
                              'error'
                            )
                    return false;
                }

                            Swal.fire({
                              title: '¿Generar guías de este archivo?',
                              text: "Esta acción no se puede deshacer",
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Generar',
                              cancelButtonText: 'Cerrar'
                            }).then((result) => {
                              if (result.isConfirmed) {

                                 var formData = new FormData();
                               var files = $('#archivo_guias')[0].files[0];
                               formData.append('file',files);

                           $.ajax({
                                url: base_url+"index.php/almacen/guiarem/Leer_Guias_Excel/",
                                type:'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function()
                                {
                                    Swal.fire('Cargando...')
                                },
                                success:  function (response)
                                {
                                                    Swal.fire(
                                                      'Exito',
                                                      'Sus guias fueron generadas',
                                                      'success'
                                                    )
                                                    $("#modal_carga_masiva").modal("hide");
                                },
                                error: function()
                                {
                                                    Swal.fire(
                                                      'Error',
                                                      'Sus guías no Pudieron Cargarse, Verifique que las rutas existan.',
                                                      'error'
                                                    )
                                                    $("#modal_carga_masiva").modal("hide");
                                }
                            });
                              }
                            })
            });
            
            
            $("#SubirFormato_compras").click(function()
            {
                $("#archivo_guias").val("");
                $("#modal_carga_masiva").modal("show");
            });

           $(".subir_formato_compras").click(function()
            {
                if ($("#archivo_guias").val()=="") 
                {
                            Swal.fire(
                              'Verifique el Archivo',
                              'Debe seleccionar primero el Excel',
                              'error'
                            )
                    return false;
                }

                            Swal.fire({
                              title: '¿Generar guías de este archivo?',
                              text: "Esta acción no se puede deshacer",
                              icon: 'warning',
                              showCancelButton: true,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'Generar',
                              cancelButtonText: 'Cerrar'
                            }).then((result) => {
                              if (result.isConfirmed) {

                                 var formData = new FormData();
                               var files = $('#archivo_guias')[0].files[0];
                               formData.append('file',files);

                           $.ajax({
                                url: base_url+"index.php/almacen/guiarem/Leer_Guias_Excel_Compras/",
                                type:'POST',
                                data: formData,
                                contentType: false,
                                processData: false,
                                beforeSend: function()
                                {
                                    Swal.fire('Cargando...')
                                },
                                success:  function (response)
                                {
                                                    Swal.fire(
                                                      'Exito',
                                                      'Sus guias fueron generadas',
                                                      'success'
                                                    )
                                                    $("#modal_carga_masiva").modal("hide");
                                },
                                error: function()
                                {
                                                    Swal.fire(
                                                      'Error',
                                                      'Sus guías no Pudieron Cargarse, Verifique que las rutas existan.',
                                                      'error'
                                                    )
                                                    $("#modal_carga_masiva").modal("hide");
                                }
                            });
                              }
                            })
            });
            ///#############################FIN##################################
    });
    
    
    
    
    ///#############################COM##################################
    function postForm(path, params, method) {
        method = method || 'post';

        var form = document.createElement('form');
        form.setAttribute('method', method);
        form.setAttribute('action', path);

        for (var key in params) {
            if (params.hasOwnProperty(key)) {
                var hiddenField = document.createElement('input');
                hiddenField.setAttribute('type', 'hidden');
                hiddenField.setAttribute('name', key);
                hiddenField.setAttribute('value', params[key]);

                form.appendChild(hiddenField);
            }
        }

        document.body.appendChild(form);
        form.submit();
    }
    ///#############################FIN##################################
    
    
    
    


    function comprobante_ver_pdf_conmenbrete_guia(cod, conv, img) {
        url = base_url+"index.php/almacen/guiarem/guiarem_ver_pdf_conmenbrete/"+cod;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;")
    }

    function abrirAnulacionModal( id, serie, numero){
        $(".modal-anulacion").modal("toggle");
        $("#idDocAnula").val(id);
        $("#anulaSerie").html(serie);
        $("#anulaNumero").html(numero);
       
        $("#motivo").val("");
    }

</script>