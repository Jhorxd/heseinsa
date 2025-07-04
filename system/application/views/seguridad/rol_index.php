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
            <div class="col-sm-9 col-md-9 col-lg-9"></div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="nombre_rol" id="nombre_rol" value="" placeholder="Buscar rol" class="form-control h-1"/>
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_rol'>Rol</li>
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
                    <table class="fuente8 display" id="table-rol">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="false">N°</td>
                                <td style="width:75%" data-orderable="true">DESCRIPCIÓN</td>
                                <td style="width:05%" data-orderable="false"></td>
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

<div id="add_rol" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formRol" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR ROL</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="rol" name="rol" value="">

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="rol_nombre">DESCRIPCIÓN</label>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <input type="text" id="rol_nombre" name="rol_nombre" class="form-control" placeholder="DESCRIPCIÓN DEL ROL" value="">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            <table class="fuente8 display" id="table-permisos">
                                <thead>
                                    <th style="width:10%;" data-orderable="false">ACTIVAR</th>
                                    <th style="width:90%;" data-orderable="false">DESCRIPCIÓN</th>
                                </thead>
                                <tbody> <?php
                                    if ($modulos != NULL){
                                        foreach ($modulos as $j => $permisos) {
                                            $size = count($permisos["permiso"]);

                                            for ( $i = 0; $i < $size; $i++ ){ ?>
                                                <tr>
                                                    <td <?=($permisos["modulo"][$i] == true) ? "class='header'" : "";?>>
                                                        <input type="checkbox" name="permiso[]" class="form-control h-1 permiso <?=($permisos['modulo'][$i] == true) ? '' : 'auto-check-'.$j;?> check-<?=$permisos['permiso'][$i];?>" value="<?=$permisos['permiso'][$i];?>" <?=($permisos["modulo"][$i] == true) ? "onclick='autocheck($j)'" : "";?>>
                                                    </td>
                                                    <td <?=($permisos["modulo"][$i] == true) ? "class='header'" : "";?>> <?=$permisos["descripcion"][$i];?> </td>
                                                </tr> <?php
                                            }
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_rol()">Guardar Registro</button>
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
        $('#table-rol').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/seguridad/rol/datatable_rol/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-rol .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-rol .loading-table").hide();
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

        $('#nombre_rol').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });

        $('#table-permisos').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            autoWidth: false,
            language: spanish,
            paging: false,
            columnDefs: [{"className": "dt-center", "targets": 0}]
        });
    });

    function search( search = true){
        if (search == true){
            nombre = $("#nombre_rol").val();
        }
        else{
            $("#nombre_rol").val("");
            nombre = "";
        }
        
        $('#table-rol').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/seguridad/rol/datatable_rol/',
                    type: "POST",
                    data: {
                            nombre: nombre
                    },
                    beforeSend: function(){
                        $("#table-rol .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-rol .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });
    }

    function autocheck(i){
        if ( $(".auto-check-"+i).is(":checked") ){
            console.log(0);
            $(".auto-check-"+i).removeAttr("checked");
        }
        else{
            console.log(1);
            $(".auto-check-"+i).attr("checked", "true");
        }
    }

    function editar(id){
        var url = base_url + "index.php/seguridad/rol/getPermisos";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    rol: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;
                    $("#rol").val(info.rol);
                    $("#rol_nombre").val(info.descripcion);

                    $.each(info.permisos, function(i,item){
                        $(".check-"+item).attr("checked", "true");
                    });

                    $("#add_rol").modal("toggle");
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

    function registrar_rol(){
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
                        var rol = $("#rol").val();
                        var url = base_url + "index.php/seguridad/rol/guardar_registro";
                        var nombre = $("#rol_nombre").val();
                        validacion = true;

                        if (nombre == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un nombre.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#rol_nombre").focus();
                            validacion = false;
                        }

                        if (validacion == true){
                            var info = $("#formRol").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (rol == "")
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
                                    search(false);
                                    $("#rol_nombre").focus();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(rol){
        Swal.fire({
                    icon: "info",
                    title: "¿Esta seguro de eliminar el registro seleccionado?",
                    html: "<b class='color-red'>Esta acción no se puede deshacer.</b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var url = base_url + "index.php/seguridad/rol/deshabilitar_rol";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                rol: rol
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
                                        html: "<b class='color-red'>La información no pudo ser eliminada, intentelo nuevamente.</b>",
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
        $("#rol").val("");
        $(".permiso").removeAttr("checked");
        $("#formRol")[0].reset();
    }
</script>