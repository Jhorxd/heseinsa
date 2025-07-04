<?php

class Companiaconfiguracion_model extends Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/compania_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function obtener($compania) {
        $where = array("COMPP_Codigo" => $compania, "COMPCONFIC_FlagEstado" => "1");
        $query = $this->db->where($where)->get('cji_companiaconfiguracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function listar($comp) {
        $where = '';
        if ($comp == '1') {
            $where = array("COMPCONFIC_FlagEstado" => "1", "COMPCONFIC_Cliente" => "1");
        } else if ($comp == '2') {
            $where = array("COMPCONFIC_FlagEstado" => "1", "COMPCONFIC_Proveedor" => "1");
        } else if ($comp == '3') {
            $where = array("COMPCONFIC_FlagEstado" => "1", "COMPCONFIC_Producto" => "1");
        } else if ($comp == '4') {
            $where = array("COMPCONFIC_FlagEstado" => "1", "COMPCONFIC_Familia" => "1");
        }
        $query = $this->db->where($where)->get('cji_companiaconfiguracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function modificar($compania, $igv, $contiene_igv, $determinaprecio) {
        $data = array("COMPCONFIC_Igv" => $igv,
            "COMPCONFIC_PrecioContieneIgv" => $contiene_igv,
            "COMPCONFIC_DeterminaPrecio" => $determinaprecio
        );
        $where = array("COMPP_Codigo" => $compania);
        $this->db->where($where);
        $this->db->update('cji_companiaconfiguracion', $data);
    }
    
    public function inventario_inicial($compania){
        $this->db->select('COMPCONFIC_InventarioInicial')->where('COMPP_Codigo',$compania);
        $query=  $this->db->get('cji_companiaconfiguracion');
        if($query->num_rows>0){
            return $query->result();
        }
    }

    public function modificar_compartido($compania, $cliente, $proveedor, $producto, $familia) {
        $data = array("COMPCONFIC_Cliente" => $cliente,
            "COMPCONFIC_Proveedor" => $proveedor,
            "COMPCONFIC_Producto" => $producto,
            "COMPCONFIC_Familia" => $familia
        );
        $where = array("COMPP_Codigo" => $compania);
        //$this->db->where($where);
        $verdadero=$this->db->update('cji_companiaconfiguracion', $data);
        
        if ($verdadero) {
            return $verdadero;
        }else{
            return null;
        }
    }

    public function modificar_mov_stock($compania, $s_comprobante, $s_guia) {
        $data = array(
            "COMPCONFIC_StockComprobante" => $s_comprobante,
            "COMPCONFIC_StockGuia" => $s_guia
        );
        $where = array('COMPP_Codigo' => $compania);
        $this->db->where($where);
        $this->db->update('cji_companiaconfiguracion', $data);
    }

    public function modificar_inventario_inicial($compania, $inventario_inicial) {
        $data = array(
            "COMPCONFIC_InventarioInicial" => $inventario_inicial,
        );
        $where = array('COMPP_Codigo' => $compania);
        $this->db->where($where);
        $this->db->update('cji_companiaconfiguracion', $data);
    }
public function get_monedalist($codigo,$codigoDocumento){
     $tabla="";
     $where="";
    if($codigoDocumento==1){
        $tabla='cji_pedido c';
        $where= 'c.PEDIP_Codigo='.$codigo;
    }else {
       $tabla='cji_comprobante c'; 
       $where= 'c.CPP_Codigo='.$codigo;
    }
    $sql='SELECT m.MONED_Simbolo,m.MONED_Descripcion FROM  '.$tabla.' 
JOIN cji_moneda m on m.MONED_Codigo=c.MONED_Codigo
WHERE '.$where;
 $query = $this->db->query($sql);
    if ($query->num_rows > 0) {
        foreach ($query->result() as $value) {
            $data[] = $value;
        }
        return $data;
    }   
}
}

?>