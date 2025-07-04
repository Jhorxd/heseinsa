var base_url;
jQuery(document).ready(function () {

    base_url = $("#base_url").val();

    tipo_codificacion = $("#tipo_codificacion").val();

    $("#nuevaGuiatrans").click(function () {
        url = base_url + "index.php/almacen/guiatrans/nueva" + "/";
        location.href = url;
    });
    
    $("#grabarGuiatrans").click(function () {
        $('img#loading').css('visibility', 'hidden');
        // Sirve para editar y insertar
        url = base_url + "index.php/almacen/guiatrans/grabar";

        dataString = $('#frmGuiatrans').serialize();
        $.post(url, dataString, function (data) {
            $('img#loading').css('visibility', 'hidden');
            switch (data.result) {
                case 'ok':
                    location.href = base_url + "index.php/almacen/guiatrans/listar";
                    break;
                case 'error':
                    $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                    $('#' + data.campo).css('background-color', '#FFC1C1').focus();
                    $('img#loading').css('visibility', 'visible');
                    break;
                case 'error2':
                    $('input[type="text"][readonly!="readonly"], select, textarea').css('background-color', '#FFFFFF');
                    var element = document.getElementById(data.campo);
                    element.style.backgroundColor = '#FFC1C1';
                    $('img#loading').css('visibility', 'visible');
                    break;
            }
            $('img#loading').css('visibility', 'visible');
        }, 'json');
    });
    
    $("#cancelarGuiatrans").click(function () {
        url = base_url + "index.php/almacen/guiatrans/listar/";
        location.href = url;
    });

    $('#almacen_destino').change(function () {
        if ($('#almacen_destino').val() != '' && $('#almacen_destino').val() == $('#almacen').val()) {
            alert('El ALMACEN DESTINO debe ser diferente al ALMACEN ORIGEN.');
            $('#almacen_destino').val('').focus();
            return false;
        }
        return true;
    });

    $('#linkEnviarProhibido').click(function () {
        alert('Aun no se ah confirmado la transferencia!');
    });

    $('#idRecibido').click(function () {
        alert('Transferencia realizada correctamente!');
    });
    $('#idRecibido2').click(function () {
        alert('Transferencia realizada correctamente!');
    });

    $('#idDevolucion').click(function () {
        alert('La transferencia fue devuelta a su ORIGEN!');
    });

    $('#linkAnulado').click(function(){
        alert('Transferencia anulada por el origen');
    });

    $("#linkVerSerieNum").click(function () {
        var temp = $("#linkVerSerieNum p").html();
        var serienum = temp.split('-');
        switch (tipo_codificacion) {
            case '1':
                $("#numero").val(serienum[1]);
                break;
            case '2':
                $("#serie").val(serienum[0]);
                $("#numero").val(serienum[1]);
                break;
        }
    });

});

/********************************************************************************************/


function cargarTransferencia(estado, guiaTrans) {
    var mensajeConfirmacion = "";
    switch (estado) {
        case 0:
            mensajeConfirmacion = "¿Estas seguro(a) de realizar la transferencia?";
        break;
        case 1:
            mensajeConfirmacion = "¿Estas seguro(a) de confirmar el transito del envio?";
        break;
        case 2:
            mensajeConfirmacion = "¿Estas seguro(a) de cancelar la transferencia?";
        break;
    }
    compkardex = $("#compkardex").val();

    Swal.fire({
      title: mensajeConfirmacion,
      text: 'Si deseas continuar presiona Si',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var codUsuario = $('#codUsuario').val();
            if (estado <= -1 || guiaTrans <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Existe un error con la transferencia",
                    html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                    showConfirmButton: true,
                    timer: 3000
                });
                return false;
            } else {

                $("#trans"+guiaTrans).hide();
                url = base_url + 'index.php/almacen/guiatrans/cargarTransferencia';
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {estado: estado, guiaTrans: guiaTrans, usuario: codUsuario,compkardex:compkardex},
                    dataType: "json",
                beforeSend: function (data) {
                },
                success: function (data) {
                    if (data.estado=="success") {
                        $("#limpiarG").click();
                        Swal.fire({
                            icon: "success",
                            title: data.mensaje,
                            html: "<b class='color-red'></b>",
                            showConfirmButton: true,
                            timer: 3000
                        });

                    }else{
                        $("#limpiarG").click();
                        Swal.fire({
                            icon: "warning",
                            title: data.mensaje,
                            html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                            showConfirmButton: true,
                            timer: 5000
                        });
                    }
                
                },
                error: function () {
                    Swal.fire({
                        icon: "warning",
                        title: "Se ha presentado un error inesperado, contacta con SOPORTE TECNICO",
                        html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                        showConfirmButton: true,
                        timer: 5000
                    });
                    
                }
                });
            }
        }
    })
}

function devolucion(estado, guiaTrans) {
    compkardex = $("#compkardex").val();

    mensajeConfirmacion = "¿Estas seguro(a) de cancelar la transferencia?";

    Swal.fire({
      title: mensajeConfirmacion,
      text: 'Si deseas continuar presiona Si',
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si',
      cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
            var codUsuario = $('#codUsuario').val();
            if (estado <= -1 || guiaTrans <= 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Existe un error con la transferencia",
                    html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                    showConfirmButton: true,
                    timer: 1500
                });
                return false;
            } else {

                $("#trans"+guiaTrans).hide();
                url = base_url + 'index.php/almacen/guiatrans/devolucion';
                $.ajax({
                    url: url,
                    type: "POST",
                    data: {estado: estado, guiaTrans: guiaTrans, usuario: codUsuario,compkardex:compkardex},
                    dataType: "json",
                beforeSend: function (data) {
                },
                success: function (data) {
                    if (data.estado=="success") {
                        $("#limpiarG").click();
                        Swal.fire({
                            icon: "success",
                            title: data.mensaje,
                            html: "<b class='color-red'></b>",
                            showConfirmButton: true,
                            timer: 3000
                        });

                    }else{
                        $("#limpiarG").click();
                        Swal.fire({
                            icon: "warning",
                            title: data.mensaje,
                            html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                            showConfirmButton: true,
                            timer: 3000
                        });
                    }
                
                },
                error: function () {
                    Swal.fire({
                        icon: "warning",
                        title: "Se ha presentado un error inesperado, contacta con SOPORTE TECNICO",
                        html: "<b class='color-red'>Si el problema persiste, comuníquese con soporte</b>",
                        showConfirmButton: true,
                        timer: 2000
                    });
                    
                }
                });
            }
        }
    })
}

function editar_guiatrans(guiatrans) {
    location.href = base_url + "index.php/almacen/guiatrans/editar/" + guiatrans;
}

function listar_unidad_medida_producto(producto) {
    limpiar_combobox('unidad_medida');

    base_url = $("#base_url").val();
    url = base_url + "index.php/almacen/producto/listar_unidad_medida_producto/" + producto;
    select = document.getElementById('unidad_medida');
    $.getJSON(url, function (data) {
        $.each(data, function (i, item) {
            codigo = item.UNDMED_Codigo;
            descripcion = item.UNDMED_Descripcion;
            simbolo = item.UNDMED_Descripcion;
            nombre_producto = item.PROD_Nombre;
            nombrecorto_producto = item.PROD_NombreCorto;
            marca = item.MARCC_Descripcion;
            modelo = item.PROD_Modelo;
            presentacion = item.PROD_Presentacion;
            opt = document.createElement('option');
            texto = document.createTextNode(simbolo);
            opt.appendChild(texto);
            opt.value = codigo;
            if (i == 0)
                opt.selected = true;
            select.appendChild(opt);
        });
        var nombre;
        if (nombrecorto_producto)
            nombre = nombrecorto_producto;
        else
            nombre = nombre_producto;
        if (marca)
            nombre += ' / Marca:' + marca;
        if (modelo)
            nombre += ' / Modelo: ' + modelo;
        if (presentacion)
            nombre += ' / Prest: ' + presentacion;
        $("#nombre_producto").val(nombre);
    });
}


function guiatrans_ver_pdf(guiatrans, img = 0) {
    url = base_url + "index.php/almacen/guiatrans/guiatrans_ver_pdf/" + guiatrans + "/pdf/" + img;
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;")
}
function guiatrans_ver_pdf_conmenbrete(guiatrans) {
    tipo_oper = $("#tipo_oper").val();
    url = base_url + "index.php/almacen/guiatrans/guiatrans_ver_pdf_conmenbrete/" + guiarem + "/0";
    window.open(url, '', "width=800,height=600,menubars=no,resizable=no;")
}

function anular_guia(codigo){

    url = base_url + 'index.php/almacen/guiatrans/anular_trasnferencia';

    Swal.fire({
      title: '¿Estas seguro(a) que deseas anular esta guia de transferencia?',
      text: "La anulación no se podrá revertir",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Si, anular',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          type: "POST",
          data: {
              codigo: codigo
          },
          dataType: "json",
          beforeSend: function (data) {
          },
          success: function (data){
             Swal.fire(
                      'Transferencia Anulada!',
                      'La guia ha sido anulada',
                      'success'
                    )
              $("#limpiarG").click();
          },
          error: function (HXR, error, xd) {
              console.log('errorr');
          }
      });
      }
    })
}

///////////////////////////////////////////////////////////////////////

function limpiarCampoDeTexto() {
    // Obtén el elemento de entrada de texto por su ID
    var campoDeTexto = document.getElementById("observacion");
  
    // Establece el valor del campo de texto como una cadena vacía
    campoDeTexto.value = "";
  }


