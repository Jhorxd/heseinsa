<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_codigo">CÓDIGO DE CAJA</label>
                <select name="search_codigo" id="search_codigo" class="form-control w-porc-90 h-2">
                    <option value=""> :: TODOS :: </option> <?php
                    if ($caja != NULL){
                        foreach ($caja as $indice => $val){ ?>
                            <option value="<?=$val->CAJA_Codigo;?>"><?=$val->CAJA_Nombre;?></option> <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_descripcion">NOMBRE DE CAJA</label>
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Nombre de la caja" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_tipo">TIPO DE CAJA</label>
                <select name="search_tipo" id="search_tipo" class="form-control w-porc-90 h-2 w-porc-90">
                    <option value=""> :: TODAS :: </option> <?php
                    if ($tipo_caja != NULL){
                        foreach ($tipo_caja as $indice => $val){ ?>
                            <option value="<?=$val->tipCa_codigo;?>"><?=$val->tipCa_Descripcion;?></option> <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_fechai">FECHA INICIO</label>
                <input type="date" name="search_fechai" id="search_fechai" value="" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_fechaf">FECHA FIN</label>
                <input type="date" name="search_fechaf" id="search_fechaf" value="" class="form-control h-1 w-porc-90"/>
            </div>
        </div>

    </form>
    <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2">
               
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="total_ingreso">TOTAL INGRESO S./</label>
                <input type="text" name="total_ingreso" id="total_ingreso" value="" class="form-control h-1 w-porc-90" readonly style="border: 0px; background: #f5f2f5; font-weight: bolder;"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="total_salida">TOTAL SALIDA</label>
                <input type="text" name="total_salida" id="total_salida" value="" class="form-control h-1 w-porc-90" readonly style="border: 0px; background: #f5f2f5; font-weight: bolder;"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="balance">BALANCE TOTAL</label>
                <input type="text" name="balance" id="balance" value=""  class="form-control h-1 w-porc-90" readonly style="border: 0px; background: #f5f2f5; font-weight: bolder;"/>
            </div>
        </div>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul class="lista_botones">
                                <li id="imprimir" class="pdfMovimientos">Reporte</li>
                            </ul>
                            <ul class="lista_botones">
                                <li id="nuevo" data-toggle='modal' data-target='#add_movimiento' onclick="clean();">Movimiento</li>
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
                    <div class="header text-align-center"><?=$titulo;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="table-movimiento">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:07%" data-orderable="true" title="Fecha de registro.">FECHA REG.</td>
                                <td style="width:10%" data-orderable="true" title="Nombre de la caja">NOMBRE</td>
                                <td style="width:10%" data-orderable="true" title="Tipo de caja">TIPO DE CAJA</td>
                                
                                <td style="width:10%" data-orderable="true" title="Importe del movimiento">MONTO</td>
                                <td style="width:10%" data-orderable="true" title="Tipo de movimiento">MOVIMIENTO</td>
                                <td style="width:30%" data-orderable="true" title="Tipo de movimiento">JUSTIFICACION</td>
                                <td style="width:05%" data-orderable="false" title=""></td>
                                <td style="width:05%" data-orderable="false" title=""></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



<div id="add_movimiento" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formMovimiento" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title text-center"><span id="modal_titulo">REGISTRAR</span> MOVIMIENTO</h4>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="movimiento" name="movimiento" value="">

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="caja">CAJA</label>
                            <select name="caja" id="caja" class="form-control w-porc-90 h-3"> <?php
                                if ($caja != NULL){
                                    foreach ($caja as $indice => $val){ ?>
                                        <option value="<?=$val->CAJA_Codigo;?>"><?=$val->CAJA_Nombre;?></option> <?php
                                    }
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tipo_movimiento">MOVIMIENTO</label>
                            <select name="tipo_movimiento" id="tipo_movimiento" class="form-control w-porc-90 h-3">
                                <option value="1">INGRESO</option>
                                <option value="2">SALIDA</option>
                            </select>
                        </div>

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="fecha">FECHA *</label>
                            <input type="date" id="fecha" name="fecha" class="form-control h-2" value=""/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="forma_pago">FORMA DE PAGO</label>
                            <select name="forma_pago" id="forma_pago" class="form-control w-porc-90 h-3"> <?php
                                if ($forma_pago != NULL){
                                    foreach ($forma_pago as $indice => $val){ ?>
                                        <option value="<?=$val->FORPAP_Codigo;?>"><?=$val->FORPAC_Descripcion;?></option> <?php
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="moneda">MONEDA</label>
                            <select name="moneda" id="moneda" class="form-control w-porc-90 h-3"> <?php
                                if ($moneda != NULL){
                                    foreach ($moneda as $indice => $val){ ?>
                                        <option value="<?=$val->MONED_Codigo;?>"><?="$val->MONED_Simbolo | $val->MONED_Descripcion";?></option> <?php
                                    }
                                } ?>
                            </select>
                        </div>

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="importe">MONTO *</label>
                            <input type="number" step="1" min="0" id="importe" name="importe" class="form-control h-2 w-porc-90" placeholder="Total" value=""/>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="justificacion">JUSTIFICACIÓN *</label>
                            <textarea class="form-control h-5" id="justificacion" name="justificacion" placeholder="Indique una justificación" maxlength="800"></textarea>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="obs_movimiento">OBSERVACIÓN</label>
                            <textarea class="form-control h-5" id="obs_movimiento" name="obs_movimiento" placeholder="Indique una observación" maxlength="800"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success registrar_movimiento" accesskey="x" onclick="registrar_movimiento()">Guardar Registro</button>
                    <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    base_url = "<?=$base_url;?>";

    $(document).ready(function(){
        balance_caja();
        $('#table-movimiento').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/tesoreria/movimiento/datatable_movimiento/',
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
        });

        $("#buscarC").click(function(){
            search();
            balance_caja();
        });

        $("#limpiarC").click(function(){
            search(false);
            balance_caja();
        });

        $('#form_busqueda').keypress(function(e){
            if ( e.which == 13 ){
                return false;
            } 
        });

        $('#search_codigo, #search_descripcion').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });

        $(".pdfMovimientos").click(function(){
            codigo = $("#search_codigo").val();
            fechai = $("#search_fechai").val();
            fechaf = $("#search_fechaf").val();

            if ( codigo != "" && fechai != "" && fechaf != "" ){
                url = base_url + "index.php/tesoreria/movimiento/resumen_movimientos_pdf/" + codigo + "/" + fechai + "/" + fechaf;
                $.fancybox.open({
                    src: url,
                    type: 'iframe'
                });
            }
            else{
                Swal.fire({
                        icon: "info",
                        title: "Debe completar los filtros",
                        html: "<b class='color-red'>Debe seleccionar la caja, fecha de inicio y fecha de fin.</b>",
                        showConfirmButton: true,
                        timer: 4000
                });
            }
        });
    });

    function search( search = true){
        if (search == true){
            search_codigo = $("#search_codigo").val();
            search_descripcion = $("#search_descripcion").val();
            search_tipo = $("#search_tipo").val();

            search_fechai = $("#search_fechai").val();
            search_fechaf = $("#search_fechaf").val();
        }
        else{
            $("#search_codigo").val("");
            $("#search_descripcion").val("");
            $("#search_tipo").val("");
            $("#search_fechai").val("");
            $("#search_fechaf").val("");

            search_codigo = "";
            search_descripcion = "";
            search_tipo = "";
            search_fechai = "";
            search_fechaf = "";
        }
        
        $('#table-movimiento').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/tesoreria/movimiento/datatable_movimiento/',
                    type: "POST",
                    data: {
                            codigo: search_codigo,
                            descripcion: search_descripcion,
                            tipo: search_tipo,
                            fechai: search_fechai,
                            fechaf: search_fechaf
                    },
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
        });
    }

    function view(id){
        var url = base_url + "index.php/tesoreria/movimiento/getMovimiento";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    movimiento: id
            },
            beforeSend: function(){
                clean();
                $(".registrar_movimiento").hide();
                $("#modal_titulo").html("VER");

                $("#caja").attr({"disabled": true});
                $("#tipo_movimiento").attr({"disabled": true});
                $("#fecha").attr({"disabled": true});
                $("#forma_pago").attr({"disabled": true});
                $("#moneda").attr({"disabled": true});
                $("#importe").attr({"disabled": true});
                $("#justificacion").attr({"disabled": true});
                $("#obs_movimiento").attr({"disabled": true});
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#movimiento").val(info.movimiento);
                    $("#caja").val(info.caja);
                    $("#tipo_movimiento").val(info.tipo_movimiento);
                    $("#fecha").val(info.fecha);
                    $("#forma_pago").val(info.forma_pago);
                    $("#moneda").val(info.moneda);
                    $("#importe").val(info.importe);
                    $("#justificacion").val(info.justificacion);
                    $("#obs_movimiento").val(info.obs_movimiento);

                    $("#add_movimiento").modal("toggle");
                }
                else{
                    Swal.fire({
                                icon: "info",
                                title: "Información no disponible.",
                                html: "<b class='color-red'></b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                    clean();
                }
            },
            complete: function(){
            }
        });
    }

    function registrar_movimiento(){
        Swal.fire({
                    icon: "info",
                    title: "¿Esta seguro de guardar el registro?",
                    html: "<b class='color-red'></b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var movimiento = $("#movimiento").val();
                        var fecha = $("#fecha").val();
                        var importe = $("#importe").val();
                        var justificacion = $("#justificacion").val();
                        validacion = true;

                        if (fecha == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar la fecha del movimiento.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#fecha").focus();
                            validacion = false;
                            return null;
                        }

                        if (importe == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar el importe del movimiento.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#importe").focus();
                            validacion = false;
                            return null;
                        }

                        if (justificacion == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar una justificación.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#justificacion").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/tesoreria/movimiento/guardar_registro";
                            var info = $("#formMovimiento").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (movimiento == "")
                                            titulo = "¡Registro exitoso!";
                                        else
                                            titulo = "¡Actualización exitosa!";

                                        Swal.fire({
                                            icon: "success",
                                            title: titulo,
                                            showConfirmButton: true,
                                            timer: 2000
                                        });

                                        clean();
                                        $("#limpiarC").click();
                                    }
                                    else{
                                        Swal.fire({
                                            icon: "error",
                                            title: "Sin cambios.",
                                            html: "<b class='color-red'>La información no fue registrada/actualizada, intentelo nuevamente.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                    }
                                },
                                complete: function(){
                                    $("#nombre_movimiento").focus();
                                }
                            });
                        }
                    }
                });
    }

    function balance_caja(){
        search_codigo       = $("#search_codigo").val();
        search_descripcion  = $("#search_descripcion").val();
        search_tipo         = $("#search_tipo").val();
        search_fechai       = $("#search_fechai").val();
        search_fechaf       = $("#search_fechaf").val();

        var url = base_url + "index.php/tesoreria/movimiento/balance_caja";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                codigo: search_codigo,
                descripcion: search_descripcion,
                tipo: search_tipo,
                fechai: search_fechai,
                fechaf: search_fechaf
            },
            beforeSend: function(){
            },
            success: function(data){
               
                    $("#total_ingreso").val(data.total_ingreso);
                    $("#total_salida").val(data.total_salida);
                    $("#balance").val(data.balance);
                    
            },
            complete: function(){
            }
        });
    }


    function deshabilitar(movimiento){
        Swal.fire({
                    icon: "info",
                    title: "Debe confirmar esta acción.",
                    html: "<b class='color-red'>Esta acción no se puede deshacer</b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var url = base_url + "index.php/tesoreria/movimiento/deshabilitar_movimiento";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                movimiento: movimiento
                            },
                            success: function(data){
                                if (data.result == "success") {
                                    titulo = "¡Registro eliminado!";
                                    Swal.fire({
                                        icon: "success",
                                        title: titulo,
                                        showConfirmButton: true,
                                        timer: 2000
                                    });
                                    $("#limpiarC").click();
                                }
                                else{

                                    msj = "Algo ha ocurrido, verifique he intentelo nuevamente.";
                                    if (data.mensaje != "")
                                        msj = data.mensaje;

                                    Swal.fire({
                                        icon: "error",
                                        title: "Sin cambios.",
                                        html: "<b class='color-red'>" + msj + "</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                                }
                            },
                            complete: function(){
                                search(false);
                            }
                        });
                    }
                });
    }

    function clean(){
        $("#modal_titulo").html("REGISTRAR");
        $("#caja").removeAttr("disabled");
        $("#tipo_movimiento").removeAttr("disabled");
        $("#fecha").removeAttr("disabled");
        $("#forma_pago").removeAttr("disabled");
        $("#moneda").removeAttr("disabled");
        $("#importe").removeAttr("disabled");
        $("#justificacion").removeAttr("disabled");
        $("#obs_movimiento").removeAttr("disabled");
        $(".registrar_movimiento").show();

        $("#formMovimiento")[0].reset();
        $("#movimiento").val("");
    }
</script>