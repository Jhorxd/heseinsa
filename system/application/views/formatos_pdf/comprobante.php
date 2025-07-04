<?php 
    $imagenBase64 = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'public/images/icons/logo.png'));
    $fondo = "data:image/png;base64,".base64_encode(file_get_contents(base_url().'/images/img_db/'.$data['url_foto']));
    // $data['flagPdf'] : 1 => negoweb | 2 => TechSupport
    $colorHeader = ($data['flagPdf'] === 1) ? '#3ac5f9' : '#5bb58a';
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
                                    <span><b> <?php echo $data['serie'].' - '.$data['numero_parse'] ?></b></span>     
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
                                <td style="padding-left: 0px;width: 20%;">
                                    <b><?php echo $data['tipoID']?></b>
                                </td>
                                <td>: <?php echo $data['ruc_cliente'] ?></td>
                            </tr> -->
                            <tr>
                                <td style="padding-left: 0px; width: 13%;">
                                    <b>SEÑOR (A)</b>
                                </td>
                                <td colspan="3">: <?php echo $data['nombres'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>ATENCIÓN</b></td>
                                <td colspan="3">: <?php echo $data['contacto'][0]->ECONC_Descripcion?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>TELÉFONO</b></td>
                                <td colspan="3">: <?php echo $data['contacto'][0]->ECONC_Telefono ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>CORREO</b></td>
                                <td colspan="3">: <?php echo $data['contacto'][0]->ECONC_Email ?></td>
                            </tr>
                        </table>
                    </div>
                </td>
                <td class="comprobante-data" style="width: 33%;">
                    <div class="border" style="margin: 1px 0px 1px 2px;">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td style="padding-left: 0px; width: 40%;"><b>FECHA EMISIÓN</b></td>
                                <td>: <?php echo $data['fecha'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>FECHA VENC.</b></td>
                                <td>: <?php echo $data['fecha_vencimiento'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>MONEDA</b></td>
                                <td>: <?php echo $data['moneda_nombre'] ?></td>
                            </tr>
                            <tr>
                                <td style="padding-left: 0px;"><b>FORMA DE PAGO</b></td>
                                <td>: <?php echo $data['nombre_formapago'] ?></td>
                            </tr>
                            <!-- <tr>
                                <td>
                                    <br>
                                </td>
                                <td>
                                    <br>
                                </td>
                            </tr> -->
                        </table>
                    </div>
                </td>
            </tr>
        </table>    
        <p class="texto jutify" style="padding-left: 7px;">
            <b> Estimados Señores:</b> <br>
            <span>Por medio de la presente, nos es grato dirigirnos a usted para haerle llegar un
                cordial saludo y a si mismo poner a su consedireración el siguiente presupuesto:</span>
        </p>

        <div class="detalle divDetalles" style="">
            <table border="0" cellpadding="2" cellspacing="0.2">
                <thead>
                    <tr>
                        <th>ITEM</th>
                        <th>CÓDIGO</th>
                        <th style="width: 40%;">DESCRIPCIÓN</th>
                        <th>CANTIDAD</th>
                        <th>PRECIO UNIT</th>
                        <th style="border-right: 0px solid;">PRECIO TOTAL</th>
                    </tr>
                </thead>
                <tbody>
                    <?php echo $data['detaProductos']?> 
                   
                </tbody>
            </table>
            
        </div>
            
        <footer>
            <table border="0" class="totales" cellpadding="0" cellspacing="0" class="texto">
                <tr>
                    <td style="width:70%;"><p style="margin: 6px 0 2px 0;"><b class="texto">Son: <?php echo $data['totalesHTML'] ?></b></p></td>
                    <td style="width:30%;">
                        <table border="0" cellpadding="0" cellspacing="0" style="margin-right: 30px;">
                            <?php if (!empty($data['descuento']) && $data['descuento']>0) : ?>
                                <tr>
                                    <th style="text-align: right;width:50%">Descuento</th>
                                    <th style="text-align: right;width:6%"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;width:15%; padding-right: 3px;">
                                        <?php echo number_format($data['descuento'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['exonerado'])) : ?>
                                <tr>
                                    <td style="text-align: right;">Exonerado</td>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['exonerado'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['inafecto'])) : ?>
                                <tr>
                                    <td style="width:3.0cm; text-align:right; font-style:italic;">Inafecto</td>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="width:2.0cm; text-align:right;padding-right: 3px;"><? echo number_format($data['inafecto'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['gravada'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Gravado</th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['gravada'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['igv'])) : ?>
                                <tr>
                                    <th style="text-align: right;">18% IGV</th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['igv'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <?php if (!empty($data['gratuito'])) : ?>
                                <tr>
                                    <th style="text-align: right;">Gratuito</th>
                                    <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?></th>
                                    <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['gratuito'], 2)?></th>
                                </tr>
                            <?php endif; ?>
                            <tr>
                                <th style="text-align: right;">Total</th>
                                <th style="text-align: right;"><?php echo $data['simbolo_moneda'] ?> </th>
                                <th style="text-align: right;padding-right: 3px;"><?php echo number_format($data['total'], 2)?></th>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <table class="table-footer" cellpadding="2" cellspacing="3" style="margin-top:5px;">
                <tr>
                    <td style="width: 60%; vertical-align: top;" class="table-redondo">
                        <b>OBSERVACIONES</b> <br>
                        <?php echo $data['observacion'] ?>            
                    </td>  
                    <td style="width: 40%;" class="table-redondo">
                        <b>Cuentas Corrientes</b> 
                        <table border="0" class="totales" cellpadding="1" cellspacing="0" style="width: 100%;margin: 0 auto;" >
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
                <tr>
                    <td style="vertical-align: top;" class="table-redondo">
                        <p class="linea"><b>Garantía: </b> <?php echo $data['garantia'] ?></p>
                        <p class="linea"><b>Tiempo de entrega: </b> <?php echo $data['tiempo_entrega'] ?></p>  
                        <p class="linea"><b>Lugar de entrega: </b> <?php echo $data['lugar_entrega'] ?></p>      
                    </td>  
                    <td style="vertical-align: top;" class="table-redondo">
                        <p class="linea"><b>Ejecutivo: </b> <?php echo $data['miPersonal'] ?></p>  
                        <p class="linea"><b>Celular: </b> <?php echo $data['datos_ocompra'][0]->PERSC_Telefono. ' / ' .$data['datos_ocompra'][0]->PERSC_Movil ?></p>
                        <p class="linea"><b>Correo: </b> <?php echo $data['datos_ocompra'][0]->PERSC_Email ?></p>  
                        
                    </td>
                </tr>
            </table>
        </footer>
    
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>