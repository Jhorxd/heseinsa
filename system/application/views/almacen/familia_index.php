<script type="text/javascript" src="<?php echo base_url();?>js/almacen/familia.js?=<?=JS;?>"></script>

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
                <input type="text" name="nombre_familia" id="nombre_familia" value="" placeholder="Buscar familia" class="form-control h-1" autocomplete="off"/>
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_familia'>familia</li>
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
                    <table class="fuente8 display" id="table-familia">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:05%" data-orderable="false">N°</td>
                                <td style="width:25%" data-orderable="true">CODIGO INTERNO</td>
                                <td style="width:60%" data-orderable="false">DESCRIPCIÓN</td>
                                <td style="width:05%" data-orderable="false">EDITAR</td>
                                <td style="width:05%" data-orderable="false">ELIMINAR</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add_familia" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formfamilia" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR FAMILIA</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="familia" name="familia" value="">
                    <input type="hidden" id="flagBS" name="flagBS" value="<?php echo $flagBS;?>">
                    <div class="row">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="familia_descripcion">CÓDIGO</label>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <input type="text" id="familia_descripcion" name="familia_descripcion" class="form-control" placeholder="Codigo Interno" value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="familia_nombre">NOMBRE</label>
                        </div>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            <input type="text" id="familia_nombre" name="familia_nombre" class="form-control" placeholder="Nombre" value="">
                        </div>
                    </div>
                    <br>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_familia()">Guardar Registro</button>
                    <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="clean()">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    base_url = "<?=$base_url;?>";

    $(document).ready(function(){
        flagBS = $("#flagBS").val();
        $('#table-familia').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/familia/datatable_familia/',
                    type: "POST",
                    data: { dataString: "",flagBS:flagBS },
                    beforeSend: function(){
                        $("#table-familia .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-familia .loading-table").hide();
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

        $('#nombre_familia').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });
    });

    function search( search = true){
        if (search == true){
            nombre = $("#nombre_familia").val();
            flagBS = $("#flagBS").val();
        }
        else{
            
            flagBS = $("#flagBS").val();
            nombre = "";
        }

        
        $('#table-familia').DataTable({
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/familia/datatable_familia/',
                    type: "POST",
                    data: {
                            flagBS: flagBS,
                            nombre: nombre
                    },
                    beforeSend: function(){
                        $("#table-familia .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-familia .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/almacen/familia/getfamilia";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    familia: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;
                    $("#familia").val(info.familia);
                    $("#familia_nombre").val(info.nombre);
                    $("#familia_descripcion").val(info.descripcion);

                    $("#add_familia").modal("toggle");
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
                $("#limpiarC").click();                    
            }
        });
    }

    function registrar_familia(){
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
                        var familia     = $("#familia").val();
                        var url         = base_url + "index.php/almacen/familia/guardar_registro";
                        var nombre      = $("#familia_nombre").val();
                        var descripcion = $("#familia_descripcion").val();
                        var flagBS      = $("#flagBS").val();
                        validacion      = true;

                        if (nombre == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un nombre.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#familia_descripcion").focus();
                            validacion = false;
                        }

                        if (validacion == true){
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: {
                                    familia: familia,
                                    familia_nombre: nombre,
                                    flagBS: flagBS,
                                    familia_descripcion: descripcion
                                },
                                success: function(data){
                                    if (data.result == "success") {
                                        if (familia == "")
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
                                    $("#familia_nombre").focus();
                                    $("#limpiarC").click();

                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(familia){
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
                        var url = base_url + "index.php/almacen/familia/deshabilitar_familia";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                familia: familia
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
                                $("#limpiarC").click();
                            }
                        });
                    }
                });
    }

    function clean(){
        $("#familia").val("");
        $("#familia_nombre").val("");
        $("#familia_descripcion").val("");
    }
</script>