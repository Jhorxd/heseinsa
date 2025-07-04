	
	$("#forma_pago").val(1);//Efectivo

	$("#modal_atras").click(function()
		{
			$("#modal_pago").modal("hide");
		});


$('#ruc_cliente').keyup(function (e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        if ($(this).val() != '') {
        	buscar_clientEnter();
            
        }
    }
});

$('#numero_documento').keyup(function (e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        if ($(this).val() != '') {
        	btn-cuota-acept();
        }
    }
});

$('#monto_temp').keyup(function (e) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        $("#btn-cuota-acept").click();
    }
});





$("#nombre_cliente").autocomplete({
	source: function (request, response) {
		$.ajax({
			url: base_url+"index.php/ventas/cliente/autocomplete/",
			type: "POST",
			data: {term: $("#nombre_cliente").val()},
			dataType: "json",
			success: function (data) {
				response(data);
			}
		});
	},
	select: function (event, ui) {
			  $("#nombre_cliente").val(ui.item.nombre);
			  $("#ruc_cliente").val(ui.item.ruc);
			  $("#cliente").val(ui.item.codigo);
			  check_doc=$("#cboTipoDocu").val()=='F'?1:0;
			  $("#tipo_persona").val(ui.item.tipoPersona);
			  if (check_doc==1) 
			  {
				  var tipo_per=ui.item.tipoPersona;
				  if (tipo_per!=check_doc) 
				  {
					  toastr.info("Tipo De Documento Adaptado al Cliente")
					  if (tipo_per==1) 
					  {
						  $("#cboTipoDocu").val('F');
					  }
					  if (tipo_per==0)  
					  {
						  $("#cboTipoDocu").val('B');
					  }					
				  }					
			  }
			  var vendedor=ui.item.vendedor;
			  if (vendedor>0) 
			  {
				  $("#cboVendedor").val(vendedor);
			  }
		  },
   minLength: 2
})
.focus(function() {
	  $(this).autocomplete("search");
});

$(document).ready({
  source: function (request, response) {
	  $.ajax({
		  url: base_url+"index.php/ventas/cliente/autocomplete_ruc/",
		  type: "POST",
		  data: {term: "00110011"},
		  dataType: "json",
		  success: function (data) {
			  response(data);
		  }
	  });
  },
  select: function (event, ui) {
			$("#nombre_cliente").val(ui.item.nombre);
			alert(ui.item.nombre);
			$("#ruc_cliente").val(ui.item.ruc);
			$("#cliente").val(ui.item.codigo);
			

			check_doc=$("#cboTipoDocu").val()=='F'?1:0;
			$("#tipo_persona").val(ui.item.tipoPersona);
			if (check_doc==1) 
			{
				var tipo_per=ui.item.tipoPersona;
				if (tipo_per!=check_doc) 
				{
					toastr.info("Tipo De Documento Adaptado al Cliente")
					if (tipo_per==1) 
					{
						$("#cboTipoDocu").val('F');
					}
					if (tipo_per==0)  
					{
						$("#cboTipoDocu").val('B');
					}	

				}					
			}

			var vendedor=ui.item.vendedor;
			if (vendedor>0) 
			{
				$("#cboVendedor").val(vendedor);
			}

  },
  minLength: 2

});



function autocompleteRuc() {
	$(document).ready(function() {
		$.ajax({
			url: base_url + "index.php/ventas/cliente/autocomplete_ruc/",
			type: "POST",
			data: {
				term: "00110011"
			},
			dataType: "json",
			success: function (data) {
				$.each(data, function(index, objeto) {
					var ruc = objeto.ruc;
					var nombre = objeto.nombre;
					var codigo = objeto.codigo;
					$("#ruc_cliente").val(ruc);
					$("#nombre_cliente").val(nombre);
					$("#cliente").val(codigo);
				});
			}
		});
	});
}

autocompleteRuc();

$("#ruc_cliente").autocomplete({
      source: function (request, response) {
          $.ajax({
              url: base_url+"index.php/ventas/cliente/autocomplete_ruc/",
              type: "POST",
              data: {term: $("#ruc_cliente").val()},
              dataType: "json",
              success: function (data) {
                  response(data);
              }
          });
      },
      select: function (event, ui) {

				$("#nombre_cliente").val(ui.item.nombre);
				$("#ruc_cliente").val(ui.item.ruc);
				$("#cliente").val(ui.item.codigo);
				

				check_doc=$("#cboTipoDocu").val()=='F'?1:0;
				$("#tipo_persona").val(ui.item.tipoPersona);
				if (check_doc==1) 
				{
					var tipo_per=ui.item.tipoPersona;
					if (tipo_per!=check_doc) 
					{
						toastr.info("Tipo De Documento Adaptado al Cliente")
						if (tipo_per==1) 
						{
							$("#cboTipoDocu").val('F');
						}
						if (tipo_per==0)  
						{
							$("#cboTipoDocu").val('B');
						}	

					}					
				}

				var vendedor=ui.item.vendedor;
				if (vendedor>0) 
				{
					$("#cboVendedor").val(vendedor);
				}

      },
      minLength: 2
  })
	 .focus(function() {
	        $(this).autocomplete("search");
	});



			function buscar_direcciones2(id)
			{
				$.ajax({
		          url: base_url+'index.php/ventas/cliente/JSON_listar_sucursalesCliente/'+id,
		          success:  function (data) 
		          {
		              $("#direccionsuc").html("");
		              var response=JSON.parse(data);

		              $.each(response, function() 
		              {
		              	if (this.EESTAC_Direccion!="" && this.EESTAC_Direccion!=undefined) 
		              	{
		              		$("#direccionsuc").append("<option value='"+this.EESTAC_Direccion+"'>"+this.EESTAC_Direccion+"</option>");
		              	}
									});
		          }
		    });
			}

	$("#search").keyup(function()
	{
		if (this.value.length>1) 
		{
				$(".msj").hide();

				$("#results").html('<div class="loadingio-spinner-spin-lvpepxs6i1"><div class="ldio-0sdgcnk1lov"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');
				let parametros="term="+$("#search").val()+"&TipCli="+$("#TipCli").val()+"&tipo_oper=V&familia=&marca=&modelo"+"&moneda="+$("#moneda").val();
				search(parametros);
		}
		else
		{
			$(".msj").hide();
			$("#search_msj").show();
			$("#results").html("");
		}
	});	
	
	$('#TipCli').change(function(){
		$(".msj").hide();
		$("#results").html('<div class="loadingio-spinner-spin-lvpepxs6i1"><div class="ldio-0sdgcnk1lov"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');
		let parametros="term="+$("#search").val()+"&TipCli="+$("#TipCli").val()+"&tipo_oper=V&familia=&marca=&modelo"+"&moneda="+$("#moneda").val();
		search(parametros);
	})
	
	/*
	$("#search").change(function()
	{
		if (this.value.length>1) 
		{
				$(".msj").hide();

				$("#results").html('<div class="loadingio-spinner-spin-lvpepxs6i1"><div class="ldio-0sdgcnk1lov"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');
				search();
		}
		else
		{
			$(".msj").hide();
			$("#search_msj").show();
			$("#results").html("");
		}
	});	*/

	var productos_temp = [];
	var productos = [];

	function search(parametros) //Búsqueda de Productos/Servicios
	{
 		 // var parametros="term="+$("#search").val()+"&TipCli="+$("#TipCli").val()+"&tipo_oper=V&familia=&marca=&modelo"+"&moneda="+$("#moneda").val();
         $.ajax({
            data:parametros, 
            url:base_url+"index.php/maestros/temporaldetalle/autocomplete_producto/"+ $("#flagBS").val() + "/" + compania+"/"+$("#almacen").val(), 
            type:  'POST',
            beforeSend: function()
            {
                $("#results").html('<div class="loadingio-spinner-spin-lvpepxs6i1"><div class="ldio-0sdgcnk1lov"><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div><div><div></div></div></div></div>');
            },
            success:  function (response) 
	          {
	          		var data=JSON.parse(response);
	          		//console.log(data);

	          		productos_temp=[];
					
	          		if (data.length==0) 
	          		{
	          			$("#results").html("");
	          			$("#empty_msj").show();
	          			return false;
	          		}
	          		else
	          		{
	          			$("#results").html("");
	          			var limite=15;
	          			var start=0;
	          			$.each(data, function(){
	          				var venta=this.pventa>0?this.pventa:0;
	          				start++;
	          				var style="";
	          				if (this.img=="1") 
	          				{
	          					style="color:green;";
	          				}
	          				else
	          				{
	          					style="color:#bdbdbd;";
	          				}
	          					var stock=this.stock!=null?this.stock:0;

				          		$("#results").append(
									'<div style="cursor:pointer;" class="col-md-4"><div class="card"><div class="card-body"><h5 class="card-title"><i class="fa-solid fa-star" id="imagen' + this.codigo + '" onclick="fav_producto(' + this.codigo + ')" data-img="' + this.img + '" style="' + style + '"></i><br>' + this.value + ' [Stock: ' + stock + ']</h5><p class="card-text">Precio: S./' + venta + '</p> <div class="d-flex justify-content-between align-items-center flex-wrap"><a href="#" onclick="agregar_producto(' + this.codigo + ')" class="btn btn-primary mb-3 mr-lg-2 mb-md-2 mb-lg-3 mb-xl-1">Agregar</a><button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#StockModal" onclick="stockGeneral(\'' + this.value + '\')">Ver stock</button> </div></div></div></div>'
									);
									
				          		productos_temp.push(this);
								
					          	if (start==limite) 
					          	{
					          		return false;
					          	}	
	          			});
						
	          		}
	          }   
        });
	}	

        function stockGeneral(producto) {
        		var term = producto;
        		var url = base_url + "index.php/almacen/almacen/obtener_stock_general_por_almacenes";
        		var res = document.querySelector('#res');
        		res.innerHTML = '';
        		
        		$.ajax({
        			url: url,
        			type: 'POST',
        			data: { product: term },
        			dataType: "json", // Es importante especificar el tipo de datos como JSON
        			
        			success: function (data) {
						if (data && Array.isArray(data) && data.length > 0) {
							data.forEach(function (item) {
								res.innerHTML += `
									<tr>
										<td>${item.empresa}</td>
										<td>${item.sucursal}</td>
										<td>${item.almacen}</td>
										<td>${item.stock}</td>
									</tr>
								`;
							});
						} else {
							res.innerHTML = `
								<tr>
									<td style="color:red" colspan="4">Estimado no tiene ingreso de inventario en ningún almacén</td>
								</tr>
							`;
						}
					},	
        			error: function (xhr, status, error) {
        				console.error(error); // Muestra errores en la consola si los hay
        			}
        		});
        	}


	function add_table() //Cargar todos los Productos de Array "productos"
	{
		$("#tbody_productos").html("");
		$.each(productos, function()
			{
				//onclick=ver_teclado("precio'+this.Producto+'")
				html = "";
				
				html += '<tr>';
				html += '<th scope="row">'+this.Nombre+'</th>';
				//precio
				var rol = parseInt(document.getElementById('rol').value);

				//console.log('Rol (número):', rol);
				if (rol === 7004) {
					html += '<td><input type="text" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" style="width: 100px;" class="form-control teclado" onclick="cantidad('+this.Producto+',3)" readonly value="'+this.Precio_Venta+'" onblur="cantidad('+this.Producto+',3)" onfocus="cantidad('+this.Producto+',3)" onkeyup="cantidad('+this.Producto+',3)" id="precio'+this.Producto+'"></td>';
				} else {
					html += '<td><input type="text" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" style="width: 100px;" class="form-control teclado" onclick="cantidad('+this.Producto+',3)" value="'+this.Precio_Venta+'" onblur="cantidad('+this.Producto+',3)" onfocus="cantidad('+this.Producto+',3)" onkeyup="cantidad('+this.Producto+',3)" id="precio'+this.Producto+'"></td>';
				}
								//precio, es el codigo original.
				// html += '<td><input type="text" data-kioskboard-specialcharacters="true" data-kioskboard-type="all" style="width: 100px;" class="form-control teclado" onclick="cantidad('+this.Producto+',3)" value="'+this.Precio_Venta+'" onblur="cantidad('+this.Producto+',3)" onfocus="cantidad('+this.Producto+',3)" onkeyup="cantidad('+this.Producto+',3)" id="precio'+this.Producto+'"></td>';
				
				//cantidad
				html += '<td><i class="fa-solid fa-minus qty-down" style="color:red;" onclick="cantidad('+this.Producto+',2)" ></i>'; 
				html += '<input style="width: 100px;" class="input-number teclado" onkeyup="cantidad('+this.Producto+',4)" id="producto'+this.Producto+'"  value="'+this.Cantidad+'">';
				//html += '<label id="producto'+this.Producto+'">'+this.Cantidad+'</label>';
				html += '<i style="color:green;" onclick="cantidad('+this.Producto+',1)" class="fa-solid fa-plus qty-up"></i></td>';
				
				//total
				html += '<td><input type="text" style="width: 100px;" class="form-control" id="total'+this.Producto+'" readonly value="'+this.Precio_Venta*this.Cantidad+'"></td>';
				html += '<td><i onclick=borrar('+this.Producto+') class="fa-solid fa-trash"></i></td>';
				html += '</tr>';
				$("#tbody_productos").append(html);

			});
		calcular_total();

	if ($("#teclado").prop("checked")) 
	{
		KioskBoard.Run(".teclado");
	}


	}
	function agregar_producto(id) //Agregar Producto Nuevo
	{
		let indice = productos.findIndex(producto => producto.Producto == id);
		if (indice!=-1) 
		{
			toastr.info("Producto ya esta Agregado")
			return false;
		}
		else
		{
			let indice2 = productos_temp.findIndex(producto => producto.codigo == id);
			if (indice2!=-1) 
			{
						var precio_venta=productos_temp[indice2]["pventa"]>0 ? productos_temp[indice2]["pventa"]:0;
						var precio=(parseFloat(precio_venta)*100)/118;
						var igv_pp=parseFloat(precio_venta)-precio;

			 			var producto={
			 			"Producto":productos_temp[indice2]["codigo"],
			 			"Cantidad":1,	 			
			 			"Nombre":productos_temp[indice2]["value"],
			 			"Precio_Unitario":parseFloat(precio),
			 			"Precio_Venta":parseFloat(precio_venta),
			 			"Importe":parseFloat(precio_venta)*1,
			 			"Subtotal":parseFloat(precio),
			 			"Igv":igv_pp,
			 			"Igv_100":"18",
			 			"Tipo_Igv":"1",
			 			"Lote":0,
			 			"icbper":0,
			 			"Descuento_Producto":0,
			 			"flagBS":"",
			 			"Observacion":"",
			 			"Unidad":productos_temp[indice2]["codunidad"],
			 			"Almacen":productos_temp[indice2]["almacenProducto"],
			 			"Stock":0,
			 			"Total_igv":igv_pp
			 			};
			 			productos.push(producto);
			 			add_table();
			}
		}

	}
function cantidad(id,tipo) //Sumar Cantidades a Arrays
{

	$("#numero_temporal").val(id);


	var precio 		= parseFloat($("#precio"+id).val());
	var cantidad 	= parseFloat($("#producto"+id).val());
	var total 		= parseFloat($("#total"+id).val());
	if (cantidad<0) {cantidad=0;}
	if (isNaN(cantidad)) {cantidad=0;}
	let indice = productos.findIndex(producto => producto.Producto == id);
	
	if (tipo==1)//Sumar 
	{
		$("#producto"+id).val(cantidad+1);
		productos[indice]["Cantidad"]=cantidad+1;
	}
	if (tipo==2)//Restar 
	{
		$("#producto"+id).val(cantidad-1);
		productos[indice]["Cantidad"]=cantidad-1;
	}
	if (tipo==4)//Restar 
	{
		$("#producto"+id).val(cantidad);
		productos[indice]["Cantidad"]=cantidad;
	}
	var cantidad2 = parseFloat($("#producto"+id).val());
	if (isNaN(cantidad2)) {cantidad2=0;}
	
	if (cantidad2<0) {cantidad2=0;}


	productos[indice]["Precio_Venta"] = precio;
	pu = (precio*100)/118;
	productos[indice]["Precio_Unitario"] = pu;
	igv_temp = precio-pu;

	productos[indice]["Igv"] 		= igv_temp;
	productos[indice]["Total_igv"] 	= igv_temp*cantidad2;
	productos[indice]["Subtotal"] 	= pu*cantidad2;
	productos[indice]["Importe"] 	= precio*cantidad2;
	
	total_m=precio*cantidad2;
	$("#total"+id).val(total_m);
	calcular_total();
}
function calcular_total()
{
	var subtotal=0;
	var igv=0;
	var total=0;
	for (var i = 0; i <productos.length; i++) 
	{
		subtotal+=productos[i]["Subtotal"];
		igv+=productos[i]["Total_igv"];
		total+=productos[i]["Importe"];
	}
	$("#subtotal").html(parseFloat(subtotal).toFixed(2));
	$("#igv").html(parseFloat(igv).toFixed(2));
	$("#total").html(parseFloat(total).toFixed(2));

}
function limpiar()
{
  productos=[];
  add_table();
  productos_temp=[];
  cuotas_temp=[];
  $("#ruc_cliente").val("");
  $("#nombre_cliente").val("");
  $("#cliente").val("");
  $("#direccionsuc").html("");
  $("#search").val("");
  calcular_total();
	$("#results").html("");
	$("#search_msj").show();
	$("#tipo_persona").val("");
}

$("#cancelar").click(function()
	{
		Swal.fire({
			  title: '¿Limpiar Documento?',
			  text: "Deberá llenar los datos nuevamente",
			  icon: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Si, Limpiar!',
			  cancelButtonText: 'No, Cerrar!'
			}).then((result) => {
			  if (result.isConfirmed) {
			    Swal.fire(
			      'Exito!',
			      'Documento Limpiado',
			      'info'
			    )
			    limpiar();
			  }
			})
	});
$("#salir_pos").click(function()
	{
			Swal.fire({
			  title: '¿Salir de Modo POS?',
			  text: "Volverá a la Versión Escritorio",
			  icon: 'info',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Salir del POS',
			  cancelButtonText: 'Quedarme'
			}).then((result) => {
			  if (result.isConfirmed) {
					toastr.info("Saliendo de modo POS...")
					window.location=base_url+"/index.php/index/inicio";
			  }
			})
	});

function borrar(id) //Borrar Producto de Array
{
		Swal.fire({
		  title: '¿Quitar este Producto?',
		  text: "Puede Agregarlo Nuevamente",
		  icon: 'warning',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Quitar',
		  cancelButtonText: 'Dejar'
		}).then((result) => {
		  if (result.isConfirmed) {
		    Swal.fire(
		      'Exito!',
		      'Producto Elimiado de la lista.',
		      'success'
		    )
				let indice = productos.findIndex(producto => producto.Producto == id);
				if (indice!=-1) 
				{
					productos.splice(indice,1);
				}
				add_table();

		  }
		})


}

function calcular_vuelto()
{
	if ($("#monto_temp").val()>0) 
	{
		var monto=$("#monto_temp").val();
		var total=$("#total_temp").val();
		var vuelto=parseFloat(total)-parseFloat(monto);
		$("#vuelto_temp").val(vuelto*-1);
	}
}
$("#monto_temp1").hide();
$("#vuelto_temp1").hide();
var ruc_cliente = $("#ruc_cliente").val();
var nombre_cliente = $("#nombre_cliente").val();
$("#procesar").click(function() //Paso 1
	{
		if (ruc_cliente === "" && nombre_cliente === "") {
			if ($("#cliente").val()=="") 
			{
				toastr.info("Debe Introducir un Cliente")
				return false;
			}
		}

		if ($("#tipo_persona").val()=="0" && $("#cboTipoDocu").val()=='F') 
		{
			toastr.info("No puede emitir factura con este tipo de documento")
			return false;
		}
		if (productos.length==0) 
		{
			toastr.info("Debe Introducir al Menos un Producto")
			return false;
		}
		if ($("#total").html()==0) 
		{
			toastr.warning("Verifique los Precios")
			return false;							
		}		
		$("#modal_pago").modal("show");

		$("#total_temp").val($("#total").html());
		$("#monto_temp").val(0);
		$("#vuelto_temp").val(0);
		let valor = parseInt($("#condiciones_pago").val());
		if (valor === 1) {
			$("#monto_temp1").show();
			$("#vuelto_temp1").show();
		}
		if (valor === 2 || valor === 3 || valor === 6 || valor === 7 || valor === 11) {
			$("#monto_temp1").hide();
			$("#vuelto_temp1").hide();
		} 


	});

function necesitaCuota() {
    var _this = $("#forma_pago");

    var currentText = document.getElementById('forma_pago').options[document.getElementById('forma_pago').options.selectedIndex].innerText.toLowerCase();
    var requiereCuota = /cuota|credito/g.test(currentText);
    $("#btn-cuotas").css('display', requiereCuota ? '' : 'none');
    $("#condicionespago").css('display', requiereCuota ? '' : 'none');
    codigo ="";
    if (codigo=="") {
        $("#condiciones_de_pago").val(currentText);
    }
    
    if (requiereCuota) {
        $("#btn-cuotas").click();
    }
    
    if(!requiereCuota){
    	$("#div_mostrar_cuotas").hide("slow");
    }else{
        view_coutas();
        $("#div_mostrar_cuotas").show("slow");
    }
}
		var cuotas_temp=[];
  	var cuotas_temp_old=[];
    function cant_cuotas(){
        cuotas = $("#cant-cuotas").val();
        var fecha = $("#fecha_temp").val();

        cantidadA = $(".cantidad-cuotas").length;
        if ( cantidadA > cuotas ){
            $(".cantidad-cuotas:last-child").remove();
            $(".cantidad-cuotas:last-child .cuota-fechaf").removeAttr("onchange");
            total=cuotas_temp.length-1;
            cuotas_temp.splice(total,1);
        }
        else{
            i = cuotas - 1;
            j = i + 1;
            
            if (i > 0){
                fecha = $(".cuota-fechaf" + parseInt(i-1) ).val();
                $(".cuota-fechaf"+parseInt(i-1)).attr({ "onchange": "fecha_fin_cuota("+parseInt(i)+");precio_cuota("+i+");" });
            }

            inputs = '<tr class="cantidad-cuotas">';
                inputs += '<td> ' + j + ' </td>';
                inputs += '<td> <input type="date" onchange=precio_cuota('+i+') id="cuota-fechai[' + i + ']" name="cuota-fechai[' + i + ']" class="form-control fechai'+i+' cuota-fechai'+i+'" value="' + fecha + '"> </td>';
                inputs += '<td> <input type="date" onchange=precio_cuota('+i+') id="cuota-fechaf[' + i + ']" name="cuota-fechaf[' + i + ']" class="form-control fechaf'+i+' cuota-fechaf'+i+' cuota-fechaf" > </td>';
                inputs += '<td> <input type="number" step="0.1" min="0" id="cuota-monto[' + i + ']" name="cuota-monto[' + i + ']" class="form-control monto'+i+' cuota-monto'+i+'" onchange="cuota_total(' + true + ');precio_cuota('+i+');" value=""> </td>';
            inputs += '</tr>';

            cuotas_temp.push({"Cuota":j,"Fecha":fecha,"Fecha_Fin":"","Monto":0});

            $("#tbl-cuotas tbody").append(inputs);
        }
        cuota_total(false);
    }

    function view_coutas(comprobante = ""){
        if (comprobante != ""){
            url = base_url+"index.php/tesoreria/cuota/obtener_cuotas_comprobante";
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                data: { comprobante: comprobante },
                beforeSend:function(data){
                    $('#tbl-cuotas tbody').html('');
                },
                error: function (XRH, error){
                    Swal.fire({
                        icon: "warning",
                        title: "No fue posible acceder a las cuotas.",
                        showConfirmButton: false,
                        showCancelButton: false,
                        timer: 2000
                    });
                },
                success: function (data){
                    if (data.match == true) {                        
                        $.each(data.info, function(i,item){
                            cuotas = $("#cant-cuotas").val();
                            indice = i + 1;

                            inputs = '<tr class>';
                                inputs += '<td> ' + indice + ' </td>';
                                inputs += '<td> <input type="date" value="' + item.fechaiv + '" id="cuota-fechai[' + i + ']" name="cuota-fechai[' + i + ']" class="form-control cuota-fechai'+i+'" value="' + fecha + '"> </td>';

                                inputs += '<td> <input value="' + item.fechafv + '" type="date" id="cuota-fechaf[' + i + ']" name="cuota-fechaf[' + i + ']" class="form-control cuota-fechaf'+i+' cuota-fechaf"> </td>';
                                    
                                inputs += '<td> <input type="number" step="0.1" min="0" id="cuota-monto[' + i + ']" name="cuota-monto[' + i + ']" class="form-control cuota-monto'+i+'" onchange="cuota_total(' + true + ')" value="' + item.cuota + '"> </td>';
                            inputs += '</tr>';

                            cuotas_temp.push({"Cuota":indice,"Fecha":item.fechaiv,"Fecha_Fin":item.fechafv,"Monto":item.cuota});
                            cuotas_temp_old.push({"Cuota":indice,"Fecha":item.fechaiv,"Fecha_Fin":item.fechafv,"Monto":item.cuota});

                            $("#tbl-cuotas tbody").append(inputs);
                        });

                        cuota_total(true);
                    }
                }
            });
        }
    }

function fecha_fin_cuota(pos){
  i = parseInt(pos-1);
  $(".cuota-fechai"+pos).val( $(".cuota-fechaf"+i).val() );
  cuotas_temp[pos]["Fecha"]=$(".cuota-fechaf"+i).val();
  cuotas_temp[i]["Fecha_Fin"]=$(".cuota-fechaf"+i).val();
}

function cuota_total(quetions = false){
  cuotas = cuotas_temp.length;
  montoTotal = parseFloat($("#total").html());

  importe = montoTotal / cuotas;
  total = 0;

  if (quetions == true){
      Swal.fire({
                  icon: "warning",
                  title: "¿Desea recalcular automaticamente las cuotas?",
                  showConfirmButton: true,
                  showCancelButton: true,
                  confirmButtonText: "Si",
                  cancelButtonText: "No"
              }).then(result => {
                  if (result.value){
                      for ( i=0; i<cuotas; i++ ){
                          $(".cuota-monto"+i).val(importe);

                          cuotas_temp[i]["Monto"]=importe;
                          
                          if ( $(".cuota-monto"+i).val() != "" )
                              total = parseFloat(total) + parseFloat($(".cuota-monto"+i).val());
                      }
                  }
              });
  }
  else{
      for ( i=0; i<cuotas; i++ ){
          $(".cuota-monto"+i).val(importe);
           cuotas_temp[i]["Monto"]=importe;
          if ( $(".cuota-monto"+i).val() != "" )
              total = parseFloat(total) + parseFloat($(".cuota-monto"+i).val());
      }
      $("#suma-cuotas").html( total.toFixed(2) );
  }
}


  $(".add-cuota").click(function(){
      $("#cant-cuotas").val( parseInt( $("#cant-cuotas").val() ) + 1 );
      cant_cuotas();
  });

  $(".del-cuota").click(function(){
      $("#cant-cuotas").val( parseInt( $("#cant-cuotas").val() ) - 1 );
      cant_cuotas();
  });

  $(".btn-cuota-recalc").click(function(){
      cuota_total(true);
  });

  $(".btn-cuota-cancel").click(function(){
      $("#cant-cuotas").val(0);
      $("#tbl-cuotas tbody").html("");
      $(".modal-cuotas").modal("hide");
      cuotas_temp=[];
  });

    $(".btn-cuota-acept").click(function(){
    	var pase=0;
    	monto=parseFloat($("#monto_temp").val());
    	total_temp=parseFloat($("#total_temp").val());



    	let valor = parseInt($("#condiciones_pago").val());
		if (valor === 1) {
			if (total_temp>monto) 
			{
				alert($("#condiciones_pago").val());
				toastr.warning("Monto pagado no Válido")
				return false;
			}
		}

    		$.each(cuotas_temp,function()
    			{
    				if (this.Fecha=="") 
    				{
    					toastr.warning("Complete las Fechas de las Cuotas")
    					pase++;
    					return false;

    				}
    				if (this.Fecha_Fin=="") 
    				{
    					toastr.warning("Complete las Fechas de las Cuotas")
    					pase++;
    					return false;
    				}        				
    			});
    		if (pase==0) 
    		{
    			enviar();
    		}
    		
    });

function precio_cuota(pos)
{
	cuotas_temp[pos]["Fecha"]=$(".fechai"+pos).val();
	cuotas_temp[pos]["Fecha_Fin"]=$(".fechaf"+pos).val();
	cuotas_temp[pos]["Monto"]=parseFloat($(".monto"+pos).val());
}

$("#forma_pago").change(function(){
	if (this.value!="") 
		$("#div_generar").show();
	else
		$("#div_generar").hide();
});

$("#close_modal_ticket").click(function(){
	$("#modal_ticket").modal("hide");
});

function enviar()
{

	if ($("#forma_pago").val()=="") 
	{
		toastr.warning("Falta Forma de Pago")
		return false;
	}

	var datos = [];
	var data=
	{
		"compania":compania,
		"tipo_oper":"V",
		"cboTipoDocu":$("#cboTipoDocu").val(),
		"ordencompra":"",
		"dRef":"",
		"serie":$("#serie").val(),
		"numero":"",
		"numeroAutomatico":$("#numeroAutomatico").val(),
		"igv":18,
		"fecha":$("#fecha_temp").val(),
		"fecha_vencimiento":$("#fecha_temp").val(),
		"cliente":$("#cliente").val(),
		"buscar_cliente":"",
		"ruc_cliente":$("#ruc_cliente").val(),
		"nombre_cliente":$("#nombre_cliente").val(),						
		"tempde_TipCli":0,
		"cboVendedor":$("#cboVendedor").val(),
		"VerificadoSuccess":"",
		"almacen":$("#almacen").val(),
		"moneda":$("#moneda").val(),
		"tdcDolar":$("#tdcDolar").val(),
		"direccionsuc":$("#direccionsuc").val(),
		"oc_cliente":"",
		"obra":0,
		"tipo_venta":1,
		"descuento":0,
		"docurefe_codigo":"",
		"estado":"",
		"applyRetencion_hidden":"",
		"applyRetencion":"",
		"retencion_codigo":"",
		"retencion_porc":"",
		"forma_pago":$("#forma_pago").val(),
		"caja":$("#caja").val(),
		"observacion":$("#observaciones").val(),
		"descuentotal":0,
		"exoneradototal":0,
		"inafectototal":0,
		"gratuitatotal":0,
		"preciototal":0,
		"gravadatotal":$("#subtotal").html(),
		"igvtotal":$("#igv").html(),
		"importeBolsa":0,
		"importetotal":$("#total").html(),
		"salir":0,
		"codigo":"",
		"contiene_igv":1,
		"contacto":"",
		"ordencompra":"",
		"condiciones_pago":$("#condiciones_pago").val(),
		"monto_temp":$("#monto_temp").val()
	}

	datos.push(data);

	var array_total = [];
	array_total.push({"Datos":datos,"Productos":productos,"Cuotas":cuotas_temp});
	$("#datos").val(JSON.stringify(array_total));

	array = $('#frmComprobante').serialize();

	$(".btn-cuota-acept").prop("disabled", true);
	$(".btn-cuota-recalc").prop("disabled", true);
	$(".btn-cuota-acept").html("Espere...");

	$.ajax({
		data:  array, 
		url:   base_url + "index.php/ventas/comprobante/comprobante_insertar_array", 
		type:  'POST',
		beforeSend: function()
		{
			$("#imgload").show("slow");
			$("#imgload").css("z-index",999);
			$("#modal_pago").modal("hide");

		},
		success:  function (response) 
		{
			$("#imgload").hide("fast");
			$("#imgload").css("z-index",0);

			if (response=="error") 
			{
				Swal.fire(
					'Ocurrio un Error!',
					'No se pudo crear el Documento',
					'warning'
				)	
				$(".btn-cuota-acept").prop("disabled", false);
				$(".btn-cuota-acept").html("Generar");	                             		
			}
			if (response>0) 
			{
				toastr.success("Documento Creado, Cargando PDF...")
				limpiar();
				var tdoc=$("#cboTipoDocu").val();
				$("#tbl-cuotas tbody").html("");
				$("#div_mostrar_cuotas").hide();
				$("#condiciones_de_pago").val("");
				$("#forma_pago").val(1);

				$("#last_sell").val(response);
				$("#last_sell_tipo").val($("#cboTipoDocu").val());
				$("#cboTipoDocu").val('B')
				$("#modal_ticket").modal("show");
				$("#tipo_persona").val("");

				if (tdoc=='N') 
				{
					$("#pdf").html('<embed src="'+base_url+'index.php/ventas/comprobante/comprobante_ver_pdf/'+response+'/TICKET" width="100%" height="400" type="application/pdf">');
				}
				else
				{
					abrir_pdf_envioSunat(response);
				}

				$(".btn-cuota-acept").prop("disabled", false);
				$(".btn-cuota-recalc").prop("disabled", false);
				$(".btn-cuota-acept").html("Generar");	   

			}
			else 
			{
				var porciones = response.split('-');
				if (porciones[1]=="ErrorFact") 
				{
					limpiar();
					$("#tbl-cuotas tbody").html("");
					$("#div_mostrar_cuotas").hide();
					$("#condiciones_pago").val("");
					$("#forma_pago").val(1);
					$("#modal_pago").modal("hide");
					$("#last_sell").val(response);
					//$("#modal_ticket").modal("show");
					$("#tipo_persona").val("");

					$(".btn-cuota-acept").html("Generar");

					Swal.fire({
						title: 'Documento Creado pero no Enviado a Sunat',
						text: porciones[2],
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Volver a Enviar',
						cancelButtonText: 'Enviar Luego'
					}).then((result) => {
						if (result.isConfirmed) {
							$("#imgload").show("slow");
							$("#imgload").css("z-index",999);
							var comprobante=porciones[0];
							disparador(comprobante,0);
						}
					})	

					$(".btn-cuota-acept").prop("disabled", false);
					$(".btn-cuota-recalc").prop("disabled", false);
				} 
			}

		}

	});

}

$("#observaciones").keyup(function(){
	var valor=$("#observaciones").val();
	var valor_up=valor.toUpperCase();
	$("#observaciones").val(valor_up);
});


function disparador(comprobante, pos) {
    updateFecha = false;

    $.ajax({
        type: "POST",
        dataType: "json",
        url: base_url + "index.php/ventas/comprobante/getFechaE",
        data:{ comprobante: comprobante },
        success: function(data){
            updateFecha = data.update;
            fecha = data.fecha_hoy;
        },
        complete: function(data){

            if ( updateFecha == true ){
                Swal.fire({
                    icon: "info",
                    title: "Notificación",
                    html: "<b>El documento debe ser enviado con la fecha actual.<br>Si continua la fecha se actualizara automaticamente.</b>",
                    showConfirmButton: true,
                    showCancelButton: true,
                    confirmButtonText: "Aceptar",
                    cancelButtonText: "Cancelar"
                }).then(result => {
                    if ( result.value == true){
                        execute_disparador(comprobante, pos);
                    }
                    else{
                        Swal.fire({
                            icon: "warning",
                            title: "Envio cancelado",
                            html: "<b>La aprobación fue cancelada.</b>",
                            timer: 2000
                        });
                    }
                });
            }
            else{
                execute_disparador(comprobante, pos);                   
            }
        }
    });
}

function execute_disparador(comprobante, pos){
    tipo_oper = $("#tipo_oper").val();
    tipo_docu = $("#cboTipoDocu").val();
    var url = base_url + "index.php/ventas/comprobante/disparador/" + tipo_oper + "/" + comprobante + "/" + tipo_docu;

    $.ajax({
        type: "POST",
        url: url,
        data: { comprobante: comprobante },
        dataType: 'json',
        beforeSend: function (data) {
        },
        error: function (data) {
        },
        success: function (data) {
        		$("#imgload").hide("fast");
        		$("#imgload").css("z-index",0);
            switch (data.result){
                case 'success':
                    Swal.fire({
                        icon: "success",
                        title: data.response,
                        html: "<b class='color-red'></b>",
                        showConfirmButton: true,
                        timer: 3000
                    });

                    $("#modal_ticket").modal("show");
                    abrir_pdf_envioSunat(comprobante);

                    break;
                case 'error':

                    Swal.fire({
                        icon: "error",
                        title: data.response,
                        html: "Debe salir del POS y Verificar el Documento en el Facturador",
                        showConfirmButton: true
                    });
                    break;
            }
        }
    });
}

function abrir_pdf_envioSunat(codigo){
    url = base_url+"index.php/ventas/comprobante/consultarRespuestaPdfsunat/"+codigo;
    $.ajax({
        type: "POST",
        url: url,
        data: codigo,
        dataType: 'json',
        async: false,
        beforeSend: function (data) {
        },
        error: function (data) {
        },
        success: function (data) {
            if(data.error==1){
                Swal.fire({
                    icon: "error",
                    title: "No se ha obtenido el documento, por favor comuníquese con SOPORTE TÉCNICO",
                    html: "<b class='color-red'></b>",
                    showConfirmButton: true
                    
                });
            }else{
                url = data.respuestas_enlacepdf;
                if (url!="") 
                {
                	$("#pdf").html('<embed src="'+base_url+'index.php/ventas/comprobante/comprobante_ver_pdf/'+codigo+'/TICKET" width="100%" height="400" type="application/pdf">');
                }
                else
                {
                	$("#pdf").html("Hay un Error en el Documento");
                }

            }
        }
    });
}

$("#see_last_sell").click(function()
	{
		if ($("#last_sell").val()>0) 
		{
			var id=$("#last_sell").val();
			toastr.success("Cargando PDF...")
			if ($("#last_sell_tipo").val()=='N') 
			{
				$("#modal_ticket").modal("show");
				$("#pdf").html('<embed src="'+base_url+'index.php/ventas/comprobante/comprobante_ver_pdf/'+id+'/TICKET" width="100%" height="400" type="application/pdf">');
			}
			else
			{
				$("#modal_ticket").modal("show");
				abrir_pdf_envioSunat($("#last_sell").val());
			}
		}
		else
		{
			toastr.info("Aún no hay Ventas en esta Sesión")
		}
	});
$("#cboTipoDocu").change(function()
	{
		if ($("#tipo_persona").val()!="") 
		{
			check_doc=$("#cboTipoDocu").val()=='F'?1:0;

			if (check_doc==1) 
			{
				if (check_doc!=$("#tipo_persona").val()) 
				{
					toastr.info("No es Posible usar con este Cliente")
					tipo_per=$("#tipo_persona").val();

							if (tipo_per==1) 
							{
								$("#cboTipoDocu").val('F');
							}
							if (tipo_per==0) 
							{
								$("#cboTipoDocu").val('B');
							}	
				}
			}
		}

	});
$("#modal_d").click(function()
	{
		$("#modal_addcliente").modal("show");

	});

    $("#tipo_cliente").change(function(){
        show_tipoCliente( parseInt($(this).val()) );
    });
    function show_tipoCliente( id = null ){
    if (id == null)
        id = parseInt( $("#tipo_cliente").val() );
    else
        $("#tipo_cliente").val(id);

    if ( id == 0 ){
        $(".divJuridico").hide("fast");
        $(".divNatural").show("slow");

        $(".documentosJuridico").attr({ "disabled": "disabled" });
        $(".DOC1").removeAttr("selected");

        $(".documentosNatural").removeAttr("disabled");
        $(".DOC0").first().attr({"selected":"selected"});
    }
    else
        if ( id == 1 ){
            $(".divNatural").hide("fast");
            $(".divJuridico").show("slow");

            $(".documentosNatural").attr({ "disabled": "disabled" });
            $(".DOC0").removeAttr("selected");

            $(".documentosJuridico").removeAttr("disabled");
            $(".DOC1").first().attr({"selected":"selected"});
        }
}

function getSunat(){
	toastr.info("Buscando, espere...")
    if ( $("#numero_documento").val() != "" ){
        var url = base_url + "index.php/ventas/cliente/search_documento";
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data:{
                    numero: $("#numero_documento").val()
            },
            beforeSend: function(){
                $('.btn-search-sunat').hide("fast");
                $("#img_load").show("slow");
                            
                $("#nombres").val("");
                $("#apellido_paterno").val("");
                $("#apellido_materno").val("");

                $("#razon_social").val("");
                $("#direccion").val("");
            },
            success: function(data){
                if (data.exists == false) {
                    if (data.match == true){
                        info = data.info;

                        show_tipoCliente(data.tipo_cliente);
                        $("#idcliente").val(data.id_cliente);

                        if (data.tipo_cliente == 0){ // NATURAL
                            $("#nombres").val(info.nombre);
                            $("#apellido_paterno").val(info.paterno);
                            $("#apellido_materno").val(info.materno);
                            $("#direccion").val("-");

                            if (info.sexo == "Masculino")
                                $("#genero").val("0");
                            if (info.sexo == "Femenino")
                                $("#genero").val("1");
                        }
                        else{ // JURIDICO
                            $("#razon_social").val(info.result.razon_social);
                            $("#direccion").val(info.result.direccion);

                            ubigeo = info.result.ubigeo;

                            dpto = ubigeo.substr(0,2);
							prov = ubigeo.substr(2,2);
							dist = ubigeo.substr(4,2);

							$("#departamento").val(dpto);

                        }
                    }
                    else{
                        Swal.fire({
                                    icon: "info",
                                    title: "¡Algo ha ocurrido!",
                                    html: "<b class='color-red'>" + data.message + "</b>",
                                    showConfirmButton: true,
                                    timer: 6000
                                });

                        				$("#numero_documento").val("");
                    }
                }
                else{
                    Swal.fire({
                                icon: "info",
                                title: "¡Algo ha ocurrido!",
                                html: "<b class='color-red'>" + data.message + "</b>",
                                showConfirmButton: true,
                                timer: 6000
                            });
                }
            },
            complete: function(){
                $("#img_load").hide("fast");
                $('.btn-search-sunat').show("fast");

            }
        });
    }
    else
    {
    	toastr.info("Introduzca un Número de Documento")
    }
}

function clean()
{
	$("#formCliente")[0].reset();
}
$("#cerrar_cliente").click(function()
{
	$("#modal_addcliente").modal("hide");
});

function fav_producto(id)
{
	var img_check=$("#imagen"+id).attr("data-img");
	var estado;
	if (img_check=="1") 
	{
		toastr.success("Favorito Elimiado")
		estado=0;
		$("#imagen"+id).attr("data-img",0);
		$("#imagen"+id).css("color","#bdbdbd");
	}
	else
	{
		toastr.success("Favorito Agregado")
		estado=1;
		$("#imagen"+id).attr("data-img",1);
		$("#imagen"+id).css("color","green");
	}

 var parametros="estado="+estado;
 $.ajax({
        data:  parametros, 
        url:   base_url+'index.php/maestros/temporaldetalle/modificar_producto_img/'+id, 
        type:  'POST'
    });

}

function cargar_productos(data)
{

		$("#results").html("");
		var limite=15;
		var start=0;
		if (data.length==0) 
		{
			$("#search_msj").hide("");
		}
		productos_temp=[];
		$.each(data, function(){
			var venta=this.pventa>0?this.pventa:0;
			start++;
			var style="";
			if (this.img=="1") 
			{
				style="color:green;";
			}
			else
			{
				style="color:#bdbdbd;";
			}
			    var stock=this.stock!=null?this.stock:0;
    			$("#results").append('<div style="cursor:pointer;" class="col-md-4"><div class="card"><div class="card-body"><h5 class="card-title"><i class="fa-solid fa-star" id="imagen'+this.codigo+'" onclick=fav_producto('+this.codigo+') data-img='+this.img+' style='+style+'></i><br>'+this.value+' [Stock: '+stock+']</h5><p class="card-text">Precio: S./'+venta+'</p><a href="#" onclick=agregar_producto('+this.codigo+') class="btn btn-primary">Agregar</a></div></div></div>');
				  productos_temp.push(this);

      	if (start==limite) 
      	{
      		return false;
      	}	
		});

		if (start>0) 
		{
			$("#search_msj").hide("");
		}	
}
function cargar_favoritos()
{	 
	var almacen = $("#almacen").val();
	var parametros="search=true";
	$.ajax({
	    data: {almacen:almacen}, 
	    url:   base_url+'index.php/index/getFavoritos', 
	    type:  'POST',
	    beforeSend: function(){
	        toastr.info("Cargando Favoritos...")
	    },
	    success:  function (response) 
            {
             	if (response.length>0) 
             	{
             		var data=JSON.parse(response);
             		cargar_productos(data);
             		$("#search").val("");
             	}
             	else
             		toastr.warning("No hay Favoritos Registrados")
            }
	});
}
$("#fav_reload").click(function()
	{
		$("#search").val("");
		cargar_favoritos();
	});


///////////BUSCA CLIENTE CON ENTER/////////////
function buscar_clientEnter() {

		var term = $("#ruc_cliente").val();

        $.ajax({
            type: "POST",
            dataType: "json",
            url: base_url + "index.php/ventas/cliente/buscar_enter_ruc",
            data:{ term: term },
            success: function(data){
            	var result = data[0].resultado;
                if (result=="success") {
                	$("#nombre_cliente").val(data[0].nombre);
					$("#ruc_cliente").val(data[0].ruc);
					$("#cliente").val(data[0].codigo);

					check_doc = $("#cboTipoDocu").val()=='F' ? 1 : 0;
					$("#tipo_persona").val(data[0].tipoPersona);
					if (check_doc==1) 
					{
						var tipo_per=data[0].tipoPersona;
						if (tipo_per!=check_doc) 
						{
							toastr.info("Tipo De Documento Adaptado al Cliente")
							if (tipo_per==1) 
							{
								$("#cboTipoDocu").val('F');
							}
							if (tipo_per==0)  
							{
								$("#cboTipoDocu").val('B');
							}	

						}					
					}

					var vendedor=data[0].vendedor;
					if (vendedor>0) 
					{
						$("#cboVendedor").val(vendedor);
					}
					$("#cboVendedor").focus();
	            }else{
	            	toastr.error("No se ha conseguido al Cliente")
	                }
            },
            complete: function(data){

                
            }
        });

	
}


function registrar_cliente(){
	tipo_oper = $("#tipo_oper").val();
    Swal.fire({
        icon: "info",
        title: "¿Esta seguro de guardar el registro?",
        html: "<b class='color-red'></b>",
        showConfirmButton: true,
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.value){
            if (tipo_oper=="C") {
                var url = base_url + "index.php/compras/proveedor/guardar_registro";
            }else{
                var url = base_url + "index.php/ventas/cliente/guardar_registro";
            }


            cliente         = "";

            tipo_cliente    	= $("#tipo_cliente").val();
            tipo_documento  	= $("#tipo_documento").val();
            numero_documento 	= $("#numero_documento").val();
            
            razon_social    = $("#razon_social").val();
            
            nombres         = $("#nombres").val();
            apellido_paterno = $("#apellido_paterno").val();
            apellido_materno = $("#apellido_materno").val();
            genero          = $("#genero").val();
            edo_civil       = $("#edo_civil").val();
            nacionalidad    = $("#nacionalidad").val();
            
            direccion       = $("#direccion").val();
            departamento    = $("#departamento").val();
            provincia       = $("#provincia").val();
            distrito        = $("#distrito").val();

            idcliente       = $("#idcliente").val();
            vendedor        = $("#vendedor").val();
            sector_comercial = $("#sector_comercial").val();
            forma_pago      = $("#forma_pago").val();
            categoria       = $("#categoria").val();
            telefono        = $("#telefono").val();
            movil           = $("#movil").val();
            fax             = $("#fax").val();
            correo          = $("#correo").val();
            web             = $("#web").val();

            validacion = true;

            if (tipo_cliente == "1"){
                if (razon_social == ""){
                    Swal.fire({
                                icon: "error",
                                title: "Verifique los datos ingresados.",
                                html: "<b class='color-red'>Debe ingresar una razón social.</b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                    $("#razon_social").focus();
                    validacion = false;
                    return false;
                }
            }
            else{
                if (nombres == ""){
                    Swal.fire({
                                icon: "error",
                                title: "Verifique los datos ingresados.",
                                html: "<b class='color-red'>Debe ingresar el nombre.</b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                    $("#nombres").focus();
                    validacion = false;
                    return false;
                }

                if (apellido_paterno == ""){
                    Swal.fire({
                                icon: "error",
                                title: "Verifique los datos ingresados.",
                                html: "<b class='color-red'>Debe ingresar el apellido paterno.</b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                    $("#apellido_paterno").focus();
                    validacion = false;
                    return false;
                }

                if (apellido_materno == ""){
                    Swal.fire({
                                icon: "error",
                                title: "Verifique los datos ingresados.",
                                html: "<b class='color-red'>Debe ingresar el apellido materno.</b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                    $("#apellido_materno").focus();
                    validacion = false;
                    return false;
                }
            }

            if (numero_documento == ""){
                Swal.fire({
                            icon: "error",
                            title: "Verifique los datos ingresados.",
                            html: "<b class='color-red'>Debe ingresar un número de documento valido.</b>",
                            showConfirmButton: true,
                            timer: 4000
                        });
                $("#numero_documento").focus();
                validacion = false;
                return false;
            }

            if (direccion == ""){
                Swal.fire({
                            icon: "error",
                            title: "Verifique los datos ingresados.",
                            html: "<b class='color-red'>Debe ingresar la dirección.</b>",
                            showConfirmButton: true,
                            timer: 4000
                        });
                $("#direccion").focus();
                validacion = false;
                return false;
            }

            if (validacion == true){
                var dataForm = $("#formCliente").serialize();
                $.ajax({
                    type: 'POST',
                    url: url,
                    dataType: 'json',
                    data: dataForm,
                    success: function(data){
                        if (data.result == "success") {
                            if (cliente == "")
                                titulo = "¡Registro exitoso!";
                            else
                                titulo = "¡Actualización exitosa!";

                            Swal.fire({
                                icon: "success",
                                title: titulo,
                                showConfirmButton: true,
                                timer: 2000
                            });
                           
                            if (tipo_cliente == "1"){
                                $("#buscar_cliente").val(numero_documento);
                                $("#nombre_cliente").val(razon_social);
                                $("#cliente").val(data.codigo);
                                $("#ruc_cliente").val(numero_documento);
                            }else{
                                $("#buscar_cliente").val(numero_documento);
                                $("#nombre_cliente").val(nombres + ' ' + apellido_paterno + ' ' + apellido_materno);
                                $("#cliente").val(data.codigo);
                                $("#ruc_cliente").val(numero_documento);
                            }
                            $("#tipo_persona").val(tipo_cliente);
                            check_doc = $("#cboTipoDocu").val()=='F' ? 1 : 0;

							if (check_doc==1) 
							{
								if (check_doc!=tipo_cliente) 
								{
									toastr.info("No es posible facturar con este Cliente, cambiando a boleta")
									tipo_per = tipo_cliente;

									if (tipo_per==1) 
									{
										$("#cboTipoDocu").val('F');
									}
									if (tipo_per==0) 
									{
										$("#cboTipoDocu").val('B');
									}	
								}
							}

                            clean();
                                


                            $("#modal_addcliente").modal("toggle");
                            $("#salir_modal_cliente").click();
                        }
                        else{
                            Swal.fire({
                                icon: "error",
                                title: "Sin cambios.",
                                html: "<b class='color-red'>" + data.message + "</b>",
                                showConfirmButton: true,
                                timer: 4000
                            });
                        }
                    },
                    complete: function(){
                        $("#addItems").focus();
                    }
                });
            }
        }
    });
}