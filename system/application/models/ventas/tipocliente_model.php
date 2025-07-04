<?php

class Tipocliente_model extends Model{

    private $compania;

    public function __construct(){
        parent::__construct();
        $this->load->helper('date');
        $this->somevar['compania'] = $this->session->userdata('compania');
        $this->somevar['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s",time());

        $this->compania = $this->session->userdata('compania');
    }

    #########################
    ##### FUNCTIONS NEWS
    #########################

        public function getCategorias($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND tp.TIPCLIC_Descripcion LIKE '%$filter->descripcion%'";

            //$sql = "SELECT tp.* FROM cji_tipocliente tp WHERE tp.TIPCLIC_FlagEstado LIKE '1' AND tp.COMPP_Codigo = $this->compania $where $order $limit";
            
            //PRECIO PARA TODAS LAS COMPP
            $sql = "SELECT tp.* FROM cji_tipocliente tp WHERE tp.TIPCLIC_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0) {
                return $query->result();
            }
            return array();
        }

        public function getCategoria($codigo) {

            $sql = "SELECT tp.* FROM cji_tipocliente tp WHERE tp.TIPCLIP_Codigo = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0) {
                return $query->result();
            }
            return array();
        }

        public function insertar_categoria($filter){
            $this->db->insert("cji_tipocliente", (array) $filter);
            return $this->db->insert_id();
        }

        public function actualizar_categoria($categoria, $filter){
            $this->db->where('TIPCLIP_Codigo',$categoria);
            return $this->db->update('cji_tipocliente', $filter);
        }

        public function deshabilitar_categoria($categoria, $filter){

            $this->db->where('TIPCLIP_Codigo',$categoria);
            $query = $this->db->update('cji_tipocliente', $filter);

            if ($query){
                $sql = "DELETE FROM cji_productoprecio WHERE TIPCLIP_Codigo = $categoria";
                $this->db->query($sql);
            }

            return $query;
        }

    #########################
    ##### FUNCTIONS OLDS
    #########################
    
        public function listar(){
            $compania = $this->somevar['compania'];
            $this->db->where('COMPP_Codigo ', $compania)->where('TIPCLIC_FlagEstado','1');
            $this->db->where_not_in('TIPCLIP_Codigo','0')->order_by('TIPCLIC_Descripcion');
            $query = $this->db->get('cji_tipocliente');
            if($query->num_rows>0){
               return $query->result();
            }
        }

        public function obtener($id){
            $where = array("TIPCLIP_Codigo"=>$id,"TIPCLIC_FlagEstado"=>"1");
            $query = $this->db->where($where)->get('cji_tipocliente');
            if($query->num_rows>0){
                    foreach($query->result() as $fila){
                            $data[] = $fila;
                    }
                    return $data;
            }
        }

        public function buscar($filter,$number_items='',$offset=''){
            $this->db->where('COMPP_Codigo',$this->somevar['compania']);
            if(isset($filter->TIPCLIC_Descripcion) && $filter->TIPCLIC_Descripcion!="")
                $this->db->like('TIPCLIC_Descripcion',$filter->TIPCLIC_Descripcion);
            
            $query = $this->db->where_not_in('TIPCLIP_Codigo','0')->order_by('TIPCLIC_Descripcion');
            $query = $this->db->get('cji_tipocliente',$number_items,$offset);
            if($query->num_rows>0){
                foreach($query->result() as $fila){
                        $data[] = $fila;
                }
                return $data;
            }
        }
 
}
?>