<?php
class Sunat_Model extends Model{

    protected $_name = "sunat_transaction";
    
    public function  __construct(){
        parent::__construct();
    }

    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function getTransactions($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND t.TXC_Descripcion LIKE '%$filter->descripcion%'";

            if (isset($filter->trans_cod) && $filter->trans_cod != '')
                $where .= " AND t.TXC_CodigoSunat  = '$filter->trans_cod'";

            $sql = "SELECT t.* FROM sunat_transaction t WHERE t.TXC_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getTransaction($codigo) {

            $sql = "SELECT t.* FROM sunat_transaction t WHERE t.TXC_CodigoSunat = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }


        public function getDetracciones($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND t.DTT_Descripcion LIKE '%$filter->descripcion%'";

            if (isset($filter->det_codigo) && $filter->det_codigo != '')
                $where .= " AND t.DTT_CodigoSunat = '$filter->det_codigo'";

            $sql = "SELECT d.* FROM detraccion_tipo d WHERE d.DTT_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getDetraccion($codigo) {

            $sql = "SELECT d.* FROM detraccion_tipo d WHERE d.DTT_CodigoSunat = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getPagoDetracciones($filter = NULL) {

            $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
            $order = ( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";

            $where = '';
            if (isset($filter->descripcion) && $filter->descripcion != '')
                $where .= " AND t.DTT_Descripcion LIKE '%$filter->descripcion%'";

            if (isset($filter->mdp_codigo) && $filter->mdp_codigo != '')
                $where .= " AND t.MDP_CodigoSunat = '$filter->mdp_codigo'";

            $sql = "SELECT m.* FROM medio_de_pago_detraccion m WHERE m.MDP_FlagEstado LIKE '1' $where $order $limit";

            $query = $this->db->query($sql);
            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        public function getPagoDetraccion($codigo) {

            $sql = "SELECT m.* FROM medio_de_pago_detraccion m WHERE m.MDP_CodigoSunat = $codigo";
            $query = $this->db->query($sql);

            if ($query->num_rows > 0)
                return $query->result();
            else
                return array();
        }

        
        
}
?>