<?php
class Documento_model extends Model
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
    public function seleccionar($es_comprobante=NULL)
    {
        if($es_comprobante!=NULL)
            $lista = $this->listar($es_comprobante);
        else
            $lista = $this->listar();    
        $arreglo = array(''=>':: Seleccione ::');
        foreach($lista as $indice=>$valor)
        {
            $indice1   = $valor->DOCUP_Codigo;
            $valor1    = $valor->DOCUC_Descripcion;
            $arreglo[$indice1] = $valor1;
        }
        return $arreglo;
    }
    public function listar($es_comprobante=NULL)
    {
        $compania = $this->somevar['compania'];
        $where = array("DOCUC_FlagEstado"=>"1");
        if($es_comprobante!=NULL)
            $where['DOCUC_FlagComprobante']=$es_comprobante;
        $query = $this->db->order_by('DOCUC_Descripcion')->where($where)->get('cji_documento');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    public function obtener($moneda)
    {
        $query = $this->db->where('DOCUP_Codigo',$moneda)->get('cji_documento');
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }
    
    public function obtenerAbreviatura($Abreviatura)
    {
    	$query = $this->db->where('DOCUC_ABREVI',$Abreviatura)->get('cji_documento');
    	if($query->num_rows>0){
    		foreach($query->result() as $fila){
    			$data[] = $fila;
    		}
    		return $data;
    	}
    }
    
    public function insertar(stdClass $filter = null)
    {
        $this->db->insert("cji_documento",(array)$filter);
    }
    public function modificar($id,$filter)
    {
        $this->db->where("DOCUP_Codigo",$id);
        $this->db->update("cji_documento",(array)$filter);
    }
    public function eliminar($id)
    {
        $this->db->delete('cji_documento',array('DOCUP_Codigo' => $id));
    }
    public function buscar($filter,$number_items='',$offset='')
    {
        $this->db->where("DOCUC_FlagEstado",1);
        if(isset($filter->DOCUC_Descripcion) && $filter->DOCUC_Descripcion!='')
            $this->db->like('DOCUC_Descripcion',$filter->DOCUC_Descripcion,'right');
        $query = $this->db->get('cji_documento',$number_items,$offset);
        if($query->num_rows>0){
            return $query->result();
        }
    }
}
?>