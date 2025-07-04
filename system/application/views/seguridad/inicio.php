<script type="text/javascript" src="<?=base_url(); ?>js/maestros/tipocambio.js?=<?=JS;?>"></script>

<section class="general">
    <span class="header titulo">ACTIVIDADES RECIENTES / AVISOS</span>
    <section class="opcionesL">

        <section class="box">
            <span class="titulo">TRANSFERENCIAS EN OBSERVACIÓN
                <span style="float: right"> <img src="<?=base_url();?>images/icon-menu.png" class="icon-box-nav gtrans"> </span>
            </span>
            <table class="fuente8 display" id="table-gtrans" style="width: 100%">
                <span class="loading-table">
                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                </span>
                <thead>
                    <tr class="cabeceraTabla">
                        <th style="width: 15%" data-orderable="true">FECHA</th>
                        <th style="width: 15%" data-orderable="true">SERIE</th>
                        <th style="width: 15%" data-orderable="true">NÚMERO</th>
                        <th style="width: 40%" data-orderable="true">ALMACEN ORIGEN</th>
                        <th style="width: 15%" data-orderable="false">MOVIMIENTO</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
        
        <section class="box">
            <span class="titulo">ARTICULOS POR DEBAJO DEL STOCK
                <span style="float: right"> <img src="<?=base_url();?>images/icon-menu.png" class="icon-box-nav list-stock"> </span>
            </span>
            <table class="fuente8 display" id="table-list-stock" style="width: 100%">
                <span class="loading-table">
                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                </span>
                <thead>
                    <tr class="cabeceraTabla">
                        <th style="width: 15%" data-orderable="true">CODIGO</th>
                        <th style="width: 50%" data-orderable="true">PRODUCTO</th>
                        <th style="width: 15%" data-orderable="true">STOCK ACTUAL</th>
                        <th style="width: 20%" data-orderable="true">STOCK MIN.</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </section>

    <section class="opcionesR">
        <section class="box">
            <span class="titulo">TIPOS DE CAMBIOS REGISTRADOS 
                <span style="float: right">
                    <span class="btn btn-primary open-modal-tc" data-toggle="modal" data-target=".modal-tc" style="font-size: 8pt;">TIPO DE CAMBIO</span>
                    <img src="<?=base_url();?>images/icon-menu.png" class="icon-box-nav tcambio">
                </span>
            </span>
                
            <table class="fuente8 display" id="table-tcambio" style="width: 100%">
                <span class="loading-table">
                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                </span>
                <thead>
                    <tr class="cabeceraTabla">
                        <th style="width: 30%" data-orderable="false">MONEDA ORIGEN</th>
                        <th style="width: 30%" data-orderable="false">MONEDA DESTINO</th>
                        <th style="width: 10%" data-orderable="false">TASA</th>
                        <th style="width: 30%" data-orderable="false">CONVERSIÓN</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </section>
    </section>
</section>

<div class="modal fade modal-tc" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
    <div class="modal-content" style="width: 50%; height: auto; margin: auto; font-family: Trebuchet MS, sans-serif; font-size: 11pt; padding-bottom: 40px;">
            <div style="text-align: center;">
                <h4>TIPO DE CAMBIO DEL: <?=date("d / m / Y ");?></h4>
                                <button onclick="consultarTipoCambio()">Consultar Tipo de Cambio</button>
                                 <div id="alerta-tipo-cambio"></div>
            </div>
            <form method="post" id="form-tc"style="display: none;">
                <div class="contenido" style="width: 100%; margin: auto; height: auto; overflow: auto;">
                    <div class="tempde_body"></div>
                    <div class="tempde_footer">
                        <div class="row">
                            <div class="col-sm-1 col-md-1 col-lg-1"></div>
                            <div class="col-sm-7 col-md-7 col-lg-7" style="text-align: center;">
                                <a href="#" class="btn btn-success tempde_addTipoCambio">Aceptar</a>
                            </div>
                            <div class="col-sm-2 col-md-2 col-lg-2"></div>
                        </div>
                        <br>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){

        var faltan_cambios = <?=$tcf;?>;
        
        if ( faltan_cambios == 1){
            $('.modal-tc').modal("toggle");
            existsTC();
        }

        $(".open-modal-tc").click(function(){
            existsTC();
        });

        var table_gtrans = $('#table-gtrans').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/guiatrans/datatable_guias_transito/',
                    type: "POST",
                    data: { info: "" },
                    beforeSend: function(){
                        $("#table-gtrans .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-gtrans .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "desc" ]]
        });

        var table_tcambio = $('#table-tcambio').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/maestros/tipocambio/datatable_listTipoCambio/',
                    type: "POST",
                    data: { info: "" },
                    beforeSend: function(){
                        $("#table-tcambio .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-gtrans .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "ASC" ]]
        });
        
        var table_stock = $('#table-list-stock').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                    url : '<?=base_url();?>index.php/almacen/producto/datatable_list_stock/',
                    type: "POST",
                    data: { info: "" },
                    beforeSend: function(){
                        $("#table-list-stock .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-list-stock .loading-table").hide();
                    }
            },
            language: spanish,
            order: [[ 0, "desc" ]]
        });

        $(".modal-tc").on("keyup", "", function(event) {
            if(event.keyCode == 13) {
                $(".tempde_addTipoCambio").click();
            }
        });

        $(".tempde_addTipoCambio").click(function(){

            var size_cambios = $(".inputsTC").length;

            moneda = []; // Inicializo ambos arrays.
            tipo_cambio = []; // Inicializo ambos arrays.

            for (i = 0; i < size_cambios; i++){
                if ( $.isNumeric( $(".tipo_cambio"+i).val() ) == true ){
                    if ( $(".tipo_cambio"+i).val() == "" ){
                        Swal.fire({
                            icon: "warning",
                            title: "Debe ingresar todos los tipos de cambio.",
                            showConfirmButton: true,
                            timer: 2000
                        });
                        $(".tipo_cambio"+i).focus();
                        return null;
                    }
                    else{
                        moneda.push( $(".moneda"+i).val() ); // Añado nuevos box al final de cada array con el metodo push 
                        tipo_cambio.push( $(".tipo_cambio"+i).val() ); // Añado nuevos box al final de cada array con el metodo push 
                    }
                }
                else{
                    Swal.fire({
                            icon: "warning",
                            title: "Tipo de cambio invalido. Debe indicar un valor númerico.",
                            showConfirmButton: true,
                            timer: 2000
                    });
                    return null;
                }
            }

            var url = "<?=base_url();?>index.php/maestros/tipocambio/ingesar_tipo_cambio";
            $.ajax({
                url:url,
                type:"POST",
                data:{ moneda: moneda, tipo_cambio: tipo_cambio }, // Envio ambos arrays por post
                dataType:"json",
                error:function(data){
                },
                success:function(data){
                    if (data.result == "success"){
                        Swal.fire({
                            icon: "success",
                            title: "Tipo de cambio registrado",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        close_modal();
                    }
                    else{
                        Swal.fire({
                            icon: "error",
                            title: "El tipo de cambio fue rechazado. Intentelo nuevamente.",
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                },
                complete: function(){
                    table_tcambio.ajax.reload();
                }
            });
        });

        $(".list-stock").click(function(){
            if ( $("#table-list-stock_wrapper").css("display") == "block" )
                $("#table-list-stock_wrapper").hide("slow");
            else
                $("#table-list-stock_wrapper").show("slow");
        });

        $(".gtrans").click(function(){
            if ( $("#table-gtrans_wrapper").css("display") == "block" )
                $("#table-gtrans_wrapper").hide("slow");
            else
                $("#table-gtrans_wrapper").show("slow");
        });

        $(".tcambio").click(function(){
            if ( $("#table-tcambio_wrapper").css("display") == "block" )
                $("#table-tcambio_wrapper").hide("slow");
            else
                $("#table-tcambio_wrapper").show("slow");
        });
    });

    function close_modal(){
        $('.modal-tc').modal("hide");
    }

    function existsTC(){

        var url = "<?=base_url();?>index.php/maestros/tipocambio/getFechaTc";
        $.ajax({
            url:url,
            type:"POST",
            data:{ fecha: "" },
            dataType:"json",
            error:function(data){
            },
            success:function(data){
                $(".tempde_body .row").remove();
                $.each(data.info, function (i, item){

                    if (item.tipo_cambio == null)
                        item.tipo_cambio = 0;

                    // TITULOS
                        M = "<div class='row'>";
                            M += "<div class='col-sm-2 col-md-2 col-lg-2 tempde_stock'></div>";

                            M += "<div class='col-sm-2 col-md-2 col-lg-2 tempde_stock'>";
                                M += "<label for='tipo_cambio[" + i + "]'>" + item.moneda_origen + "</label>";
                            M += "</div>";

                            M += "<div class='col-sm-3 col-md-3 col-lg-3 tempde_stock'>";
                                M += "<label for='tipo_cambio[" + i + "]'>" + item.descripcion + "</label>";
                            M += "</div>";
                        
                        M += "</div>";

                    // INPUTS
                        M += "<div class='row'>";
                            M += "<div class='col-sm-2 col-md-2 col-lg-2 tempde_stock'></div>";

                            M += "<div class='col-sm-2 col-md-2 col-lg-2 tempde_stock'>";
                                M += "<input type='number' min='0.00' class='form-control inputsTC tipo_cambio"+i+"' style='width: 85%' id='tipo_cambio[" + i + "]' value='" + item.tipo_cambio + "' placeholder='0.00'>";
                            M += "</div>";

                            M += "<div class='col-sm-3 col-md-3 col-lg-3 tempde_stock'>";
                                M += "<input type='hidden' id='moneda[" + i + "]' value='" + item.moneda + "' class='moneda"+i+"'>";
                                M += "<input type='text' class='form-control cajaSoloLectura' value='" + item.simbolo + " 1' readonly>";
                            M += "</div>";
                        M += "</div>";

                    M += "<div class='row'> <div class='col-sm-7 col-md-7 col-lg-7 tempde_stock'>&nbsp;</div> </div>";
                        
                    $(".tempde_body").append(M);
                });
            },
            complete: function(){
                $(".tipo_cambio0").focus();
            }
        });
    }
        function mostrarAlerta(mensaje, esError = false) {
        const alerta = document.getElementById('alerta-tipo-cambio');
        if (!alerta) {
            console.error("No se encontró el div con ID 'alerta-tipo-cambio'");
            return;
        }
        alerta.innerHTML = mensaje;
        alerta.style.backgroundColor = esError ? '#f44336' : '#4caf50';
        alerta.style.display = 'block';

        setTimeout(() => {
            alerta.style.display = 'none';
        }, 5000);
    }
    function consultarTipoCambio() {

                var table_tcambio = $('#table-tcambio').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                        url : '<?=base_url();?>index.php/maestros/tipocambio/datatable_listTipoCambio/',
                        type: "POST",
                        data: { info: "" },
                        beforeSend: function(){
                            $("#table-tcambio .loading-table").show();
                        },
                        error: function(){
                        },
                        complete: function(){
                            $("#table-gtrans .loading-table").hide();
                        }
                },
                language: spanish,
                order: [[ 0, "ASC" ]]
            });
        var url = "<?=base_url();?>index.php/tcsunat";         
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.success !== false) {
                    const tipoCambio = {
                        compra: data.data.compra,
                        venta: data.data.venta,
                        fecha: data.data.fecha_sunat,
                        moneda: data.data.moneda
                    };
    
                    // ENVÍO A BACKEND PARA GUARDAR EN BD
                    fetch("<?=base_url();?>index.php/maestros/tipocambio/ingresar_tipo_cambio_automatico", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json"
                        },
                        body: JSON.stringify(tipoCambio)
                    })
                    .then(res => res.json())
                    .then(resp => {
                        if (resp.success) {
                            mostrarAlerta("Tipo de cambio guardado correctamente.", false);
                              table_tcambio.ajax.reload(); 
                            
                        } else {
                            mostrarAlerta("Error al guardar tipo de cambio.", true);
                        }
                    })
                    .catch(error => {
                        mostrarAlerta("Fallo al comunicar con el servidor.", true);
                    });
    
                } else {
                    mostrarAlerta("No se pudo obtener el tipo de cambio.", true);
                }
            })
            .catch(error => {
                mostrarAlerta("Error en la solicitud al servidor.", true);
            });
    }
</script>