<script type="text/javascript"">
    var base_url   = $("#base_url").val();
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    /*$("#nuevoComercial").click(function(){
        url = base_url+"index.php/maestros/comercial/nuevo_comercial #contenedor_comercial";
        $("#zonaContenido").load(url);
       // location.href = url;
    }); *
    /*$("#grabarComercial").click(function(){
        $("#frmComercial").submit();    
    }); 
    $("#limpiarComercial").click(function(){
            url = base_url+"index.php/maestros/comercial/comerciales";
            $("#txtComercial").val('');
            location.href=url;
    });
        $("#imprimirComercial").click(function(){
        
        ///
        url = base_url+"index.php/maestros/comercial/registro_comerciales_pdf/";
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
    });
    $("#cancelarComercial").click(function(){
            url = base_url+"index.php/maestros/comercial/comerciales";
            location.href = url;
    });
    $("#buscarComercial").click(function(){
            $("#form_busquedaComercial").submit();
    }); */
});
function nuevo_comercial(){
url = base_url+"index.php/maestros/comercial/nuevo_comercial #contenedor_comercial";
        $("#zonaContenido").load(url);
}
function verPdf(){
    var data=$("#txtComercial").val();
url = base_url+"index.php/maestros/comercial/comerciales_pdf/"+data;
        window.open(url,'',"width=800,height=600,menubars=no,resizable=no;");
}
function buscar_sector_comercial(){
    var Nombre=$("#txtComercial").val();
    datas="nombre="+Nombre;
    var urls=base_url+"index.php/maestros/comercial/filtrar_data"; 
    $.ajax({url:urls,
            data:datas,
            type:"post",
            success: function(result){
        $("#cargarContenedor").html(result);
    }});
   
}

function insertar_sector_comercial(){
     base_url   = $("#base_url").val();
     var urls="";
    if ($("#codigo").val()=="") {
urls=base_url+"index.php/maestros/comercial/insertar_comercial";
    }else{
     urls=base_url+"index.php/maestros/comercial/modificar_comercial";
       
    }    
    var Nombre=$("#nombre").val();
    var codigo=$("#codigo").val();
    datas="nombre="+Nombre+"&codigo="+codigo;
   $.ajax({url:urls,data:datas,type:"post",
    success: function(result){
      location.href = base_url+"index.php/maestros/comercial/sector_comercial";  
    }});
   

}
function editar_comercial(comercial){
    url = base_url+"index.php/maestros/comercial/editar_comercial/"+comercial+" #contenedor_comercial";
    $("#zonaContenido").load(url);
   
}
function eliminar_comercial(comercial){
    if(confirm('¿Está seguro que desea eliminar este comercial?')){
        dataString        = "codigo="+comercial;
                url = base_url+"index.php/maestros/comercial/eliminar_comercial";
        $.ajax({url:url,
            data:dataString,
            type:"post",
            success: function(result){
       location.href = base_url+"index.php/maestros/comercial/sector_comercial";
            }   
        });       
    }
}
function ver_comercial(comercial){
  location.href = base_url+"index.php/maestros/comercial/ver_comercial/"+comercial;
}
function atras_comercial(){
    location.href = base_url+"index.php/maestros/comercial/comerciales";
}
function cancelar_commercial(){
    location.href = base_url+"index.php/maestros/comercial/sector_comercial"; 
}
</script>             
<div id="pagina">
    <div id="zonaContenido">
        <div align="center">
            <div id="tituloForm" class="header"><?php echo $titulo_busqueda;?></div>
            <div id="frmBusqueda">
<form id="form_busquedaComercial" name="form_busquedaComercial" method="post" action="<?php echo $action;?>">
<table class="fuente8" width="98%" cellspacing="0" cellpadding="5" border="0">
                        <tr>
                            <td align='left' width="13%">Nombre del comercial</td>
                            <td align='left'><input id="txtComercial" name="txtComercial" type="text" class="cajaGrande" maxlength="45" value="<?php echo $txtComercial;?>"></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="cargarContenedor">
             <div class="acciones">
            <div id="botonBusqueda">
                 <!--<ul onclick="verPdf()" id="imprimirComercial" class="lista_botones"><li id="imprimir">Imprimir</li></ul>-->
                <ul onclick="nuevo_comercial()" id="nuevoComercial" class="lista_botones"><li id="nuevo">Nuevo Comercial</li></ul>
                <ul id="limpiarComercial" class="lista_botones"><li id="limpiar">Limpiar</li></ul>
                <ul onclick="buscar_sector_comercial()" id="buscarComercial" class="lista_botones"><li id="buscar">Buscar</li></ul> 
            </div>
            <div id="lineaResultado">
              <table class="fuente7" width="100%" cellspacing=0 cellpadding=3 border=0>
                    <tr>
                    <td width="50%" align="left">N de comerciales encontrados:&nbsp;<?php echo $registros;?> </td>
              </table>
            </div>
</div> 
<div id="cabeceraResultado" class="header"><?php echo $titulo_tabla;;?></div>
 <div id="frmResultado">
                <table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" ID="Table1">
                    <tr class="cabeceraTabla">
                        <td width="5%">ITEM</td>
                        <td width="60%">NOMBRES DE COMERCIALES</td>
                        <td width="5%">&nbsp;</td>
                        <td width="5%">&nbsp;</td>
                        <td width="6%">&nbsp;</td>
                    </tr>
                        <?php
                        if(count($lista)>0){
                        foreach($lista as $indice=>$valor){
                                $class = $indice%2==0?'itemParTabla':'itemImparTabla';
                                ?>
                                <tr class="<?php echo $class;?>">
                                        <td><div align="center"><?php echo $valor[0];?></div></td>
                                        <td><div align="left"><?php echo $valor[1];?></div></td>
                                        <td><div align="center"><?php echo $valor[2];?></div></td>
                                        <td><div align="center"><?php echo $valor[3];?></div></td>
                                        <td><div align="center"><?php echo $valor[4];?></div></td>
                                </tr>
                                <?php
                                }
                        }
                        else{
                        ?>
                        <table width="100%" cellspacing="0" cellpadding="3" border="0" class="fuente8">
                                <tbody>
                                        <tr>
                                                <td width="100%" class="mensaje">No hay ning&uacute;n registro que cumpla con los criterios de b&uacute;squeda</td>
                                        </tr>
                                </tbody>
                        </table>
                        <?php
                        }
                        ?>
                            

                </table>
                <input type="hidden" id="iniciopagina" name="iniciopagina">
                <input type="hidden" id="cadena_busqueda" name="cadena_busqueda">
                <input type="hidden" name="base_url" id="base_url" value="<?php echo base_url();?>">
            </div>
            <div style="margin-top: 15px;"><?php echo $paginacion;?></div>
</div>

            
           
        </div>
    </div>
</div>