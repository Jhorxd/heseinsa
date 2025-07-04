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
            <div class="col-sm-4 col-md-4 col-lg-4"></div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="search_codigo" id="search_codigo" value="" placeholder="Código de caja" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Nombre de la caja" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <select name="search_tipo" id="search_tipo" class="form-control w-porc-90 h-2 w-porc-90">
                    <option value=""> :: TODAS :: </option> <?php
                    if ($tipo_caja != NULL){
                        foreach ($tipo_caja as $indice => $val){ ?>
                            <option value="<?=$val->tipCa_codigo;?>"><?=$val->tipCa_Descripcion;?></option> <?php
                        }
                    } ?>
                </select>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul class="lista_botones">
                                <li id="nuevo" data-toggle='modal' data-target='#add_caja'>Caja</li>
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
                    <table class="fuente8 display" id="table-caja">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="false">N°</td>
                                <td style="width:10%" data-orderable="true">CÓDIGO</td>
                                <td style="width:25%" data-orderable="true">NOMBRE</td>
                                <td style="width:15%" data-orderable="true">TIPO DE CAJA</td>
                                <td style="width:30%" data-orderable="true">OBSERVACIONES</td>
                                <td style="width:05%" data-orderable="false"></td>
                                <td style="width:05%" data-orderable="false"></td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add_caja" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formCaja" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title text-center">REGISTRAR CAJA</h4>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="caja" name="caja" value="">

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="codigo_caja">CÓDIGO</label>
                            <input type="text" id="codigo_caja" name="codigo_caja" class="form-control h-2 w-porc-90" placeholder="Indique el codigo" value="" maxlength="30">
                        </div>
                        <div class="col-sm-4 col-md-4 col-lg-4">
                            <label for="nombre_caja">NOMBRE *</label>
                            <input type="text" id="nombre_caja" name="nombre_caja" class="form-control h-2" placeholder="Indique la caja" value="" maxlength="200">
                        </div>

                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tipo_caja">TIPO</label>
                            <select name="tipo_caja" id="tipo_caja" class="form-control w-porc-90 h-3"> <?php
                                if ($tipo_caja != NULL){
                                    foreach ($tipo_caja as $indice => $val){ ?>
                                        <option value="<?=$val->tipCa_codigo;?>"><?=$val->tipCa_Descripcion;?></option> <?php
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-10 col-md-10 col-lg-10">
                            <label for="obs_caja">OBSERVACIONES</label>
                            <textarea class="form-control h-5" id="obs_caja" name="obs_caja" placeholder="Indique las observaciones" maxlength="800"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_caja()">Guardar Registro</button>
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
        $('#table-caja').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/tesoreria/caja/datatable_caja/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-caja .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-caja .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });

        $("#buscarC").click(function(){
            search();
        });

        $("#limpiarC").click(function(){
            search(false);
        });

        $('#form_busqueda').keypress(function(e){
            if ( e.which == 13 ){
                return false;
            } 
        });

        $('#search_descripcion').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });
    });

    function search( search = true){
        if (search == true){
            search_codigo = $("#search_codigo").val();
            search_descripcion = $("#search_descripcion").val();
            search_tipo = $("#search_tipo").val();
        }
        else{
            $("#search_codigo").val("");
            $("#search_descripcion").val("");
            $("#search_tipo").val("");
            search_codigo = "";
            search_descripcion = "";
            search_tipo = "";
        }
        
        $('#table-caja').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/tesoreria/caja/datatable_caja/',
                    type: "POST",
                    data: {
                            codigo: search_codigo,
                            descripcion: search_descripcion,
                            tipo: search_tipo,
                    },
                    beforeSend: function(){
                        $("#table-caja .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-caja .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/tesoreria/caja/getCaja";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    caja: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#caja").val(info.caja);
                    $("#codigo_caja").val(info.codigo);
                    $("#nombre_caja").val(info.nombre);
                    $("#tipo_caja").val(info.tipocaja);
                    $("#obs_caja").val(info.obs);

                    $("#add_caja").modal("toggle");
                }
                else{
                    Swal.fire({
                                icon: "info",
                                title: "Información no disponible.",
                                html: "<b class='color-red'></b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                }
            },
            complete: function(){
            }
        });
    }

    function registrar_caja(){
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
                        var caja = $("#caja").val();
                        var descripcion = $("#nombre_caja").val();
                        validacion = true;

                        if (descripcion == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un nombre para la caja.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#nombre_caja").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/tesoreria/caja/guardar_registro";
                            var info = $("#formCaja").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (caja == "")
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
                                    $("#nombre_caja").focus();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(caja){
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
                        var url = base_url + "index.php/tesoreria/caja/deshabilitar_caja";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                caja: caja
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
                                }
                                else{
                                    Swal.fire({
                                        icon: "error",
                                        title: "Sin cambios.",
                                        html: "<b class='color-red'>Algo ha ocurrido, verifique he intentelo nuevamente.</b>",
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
        $("#formCaja")[0].reset();
        $("#caja").val("");
    }
</script>