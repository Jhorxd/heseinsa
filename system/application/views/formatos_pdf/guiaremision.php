<?php 
    $imagenBase64 = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'public/images/icons/logo.png'));
    $fondo = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'/images/img_db/'.$data['url_foto']));
    // $data['flagPdf'] : 1 => negoweb | 2 => TechSupport
    $colorHeader = ($data['flagPdf'] == 1) ? '#8dddff' : '#7fc5a4';
    $font = base_url().'assets/fonts/FreeSans.ttf';
    
?> 
<!doctype html>
<html lang="en">
  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title><?php echo $data['nameFile'] ?></title>
    <style>
        @page {
            margin-left: 0.3cm;
            margin-right: 0.5cm;
            margin-top: 1cm;
            margin-bottom: 1cm;
        }
        table{
            width: 100%;

        }
        thead{
            border-radius: 5px;
        }
        body{
            font-family: sans-serif;
            background-image: url('<?php echo $fondo ?>');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: center center;
            background-size: 100%;
            margin: 0px 0px 0px 10px;
            padding: 0px;
        }
        /* body, main, html, *{
            font-family: helvetica, Helvetica, Arial, sans-serif;
        } */
        .text-center
        {
            text-align: center;
        }
        .ruc .table tr td{
            padding: 3px auto;
            font-weight: 800;
            font-size: 17px;
        }
        .ruc{
            border: 1px solid;
            border-radius: 8px;
            border-color: #676c70;
            padding: 10px;
            margin: 2px 0px 2px 0px ;
        }
        .cliente-data, .comprobante-data, .direccion-text, .detalle, .totales, .texto, .table-footer{
            font-size: 10px;
        }
        .border{
            border: 1px solid;
            border-radius: 7px;
            border-color: #676c70;
            padding: 7px;
        }
        .direccion tr td{
            padding: 8px;
        }
        .direccion{
            border: 0px solid;
        }
        .detalle{
            padding: 0px;
            margin-top: 5px;
        }
        /*.detalle table {
            border: 1px solid; 
            border-radius: 5px; 
            border-color: #676c70;
        }*/
        .detalle table thead th{
            border-color: #676c70;
            border-right: 1px solid;
            background-color: <?php echo $colorHeader?>;
            font-style: italic;
        }
        .detalle table thead th:first-child{
            border-top-left-radius: 3px !important;
        }
        .detalle table thead th:last-child{
            border-top-right-radius: 3px !important;
            border-color: transparent;
        }
        
        .detalle table thead{
            font-size: 10px;
        }
        .detalle table tbody
        {
            border-top: 1px solid;
            padding-top: 5px;
            border-color: #676c70;
        }

        .divDetalles{
            height: 510px; 
            border-radius: 5px; 
            border-style: solid; 
            border-top-width: 1px; 
            border-right-width: 1px; 
            border-bottom-width: 1px; 
            border-left-width: 1px;
            border-color: #676c70;
        }

        .datosTrasladoTitle{
            border-bottom-width: 1px; 
            border-color: #676c70;
            border-radius: 5px; 
            border-style: solid; 
             background-color: <?php echo $colorHeader?>;
        }

        .jutify{
            /* text-align: justify; */
            font-size: 10px;
        }
        .linea
        {
            margin: 4px;
        }
        .table-footer tr td{
            padding: 3px 0px 3px 0px;
            height: 100px;
        }
        .table-redondo{
            border: 1px solid;
            border-radius: 5px;
            border-color: #676c70;
        }
        footer{
            position: absolute;
            bottom: 0;
            width: 99%;
        }
        .totales_items tr > td{
            text-align: right;
        }
        .fondo_status{
            width: 100%;
            position: absolute;
            top: 30%;
            text-align: center;
        }
        .fondo_status img{
            width: 450px;
            opacity: 0.5;
        }
        .totales{
            font-size: 10.5px !important;
        }
        table
        {
        	border-collapse: inherit;
        }
        .detalle table thead th {
        	background-color: #ced3ce;
        }

        .subtitles{
            width: 25%;
        }
    </style>
  </head>
  <body>
    <main>
        <table border="0" cellspacing ="<?php echo $data['flagPdf'] == 2 ? '0' :'0' ?>" cellpadding="0">
            <tr>
                <td style="width:67%;" class="text-center">
                   <table  class="direccion" cellspacing ="0" cellpadding="0">
                        <tr>
                            <td style="">
                                <!-- <img src="<?php echo $imagenBase64 ?>" alt="Logo" style="width: 100%;"> -->
                            </td>
                           
                        </tr>
                        <tr>
                            <?php if ($data['flagPdf'] == 1): ?>
                                <td style="text-indent:-0.1cm;">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="direccion-text text-left">GRUPO TECH LEADER SOCIEDAD ANONIMA CERRADA</div>
                                    <div class="direccion-text text-left">AV. LOS CIPRESES 140 INT. 303 - SANTA ANITA - LIMA - LIMA</div>
                                    <div class="direccion-text text-left">Web: https://negoweb.pe - Correo: hola@negoweb.pe - Telf: (01) 757-0537</div>
                                </td>
                            <?php endif ?>?>
                            
                            <?php if ($data['flagPdf'] == 2): ?>
                                <td style="text-indent:-0.1cm;">
                                    <br>
                                    <br>
                                    <br>
                                    <br>
                                    <div class="direccion-text text-left">GRUPO TECH LEADER SOCIEDAD ANONIMA CERRADA</div>
                                    <div class="direccion-text text-left">AV. LOS CIPRESES 140 INT. 303 SANTA ANITA - LIMA - LIMA</div>
                                    <div class="direccion-text text-left">Web: https://techsupport.pe - Correo: hola@techsupport.pe - Telf: (01) 757-0537</div>
                                </td>
                            <?php endif ?>?>
                            
                        </tr>
                   </table>
                </td>
                <td style="width: 33%;">
                    <div class="ruc">
                        <table class="table" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td class="text-center">
                                   <span><b>R.U.C. 20551172687</b></span>     
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <span><b><?php echo $data['tipoDocumento'] ?></b></span>     
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <span><b> <?php echo $data['serie'].' - '.$data['numero'] ?></b></span>     
                                </td>
                            </tr>
                        </table>
                    </div>
                </td>
            </tr>
        </table> 
        <table>
            <tr>
                <td colspan="2" class="cliente-data" style="width: 100%;">
                    <div class="" style="margin: 3px 1px 3px 0px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid;width: 100%;border-radius: 10px;"> 
                            <tr>
                                <td colspan="2" style="border:1px solid;padding-left: 0px;" class="datosTrasladoTitle">
                                    <b>DATOS DEL TRASLADO</b>
                                </td>
                            </tr> 

                            <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b><?php echo $data['tipoID']?></b>
                                </td>
                                <td>: <?php echo $data['ruc_cliente'] ?></td>
                            </tr> 
                            <tr>
                                <td style="padding-left: 0px; " class="subtitles">
                                    <b>DENOMINACIÓN</b>
                                </td>
                                <td >: <?php echo $data['nombres'] ?></td>
                            </tr> 																	
                                    


                            
                        </table>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="cliente-data" style="width: 100%;">
                    <div class="" style="margin: 3px 1px 3px 0px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid;width: 100%;border-radius: 10px;"> 
                            <tr>
                                <td colspan="2" style="border:1px solid;padding-left: 0px;" class="datosTrasladoTitle">
                                    <b>DATOS DEL TRASLADO</b>
                                </td>
                            </tr> 

                            <?php  
                            switch ($data["tipo_movimiento"]) {
                            	case 1:
                            		$tipo_m="VENTA";
                            		break;
                            	case 2:
                            		$tipo_m="COMPRA";
                            		break;                            	
                            	case 4:
                            		$tipo_m="TRASL. ENTRE ESTAB. DE LA MISMA EMPRESA";
                            		break;    
                            	case 8:
                            		$tipo_m="IMPORTACIÓN";
                            		break; 
                            	case 9:
                            		$tipo_m="EXPORTACIÓN";
                            		break; 
                            	case 13:
                            		$tipo_m="OTROS";
                            		break; 
                            	case 14:
                            		$tipo_m="VENTA SUJETA A CONF. DEL COMPRADOR";
                            		break; 
                            	case 18:
                            		$tipo_m="TRASLADO EMISOR ITINERANTE CP";
                            		break; 
                            	case 19:
                            		$tipo_m="TRASL. ZONA PRIMARIA";
                            		break;                             		
                            }

                            ?>


                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>FECHA EMISIÓN</b>
                                </td>
                                <td><?php echo $data["fecha"]; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>FECHA INICIO DE TRASLADO</b>
                                </td>
                                <td><?php echo $data["fecha_traslado"]; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>MOTIVO DE TRASLADO</b>
                                </td>
                                <td><?php echo $tipo_m; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>MODALIDAD DE TRANSPORTE</b>
                                </td>
                                <td><?php echo $data["modalidad_transporte"]==1?"TRANSPORTE PÚBLICO":"TRANSPORTE PRIVADO"; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>PESO BRUTO TOTAL (KGM)</b>
                                </td>
                                <td><?php echo $data["peso_total"]; ?></td>
                             </tr>
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>NÚMERO DE BULTOS</b>
                                </td>
                                <td><?php echo $data["num_bultos"]; ?></td>
                             </tr>


                        </table>
                    </div>
                </td>
            </tr>


            <tr>
                <td colspan="2" class="cliente-data" style="width: 100%;">
                    <div class="" style="margin: 3px 1px 3px 0px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid;width: 100%;border-radius: 10px;"> 
                            <tr>
                                <td colspan="2" style="border:1px solid;padding-left: 0px;" class="datosTrasladoTitle">
                                    <b>DATOS DEL PUNTO DE PARTIDA Y PUNTO DE LLEGADA</b>
                                </td>
                            </tr> 

                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>PUNTO DE PARTIDA</b>
                                </td>
                                <td><?php echo $data['punto_partida']; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>PUNTO DE LLEGADA</b>
                                </td>
                                <td><?php echo $data['punto_llegada']; ?></td>
                             </tr> 

                        </table>
                    </div>
                </td>
            </tr>


            <tr>
                <td colspan="2" class="cliente-data" style="width: 100%;">
                    <div class="" style="margin: 3px 1px 3px 0px;">
                        <table border="0" cellpadding="0" cellspacing="0" style="border:1px solid;width: 100%;border-radius: 10px;"> 
                            <tr>
                                <td colspan="2" style="border:1px solid;padding-left: 0px;" class="datosTrasladoTitle">
                                    <b>DATOS DEL TRANSPORTE</b>
                                </td>
                            </tr> 


                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>TRANSPORTISTA</b>
                                </td>
                                <td><?php echo $data['nombre_empresa_transporte']; ?> : <?php echo $data['ruc_empresa_transporte']; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>VEHÍCULO</b>
                                </td>
                                <td><?php echo $data['placa']; ?></td>
                             </tr> 
                             <tr>
                                <td style="padding-right: 0px;" class="subtitles">
                                    <b>CONDUCTOR</b>
                                </td>
                                <td><?php echo $data['nombre_conductor']." ".$data['recepciona_dni']; ?></td>
                             </tr> 

                        </table>
                    </div>
                </td>
            </tr>


        </table>    
<!--         <p class="texto jutify" style="padding-left: 7px;">
            <b> Estimados Señores:</b> <br>
            <span>Por medio de la presente, nos es grato dirigirnos a usted para haerle llegar un
                cordial saludo y a si mismo poner a su consedireración el siguiente presupuesto:</span>
        </p> -->

        <div class="detalle divDetalles" style="padding: 2px;">
            <table border="0" cellpadding="2" cellspacing="0.2" class="table table-striped">
                <thead>
                    <tr>
                        <th style="width: 10%;background-color: <?php echo $colorHeader?>;" >Nro.</th>
                        <th style="width: 10%;background-color: <?php echo $colorHeader?>;" >COD.</th>
                        <th style="width: 60%;background-color: <?php echo $colorHeader?>;" >DESCRIPCIÓN</th>
                        <th style="width: 10%;background-color: <?php echo $colorHeader?>;" >U/M</th>
                        <th style="width: 10%;background-color: <?php echo $colorHeader?>;" >CANTIDAD</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $data['detaProductos']?> 
                   
                </tbody>
            </table>
            
        </div>
            
        <footer>
            <table class="table-footer" cellpadding="2" cellspacing="3" style="margin-top:5px;">
                <tr>
                    <td style="vertical-align: top;border-top: 1px solid;">
                        <b>OBSERVACIONES</b> <br>
                        <?php echo $data['observacion'] ?>            
                    </td>  
                    
                </tr>
                <tr>
                    <td style="vertical-align: top;height: 40px!important;">
                        <p class="linea">Representación impresa de la GUIA DE REMISIÓN REMITENTE ELECTRÓNICA, para ver el documento visita https://osafact.pse.pe/<?php echo $data['empresainfo_ruc'] ?> Emitido mediante un PROVEEDOR Autorizado por la SUNAT mediante Resolución de Intendencia No.034-005-0005315</p>
                         
                    </td>  
                </tr>
            </table>
        </footer>
    
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>