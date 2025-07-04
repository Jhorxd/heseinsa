<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

function cambiar_moneda($monto, $tdc, $moneda, $moneda_destino)
{
    $resultado = $monto;

    if ($moneda == $moneda_destino) {
        $resultado = $monto;
    }
    else if ($moneda == '1') {
        $resultado = round($monto / $tdc, 2);
    }
    else {
        $resultado = round($monto * $tdc, 2);
    }
    return $resultado;
}

function obtener_estado_formato($total, $avance)
{
    $result = '';
    if ($total == $avance)
        $result = "<div style='width:70px; height:17px; background-color: #00D269; text-align:center; cursor:help;' title='Cancelado'>Cancelado</div>_|_Cancelado";
    elseif ($avance == 0)
        $result = "<div style='width:70px; height:17px; background-color: #FF6464; text-align:center; cursor:help;' title='Pendiente'>Pendiente</div>_|_Pendiente";
    else
        $result = "<div style='width:70px; height:17px; background-color: #FFB648; text-align:center; cursor:help;' title='Pendiente con Avance'>Pendiente (AV)</div>_|_Pendiente";

    return $result;
}

function obtener_forma_pago($forma_pago)
{
    $result = '';
    switch ($forma_pago) {
        case '1' :
            $result = 'EFECTIVO';
            break;
        case '2' :
            $result = 'DEPOSITO';
            break;
        case '3' :
            $result = 'CHEQUE';
            break;
        case '4' :
            $result = 'CANJE POR FACTURA';
            break;
        case '5' :
            $result = 'NOTA DE CREDITO';
            break;
        case '6' :
            $result = 'DESCUENTO';
            break;
    }
    return $result;
}

?>
