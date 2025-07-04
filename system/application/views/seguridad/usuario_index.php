<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/seguridad/usuario.js?=<?=JS;?>"></script>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo_busqueda;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="searchNombres">NOMBRES</label>
                <input type="text" name="searchNombres" id="searchNombres" value="" placeholder="Nombres" class="form-control h-1 w-porc-90" autocomplete="off"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="searchUsuario">USUARIO</label>
                <input type="text" name="searchUsuario" id="searchUsuario" value="" placeholder="Usuario" class="form-control h-1 w-porc-90" autocomplete="off"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="searchRol">ROL</label>
                <input type="text" name="searchRol" id="searchRol" value="" placeholder="Rol" class="form-control h-1 w-porc-90" autocomplete="off"/>
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_usuario'>Usuario</li>
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
                    <table class="fuente8 display" id="table-usuarios">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <th style="width: 30%" data-orderable="true">PERSONAL</th>
                                <th style="width: 20%" data-orderable="true">USUARIO</th>
                                <th style="width: 35%" data-orderable="true">ROLES</th>
                                <th style="width: 05%" data-orderable="false">&nbsp;</th>
                                <th style="width: 05%" data-orderable="false">&nbsp;</th>
                                <th style="width: 05%" data-orderable="false">&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="add_usuario" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog w-porc-80">
        <div class="modal-content">
            <form id="formUsuario" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR USUARIO</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="usuario" name="usuario" value=""/>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>INFORMACIÓN DEL EMPLEADO</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="persona">EMPLEADO *</label>
                            <select name="persona" id="persona" class="form-control h-3 cboDirectivo">
                                <option value=""> :: SELECCIONE :: </option><?php
                                foreach($directivos as $indice => $val){ ?>
                                    <option value="<?=$val->PERSP_Codigo;?>"><?=$val->nombre;?></option><?php
                                } ?>
                            </select>
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtNombres">NOMBRES</label>
                            <input type="text" name="txtNombres" id="txtNombres" maxlength="30" class="form-control" value="<?=$nombres;?>" readonly placeholder="NOMBRES">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtPaterno">APELLIDO PATERNO</label>
                            <input type="text" name="txtPaterno" id="txtPaterno" maxlength="30" class="form-control" value="<?=$paterno;?>" readonly placeholder="APELLIDO PATERNO">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtMaterno">APELLIDO MATERNO</label>
                            <input type="text" name="txtMaterno" id="txtMaterno" maxlength="30" class="form-control" value="<?=$materno;?>" readonly placeholder="APELLIDO MATERNO">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>DATOS DEL USUARIO</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtUsuario">USUARIO *</label>
                            <input type="text" name="txtUsuario" id="txtUsuario" maxlength="30" class="form-control" value="<?=$usuario;?>" placeholder="USUARIO" autocomplete="off">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtClave">CLAVE *</label>
                            <input type="password" name="txtClave" id="txtClave" maxlength="30" class="form-control" value="<?=$clave;?>" autocomplete="off" placeholder="**********">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="txtClave2">REPETIR CLAVE *</label>
                            <input type="password" name="txtClave2" id="txtClave2" maxlength="30" class="form-control" value="<?=$clave2;?>" autocomplete="off" placeholder="**********">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                            <span>DEFINIR ACCESO</span>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-11 col-md-11 col-lg-11">
                            <table class="fuente8 display" id="establecimientos-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;" data-orderable="true">EMPRESA</th>
                                        <th style="width: 20%;" data-orderable="false">ESTABLECIMIENTO</th>
                                        <th style="width: 20%;" data-orderable="false">ROL</th>
                                        <th style="width: 20%;" data-orderable="false">ACCESO</th>
                                    </tr>
                                </thead>
                                <tbody> <?php
                                        $empresa = NULL;
                                        foreach ($establecimientos as $i => $val){ ?>
                                            <tr>
                                                <td><?=$val->EMPRC_RazonSocial;?></td>
                                                <td><?=$val->EESTABC_Descripcion;?>
                                                    <input type="hidden" name="establecimientos[]" class="establecimientos-input" value="<?=$val->COMPP_Codigo;?>"/>
                                                </td>
                                                <td>
                                                    <select name="rol[]" class="form-control h-2 establecimientos-rol_<?=$val->COMPP_Codigo;?>"> <?php
                                                        foreach($roles as $j => $rol){ ?>
                                                            <option value="<?=$rol->ROL_Codigo;?>"><?=$rol->ROL_Descripcion;?></option><?php
                                                        } ?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="acceso[]" class="form-control h-2 establecimientos-acceso_<?=$val->COMPP_Codigo;?>">
                                                        <option value="0">SIN ACCESO</option>
                                                        <option value="1">PERMITIDO</option>
                                                    </select>
                                                </td>
                                            </tr> <?php
                                        } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_usuario()">Guardar Registro</button>
                    <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="view_user" class="modal fade" role="dialog" data-backdrop="static">
    <div class="modal-dialog w-porc-70">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
            </div>
            <div style="text-align: center;">
                <h3><b>INFORMACIÓN DEL USUARIO</b></h3>
            </div>
            <div class="modal-body panel panel-default">
                <div class="row form-group">
                    <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                        <span>EMPLEADO</span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <label>NOMBRES:</label>
                        <span class="data-nombres"></span>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>APELLIDO PATERNO:</label>
                        <span class="data-apellidop"></span>
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <label>APELLIDO MATERNO:</label>
                        <span class="data-apellidom"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-10 col-md-10 col-lg-10">
                        <label>USUARIO:</label>
                        <span class="data-usuario"></span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                        <span>INFORMACIÓN DE ACCESO</span>
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col-sm-11 col-md-11 col-lg-11">
                        <table class="fuente8 display" id="table-view-accesos">
                            <thead>
                                <tr class="cabeceraTabla">
                                    <th style="width: 50%;" data-orderable="false">EMPRESA</th>
                                    <th style="width: 25%;" data-orderable="false">ESTABLECIMIENTO</th>
                                    <th style="width: 25%;" data-orderable="false">ROL</th>
                                </tr>
                            </thead>
                            <tbody class="info-accesos"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    base_url = "<?=base_url();?>";

    $(document).ready(function(){
        $('#table-usuarios').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/seguridad/usuario/datatable_usuarios/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-usuarios .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-usuarios .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "asc" ]]
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

        $('#searchNombres, #searchUsuario, #searchRol').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });

        $("#persona").change(function(){
            getUsuarioPersona( $(this).val() );
        });

        table_establecimientos();
    });

    function search( search = true){
        if (search == true){
            searchNombres = $("#searchNombres").val();
            searchUsuario = $("#searchUsuario").val();
            searchRol = $("#searchRol").val();
        }
        else{
            $("#searchNombres").val("");
            $("#searchUsuario").val("");
            $("#searchRol").val("");

            searchNombres = "";
            searchUsuario = "";
            searchRol = "";
        }
        
        $('#table-usuarios').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/seguridad/usuario/datatable_usuarios/',
                    type: "POST",
                    data: {
                            txtNombres: searchNombres,
                            txtUsuario: searchUsuario,
                            txtRol: searchRol
                    },
                    beforeSend: function(){
                        $("#table-usuarios .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-usuarios .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "asc" ]]
        });
    }

    function getUsuarioPersona(persona = ""){
        if( persona != "" ){
            url = base_url + "index.php/seguridad/usuario/getPersonaUsuario";
            $.ajax({
                type: "POST",
                url: url,
                data: {
                        persona: persona
                },
                dataType: "json",
                beforeSend: function(data){
                    clean();
                },
                success: function(data){
                    $("#persona").val(persona);
                    if (data.match == true){
                        $('#txtNombres').val(data.info.nombres);
                        $("#txtPaterno").val(data.info.apellido_paterno);
                        $("#txtMaterno").val(data.info.apellido_materno);
                        
                        $("#usuario").val(data.info.usuario);
                        $('#txtUsuario').val(data.info.nombre_usuario);
                        if ( data.info.usuario == null )
                            $('#txtUsuario').removeAttr("readonly");
                        else{
                            $.each(data.info.acceso, function(i,item){
                                $(".establecimientos-rol_"+item.establecimiento).val(item.rol);
                                $(".establecimientos-acceso_"+item.establecimiento).val(1);
                            });
                        }
                    }
                    else{
                        $('#txtUsuario').removeAttr('readonly');
                        $('#txtClave').removeAttr('readonly');
                        $('#txtClave2').removeAttr('readonly');
                        
                        $('#txtUsuario').val("");
                        $('#txtClave').val("");
                        $('#txtClave2').val("");
                    }
                },
                complete: function(){
                }
            });
        }
        else{
            clean();
        }
    }

    function editar_usuario(persona){
        getUsuarioPersona(persona);
        $("#add_usuario").modal("toggle");
    }

    function table_establecimientos(){
        $('#establecimientos-table').DataTable({ responsive: true,
            autoWidth: false,
            filter: false,
            destroy: true,
            language: spanish
        });
    }

    function registrar_usuario(){
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
                        var usuario = $("#usuario").val();
                        var username = $("#txtUsuario").val();
                        validacion = true;

                        if (usuario == "" && $("#txtClave").val().length < 5 || usuario != "" && $("#txtClave").val() != "" && $("#txtClave").val().length < 5 ){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar una contraseña valida.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#txtClave").focus();
                            validacion = false;
                            return null;
                        }

                        if ( $("#txtClave").val() != $("#txtClave2").val() ){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Las contraseñas ingresadas no coinciden.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#txtClave2").focus();
                            validacion = false;
                            return null;
                        }

                        expr = /[a-zA-Z0-9._\-]{3,15}$/
                        if ( expr.test(username) == true ){
                            url = base_url+"index.php/seguridad/usuario/buscar_nombre_usuario";
                            $.ajax({
                                url: url,
                                type: "POST",
                                dataType: 'json',
                                data: { username: username },
                                beforeSend: function(data) {

                                },
                                success: function(data){
                                    if ( data.match == true && usuario == "" ){
                                        Swal.fire({
                                                    icon: "error",
                                                    title: "Verifique los datos ingresados.",
                                                    html: "<b class='color-red'>El nombre de usuario " + username + " no esta disponible.</b>",
                                                    showConfirmButton: true,
                                                    timer: 4000
                                                });
                                        $("#txtUsuario").focus();
                                        validacion = false;
                                        return null;
                                    }
                                }
                            });
                        }
                        else{
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>El nombre de usuario " + username + ". no esta permitido.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            
                            $("#txtUsuario").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/seguridad/usuario/guardar_registro";
                            $("#establecimientos-table").DataTable().destroy();
                            var dataForm = $("#formUsuario").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: dataForm,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (usuario == "")
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
                                        search(false);
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
                                    table_establecimientos();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(usuario){
        Swal.fire({
                    icon: "info",
                    title: "¿Esta seguro de eliminar el acceso del usuario seleccionado?",
                    html: "<b class='color-red'></b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var url = base_url + "index.php/seguridad/usuario/deshabilitar_usuario";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                usuario: usuario
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

    function ver_usuario(usuario){
        url = base_url + "index.php/seguridad/usuario/getUsuario";
        $.ajax({
            type: "POST",
            url: url,
            data: {
                    usuario: usuario
            },
            dataType: "json",
            beforeSend: function(data){
                $('.data-nombres').html("");
                $(".data-apellidop").html("");
                $(".data-apellidom").html("");

                $(".data-usuario").html("");
                $(".info-accesos").html("");
            },
            success: function(data){
                if (data.match == true){
                    $('.data-nombres').html(data.info.nombres);
                    $(".data-apellidop").html(data.info.apellido_paterno);
                    $(".data-apellidom").html(data.info.apellido_materno);

                    $(".data-usuario").html(data.info.nombre_usuario);
                    
                    $.each(data.info.acceso, function(i,item){
                        tr = "<tr>";
                            tr += "<td>"+item.empresa+"</td>";
                            tr += "<td>"+item.establecimiento+"</td>";
                            tr += "<td>"+item.rol+"</td>";
                        tr += "</tr>";
                        $(".info-accesos").append(tr);
                    });
                }
            },
            complete: function(){
                $('#table-view-accesos').DataTable({ responsive: true,
                    filter: false,
                    destroy: true,
                    autoWidth: false,
                    language: spanish
                });
                $("#view_user").modal("toggle");
            }
        });
    }

    function clean(){
        $("#formUsuario")[0].reset();
        $("#usuario").val("");
    }
</script>