jQuery(document).ready(function () {
    var	   base_url = $("#base_url").val();
	var    tipo_caja = $("#tipo_caja").val();
	$("#nuevoTipocaja").click(function(){
		//alert(base_url+" "+tipo_caja);
		url = base_url + "index.php/tesoreria/tipocaja/tipocaja_nuevo" ;
        location.href = url;
	});
	
    $("#cancelartipoCaja").click(function(){
        url = base_url + "index.php/tesoreria/tipocaja/tipocajas/" ;
        location.href = url;
    });
    $("#grabartipoCaja").click(function () {
   
        //if (confirm('¿Está seguro de grabar?')) {
        $('img#loading').css('visibility', 'visible');
        if($("#txtcodigo").val()==""){
           // alert("ingresando a guardar");
    url = base_url + "index.php/tesoreria/tipocaja/tipocaja_grabar";
      
        }else{
    //alert("ingresando a Actualizar");
    url = base_url + "index.php/tesoreria/tipocaja/tipocaja_modificar";
        }
       

      dataString = $('#frmtipocaja').serialize();
      if(validateFormulario()){ 
    $.post(url, dataString, function (data) {
                $('img#loading').css('visibility', 'hidden');
                switch (data.result) {
                    case 'ok':
                       
                  // alert("pasando al");
              location.href = base_url+"index.php/tesoreria/tipocaja/tipocajas";
                      
                
                        break;
                    case 'error':
                        $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                        $('#' + data.campo).css('background-color', '#FFC1C1').focus();
                        break;
                }
            }, 'json');}
    

        //}
    });	
$("#txtTipo").click(function(){
    $("#txtCodigoT").val($("#txtTipo").val());
});
});

function tipocaja_editar(codigo){
   var url=$("#base_url").val();
    location.href = url+"index.php/tesoreria/tipocaja/tipocaja_editar/"+codigo;  
}
function fireMyFunction(){
    $("#buscarTipocaja").click();
}
jQuery(document).ready(function(){
     // $('#txtDescrip').validCampoFranz('0123456789 abcdefghijklmnñopqrstuvwxyzáéiou');
     // $('#txtAbreviatura').validCampoFranz('0123456789 abcdefghijklmnñopqrstuvwxyzáéiou');

$("#buscarTipocaja").click(function(){
        $("#form_busqueda").submit();
    });
 $("#limpiarTipocaja").click(function(){
    var base_url=$("#base_url").val();
        url = base_url+"index.php/tesoreria/tipocaja/tipocajas/0/1"; 
        location.href = url;
    });         
$("#limpiartipoCaja").click(function(){
    //alert("hola");
    document.getElementById("frmtipocaja").reset();
});
});


$(document).ready(function(){
  
  $("#open").click(function(){
        $('#cajaFlotante').fadeIn('slow');
        $('.popup-overlay').fadeIn('slow');
        $('.popup-overlay').height($(window).height());
        return false;
    });
    
    $('#close').click(function(){
        $('#cajaFlotante').fadeOut('slow');
        $('.popup-overlay').fadeOut('slow');
        return false;
    });

   

});
function getOptenerModal(codigo,y){
    var base_u=$("#base_url").val();
    var url_data="index.php/tesoreria/tipocaja/JSON_listarTipoCaja/";
    var url= base_u+url_data+codigo;
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {

  
    $("#tipCa_Descripcion").html(item.tipCa_Descripcion);
    $("#tipCa_Abreviaturas").html(item.tipCa_Abreviaturas);
    $("#tipCa_Tipo").html(item.tipCa_Tipo);
    $("#UsuarioRegistro").html(item.UsuarioRegistro);
    $("#UsuarioModificado").html(item.UsuarioModificado);
    $("#tipCa_fechaModificacion").html(item.tipCa_fechaModificacion);
    $("#tipCa_FechaRegsitro").html(item.tipCa_FechaRegsitro);
    });
});
    $('#cajaFlotante').fadeIn('slow');
    $('.popup-overlay').fadeIn('slow');
    $('.popup-overlay').height($(window).height());
    return false; 
}
function tipocaja_Eliminar(codigo){
    var base_u=$("#base_url").val();
    var url_data="index.php/tesoreria/tipocaja/JSON_ActualizarTipoCaja/";
    var url= base_u+url_data+codigo;
    if(confirm("Esta seguro que desea eliminar?")){
     $.ajax({url: url,type: "POST", success: function(result){
   url2 = base_u + "index.php/tesoreria/tipocaja/tipocajas/" ;
        location.href = url2;
        }
    });   
 }else{

 }
    
}

$(document).dblclick(function(){
   $('#cajaFlotante').fadeOut('slow');
$('.popup-overlay').fadeOut('slow');
    return false;
});

$(document).keydown(function(tecla){ 

   if(tecla.keyCode == 27||tecla.keyCode == 10){
   $('#cajaFlotante').fadeOut('slow');
   $('.popup-overlay').fadeOut('slow');
    return false;
   }
 
  });


function soloLetras_andNumero(e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key).toLowerCase();
    letras = "áéíóúabcdefghijklmnñopqrstuvwxyz.1234567890 ";
    especiales = [8, 37, 39, 46];

    tecla_especial = false
    for(var i in especiales) {
        if(key == especiales[i] ) {
            tecla_especial = true;
            break;
        }
    }

    if(letras.indexOf(tecla) == -1 && !tecla_especial)
        return false;
}
function validateFormulario(){
     if($("#txtDescrip").val() == "" || /^\s*$/.test($("#txtDescrip").val())) {
        $("#txtDescrip").css('background-color', '#FFC1C1').focus();
        return false;
    }
    // Campos de texto
     if($("#txtAbreviatura").val() == "" || /^\s*$/.test($("#txtTipocaja").val())){
       $('#txtAbreviatura').css('background-color', '#FFC1C1').focus();
        return false;
    }//|| /^\s*$/.test(la caja de texto) cuando hay muchos espacios en blanco
    if($("#txtTipocaja").val() == "::Seleccione::" ){
      $('#txtTipocaja').css('background-color', '#FFC1C1').focus();
      return false;
    }
   
   
    return true; // Si todo está correcto
}
$(document).ready(function(){

   $("#txtDescrip").keypress(function(){
  $("#txtDescrip").css({"background-color": "#fff"});
  });
  $("#txtAbreviatura").click(function(){
   $("#txtAbreviatura").css({"background-color": "#fff"});
  });
  $("#txtTipocaja").click(function(){
  $("#txtTipocaja").css({"background-color": "#fff"});
  });
});