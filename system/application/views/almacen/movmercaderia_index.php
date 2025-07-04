<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>
<style type="text/css">
/*CHECKBOX*/
.swtich-container {
    position: relative;
    display: inline-block;
    width: 100px;
    /* Anoche del contenedor */
    height: 30px;
    /* Alto del contenedor */
    border-radius: 20px;
    border: 3px solid rgba(2, 137, 155, 0.050);
    /* Bordeado fuera del switch */
}

.swtich-container input {
    display: none;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #979797;
    -webkit-transition: .2s;
    transition: .2s;
}

.slider:before {
    position: absolute;
    content: "";
    height: 24px;
    /* Alto de la bola */
    width: 24px;
    /* Ancho de la bola */
    left: 4px;
    /* Ubicacion Izquierda de la bola */
    bottom: 3.5px;
    /* Ubicacion Arriba-Abajo de la bola */
    background-color: white;
    /* Color de la bola */
    -webkit-transition: .2s;
    /* Velicidad de transición */
    transition: .2s;
    /* Velicidad de transición de Webkit*/
}

input:checked+.slider {
    background-color: #02889B;
}

input:focus+.slider {
    box-shadow: 0 0 1px #2196F3;
}

input:checked+.slider:before {
    -webkit-transform: translateX(70px);
    /* Desplazamiento Webkit*/
    -ms-transform: translateX(70px);
    /* Desplazamiento */
    transform: translateX(70px);
    /* Desplazamiento */
}


/*------ Cambio ON y OFF ---------*/

.on {
    display: none;
}

.on,
.off {
    color: white;
    /* Color ON-OFF */
    position: absolute;
    /* Posicion */
    transform: translate(-50%, -50%);
    top: 25%;
    left: 25%;
    font-size: 11px;
    /* Tamaño de letra */
    font-family: Verdana, sans-serif;
    /* Fuente de letra */
}

.on {
    top: 14px;
    /* Ubicacion Arriba-Abajo de la palabra ON */
}

.off {
    left: auto;
    right: -3px;
    /* Ubicacion Derecha de la palabra OFF */
    top: 14px;
    /* Ubicacion Arriba-Abajo de la palabra OFF */
}

input:checked+.slider .on {
    display: block;
}

input:checked+.slider .off {
    display: none;
}


/* Slider */

.slider {
    border-radius: 17px;
}

.slider:before {
    border-radius: 50%;
}


/*LOADER*/
div.image-container {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    width: 100%;
    height: 100%;
    bottom: 0;
    z-index: 999999;
    text-align: center;
}

.image-holder {
    position: absolute;
    left: 50%;
    top: 50%;
    width: 100px;
    height: 100px;
}

.image-holder img {
    width: 100%;
    margin-left: -50%;
    margin-top: -50%;
}

.text-holder {
    position: absolute;
    left: 41%;
    top: 60%;
    width: 300px;
    height: 300px;
    font-weight: bolder;

}
</style>
<div class="container-fluid">
    <div class="image-container">
        <p class="image-holder">
            <img src="<?=base_url().'images/loading.gif?='.IMG;?>" style="">
        </p>
        <span class="text-holder">
            Esto puede demorar unos segundos
        </span>
    </div>
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-4 col-md-4 col-lg-4 form-group">
                <label for="search_descripcion">PRODUCTO</label>
                <input type="text" name="search_descripcion" id="search_descripcion" value=""
                    placeholder="Nombre del producto" class="form-control h-1 w-porc-90" />
                <input type="hidden" name="producto" id="producto" value="" placeholder="codigo"
                    class="form-control h-1 w-porc-90" />
            </div>
            <!--       <div class="col-sm-4 col-md-4 col-lg-4 form-group">
                <label for="search_tipo">ALMACEN</label>
                <?=$cboAlmacen;?>
            </div> -->
            <!--    <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_tipo">INVENTARIO</label>
                    <label class="swtich-container">
                     <input type="checkbox" id="switch" name="switch">
                         <div class="slider">
                         <span class="on">TODOS</span>
                         <span class="off">ULTIMO</span>
                     </div>
                    </label>
                
            </div> -->
        </div>
        <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_fechai">FECHA INICIO</label>
                <input type="date" name="search_fechai" id="search_fechai" value=""
                    class="form-control h-1 w-porc-90" />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_fechaf">FECHA FIN</label>
                <input type="date" name="search_fechaf" id="search_fechaf" value=""
                    class="form-control h-1 w-porc-90" />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="entrada">ENTRADA</label>
                <input type="text" name="entrada" id="entrada" value="" class="form-control h-1 w-porc-90" readonly />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="salida">SALIDA</label>
                <input type="text" name="salida" id="salida" value="" class="form-control h-1 w-porc-90" readonly />
            </div>


        </div>
        <!--<div class="row fuente8 py-1">
            <?php if ($this->session->userdata('rol')=="7000"){ ?>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="salida">REVISION DE STOCK</label>
                <a type="button" class="btn btn-success" id="balance_stock_total" name="balance_stock_total">REVISAR
                    KARDEX</a>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group ">

                <a type="button" class="btn btn-success" id="dele_al_kardex" name="dele_al_kardex">INGRESO A KARDEX</a>

            </div>

            <div class="col-sm-2 col-md-2 col-lg-2 form-group ">

                <a type="button" class="btn btn-success" id="balance_stock" name="balance_stock">AJUSTE PRODUCTO</a>
            </div>

            <?php } ?>
        </div>-->

    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul id="limpiarC" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarC" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                            <ul id="nuevoC" class="lista_botones">
                                <li id="nuevo">Nuevo</li>
                            </ul>
                            <ul id="ExelC" class="lista_botones">
                                <li id="exel" onclick="exel_mov()">Descargar reporte</li>
                            </ul>
                        </div>
                        <div id="lineaResultado">Registros encontrados</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="header text-align-center"><?=$titulo;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="table_movimiento" data-page-length="25">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:05%" data-orderable="false" title="">N°</td>
                                <td style="width:10%" data-orderable="false" title="">FECHA MOV.</td>
<!--                                 <td style="width:10%" data-orderable="false" title="">NUM DOC</td>
 -->                                <td style="width:25%" data-orderable="false" title="">CLIENTE O PROVEEDOR</td>
                                <td style="width:20%" data-orderable="false" title="">PRODUCTO (ITEM)</td>
                                <td style="width:05%" data-orderable="false" title="">CANT.</td>
                                <td style="width:05%" data-orderable="false" title="">ORDEN DE COMPRA</td>
                                <td style="width:15%" data-orderable="false" title="">DESTINO</td>
                                <td style="width:15%" data-orderable="false" title="">MOVIMIENTO</td>
                                <td style="width:5%" data-orderable="false" title=""></td>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal_movmercaderias" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">REGISTRAR MOVIMIENTO DE ITEM</h5>

            </div>
            <div class="modal-body">
                <form id="form_movitem">
                    <!-- id_registro-->
                    <input type="text" id="id_registro" name="id_registro" hidden>
                    <input type="text" id="code_producto" name="code_producto" hidden>

                    <!-- ---------- -->
                    <div class="row form-group align-items-center">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <img src="<?php echo base_url()."images/barcode.png"?>" width="50xp" height="50px">
                            <label for="tempde_barcode">Codigo de barras</label>
                            <input type="text" id="tempde_barcode" name="tempde_barcode" class="form-control h-2"
                                style="width: 80%;" placeholder="Codigo de barra">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_prodcuto">Item (*)</label>
                            <input type="text" id="id_prodcuto" name="id_prodcuto" class="form-control h-2"
                                style="width: 90%;" placeholder="Descripcion item">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <button id="nuevo_cliente" type="button" class="btn btn-default" data-target="#modal_addcliente" data-toggle="modal">NUEVO</button>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_recep">CLIENT - PROVEEDOR (*)</label>
                            <input type="text" id="id_recep" name="id_recep" class="form-control h-2"
                                style="width: 110%;" placeholder="Cliente o proveedor item">
                        </div>

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_dia">Dia de llegada o partida (*)</label>
                            <input type="date" id="id_dia" name="id_dia" class="form-control h-2" style="width: 90%;">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_cantidad">Cantidad (*)</label>
                            <input type="number" id="id_cantidad" name="id_cantidad" class="form-control h-2"
                                style="width: 60%;" placeholder="Cantidad del item">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_oc">Orden de compra</label>
                            <input type="text" id="id_oc" name="id_oc" class="form-control h-2" style="width: 90%;"
                                placeholder="Orden de compra">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_destino">Destino</label>
                            <input type="text" id="id_destino" name="id_destino" class="form-control h-2"
                                style="width: 80%;" placeholder="Descripcion del destino">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="id_oc">Número de documento</label>
                            <input type="text" id="id_doc" name="id_doc" class="form-control h-2" style="width: 80%;"
                                placeholder="SERIE - NUMERO (FPP1 - 00001)">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tipo_mov">Movimiento</label>
                            <select name="tipo_mov" id="tipo_mov" class="form-control h-2">
                                <option value="1" style="color: red;">SALIDA</option>
                                <option value="2" style="color: green;">ENTRADA</option>
                            </select>
                        </div>
                        <div class="col-sm-10 col-md-10 col-lg-9">
                            <label for="id_obs">Observaciones</label>
                            <textarea name="id_obs" id="id_obs" class="form-control"></textarea>
                        </div>


                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info" onclick="clean()">limpiar</button>
                <button type="button" class="btn btn-success" onclick="insertar()">Guardar</button>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('ventas/modal_clientes'); ?>

<script type="text/javascript">
base_url = "<?=$base_url;?>";

$(document).ready(function() {
    $('#search_descripcion').keyup(function(e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            search();
        }
    });
    $("#search_descripcion").autocomplete({
        source: function(request, response) {

            tipo_oper = 'V';
            moneda = 1;
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/B/" +
                    <?php echo $compania;?> + "/" + $("#almacen").val(),
                type: "POST",
                data: {
                    term: $("#search_descripcion").val(),
                    TipCli: "0",
                    tipo_oper: tipo_oper,
                    moneda: moneda
                },
                dataType: "json",
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {
            /**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/


            $("#producto").val(ui.item.codigo);
            $("#search_codigo").val(ui.item.value);
            $("#search_descripcion").val(ui.item.nombre);


        },
        minLength: 1
    });

    $("#search_codigo").autocomplete({
        source: function(request, response) {
            compania = <?php echo $_SESSION["compania"]?>;
            almacen = $("#almacen").val();
            tipo_oper = "V";
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/almacen/producto/autocompletado_producto_x_codigo",
                type: "POST",
                data: {
                    term: $("#search_codigo").val(),
                    flag: "B",
                    compania: compania,
                    almacen: almacen
                },
                dataType: "json",
                success: function(data) {
                    response(data);
                }
            });
        },
        select: function(event, ui) {

            $("#producto").val(ui.item.codigo);
            $("#search_codigo").val(ui.item.value);
            $("#search_descripcion").val(ui.item.nombre);
        },
        minLength: 1
    });

    /* $('#table-movimiento').DataTable({
         filter: false,
         destroy: true,
         processing: true,
         serverSide: true,
         autoWidth: false,
         ajax:{
                 url : '<?=base_url();?>index.php/almacen/kardex/datatable_kardex/',
                 type: "POST",
                 data: { dataString: "" },
                 beforeSend: function(){
                     $("#table-movimiento .loading-table").show();
                 },
                 error: function(){
                 },
                 complete: function(){
                     $("#table-movimiento .loading-table").hide();
                 }
         },
         language: spanish,
         columnDefs: [{"className": "dt-center", "targets": 0}],
         order: [[ 1, "desc" ]]
     });*/
    $("#nuevoC").click(function() {
        $("#modal_movmercaderias").modal("show");
    });

    /*   $("#buscarC").click(function() {
          search();
      }); */

    $("#buscarC").click(function() {
        fechai = $('#fechai').val();
        fechaf = $('#fechaf').val();
        producto = $('#producto').val();

        $('#table_movimiento').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url();?>index.php/almacen/movmercaderia/tabla_mov/",
                type: "POST",
                dataType: 'json',
                data: { fechai: fechai, fechaf: fechaf, producto: producto,},

                beforeSend: function() {},
                /*   success: function(data) {
                      console.log(data);
                  }, */
                error: function() {}
            },
            language: spanish,
            createdRow: function(row, data, dataIndex) {
                // Asumiendo que la columna de movimiento es la novena (índice 8)
                var movimiento = data[7]; // Aquí está el tipo de movimiento

                // Verifica si el movimiento es Salida o Ingreso
                if (movimiento.includes('SALIDA')) {
                    $(row).find('td').css('background-color',
                        '#F2A1A1');
                } else if (movimiento.includes('ENTRADA')) {
                    $(row).find('td').css('background-color',
                        '#C0F2A1');
                }
            }
        });

    });

    $("#limpiarC").click(function() {
        $("#search_descripcion").val("");
        $("#search_codigo").val("");
        $("#producto").val("");
        $("#search_fechai").val("");
        $("#search_fechaf").val("");
        $("#almacen").val("");
        $("#entrada").val("");
        $("#salida").val("");
        $("#tbody").empty();

    });

    $('#form_busqueda').keypress(function(e) {
        if (e.which == 13) {
            return false;
        }
    });

    $('#search_descripcion').keyup(function(e) {
        if (e.which == 13) {
            if ($(this).val() != '')
                search();
        }
    });


    $('#table_movimiento').DataTable({
        filter: false,
        destroy: true,
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?=base_url();?>index.php/almacen/movmercaderia/tabla_mov/",
            type: "POST",
            dataType: 'json',
            data: {
                dataString: ""
            },
            beforeSend: function() {},
            /*   success: function(data) {
                  console.log(data);
              }, */
            error: function() {}
        },
        language: spanish,
        createdRow: function(row, data, dataIndex) {
            // Asumiendo que la columna de movimiento es la novena (índice 8)
            var movimiento = data[7]; // Aquí está el tipo de movimiento

            // Verifica si el movimiento es Salida o Ingreso
            if (movimiento.includes('SALIDA')) {
                $(row).find('td').css('background-color',
                    '#F2A1A1');
            } else if (movimiento.includes('ENTRADA')) {
                $(row).find('td').css('background-color',
                    '#C0F2A1');
            }
        }
    });

    $("#limpiarC").click(function() {

        $('#table_movimiento').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?=base_url();?>index.php/almacen/movmercaderia/tabla_mov/",
                type: "POST",
                dataType: 'json',
                data: {
                    dataString: ""
                },
                beforeSend: function() {},
                /*   success: function(data) {
                      console.log(data);
                  }, */
                error: function() {}
            },
            language: spanish,
            createdRow: function(row, data, dataIndex) {
                // Asumiendo que la columna de movimiento es la novena (índice 8)
                var movimiento = data[7]; // Aquí está el tipo de movimiento

                // Verifica si el movimiento es Salida o Ingreso
                if (movimiento.includes('SALIDA')) {
                    $(row).find('td').css('background-color',
                        '#F2A1A1');
                } else if (movimiento.includes('ENTRADA')) {
                    $(row).find('td').css('background-color',
                        '#C0F2A1');
                }
            }
        });

    });

    var code_bar = $('#tempde_barcode');

    code_bar.keyup(function(e) {
        var key = e.keyCode || e.which;
        if (key == 13) {
            if ($(this).val() != '') {
                busqueda_producto_enter();
            }
        }
    });
});

function clean() {

    $("#tempde_barcode").val("");
    $("#id_prodcuto").val("");
    $("#id_recep").val("");
    $("#id_dia").val("");
    $("#id_cantidad").val("");
    $("#id_oc").val("");
    $("#id_destino").val("");
    $("#id_doc").val("");
    $("#id_obs").val("");

}

function editar_mercaderia(id) {

    $("#modal_movmercaderias").modal("show");
    var url = '<?=base_url();?>index.php/almacen/movmercaderia/get_mov/';

    $.ajax({
        url: url,
        type: "POST",
        data: {
            id: id
        },
        dataType: "json",

        success: function(data) {

            $("#id_registro").val(data.id);
            $("#code_producto").val(data.id_prodcuto);

            $("#id_prodcuto").val(data.producto);
            $("#id_recep").val(data.recep);
            $("#id_dia").val(data.fecha);
            $("#id_cantidad").val(data.cantidad);
            $("#id_oc").val(data.ocompra);
            $("#id_destino").val(data.destino);
            $("#id_doc").val(data.numDoc);
            $("#id_obs").val(data.observaciones);
            $("#tipo_mov").val(data.movimiento);
        }

    });


}

function exel_mov() {
    var search_fechai = $("#search_fechai").val();
    var search_fechaf = $("#search_fechaf").val();

    location.href = base_url + "index.php/almacen/movmercaderia/excel_mov_caja/" + search_fechai + "/" + search_fechaf;

}

function insertar() {
    var info = $("#form_movitem").serialize();
    var url = '<?=base_url();?>index.php/almacen/movmercaderia/insertar_mov/';

    if ($("#id_prodcuto").val() == "") {
        alert("debe ingresar un item");
        return;

    } else if ($("#id_recep").val() == "") {
        alert("debe ingresar un cliente o proveedor");
        return;

    } else if ($("#id_dia").val() == "") {
        alert("debe ingresar una fecha valida");
        return;

    } else if ($("#id_cantidad").val() == "") {
        alert("debe ingresar una cantidad valida");
        return;
    }

    $.ajax({
        url: url,
        type: "POST",
        data: info,
        dataType: "json",

        success: function(data) {
            if (data.result == "success") {
                Swal.fire({
                    icon: "success",
                    title: "Ejecucion completada",
                    html: "",
                    showConfirmButton: true
                }).then(() => {
                    // Ejecutar el click en el botón limpiarC
                    $("#limpiarC").click();
                    clean();
                });

            } else {
                Swal.fire({
                    icon: "warning",
                    title: "Ejecucion completada",
                    html: "Sin cambios",
                    showConfirmButton: true
                });
            }
        }
    });
}

$("#id_recep").autocomplete({
    source: function(request, response) {
        $.ajax({
            url: "<?php echo base_url(); ?>index.php/ventas/cliente/autocomplete_ruc/",
            type: "POST",
            data: {
                term: $("#id_recep").val()
            },
            dataType: "json",
            success: function(data) {

                response($.map(data, function(item) {
                    return {
                        label: item.ruc + ' | ' + item.nombre,
                        value: item.nombre,
                        code: item.codigo,
                    };
                }));
            }
        });
    },
    select: function(event, ui) {
        $("#id_recep").val(ui.item.nombre);
        //$("#buscar_cliente").val(ui.item.ruc);


        if (ui.item.contactos != null) {
            var size = ui.item.contactos.length;
            $('#contacto option').remove();

            for (x = 0; x < size; x++) {
                $('#contacto').append("<option value='" + ui.item.contactos[x].ECONC_Contacto + "'>" + ui
                    .item.contactos[x].ECONC_Descripcion + "</option>");
            }
        }

    },
    minLength: 2
});

function busqueda_producto_enter() {

    var barcode = $("#tempde_barcode").val();
    var url = '<?=base_url();?>index.php/almacen/movmercaderia/get_productos_barcode/';

    $.ajax({
        url: url,
        type: "POST",
        data: {
            barcode: barcode
        },
        dataType: "json",

        success: function(data) {

            $("#id_prodcuto").val(data.descripcion);
            $("#code_producto").val(data.id_p)
        }
    });

}
</script>