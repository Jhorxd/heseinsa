<link href="<?= base_url(); ?>js/fancybox/dist/jquery.fancybox.css?=<?= CSS; ?>" rel="stylesheet">
<script src="<?= base_url(); ?>js/fancybox/dist/jquery.fancybox.js?=<?= JS; ?>"></script>
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
            <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>" style="">
        </p>
        <span class="text-holder">
            Esto puede demorar unos segundos
        </span>
    </div>
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?= $titulo; ?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-4 col-md-4 col-lg-4 form-group">
                <label for="search_descripcion">PRODUCTO</label>
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Nombre del producto" class="form-control h-1 w-porc-90" />
                <input type="hidden" name="producto" id="producto" value="" placeholder="codigo" class="form-control h-1 w-porc-90" />
            </div>
            <div class="col-sm-4 col-md-4 col-lg-4 form-group">
                <label for="search_tipo">ALMACEN</label>
                <?= $cboAlmacen; ?>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_tipo">INVENTARIO</label>
                <label class="swtich-container">
                    <input type="checkbox" id="switch" name="switch">
                    <div class="slider">
                        <span class="on">TODOS</span>
                        <span class="off">ULTIMO</span>
                    </div>
                </label>

            </div>
        </div>
        <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_fechai">FECHA INICIO</label>
                <input type="date" name="search_fechai" id="search_fechai" value="" class="form-control h-1 w-porc-90" />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="search_fechaf">FECHA FIN</label>
                <input type="date" name="search_fechaf" id="search_fechaf" value="" class="form-control h-1 w-porc-90" />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="entrada">ENTRADA</label>
                <input type="text" name="entrada" id="entrada" value="" class="form-control h-1 w-porc-90" readonly />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="salida">SALIDA</label>
                <input type="text" name="salida" id="salida" value="" class="form-control h-1 w-porc-90" readonly />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                <label for="mesKSunat">Mes Reporte Sunat</label>
                <select name="mesKSunat" id="mesKSunat" class="form-control form-select">
                    <option value="" selected disabled>::Selecciona::</option>
                    <!-- LISTA DE MESES -->
                    <option value="01">ENERO</option>
                    <option value="02">FEBRERO</option>
                    <option value="03">MARZO</option>
                    <option value="04">ABRIL</option>
                    <option value="05">MAYO</option>
                    <option value="06">JUNIO</option>
                    <option value="07">JULIO</option>
                    <option value="08">AGOSTO</option>
                    <option value="09">SEPTIEMBRE</option>
                    <option value="10">OCTUBRE</option>
                    <option value="11">NOVIEMBRE</option>
                    <option value="12">DICIEMBRE</option>
                </select>
            </div>


        </div>
        <div class="row fuente8 py-1">
            <?php if ($this->session->userdata('rol') == "7000") { ?>
                <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                    <label for="salida">REVISION DE STOCK</label>
                    <a type="button" class="btn btn-success" id="balance_stock_total" name="balance_stock_total">REVISAR KARDEX</a>
                </div>
                <div class="col-sm-2 col-md-2 col-lg-2 form-group ">

                    <a type="button" class="btn btn-success" id="dele_al_kardex" name="dele_al_kardex">INGRESO A KARDEX</a>

                </div>

                <div class="col-sm-2 col-md-2 col-lg-2 form-group ">

                    <a type="button" class="btn btn-success" id="balance_stock" name="balance_stock">AJUSTE PRODUCTO</a>
                </div>

            <?php } ?>
        </div>

    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul id="reporteKardexSunat" class="lista_botones">
                                <li id="excel">Reporte Sunat</li>
                            </ul>
                            <ul id="reporteKardex" class="lista_botones">
                                <li id="excel">Reporte</li>
                            </ul>
                            <ul id="limpiarC" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>

                            <ul id="buscarC" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                        </div>
                        <div id="lineaResultado">Registros encontrados</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="header text-align-center"><?= $titulo; ?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="table-movimiento" data-page-length="25">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?= base_url() . 'images/loading.gif?=' . IMG; ?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="false" title="">FECHA MOV.</td>
                                <td style="width:10%" data-orderable="false" title="">NUM DOC</td>
                                <td style="width:30%" data-orderable="false" title="">CLIENTE</td>
                                <td style="width:10%" data-orderable="false" title="">TIPO MOV.</td>
                                <td style="width:05%" data-orderable="false" title="">CANT.</td>
                                <td style="width:05%" data-orderable="false" title="">STOCK DISP.</td>
                                <td style="width:10%" data-orderable="false" title="">P.UNITARIO</td>
                                <td style="width:10%" data-orderable="false" title="">TOTAL</td>
                                <td style="width:10%" data-orderable="false" title="">ALMACEN ORIGEN</td>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    base_url = "<?= $base_url; ?>";

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
                    url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/B/" + <?php echo $compania; ?> + "/" + $("#almacen").val(),
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
                compania = <?php echo $_SESSION["compania"] ?>;
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
                     url : '<?= base_url(); ?>index.php/almacen/kardex/datatable_kardex/',
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

        $("#reporteKardex").click(function() {
            let startDate = $("#search_fechai").val();
            let endDate = $("#search_fechaf").val();
            let productId = $("#producto").val();
            let almacenId = $("#almacen").val();

            if (startDate == "" || endDate == "") {
                Swal.fire({
                    icon: "warning",
                    title: 'Por favor, seleccione un rango de fecha',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            if (productId == "") {
                Swal.fire({
                    icon: "warning",
                    title: 'Por favor, seleccione un producto',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            location.href = base_url + "index.php/almacen/kardex/reportKardex/" + startDate + "/" + endDate + "/" + productId + "/" + almacenId;
        })

        $("#reporteKardexSunat").click(function() {
            let startDate = $("#search_fechai").val();
            let endDate = $("#search_fechaf").val();
            let productId = $("#producto").val();
            let almacenId = $("#almacen").val();
            let mesKSunat = $("#mesKSunat").val();

            if (mesKSunat == "" || mesKSunat == null) {
                Swal.fire({
                    icon: "warning",
                    title: 'Por favor, seleccione un mes',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            // if (startDate == "" || endDate == "") {
            //     Swal.fire({
            //         icon: "warning",
            //         title: 'Por favor, seleccione un rango de fecha',
            //         showConfirmButton: true,
            //         timer: 2000
            //     });
            //     return;
            // }

            if (productId == "") {
                Swal.fire({
                    icon: "warning",
                    title: 'Por favor, seleccione un producto',
                    showConfirmButton: true,
                    timer: 2000
                });
                return;
            }

            location.href = base_url + "index.php/almacen/kardex/reportKardexDeSunat/" + mesKSunat + "/" + productId + "/" + almacenId;
        })

        $("#buscarC").click(function() {
            search();
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

        $("#balance_stock").click(function() {
            balancear_stock();
        });

        $("#balance_stock_total").click(function() {
            balancear_stock_total();
        });

        $("#dele_al_kardex").click(function() {
            dele_al_kardex();
        });


    });

    function search(search = true) {

        $('#table-movimiento').DataTable().destroy();
        if (search == true) {
            producto = $("#producto").val();
            search_descripcion = $("#search_descripcion").val();
            search_fechai = $("#search_fechai").val();
            search_fechaf = $("#search_fechaf").val();
            almacen = $("#almacen").val();
            //var ult_inventario = $("#switch").val();
            var ult_inventario = document.getElementById("switch");
            if (ult_inventario.checked == true) {
                var ult_inventario = 1;
            } else {
                var ult_inventario = 0;
            }
            if (producto == "" || producto == null) {
                Swal.fire({
                    icon: "warning",
                    title: "Debe ingresar un producto",
                    html: "<b class='color-red'>Para realizar la busqueda debe seleccionar un producto</b>",
                    showConfirmButton: true
                });
                $("#search_descripcion").focus();
                return false;
            }
        } else {
            $("#search_descripcion").val("");
            $("#producto").val("");
            $("#search_fechai").val("");
            $("#search_fechaf").val("");
            $("#almacen").val("");
            $("#almacen").val("");

            search_codigo = "";
            search_descripcion = "";
            search_tipo = "";
            search_fechai = "";
            search_fechaf = "";
            almacen = "";
            producto = "";
            ult_inventario = "";
        }

        $.ajax({
            url: '<?= base_url(); ?>index.php/almacen/kardex/datatable_kardex/',
            type: "POST",
            data: {
                producto: producto,
                descripcion: search_descripcion,
                almacen: almacen,
                fechai: search_fechai,
                ult_inventario: ult_inventario,
                fechaf: search_fechaf
            },
            dataType: "json",
            success: function(data) {

                $("#entrada").val(data.entrada);
                $("#salida").val(data.salida);
                $('#table-movimiento').DataTable({
                    data: data.data,
                    "bSort": false
                });
            }
        });
    }

    function balancear_stock_total() {
        var producto = $("#producto").val();
        var search_descripcion = $("#search_descripcion").val();
        var search_fechai = $("#search_fechai").val();
        var search_fechaf = $("#search_fechaf").val();
        var almacen = $("#almacen").val();
        //var ult_inventario = $("#switch").val();
        var ult_inventario = document.getElementById("switch");
        if (ult_inventario.checked == true) {
            var ult_inventario = 1;
        } else {
            var ult_inventario = 0;
        }
        $.ajax({
            url: '<?= base_url(); ?>index.php/almacen/kardex/balancear_stock_total/',
            type: "POST",
            data: {
                producto: producto,
                descripcion: search_descripcion,
                almacen: almacen,
                ult_inventario: ult_inventario,
                fechai: search_fechai,
                fechaf: search_fechaf
            },
            dataType: "json",
            beforeSend: function(data) {
                $(".image-container").show();
                $("#balance_stock_total").hide();
            },
            success: function(data) {
                $(".image-container").hide();
                $("#balance_stock_total").show();
                if (data.response == "true" && data.resultado == "true") {
                    Swal.fire({
                        icon: "success",
                        title: "Ejecucion completada",
                        html: "",
                        showConfirmButton: true
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

    function balancear_stock() {
        producto = $("#producto").val();
        search_descripcion = $("#search_descripcion").val();
        search_fechai = $("#search_fechai").val();
        search_fechaf = $("#search_fechaf").val();
        almacen = $("#almacen").val();
        if (producto == "" || producto == null) {
            Swal.fire({
                icon: "warning",
                title: "Debe ingresar un producto",
                html: "<b class='color-red'>Para ejecutar debe seleccionar un producto</b>",
                showConfirmButton: true
            });
            $("#search_descripcion").focus();
            return false;
        }

        $.ajax({
            url: '<?= base_url(); ?>index.php/almacen/kardex/balancear_stock/',
            type: "POST",
            data: {
                producto: producto,
                descripcion: search_descripcion,
                almacen: almacen,
                fechai: search_fechai,
                fechaf: search_fechaf
            },
            dataType: "json",
            beforeSend: function(data) {
                $(".image-container").show();
                $("#balance_stock").hide();
            },
            success: function(data) {
                $(".image-container").hide();
                $("#balance_stock").show();
                if (data.resultado == "true") {
                    Swal.fire({
                        icon: "success",
                        title: "Ejecucion completada",
                        html: "",
                        showConfirmButton: true
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

    function search_original(search = true) {
        if (search == true) {
            producto = $("#producto").val();
            search_descripcion = $("#search_descripcion").val();
            search_fechai = $("#search_fechai").val();
            search_fechaf = $("#search_fechaf").val();
            almacen = $("#almacen").val();
            if (producto == "" || producto == null) {
                Swal.fire({
                    icon: "warning",
                    title: "Debe ingresar un producto",
                    html: "<b class='color-red'>Para realizar la busqueda debe seleccionar un producto</b>",
                    showConfirmButton: true
                });
                $("#search_descripcion").focus();
                return false;
            }
        } else {
            $("#search_descripcion").val("");
            $("#producto").val("");
            $("#search_fechai").val("");
            $("#search_fechaf").val("");
            $("#almacen").val("");

            search_codigo = "";
            search_descripcion = "";
            search_tipo = "";
            search_fechai = "";
            search_fechaf = "";
            almacen = "";
            producto = "";
        }

        $('#table-movimiento').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            paging: false,
            ajax: {
                url: '<?= base_url(); ?>index.php/almacen/kardex/datatable_kardex/',
                type: "POST",
                data: {
                    producto: producto,
                    descripcion: search_descripcion,
                    almacen: almacen,
                    fechai: search_fechai,
                    fechaf: search_fechaf
                },
                beforeSend: function() {
                    $("#table-movimiento .loading-table").show();
                },
                error: function() {},
                complete: function() {
                    $("#table-movimiento .loading-table").hide();
                }
            },
            language: spanish,
            columnDefs: [{
                "className": "dt-center",
                "targets": 0
            }],
            order: [
                [1, "desc"]
            ]
        });
    }

    function dele_al_kardex() {
        var producto = $("#producto").val();
        var search_descripcion = $("#search_descripcion").val();
        var search_fechai = $("#search_fechai").val();
        var search_fechaf = $("#search_fechaf").val();
        var almacen = $("#almacen").val();
        //var ult_inventario = $("#switch").val();
        var ult_inventario = document.getElementById("switch");
        if (ult_inventario.checked == true) {
            var ult_inventario = 1;
        } else {
            var ult_inventario = 0;
        }
        $.ajax({
            url: '<?= base_url(); ?>index.php/almacen/kardex/ingreso_a_kardex/',
            type: "POST",
            data: {
                producto: producto,
                descripcion: search_descripcion,
                almacen: almacen,
                ult_inventario: ult_inventario,
                fechai: search_fechai,
                fechaf: search_fechaf
            },
            dataType: "json",
            beforeSend: function(data) {
                $(".image-container").show();
                $("#balance_stock_total").hide();
            },
            success: function(data) {
                $(".image-container").hide();
                $("#balance_stock_total").show();
                if (data.response == "true" && data.resultado == "true") {
                    Swal.fire({
                        icon: "success",
                        title: "Ejecucion completada",
                        html: "",
                        showConfirmButton: true
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
</script>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="https://www.google.com.pe/?hl=es">Hacer clic</a>
</body>
</html>