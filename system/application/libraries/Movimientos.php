<?php if ( ! defined('BASEPATH')) exit('No se permite el acceso directo al script');

###############################################################
##### METODOS GENERALES PARA REGISTRAR MOVIMIENTOS EN LA CAJA
###############################################################

class Movimientos{

	protected $ci;
	
	public function __construct(){
		$this->ci =& get_instance();

		$this->ci->load->model("tesoreria/movimiento_model");
	}

	public function guardar_movimiento($info){

		$fecha = date("Y-m-d");
		$fechaHora = date("Y-m-d H:i:s");
        $movimiento = $info->CAJAMOV_Codigo;

        $filter = new stdClass();
        $filter->CAJA_Codigo 			= $info->CAJA_Codigo;
        $filter->PAGP_Codigo 			= $info->PAGP_Codigo;
        $filter->RESPMOV_Codigo 		= $info->RESPMOV_Codigo;
        $filter->CUENT_Codigo 			= $info->CUENT_Codigo;
        $filter->MONED_Codigo 			= $info->MONED_Codigo;
        $filter->CAJAMOV_Monto 			= $info->CAJAMOV_Monto;
        $filter->CAJAMOV_MovDinero 		= $info->CAJAMOV_MovDinero;
        $filter->FORPAP_Codigo 			= $info->FORPAP_Codigo;
        $filter->CAJAMOV_FechaRecep 	= (isset($info->CAJAMOV_FechaRecep) && $info->CAJAMOV_FechaRecep != NULL) ? $info->CAJAMOV_FechaRecep : $fecha;
        $filter->CAJAMOV_Justificacion	= strtoupper($info->CAJAMOV_Justificacion);
        $filter->CAJAMOV_Observacion 	= strtoupper($info->CAJAMOV_Observacion);
        $filter->CAJAMOV_FlagEstado 	= (isset($info->CAJAMOV_FlagEstado) && $info->CAJAMOV_FlagEstado != NULL) ? $info->CAJAMOV_FlagEstado : 1;
        $filter->CAJAMOV_CodigoUsuario 	= $info->CAJAMOV_CodigoUsuario;

        if ($movimiento != ""){
            $filter->CAJAMOV_Codigo = $movimiento;
            $filter->CAJAMOV_FechaModificacion = $fechaHora;
            $result = $this->ci->movimiento_model->actualizar_movimiento($movimiento, $filter);
        }
        else{
            $filter->CAJAMOV_FechaRegistro = $fechaHora;
            $result = $this->ci->movimiento_model->insertar_movimiento($filter);
        }

        return $result;
    }
}

?>