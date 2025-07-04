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
            <div class="col-sm-6 col-md-6 col-lg-6"></div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <select id="search_modulo" name="search_modulo" class="form-control h-2">
                    <option value=""> :: TODOS :: </option> <?php
                    foreach ($modulos as $i => $val){ ?>
                        <option value="<?=$val->MENU_Codigo;?>"><?=$val->MENU_Descripcion;?></option> <?php
                    } ?>                    
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <input type="text" name="search_menu" id="search_menu" value="" placeholder="Descripción" class="form-control h-1"/>
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
                                <li id="nuevo" data-toggle='modal' data-target='#add_menu'>Menu</li>
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
                    <table class="fuente8 display" id="table-menu">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="true">MODULO</td>
                                <td style="width:10%" data-orderable="true">DESCRIPCIÓN</td>
                                <td style="width:10%" data-orderable="true">TITULO</td>
                                <td style="width:35%" data-orderable="true">URL</td>
                                <td style="width:10%" data-orderable="true">ACCESO RAPIDO</td>
                                <td style="width:05%" data-orderable="true">ORDEN</td>
                                <td style="width:10%" data-orderable="true">ESTADO</td>
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

<div id="add_menu" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formMenu" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR MENU</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="menu" name="menu" value="">

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="modulo_padre">MODULO</label>
                            <select id="modulo_padre" name="modulo_padre" class="form-control h-3">
                                <optgroup label="CREAR MODULO">
                                    <option value="0">MODULO</option>
                                </optgroup>
                                <optgroup label="ASIGNAR MODULO"> <?php
                                    foreach ($modulos as $i => $val){ ?>
                                        <option value="<?=$val->MENU_Codigo;?>"><?=$val->MENU_Descripcion;?></option> <?php
                                    } ?>
                                </optgroup>
                            </select>
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="modulo_descripcion">DESCRIPCIÓN *</label>
                            <input type="text" id="modulo_descripcion" name="modulo_descripcion" class="form-control h-2" placeholder="Descripcion (nombre a mostrar)" value="">
                        </div>
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="modulo_titulo">TITULO</label>
                            <input type="text" id="modulo_titulo" name="modulo_titulo" class="form-control  h-2" placeholder="Titulo (opcional)" value="">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="modulo_url">URL *</label>
                            <input type="text" id="modulo_url" name="modulo_url" class="form-control h-2" placeholder="carpeta/controlador/metodo" value="">
                        </div>
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label for="modulo_access">ACCESO DIRECTO</label>
                            <select id="modulo_access" name="modulo_access" class="form-control h-3">
                                <option value="0">INHABILITADO</option>
                                <option value="1">HABILITADO</option>
                            </select>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <label for="modulo_order">ORDEN</label>
                            <input type="number" min="0" step="1" max="999" id="modulo_order" name="modulo_order" class="form-control  h-2" placeholder="0" value="0">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-10 col-md-10 col-lg-10">
                            <label for="modulo_icono">ICONO (OPCIONAL) - BASE64</label>
                            <textarea id="modulo_icono" name="modulo_icono" class="form-control h-5" placeholder="Pegue el código base64 del icono"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_menu()">Guardar Registro</button>
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
        $('#table-menu').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/basedatos/menu/datatable_menu/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-menu .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-menu .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
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

        $('#search_menu, #search_modulo').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });
    });

    function search( search = true){
        if (search == true){
            search_menu = $("#search_menu").val();
            search_modulo = $("#search_modulo").val();
        }
        else{
            $("#search_menu").val("");
            $("#search_modulo").val("");
            search_menu = "";
            search_modulo = "";
        }
        
        $('#table-menu').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/basedatos/menu/datatable_menu/',
                    type: "POST",
                    data: {
                            menu: search_menu,
                            modulo: search_modulo
                    },
                    beforeSend: function(){
                        $("#table-menu .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-menu .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 0, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/basedatos/menu/getMenu";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    menu: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#menu").val(info.menu);
                    $("#modulo_padre").val(info.padre);
                    $("#modulo_descripcion").val(info.descripcion);
                    $("#modulo_titulo").val(info.titulo);
                    $("#modulo_url").val(info.url);
                    $("#modulo_access").val(info.access);
                    $("#modulo_order").val(info.order);
                    $("#modulo_icono").val(info.icon);

                    $("#add_menu").modal("toggle");
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

    function registrar_menu(){
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
                        var menu = $("#menu").val();

                        var descripcion = $("#modulo_descripcion").val();
                        var url = $("#modulo_url").val();
                        validacion = true;

                        if (descripcion == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar una descripcion.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#modulo_descripcion").focus();
                            validacion = false;
                            return null;
                        }

                        if (url == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe definir el acceso al controlador y metodo.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#modulo_url").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/basedatos/menu/guardar_registro";
                            var info = $("#formMenu").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (menu == "")
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
                                    $("#menu_nombre").focus();
                                }
                            });
                        }
                    }
                });
    }

    function habilitar(menu){
        Swal.fire({
                    icon: "info",
                    title: "El menú sera habilitado",
                    html: "<b class='color-red'></b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var url = base_url + "index.php/basedatos/menu/habilitar_menu";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                menu: menu
                            },
                            success: function(data){
                                if (data.result == "success") {
                                    titulo = "¡Menú habilitado!";
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
                            }
                        });
                    }
                });
    }

    function deshabilitar(menu){
        Swal.fire({
                    icon: "info",
                    title: "Debe confirmar esta acción.",
                    html: "<b class='color-red'></b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if (result.value){
                        var url = base_url + "index.php/basedatos/menu/deshabilitar_menu";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                menu: menu
                            },
                            success: function(data){
                                if (data.result == "success") {
                                    titulo = "¡Menú deshabilitado!";
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
        $("#formMenu")[0].reset();
        $("#menu").val("");
    }
</script>