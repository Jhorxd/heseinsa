<script type="text/javascript" src="<?php echo base_url(); ?>js/almacen/almacen.js?=<?=JS;?>"></script>

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
            <div class="col-sm-7 col-md-7 col-lg-7"></div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Descripción" class="form-control h-1"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <select id="search_tipo" name="search_tipo" class="form-control h-2">
                    <option value=""> :: TODOS :: </option> <?php
                    foreach ($tipo_almacen as $i => $val){ ?>
                        <option value="<?=$val->TIPALMP_Codigo;?>"><?=$val->TIPALM_Descripcion;?></option> <?php
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_almacen'>Almacen</li>
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
                    <table class="fuente8 display" id="table-almacen">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="true">CÓDIGO</td>
                                <td style="width:20%" data-orderable="true">ESTABLECIMIENTO</td>
                                <td style="width:10%" data-orderable="true">NOMBRE ALMACEN</td>
                                <td style="width:10%" data-orderable="true">TIPO DE ALMACEN</td>
                                <td style="width:40%" data-orderable="true">DIRECCIÓN</td>
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

<div id="add_almacen" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formAlmacen" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR ALMACEN</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="almacen" name="almacen" value="">

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="establecimiento">ESTABLECIMIENTO</label>
                            <input type="text" name="establecimiento" readOnly class="form-control h-2 w-porc-90" value="<?=$nombre_establecimiento;?>">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="codigo_almacen">CÓDIGO DE ALMACEN</label>
                            <input type="text" id="codigo_almacen" name="codigo_almacen" class="form-control h-2 w-porc-90" placeholder="Indique el codigo" value="">
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="descripcion_almacen">DESCRIPCIÓN DE ALMACEN *</label>
                            <input type="text" id="descripcion_almacen" name="descripcion_almacen" class="form-control h-2" placeholder="Indique la almacen" value="">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tipo_almacen">TIPO</label>
                            <select id="tipo_almacen" name="tipo_almacen" class="form-control h-3"> <?php
                                foreach ($tipo_almacen as $i => $val){ ?>
                                    <option value="<?=$val->TIPALMP_Codigo;?>"><?=$val->TIPALM_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-7 col-md-7 col-lg-7">
                            <label for="direccion_almacen">DIRECCIÓN DEL ALMACEN</label>
                            <textarea id="direccion_almacen" name="direccion_almacen" class="form-control h-5" placeholder="Indique la dirección del almacen."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_almacen()">Guardar Registro</button>
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
        $('#table-almacen').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/almacen/datatable_almacen/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-almacen .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-almacen .loading-table").hide();
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
            search_descripcion = $("#search_descripcion").val();
            search_tipo = $("#search_tipo").val();
        }
        else{
            $("#search_descripcion").val("");
            $("#search_tipo").val("");
            search_descripcion = "";
            search_tipo = "";
        }
        
        $('#table-almacen').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/almacen/datatable_almacen/',
                    type: "POST",
                    data: {
                            descripcion: search_descripcion,
                            tipo: search_tipo
                    },
                    beforeSend: function(){
                        $("#table-almacen .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-almacen .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/almacen/almacen/getAlmacen";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    almacen: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#almacen").val(info.almacen);
                    $("#codigo_almacen").val(info.codigo);
                    $("#descripcion_almacen").val(info.descripcion);
                    $("#tipo_almacen").val(info.tipo);
                    $("#direccion_almacen").val(info.direccion);

                    $("#add_almacen").modal("toggle");
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

    function registrar_almacen(){
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
                        var almacen = $("#almacen").val();
                        var descripcion = $("#descripcion_almacen").val();
                        validacion = true;

                        if (descripcion == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar una descripcion.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#descripcion_almacen").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/almacen/almacen/guardar_registro";
                            var info = $("#formAlmacen").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (almacen == "")
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
                                    $("#descripcion_almacen").focus();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(almacen){
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
                        var url = base_url + "index.php/almacen/almacen/deshabilitar_almacen";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                almacen: almacen
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
        $("#formAlmacen")[0].reset();
        $("#almacen").val("");
    }
</script>