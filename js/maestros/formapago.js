var base_url;
jQuery(document).ready(function(){
    base_url   = $("#base_url").val();
    $("#nuevaFormapago").click(function(){
        url = base_url+"index.php/maestros/formapago/nuevo";
        location.href = url;
    });
    $("#grabarFormapago").click(function(){
        $("#frmFormapago").submit();
    });
    $("#limpiarFormapago").click(function(){
        url = base_url+"index.php/maestros/formapago/listar";
        $("#nombre_formapago").val('');
        location.href=url;
    });
    $("#cancelarFormapago").click(function(){
        url = base_url+"index.php/maestros/formapago/listar";
        location.href = url;
    });
    $("#buscarFormapago").click(function(){
        $("#form_busquedaFormapago").submit();
    });
});
function editar_formapago(formapago){
	location.href = base_url+"index.php/maestros/formapago/editar/"+formapago;
}
function eliminar_formapago(formapago){
    if(confirm('¿Está seguro que desea eliminar esta forma de pago?')){
        dataString        = "formapago="+formapago;
        url = base_url+"index.php/maestros/formapago/eliminar";
        $.post(url,dataString,function(data){
            location.href = base_url+"index.php/maestros/formapago/listar";
        });
    }
}
function ver_formapago(formapago){
    location.href = base_url+"index.php/maestros/formapago/ver/"+formapago;
}
function atras_formapago(){
    location.href = base_url+"index.php/maestros/formapago/listar";
}