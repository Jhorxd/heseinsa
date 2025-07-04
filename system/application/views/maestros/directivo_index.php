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
                <label for="search_codigo">Código de empleado</label>
                <input type="text" name="search_codigo" id="search_codigo" value="" placeholder="Código" class="form-control h-1 w-porc-90" autocomplete="off"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_documento">Número de documento</label>
                <input type="text" name="search_documento" id="search_documento" value="" placeholder="Documento" class="form-control h-1 w-porc-90" autocomplete="off"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="nombre_empleado">Nombre</label>
                <input type="text" name="nombre_empleado" id="nombre_empleado" value="" placeholder="Buscar empleado" class="form-control h-1 w-porc-90" autocomplete="off"/>
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_empleado'>Empleado</li>
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
                    <table class="fuente8 display" id="table-empleado">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="true">ID EMPLEDADO</td>
                                <td style="width:05%" data-orderable="true">DNI</td>
                                <td style="width:20%" data-orderable="true">NOMBRES</td>
                                <td style="width:20%" data-orderable="true">APELLIDOS</td>
                                <td style="width:20%" data-orderable="true">CARGO</td>
                                <td style="width:05%" data-orderable="false"></td>
                                <td style="width:05%" data-orderable="false"></td>
                                <td style="width:05%" data-orderable="false"></td>
                                <td style="width:10%" data-orderable="false">CLIENTES</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add_empleado" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog w-porc-80">
        <div class="modal-content">
            <form id="formEmpleado" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR EMPLEADO</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="empleado" name="empleado" value="">

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>INFORMACIÓN DEL EMPLEADO</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="tipo_documento">Tipo de documento</label>
                            <select id="tipo_documento" name="tipo_documento" class="form-control h-3 w-porc-80"><?php
                                foreach ($documentos as $i => $val){ ?>
                                    <option value="<?=$val->TIPDOCP_Codigo;?>"><?=$val->TIPOCC_Inciales;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="numero_documento">Número de documento (*)</label>
                            <input type="number" id="numero_documento" name="numero_documento" class="form-control h-2 w-porc-90" placeholder="Número de documento" value="" autocomplete="off">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="numero_ruc">Número de ruc</label>
                            <input type="number" id="numero_ruc" name="numero_ruc" class="form-control h-2" placeholder="Indique el número de RUC" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="nombres">Nombres (*)</label>
                            <input type="text" id="nombres" name="nombres" class="form-control h-2 w-porc-90" placeholder="Indique el nombre completo" value="" autocomplete="off">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="apellido_paterno">Apellido paterno (*)</label>
                            <input type="text" id="apellido_paterno" name="apellido_paterno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido paterno" value="" autocomplete="off">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="apellido_materno">Apellido materno (*)</label>
                            <input type="text" id="apellido_materno" name="apellido_materno" class="form-control h-2 w-porc-90" placeholder="Indique el apellido materno" value="" autocomplete="off">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="fecha_nacimiento">Fecha de nacimiento (*)</label>
                            <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control h-2 w-porc-90" val="">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                            <label for="genero">Genero</label>
                            <select id="genero" name="genero" class="form-control h-3">
                                <option value="M">Masculino</option>
                                <option value="F">Femenino</option>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                            <label for="edo_civil">Estado civil</label>
                            <select id="edo_civil" name="edo_civil" class="form-control h-3"> <?php
                                foreach ($edo_civil as $i => $val) { ?>
                                    <option value="<?=$val->ESTCP_Codigo?>"><?=$val->ESTCC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                            <label for="nacionalidad">Nacionalidad</label>
                            <select id="nacionalidad" name="nacionalidad" class="form-control h-3"> <?php
                                foreach ($nacionalidad as $i => $val) { ?>
                                    <option value="<?=$val->NACP_Codigo;?>" <?=($val->NACP_Codigo == 193) ? "selected" : '';?> ><?=$val->NACC_Descripcion;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2"></div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 form-group">
                            <label for="direccion">Dirección de residencia (*)</label>
                            <textarea id="direccion" name="direccion" class="form-control"></textarea>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>INFORMACIÓN DEL CONTRATACIÓN</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                            <label for="cargo">Cargo</label>
                            <select id="cargo" name="cargo" class="form-control h-3"> <?php
                                foreach ($cargos as $i => $val) { ?>
                                    <option value="<?=$val->CARGP_Codigo;?>" title="<?=$val->CARGC_Descripcion;?>"><?=$val->CARGC_Nombre;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="numero_contrato">Número de contrato</label>
                            <input type="number" id="numero_contrato" name="numero_contrato" class="form-control h-2 w-porc-90" placeholder="Indique el número de contrato" value="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="fecha_inicio">Fecha de inicio</label>
                            <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control h-2 w-porc-90" val="">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="fecha_final">Fecha de vencimiento</label>
                            <input type="date" id="fecha_final" name="fecha_final" class="form-control h-2 w-porc-90" val="">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>CUENTA BANCARIA</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                            <label for="banco">Banco</label>
                            <select id="banco" name="banco" class="form-control h-3">
                                <option value=""> :: SELECCIONE :: </option> <?php
                                foreach ($bancos as $i => $val) { ?>
                                    <option value="<?=$val->BANP_Codigo;?>" title="<?=$val->BANC_Nombre;?>"><?=$val->BANC_Siglas;?></option> <?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="cta_soles">CTA SOLES</label>
                            <input type="tel" id="cta_soles" name="cta_soles" class="form-control h-2 w-porc-90" placeholder="000 000 000 000" val="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="cta_dolares">CTA DOLARES</label>
                            <input type="tel" id="cta_dolares" name="cta_dolares" class="form-control h-2 w-porc-90" placeholder="000 000 000 000" val="" autocomplete="off">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>INFORMACIÓN DE CONTACTO</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="telefono">Telefono</label>
                            <input type="tel" id="telefono" name="telefono" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="movil">Movil</label>
                            <input type="tel" id="movil" name="movil" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="fax">Fax</label>
                            <input type="number" id="fax" name="fax" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="correo">Correo</label>
                            <input type="email" id="correo" name="correo" class="form-control h-2 w-porc-90" placeholder="empleado@empresa.com" val="" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="web">Dirección web</label>
                            <input type="url" id="web" name="web" class="form-control h-2 w-porc-90" placeholder="" val="http://www.google.com" autocomplete="off">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_empleado()">Guardar Registro</button>
                    <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script type="text/javascript">
    base_url = "<?=base_url();?>";

    $(document).ready(function(){
        $('#table-empleado').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/maestros/directivo/datatable_empleado/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-empleado .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-empleado .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0, "targets": 8}],
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

        $('#search_codigo, #search_documento, #nombre_empleado').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });
    });

    function search( search = true){
        if (search == true){
            codigo = $("#search_codigo").val();
            documento = $("#search_documento").val();
            nombre = $("#nombre_empleado").val();
        }
        else{
            $("#search_codigo").val("");
            $("#search_documento").val("");
            $("#nombre_empleado").val("");

            codigo = "";
            documento = "";
            nombre = "";
        }
        
        $('#table-empleado').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/maestros/directivo/datatable_empleado/',
                    type: "POST",
                    data: {
                            codigo: codigo,
                            documento: documento,
                            nombre: nombre
                    },
                    beforeSend: function(){
                        $("#table-empleado .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-empleado .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0, "targets": 8}],
            order: [[ 1, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/maestros/directivo/getEmpleado";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    empleado: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#tipo_documento").val(info.tipo_documento);
                    $("#numero_documento").val(info.numero_documento);
                    $("#numero_ruc").val(info.numero_ruc);
                    $("#nombres").val(info.nombres);
                    $("#apellido_paterno").val(info.apellido_paterno);
                    $("#apellido_materno").val(info.apellido_materno);
                    $("#fecha_nacimiento").val(info.fecha_nacimiento);
                    $("#genero").val(info.genero);
                    $("#edo_civil").val(info.edo_civil);
                    $("#nacionalidad").val(info.nacionalidad);
                    $("#telefono").val(info.telefono);
                    $("#movil").val(info.movil);
                    $("#fax").val(info.fax);
                    $("#correo").val(info.correo);
                    $("#web").val(info.web);
                    $("#direccion").val(info.direccion);
                    $("#direccion").val(info.direccion);

                    $("#banco").val(info.banco);
                    $("#cta_soles").val(info.cta_soles);
                    $("#cta_dolares").val(info.cta_dolares);

                    $("#empleado").val(info.empleado);
                    $("#cargo").val(info.cargo);
                    $("#numero_contrato").val(info.numero_contrato);
                    $("#fecha_inicio").val(info.fecha_inicio);
                    $("#fecha_final").val(info.fecha_final);
                    $("#codigo_empleado").val(info.codigo_empleado);

                    $("#add_empleado").modal("toggle");
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

    function registrar_empleado(){
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
                        var url = base_url + "index.php/maestros/directivo/guardar_registro";

                        empleado = $("#empleado").val();
                        numero_documento = $("#numero_documento").val();
                        nombres = $("#nombres").val();
                        apellido_paterno = $("#apellido_paterno").val();
                        apellido_materno = $("#apellido_materno").val();
                        fecha_nacimiento = $("#fecha_nacimiento").val();
                        direccion = $("#direccion").val();

                        validacion = true;

                        if (numero_documento == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un número de documento.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#numero_documento").focus();
                            validacion = false;
                            return false;
                        }

                        if (nombres == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar el nombre.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#nombres").focus();
                            validacion = false;
                            return false;
                        }

                        if (apellido_paterno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar el apellido paterno.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#apellido_paterno").focus();
                            validacion = false;
                            return false;
                        }

                        if (apellido_materno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar el apellido materno.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#apellido_materno").focus();
                            validacion = false;
                            return false;
                        }

                        if (fecha_nacimiento == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar la fecha de nacimiento.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#fecha_nacimiento").focus();
                            validacion = false;
                            return false;
                        }

                        if (direccion == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar la dirección.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#direccion").focus();
                            validacion = false;
                            return false;
                        }

                        if (validacion == true){
                            var dataForm = $("#formEmpleado").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: dataForm,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (empleado == "")
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
                                    $("#numero_documento").focus();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(empleado){
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
                        var url = base_url + "index.php/maestros/directivo/deshabilitar_empleado";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                empleado: empleado
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
                            }
                        });
                    }
                });
    }

    function clean(){
        $("#empleado").val("");
        $("#formEmpleado")[0].reset();
    }
</script>