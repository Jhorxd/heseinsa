<?php
class Sectorcomercial_model extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario']  = $this->session->userdata('usuario');
        $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
    }
    public function listar($number_items='',$offset='')
    {
        $where = array("SECCOMC_FlagEstado"=>"1");
        $query = $this->db->order_by('SECCOMC_Descripcion')->where_not_in('SECCOMP_Codigo','0')->where($where)->get('cji_sectorcomercial',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
   
}
?>