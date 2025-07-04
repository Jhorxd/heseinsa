<style>
/*BOTONES DE BUSQUEDA Y LIMPIAR*/
  .button {
    display: inline-block;
    border-radius: 4px;
    background-color: #35afe3;
    border: none;
    color: #FFFFFF;
    text-align: center;
    font-size: 12px;
    padding: 10px;
    width: 100px;
    transition: all 0.5s;
    cursor: pointer;
    margin: 5px;
  }

  .button span {
    cursor: pointer;
    display: inline-block;
    position: relative;
    transition: 0.5s;
  }

  .button span:after {
    content: '\00bb';
    position: absolute;
    opacity: 0;
    top: 0;
    right: -20px;
    transition: 0.5s;
  }

  .button:hover span {
    padding-right: 25px;
  }

  .button:hover span:after {
    opacity: 1;
    right: 0;
  }
/**/

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

</head>
<input type="hidden" name="tipo_oper" id="tipo_oper" value="<?=$tipo_oper;?>">

<div class="container-fluid">

  <h3><?php echo $titulo_tabla;?></h3>

  <section>
    <div class="row fuente8 py-1">
      <div class="col-sm-11 col-md-11">
        <div class="col-sm-2 col-md-2">
            <label for="tipo_doc">Tipo de documento</label>
            <select id="tipo_doc" name="tipo_doc" class="form-control h-2">
              <option value="">SELECCIONAR</option>
              <option value="V">REGISTRO DE VENTAS (SUNAT)</option>
              <option value="F">FACTURAS</option>
              <option value="B">BOLETAS</option>
              <option value="N">NOTAS DE VENTA</option>
              <option value="C">NOTAS DE CREDITOS</option>
              <option value="T">TODOS</option>
            </select>
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="fecha1">Desde</label>
            <input type="date" name="fecha1" id="fecha1" value="" class="form-control h-1" />
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="fecha2">Hasta</label>
            <input type="date" name="fecha2" id="fecha2" value="" class="form-control h-1" />
        </div>
        <div class="col-sm-2 col-md-2">
            <label for="forma_pago">Forma de Pago</label>
            <select id="forma_pago" name="forma_pago" class="form-control h-2">
              <?=$cboFormaPago;?> 
            </select>
        </div>
        <?php if($tipo_oper == 'V'){ ?>
          <div class="col-sm-2 col-md-2">
            <label for="cboVendedor">Vendedor</label>
            <!-- // TODO: Combobox para listar los vendedores -->
            <select id="cboVendedor" name="cboVendedor" class="form-control h-2">
              <option value="">Todos</option>
              <?=$cboVendedor;?>
            </select>
          </div>
        <?php } else{ ?>
          <div class="col-sm-2 col-md-2">
            <label for="cboAlmacen">Almacen</label>
            <select id="cboAlmacen" name="cboAlmacen" class="form-control h-2">
                <option value="">Todos</option>
              <?php foreach($cboAlmacen as $value) { ?>
                <option value="<?php echo $value->ALMAP_Codigo ?>" ><?php echo $value->ALMAC_Descripcion ?></option>
              <?php } ?>
            </select>
          </div>
        <?php } ?>

        <div class="col-sm-2 col-md-2">
            <label for="moneda">Moneda</label>
            <select id="moneda" name="moneda" class="form-control h-2">
                <?php echo $cboMoneda; ?>
            </select>
        </div>
        <div class="col-sm-2 col-md-2" style="font-size: 12pt; font-weight: bold;">
            <label for="myCheck"> </label><br>
            <input type="checkbox" id="myCheck" onclick="myFunction()" style="cursor: pointer;"> Consolidado 
        </div>
        <div class="col-sm-2 col-md-2">
           <br>
           <span id="text" style="display:none; font-size: 15pt; font-weight: bold;">Todas las sucursales</span>
        </div>
        
        
      </div>
    </div>

  </section>
    <section>
    <div class="row fuente8 py-1">
      <div class="col-sm-4 col-md-4">
           
        </div>
      <div class="col-sm-6 col-md-6">
        
           <button class="button" style="vertical-align:middle" onclick="ejecutarAjax2()"><span>Buscar </span></button>
           <button class="button" style="vertical-align:middle" onclick="limpiar()"><span>Limpiar </span></button>
        
        
      </div>
    </div>
    
  </section>
  <hr>
  <section>
    <div class="row" style="font-weight:bold;">
        <div class="col-sm-1 col-md-1"></div>
        <div class="col-sm-2 col-md-2">
            <label style="color:green"><strong>TOTAL FACTURAS: </strong></label><span id="cont_facturas" name="cont_facturas"> ()</span><br>
            S./ <span id="total_fac" name="total_fac"></span> <br>
            $  <span id="total_fac_dolar" name="total_fac_dolar" style="border:0; background-color: #e0e2e8;" ></span>
        </div>
        <div class="col-sm-2 col-md-2">
            <label style="color:green"><strong>TOTAL BOLETAS: </strong></label><span id="cont_boletas" name="cont_boletas"> ()</span><br>
            S./ <span id="total_bol" name="total_bol"></span> <br>
            $  <span id="total_bol_dolar" name="total_bol_dolar" style="border:0; background-color: #e0e2e8;" ></span>
        </div>
        <div class="col-sm-2 col-md-2">
            <label style="color:blue"><strong>TOTAL NOTAS DE VENTA: </strong></label><span id="cont_notas" name="cont_notas"> ()</span><br>
            S./ <span id="total_comp" name="total_comp"></span> <br>
            $  <span id="total_comp_dolar" name="total_comp_dolar" style="border:0; background-color: #e0e2e8;" ></span>
        </div>
        <div class="col-sm-2 col-md-2">
            <label style="color:blue"><strong>TOTAL NOTAS DE CREDITO: </strong></label><span id="cont_comprob" name="cont_comprob"> ()</span><br>
            S./ <span id="total_nota" name="total_nota"></span> <br>
            $  <span id="total_nota_dolar" name="total_nota_dolar" style="border:0; background-color: #e0e2e8;" ></span>
        </div>
        
      </div><br>
      <div class="row" style="font-weight:bold;">
        <div class="col-sm-1 col-md-1"></div>
        
        <div class="col-sm-2 col-md-2">
            <div class="small-box bg-warning">
                  <div class="inner">
                      <h3 id="cantidad_fac" name="cantidad_fac">0</h3>
                      <p>Cantidad Documentos</p>
                  </div>
                  <div class="icon">
                      <i class="ion ion-bag"></i>
                  </div>
              </div>
        </div>
        <div class="col-sm-2 col-md-2">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3 id="total" name="total">S/ 0.00</h3>
                    <p>Total Soles</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-md-2">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3 id="total_dolar" name="total_dolar">$ 0.00</h3>
                    <p>Total Dólares</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
            </div>
        </div>
        <div class="col-sm-2 col-md-2">
          <label>Descargar reporte</label><br>
            <button class="button" id="imprimirexcel_contador" style="vertical-align:middle" ><span>EXCEL</span></button>
           
        </div>
        
      </div>
    </div>
  </section> 
  <div class="row">
    <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
                <div class="header text-align-center">RESULTADOS</div>
            </div>
        </div><br>
        <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 pall-0">
              <table class="fuente8 display" id="table-producto">
                <thead>
                  <tr>
                    <td style="width:08%;">F. EMISION</td>
                    <td style="width:08%;">F. VENCIMIENTO</td>
                    <td style="width:05%;">TIPO</td>
                    <td style="width:10%;">NUMERO</td>
                    <td style="width:10%;">DOCUMENTO</td>
                    <td style="width:25%;">RAZON SOCIAL</td>
                    <td style="width:10%;">MONEDA</td>
                    <td style="width:10%;">TOTAL</td>
                    <td style="width:10%;">FORMA PAGO</td>
                    <td style="width:10%;">ESTADO</td>
                  </tr>
                </thead>
                <tbody class="viewData">
                </tbody>
              </table>
            </div>
        </div>
    </div>
  </div>
<!--FIN container-fluid-->
</div>

<script type="text/javascript">
  $(document).ready(function() {
    ejecutarAjax2();
    // TODO: Evento click para generar el excel
    $("#imprimirexcel_contador").click(function() {
        Swal.fire({
          position: 'bottom-start',
          icon: 'success',
          title: 'El reporte se está generando y se descargará al finalizar',
          showConfirmButton: false,
          timer: 10000
        })
        
        tipo_docu   = $("#tipo_doc").val();

        tipo_oper   = $("#tipo_oper").val();
        fecha1      = $("#fecha1").val();
        fecha2      = $("#fecha2").val();
        forma_pago  = $("#forma_pago").val();
        vendedorOrStore = (tipo_oper == "V")?($("#cboVendedor").val()):($("#cboAlmacen").val());
        moneda      = $("#moneda").val();
        consolidado = $("#consolidado").val();

        if(fecha1==""){
          fecha1=1;
        }
        if(fecha2==""){
          fecha2=1;
        }
        if(tipo_docu==""){
          tipo_docu="-";
        }
        if(forma_pago==""){
          forma_pago="-";
        }
        if(vendedorOrStore==""){
          vendedorOrStore="-";
        }
        
        if(moneda==""){
          moneda="-";
        }

        var checkBox = document.getElementById("myCheck");

        if (checkBox.checked == true){
          consolidado = 1;
        } else {
          consolidado = 0;
        }

        location.href = "<?php echo base_url() ?>index.php/reportes/ventas/resumen_ventas_mensual/" + tipo_oper + "/" + tipo_docu + "/" + fecha1 + "/" + fecha2 + "/" + forma_pago + "/" + vendedorOrStore + "/" + moneda+"/"+consolidado; 
    });
    
  });


function ejecutarAjax2(){
    clean_values();
    tipo_docu   = $("#tipo_doc").val();
    tipo_oper   = $("#tipo_oper").val();
    fecha1      = $("#fecha1").val();
    fecha2      = $("#fecha2").val();
    forma_pago  = $("#forma_pago").val();
    vendedorOrStore = (tipo_oper == "V")?($("#cboVendedor").val()):($("#cboAlmacen").val());
    moneda      = $("#moneda").val();

    var checkBox = document.getElementById("myCheck");


    // If the checkbox is checked, display the output text
    if (checkBox.checked == true){
      consolidado = 1;
    } else {
      consolidado = 0;
    }

    base_url=$("#base_url").val();
    $("#table-producto").DataTable().destroy();
    $(".viewData").html('');

    $.ajax({
      url : "<?=base_url();?>index.php/reportes/ventas/registro_ventas_table/",
      type: "POST",
      data: {
          "term": "",
          "tipo_oper": tipo_oper,
          "tipo_doc": tipo_docu,
          "fecha1": fecha1,
          "fecha2": fecha2,
          "forma_pago": forma_pago,
          "vendedorOrStore": vendedorOrStore,
          "moneda": moneda,
          "consolidado": consolidado
      },
      dataType: "json",
      success: function (data) {
        if (data.data != null && data.data != undefined){ 
          totales = data.totales;      

          document.getElementById("total_fac").innerHTML  = totales.total_fac;
          document.getElementById("total_bol").innerHTML  = totales.total_bol;
          document.getElementById("total_comp").innerHTML = totales.total_comp;
          document.getElementById("total_nota").innerHTML = totales.total_nota;
          document.getElementById("total_fac_dolar").innerHTML  = totales.total_fac_dolar;
          document.getElementById("total_bol_dolar").innerHTML  = totales.total_bol_dolar;
          document.getElementById("total_comp_dolar").innerHTML = totales.total_comp_dolar;
          document.getElementById("total_nota_dolar").innerHTML = totales.total_nota_dolar;
          
          document.getElementById("total").innerHTML            = "S/ "+totales.total;
          document.getElementById("total_dolar").innerHTML      = "$ "+totales.total_dolar;
          document.getElementById("cantidad_fac").innerHTML     = totales.cantidad;
          document.getElementById("cont_facturas").innerHTML    = " ("+totales.cont_facturas+")";
          document.getElementById("cont_boletas").innerHTML     = " ("+totales.cont_boletas+")";
          document.getElementById("cont_notas").innerHTML       = " ("+totales.cont_notas+")";
          document.getElementById("cont_comprob").innerHTML     = " ("+totales.cont_comprob+")";
          
          $.each(data.data, function(i, item) {
              table = '';
              table += '<tr>'+item.tachado1;
              
              table += '<td>'+item.tachado1 + item.fecha          +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.fecha          +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.tipo_documento +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.serie          +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.num_doc        +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.razon_social   +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.moneda       +item.tachado2+ '</td>';
              //table += '<td>'+item.tachado1 + item.subtotal       +item.tachado2+ '</td>';
              //table += '<td>'+item.tachado1 + item.igv            +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.total          +item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.FORPAC_Descripcion + item.tachado2+ '</td>';
              table += '<td>'+item.tachado1 + item.estado         +item.tachado2+ '</td>';
              
              table += '</tr>';

              $(".viewData").append(table);
          });

          $('#table-producto').DataTable({
            language: {

              lengthMenu: "_MENU_",
              search: "_INPUT_",
              searchPlaceholder: "Búsqueda Rápida",
              emptyTable: "No hay información",
              info: "Mostrando desde _START_ hasta _END_ de _TOTAL_ entradas",
              infoEmpty: "Sin resultados",
              infoFiltered: "(Filtrado de _MAX_ entradas)",
              infoPostFix: "",
              thousands: ",",
              lengthMenu: "Mostrar _MENU_ Entradas",
              loadingRecords: "Cargando...",
              processing: "Procesando...",
              zeroRecords: "Sin resultados encontrados.",
              paginate: {
                "first": "Primero",
                "last": "Ultimo",
                "next": "Siguiente",
                "previous": "Anterior"
              },

            }
           
          });
          $(".table-producto").show();
        }
      }
    });
}

function myFunction() {
  var checkBox = document.getElementById("myCheck");
  var text = document.getElementById("text");
  
  if (checkBox.checked == true){
    text.style.display = "block";
  } else {
    text.style.display = "none";
  }
}

function limpiar(){
  $("#tipo_doc").val("");
  $("#fecha1").val("");
  $("#fecha2").val("");
  $("#forma_pago").val("");
  $("#cboVendedor").val("");
  $("#moneda").val("");
  document.getElementById("total_fac").innerHTML        = "0";
  document.getElementById("total_bol").innerHTML        = "0";
  document.getElementById("total_comp").innerHTML       = "0";
  document.getElementById("total_nota").innerHTML       = "0";
  document.getElementById("total_fac_dolar").innerHTML  = "0";
  document.getElementById("total_bol_dolar").innerHTML  = "0";
  document.getElementById("total_comp_dolar").innerHTML = "0";
  document.getElementById("total_nota_dolar").innerHTML = "0";
  document.getElementById("total").innerHTML            = "S/ 0.00";
  document.getElementById("total_dolar").innerHTML      = "$ 0.00";
  document.getElementById("cantidad_fac").innerHTML     = "0";
  ejecutarAjax2();
}

function clean_values(){
  document.getElementById("cont_facturas").innerHTML    = " ()";
  document.getElementById("cont_boletas").innerHTML     = " ()";
  document.getElementById("cont_notas").innerHTML       = " ()";
  document.getElementById("cont_comprob").innerHTML     = " ()";
  document.getElementById("total_fac").innerHTML        = "0";
  document.getElementById("total_bol").innerHTML        = "0";
  document.getElementById("total_comp").innerHTML       = "0";
  document.getElementById("total_nota").innerHTML       = "0";
  document.getElementById("total_fac_dolar").innerHTML  = "0";
  document.getElementById("total_bol_dolar").innerHTML  = "0";
  document.getElementById("total_comp_dolar").innerHTML = "0";
  document.getElementById("total_nota_dolar").innerHTML = "0";
  document.getElementById("total").innerHTML            = "S/ 0.00";
  document.getElementById("total_dolar").innerHTML      = "$ 0.00";
  document.getElementById("cantidad_fac").innerHTML     = "0";
}


</script>