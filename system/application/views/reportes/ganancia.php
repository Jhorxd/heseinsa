<link href="<?=base_url();?>js/fancybox/dist/jquery.fancybox.css?=<?=CSS;?>" rel="stylesheet">
<script src="<?=base_url();?>js/fancybox/dist/jquery.fancybox.js?=<?=JS;?>"></script>
<style>
#detalles{
    font-size: 12px;
    background-color: #849cb6;
    padding: 2px;
    border-radius: 5px 5px 5px 5px ;
    width: 55%;

}

.small-box {
    border-radius: 0.25rem;
    box-shadow: 0 0 1px rgb(0 0 0 / 13%), 0 1px 3px rgb(0 0 0 / 20%);
    display: block;
    margin-bottom: 20px;
    position: relative;
} 

.bg-danger, .bg-danger>a {
    color: #fff!important;
}

.bg-warning {
    background-color: #ffc107!important;
}

.bg-danger {
    background-color: #dc3545!important;
}


.bg-warning, .bg-warning>a {
    color: #1f2d3d!important;
}

.bg-info {
    background-color: #17a2b8!important;
}   

.bg-info, .bg-info>a {
    color: #fff!important;
}

.bg-success {
    background-color: #28a745!important;
}

.bg-success, .bg-success>a {
    color: #fff!important;
}

.small-box>.inner {
    padding: 10px;

}

.small-box .icon {
    color: rgba(0,0,0,.15);
    z-index: 0;
}

.small-box h3 {
    font-size: 3.2rem;
    font-weight: 700;
    margin: 0 0 10px;
    padding: 0;
    white-space: nowrap;
}



.small-box .icon>i {
    font-size: 90px;
    position: absolute;
    right: 15px;
    top: 15px;
    transition: -webkit-transform .3s linear;
    transition: transform .3s linear;
    transition: transform .3s linear,-webkit-transform .3s linear;
}

.small-box .icon>i.fa, .small-box .icon>i.fab, .small-box .icon>i.fad, .small-box .icon>i.fal, .small-box .icon>i.far, .small-box .icon>i.fas, .small-box .icon>i.ion {
    font-size: 70px;
    top: 20px;
}

</style>
<div class="container-fluid">
    <div class="row header">
        <div class="col-md-12 col-lg-12">
            <div><?=$titulo_tabla;?></div>
        </div>
    </div>
    <form id="form_busqueda" method="post">
        <section>
            
        <div class="row fuente8 py-1">
            <div class="col-sm-3 col-md-3 col-lg-3">
                <label for="search_descripcion">PRODUCTO</label>
                <input type="text" name="search_descripcion" id="search_descripcion" value="" placeholder="Nombre del producto" class="form-control h-1 w-porc-90"/>
                <input type="hidden" name="producto" id="producto" value="" placeholder="codigo" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_fechai">FECHA INICIO</label>
                <input type="date" name="search_fechai" id="search_fechai" value="" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="search_fechaf">FECHA FIN</label>
                <input type="date" name="search_fechaf" id="search_fechaf" value="" class="form-control h-1 w-porc-90"/>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1">
                <label for="moneda">MONEDA</label>
                <select name="moneda" id="moneda" class="form-control w-porc-90 h-2"> <?php
                    if ($moneda != NULL){
                        foreach ($moneda as $indice => $val){ ?>
                            <option value="<?=$val->MONED_Codigo;?>"><?="$val->MONED_Simbolo | $val->MONED_Descripcion";?></option> <?php
                        }
                    } ?>
                </select>
            </div>
            <div class="col-sm-2 col-md-2 col-lg-2">
                <label for="moneda">ESTABLECIMIENTO</label>
                <select name="locales" id="locales" class="form-control w-porc-90 h-2"> 
                    <option value="0">TODOS</option> 
                    <?php 
                    foreach($lista_companias as $valor){ ?>
                           <option value="<?=$valor->COMPP_Codigo;?>" <?=($valor->COMPP_Codigo == $_SESSION['compania']) ? 'selected' : '';?>><?="$valor->EESTABC_Descripcion";?></option> 
                    <?php
                        
                    } ?>
                </select>
            </div>
            
        </div>
        </section>
</form>
        <div class="row">
          <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="ventas_aprobadas" name="ventas_aprobadas"><?=$ventas_aprobadas;?></h3>
                <p>Ventas aprobadas</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              
            </div>
          </div>
          <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3 id="total_ventas" name="total_ventas"><?=$total_ventas;?></h3>
                <p>Total en Ventas</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3 id="total_costo" name="total_costo"><?=$total_costo;?></h3>
                <p>Total costo</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
             
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3 id="total_utilidad" name="total_utilidad"><?=$total_utilidad;?></h3>
                <p>Utilidad Bruta</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-2 col-2">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3 id="por_utilidad" name="por_utilidad"><?=$por_utilidad;?>%</h3>
                <p>% Utilidad</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              
            </div>
          </div>
          <!-- ./col -->
        </div>

    <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <div class="acciones">
                        <div id="botonBusqueda">
                            <ul id="limpiarC" class="lista_botones">
                                <li id="limpiar">Limpiar</li>
                            </ul>
                            <ul id="buscarC" class="lista_botones">
                                <li id="buscar">Buscar</li>
                            </ul>
                            <ul onclick="descargarExcel()" class="lista_botones">
                                <li id="excel">Reporte</li>
                            </ul>
                        </div>
                        <div id="lineaResultado">Productos vendidos</div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                    <table class="fuente8 display" id="table-ganancia">
                        <div id="cargando_datos" class="loading-table">
                            <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                        </div>
                        <thead>
                            <tr class="cabeceraTabla">
                                <td style="width:10%" data-orderable="false" title="">Fecha</td>
                                <td style="width:10%" data-orderable="false" title="">Establec</td>
                                <td style="width:22%" data-orderable="false" title="">Producto</td>
                                <td style="width:05%" data-orderable="false" title="">CANT</td>
                                <td style="width:05%" data-orderable="false" title="">Moneda</td>
                                <td style="width:08%" data-orderable="false" title="">PU. Costo</td>
                                <td style="width:08%" data-orderable="false" title="">PU. Venta</td>
                                <td style="width:08%" data-orderable="false" title="">Costo</td>
                                <td style="width:08%" data-orderable="false" title="">Venta</td>
                                <td style="width:08%" data-orderable="false" title="">Utilidad</td>
                                <td style="width:08%" data-orderable="false" title="">%utulidad</td>
                            </tr>
                        </thead>
                        <tbody id="tbody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    base_url = "<?=$base_url;?>";

$(document).ready(function(){

        $('#table-ganancia').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            ajax:{
                url : '<?=base_url();?>index.php/reportes/ventas/datatable_ganancia/',
                type: "POST",
                data: { dataString: "" },
                beforeSend: function(){
                    $("#table-ganancia .loading-table").show();
                },
                error: function(){
                },
                complete: function(){
                    $("#table-ganancia .loading-table").hide();
                }
            },
            language: spanish,
            columnDefs: [{"className": "dt-center", "targets": 0}],
            order: [[ 1, "asc" ]]
        });
        
        $("#search_descripcion").autocomplete({
                source: function (request, response) {

                    tipo_oper='V';
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/maestros/temporaldetalle/autocomplete_producto/B/" + <?php echo $compania;?>+"/1",
                        type: "POST",
                        data: {
                            term: $("#search_descripcion").val(), TipCli: $("#TipCli").val(), familia: $("#tempde_filtro_familia").val(), marca: $("#tempde_filtro_marca").val(), modelo: $("#tempde_filtro_modelo").val(), tipo_oper: tipo_oper 
                        },
                        dataType: "json",
                        success: function (data) {
                            response(data);
                        }
                    });
                },
                select: function (event, ui) {
                    /**si el producto tiene almacen : es que no esta inventariado en ese almacen , se le asigna el almacen general de cabecera**/
                    
                    
                    $("#producto").val(ui.item.codigo);
                    $("#search_codigo").val(ui.item.value);
                    $("#search_descripcion").val(ui.item.nombre);       
                        
                    
                },
                minLength: 1
        });

     
        $("#buscarC").click(function(){

            ganancias_globales();
            
            
            producto            = $("#producto").val();
            search_fechai       = $("#search_fechai").val();
            search_fechaf       = $("#search_fechaf").val();
            moneda              = $("#moneda").val();
            companias           = $("#locales").val();
            
            $('#table-ganancia').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/reportes/ventas/datatable_ganancia/',
                    type: "POST",
                    data: {
                            producto: producto,
                            companias: companias,
                            moneda: moneda,
                            fechai: search_fechai,
                            fechaf: search_fechaf
                        },
                    beforeSend: function(){
                        $("#table-ganancia .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-ganancia .loading-table").hide();
                        
                    }
                },
                language: spanish,
                columnDefs: [{"className": "dt-center", "targets": 0}],
                order: [[ 1, "asc" ]]
            });
        });


        $("#limpiarC").click(function(){

            producto            = "";
            search_fechai       = "";
            search_fechaf       = "";
            moneda              = "";
            companias           = "";
            $("#producto").val("");
            $("#search_fechai").val("");
            $("#search_fechaf").val("");
            $("#moneda").val("");
            $("#locales").val("");

            ganancias_globales();
            
            $('#table-ganancia').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                autoWidth: false,
                ajax:{
                    url : '<?=base_url();?>index.php/reportes/ventas/datatable_ganancia/',
                    type: "POST",
                    data: {
                            producto: producto,
                            companias: companias,
                            moneda: moneda,
                            fechai: search_fechai,
                            fechaf: search_fechaf
                        },
                    beforeSend: function(){
                        $("#table-ganancia .loading-table").show();
                    },
                    error: function(){
                    },
                    complete: function(){
                        $("#table-ganancia .loading-table").hide();
                    }
                },
                language: spanish,
                columnDefs: [{"className": "dt-center", "targets": 0}],
                order: [[ 1, "asc" ]]
            });
        });

        $('#form_busqueda').keypress(function(e){
            if ( e.which == 13 ){
                return false;
            } 
        });
});

        

function descargarExcel() {
    base_url = "<?php echo base_url();?>";
    
    if (!$('#producto').val()){
        productoBuscar_id= 'noValue';
    }
    else {
        productoBuscar_id= $('#producto').val();
    }

    if ($('#search_fechai').val() && $('#search_fechaf').val()){
        IntervalosFechas = $('#search_fechai').val()+'-'+$('#search_fechaf').val();
    }
    else {
        IntervalosFechas = 'noValue';
    }

    Companias = "1";
    moneda=$('#moneda').val();
    location.href = base_url + "index.php/reportes/ventas/gananciaExcel/"+productoBuscar_id+"/"+Companias+"/"+IntervalosFechas+"/"+moneda;
}

function ganancias_globales() {
    producto            = $("#producto").val();
    search_fechai       = $("#search_fechai").val();
    search_fechaf       = $("#search_fechaf").val();
    moneda              = $("#moneda").val();
    companias           = $("#locales").val();
    var url = base_url + "index.php/reportes/ventas/busca_ganancia_global";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                producto: producto,
                companias: companias,
                moneda: moneda,
                fechai: search_fechai,
                fechaf: search_fechaf
            },
            beforeSend: function(){
               
            },
            success: function(data){
                    ventas_aprobadas = document.getElementById("ventas_aprobadas");
                    ventas_aprobadas.innerHTML=data.ventas_aprobadas;

                    total_ventas = document.getElementById("total_ventas");
                    total_ventas.innerHTML=data.total_ventas;

                    total_costo = document.getElementById("total_costo");
                    total_costo.innerHTML=data.total_costo;
                    
                    total_utilidad = document.getElementById("total_utilidad");
                    total_utilidad.innerHTML=data.total_utilidad;
                    
                    por_utilidad = document.getElementById("por_utilidad");
                    por_utilidad.innerHTML=data.por_utilidad+ "%";

                    
            },
            complete: function(){
            }
        });
}


</script>



