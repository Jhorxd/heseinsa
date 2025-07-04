<!doctype html>
<html lang="ES">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>REPORTE CONSOLIDADO DE VENTAS</title>
    <?php 
      $logoMain = getConvertPDFToBase64('images/img_db/comprobante_orden_recepcion.jpg');
      $numberDocumento = ($cliente->tipo == 1) ? $cliente->ruc : $cliente->dni;
      $fecha = formatDate($row->OCOMC_Fecha);
      $fechaHoy = date('d/m/Y');
    ?>
    <style>
      html{
        font-family: 'helvetica' !important;
        margin: 20px 25px;
      }
      body{
        font-size: 7pt;
        font-family: 'helvetica' !important;
      }
      .center{
        text-align: center;
      }
      .width100 {
        width: 100%;
      }
      .bold, label{
        font-weight: 500;
        font-family: 'helvetica' !important;
        
      }
      .bold{

        background-color: #e1e1e1;
      }
      .right
      {
        text-align: right;
      }
      table{
        width: 100%;
        font-family: 'helvetica' !important;
      }
      table tr td{
        font-family: 'helvetica' !important;
        padding: 3px 5px;
      }
      p{
        margin: 5px;
      }
      #tbTableMain thead tr td, #tbTableMain tfoot tr td{
        padding: 7px;
        font-family: 'helvetica' !important;
      }
      #tbTableMain tbody tr td{
        padding: 5px;
      }
      .page_break{ page-break-before: always; }

      .grid
      {
        display: grid;
      }
    </style>
  <link rel="stylesheet" href="<?php base_url()?>css/grid12.css">
  </head>
  <body>
    <table border="0" cellspacing="0" cellspacing="0">
      <tr>
        <td class="bold center"><h3 style="margin: 0;">REPORTE DE DE VENTAS DEL DIA</h3></td>
      </tr>
    </table>

    <table border="0" cellspacing="0" cellspacing="0" style="margin-bottom: 5px;">
      <tr>
        <td style="width: 100%;" colspan="2">
            <label>EMPRESA: </label> <?php echo isset($datos_empresa[0]->EMPRC_RazonSocial) ? $datos_empresa[0]->EMPRC_RazonSocial : '' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;" colspan="2">
          <label>RUC: </label> <?php echo isset($datos_empresa[0]->EMPRC_Ruc) ? $datos_empresa[0]->EMPRC_Ruc : '' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;" colspan="2">
          <label>LOCAL: </label> 
          <?php echo isset($establecimiento[0]->EESTABC_Descripcion) ? $establecimiento[0]->EESTABC_Descripcion: '-' ?>
        </td>
      </tr>
      <tr>
        <td style="width: 100%;">
          <label>FECHA: </label> <?php echo mysql_to_human($fecha1).' - '.mysql_to_human($fecha2)?>
        </td>
      </tr>
    </table>

    <table border="1" cellspacing="0" cellspacing="0" id="tbTableMain"> 
      <thead>
        <tr>
            <td class="bold center" colspan="7">COMPROBANTES</td>
        </tr>
        <tr style="background-color: #e1e1e1;">
          <td style="width: 7%;" class="center">
            <label>TIPO</label>   
          </td>
          <td style="width: 7%;" class="center">
            <label>SERIE</label>   
          </td>
          <td style="width: 8%;" class="center">
            <label>NUM DOC</label>
          </td>
          <td style="width: 18%;" class="center">
            <label>DENOMINACIÓN</label>   
          </td>
          <td style="width: 7%;" class="center">
            <label>MONEDA</label>   
          </td>
          <td style="width: 8%;" class="center">
            <label>TOTAL</label>   
          </td>
          <td style="width: 12%;" class="center">
            <label>FORMA PAGO</label>   
          </td>
        </tr>
      </thead>
      <tbody style="font-size:7pt !important">
        <?php 
        $totalCPPSol = 0;
        $totalCPPDol = 0;
        foreach ($data as $key => $row) {
            switch ($row->CPC_TipoDocumento) {
                case 'F':
                    $typeName = 'FACTURA';
                    break;
                case 'B':
                    $typeName ='BOLETA';
                    break;
                default:
                    $typeName ='COMPROBANTE';
                    break;
            }
          ?>
          <tr class="center">
            <td style="border-bottom: none;border-top: none;"><?php echo $typeName ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $row->CPC_Serie.'-'.$row->CPC_Numero ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $row->numero_documento_cliente ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo $row->razon_social_cliente ?></td>
            <td style="border-bottom: none;border-top: none;"><?php echo '('.$row->MONED_Simbolo.') '.$row->MONED_Descripcion ?></td>
            <td style="border-bottom: none;border-top: none;">
                <?php
                    echo $row->CPC_total;
                    $totalCPPSol += ($row->MONED_Codigo == 1) ? $row->CPC_total : 0;
                    $totalCPPDol += ($row->MONED_Codigo == 2) ? $row->CPC_total : 0;
                ?>
            </td>
            <td style="border-bottom: none;border-top: none;"><?php echo $row->FORPAC_Descripcion ?></td>
          </tr>
        <?php } ?>
      </tbody>
      <tfoot>
        <tr class="bold">
            <td colspan="5"></td>
            <td colspan="2">
                <label>TOTAL (S/.): </label> <?php echo $totalCPPSol ?>
            </td>
        </tr>
        <tr class="bold">
            <td colspan="5"></td>
            <td colspan="2"> 
                <label>TOTAL (US$): </label> <?php echo $totalCPPDol ?>
            </td>
        </tr>
      </tfoot>
    </table>

    <?php
        $formas=[];

        foreach ($data as $key1 => $cpp) 
        {
            $rowFP = $db->Comprobante_formapago_model->getList($cpp->CODCPC, 0 , true);
            foreach ($rowFP as $key2 => $rowOneFP) 
            {
                $indice = array_search($rowOneFP->FORPAP_Codigo, array_column($formas, 'Codigo'));
                $montoS = ($rowOneFP->MONED_Codigo == 1) ? $rowOneFP->monto : 0;
                $montoD = ($rowOneFP->MONED_Codigo == 2) ? $rowOneFP->monto : 0;

                if ($indice > -1){
                    $formas[$indice]["MontoS"] += $montoS;
                    $formas[$indice]["MontoD"] += $montoD;
                } else
                {
                    $datas=["Codigo"=>$rowOneFP->FORPAP_Codigo,"Nombre"=>$rowOneFP->FORPAC_Descripcion,"MontoS"=> $montoS, "MontoD" =>$montoD];
                    array_push($formas, $datas);
                }
            }            
        }
    ?>

    <br><br>
    <table border="1" cellspacing="0" cellspacing="0" style="width: 50%;">
        <tr>
            <th colspan="3">TOTALES</th>
        </tr>
        <tr>
            <th>MEDIO DE PAGO</th>
            <th>SOLES</th>
            <th>DOLARES</th>
        </tr>

        <?php 
        $totalSoles = 0; $totalDolares = 0;
        foreach ($formas as $key => $form) { ?>
            <tr>
                <td>
                    <?php echo $form['Nombre']; ?>
                </td>
                <td class="center">
                    <?php 
                        echo number_format($form['MontoS'], 2);
                        $totalSoles += $form['MontoS'];
                    ?>
                </td>
                <td class="center">
                    <?php 
                        echo number_format($form['MontoD'], 2);
                        $totalDolares += $form['MontoD'];
                    ?>
                </td>
            </tr>
        <?php } ?>
        <tr>
            <th>TOTALES</th>
            <th>
                <?php echo number_format($totalSoles, 2) ?>
            </th>
            <th>
                <?php echo number_format($totalDolares, 2) ?>
            </th>
        </tr>
    </table>
  </body>        
</html>