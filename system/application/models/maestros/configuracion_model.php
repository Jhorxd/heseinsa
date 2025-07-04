<?php

class Configuracion_model extends Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('date');
        $this->load->model('maestros/compania_model');
        $this->somevar ['compania'] = $this->session->userdata('compania');
        $this->somevar ['usuario'] = $this->session->userdata('usuario');
        $this->somevar['hoy'] = mdate("%Y-%m-%d %h:%i:%s", time());
    }

    public function obtener_configuracion($compania) {
        $where = array("COMPP_Codigo" => $compania, "CONFIC_FlagEstado" => "1");
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function update_numero_presupuesto($numero, $compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 13);
        $data['CONFIC_Numero']=$numero;
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }
    public function update_numero_pedido($numero, $compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 1);
        $data['CONFIC_Numero']=$numero;
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }

    /*function obtener_numero_documento($compania, $tipo_doc) {//jjjjjj
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $tipo_doc);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }*/

    function obtener_numero_documento($compania, $tipo_doc, $documento = "F") {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $tipo_doc);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }

            $ultNumero = $this->correlativoSiguiente($compania, $tipo_doc, $documento);
            

            if ($ultNumero >= 0){
                if ( $tipo_doc == 11 || $tipo_doc == 12 || $tipo_doc == 10)
                    $data[0]->CONFIC_Numero = $ultNumero;
                else
                    if ( $ultNumero > $data[0]->CONFIC_Numero )
                        $data[0]->CONFIC_Numero = $ultNumero;
            }

            return $data;
        }
    }

    public function obtener_ultimo_numero_guia_remision(){

     $sql = "SELECT count(*) + 1 as conteo FROM cji_guiarem where GUIAREMC_TipoOperacion = 'C'"; 
     $query = $this->db->query($sql);
     return $query->row();
    }
    
    public function obtener_ultimo_numero_nota_credito_compras(){

     $sql = "SELECT count(*) + 1 as conteo FROM cji_nota where CRED_TipoOperacion = 'C'"; 
     $query = $this->db->query($sql);
     return $query->row();
    }


    public function correlativoSiguiente($compania, $tipo, $documento = "F"){

        switch ($tipo) {
            case 8: # FACTURA
                $tipo_doc = 'F';
                break;
            case 9: # BOLETA
                $tipo_doc = 'B';
                break;
            case 10: # GUIA DE REMISION
                $tipo_doc = 'GR';
                break;
            case 11: # NOTA CREDITO
                $tipo_doc = 'C';
                break;
            case 12: # NOTA DEBITO
                $tipo_doc = 'D';
                break;
            case 14: # COMPROBANTE
                $tipo_doc = 'N';
                break;
            case 20: # PRODUCCION
                $tipo_doc = 'PR';
                break;
            case 21: # DESPACHO
                $tipo_doc = 'DP';
                break;
        }

        if ($tipo == 8 || $tipo == 9 || $tipo == 14){
            $sql = "SET @CPP_Ult = (SELECT max(CPP_Codigo) FROM cji_comprobante WHERE COMPP_Codigo = '$compania' AND CPC_TipoDocumento = '$tipo_doc' AND CPC_TipoOperacion = 'V' AND CPC_Serie = (SELECT con.CONFIC_Serie FROM cji_configuracion con WHERE con.COMPP_Codigo = $compania	AND con.DOCUP_Codigo IN(SELECT DOCUP_Codigo FROM cji_documento d WHERE d.DOCUC_ABREVI LIKE '$tipo_doc') LIMIT 1 ));";
            $this->db->query($sql);
            
            $sql = "SELECT CPC_Numero as Numero FROM cji_comprobante WHERE CPP_Codigo = @CPP_Ult;";
            $query = $this->db->query($sql);
        }
        else
            if ($tipo == 11 || $tipo == 12){
                $sql = "SET @CPP_Ult = (SELECT max(CRED_Codigo) FROM cji_nota WHERE COMPP_Codigo = '$compania' AND CRED_TipoNota = '$tipo_doc' AND CRED_TipoOperacion = 'V' AND CRED_TipoDocumento_inicio = '$documento'); ";
                $this->db->query($sql);
                
                $sql = "SELECT CRED_Numero as Numero FROM cji_nota WHERE CRED_Codigo = @CPP_Ult;";
                $query = $this->db->query($sql);
            }
        else
            if ($tipo == 20){
                $sql = "SET @CPP_Ult = (SELECT max(PR_Codigo) FROM cji_produccion); ";
                $this->db->query($sql);
                
                $sql = "SELECT PR_Numero as Numero FROM cji_produccion WHERE PR_Codigo = @CPP_Ult;";
                $query = $this->db->query($sql);
            }
        else
            if ($tipo == 21){
                $sql = "SET @CPP_Ult = (SELECT max(DESP_Codigo) FROM cji_despacho); ";
                $this->db->query($sql);
                
                $sql = "SELECT DESC_Numero as Numero FROM cji_despacho WHERE DESP_Codigo = @CPP_Ult;";
                $query = $this->db->query($sql);
            }
         else
            if ($tipo == 10){
                $sql = "SET @CPP_Ult = (SELECT max(GUIAREMP_Codigo) FROM cji_guiarem WHERE GUIAREMC_TipoOperacion LIKE 'V' AND COMPP_Codigo = $compania);"; # OBTIENE EL MAXIMO CORRELATIVO DE LA SERIE ACTUAL
                $this->db->query($sql);
                
                $sql = "SELECT GUIAREMC_Numero as Numero FROM cji_guiarem WHERE GUIAREMP_Codigo = @CPP_Ult;";

                $query = $this->db->query($sql);

            }
        else
            if ($tipo == 15){
                $sql = "SET @CPP_Ult = (SELECT max(GTRANP_Codigo) FROM cji_guiatrans where COMPP_Codigo='$compania'); ";
                $this->db->query($sql);
                
                $sql = "SELECT GTRANC_Numero as Numero FROM cji_guiatrans WHERE GTRANP_Codigo = @CPP_Ult;";

                $query = $this->db->query($sql);

            }

        $data = NULL;
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data = $fila->Numero;
            }
        }
        else
            $data = 0;
        
        return $data;
    }

    
       function obtener_numero_documento_oc($compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 3);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }

    function obtener_numero_documento_os($compania) {
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => 17);
        $query = $this->db->where($where)->get('cji_configuracion');
        if ($query->num_rows > 0) {
            foreach ($query->result() as $fila) {
                $data[] = $fila;
            }
            return $data;
        }
    }
    
     public function modificar_configuracion2($compania, $documento, $numero, $serie = null) {
        $data['CONFIC_Numero'] = $numero;
        if ($serie != null)
            $data['CONFIC_Serie'] = $serie;
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $documento);
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }
    
    
    
    public function modificar_configuracion($compania, $documento, $numero, $serie = null) {
        $data['CONFIC_Numero'] = $numero;
        if ($serie != null)
            $data['CONFIC_Serie'] = $serie;
        $where = array("COMPP_Codigo" => $compania, "DOCUP_Codigo" => $documento);
        $this->db->where($where);
        $this->db->update('cji_configuracion', $data);
    }

    public function modificar_configuracion_total($compania, $logo, $tipo_valorizacion, $datos, $datos_serie) {
        $this->modificar_configuracion($compania, '3', $datos['orden_compra'], $datos_serie['orden_compra']);
        $this->modificar_configuracion($compania, '8', $datos['factura'], $datos_serie['factura']);
        $this->modificar_configuracion($compania, '9', $datos['boleta'], $datos_serie['boleta']);
        $this->modificar_configuracion($compania, '10', $datos['guia_remision'], $datos_serie['guia_remision']);
        $this->modificar_configuracion($compania, '11', $datos['nota_credito'], $datos_serie['nota_credito']);
        $this->modificar_configuracion($compania, '14', $datos['comprobante_general'], $datos_serie['comprobante_general']);
        $this->modificar_configuracion($compania, '18', $datos['ordenventa'], $datos_serie['ordenventa']);
    }

}

?>