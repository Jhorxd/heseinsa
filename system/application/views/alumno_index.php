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
                <label for="search_descripcion">ALUMNO</label>
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Alumno o correo" class="form-control h-1" autocomplete="off" />
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_nivel">NIVEL</label>
                <select name="search_nivel" id="search_nivel" class="form-control h-2">
                    <option value="">TODOS</option>
                    <option value="INICIAL">INICIAL</option>
                    <option value="PRIMARIA">PRIMARIA</option>
                    <option value="SECUNDARIA">SECUNDARIA</option>
                </select>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1">
                <label for="search_curso">CURSO</label>
                <select name="search_curso" id="search_curso" class="form-control h-2">
                    <option value="">TODOS</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                </select>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1">
                <label for="search_seccion">SECCIÓN</label>
                <select name="search_seccion" id="search_seccion" class="form-control h-2">
                    <option value="">TODOS</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                    <option value="D">D</option>
                </select>
            </div>
        </div>
    </form>
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda" style="width: auto;">
                            <ul class="lista_botones">
                                <li id="zip">ZIP</li>
                            </ul>
                            <ul class="lista_botones">
                                <li id="imprimir">PDF</li>
                            </ul>
                            <ul class="lista_botones">
                                <li id="excel">Descargar</li>
                            </ul>
                            <ul class="lista_botones">
                                <li id="nuevo" data-toggle='modal' data-target='#add_alumno'>Alumno</li>
                            </ul>
                            <ul id="limpiarC" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarC" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul> 
                        </div>
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
                    <table class="fuente8 display" id="table-alumno">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:14%" data-orderable="true">APELLIDOS</td>
                                <td style="width:14%" data-orderable="true">NOMBRES</td>
                                <td style="width:20%" data-orderable="true">CORREO</td>
                                <td style="width:17%" data-orderable="true">GRUPO</td>
                                <td style="width:05%" data-orderable="true">CURSO</td>
                                <td style="width:15%" data-orderable="false">NIVEL</td>
                                <td style="width:05%" data-orderable="false">SECCIÓN</td>
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

<div id="add_alumno" class="modal fade" role="dialog">
    <div class="modal-dialog w-porc-60">
        <div class="modal-content">
            <form id="formAlumno" method="POST">
                <div class="modal-header">
                    <h4 class="modal-title"></h4>
                </div>
                <div style="text-align: center;">
                    <h3><b>REGISTRAR ALUMNO</b></h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="alumno" name="alumno" value="">

                    <div class="row form-group">
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="nombres_alumno">NOMBRES *</label>
                            <input type="text" id="nombres_alumno" name="nombres_alumno" class="form-control h-2" placeholder="Nombre del alumno" value="">
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="apellidos_alumno">APELLIDOS *</label>
                            <input type="text" id="apellidos_alumno" name="apellidos_alumno" class="form-control h-2 w-porc-90" placeholder="Apellidos del alumno" value="">
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="grupo_alumno">GRUPO *</label>
                            <input type="text" id="grupo_alumno" name="grupo_alumno" class="form-control h-2" placeholder="Grupo '2doprimariaa2020@colegioalfonsougarte.edu.pe' " value="">
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label for="correo_alumno">CORREO *</label>
                            <input type="text" id="correo_alumno" name="correo_alumno" class="form-control h-2 w-porc-90" placeholder="Correo" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" accesskey="x" onclick="registrar_alumno()">Guardar Registro</button>
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
        $('#table-alumno').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/alumno/datatable_alumno/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-alumno .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-alumno .loading-table").hide();
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

        $('#search_descripcion').keyup(function(e){
            if ( e.which == 13 ){
                if( $(this).val() != '' )
                    search();
            }
        });

        $("#excel").click(function(){
            window.location = base_url + "index.php/alumno/excel";
        });

        $("#imprimir").click(function(){
            url = base_url + "index.php/alumno/pdf";
                $.fancybox.open({
                    src: url,
                    type: 'iframe'
                });
        });

        $("#zip").click(function(){
            url = base_url + "index.php/alumno/zip";
            Swal.fire({
                    title: "Este proceso puede tardar unos minutos.",
                    html: "<b class='color-green bold'>La descarga iniciara automaticamente.</b>",
                    imageUrl: base_url + 'images/loading.gif',
                    imageWidth: 150,
                    imageHeight: 150,
                    imageAlt: 'Loading',
                    showConfirmButton: true
            });

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200){
                    Swal.fire({
                            icon: "success",
                            title: "Archivo preparado.",
                            showConfirmButton: true,
                            timer: 6000
                    });
                    window.location = base_url + "alumnos.zip";
                }
            };
            
            xhttp.open("GET", url, true);
            xhttp.send();
        });

        $("#nombres_alumno, #apellidos_alumno").keyup(function(){
            nombre = $("#nombres_alumno").val().split(" ").join(".");
            apellido = $("#apellidos_alumno").val().split(" ").join(".");

            correo = apellido + "." + nombre + "@colegioalfonsougarte.edu.pe";
            
            correo = correo.toLowerCase();
            correo = correo.split("á").join("a");
            correo = correo.split("ä").join("a");
                
            correo = correo.split("é").join("e");
            correo = correo.split("ë").join("e");
                
            correo = correo.split("í").join("i");
            correo = correo.split("ï").join("i");
                
            correo = correo.split("ó").join("o");
            correo = correo.split("ö").join("o");
                
            correo = correo.split("ú").join("u");
            correo = correo.split("ü").join("u");
                
            correo = correo.split("ñ").join("n");
            correo = correo.split("'").join("");
                
            $("#correo_alumno").val(correo);
        });

        $("#grupo_alumno").autocomplete({
            source: function (request, response) {
                $.ajax({
                    url: base_url + "index.php/alumno/getGrupo",
                    type: "POST",
                    data: {
                        grupo: $("#grupo_alumno").val()
                    },
                    dataType: "json",
                    success: function (data) {
                        response(data);
                    }
                });
            },
            select: function (event, ui) {
                $("#grupo_alumno").val(ui.item.value);
            },
            minLength: 1
        });
    });

    function search( search = true){
        if (search == true){
            search_descripcion = $("#search_descripcion").val();
            search_nivel = $("#search_nivel").val();
            search_curso = $("#search_curso").val();
            search_seccion = $("#search_seccion").val();
        }
        else{
            $("#form_busqueda")[0].reset();

            search_descripcion = "";
            search_nivel = "";
            search_curso = "";
            search_seccion = "";
        }


        $('#table-alumno').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : '<?=base_url();?>index.php/alumno/datatable_alumno/',
                    type: "POST",
                    data: {
                            descripcion: search_descripcion,
                            nivel: search_nivel,
                            curso: search_curso,
                            seccion: search_seccion
                    },
                    beforeSend: function(){
                        $("#table-alumno .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-alumno .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "asc" ]]
        });
    }

    function editar(id){
        var url = base_url + "index.php/alumno/getAlumno";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    alumno: id
            },
            beforeSend: function(){
                clean();
            },
            success: function(data){
                if (data.match == true) {
                    info = data.info;

                    $("#alumno").val(info.alumno);
                    $("#nombres_alumno").val(info.nombres);
                    $("#apellidos_alumno").val(info.apellidos);
                    $("#grupo_alumno").val(info.grupo);
                    $("#correo_alumno").val(info.correo);

                    $("#add_alumno").modal("toggle");
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

    function registrar_alumno(){
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
                        var alumno = $("#alumno").val();
                        var nombres_alumno = $("#nombres_alumno").val();
                        var apellidos_alumno = $("#apellidos_alumno").val();
                        var grupo_alumno = $("#grupo_alumno").val();
                        var correo_alumno = $("#correo_alumno").val();
                        validacion = true;

                        if (nombres_alumno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un nombre.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#nombres_alumno").focus();
                            validacion = false;
                            return null;
                        }

                        if (apellidos_alumno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un apellido.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#apellidos_alumno").focus();
                            validacion = false;
                            return null;
                        }

                        if (grupo_alumno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un grupo.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#grupo_alumno").focus();
                            validacion = false;
                            return null;
                        }

                        if (correo_alumno == ""){
                            Swal.fire({
                                        icon: "error",
                                        title: "Verifique los datos ingresados.",
                                        html: "<b class='color-red'>Debe ingresar un correo.</b>",
                                        showConfirmButton: true,
                                        timer: 4000
                                    });
                            $("#correo_alumno").focus();
                            validacion = false;
                            return null;
                        }

                        if (validacion == true){
                            var url = base_url + "index.php/alumno/guardar_registro";
                            var info = $("#formAlumno").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: info,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (alumno == "")
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
                                    $("#nombres_alumno").focus();
                                }
                            });
                        }
                    }
                });
    }

    function deshabilitar(alumno){
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
                        var url = base_url + "index.php/alumno/deshabilitar_alumno";
                        $.ajax({
                            type: 'POST',
                            url: url,
                            dataType: 'json',
                            data: {
                                alumno: alumno
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
        $("#formAlumno")[0].reset();
        $("#alumno").val("");
    }
</script>