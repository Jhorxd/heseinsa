<!-- MODAL CLIENTE-->
    <div id="modal_asociarCoti" class="modal fade" role="dialog" data-backdrop="static">
        <div class="modal-dialog w-porc-80">
            <div class="modal-content">
                <form id="asoc_Cot" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title"></h4>
                    </div>
                    <div style="text-align: center;">
                        <h3><b>ASOCIAR COTIZACIÓN</b></h3>
                    </div>
                    <div class="modal-body panel panel-default">
                        <div class="row form-group">
                            <div class="col-sm-11 col-md-11 col-lg-11 header form-group">
                                <span>INFORMACIÓN DEL DOCUMENTO</span>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-sm-12 col-md-12 col-lg-12">
                                <table class="fuente8 display" id="table-asociarcoti">
                                    <div id="cargando_datos" class="loading-table">
                                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                                    </div>
                                    <thead>
                                    <tr class="cabeceraTabla">
                                        <th style="width: 08%" data-orderable="true">FECHA</th>
                                        <th style="width: 05%" data-orderable="true">SERIE</th>
                                        <th style="width: 05%" data-orderable="true">NÚMERO</th>
                                        <th style="width: 10%" data-orderable="true">RUC</th>
                                        <th style="width: 50%" data-orderable="true">RAZON SOCIAL</th>
                                        <th style="width: 07%" data-orderable="false">TOTAL</th>
                                        <th style="width: 07%" data-orderable="false">PDF.</th>
                                        <th style="width: 07%" data-orderable="false">SEL.</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="salir_modal_coti" data-dismiss="modal">Salir</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- END MODAL CLIENTE-->

<script type="text/javascript">
   
    function buscar_asociarCoti() {

            proveedor        = $("#proveedor").val();
            cliente          = $("#cliente").val();
            tipo_oper        = $("#tipo_oper").val();
            
            if (tipo_oper=="V") {
                if (cliente=="") {

                    Swal.fire({
                        icon: "error",
                        title: "Debe seleccionar el cliente.",
                        html: "<b class='color-red'>Debe ingresar una razón social.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    $("#nombre_cliente").focus();
                    
                    return false;
                }
            }else{
                if (proveedor=="") {
                    Swal.fire({
                        icon: "error",
                        title: "Debe seleccionar el proveedor.",
                        html: "<b class='color-red'>Debe ingresar una razón social.</b>",
                        showConfirmButton: true,
                        timer: 4000
                    });
                    $("#nombre_proveedor").focus();
                    $("#salir_modal_coti").click();
                    return false;
                }
            }
           
            $("#modal_asociarCoti").modal("toggle");
            $('#table-asociarcoti').DataTable({
                filter: false,
                destroy: true,
                processing: true,
                searching: true,
                autoWidth: false,
                ajax:{
                        url : '<?=base_url();?>index.php/compras/ocompra/buscarAsociarCoti/',
                        type: "POST",
                        data: {
                            cliente:cliente,
                            proveedor:proveedor,
                            tipo_oper:tipo_oper
                        },
                        beforeSend: function(){
                            $(".loading-table").show();
                        },
                        error: function(){
                        },
                        complete: function(){
                            $(".loading-table").hide();
                        }
                },
                language: spanish,
                order: [[ 0, "desc" ]]
            });
        
    } 


    

</script>