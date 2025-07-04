<!DOCTYPE html>
<html>
  <head>
      <title><?=TITULO;?></title>
      <meta charset="utf-8"/>
      <script type="text/javascript">
		    var base_url = '<?=$base_url;?>';
		    var tipo_oper = '<?=$tipo_oper;?>';
        var monto_bolsa = 0.4;
			</script>

      <script type="text/javascript" src="<?=$base_url;?>js/jquery.js?=<?=JS;?>"></script>
      
          <!-- BOOTSTRAP HERE -->
          <!-- BOOTSTRAP -->
      <link rel="shortcut icon" href="<?=$base_url;?>images/favicon.png">
      <link href="<?=$base_url;?>css/calendarioDespacho.css?=<?=CSS;?>" rel="stylesheet">
      <link rel="stylesheet" type="text/css" href="<?=$base_url;?>js/datatables/datatables.css">
      
      <link rel="stylesheet" href="<?=$base_url;?>css/calendario/calendar-win2k-2.css?=<?=CSS;?>" type="text/css" media="all" title="win2k-cold-1" />
      
      <link rel="stylesheet" href="<?=$base_url;?>css/nav.css?=<?=CSS;?>" type="text/css"/>
      <link rel="stylesheet" href="<?=$base_url;?>css/ui-lightness/jquery-ui-1.8.18.custom.css?=<?=CSS;?>" type="text/css"/>

      <link rel="stylesheet" href="<?=$base_url;?>css/estilos.css?=<?=CSS;?>" type="text/css"/>
      <link href="<?=$base_url;?>css/others.css?=<?=CSS;?>" rel="stylesheet">
      
      <script type="text/javascript" charset="utf8" src="<?=$base_url;?>js/datatables/datatables.js"></script>
      
      <script type="text/javascript" src="<?=$base_url;?>js/sweetalert2/sweetalert2.js?=<?=JS;?>"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
      <script type="text/javascript" src="<?=$base_url;?>js/funciones.js?=<?=JS;?>"></script>
      <script type="text/javascript" src="<?=$base_url;?>js/jquery-ui.custom.min.js?=<?=JS;?>"></script>
      
      <script type="text/javascript" src="<?=$base_url;?>js/jarch.io.js?=<?=JS;?>"></script>
      
      <!--<script src="<?=$base_url;?>bootstrap/js/bootstrap.min.js?=<?=JS;?>"></script>-->
      <script src="<?=$base_url;?>bootstrap/js/bootstrap.js?=<?=JS;?>"></script>
      
      <script type="text/javascript" src="<?=$base_url;?>js/sunat.js?=<?=JS;?>"></script>
      <!-- BOOTSTRAP HERE -->
          <link href="<?=$base_url;?>bootstrap/css/bootstrap.css?=<?=CSS;?>" rel="stylesheet">
          <link href="<?=$base_url;?>bootstrap/css/bootstrap-theme.css?=<?=CSS;?>" rel="stylesheet">
      <!-- BOOTSTRAP -->

      <!-- Calendario -->
      <script type="text/javascript" src="<?=$base_url;?>js/calendario/responsive-calendar.js?=<?=JS;?>"></script>
      <script type="text/javascript" src="<?=$base_url;?>js/calendario/calendar.js?=<?=JS;?>"></script>
      <script type="text/javascript" src="<?=$base_url;?>js/calendario/calendar-es.js?=<?=JS;?>"></script>
      <script type="text/javascript" src="<?=$base_url;?>js/calendario/calendar-setup.js?=<?=JS;?>"></script>  

      <!-- Calendario -->
      <script language="javascript">
        var cursor;
        if (document.all) {
            // Est utilizando EXPLORER
            cursor='hand';
        } else {
            // Est utilizando MOZILLA/NETSCAPE
            cursor='pointer';
        }
      </script>
      <script language="javascript">
        $(document).ready(function(){  
          obtener_demora();
          $("ul.subnav").parent().append("<span></span>"); //Only shows drop down trigger when js is enabled (Adds empty span tag after ul.subnav*)  
          $("ul.topnav li span").click(function() { //When trigger is clicked...  
            //Following events are applied to the subnav itself (moving subnav up and down)  
            $(this).parent().find("ul.subnav").slideDown('fast').show(); //Drop down the subnav on click 
            $(this).parent().hover(function() {  
            }, function(){  
                $(this).parent().find("ul.subnav").slideUp('slow'); //When the mouse hovers out of the subnav, move it back up  
            }); //Following events are applied to the trigger (Hover events for the trigger)
          }).hover(function() {
            $(this).addClass("subhover"); //On hover over, add class "subhover"
          }, function(){  //On Hover Out
            $(this).removeClass("subhover"); //On hover out, remove class "subhover"
          });
        });
      </script>
  </head>
  <body>
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-5 col-md-5 col-lg-5 pall-0">
          <div id="idDivLogo" class="divWF30">
            <img src="<?=$base_url;?>images/logo.png?=<?=IMG;?>" alt="logo" style="height: 100%; margin-left: 1em; margin-top: 0.3em;" />
          </div>
        </div>
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0" style="cursor:pointer;" id="pos_open">
          <label>Punto de Venta</label><br>
          <img width="90px" src="<?php echo base_url(); ?>/assets/img/pos.png">
        </div>  
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0" style="cursor:pointer;" id="precios">
            <label>PRECIOS</label><br>
            <img width="60px" src="<?php echo base_url(); ?>images/soles.png" style="padding-top: 3px;">
        </div>  
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0" style="cursor:pointer;" id="mis_ventas">
            <label>VENTAS DEL DÍA</label><br>
            <img width="44px" src="<?php echo base_url(); ?>images/pdf_salida.png" style="padding-top: 0px;">
        </div>              
        <div class="col-sm-4 col-md-4 col-lg-4 pall-0">
          <div class="backgroundMenu select-empresa">
            <select name="cboCompania" id="cboCompania" onchange="cambiar_sesion();"> <?php $j = 0;
              foreach ($lista_compania as $valor) {
                if ($valor['tipo'] == 1){
                  if ($j != 0) ?>
                      </optgroup>

                  <optgroup label="<?=$valor['nombre'];?>"> <?php
                }
                else{ ?>
                    <option value="<?=$valor['compania'];?>" <?=($valor['compania'] == $_SESSION['compania']) ? 'selected' : '';?>> <?=$valor['nombre'];?> </option> <?php
                }
                $j++;
              } ?>
            </select>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-12 col-md-12 col-lg-12 pall-0 backgroundMenu">
          <?php include "menu.php"; ?>
        </div>
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-2 col-md-2 col-lg-2 pall-0">
            <?php include "menuIzquierdo.php"; ?>  
        </div>
        <div class="col-sm-10 col-md-10 col-lg-10 pall-0">
          <div class="container-fluid">
            <div class="row header">
              <div class="col-sm-2 col-md-2 col-lg-2 pall-0">
                <span> <b>ROL:</b> <?=$desc_rol;?> </span>
              </div>
              <div class="col-sm-3 col-md-3 col-lg-3 pall-0">
                <span> <b>USUARIO: <?=$nom_user;?></b> </span>
              </div>
              <div class="col-sm-6 col-md-6 col-lg-6 pall-0">
                <span class="pull-right"> <b>EMPRESA:</b> <?=$nombre_empresa;?> </span>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12 col-md-12 col-lg-12 pall-0"><?=$content_for_layout;?></div>
            </div>
          </div>
        </div>
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0">
          <?php include "menuDerecho.php"; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0"></div>
        <footer class="col-sm-10 col-md-10 col-lg-10 pall-0" style="text-align: center">
          <p> <a href="http://www.osa-erp.com"> www.osa-erp.com </a> </p>
          <p> Resolución optima 1152 x 864 pixeles </p>
          <p> <a href="http://www.ccapasistemas.com">www.ccapasistemas.com</a> </p>
        </footer>
        <div class="col-sm-1 col-md-1 col-lg-1 pall-0"></div>
      </div>
    </div>

<!--MODAL PRECIOS-->
    <div class="modal fade bd-modalPreciosView-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content" style="width: 75%; margin: auto; font-family: Trebuchet MS, sans-serif; font-size: 17px;">
            <div class="titulo" style="text-align: center;">
              <h3>BUSCADOR DE PRECIOS</h3>
            </div>
            <div class="contenido" style="width: 95%; margin:auto;height: auto;padding-bottom: 15px;">
              <div class="tempde_head">
                <form id="fmrBuscarPrecioxSerie" method="post" onsubmit="return false;" style="margin-bottom: 12px;" autocomplete="off">
                  <div class="row">
                    <div class="col-sm-2 col-md-2 col-lg-2">
                      <label for="txtSeriePrecio">Código:</label>
                      <input type="text" class="form-control h-1 uppercase" name="txtSeriePrecio" id="txtSeriePrecio" onkeyup="replaceComilla(this.value, this)">
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3">
                      <label for="txtSearchPrecio">Nombre del producto:</label>
                      <input type="text" class="form-control h-1 uppercase" name="txtSearchPrecio" id="txtSearchPrecio">
                    </div>
                    <div class="col-sm-3 col-md-3 col-lg-3" hidden>
                      <label for="almacen_precio">Almacen:</label>
                      <select id="almacen_precio" name="almacen_precio" class="form-control h-2">
                        <?php foreach ($cboAlmacenLa as $key => $value) {?>
                          <option value="<?=$value->ALMAP_Codigo?>"><?=$value->ALMAC_Descripcion;?></option>
                       <?php } ?>
                        
                      </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2"><br>
                      <button type="submit" id="buscarxPrecio" class="btn btn-success" accesskey="x" onclick="searchPrecios()">Buscar</button>
                      <button type="button" class="btn btn-primary" accesskey="x" onclick="limpiarPrecios()">Limpiar</button>
                    </div>
                  </div>
                </form>
                <div class="row">
                  <div class="col-12">
                    <table id="tbPreciosProducto" class="table table-hover table-sm fuente8" style="font-size: 12px;">
                      <thead>
                        <tr>
                          <th style="width:10% !important;">CODIGO</th>
                          <th style="width:35% !important;">PRODUCTO</th>
                          <th style="width:10% !important;">UNIDAD MEDIDA</th>
                          <th style="width:5% !important;">STOCK</th>
                          <?php foreach($precio_categorias as $catePrecio){ ?>
                            <th style="width:10% !important;" class="text-center"><?php echo $catePrecio->TIPCLIC_Descripcion ?></th>
                          <?php } ?>
                          <!--<th style="width:10% !important;" class="text-center">P. MÍNIMO</th>-->
                        </tr> 
                      </thead>
                      <tbody></tbody>
                    </table>
                  </div>
                  <div class="col-sm-12 col-md-12 col-lg-12 text-center" style="padding-top: 10px;">
                    <button type="button" class="btn btn-danger" onclick="cerrarPreciosMod()" aria-label="Close">Cerrar</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
<!--FIN MODAL PRECIOS-->




  </body>
</html>
<script type="text/javascript">
	$("#pos_open").click(function()
		{
			//toastr.info("Cargando POS...")
			window.location="<?php echo base_url(); ?>index.php/index/pos";
		});

/*VENTANA PRECIOS*/
  $("#precios").click(function(){
    $('.bd-modalPreciosView-sm').modal('show');
    limpiarPrecios();
  });

  $('#txtSeriePrecio').on('keypress',function(e){
    if(e.which == 13) {
      searchPrecios();
    }
  });
  
  function searchPrecios()
  {
    let txtSeriePrecio  = $('#txtSeriePrecio').val();
    let txtNombrePrecio = $('#txtNombrePrecio').val();
    let table           = $('#tbPreciosProducto');

    table.DataTable({
      filter: false,
      destroy: true,
      processing: true,
      serverSide: true,
      autoWidth: false,
      pageLength: 25,
      ajax:{
        url: base_url+"index.php/almacen/producto/buscar_precio_lectora_nombre/",
        type: "POST",
        data: {
          tipo_oper: 'V',
          codigo_interno: $('#txtSeriePrecio').val(),
          compania: $('#cboCompania').val(),
          almacen: $('#almacenLayout').val(),
          search: $('#txtSearchPrecio').val()
        },
        beforeSend: function(){
          $(".loading-table").show();
          $('#cargando_datos').show();
        },
        error: function(){},
        complete: function(){
          $(".loading-table").hide();
          $('#cargando_datos').hide();
        }
      },
      language: spanish,
      order: [[ 0, "desc" ]]
    });
  }

  function cerrarPreciosMod()
  {
    $('.bd-modalPreciosView-sm').modal('hide');
  }

  function limpiarPrecios()
  {
    $('#txtSeriePrecio').val('');
    $('#txtSearchPrecio').val('');
    searchPrecios();
  }
/*FIN PRECIOS*/

/*VENTAS DEL DIA*/
  $("#mis_ventas").click(function(){
    var tipo_oper = "V";
    var tipo_docu = 'T';
    var consolidado = 0; 

    let date = new Date()
    let day = `${(date.getDate())}`.padStart(2,'0');
    let month = `${(date.getMonth()+1)}`.padStart(2,'0');
    let year = date.getFullYear();

    fecha1 = `${year}-${month}-${day}`;
    // fecha2 = $("#fecha2").val();
    forma_pago = '0';
    sucursal = $('#cboCompania').val();

    var url = "<?php echo base_url() ?>index.php/reportes/ventas/registro_ventas_pdf2/"+tipo_oper+"/"+tipo_docu+"/"+fecha1+"/"+fecha1+"/"+forma_pago+"/"+consolidado+"/"+sucursal;
    window.open(url, '', "menubars=no,resizable=no;");
  });
</script>