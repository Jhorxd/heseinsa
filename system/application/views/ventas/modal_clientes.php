<!-- MODAL CLIENTE-->
    <div id="modal_addcliente" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog w-porc-80">
            <div class="modal-content">
                <form id="formCliente" method="POST">
                    <div class="modal-header" style="text-align: center;">
                        <h2 class="modal-title">REGISTRAR CLIENTE</h2>
                    </div>
                    <div class="modal-body panel panel-default">
                        <input type="hidden" id="modal_cliente" name="modal_cliente" value="">
                        <input type="hidden" id="operacionE" name="operacionE" value="">

                        <div class="row form-group">
                            <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                                <span>INFORMACIÓN DEL CLIENTE</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="tipo_cliente">Tipo Cliente/Proveedor</label>
                                <select id="tipo_cliente" name="tipo_cliente" class="form-control h-3 w-porc-90">
                                    <option value="0">NATURAL</option>
                                    <option value="1" selected>JURIDICO</option>
                                </select>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="tipo_documento">Tipo de documento</label>
                                <select id="tipo_documento" name="tipo_documento" class="form-control h-3 w-porc-90">
                                    <optgroup label="Natural" disabled class="documentosNatural"> <?php
                                        foreach ($documentosNatural as $i => $val){ ?>
                                            <option class="DOC0" value="<?=$val->TIPDOCP_Codigo;?>"><?=$val->TIPOCC_Inciales;?></option> <?php
                                        } ?>
                                    </optgroup>

                                    <optgroup label="Juridico" class="documentosJuridico"> <?php
                                        foreach ($documentosJuridico as $i => $val){ ?>
                                            <option class="DOC1" value="<?=$val->TIPCOD_Codigo;?>"><?=$val->TIPCOD_Inciales;?></option> <?php
                                        } ?>
                                    </optgroup>
                                    
                                </select>
                            </div>
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

                        <!--********** NATURAL **********-->
                            <div class="row form-group divNatural" hidden>
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
                                <label for="fax">Fax</label>
                                <input type="number" id="fax" name="fax" class="form-control h-2 w-porc-90" placeholder="000 000 000" val="" autocomplete="off">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="correo">Correo</label>
                                <input type="email" id="correo" name="correo" class="form-control h-2 w-porc-90" placeholder="cliente@empresa.com" val="" autocomplete="off">
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2">
                                <label for="web">Dirección web</label>
                                <input type="url" id="web" name="web" class="form-control h-2 w-porc-90" placeholder="" val="http://www.google.com" autocomplete="off">
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" onclick="registrar_cliente()">Guardar Registro</button>
                        <button type="button" class="btn btn-info" onclick="clean()">Limpiar</button>
                        <button type="button" class="btn btn-default" id="salir_modal_cliente" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END MODAL CLIENTE-->

<script type="text/javascript">
    
    function registrar_cliente(){
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
                        if (tipo_oper=="C") {
                            var url = base_url + "index.php/compras/proveedor/guardar_registro";
                        }else{
                            var url = base_url + "index.php/ventas/cliente/guardar_registro";
                        }


                        cliente         = "";

                        tipo_cliente    = $("#tipo_cliente").val();
                        tipo_documento  = $("#tipo_documento").val();
                        numero_documento = $("#numero_documento").val();
                        
                        razon_social    = $("#razon_social").val();
                        
                        nombres         = $("#nombres").val();
                        apellido_paterno = $("#apellido_paterno").val();
                        apellido_materno = $("#apellido_materno").val();
                        genero          = $("#genero").val();
                        edo_civil       = $("#edo_civil").val();
                        nacionalidad    = $("#nacionalidad").val();
                        
                        direccion       = $("#direccion").val();
                        departamento    = $("#departamento").val();
                        provincia       = $("#provincia").val();
                        distrito        = $("#distrito").val();

                        idcliente       = $("#idcliente").val();
                        vendedor        = $("#vendedor").val();
                        sector_comercial = $("#sector_comercial").val();
                        forma_pago      = $("#forma_pago").val();
                        categoria       = $("#categoria").val();
                        telefono        = $("#telefono").val();
                        movil           = $("#movil").val();
                        fax             = $("#fax").val();
                        correo          = $("#correo").val();
                        web             = $("#web").val();

                        validacion = true;

                        if (tipo_cliente == "1"){
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
                        }
                        else{
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
                            var dataForm = $("#formCliente").serialize();
                            $.ajax({
                                type: 'POST',
                                url: url,
                                dataType: 'json',
                                data: dataForm,
                                success: function(data){
                                    if (data.result == "success") {
                                        if (cliente == "")
                                            titulo = "¡Registro exitoso!";
                                        else
                                            titulo = "¡Actualización exitosa!";

                                        Swal.fire({
                                            icon: "success",
                                            title: titulo,
                                            showConfirmButton: true,
                                            timer: 2000
                                        });
                                        if (tipo_oper=="V") {
                                            if (tipo_cliente == "1"){
                                                $("#buscar_cliente").val(numero_documento);
                                                $("#nombre_cliente").val(razon_social);
                                                $("#cliente").val(data.codigo);
                                                $("#ruc_cliente").val(numero_documento);
                                            }else{
                                                $("#buscar_cliente").val(numero_documento);
                                                $("#nombre_cliente").val(nombres + ' ' + apellido_paterno + ' ' + apellido_materno);
                                                $("#cliente").val(data.codigo);
                                                $("#ruc_cliente").val(numero_documento);
                                                
                                            }
                                            clean();
                                            

                                        }

                                        if (tipo_oper=="C") {
                                            if (tipo_cliente == "1"){
                                                $("#buscar_proveedor").val(numero_documento);
                                                $("#nombre_proveedor").val(razon_social);
                                                $("#proveedor").val(data.codigo);
                                                $("#ruc_proveedor").val(numero_documento);
                                            }else{
                                                $("#buscar_proveedor").val(numero_documento);
                                                $("#nombre_proveedor").val(nombres + ' ' + apellido_paterno + ' ' + apellido_materno);
                                                $("#proveedor").val(data.codigo);
                                                $("#ruc_proveedor").val(numero_documento);
                                            }
                                            clean();
                                            
                                        }
                                        $("#tipocliente_doc").val(tipo_cliente);

                                        $("#modal_addcliente").modal("toggle");
                                        $("#salir_modal_cliente").click();
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
                                    $("#addItems").focus();
                                }
                            });
                        }
                    }
                });
    }

</script>