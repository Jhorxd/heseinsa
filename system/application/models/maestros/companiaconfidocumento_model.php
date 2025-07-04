<?php
class Companiaconfidocumento_model  extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/compania_model');
        $this->somevar ['compania']  = $this->session->userdata('compania');
        $this->somevar ['usuario']   = $this->session->userdata('usuario');
        $this->somevar['hoy']        = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function obtener($comp_confi, $documento)
    {
        $where = array("COMPCONFIP_Codigo"=>$comp_confi,"DOCUP_Codigo"=>$documento,"COMPCONFIDOCP_FlagEstado"=>"1");
        $query = $this->db->where($where)->get('cji_companiaconfidocumento');
        if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
        }
    } 
    
    public function modificar($codigo,$companiadato,$filter=null)
    {
        //$compania = $this->somevar['compania'];
    	$where = array("COMPCONFIDOCP_Codigo"=>$codigo,"COMPCONFIP_Codigo"=>$companiadato);
    	$this->db->where($where);
    	$this->db->update('cji_companiaconfidocumento',(array)$filter);
    }
}
?>