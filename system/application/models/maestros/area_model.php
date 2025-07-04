<?php
class Area_model extends Model
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
    public function listar_areas($number_items='',$offset='')
    {
        $compania = $this->somevar['compania'];
        $where = array("COMPP_Codigo"=>$compania,"AREAC_FlagEstado"=>"1");
        $query = $this->db->order_by('AREAC_Descripcion')->where_not_in('AREAP_Codigo','0')->where($where)->get('cji_area',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener_area($area)
    {
        $query = $this->db->where('AREAP_Codigo',$area)->get('cji_area');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function insertar_area($descripcion)
    {
        $compania = $this->somevar['compania'];
        $data = array(
                    "AREAC_Descripcion" => strtoupper($descripcion),
                    "COMPP_Codigo"      => $compania
                );
        $this->db->insert("cji_area",$data);
    }
    public function modificar_area($area,$descripcion)
    {
        $data  = array("AREAC_Descripcion"=>strtoupper($descripcion));
        $this->db->where("AREAP_Codigo",$area);
        $this->db->update('cji_area',$data);
    }
    public function eliminar_area($area)
    {
        $where = array("AREAP_Codigo"=>$area);
        $this->db->delete('cji_area',$where);
    }
    public function buscar_areas($filter,$number_items='',$offset='')
    {
        $this->db->where('COMPP_Codigo',$this->somevar['compania']);
        $this->db->where_not_in('AREAP_Codigo','0');
        if(isset($filter->nombre_area) && $filter->nombre_area!="")
            $this->db->like('AREAC_Descripcion',$filter->nombre_area,'both');
        $query = $this->db->get('cji_area',$number_items,$offset);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                    $data[] = $fila;
            }
            return $data;
        }
    }
}
?>