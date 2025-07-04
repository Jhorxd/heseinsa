<?php
class Comprobante_formapago_model extends Model 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->database();
    }

    public function getList($idComprobante = 0, $typeFP = 0, $withMain = false) 
    {
        $rows = $this->db->select("comfp.*, fp.FORPAC_Descripcion, mon.MONED_Simbolo")
            ->from('cji_comprobante_formaspago comfp')
            ->join('cji_formapago fp', 'fp.FORPAP_Codigo = comfp.FORPAP_Codigo AND fp.FORPAC_FlagEstado=1' ,'LEFT')
            ->join('cji_moneda mon', 'mon.MONED_Codigo = comfp.MONED_Codigo AND mon.MONED_FlagEstado=1' ,'LEFT')
            ->where([
                'comfp.CPP_Codigo' => $idComprobante,
                'comfp.compro_forPa_flag' => 1
            ]);

        if (!empty($typeFP))
            $rows->where('fp.FORPAP_Codigo', $typeFP);

        if ($withMain)
        {
            $query1 = $rows->get()->result();
            $rowMain = $this->db->select('c.CPP_Codigo, c.MONED_Codigo, c.FORPAP_Codigo, 
                    c.FORPAP_Monto AS monto,
                    c.CPC_total, 
                    fp1.FORPAC_Descripcion, 
                    mon1.MONED_Simbolo')
                    ->from('cji_comprobante c')
                    ->join('cji_formapago fp1', 'fp1.FORPAP_Codigo = c.FORPAP_Codigo AND fp1.FORPAC_FlagEstado=1' ,'LEFT')
                    ->join('cji_moneda mon1', 'mon1.MONED_Codigo = c.MONED_Codigo AND mon1.MONED_FlagEstado=1' ,'LEFT')
                    ->where([
                        'c.CPP_Codigo' => $idComprobante
                    ]);
            if (!empty($typeFP))
                $rowMain->where('fp1.FORPAP_Codigo', $typeFP);

            $query2 = $rowMain->get()->result();
            $arrayMerge = array_merge($query2, $query1);
            return $arrayMerge;
        }

        return $rows->get()->result();
    }

    public function insertar($filter) 
    {
        $this->db->insert("cji_comprobante_formaspago", (array) $filter);
        return $this->db->insert_id();
    }

    public function deleteforComprobante($idComprobante) 
    {
        $this->db->delete("cji_comprobante_formaspago", ['CPP_Codigo' => $idComprobante]);
    }
}