<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>

<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo_busqueda;?></div>
        </div>
    </div>
    
        <div class="row fuente8 py-1">
            <div class="col-sm-2 col-md-2 col-lg-2">
                <h1>LISTA DE EMPRESAS</h1>
            </div>

        </div>
    
    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="header text-align-center"><?=$titulo_tabla;?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="table-empresas">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="true">CÓDIGO</td>
                                <td style="width:40%" data-orderable="true">RAZÓN SOCIAL</td>
                                <td style="width:30%" data-orderable="true">DIRECCION</td>
                                <td style="width:10%" data-orderable="true">SUCURSALES</td>
                                <td style="width:10%" data-orderable="false">BANCOS</td>
                                <td style="width:10%" data-orderable="false">EDITAR</td>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL empresa-->
    <div id="modal_addempresa" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog w-porc-80">
            <div class="modal-content">
                <form id="formempresa" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div style="text-align: center;">
                        <h3><b>EMPRESA</b></h3>
                    </div>
                    <div class="modal-body panel panel-default">
                        <input type="hidden" id="id_empresa" name="id_empresa" value="">

                        <div class="row form-group">
                            <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                                <span>INFORMACIÓN DE LA EMPRESA</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="numero_documento">Número de documento (*)</label>
                                <input type="text" id="numero_documento" name="numero_documento" class="form-control h-2 w-porc-90" placeholder="Número de documento" value="" autocomplete="off">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">&nbsp;<br>
                                <button type="button" class="btn btn-default btn-search-sunat">
                                    <img src="<?=$base_url;?>images/sunat.png" class='image-size-2'/>
                                </button>
                                <span class="icon-loading-lg"></span>
                            </div>
                        </div>

                        <!--********** JURIDICO **********-->
                            <div class="row form-group divJuridico">
                                <div class="col-sm-9 col-md-9 col-lg-9">
                                    <label for="razon_social">Razón social (*)</label>
                                    <input type="text" id="razon_social" name="razon_social" class="form-control h-2" placeholder="Indique la razón social" value="" autocomplete="off">
                                </div>
                            </div>

                        <div class="row form-group">
                            <div class="col-sm-9 col-md-9 col-lg-9">
                                <label for="direccion">Dirección (*)</label>
                                <textarea id="direccion" name="direccion" class="form-control h-4" placeholder="Indique la dirección"></textarea>
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
                                <label for="correo">Correo</label>
                                <input type="email" id="correo" name="correo" class="form-control h-2 w-porc-90" placeholder="empresa@empresa.com" val="" autocomplete="off">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="web">Dirección web</label>
                                <input type="url" id="web" name="web" class="form-control h-2 w-porc-90" placeholder="" val="http://www.google.com" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="registrar_empresa()">Guardar Registro</button>
                        <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END MODAL empresa-->


<!-- MODAL SUCURSALES -->
    <div id="modal_sucursales" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog w-porc-80">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3 class="modal-title">SUCURSALES</h3>
                </div>
                <div class="modal-body panel panel-default">
                    <input type="hidden" id="id_empresa" name="id_empresa" value="">
                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label>RUC:</label> <span class="titleRuc"></span>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <button type="button" class="btn btn-info btn-addSucursal" value="">Agregar Sucursal</button>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                            <table class="fuente8 display" id="table-sucursales">
                                <div id="cargando_datos" class="loading-table">
                                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                                </div>
                                <thead>
                                    <tr class="cabeceraTabla">
                                        <td style="width:15%" data-orderable="true">NOMBRE</td>
                                        <td style="width:15%" data-orderable="true">TIPO</td>
                                        <td style="width:40%" data-orderable="true">DIRECCIÓN</td>
                                        <td style="width:20%" data-orderable="true">UBIGEO</td>
                                        <td style="width:05%" data-orderable="false"></td>
                                        <td style="width:05%" data-orderable="false"></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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

    <div id="modal_addsucursal" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog w-porc-70">
            <div class="modal-content">
                <form id="formSucursal" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div style="text-align: center;">
                        <h3><b>REGISTRO DE SUCURSAL</b></h3>
                    </div>
                    <div class="modal-body panel panel-default">

                        <input type="hidden" id="sucursal" name="sucursal" value="">
                        <input type="hidden" id="sucursal_empresa" name="sucursal_empresa" value="">

                        <div class="row form-group">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <label for="establecimiento_nombre">Nombre *</label>
                                <input type="text" id="establecimiento_nombre" name="establecimiento_nombre" class="form-control h-2 w-porc-90" placeholder="Nombre del establecimiento" value="" autocomplete="off">
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="establecimiento_tipo">Tipo de establecimiento</label>
                                <select id="establecimiento_tipo" name="establecimiento_tipo" class="form-control h-3 w-porc-90"><?php
                                    foreach ($tipo_establecimiento as $i => $val){ ?>
                                        <option value="<?=$val->TESTP_Codigo?>"><?=$val->TESTC_Descripcion;?></option><?php
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-sm-9 col-md-9 col-lg-9">
                                <label for="establecimiento_direccion">Dirección (*)</label>
                                <textarea id="establecimiento_direccion" name="establecimiento_direccion" class="form-control h-4" placeholder="Indique la dirección del establecimiento"></textarea>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="establecimiento_departamento">Departamento</label>
                                <select id="establecimiento_departamento" name="establecimiento_departamento" class="form-control h-3 w-porc-90"><?php
                                    foreach ($departamentos as $i => $val){ ?>
                                        <option value="<?=$val->UBIGC_CodDpto;?>" <?=($val->UBIGC_CodDpto == "15") ? "selected" : ""?> ><?=$val->UBIGC_DescripcionDpto;?></option> <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="establecimiento_provincia">Provincia</label>
                                <select id="establecimiento_provincia" name="establecimiento_provincia" class="form-control h-3 w-porc-90"><?php
                                    foreach ($provincias as $i => $val){ ?>
                                        <option value="<?=$val->UBIGC_CodProv;?>" <?=($val->UBIGC_CodProv == "01") ? "selected" : "";?>><?=$val->UBIGC_DescripcionProv;?></option> <?php
                                    } ?>
                                </select>
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="establecimiento_distrito">Distrito</label>
                                <select id="establecimiento_distrito" name="establecimiento_distrito" class="form-control h-3 w-porc-90"><?php
                                    foreach ($distritos as $i => $val){ ?>
                                        <option value="<?=$val->UBIGC_CodDist;?>" <?=($val->UBIGC_CodDist == "01") ? "selected" : "";?>><?=$val->UBIGC_Descripcion;?></option> <?php 
                                    } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="registrar_sucursal()">Guardar Registro</button>
                        <button type="button" class="btn btn-info" onclick="clean_sucursal()">Limpiar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END MODAL SUCURSALES -->


<!-- MODAL BANCOS -->
    <div id="modal_bancos" class="modal fade" role="dialog">
        <div class="modal-dialog w-porc-80">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h3 class="modal-title">CUENTAS BANCARIAS</h3>
                </div>
                <div class="modal-body panel panel-default">
                    <div class="row form-group">
                        <div class="col-sm-2 col-md-2 col-lg-2">
                            <label>RUC:</label> <span class="titleRuc"></span>
                        </div>
                        <div class="col-sm-5 col-md-5 col-lg-5">
                            <label>RAZÓN SOCIAL:</label> <span class="titleRazonSocial"></span>
                        </div>
                        <div class="col-sm-1 col-md-1 col-lg-1">
                            <button type="button" class="btn btn-info btn-addBanco" value="">Agregar Cuenta</button>
                            <button type="button" hidden id="btn-ctabancoempresa" value=""></button>
                            <button type="button" hidden id="btn-ctabancopersona" value=""></button>
                        </div>
                    </div>
                    
                    <div class="row form-group">
                        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                            <table class="fuente8 display" id="table-bancos">
                                <div id="cargando_datos" class="loading-table">
                                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                                </div>
                                <thead>
                                    <tr class="cabeceraTabla">
                                        <td style="width:20%" data-orderable="true">BANCO</td>
                                        <td style="width:20%" data-orderable="true">TITULAR</td>
                                        <td style="width:10%" data-orderable="true">TIPO</td>
                                        <td style="width:10%" data-orderable="true">MONEDA</td>
                                        <td style="width:15%" data-orderable="false">N° CUENTA</td>
                                        <td style="width:15%" data-orderable="false">INTERBANCARIA</td>
                                        <td style="width:05%" data-orderable="false"></td>
                                        <td style="width:05%" data-orderable="false"></td>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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

    <div id="modal_addctabancaria" class="modal fade" role="dialog">
        <div class="modal-dialog w-porc-70">
            <div class="modal-content">
                <form id="formCtaBancaria" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div style="text-align: center;">
                        <h3><b>REGISTRO DE CUENTA BANCARIA</b></h3>
                    </div>
                    <div class="modal-body panel panel-default">

                        <input type="hidden" id="cta_bancaria" name="cta_bancaria" value="">
                        <input type="hidden" id="cta_bancaria_empresa" name="cta_bancaria_empresa" value="">
                        <input type="hidden" id="cta_bancaria_persona" name="cta_bancaria_persona" value="">

                        <div class="row form-group">
                            <div class="col-sm-4 col-md-4 col-lg-4">
                                <label for="banco">Banco *</label>
                                <select id="banco" name="banco" class="form-control h-3 w-porc-90"><?php
                                    foreach ($bancos as $i => $val){ ?>
                                        <option value="<?=$val->BANP_Codigo;?>"><?=$val->BANC_Nombre;?></option> <?php
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-5 col-md-5 col-lg-5">
                                <label for="cta_bancaria_titular">Titular *</label>
                                <input type="text" id="cta_bancaria_titular" name="cta_bancaria_titular" class="form-control h-2 w-porc-90" placeholder="Titular de la cuenta" value="" autocomplete="off">
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="cta_bancaria_tipo">Tipo de cuenta *</label>
                                <select id="cta_bancaria_tipo" name="cta_bancaria_tipo" class="form-control h-3 w-porc-90">
                                    <option value="1">AHORROS</option>
                                    <option value="2">CORRIENTE</option>
                                </select>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="cta_bancaria_moneda">Moneda *</label>
                                <select id="cta_bancaria_moneda" name="cta_bancaria_moneda" class="form-control h-3 w-porc-90"><?php
                                    foreach ($monedas as $i => $val){ ?>
                                        <option value="<?=$val->MONED_Codigo;?>"><?="$val->MONED_Simbolo | $val->MONED_smallName";?></option> <?php
                                    } ?>
                                </select>
                            </div>

                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="cta_bancaria_numero">N° de cuenta *</label>
                                <input type="text" id="cta_bancaria_numero" name="cta_bancaria_numero" class="form-control h-2 w-porc-90" placeholder="Número de la cuenta" value="" autocomplete="off">
                            </div>
                            <div class="col-sm-3 col-md-3 col-lg-3">
                                <label for="cta_bancaria_interbancaria">Interbancaria </label>
                                <input type="number" id="cta_bancaria_interbancaria" name="cta_bancaria_interbancaria" class="form-control h-2 w-porc-90" placeholder="Número de cuenta interbancaria" value="" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="registrar_CtaBancaria()">Guardar Registro</button>
                        <button type="button" class="btn btn-info" onclick="clean_CtaBancaria()">Limpiar</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END MODAL BANCOS -->

<script type="text/javascript">
    base_url = "<?=base_url();?>";

    $(document).ready(function(){
        $('#table-empresas').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/maestros/empresa/datatable_empresas/',
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                        $("#table-empresas .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-empresas .loading-table").hide();
                    }
            },
            language: spanish,
            columnDefs: [
                            {"className": "dt-center", "targets": 0},
                            {"className": "dt-center", "targets": 1}
                        ],
            order: [[ 3, "asc" ]]
        });

        

        $('#form_busqueda').keypress(function(e){
            if ( e.which == 13 ){
                return false;
            } 
        });

        $("#formempresa").keypress(function(e){
            if ( e.which == 13 ){
                registrar_empresa();
            }
        });

        $("#numero_documento").keyup(function(e){
            if ( e.which == 16 ){
                if( $(this).val() != '' )
                    getSunat();
            }
        });

       

        

        $("#departamento").change(function(){
            getProvincias();
        });

        $("#provincia").change(function(){
            getDistritos();
        });

        $("#establecimiento_departamento").change(function(){
            getProvincias(null, null, "#establecimiento_departamento", "#establecimiento_provincia");
        });

        $("#establecimiento_provincia").change(function(){
            getDistritos(null, null, null, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito");
        });

        
        $(".btn-search-sunat").click(function(){
            getSunat();
        });

        $(".btn-addSucursal").click(function(){
            clean_sucursal();
            $("#modal_addsucursal").modal("toggle");
        });

        $(".btn-addBanco").click(function(){
            clean_CtaBancaria();
            $("#modal_addctabancaria").modal("toggle");
        });

        $(".btn-addContacto").click(function(){
            clean_contacto();
            $("#modal_addcontacto").modal("toggle");
        });
    });

    /* empresa */
        function search( search = true){
            if (search == true){
                codigo = $("#search_codigo").val();
                documento = $("#search_documento").val();
                nombre = $("#nombre_empresa").val();
            }
            else{
                $("#search_codigo").val("");
                $("#search_documento").val("");
                $("#nombre_empresa").val("");

                codigo = "";
                documento = "";
                nombre = "";
            }
            
            $('#table-empresas').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                        url : '<?=base_url();?>index.php/maestros/empresa/datatable_empresa/',
                        type: "POST",
                        data: {
                                codigo: codigo,
                                documento: documento,
                                nombre: nombre
                        },
                        beforeSend: function(){
                            $("#table-empresas .loading-table").show();
                        },
                        error: function(){
                        },
                        complete: function(){
                            $("#table-empresas .loading-table").hide();
                        }
                },
                language: spanish,
                columnDefs: [
                                {"className": "dt-center", "targets": 0},
                                {"className": "dt-center", "targets": 1}
                            ],
                order: [[ 3, "asc" ]]
            });
        }

        function editar_empresa(id){
            var url = base_url + "index.php/maestros/empresa/editar_empresa";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data:{
                    empresa: id
                },
                beforeSend: function(){
                    clean();
                },
                success: function(data){
                    if (data.match == true) {
                        info = data.info;

                        $("#id_empresa").val(info.empresa);
                        $("#numero_documento").val(info.numero_documento);
                        $("#razon_social").val(info.razon_social);
                        $("#direccion").val(info.direccion);
                        $("#telefono").val(info.telefono);
                        $("#movil").val(info.movil);
                        $("#correo").val(info.correo);
                        $("#web").val(info.web);

                        $("#modal_addempresa").modal("toggle");
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

        function registrar_empresa(){
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
                            var url = base_url + "index.php/maestros/empresa/guardar_registro";

                            empresa             = $("#id_empresa").val();
                            numero_documento    = $("#numero_documento").val();
                            razon_social        = $("#razon_social").val();
                            direccion           = $("#direccion").val();
                            telefono            = $("#telefono").val();
                            movil               = $("#movil").val();
                            correo              = $("#correo").val();
                            web                 = $("#web").val();
                            validacion = true;
                       
                            if (razon_social == ""){
                                Swal.fire({
                                            icon: "error",
                                            title: "Verifique los datos ingresados.",
                                            html: "<b class='color-red'>Debe ingresar una razón social.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                $("#razon_social").focus();
                                validacion = false;
                                return false;
                            }
                           
                            

                            if (numero_documento == ""){
                                Swal.fire({
                                            icon: "error",
                                            title: "Verifique los datos ingresados.",
                                            html: "<b class='color-red'>Debe ingresar un número de documento valido.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                $("#numero_documento").focus();
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
                                var dataForm = $("#formempresa").serialize();
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    dataType: 'json',
                                    data: dataForm,
                                    success: function(data){
                                        if (data.result == "success") {
                                            if (empresa == "")
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
                                                html: "<b class='color-red'>" + data.message + "</b>",
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

        

        function clean( id = null ){
            $("#id_empresa").val("");
            $("#formempresa")[0].reset();
        }

    /* END empresa */

    /* SUCURSAL */
    
        function sucursales( empresa = null, razon_social = "" ){

            $("#modal_sucursales").modal("toggle");

            title = razon_social.split("-");
            $(".titleRuc").html(title[0]);
            $(".titleRazonSocial").html(title[1]);
            $(".btn-addSucursal").val(empresa);
            
            getTableSucursales();
        }

        function getTableSucursales(){
            $('#table-sucursales').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                        url : '<?=base_url();?>index.php/maestros/empresa/sucursales',
                        type: "POST",
                        data: {
                            empresa: $(".btn-addSucursal").val()
                        },
                        beforeSend: function(){
                            $("#table-sucursales .loading-table").show();
                        },
                        error: function(){
                        },
                        complete: function(){
                            $("#table-sucursales .loading-table").hide();
                        }
                },
                language: spanish,
                order: [[ 0, "asc" ]]
            });
        }

        function editar_sucursal( id ){
            var url = base_url + "index.php/maestros/empresa/getEstablecimiento";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data:{
                        sucursal: id
                },
                beforeSend: function(){
                    clean_sucursal();
                    $("#modal_addsucursal").modal("toggle");
                },
                success: function(data){
                    if (data.match == true) {
                        info = data.info;

                        $("#sucursal").val(info.sucursal);
                        $("#establecimiento_nombre").val(info.nombre);
                        $("#establecimiento_tipo").val(info.tipo);
                        $("#establecimiento_direccion").val(info.direccion);

                        $("#establecimiento_departamento").val(info.departamento);
                        getProvincias(info.departamento, info.provincia, "#establecimiento_departamento", "#establecimiento_provincia", false)
                        getDistritos(info.departamento, info.provincia, info.distrito, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito")
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

        function registrar_sucursal(){
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
                            var url = base_url + "index.php/maestros/empresa/guardar_sucursal";

                            sucursal = $("#sucursal").val();
                            nombre = $("#establecimiento_nombre").val();
                            direccion = $("#establecimiento_direccion").val();

                            validacion = true;

                            if (nombre == ""){
                                Swal.fire({
                                            icon: "error",
                                            title: "Verifique los datos ingresados.",
                                            html: "<b class='color-red'>Debe ingresar un nombre valido.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                $("#establecimiento_nombre").focus();
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
                                $("#establecimiento_direccion").focus();
                                validacion = false;
                                return false;
                            }

                            if (sucursal == ""){
                                $("#sucursal_empresa").val( $(".btn-addSucursal").val() );

                                if ( $("#sucursal_empresa").val() == "" ){
                                    Swal.fire({
                                            icon: "error",
                                            title: "No hay empresa seleccionada.",
                                            html: "<b class='color-red'>Cierre el formulario de sucursales e intente ingresar nuevamente.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                    });
                                }
                            }

                            if (validacion == true){
                                var dataForm = $("#formSucursal").serialize();
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    dataType: 'json',
                                    data: dataForm,
                                    success: function(data){
                                        if (data.result == "success") {
                                            if (sucursal == "")
                                                titulo = "¡Registro exitoso!";
                                            else
                                                titulo = "¡Actualización exitosa!";

                                            Swal.fire({
                                                icon: "success",
                                                title: titulo,
                                                showConfirmButton: true,
                                                timer: 2000
                                            });

                                            clean_sucursal();
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
                                        getTableSucursales();
                                    }
                                });
                            }
                        }
                    });
        }

        function deshabilitar_sucursal(id){
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
                            var url = base_url + "index.php/maestros/empresa/deshabilitar_sucursal";
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: {
                                    sucursal: id
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
                                    getTableSucursales();
                                }
                            });
                        }
                    });
        }

        function clean_sucursal(){
            $("#sucursal").val("");
            $("#sucursal_empresa").val("");
            $("#formSucursal")[0].reset();
        }

    /* END SUCURSAL */
    
    /* UBIGEO */

        function getProvincias( dpto = null, select = null, inputDpto = "", inputProv = "", getDist = true){

            if ( dpto == null )
                dpto = (inputDpto == "") ? $("#departamento").val() : $(inputDpto).val();

            var url = base_url + "index.php/maestros/ubigeo/getProvincias";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data:{
                        departamento: dpto
                },
                beforeSend: function(){
                    if (inputProv == "")
                        $("#provincia").html("");
                    else
                        $(inputProv).html("");
                },
                success: function(data){
                    if (data.match == true) {
                        info = data.info;
                        
                        options = '';
                        $.each(info, function(i,item){
                            if (select != null && item.codigo == select)
                                selected = "selected";
                            else
                                selected = "";

                                options += '<option value="' + item.codigo + '" ' + selected + '>' + item.descripcion + '</option>';
                        });

                        if (inputProv == "")
                            $("#provincia").append(options);
                        else
                            $(inputProv).append(options);
                    }
                    else{
                        Swal.fire({
                                    icon: "info",
                                    title: "Información de provincias no disponible.",
                                    html: "<b class='color-red'></b>",
                                    showConfirmButton: true,
                                    timer: 4000
                                });
                    }
                },
                complete: function(){
                    if (getDist == true){
                    if (inputProv == "")
                        getDistritos();
                    else
                        if (getDist == true)
                            getDistritos(null, null, null, "#establecimiento_departamento", "#establecimiento_provincia", "#establecimiento_distrito");
                  }
                }
            });
        }

        function getDistritos( dpto = null, prov = null, select = null, inputDpto = "", inputProv = "", inputDist = ""){

            if (dpto == null)
                dpto = (inputDpto == "") ? $("#departamento").val() : $(inputDpto).val();

            if (prov == null)
                prov = (inputProv == "") ? $("#provincia").val() : $(inputProv).val();

            var url = base_url + "index.php/maestros/ubigeo/getDistritos";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data:{
                        departamento: dpto,
                        provincia: prov
                },
                beforeSend: function(){
                    if (inputDist == "")
                        $("#distrito").html("");
                    else
                        $(inputDist).html("");
                },
                success: function(data){
                    if (data.match == true) {
                        info = data.info;
                        
                        options = '';
                        $.each(info, function(i,item){
                            if (select != null && item.codigo == select)
                                selected = "selected";
                            else
                                selected = "";

                            options += '<option value="' + item.codigo + '" ' + selected + '>' + item.descripcion + '</option>';
                        });

                        if (inputDist == "")
                            $("#distrito").append(options);
                        else
                            $(inputDist).append(options);
                    }
                    else{
                        Swal.fire({
                                    icon: "info",
                                    title: "Información de distritos no disponible.",
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

    /* END UBIGEO */

        function getSunat(){
            if ( $("#numero_documento").val() != "" ){
                var url = base_url + "index.php/maestros/empresa/search_documento";
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data:{
                            numero: $("#numero_documento").val()
                    },
                    beforeSend: function(){
                        $('.btn-search-sunat').hide("fast");
                        $(".icon-loading-lg").show("slow");
                                    
                        $("#nombres").val("");
                        $("#apellido_paterno").val("");
                        $("#apellido_materno").val("");

                        $("#razon_social").val("");
                        $("#direccion").val("");
                    },
                    success: function(data){
                        if (data.exists == false) {
                            if (data.match == true){
                                info = data.info;

                                
                                $("#idempresa").val(data.id_empresa);

                                if (data.tipo_empresa == 0){ // NATURAL
                                    $("#nombres").val(info.nombre);
                                    $("#apellido_paterno").val(info.paterno);
                                    $("#apellido_materno").val(info.materno);

                                    if (info.sexo == "Masculino")
                                        $("#genero").val("0");
                                    if (info.sexo == "Femenino")
                                        $("#genero").val("1");
                                }
                                else{ // JURIDICO
                                    $("#razon_social").val(info.result.razon_social);
                                    $("#direccion").val(info.result.direccion);

                                    ubigeo = info.result.ubigeo;

                                    dpto = ubigeo.substr(0,2);
                                                                        prov = ubigeo.substr(2,2);
                                                                        dist = ubigeo.substr(4,2);

                                                                        $("#departamento").val(dpto);

                                                                        getProvincias(dpto, prov, "", "", false);
                                                                        getDistritos(dpto, prov, dist);
                                }
                            }
                            else{
                                Swal.fire({
                                            icon: "info",
                                            title: "¡Algo ha ocurrido!",
                                            html: "<b class='color-red'>" + data.message + "</b>",
                                            showConfirmButton: true,
                                            timer: 6000
                                        });
                            }
                        }
                        else{
                            Swal.fire({
                                        icon: "info",
                                        title: "¡Algo ha ocurrido!",
                                        html: "<b class='color-red'>" + data.message + "</b>",
                                        showConfirmButton: true,
                                        timer: 6000
                                    });
                        }
                    },
                    complete: function(){
                        $(".icon-loading-lg").hide("fast");
                        $('.btn-search-sunat').show("fast");
                    }
                });
            }
        }

        
/* CTA BANCARIA */
    
        function modal_CtasBancarias( empresa = null, persona = null, razon_social = "" ){

            $("#modal_bancos").modal("toggle");

            title = razon_social.split("-");
            $(".titleRuc").html(title[0]);
            $(".titleRazonSocial").html(title[1]);
            $("#btn-ctabancoempresa").val(empresa);
            $("#btn-ctabancopersona").val(persona);
            
            getTableCtaBancarias();
        }

        function getTableCtaBancarias(){
            $('#table-bancos').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                        url : '<?=base_url();?>index.php/tesoreria/bancocta/datatable_ctaEmpresa',
                        type: "POST",
                        data: {
                            empresa: $("#btn-ctabancoempresa").val(),
                            persona: $("#btn-ctabancopersona").val()
                        },
                        beforeSend: function(){
                            $("#table-bancos .loading-table").show();
                        },
                        error: function(){
                        },
                        complete: function(){
                            $("#table-bancos .loading-table").hide();
                        }
                },
                language: spanish,
                order: [[ 0, "asc" ]]
            });
        }

        function editar_CtaBancaria( id ){
            var url = base_url + "index.php/tesoreria/bancocta/getCtaBancaria";
            $.ajax({
                type: 'POST',
                url: url,
                dataType: 'json',
                data:{
                        cta_bancaria: id
                },
                beforeSend: function(){
                    clean_sucursal();
                    $("#modal_addctabancaria").modal("toggle");
                },
                success: function(data){
                    if (data.match == true) {
                        info = data.info;

                        $("#cta_bancaria").val(info.cta_bancaria);
                        $("#cta_bancaria_empresa").val(info.empresa);
                        $("#cta_bancaria_persona").val(info.persona);
                        $("#banco").val(info.banco);
                        $("#cta_bancaria_titular").val(info.titular);
                        $("#cta_bancaria_numero").val(info.cta_numero);
                        $("#cta_bancaria_interbancaria").val(info.cta_interbancaria);
                        $("#cta_bancaria_tipo").val(info.tipo_cuenta);
                        $("#cta_bancaria_moneda").val(info.moneda);
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

        function registrar_CtaBancaria(){
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
                            var url = base_url + "index.php/tesoreria/bancocta/guardar_ctabancaria";

                            var cta = $("#cta_bancaria").val();
                            var empresa = $("#cta_bancaria_empresa").val();
                            var persona = $("#cta_bancaria_persona").val();
                            var banco = $("#banco").val();
                            var titular = $("#cta_bancaria_titular").val();
                            var tipo = $("#cta_bancaria_tipo").val();
                            var moneda = $("#cta_bancaria_moneda").val();
                            var numero = $("#cta_bancaria_numero").val();
                            var interbancaria = $("#cta_bancaria_interbancaria").val();

                            validacion = true;

                            if (titular == ""){
                                Swal.fire({
                                            icon: "error",
                                            title: "Verifique los datos ingresados.",
                                            html: "<b class='color-red'>Debe ingresar un titular.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                $("#cta_bancaria_titular").focus();
                                validacion = false;
                                return false;
                            }

                            if (numero == ""){
                                Swal.fire({
                                            icon: "error",
                                            title: "Verifique los datos ingresados.",
                                            html: "<b class='color-red'>Debe ingresar un número de cuenta.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                        });
                                $("#cta_bancaria_numero").focus();
                                validacion = false;
                                return false;
                            }

                            if (cta == ""){
                                $("#cta_bancaria_empresa").val( $("#btn-ctabancoempresa").val() );
                                $("#cta_bancaria_persona").val( $("#btn-ctabancopersona").val() );

                                if ( $("#cta_bancaria_empresa").val() == "" && $("#cta_bancaria_persona").val() == "" ){
                                    Swal.fire({
                                            icon: "error",
                                            title: "No hay cliente/proveedor seleccionado.",
                                            html: "<b class='color-red'>Cierre el formulario de cuentas bancarias e intente ingresar nuevamente.</b>",
                                            showConfirmButton: true,
                                            timer: 4000
                                    });
                                }
                            }

                            if (validacion == true){
                                var dataForm = $("#formCtaBancaria").serialize();
                                $.ajax({
                                    type: 'POST',
                                    url: url,
                                    dataType: 'json',
                                    data: dataForm,
                                    success: function(data){
                                        if (data.result == "success") {
                                            if (cta == "")
                                                titulo = "¡Registro exitoso!";
                                            else
                                                titulo = "¡Actualización exitosa!";

                                            Swal.fire({
                                                icon: "success",
                                                title: titulo,
                                                showConfirmButton: true,
                                                timer: 2000
                                            });

                                            clean_CtaBancaria();
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
                                        getTableCtaBancarias();
                                    }
                                });
                            }
                        }
                    });
        }

        function deshabilitar_CtaBancaria(id){
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
                            var url = base_url + "index.php/tesoreria/bancocta/deshabilitar_ctabancaria";
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: {
                                    cta_bancaria: id
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
                                    getTableCtaBancarias();
                                }
                            });
                        }
                    });
        }

        function clean_CtaBancaria(){
            $("#cta_bancaria").val("");
            $("#cta_bancaria_empresa").val("");
            $("#cta_bancaria_persona").val("");
            $("#formCtaBancaria")[0].reset();
        }

    /* END CTA BANCARIA */
</script>