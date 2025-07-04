<script type="text/javascript" src="<?php echo base_url();?>js/almacen/almacenproducto.js?=<?=JS;?>"></script>
<div id="zonaContenido">
    <div align="center">
        <div id="tituloForm" class="header"><?php echo $titulo_tabla;;?></div>
        <div id="cuerpoPagina">
            <div id="frmBusqueda" >
            <input type="hidden" name="almacen_id" id="almacen_id" value="<?=$_SESSION['compania'];?>">
            <fieldset>
                <section>
                    
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="float: left;">
                        <div class="form-group">
                            <label for="exampleInputNombre">TOTAL ARTICULOS</label><br>
                            <input type="text" class="comboGrande valorizacion" id="cantidad" name="cantidad"  disabled color="black" value="<?php echo $cantidad;?>">
                        </div>
                    </div> 
                    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3" style="float: left;">
                        <div class="form-group">
                            <label for="exampleInputNombre">TOTAL VALORIZADO</label><br>
                            <input type="text" class="comboGrande valorizacion" id="valorizacion" name="valorizacion"  disabled value="<?php echo $valorizacion;?>">
                        </div>
                    </div> 
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style="float: left;">
                        <div class="form-group">
                            <label for="almacen">ALMACÉN</label><br>
                            <select class="form-control w-porc-90 h-2" name="almacen" id="almacen">
                                <option value=""> TODOS </option>
                                <?php
                                foreach ($almacenes as $key => $value) { ?>
                                    <option value='<?=$value->ALMAP_Codigo;?>'> <?=$value->ALMAC_Descripcion;?> </option> <?php
                                } ?>
                            </select>
                        </div>
                    </div> 

                </section>

            </fieldset>

            <section>
                <div class="row fuente8 py-1">
                    <div class="col-sm-1 col-md-1 col-lg-1 form-group">
                        <label for="txtCodigo">Código: </label>
                        <input id="txtCodigo" name="txtCodigo" type="text" class="form-control w-porc-90 h-1" placeholder="Codigo" maxlength="30" value="<?=$codigo;?>">
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                        <label for="txtNombre">Nombre: </label>
                        <input id="txtNombre" name="txtNombre" type="text" class="form-control w-porc-90 h-1" maxlength="100" placeholder="Nombre producto" value="<?php echo $nombre; ?>">
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group">
                        <label for="txtFamilia">Familia: </label>
                        <select name="txtFamilia" id="txtFamilia" class="form-control w-porc-90 h-2">
                            <option value=""> TODOS </option><?php
                            if ($familias != NULL){
                                foreach ($familias as $i => $v){ ?>
                                    <option value="<?=$v->FAMI_Codigo;?>"><?=$v->FAMI_Descripcion;?></option> <?php
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                        <label for="txtMarca">Marca: </label>
                        <select class="form-control w-porc-90 h-2" name="txtMarca" id="txtMarca">
                            <option value=""> TODOS </option> <?php
                                foreach ($listaMarcas as $key => $value) { ?>
                                    <option value='<?=$value->MARCP_Codigo;?>'> <?=$value->MARCC_Descripcion;?> </option> <?php
                                } ?>
                        </select>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group" <?=($flagBS == 'S') ? 'hidden' : '';?>>
                        <label for="txtModelo">Modelo: </label>
                        <select name="txtModelo" id="txtModelo" class="form-control w-porc-90 h-2">
                            <option value=""> TODOS </option><?php
                            if ($modelos != NULL){
                                foreach ($modelos as $indice => $val){
                                    if ($val->PROD_Modelo != ''){ ?>
                                        <option value="<?=$val->PROD_Modelo;?>"><?=$val->PROD_Modelo;?></option> <?php
                                    }
                                }
                            } ?>
                        </select>
                    </div>
                    

                    <input id="codigoInterno" name="codigoInterno" type="hidden" class="cajaGrande" maxlength="100" placeholder="Codigo original" value="<?=$codigoInterno;?>">
                </div>
                <div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4 form-group"> 
                       
                    </div>
                    <div class="col-sm-1 col-md-1 col-lg-1"><br>
                        <button type="button" class="btn btn-success" id="buscar" name="buscar">BUSCAR</button>
                    </div>
                    <div class="col-sm-1 col-md-1 col-lg-1"><br>
                        <button type="button" class="btn btn-info" id="limpiar" name="limpiar">LIMPIAR</button>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
                        <a href="javascript:;" onclick="descargarExcel()" style="color:black;">
                            <img src="<?php echo base_url();?>images/xls.png?=<?=IMG;?>" width="32px" class="imgBoton" onMouseOver="style.cursor=cursor">
                            <br>General
                        </a>
                    </div>
                    <div class="col-sm-2 col-md-2 col-lg-2 form-group"> 
                        <a href="javascript:;" onclick="descargarExcel_Det()" style="color:black;">
                                    <img src="<?php echo base_url();?>images/xls.png?=<?=IMG;?>" width="32px" class="imgBoton" onMouseOver="style.cursor=cursor">
                                    <br>Detallado
                                </a>
                    </div>
                </div>
            </section>

            </div>
         
            <div id="frmResultado">
                <div id="cargando_datos" class="loading-table">
                    <img src="<?=base_url().'images/loading.gif?='.IMG;?>">
                </div>
                <?php echo $form_open2;?>
                <input type="hidden" name="compania" id="compania"/>
                <input type="hidden" name="almacen" id="almacen" />
                <input type="hidden" name="producto" id="producto" />
                <input type="hidden" name="codproducto" id="codproducto" />
                <input type="hidden" name="nombre_producto" id="nombre_producto" />
                <a href="javascript:;" id="linkSerie"></a>
                <table class="display fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" id="table-stock">
                    <thead>
                        <tr class="cabeceraTabla">
                            <th width="10%" data-orderable="true">CODIGO</th>
                            <th width="30%" data-orderable="true">DESCRIPCION</th>
                            <th width="10%" data-orderable="true">FAMILIA</th>
                            <th width="10%" data-orderable="true">MARCA</th>
                            <th width="10%" data-orderable="false">STOCK</th>
                            <th width="10%" data-orderable="false">UND</th>
                            <th width="15%" data-orderable="false">ALMACEN</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <?php echo $form_close2;?>
            </div>
             <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
          
            <input type="hidden" id="iniciopagina" name="iniciopagina">
            <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
            <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
        </div>
    </div>
</div>          


<script type="text/javascript">
    $(document).ready(function(){
        $('#nombre_prod').keyup(function(e){
            var key=e.keyCode || e.which;
            if (key==13){
               
                $("#buscar").click();
            } 
        });
        $('#table-stock').DataTable({ responsive: true,
            filter: false,
            destroy: true,
            processing: true,
            serverSide: true,
            ajax:{
                    url : "<?=base_url();?>index.php/almacen/almacenproducto/datatable_almacen_producto",
                    type: "POST",
                    data: { dataString: "" },
                    beforeSend: function(){
                    },
                    error: function(){
                    }
            },
            language: spanish
        });

       

        $("#buscar").click(function(){
            codigo      = $('#txtCodigo').val();
            producto    = $('#txtNombre').val();
            familia     = $('#txtFamilia').val();
            marca       = $('#txtMarca').val();
            modelo      = $('#txtModelo').val();
            almacen     = $('#almacen').val();

            $('#table-stock').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/almacenproducto/datatable_almacen_producto",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo ,almacen:almacen},
                        error: function(){
                        }
                },
                language: spanish
            });
        });

        
        $("#limpiar").click(function(){

            $("#txtCodigo").val("");
            $("#txtNombre").val("");
            $("#txtFamilia").val("");
            $("#txtMarca").val("");
            $("#txtModelo").val("");
            $('#almacen').val();
            codigo      = "";
            producto    = "";
            familia     = "";
            marca       = "";
            modelo      = "";
            almacen     = "";

            $('#table-stock').DataTable({ responsive: true,
                filter: false,
                destroy: true,
                processing: true,
                serverSide: true,
                ajax:{
                        url : "<?=base_url();?>index.php/almacen/almacenproducto/datatable_almacen_producto",
                        type: "POST",
                        data: { txtCodigo: codigo, txtNombre: producto, txtFamilia: familia, txtMarca: marca, txtModelo: modelo, almacen:almacen },
                        error: function(){
                        }
                },
                language: spanish
            });
        });
    });
</script>