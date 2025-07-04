jQuery(document).ready(function(){
/////////////////////
//
//  RECETAS
//
/////////////////////
    $("#nuevaReceta").click(function(){
        location.href = base_url+"index.php/almacen/produccion/receta_nueva";
    });
    $("#imgGuardarReceta").click(function(){
        $("#salir").val(1);
        $("#frmReceta").submit();
    });
    $("#cancelarReceta").click(function(){
        $("#salir").val(1);
        url = base_url+"index.php/almacen/produccion/receta_index/";
        location.href = url;
    });
    $("#limpiarReceta").click(function(){
        $("#salir").val(1);
        $("#frmReceta").each(function(){
            this.reset();
        });
    });
///////////////////////////
/////////////////////
//
//  PRODUCCION
//
/////////////////////
    $("#nuevaProduccion").click(function(){
        location.href = base_url+"index.php/almacen/produccion/produccion_nueva";
    });
    $("#imgGuardarReceta").click(function(){
        $("#salir").val(1);
        $("#frmReceta").submit();
    });
///////////////////////////


});


/////////////////////
//
//  RECETAS
//
/////////////////////

function plusCost() {
    var materia_prima       = parseFloat($("#materia_prima").val());
    var mano_obra           = parseFloat($("#mano_obra").val());
    var gastos_prod         = parseFloat($("#gastos_prod").val());
    var costos_adicionales  = parseFloat($("#costos_adicionales").val());
    var totalReceta=0;

    if (isNaN(materia_prima)) {materia_prima=0;}
    if (isNaN(mano_obra)) {mano_obra=0;}
    if (isNaN(gastos_prod)) {gastos_prod=0;}
    if (isNaN(costos_adicionales)) {costos_adicionales=0;}

    totalReceta=materia_prima+mano_obra+gastos_prod+costos_adicionales;
    
    $("#totalReceta").val(totalReceta)
}

function editar_receta(receta){
    var base_url = $("#base_url").val();
    url           = base_url+"index.php/almacen/produccion/editar_receta/"+receta;
    location.href = url;
}

function eliminar_producto(producto){
    
    var url = base_url + "index.php/almacen/produccion/eliminar_receta";

    $.ajax({
        type: "POST",
        url: url,
        data: { producto: producto },
        dataType: 'json',
        beforeSend: function (data) {
            
        },
        error: function (data) {
            
        },
        success: function (data) {
            $("#limpiar").click();
            Swal.fire({
                icon: "info",
                title: "Receta desactivada",
                html: "<b class='color-red'>Se ha desactivado la receta</b>",
                showConfirmButton: true
            });
        }
    });
}

function habilitar_producto(producto){
    
    var url = base_url + "index.php/almacen/producto/habilitar_producto";

    $.ajax({
        type: "POST",
        url: url,
        data: { producto: producto },
        dataType: 'json',
        beforeSend: function (data) {
            
        },
        error: function (data) {
            alert("Ups! Algo extraño ha pasado, por favor comuniquese con soporte tecnico");
        },
        success: function (data) {
            $("#limpiar").click();
            Swal.fire({
                icon: "info",
                title: "Producto habilitado",
                html: "<b class='color-red'>Se ha habilitado el articulo para la compra/venta</b>",
                showConfirmButton: true
            });
        }
    });
}

function addProductoBarcode(argument) {
        $.ajax({
            url: base_url+"index.php/almacen/produccion/searchProducto/",
            type: "POST",
            data: {
                codigo: $("#getProductoCodigo").val(),
                almacen: "",
                default: "codigo",
            },
            dataType: "json",
            success: function(data) {
                
                $("#idProducto").val(data[0].id);
                $("#descripcionProducto").val(data[0].nombre);
                $("#codigo_producto").val(data[0].codigo);
                $("#descripcion_receta").val(data[0].nombre);
                $("#cantidadProducto").focus();
            }
        });
    }

///////////////////////////

/////////////////////
//
// TRANSFORMACIONES
//
/////////////////////