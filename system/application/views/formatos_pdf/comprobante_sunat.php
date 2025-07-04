<?php 
    $imagenBase64 = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'public/images/icons/logo.png'));
    $fondo = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'/images/img_db/'.$data['url_foto']));
    $statusFondo = "data:image/png;base64,".base64_encode(file_get_contents($data['imagen_fondo']));
    $colorHeader = ($data['flagPdf'] === 1) ? '#8dddff' : '#7fc5a4';
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
    </style>
  </head>
  <body>
    <main>
        <table border="0" cellspacing ="<?php echo $data['flagPdf'] == 2 ? '2' :'0' ?>" cellpadding="0">
            <tr>
                <td style="width: 67%;" class="text-center">
                   <table  class="direccion" cellspacing ="" cellpadding="">
                        <tr>
                            <td style="">
                                <!--<img src="<?php echo $imagenBase64 ?>" alt="Logo" style="width: 100%;">-->
                            </td>
                           
                        </tr>
                        <tr>
                            <td style="">
                                <!--<img src="<?php echo $imagenBase64 ?>" alt="Logo" style="width: 100%;">-->
                                <div class="direccion-text text-left"></div>
                            </td>
                            
                        </tr>
                        <tr>
                            <?php if ($data['flagPdf'] == 1): ?>
                                <td style="text-indent:-0.1cm;">
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
                                   <span><b>R.U.C. <?php echo $data['empresaRUC'] ?></b></span>     
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
            <tr>
                <td class="cliente-data" style="width: 67%;">
                    <div class="border" style="margin: 3px 1px 3px 0px;">
                        <table border="0" cellpadding="0" cellspacing="0"> 
                            <!-- <tr>
                                <td style="padding-left: 0px;width: 22%;" >
                                    <b><?php echo $data['tp']?></b>
                                </td>
                                <td>: <?php echo $data['idCliente'] ?></td>
                            </tr> -->
                            <tr>
                                <td style="padding-left: 0px;width: 22%;">
                                    <b><?php echo $data['tipoID']?><b>
                                </td>
                                <td>: <?php echo $data['ruc'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>DENOMINACIÓN</b></td>
                                <td>: <?php echo $data['nombre_cliente']?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>DIRECCIÓN</b></td>
                                <td>: <?php
                                    $break = strlen($data['direccion']) >= 50 ? '</br>' : '';
                                    echo $data['direccion']; ?>
                                </td>
                            </tr>
                            <tr>
                                <td rowspan="2"><br></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="comprobante-data" style="width: 33%;">
                    <div class="border" style="margin: 1px 0px 1px 1px;">
                        <table border="0" cellpadding="0" cellspacing="0" >
                            <tr>
                                <td style="padding-left: 0px;width: 43%;"><b>FECHA EMISIÓN</b></td>
                                <td>: <?php echo $data['fecha'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: px;"><b>FECHA VENC.</b></td>
                                <td>: <?php echo $data['fecha_vencimiento'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: px;"><b>MONEDA</b></td>
                                <td>: <?php echo $data['moneda_nombre'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>FORMA DE PAGO</b></td>
                                <td>: <?php echo $data['formapago_desc'] ?></td>
                            </tr>
                            <!-- <tr>
                                <td style="padding-left: 15px;"><br></td>
                                <td><br></td>
                            </tr> -->
                        </table>
                    </div>
                </td>
            </tr>
        </table>    
        <div class="detalle divDetalles" style="">
        <?php $colorHeader = ($data['flagPdf'] === 1) ? '#3ac5f9' : '#5bb58a'; ?>
            <table border="0" cellpadding="2" cellspacing="0.2">
                <thead>
                    <tr>
                        <th style="border-right: 1px solid;width:6%;">CANT.</th>
                        <th style="border-right: 1px solid;">CÓDIGO</th>
                        <th style="border-right: 1px solid;width: 50%;">DESCRIPCIÓN</th>
                        <!--<th style="border-right: 1px solid;">MARCA</th>-->
                        <th style="border-right: 1px solid;">V/U</th>
                        <th style="border-right: 1px solid;">P/U</th>
                        <th>IMPORTE</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $data['detaProductos']?> 
                    
                </tbody>
            </table>
           
        </div>

        <div class="fondo_status">
            <?php if($data['estado']==2 || $data['estado']==0){ ?>
                
                <img src="<?php echo $statusFondo?>" alt="fondo status">

            <?php } ?>
        </div>

        <footer>
            <table>
                <tr>
                    <td style="width:70%;"> <p style="margin: 6px 0 2px 0;"><b class="texto">IMPORTE EN LETRAS:: <?php echo $data['totalesHTML'] ?></b></p></td>
                    <td style="width:30%;" class="texto">
                        <table class="totales_items" border="0" cellpadding="0" cellspacing="1" style="margin-bottom: 5px;">
                            <?php 
                            if (!empty($data['descuento']) and $data['descuento'] > 0) : ?>
                                <tr>
                                    <th style="width:50%; text-align: right;">Descuento <?=$data['por_descuento'];?>%</th>
                                    <th style="width:6%;text-align: right;"><?=$data['simbolo_moneda'] ?></th>
                                    <th style="width:15%;text-align: right;padding-right: 3px;"><?php echo number_format($data['descuento'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['exonerado'])) : ?>
                                <tr>
                                    <td style="text-align: right;">Exonerado </td>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['exonerado'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['inafecto'])) : ?>
                                <tr>
                                    <td style="width:3.0cm; text-align:right; font-style:italic;">Inafecto </td>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="width:2.0cm; text-align:right;padding-right: 3px;"><? echo number_format($data['inafecto'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['gravada'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Gravado </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['gravada'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['igv'])) : ?>
                                <tr>
                                    <th style="text-align: right;">18% IGV </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['igv'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['gratuito'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Gratuito </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['gratuito'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['importeBolsa'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Impuesto bolsa </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['importeBolsa'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th style="text-align: right;">Total </th>
                                <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?> </th>
                                <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['total'], 2)?></th>
                            </tr>
                            <?php if (!empty($data['retencionDetHTML'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Retencion 3% </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['total_retencion'], 2)?></th>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Neto a pagar </th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['total_neto_con_retencion'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['detraccion'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Detraccion <?php echo $data['detraccion_porcentaje'];?></th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['detraccion_total'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </td>
                </tr>
            </table>
            <?php if (!empty($data['detraccion'])) : ?>
                <table border="0" class="totales" cellpadding="1" cellspacing="2" style="width: 100%;">
                    <tr><td> <?php echo $data['cuenta_detraccion'];?></td></tr>
                </table>
            <?php endif; ?>
            <table border="0" class="totales" cellpadding="1" cellspacing="2" style="width: 100%;">
                <tr>
                    <td style="width: 60%; text-align: left; margin-left: 5px;" class="table-redondo">
                        <table class="texto" border="0" cellpadding="2" cellspacing="1" 
                            style="width: 100%; 
                            border-radius: 5px;
                            padding: 4px;">
                            <?php if ($data['guiaRemision'] != '') :?> 
                                <tr>
                                    <td style="text-align:right; width: 30%;"><b>GUIA DE REMISIÓN: </b></td>
                                    <td style="width: width: 60%;"> <?php echo $data['guiaRemision'] ?></td>
                                </tr>
                            <?php endif ?> 
                            <?php if ($data['serieOC'] != '') :?> 
                                <tr>
                                    <td style="text-align:right; width: 30%;"><b>COTIZACIÓN: </b></td>
                                    <td style="width: 60%;"> <?php echo $data['serieOC'] ?></td>
                                </tr>
                            <?php endif ?> 
                            <?php if ($data['ordenCompraCliente'] != '') :?> 
                                <tr>
                                    <td style="text-align:right;width: 30%;"><b>ORDEN DE COMPRA:</b></td>
                                    <td style="width: 60%;"> <?php echo $data['ordenCompraCliente'] ?></td>
                                </tr>
                            <?php endif ?> 
                            <?php if ($data['observacion'] != '') :?> 
                                <tr>
                                    <td style="text-align:right;width: 30%;"><b>OBSERVACIÓN:</b></td>
                                    <td style="width: 60%;"> <?php echo $data['observacion'] ?></td>
                                </tr>
                            <?php endif ?> 
                            <?php if ($data['tiene_cuotas'] != "" || $data['condiciones_de_pago'] !="") :?> 
                                <tr style="font-size: 9px !important;">
                                    <td style="text-align:right; width:30%;"><b>CONDICIONES DE PAGO:</b></td>
                                    <td style="width: 60%;text-transform: uppercase;"><?php echo $data['condiciones_de_pago'].''.$data['tiene_cuotas'] ?></td>
                                </tr>
                            <?php endif ?> 
                        </table>
                    </td>
                    <td style="width: 40%; padding-left: 10px;" class="table-redondo">
                       <table border="0" class="totales" cellpadding="1" cellspacing="0" style="width: 100%;margin: 0 auto;" >
                        <tr><td><b>Cuentas Corrientes</b></td>
                            
                        </tr>
                            <tr>
                                <td style="text-align:left;">Soles BCP:</td>
                                <td style="text-align:left;">191-2083833-0-16</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">CCI: </td>
                                <td style="text-align:left;">00219100208383301653</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Dólares BCP:</td>
                                <td style="text-align:left;">191-2620551-1-21</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">CCI:</td>
                                <td style="text-align:left;">00219100262055112150</td>
                            </tr>
                            <tr>
                                <td style="text-align:left;">Detracciones:</td>
                                <td style="text-align:left;">00072070968</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="table-footer" border="0" cellpadding="3" cellspacing="2.5">
                <tr>
                    <td style="width: 85%; vertical-align: top; padding: 5px;" class="table-redondo">
                        <p>
                            Representación impresa de PDF FACTURA ELECTRONICA, para ver el documento 
                            visita https://osafact.pse.pe/<?php echo $data['empresaRUC'] ?>
                            Emitido mediante un PROVEEDOR Autorizado por la SUNAT mediante Resolución 
                            de Intendencia No.034-005-0005315
                        </p>   
                    </td>  
                    <td style="width: 15%;" class="table-redondo">
                        <?php echo $data['codeQR'] ?>
                    </td>
                </tr>
            </table>
        </footer>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>