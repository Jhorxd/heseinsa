<?php

class Guiatransdetalle_Model extends Model
{
    protected $_name = "cji_guiatransdetalle";

    public function  __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('user');
    }

    public function listar($guiatrans_id)
    {
        $where = array("GTRANP_Codigo" => $guiatrans_id);
        $query = $this->db->where($where)->order_by('GTRANDETP_Codigo')->get('cji_guiatransdetalle');
        if ($query->num_rows > 0) {
            return $query->result();
        } else
            return NULL;
    }

    public function update($filter){

        //$this->db->where('GTRANP_Codigo', $filter->GTRANP_Codigo);
        $datos = array(
            'PROD_Codigo' => $filter->PROD_Codigo,
            'UNDMED_Codigo' => $filter->UNDMED_Codigo,
            'GTRANDETC_Cantidad' => $filter->GTRANDETC_Cantidad,
            'GTRANDETC_Costo' => $filter->GTRANDETC_Costo,
            'GTRANDETC_GenInd' => $filter->GTRANDETC_GenInd,
            'GTRANDETC_Descripcion' => $filter->GTRANDETC_Descripcion,
            'GTRANDETC_FlagEstado' => $filter->GTRANDETC_FlagEstado
        );
        $valor = $this->db->insert('cji_guiatransdetalle', $datos);
        return $valor;
    }

    public function eliminar($guiatrans){
        $this->db->where('GTRANP_Codigo', $guiatrans);
        $valor = $this->db->delete('cji_guiatransdetalle');
        return $valor;
    }

    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_guiatransdetalle", (array)$filter);
    }

}

?>