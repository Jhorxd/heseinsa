<?php
class Compras_Model extends Model
{

  public function __construct(){
      parent::__construct();
      $this->load->database();
      $this->load->helper('date');
      $this->somevar['compania'] = $this->session->userdata('compania');
      $this->somevar['usuario']  = $this->session->userdata('usuario');
      $this->somevar['hoy']       = mdate("%Y-%m-%d %h:%i:%s",time());
  }

  public function compras_por_vendedor_detallado($vendedor, $inicio, $fin){
      $sql = "SELECT c.CPP_Codigo, c.CPC_Serie, c.CPC_Numero, c.CPC_Total, c.CPC_Fecha,
                  cli.CLIC_CodigoUsuario,
                  CONCAT_WS(' ', 
                    (SELECT CONCAT_WS(' - ', emp.EMPRC_Ruc, emp.EMPRC_RazonSocial) FROM cji_empresa emp WHERE emp.EMPRP_Codigo = cli.EMPRP_Codigo),
                    (SELECT CONCAT_WS(' - ', pp.PERSC_NumeroDocIdentidad, CONCAT_WS(' ',pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) ) FROM cji_persona pp WHERE pp.PERSP_Codigo = cli.PERSP_Codigo)
                  ) as nombre_cliente,
                  p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno, p.PERSC_NumeroDocIdentidad, f.FORPAC_Descripcion, n.CRED_Serie, n.CRED_Numero, n.CRED_Total, n.CRED_Fecha

                FROM cji_comprobante c
                INNER JOIN cji_cliente cli ON cli.CLIP_Codigo = c.CLIP_Codigo
                INNER JOIN cji_persona p ON p.PERSP_Codigo = c.CPC_Vendedor
                INNER JOIN cji_formapago f ON f.FORPAP_Codigo = c.FORPAP_Codigo
                LEFT JOIN cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
                WHERE c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.CPC_Vendedor = $vendedor AND c.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'
                ORDER BY f.FORPAC_Descripcion DESC, c.CPC_Vendedor ASC, c.CPP_Codigo ASC;
              ";
              
      $query = $this->db->query($sql);
      $data = array();
      if ($query->num_rows > 0){
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
        return $data;
      }
      else
        return NULL;
  }

  public function compras_por_producto_de_vendedor($finicio, $ffin){
    $empresa = $_SESSION['empresa'];
    $compania = $_SESSION['compania'];

    $vendedores = "SELECT p.*
                    FROM cji_persona p
                    INNER JOIN cji_directivo d ON p.PERSP_Codigo = d.PERSP_Codigo
                    INNER JOIN cji_cargo c ON c.CARGP_Codigo = d.CARGP_Codigo
                    WHERE p.PERSC_FlagEstado = 1 AND d.DIREC_FlagEstado = 1 AND d.EMPRP_Codigo = $empresa"; # AND c.CARGC_Descripcion LIKE '%VENDEDOR%'

    $vendedoresInfo = $this->db->query($vendedores);
    $col = "";

    foreach ($vendedoresInfo->result() as $key => $value) {
      if ($key > 0)
        $col .= ", ";

      $col .= "
                '$value->PERSC_Nombre $value->PERSC_ApellidoPaterno $value->PERSC_ApellidoMaterno' as vendedor$key,
                (
                  SELECT SUM(cd.CPDEC_Cantidad) FROM cji_comprobantedetalle cd
                  INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                  INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                  WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_Vendedor = $value->PERSP_Codigo AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                ) as cantidad$key,
                (
                  SELECT SUM(cd.CPDEC_Total) FROM cji_comprobantedetalle cd
                  INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                  INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                  WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_Vendedor = $value->PERSP_Codigo AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                ) as venta$key
              ";
    }

    $productos = "SELECT pp.PROD_CodigoUsuario, pp.PROD_Nombre, m.MARCC_CodigoUsuario, $col,
                  (
                    SELECT SUM(cd.CPDEC_Cantidad) FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                  ) as cantidadTotal,
                  (
                    SELECT SUM(cd.CPDEC_Total) FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                  ) as ventaTotal
                FROM cji_producto pp
                INNER JOIN cji_productocompania pc ON pc.PROD_Codigo = pp.PROD_Codigo AND pc.COMPP_Codigo = $compania
                LEFT JOIN cji_marca m ON m.MARCP_Codigo = pp.MARCP_Codigo
                
                  WHERE (
                      SELECT SUM(cd.CPDEC_Cantidad) FROM cji_comprobantedetalle cd
                      INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                      INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                      WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                    ) IS NOT NULL

                ORDER BY ventaTotal DESC
              ";

    $productosInfo = $this->db->query($productos);
    
    $data = array();
    if($productosInfo->num_rows > 0){
      foreach($productosInfo->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }

  public function compras_por_vendedor_general($vendedor, $inicio, $fin){
      /*$sql = "SELECT SUM(c.CPC_Total) as total, f.FORPAC_Descripcion,
                (SELECT CONCAT_WS(' ', p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
                  FROM cji_persona p WHERE p.PERSP_Codigo = $vendedor) as vendedor
                FROM cji_comprobante c
                INNER JOIN cji_formapago f ON f.FORPAP_Codigo = c.FORPAP_Codigo
                WHERE c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'V' AND c.CPC_Vendedor = $vendedor AND c.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'
                GROUP BY f.FORPAP_Codigo
                ORDER BY f.FORPAC_Descripcion DESC
              ";*/

      $sql = "SELECT SUM(c.CPC_Total) as total, SUM(n.CRED_total) as totalNotas, f.FORPAC_Descripcion,

                (SELECT SUM(ci.CPC_Total) FROM cji_comprobante ci WHERE ci.FORPAP_Codigo = c.FORPAP_Codigo AND ci.CPC_TipoDocumento LIKE 'F' AND ci.CPC_FlagEstado = 1 AND ci.CPC_TipoOperacion = 'C' AND ci.CPC_Vendedor = $vendedor AND ci.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59') as totalFacturas,
                (SELECT SUM(ci.CPC_Total) FROM cji_comprobante ci WHERE ci.FORPAP_Codigo = c.FORPAP_Codigo AND ci.CPC_TipoDocumento LIKE 'B' AND ci.CPC_FlagEstado = 1 AND ci.CPC_TipoOperacion = 'C' AND ci.CPC_Vendedor = $vendedor AND ci.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59') as totalBoletas,
                (SELECT SUM(ci.CPC_Total) FROM cji_comprobante ci WHERE ci.FORPAP_Codigo = c.FORPAP_Codigo AND ci.CPC_TipoDocumento LIKE 'N' AND ci.CPC_FlagEstado = 1 AND ci.CPC_TipoOperacion = 'C' AND ci.CPC_Vendedor = $vendedor AND ci.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59') as totalComprobantes,

                (SELECT CONCAT_WS(' ', p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
                  FROM cji_persona p WHERE p.PERSP_Codigo = $vendedor) as vendedor
                FROM cji_comprobante c
                INNER JOIN cji_formapago f ON f.FORPAP_Codigo = c.FORPAP_Codigo
                LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
                WHERE c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.CPC_Vendedor = $vendedor AND c.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'
                GROUP BY c.FORPAP_Codigo
                ORDER BY f.FORPAC_Descripcion DESC
              ";

      $query = $this->db->query($sql);
      $data = array();
      if ($query->num_rows > 0){
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
        return $data;
      }
      else
        return NULL;
  }

  public function compras_por_vendedor_general_suma($vendedor, $inicio, $fin){
      $sql = "SELECT SUM(c.CPC_Total) as total, f.FORPAC_Descripcion
                FROM cji_comprobante c
                INNER JOIN cji_formapago f ON f.FORPAP_Codigo = c.FORPAP_Codigo
                WHERE c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.CPC_Vendedor = $vendedor AND c.CPC_Fecha BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'
                GROUP BY f.FORPAP_Codigo
                ORDER BY f.FORPAC_Descripcion DESC
              ";
      $query = $this->db->query($sql);
      $data = array();
      if ($query->num_rows > 0){
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
        return $data;
      }
      else
        return NULL;
  }

  public function compras_por_vendedor_resumen($inicio,$fin, $comp = ""){
    $compania = ($comp == "") ? " c.COMPP_Codigo = ".$this->somevar['compania']." AND" : "";
    $sql = "SELECT SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as VENTAS, p.PERSC_Nombre as NOMBRE, CONCAT_WS(' ',p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno) as PATERNO 
       FROM cji_comprobante c 
         INNER JOIN cji_persona p ON c.CPC_Vendedor = p.PERSP_Codigo 
           WHERE $compania c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' GROUP BY c.CPC_Vendedor";

    $query = $this->db->query($sql);    
    $data = array();
    if($query->num_rows() > 0){
      foreach($query->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }


  
  public function compras_por_vendedor_mensual($inicio,$fin, $comp = ""){
    $compania = ($comp == "") ? " c.COMPP_Codigo = ".$this->somevar['compania']." AND" : "";
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio){
      $sql = " SELECT p.PERSC_Nombre as NOMBRE, CONCAT_WS(' ',p.PERSC_Nombre, p.PERSC_ApellidoPaterno) as PATERNO, ";
      for($j = $anioInicio; $j <= $anioFin; $j++){
        if($j == $anioFin){
          for($i = 1; $i <= intval($mesFin); $i++){
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }
        else
          if($j==$anioInicio){
            for($i = intval($mesInicio); $i <= 12; $i++){
              $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
            }
        }
        else{
            for($i = 1; $i <= 12; $i++){
              $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
            }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobante c
      JOIN cji_persona p ON c.CPC_Vendedor = p.PERSP_Codigo
      WHERE $compania YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' AND p.PERSC_Nombre != ''
      AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C'
      GROUP BY c.CPC_Vendedor";
    
    }
    else
      if($anioFin == $anioInicio){
        $sql = " SELECT p.PERSC_Nombre as NOMBRE, CONCAT_WS(' ',p.PERSC_Nombre, p.PERSC_ApellidoPaterno) as PATERNO, ";
        if($mesInicio == $mesFin) {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
        }
        else{
          for($i = intval($mesInicio); $i <= intval($mesFin); $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin$i,";
          }
          $sql = substr($sql,0,strlen($sql)-1);
        }
      
      $sql.= "
      FROM cji_comprobante c
      LEFT JOIN cji_persona p ON c.CPC_Vendedor = p.PERSP_Codigo 
      WHERE $compania YEAR(c.CPC_Fecha) = '$anioInicio' AND p.PERSC_Nombre != ''
      AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' 
      GROUP BY c.CPC_Vendedor";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0){
      foreach($query->result_array() as $result){
        $data[] = $result;
      }
    }
  
    return $data;
  }
  
  public function compras_por_vendedor_anual($inicio,$fin, $comp = ""){
    $compania = ($comp == "") ? " c.COMPP_Codigo = ".$this->somevar['compania']." AND" : "";
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio){
      $sql = " SELECT p.PERSC_Nombre as NOMBRE, CONCAT_WS(' ',p.PERSC_Nombre, p.PERSC_ApellidoPaterno) as PATERNO, ";
      for($j = $anioInicio; $j <= $anioFin; $j++){
        if($j == $anioFin){
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }
        else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobante c 
      JOIN cji_persona p ON c.CPC_Vendedor = p.PERSP_Codigo 
      WHERE $compania YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' AND p.PERSC_Nombre != ''
      AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' 
      GROUP BY c.CPC_Vendedor";
    }
    else
      if($anioFin == $anioInicio){
      $sql = " SELECT p.PERSC_Nombre as NOMBRE, CONCAT_WS(' ',p.PERSC_Nombre, p.PERSC_ApellidoPaterno) as PATERNO, ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_comprobante c 
      LEFT JOIN cji_persona p ON c.CPC_Vendedor = p.PERSP_Codigo 
      WHERE $compania YEAR(c.CPC_Fecha) = '$anioInicio'  AND p.PERSC_Nombre != ''
      AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' 
      GROUP BY c.CPC_Vendedor";
    }
  
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0){
      foreach($query->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_cliente_resumen_general($inicio, $fin, $all = false)
  {
    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $where="and com.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin')";
    $sql = "
    SELECT SUM( IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total)) as VENTAS,
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC
    from cji_comprobante com
    inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
    inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
    inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
    WHERE CPC_TipoOperacion = 'C' AND CPC_FlagEstado = 1 ".$where." GROUP BY com.CLIP_Codigo
     UNION
    SELECT SUM( IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total)) as VENTAS ,
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC
    from cji_comprobante com
    inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
    inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
    inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
    WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 ".$where." GROUP BY com.CLIP_Codigo ORDER BY VENTAS DESC $limit
    ";
    $query = $this->db->query($sql);
  
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_cliente_mensual_general($inicio, $fin, $all = false)
  {

    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
      $sql = " SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' GROUP BY com.CLIP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $i--;
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' GROUP BY com.CLIP_Codigo ";//ORDER BY m$j$i DESC $limit
  
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' GROUP BY com.CLIP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
          $colOrder = "m$anioFin".intval($mesInicio);
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
        $i--;
        $colOrder = "m$anioFin$i";
      }
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' GROUP BY com.CLIP_Codigo ORDER BY $colOrder DESC $limit";
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }

  public function compras_por_cliente_anual_general($inicio, $fin, $all = false)
  {

    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
  
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 GROUP BY com.CLIP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC , ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $j--;
  
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 GROUP BY com.CLIP_Codigo ORDER BY y$j DESC $limit
      ";
  
  
    }elseif($anioFin == $anioInicio){
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 GROUP BY com.CLIP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC ,";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 GROUP BY com.CLIP_Codigo ORDER BY y$anioFin DESC $limit
      ";
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }

  public function compras_por_cliente_resumen($inicio, $fin, $cliente)
  {
    $where="and com.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin')";
    $sql = "
    SELECT SUM( IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total)) as VENTAS,
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC
    from cji_comprobante com
    inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
    inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
    inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
    WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 ".$where." and com.CLIP_Codigo =".$cliente."
     UNION
    SELECT SUM( IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total)) as VENTAS ,
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC
    from cji_comprobante com
    inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
    inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
    inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
    WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 ".$where." and com.CLIP_Codigo =".$cliente."
    ";
    $query = $this->db->query($sql);
  
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }

  public function compras_por_cliente_mensual($inicio,$fin,$cliente)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
      $sql = " SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and com.CLIP_Codigo = ".$cliente."
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and com.CLIP_Codigo = ".$cliente." ";
  
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' and com.CLIP_Codigo = ".$cliente."
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' and com.CLIP_Codigo = ".$cliente." ";
  
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }
  
  public function compras_por_cliente_anual($inicio,$fin,$cliente)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
  
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and com.CLIP_Codigo = ".$cliente."
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC , ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and com.CLIP_Codigo = ".$cliente."
      ";
  
  
    }elseif($anioFin == $anioInicio){
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= "
      from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = cl.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and com.CLIP_Codigo = ".$cliente."
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC ,";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= " from cji_comprobante com
      inner join cji_cliente cl on cl.CLIP_Codigo = com.CLIP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = cl.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and com.CLIP_Codigo = ".$cliente."
      ";
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }
  
  

  public function compras_por_proveedor_resumen_general($inicio, $fin, $all = false)
  {
    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $where="and com.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin')";
    $sql = "SELECT SUM( IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total)) as VENTAS,
              EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC
            from cji_comprobante com
            inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
            inner join cji_empresa es on es.EMPRP_Codigo = pv.EMPRP_Codigo
            inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
            WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 ".$where." GROUP BY com.PROVP_Codigo ORDER BY VENTAS DESC $limit
            ";
    $query = $this->db->query($sql);
  
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }

  public function resumen_ventas($inicio, $fin){
    $where = " AND c.CPC_FechaRegistro BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'";

    $sql = "SELECT c.*,
              (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, ' - ', e.EMPRC_RazonSocial) FROM cji_empresa e WHERE e.EMPRP_Codigo = cli.EMPRP_Codigo) as clienteEmpresa,
              (SELECT CONCAT_WS(' ', pp.PERSC_NumeroDocIdentidad, ' - ', pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) FROM cji_persona pp WHERE pp.PERSP_Codigo = cli.PERSP_Codigo) as clientePersona,

              n.CRED_Serie, n.CRED_Numero, n.CRED_Total

              FROM cji_comprobante c
              LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
              INNER JOIN cji_cliente cli ON cli.CLIP_Codigo = c.CLIP_Codigo

              WHERE CPC_TipoOperacion = 'C' AND CPC_FlagEstado = 1 $where
              ORDER BY c.CPC_Fecha, c.CPC_Numero ASC
            ";
    $query = $this->db->query($sql);
    $data = array();
    if($query->num_rows > 0){
      foreach($query->result() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }


  public function resumen_compras_detallado($inicio, $fin){
    $where = " AND c.CPC_FechaRegistro BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59'";

    $sql = "SELECT c.CPC_Fecha, c.CPC_FechaRegistro, c.CPC_Serie, c.CPC_Numero, cd.*, p.PROD_Nombre, m.MARCC_CodigoUsuario, l.LOTC_Numero, l.LOTC_FechaVencimiento,
              (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, ' - ', e.EMPRC_RazonSocial) FROM cji_empresa e WHERE e.EMPRP_Codigo = pv.EMPRP_Codigo) as proveedorEmpresa,
              (SELECT CONCAT_WS(' ', pp.PERSC_NumeroDocIdentidad, ' - ', pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) FROM cji_persona pp WHERE pp.PERSP_Codigo = pv.PERSP_Codigo) as proveedorPersona

              FROM cji_comprobantedetalle cd
              INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
              INNER JOIN cji_proveedor pv ON pv.PROVP_Codigo = c.PROVP_Codigo
              INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
              LEFT JOIN cji_lote l ON l.LOTP_Codigo = cd.LOTP_Codigo
              LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo

              WHERE CPC_TipoOperacion = 'C' AND CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 $where
              ORDER BY c.CPC_Fecha
            ";
    $query = $this->db->query($sql);
    $data = array();
    if($query->num_rows > 0){
      foreach($query->result() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_proveedor_mensual_general($inicio, $fin, $all = false)
  {

    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
      $sql = " SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = pv.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' GROUP BY com.PROVP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i AND YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $i--;
      $sql.= " from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = pv.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' GROUP BY com.PROVP_Codigo ORDER BY m$j$i DESC $limit";
  
    }elseif($anioFin == $anioInicio){
      $sql = "SELECT
      CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
  
      $sql.= "
      from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = pv.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE CPC_TipoOperacion='C'  AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' GROUP BY com.PROVP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC, ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=".intval($mesInicio).",IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
          $colOrder = "m$anioFin".intval($mesInicio);
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(com.CPC_Fecha)=$i,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
        $i--;
        $colOrder = "m$anioFin$i";
      }
      $sql.= " from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = pv.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 and YEAR(com.CPC_Fecha) = '$anioInicio' GROUP BY com.PROVP_Codigo ORDER BY $colOrder DESC $limit";
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }

  public function compras_por_proveedor_anual_general($inicio, $fin, $all = false)
  {

    $limit = ($all == false) ? "" : " LIMIT 10 ";

    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
  
    if($anioFin > $anioInicio)
    {
  
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
  
      $sql.= "
      from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = pv.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 GROUP BY com.PROVP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC , ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }else{
          $sql .= "SUM(IF(YEAR(com.CPC_Fecha)=$j,IF(com.MONED_Codigo=2,com.CPC_TDC*com.CPC_Total,com.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $j--;
  
      $sql.= " from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = pv.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 GROUP BY com.PROVP_Codigo ORDER BY y$j DESC $limit
      ";
  
  
    }elseif($anioFin == $anioInicio){
  
      $sql = " SELECT
     CONCAT(pe.PERSC_Nombre , ' ', pe.PERSC_ApellidoPaterno, ' ', pe.PERSC_ApellidoMaterno) as NOMBRE, PERSC_NumeroDocIdentidad AS RUC ,
      ";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= "
      from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_persona pe on pe.PERSP_Codigo = pv.PERSP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo=com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 GROUP BY com.PROVP_Codigo
      UNION
      SELECT
      EMPRC_RazonSocial as NOMBRE , EMPRC_Ruc AS RUC ,";
      $sql .= "SUM(IF(com.MONED_Codigo=2,com.CPC_TDC * com.CPC_Total,com.CPC_Total)) as y$anioFin ";
  
      $sql.= " from cji_comprobante com
      inner join cji_proveedor pv on pv.PROVP_Codigo = com.PROVP_Codigo
      inner join cji_empresa es on es.EMPRP_Codigo = pv.EMPRP_Codigo
      inner JOIN cji_moneda m ON m.MONED_Codigo = com.MONED_Codigo
      WHERE YEAR(com.CPC_Fecha) = '$anioInicio' and CPC_TipoOperacion='C' AND CPC_FlagEstado = 1 GROUP BY com.PROVP_Codigo ORDER BY y$anioFin DESC $limit
      ";
    }
  
    $query = $this->db->query($sql);
  
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }

  public function compras_por_marca_de_vendedor($finicio, $ffin){
    $empresa = $_SESSION['empresa'];
    $compania = $_SESSION['compania'];

    $vendedores = "SELECT p.*
                    FROM cji_persona p
                    INNER JOIN cji_directivo d ON p.PERSP_Codigo = d.PERSP_Codigo
                    INNER JOIN cji_cargo c ON c.CARGP_Codigo = d.CARGP_Codigo
                    WHERE c.CARGC_Descripcion LIKE '%VENDEDOR%' AND p.PERSC_FlagEstado = 1 AND d.DIREC_FlagEstado = 1 AND d.EMPRP_Codigo = $empresa";

    $vendedoresInfo = $this->db->query($vendedores);
    $col = "";

    foreach ($vendedoresInfo->result() as $key => $value) {
      if ($key > 0)
        $col .= ", ";

      $col .= "
                '$value->PERSC_Nombre $value->PERSC_ApellidoPaterno $value->PERSC_ApellidoMaterno' as vendedor$key,
                (
                  SELECT SUM(cds.CPDEC_Total) FROM cji_comprobantedetalle cds
                  INNER JOIN cji_comprobante cs ON cs.CPP_Codigo = cds.CPP_Codigo
                  INNER JOIN cji_producto p ON p.PROD_Codigo = cds.PROD_Codigo
                  WHERE cs.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.CPC_Vendedor = $value->PERSP_Codigo AND p.MARCP_Codigo = m.MARCP_Codigo AND cs.CPC_TipoOperacion = 'C' AND cs.COMPP_Codigo = $compania
                ) as venta$key
              ";
    }

    $marcas = "SELECT m.MARCC_Descripcion, $col,
                (
                  SELECT SUM(cd.CPDEC_Total) FROM cji_comprobantedetalle cd
                  INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                  INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                  WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.MARCP_Codigo = m.MARCP_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                ) as total
                FROM cji_marca m
                WHERE m.MARCC_FlagEstado = 1
                ORDER BY total DESC
              ";

    $marcasInfo = $this->db->query($marcas);
    
    $data = array();
    if($marcasInfo->num_rows > 0){
      foreach($marcasInfo->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }

  
  public function compras_por_marca_resumen($inicio,$fin){
    $compania = $this->somevar['compania'];
    $sql = "SELECT m.MARCC_Descripcion AS NOMBRE, SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total) ) AS VENTAS
              FROM cji_comprobantedetalle cd
              JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
              JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
              JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
              WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin')
              AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania
              GROUP BY p.MARCP_Codigo
              ORDER BY VENTAS DESC
          ";
    $query = $this->db->query($sql);
    
    $data = array();
    if($query->num_rows > 0){
      foreach($query->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_marca_mensual($inicio,$fin){
    $compania = $this->somevar["compania"];
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio){
      $sql = "SELECT m.MARCC_Descripcion AS NOMBRE, ";
      for($j = $anioInicio; $j <= $anioFin; $j++) {
        if($j == $anioFin) {
          for($i = 1; $i <= intval($mesFin); $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
        else
          if($j==$anioInicio){
            for($i = intval($mesInicio); $i <= 12; $i++) {
              $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
            }
        }
        else{
          for($i = 1; $i <= 12; $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania
      GROUP BY p.MARCP_Codigo";
    
    }
    else
      if($anioFin == $anioInicio){
        $sql = "SELECT m.MARCC_Descripcion AS NOMBRE, ";
      if($mesInicio == $mesFin) {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }
      else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++) {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio' AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania
      GROUP BY p.MARCP_Codigo";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
  return $data;
  }
  
  public function compras_por_marca_anual($inicio,$fin){
    $compania = $this->somevar["compania"];
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio) {
      $sql = "SELECT m.MARCC_Descripcion AS NOMBRE, ";
      for($j = $anioInicio; $j <= $anioFin; $j++) {
        if($j == $anioFin) {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
        else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      $sql.= " FROM cji_comprobantedetalle cd
        JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
        JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
        JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
        WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
        AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania
        GROUP BY p.MARCP_Codigo";
    }
    else
      if($anioFin == $anioInicio){
      $sql = "SELECT m.MARCC_Descripcion AS NOMBRE, ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_marca m ON p.MARCP_Codigo = m.MARCP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      AND c.CPC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania
      GROUP BY p.MARCP_Codigo";
    }
  
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0) {
      foreach($query->result_array() as $result) {
        $data[] = $result;
      }
    }
  
  return $data;
  }
  
  
  /* FAMILIAS */

  
  public function compras_por_familia_resumen($inicio,$fin){
    $compania = $this->somevar['compania'];
    $sql = "SELECT f.FAMI_Descripcion AS NOMBRE, SUM( IF(c.MONED_Codigo = 2, c.CPC_TDC * cd.CPDEC_Total, cd.CPDEC_Total) ) AS VENTAS
              FROM cji_comprobantedetalle cd
              JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
              JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
              JOIN cji_familia f ON p.FAMI_Codigo  = f.FAMI_Codigo 
              WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania GROUP BY p.FAMI_Codigo";
    $query = $this->db->query($sql);
    
    $data = array();
    if($query->num_rows > 0) {
      foreach($query->result_array() as $result) {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_familia_mensual($inicio,$fin) {
    $compania = $this->somevar['compania'];
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio){
      $sql = "SELECT f.FAMI_Descripcion AS NOMBRE, ";
      for($j = $anioInicio; $j <= $anioFin; $j++) {
        if($j == $anioFin) {
          for($i = 1; $i <= intval($mesFin); $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
        else
          if($j==$anioInicio){
            for($i = intval($mesInicio); $i <= 12; $i++) {
              $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
            }
        }
        else{
          for($i = 1; $i <= 12; $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo  = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
      GROUP BY p.FAMI_Codigo";
    }
    else
      if($anioFin == $anioInicio){
        $sql = "SELECT f.FAMI_Descripcion AS NOMBRE, ";
        if($mesInicio == $mesFin) {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
        }
        else{
          for($i = intval($mesInicio); $i <= intval($mesFin); $i++) {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
          }
          $sql = substr($sql,0,strlen($sql)-1);
        }
      $sql.= "
      FROM cji_comprobantedetalle cd
      JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
      JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
      JOIN cji_familia f ON p.FAMI_Codigo  = f.FAMI_Codigo 
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
      GROUP BY p.FAMI_Codigo";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0) {
      foreach($query->result_array() as $result) {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_familia_anual($inicio,$fin) {
    $compania = $this->somevar["compania"];
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio) {
      $sql = "SELECT f.FAMI_Descripcion AS NOMBRE, ";
      for($j = $anioInicio; $j <= $anioFin; $j++) {
        if($j == $anioFin) {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
        else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= " FROM cji_comprobantedetalle cd
              JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
              JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
              JOIN cji_familia f ON p.FAMI_Codigo  = f.FAMI_Codigo 
              WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
              AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
              GROUP BY p.FAMI_Codigo";
    
    }
    else
      if($anioFin == $anioInicio){
        $sql = "SELECT f.FAMI_Descripcion AS NOMBRE, ";
        $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
        $sql.= " FROM cji_comprobantedetalle cd
                JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo
                JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
                JOIN cji_familia f ON p.FAMI_Codigo  = f.FAMI_Codigo 
                WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
                AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania
                GROUP BY p.FAMI_Codigo";
    }
  
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0) {
      foreach($query->result_array() as $result) {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_dia($inicio,$fin){
    $compania = $this->somevar['compania'];

    $sql = "SELECT c.CPC_Fecha as FECHA, date(cp.CPAGC_FechaRegistro) as FECHAPAGO, c.CPC_Serie AS SERIE,c.CPC_Numero AS NUMERO,CPC_TipoOperacion, CPC_Total AS VENTAS, cp.CPAGC_Monto, c.CPC_TipoDocumento AS TIPO, c.CPP_Codigo as CODIGO , c.CPC_TDC , c.MONED_Codigo, c.CPC_FlagEstado, c.FORPAP_Codigo, cc.CUE_Codigo, SUM(cp.CPAGC_Monto) AS pagos
              FROM cji_comprobante c
                INNER JOIN cji_cuentas cc ON cc.CUE_CodDocumento = c.CPP_Codigo
                INNER JOIN cji_cuentaspago cp ON cp.CUE_Codigo = cc.CUE_Codigo
                WHERE cp.CPAGC_FechaRegistro BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59' AND c.CPC_TipoOperacion='C' AND c.CPC_FlagEstado='1' AND c.COMPP_Codigo = '$compania'
                GROUP BY CUE_Codigo
                ORDER BY CPC_Numero ASC
                ";
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }

  public function ingreso_compras_por_dia($inicio,$fin){
    $compania = $this->somevar['compania'];

    $sql = "SELECT c.CPC_Fecha as FECHA, date(cp.CPAGC_FechaRegistro) as FECHAPAGO, c.CPC_Serie AS SERIE,c.CPC_Numero AS NUMERO,CPC_TipoOperacion, CPC_Total AS VENTAS, cp.CPAGC_Monto, c.CPC_TipoDocumento AS TIPO, c.CPP_Codigo as CODIGO , c.CPC_TDC , c.MONED_Codigo, c.CPC_FlagEstado, c.FORPAP_Codigo, cc.CUE_Codigo, SUM(cp.CPAGC_Monto) AS pagos
              FROM cji_comprobante c
                INNER JOIN cji_cuentas cc ON cc.CUE_CodDocumento = c.CPP_Codigo
                INNER JOIN cji_cuentaspago cp ON cp.CUE_Codigo = cc.CUE_Codigo
                WHERE cp.CPAGC_FechaRegistro BETWEEN '$inicio 00:00:00' AND '$fin 23:59:59' AND c.CPC_TipoOperacion='C' AND c.CPC_FlagEstado='1' AND c.COMPP_Codigo = '$compania'
                GROUP BY CUE_Codigo
                ORDER BY CPC_Numero ASC
                ";
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function producto_stock()
  {
    $sql = "SELECT DISTINCT P.PROD_Nombre, DATE_FORMAT(C.CPDEC_FechaRegistro,'%m-%d-%Y') as fecha, DATEDIFF( CURDATE( ) , C.CPDEC_FechaRegistro ) AS dias
        FROM  `cji_comprobantedetalle` C
        INNER JOIN cji_producto P ON P.PROD_Codigo = C.PROD_Codigo
        INNER JOIN (
        SELECT CPDEC_Descripcion, MAX( CPDEC_FechaRegistro ) AS MaxDateTime
        FROM cji_comprobantedetalle
        GROUP BY CPDEC_Descripcion
        )CD ON C.CPDEC_Descripcion = CD.CPDEC_Descripcion
        AND C.CPDEC_FechaRegistro = CD.MaxDateTime
        where DATEDIFF( CURDATE( ) , C.CPDEC_FechaRegistro ) >=15 AND P.PROD_FlagBienServicio = 'B' 
        ORDER BY dias ASC limit 150";
    
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result() as $result)
      {
        $data[] = $result;
      }
    }
  
    return $data;
  }
  
  //REPORTE DE VENTAS DE COMPROBANTES
  public function comprasDiarioC($date, $compania){
    $this->db->select('c.CPC_Serie, c.CPC_Numero, c.CPC_total, f.FORPAC_Descripcion, CASE (c.CPC_FlagEstado) when 2 then "Denegado" when 0 then "Anulado" ELSE "Aprobado" END as Estado', FALSE);
    $this->db->from('cji_comprobante as c');
    $this->db->join('cji_formapago as f', 'c.FORPAP_Codigo = f.FORPAP_Codigo');
    $this->db->where('c.COMPP_Codigo',$compania);
    $this->db->where('c.CPC_Fecha', $date);
   
    $response = $this->db->get();
    return $response->result();
  }
//REPORTE DE VENTAS DE NOTAS DE CREDITO
  public function comprasDiarioN($date, $compania){
    $this->db->select('n.CRED_Serie, n.CRED_Numero, n.CRED_total, f.FORPAC_Descripcion, CASE n.CRED_FlagEstado when 2 then "Denegado" ELSE "Aprobado" END as Estado', FALSE);
    $this->db->from('cji_nota as n');
    $this->db->join('cji_formapago as f', 'n.CRED_FormaPago = f.FORPAP_Codigo');
    $this->db->where('n.COMPP_Codigo', $compania);
    $this->db->where('n.CRED_Fecha', $date);

    $response = $this->db->get();
    
    return $response->result();
  }

  public function ventasTotal($date, $compania){
    $this->db->select('f.FORPAC_Descripcion, SUM(c.CPC_total) - COALESCE(n.nota_total, 0) as Total');
    $this->db->from('cji_comprobante as c');
    $this->db->join('cji_formapago as f', 'c.FORPAP_Codigo = f.FORPAP_Codigo', 'INNER');
    $this->db->join('(SELECT CRED_FormaPago, SUM(CRED_total) as nota_total FROM cji_nota WHERE COMPP_Codigo = '.$compania.' GROUP BY CRED_FormaPago) n', 'c.FORPAP_Codigo = n.CRED_FormaPago', 'LEFT');
    $this->db->where('c.COMPP_Codigo', $compania);
    $this->db->where('c.CPC_Fecha', $date);
    $this->db->where('c.CPC_FlagEstado !=', 2);
    $this->db->where('c.CPC_FlagEstado !=', 0);
    $this->db->group_by('f.FORPAC_Descripcion');

    $response = $this->db->get();
    
    return $response->result();
  }
  
   public function compras_diarios($tipo,$hoy)
  {
      $compania = $this->somevar['compania'];
      $this->db->select('cji_comprobante.CPC_Fecha,cji_comprobante.CPC_FlagEstado,cji_comprobante.CPC_TipoDocumento,cji_comprobante.CPC_Serie,cji_comprobante.CPC_Numero,
      cji_empresa.EMPRC_RazonSocial,cji_empresa.EMPRC_Ruc,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,
      cji_persona.PERSC_ApellidoMaterno,  cji_persona.PERSC_Ruc,cji_comprobante.CPC_subtotal,cji_comprobante.CPC_igv,
      cji_comprobante.CPC_total,cji_cliente.CLIC_TipoPersona,cji_moneda.MONED_Simbolo,cji_moneda.MONED_Codigo');
      $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo=cji_comprobante.CLIP_Codigo','left');
      $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_cliente.PERSP_Codigo','left');
      $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo','left');
     $this->db->join('cji_moneda','cji_moneda.MONED_Codigo=cji_comprobante.MONED_Codigo','left');
      $this->db->from('cji_comprobante');
      $this->db->where('cji_comprobante.COMPP_Codigo',$compania);
    $this->db->where('cji_comprobante.CPC_Fecha',$hoy);
       $this->db->where('cji_comprobante.CPC_TipoDocumento',$tipo);
      $this->db->where('cji_comprobante.CPC_TipoOperacion','C');
      
      $this->db->order_by('cji_comprobante.CPC_Numero','asc');
      
     $query= $this->db->get();
    

     if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
     }
  }
   public function registro_compras($tipo_oper, $tipo, $mes, $anio){
      $compania = $this->somevar['compania'];
      $this->db->select('cji_comprobante.CPC_Fecha,cji_comprobante.CPC_FlagEstado,cji_comprobante.CPC_TipoDocumento,cji_comprobante.CPC_Serie,cji_comprobante.CPC_Numero,
      cji_empresa.EMPRC_RazonSocial,cji_empresa.EMPRC_Ruc,cji_persona.PERSC_Nombre,cji_persona.PERSC_ApellidoPaterno,
      cji_persona.PERSC_ApellidoMaterno,  cji_persona.PERSC_Ruc,cji_comprobante.CPC_subtotal,cji_comprobante.CPC_igv,
      cji_comprobante.CPC_total,cji_cliente.CLIC_TipoPersona,cji_proveedor.PROVC_TipoPersona,cji_moneda.MONED_Simbolo,cji_moneda.MONED_Codigo');

      $this->db->join('cji_cliente','cji_cliente.CLIP_Codigo=cji_comprobante.CLIP_Codigo','left');
    $this->db->join('cji_proveedor','cji_proveedor.PROVP_Codigo=cji_comprobante.PROVP_Codigo','left');
    $this->db->join('cji_moneda','cji_moneda.MONED_Codigo=cji_comprobante.MONED_Codigo','left');
      if($tipo_oper=='C'){
    $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_cliente.PERSP_Codigo','left');
     $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_cliente.EMPRP_Codigo','left');
    
    }else{
    $this->db->join('cji_persona','cji_persona.PERSP_Codigo=cji_proveedor.PERSP_Codigo','left');
    $this->db->join('cji_empresa','cji_empresa.EMPRP_Codigo=cji_proveedor.EMPRP_Codigo','left');
    }
    
      $fecha1 = "$anio-$mes-01";
      $fecha2 = "$anio-$mes-".date("d");
    
      $this->db->from('cji_comprobante');

      $this->db->where('cji_comprobante.COMPP_Codigo',$compania);
      $this->db->where('cji_comprobante.CPC_TipoOperacion',$tipo_oper);
      $this->db->where('cji_comprobante.CPC_Fecha >=',$fecha1);
      $this->db->where('cji_comprobante.CPC_Fecha <=',$fecha2);
      $this->db->where('cji_comprobante.CPC_TipoDocumento',$tipo);
    
      $this->db->order_by('cji_comprobante.CPC_Numero','asc');
      
     $query = $this->db->get();    

     if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
     }
  }

  public function getAnioCompras(){
    $sql = "SELECT YEAR(CPC_Fecha) as anio FROM cji_comprobante GROUP BY CPC_Fecha";
    $query = $this->db->query($sql);
    if ($query->num_rows > 0)
      return $query->result();
    else
      return NULL;
  }

  public function resumen_compras_mensual($filter=""){

    $compania = $this->somevar['compania'];
    $sqlNotas = "";
    $where    = "";
    $where_n  = ""; 

    if($filter->tipo!="T" && $filter->tipo!=""){
      if($filter->tipo == "C"){
        $where .= " AND c.CPC_TipoDocumento IN ('F','B')";
      }else{
        $where .= " AND c.CPC_TipoDocumento = '$filter->tipo'";
      }
    }
    
    if($filter->forma_pago!=""){
      $where .= " AND c.FORPAP_Codigo='$filter->forma_pago'";
      
    }
    
    if($filter->vendedor!="" && $filter->tipo_oper == "C"){
      $where .= " AND c.CPC_Vendedor='$filter->vendedor'";
    }
    
    if($filter->almacen!="" && $filter->tipo_oper == "C"){
      $where .= " AND a.ALMAP_Codigo='$filter->almacen'";

    }

    if($filter->moneda!=""){
      $where    .= " AND c.MONED_Codigo='$filter->moneda'";
      $where_n  .= " AND c.MONED_Codigo='$filter->moneda'";
    }

    if($filter->consolidado == 0){
      $where    .= " AND c.COMPP_Codigo='$compania'";
      $where_n  .= " AND c.COMPP_Codigo='$compania'";
    }else{
      $where    .= " AND c.COMPP_Codigo IN ('".$filter->companias."')";
      $where_n  .= " AND c.COMPP_Codigo IN ('".$filter->companias."')";
    }
    
    if ($totales == false){
      $sql = "SELECT c.CPP_Codigo as CODCPC, c.CPC_Fecha, c.CPC_subtotal, c.CPC_igv, c.CPC_total, c.CPC_TDC, c.COMPP_Codigo, c.CPC_Serie, c.CPC_Numero, c.CPC_TipoDocumento, c.CPC_FlagEstado, c.MONED_Codigo, m.MONED_Simbolo, m.MONED_Descripcion, c.FORPAP_Codigo, fp.FORPAC_Descripcion, c.CPC_FechaVencimiento as CPC_FechaVencimiento,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as razon_social_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as numero_documento_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as razon_social_proveedor,
      (
        SELECT CONCAT_WS(' ', p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
        FROM cji_persona p
        WHERE p.PERSP_Codigo = c.CPC_Vendedor
      ) AS vendedor,
      a.ALMAC_Descripcion,
      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as numero_documento_proveedor, 

      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 1 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as gravada,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 8 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as exonerada,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 9 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as inafecta,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo NOT IN(1,8,9) AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as gratuita

      FROM cji_comprobante c
      LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
      LEFT JOIN cji_formapago fp ON fp.FORPAP_Codigo = c.FORPAP_Codigo
      INNER JOIN cji_almacen a ON c.ALMAP_Codigo = a.ALMAP_Codigo
      WHERE c.CPP_Codigo_Canje = 0  AND  c.CPC_FlagEstado != 2 AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND  c.CPC_Fecha BETWEEN '$filter->fecha1' AND '$filter->fecha2' $where ORDER BY c.CPC_Fecha, c.CPC_Numero
      ";

      $sqlNotas = "SELECT MONTH(c.CRED_Fecha) AS mes, c.CRED_Fecha as CPC_Fecha, c.CRED_subtotal as CPC_subtotal, c.CRED_igv as CPC_igv, c.CRED_total as CPC_total, c.CRED_TDC as CPC_TDC, c.COMPP_Codigo,  c.CRED_Serie as CPC_Serie, c.CRED_Numero as CPC_Numero, c.CRED_TipoNota as CPC_TipoDocumento, c.CRED_FlagEstado as CPC_FlagEstado, c.MONED_Codigo, m.MONED_Simbolo, m.MONED_Descripcion, null as CPC_FechaVencimiento,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as razon_social_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as numero_documento_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as razon_social_proveedor,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as numero_documento_proveedor, 

      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 1 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as gravada,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 8 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as exonerada,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 9 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as inafecta,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo NOT IN(1,8,9) AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as gratuita

      FROM cji_nota c
      LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo

      WHERE c.CRED_FlagEstado != 2 AND c.CRED_TipoOperacion = '$filter->tipo_oper' AND  c.CRED_Fecha BETWEEN '$filter->fecha1' AND '$filter->fecha2' $where_n ORDER BY c.CRED_Fecha, c.CRED_Numero
      ";
    }
    else{
      $sql = "SELECT c.CPP_Codigo as CODCPC,  SUM(c.CPC_total) AS total, m.MONED_Simbolo, c.CPC_TipoDocumento
      FROM cji_comprobante c
      LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
      WHERE c.CPC_FlagEstado = 1 AND c.COMPP_Codigo = '$compania' AND c.CPC_TipoOperacion = '$tipo' AND MONTH(CPC_Fecha) = '$mes' AND YEAR(CPC_Fecha) = '$anio' GROUP BY c.CPC_TipoDocumento, c.MONED_Codigo";
    }

    $query = $this->db->query($sql);
    $data = array();
    if($filter->tipo=="T" || $filter->tipo==""){
      if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
    }

    if ( $sqlNotas != "" ){
      $queryNotas = $this->db->query($sqlNotas);
      if ($queryNotas->num_rows > 0) {
        foreach ($queryNotas->result() as $fila) {
          $data[] = $fila;
        }
      }
    }
    }elseif($filter->tipo=="F" || $filter->tipo=="B" || $filter->tipo=="N"){
      if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
      }
    }elseif($filter->tipo=="C"){
      if ( $sqlNotas != "" ){
        $queryNotas = $this->db->query($sqlNotas);
        if ($queryNotas->num_rows > 0) {
          foreach ($queryNotas->result() as $fila) {
            $data[] = $fila;
          }
        }
      }
    }elseif($filter->tipo=="V"){
      if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
      }if ( $sqlNotas != "" ){
        $queryNotas = $this->db->query($sqlNotas);
        if ($queryNotas->num_rows > 0) {
          foreach ($queryNotas->result() as $fila) {
            $data[] = $fila;
          }
        }
      }
    }

    return $data;
  }
  
  

  
   public function compras_por_tienda_resumen($inicio,$fin)
  {
    //SELECT SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as VENTAS, p.PERSC_Nombre as NOMBRE, p.PERSC_ApellidoPaterno as PATERNO 
    $sql = "
  SELECT SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as VENTAS, e.EESTABC_Descripcion as nombre ,e.EESTAC_Direccion as direccion
  FROM cji_comprobante c 
  LEFT JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = c.COMPP_Codigo
  WHERE c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') 
  GROUP BY COMPP_Codigo ORDER BY 1 ASC
  
  ";
    $query = $this->db->query($sql);
  
    
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;
  }
  
  public function compras_por_tienda_mensual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
      $sql = " SELECT  e.EESTABC_Descripcion as nombre ,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
          for($i = 1; $i <= intval($mesFin); $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }else if($j==$anioInicio){
          for($i = intval($mesInicio); $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }else{
          for($i = 1; $i <= 12; $i++)
          {
            $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$j$i,";
          }
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
     FROM cji_comprobante c 
  LEFT JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = c.COMPP_Codigo
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY COMPP_Codigo ORDER BY 1 ASC";
    
    }elseif($anioFin == $anioInicio){
      $sql = " SELECT  e.EESTABC_Descripcion as nombre ,
      ";
      if($mesInicio == $mesFin)
      {
        $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin".intval($mesInicio)."";
      }else{
        for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
        {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as m$anioFin$i,";
        }
        $sql = substr($sql,0,strlen($sql)-1);
      }
      
      $sql.= "
     FROM cji_comprobante c 
  LEFT JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = c.COMPP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
      GROUP BY COMPP_Codigo ORDER BY 1 ASC";
    }

    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
  return $data;
  }
  
  public function compras_por_tienda_anual($inicio,$fin)
  {
    $inicio = explode('-',$inicio);
    $mesInicio = $inicio[1];
    $anioInicio = $inicio[0];
    $fin = explode('-',$fin);
    $mesFin = $fin[1];
    $anioFin = $fin[0];
    
    if($anioFin > $anioInicio)
    {
    
      $sql = " SELECT  e.EESTABC_Descripcion as nombre ,
      ";
      for($j = $anioInicio; $j <= $anioFin; $j++)
      {
        if($j == $anioFin)
        {
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }else{
            $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total),0)) as y$j,";
        }
      }
      $sql = substr($sql,0,strlen($sql)-1);
      
      $sql.= "
     FROM cji_comprobante c 
  LEFT JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = c.COMPP_Codigo
      WHERE YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin'
      GROUP BY COMPP_Codigo ORDER BY 1 ASC";
     
    
    }elseif($anioFin == $anioInicio){
    
      $sql = " SELECT  e.EESTABC_Descripcion as nombre ,
      ";
      $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*c.CPC_Total,c.CPC_Total)) as y$anioFin ";
      $sql.= "
      FROM cji_comprobante c 
  LEFT JOIN cji_emprestablecimiento e ON e.EESTABP_Codigo = c.COMPP_Codigo
      WHERE YEAR(c.CPC_Fecha) = '$anioInicio'
     GROUP BY COMPP_Codigo ORDER BY 1 ASC";
    }
  
    $query = $this->db->query($sql);

    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
  
  return $data;
  }
  
 public function concar_model($filter='')
  {
    $compania = $this->somevar['compania'];
    $sqlNotas = "";
    $where    = "";
    $where_n  = ""; 


    /*if($filter->tipo!="T" && $filter->tipo!=""){
      if($filter->tipo == "C"){*/
        $where .= " AND c.CPC_TipoDocumento IN ('F','B')";
     /* }else{
        $where .= " AND c.CPC_TipoDocumento = '$filter->tipo'";
      }
    }*/
    
    if($filter->forma_pago!=""){
      $where .= " AND c.FORPAP_Codigo='$filter->forma_pago'";
    }

    if($filter->vendedor!=""){
      $where .= " AND c.CPC_Vendedor='$filter->vendedor'";

    }

    if($filter->moneda!=""){
      $where    .= " AND c.MONED_Codigo='$filter->moneda'";
      $where_n  .= " AND c.MONED_Codigo='$filter->moneda'";
    }

    if($filter->consolidado == 0){
      $where    .= " AND c.COMPP_Codigo='$compania'";
      $where_n  .= " AND c.COMPP_Codigo='$compania'";
    }
    $sql = "SELECT 
      c.CPP_Codigo as codigo,
      c.CPC_Fecha as fecha, 
      c.CPC_subtotal as subtotal, 
      c.CPC_igv as igv, 
      c.CPC_total as total, 
      c.CPC_TDC as tdc, 
      c.COMPP_Codigo as compania, 
      c.CPC_Serie as serie, 
      c.CPC_Numero as numero, 
      c.CPC_TipoDocumento as tipo_doc, 
      c.CPC_FlagEstado as estado, 
      c.MONED_Codigo as moneda, 
      m.MONED_Simbolo as moneda_simbolo, 
      m.MONED_Descripcion as moneda_descripcion, 
      c.FORPAP_Codigo as forma_pago,
      fp.FORPAC_Descripcion as forma_pag_desc,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as razon_social_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as numero_documento_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as razon_social_proveedor,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as numero_documento_proveedor, 

      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 1 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as gravada,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 8 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as exonerada,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo = 9 AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as inafecta,
      (SELECT SUM(cd.CPDEC_Subtotal) FROM cji_comprobantedetalle cd WHERE cd.AFECT_Codigo NOT IN(1,8,9) AND cd.CPP_Codigo = c.CPP_Codigo AND cd.CPDEC_FlagEstado = 1) as gratuita

      FROM cji_comprobante c
      LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
      LEFT JOIN cji_formapago fp ON fp.FORPAP_Codigo = c.FORPAP_Codigo
      WHERE  c.CPC_FlagEstado != 2 AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND  c.CPC_Fecha BETWEEN '$filter->fecha1' AND '$filter->fecha2' $where ORDER BY c.CPC_Fecha, c.CPC_Numero
      ";

     $sqlNotas = "SELECT c.CRED_Codigo as codigo, MONTH(c.CRED_Fecha) AS mes, c.CRED_Fecha as fecha, c.CRED_subtotal as subtotal, c.CRED_igv as igv, c.CRED_total as total, c.CRED_TDC as tdc, c.COMPP_Codigo as compania,  c.CRED_Serie as serie, c.CRED_Numero as numero, c.CRED_TipoNota as tipo_doc, c.CRED_FlagEstado as estado, c.MONED_Codigo as moneda, m.MONED_Simbolo as moneda_simbolo, m.MONED_Descripcion as moneda_descripcion,c.CRED_NumeroInicio as sn_doc_modificado,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as razon_social_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_cliente cc
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
      WHERE cc.CLIP_Codigo = c.CLIP_Codigo
      ) as numero_documento_cliente,

      (SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as razon_social_proveedor,

      (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
      FROM cji_proveedor pp
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
      WHERE pp.PROVP_Codigo = c.PROVP_Codigo
      ) as numero_documento_proveedor, 

      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 1 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as gravada,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 8 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as exonerada,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo = 9 AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as inafecta,
      (SELECT SUM(cd.CREDET_Subtotal) FROM cji_notadetalle cd WHERE cd.AFECT_Codigo NOT IN(1,8,9) AND cd.CRED_Codigo = c.CRED_Codigo AND cd.CREDET_FlagEstado = 1) as gratuita

      FROM cji_nota c
      LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo

      WHERE c.CRED_FlagEstado != 2 AND c.CRED_TipoOperacion = '$filter->tipo_oper' AND  c.CRED_Fecha BETWEEN '$filter->fecha1' AND '$filter->fecha2' $where_n ORDER BY c.CRED_Fecha, c.CRED_Numero
      "; 

    $query = $this->db->query($sql);
    $data = array();
    #if($filter->tipo=="T" || $filter->tipo==""){
      if ($query->num_rows > 0) {
        foreach ($query->result() as $fila) {
          $data[] = $fila;
        }
      }
    #}

    if ( $sqlNotas != "" ){
      $queryNotas = $this->db->query($sqlNotas);
      if ($queryNotas->num_rows > 0) {
        foreach ($queryNotas->result() as $fila) {
          $data[] = $fila;
        }
      }
    }

        return $data;
  }

  public function detalles_concar_comprobantes($comprobante){
        $sql = "SELECT cd.CPDEC_Subtotal as det_subtotal, cd.CPDEC_Total as det_total,cd.CPDEC_Igv as det_igv, pr.PROD_CodigoInterno, pr.PROD_CodigoUsuario, pr.PROD_CodigoOriginal, pr.PROD_FlagBienServicio, pr.PROD_Nombre, um.UNDMED_Simbolo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion, 
                    l.LOTC_Numero, l.LOTC_FechaVencimiento

                    FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto pr ON cd.PROD_Codigo = pr.PROD_Codigo
                    LEFT JOIN cji_marca m ON m.MARCP_Codigo = pr.MARCP_Codigo
                    LEFT JOIN cji_unidadmedida um ON um.UNDMED_Codigo = cd.UNDMED_Codigo
                    LEFT JOIN cji_lote l ON l.LOTP_Codigo = cd.LOTP_Codigo
                        WHERE cd.CPP_Codigo = $comprobante AND cd.CPDEC_FlagEstado = 1
                ";

        $query = $this->db->query($sql);
        
        if( $query->num_rows > 0 ){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
        else
            return NULL;
    }
  
    public function detalle_concar_nota($comprobante){
        /*$where = array("CRED_Codigo"=>$comprobante,"CREDET_FlagEstado"=>"1");
        $query = $this->db->order_by('CREDET_Codigo')->where($where)->get('cji_notadetalle');*/

        // Cambios para mostrar el TDC al editar una nota de credito - Rawil

        $sql = "SELECT n.CRED_TDC, n.MONED_Codigo, n.CRED_ComproInicio, nd.CREDET_Subtotal as det_subtotal, nd.CREDET_Igv as det_igv, nd.CREDET_Total as det_total,nd.CREDET_Codigo,nd.CREDET_FlagEstado,nd.PROD_Codigo,
                    pr.PROD_CodigoInterno, pr.PROD_CodigoUsuario, pr.PROD_CodigoOriginal, pr.PROD_FlagBienServicio, pr.PROD_Nombre, um.UNDMED_Simbolo, m.MARCC_CodigoUsuario, m.MARCC_Descripcion,
                    l.LOTC_Numero, l.LOTC_FechaVencimiento
                    
                    FROM `cji_notadetalle` nd
                    INNER JOIN cji_nota n ON n.CRED_Codigo = nd.CRED_Codigo

                        INNER JOIN cji_producto pr ON nd.PROD_Codigo = pr.PROD_Codigo
                        LEFT JOIN cji_marca m ON m.MARCP_Codigo = pr.MARCP_Codigo
                        LEFT JOIN cji_unidadmedida um ON um.UNDMED_Codigo = nd.UNDMED_Codigo
                        LEFT JOIN cji_lote l ON l.LOTP_Codigo = nd.LOTP_Codigo

                        WHERE nd.`CRED_Codigo` = $comprobante AND nd.`CREDET_FlagEstado` = 1
                        ORDER BY nd.CREDET_Codigo
                ";

        $query = $this->db->query($sql);
        if($query->num_rows>0){
            foreach($query->result() as $fila){
                $data[] = $fila;
            }
            return $data;
        }
    }

    public function excel_reporte_por_producto_comprador($finicio, $ffin,$vendedor)
  {
        $empresa = $_SESSION['empresa'];
        $compania = $_SESSION['compania'];
        $where="";
        if(isset($vendedor) && $vendedor!=""){
          $where.= " AND c.CPC_Vendedor= $vendedor";
        }
       $productos = "SELECT pp.PROD_CodigoUsuario, pp.PROD_Nombre, m.MARCC_CodigoUsuario, 
                  (
                    SELECT SUM(cd.CPDEC_Cantidad) FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania $where
                  ) as cantidadTotal,
                  (
                    SELECT SUM(cd.CPDEC_Total) FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania $where
                  ) as ventaTotal,
                  (
                    SELECT cd.UNDMED_Codigo FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania $where GROUP BY p.PROD_Codigo
                  ) as unidad

                FROM cji_producto pp
                INNER JOIN cji_productocompania pc ON pc.PROD_Codigo = pp.PROD_Codigo AND pc.COMPP_Codigo = $compania
                LEFT JOIN cji_marca m ON m.MARCP_Codigo = pp.MARCP_Codigo
                
                WHERE (
                      SELECT SUM(cd.CPDEC_Cantidad) FROM cji_comprobantedetalle cd
                      INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                      INNER JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                      WHERE c.CPC_Fecha BETWEEN '$finicio 00:00:00' AND '$ffin 23:59:59' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND p.PROD_Codigo = pp.PROD_Codigo AND c.CPC_TipoOperacion = 'C' AND c.COMPP_Codigo = $compania $where
                    ) IS NOT NULL 

                ORDER BY pp.PROD_Nombre ASC
              ";
    $productosInfo = $this->db->query($productos);
    
    $data = array();
    if($productosInfo->num_rows > 0){
      foreach($productosInfo->result_array() as $result){
        $data[] = $result;
      }
    }
    return $data;

  }

  public function ganancia_global($filter)
  {
        $limit = "";#( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "";#"ORDER BY c.CPC_Fecha desc";#( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";
        $where = "";
        $ompania= $_SESSION['compania'];
        if($filter->producto != '')
            $where .= " AND cd.PROD_Codigo = $filter->producto ";
        if($filter->moneda != '')
            $where .= " AND c.MONED_Codigo = $filter->moneda ";
        if($filter->vendedor != '')
            $where .= " AND c.CPC_Vendedor = $filter->vendedor ";
           
        $whereCompanias = "";
        if ($filter->compania>=0) {
          if ($filter->compania==0) {
            $where .= "";
          }else{
            $where .= " AND c.COMPP_Codigo = $filter->compania ";
          }
        }else{
          $where .= " AND c.COMPP_Codigo = $ompania";
        }
        
        
        $sql = "SELECT 

                (SELECT count(c.CPP_Codigo) FROM cji_comprobante c LEFT JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo WHERE c.CPC_TipoOperacion = 'C' AND c.CPC_FlagEstado = 1   AND c.CPC_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$filter->fechaf 23:59:59' $where GROUP BY cd.CPP_Codigo) as total_comp,
                
                CASE 
                WHEN SUM(p.PROD_UltimoCosto*cd.CPDEC_Cantidad) IS NULL THEN 0
                ELSE SUM(p.PROD_UltimoCosto*cd.CPDEC_Cantidad) 
                END AS costo_total,

                CASE 
                WHEN SUM(cd.CPDEC_Total) IS NULL THEN 0
                ELSE SUM(cd.CPDEC_Total) 
                END AS venta_total,

                CASE 
                WHEN SUM(cd.CPDEC_Total) -SUM(p.PROD_UltimoCosto*cd.CPDEC_Cantidad) IS NULL THEN 0
                ELSE SUM(cd.CPDEC_Total) -SUM(p.PROD_UltimoCosto*cd.CPDEC_Cantidad) 
                END AS utilidad

                FROM cji_comprobantedetalle cd
                INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                
                LEFT JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                
               
                    WHERE c.CPC_TipoOperacion = 'C' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$filter->fechaf 23:59:59'  $where ORDER BY c.CPC_Numero desc";

        $query = $this->db->query($sql);

        if($query->num_rows>0)
            return $query->result();
        else
            return 0;
  }

    public function reporte_ganancia($filter=null){

        $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
        $order = "";#"ORDER BY c.CPC_Fecha desc";#( isset($filter->order) && isset($filter->dir) ) ? "ORDER BY $filter->order $filter->dir " : "";
        $where = "";
        $empresa = $_SESSION['empresa'];
        $ompania = $_SESSION['compania'];

        if($filter->producto != '')
            $where .= " AND cd.PROD_Codigo = $filter->producto ";
        if($filter->moneda != '')
            $where .= " AND c.MONED_Codigo = $filter->moneda ";
           
        $whereCompanias = "";
        if ($filter->compania>=0) {
          if ($filter->compania==0) {
            $where .= "";
          }else{
            $where .= " AND c.COMPP_Codigo = $filter->compania ";

          }
        }else{
          $where .= " AND c.COMPP_Codigo = $ompania";
        }
        
        $sql = "SELECT cd.*, m.MONED_Simbolo, c.CPC_Fecha,c.CPC_Numero, c.COMPP_Codigo, ee.EESTABC_Descripcion, p.PROD_Nombre,p.PROD_UltimoCosto, c.MONED_Codigo
                    FROM cji_comprobantedetalle cd
                    LEFT JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    LEFT JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                    LEFT JOIN  cji_compania co ON co.COMPP_Codigo = c.COMPP_Codigo
                    LEFT JOIN cji_emprestablecimiento ee ON ee.EESTABP_Codigo = co.EESTABP_Codigo
                        WHERE co.EMPRP_Codigo = $empresa AND c.CPC_TipoOperacion = 'C' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_Fecha BETWEEN '$filter->fechai 00:00:00' AND '$filter->fechaf 23:59:59' $where ORDER BY c.CPC_Numero desc $limit 
                ";

        $query = $this->db->query($sql);

        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }

    public function reporte_ganancia_old($producto, $f_ini, $f_fin, $companias='',$moneda='')
    {

        $where = "";
        $empresa = $_SESSION['empresa'];

        if ($producto != '') {
            $where .= " AND cd.PROD_Codigo = $producto ";
        }

        


        if (trim($moneda) != '') {

            $where .= " AND c.MONED_Codigo = $moneda ";
        }



        $sql = "SELECT cd.*, m.MONED_Simbolo, c.CPC_Fecha, c.COMPP_Codigo, ee.EESTABC_Descripcion, p.PROD_Nombre, p.PROD_UltimoCosto, apl.ALMALOTC_Costo, l.LOTC_Numero, l.LOTC_FechaVencimiento
                    FROM cji_comprobantedetalle cd
                    INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
                    LEFT JOIN cji_almaprolote apl ON apl.LOTP_Codigo = cd.LOTP_Codigo
                    LEFT JOIN cji_lote l ON l.LOTP_Codigo = cd.LOTP_Codigo
                    LEFT JOIN cji_producto p ON p.PROD_Codigo = cd.PROD_Codigo
                    LEFT JOIN cji_moneda m ON m.MONED_Codigo = c.MONED_Codigo
                    LEFT JOIN  cji_compania co ON co.COMPP_Codigo = c.COMPP_Codigo
                    LEFT JOIN cji_emprestablecimiento ee ON ee.EESTABP_Codigo = co.EESTABP_Codigo
                        WHERE co.EMPRP_Codigo = $empresa AND c.CPC_TipoOperacion = 'C' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND c.CPC_Fecha BETWEEN '$f_ini 00:00:00' AND '$f_fin 23:59:59' $where
                ";

        $query = $this->db->query($sql);

        if($query->num_rows>0)
            return $query->result();
        else
            return array();
        
    }

    //REPORTE PRODUCTO MAS VENDIDO
      public function reporte_productos_masComprados($filters = null, $tipoOperacion = 'C')
      {
        $query = $this->db->select('
                  SUM(cppdet.CPDEC_Cantidad) as cantidadProd, 
                  count(cpp.CPP_Codigo) as cantTipoDoc, 
                  pro.PROD_Nombre, 
                  SUM(pro.PROD_UltimoCosto),
                  pro.PROD_Codigo AS idProduct,
                  und.UNDMED_Descripcion, 
                  SUM(cppdet.CPDEC_Total) AS totalPU,
                  cpp.MONED_Codigo AS idMoneda,
                  cpp.CPC_TDC AS montoTC')
                ->from('cji_comprobantedetalle cppdet')
                ->join('cji_comprobante cpp', 'cpp.CPP_Codigo=cppdet.CPP_Codigo', 'LEFT')
                ->join('cji_producto pro', 'pro.PROD_Codigo=cppdet.PROD_Codigo AND pro.PROD_FlagEstado=1', 'LEFT')
                ->join('cji_productounidad pround', 'pround.PROD_Codigo=pro.PROD_Codigo AND pround.PRODUNIC_flagEstado =1', 'LEFT')
                ->join('cji_unidadmedida und', 'und.UNDMED_Codigo=pround.UNDMED_Codigo AND und.UNDMED_FlagEstado=1', 'LEFT')
                ->join('cji_nota nota', "nota.CRED_NumeroInicio=CONCAT_WS(cpp.CPC_Numero,' - ',cpp.CPC_Serie) AND nota.CRED_FlagEstado=1 AND nota.DOCUP_Codigo IN (4,5,9)", 'LEFT')
                ->join('cji_notadetalle notadet', 'notadet.CRED_Codigo=nota.CRED_Codigo AND notadet.CREDET_FlagEstado=1', 'LEFT')
                ->where([
                  'cpp.CPC_FlagEstado' => 1,
                  'cppdet.CPDEC_FlagEstado' => 1,
                  'cpp.CPC_TipoOperacion' => $tipoOperacion ,
                  'cpp.COMPP_Codigo' => $this->somevar['compania']
                ])
                ->order_by('cantidadProd', 'DESC')
                ->group_by('pro.PROD_Codigo');
        
        if (isset($filters->fecha1) and !empty($filters->fecha1))
        {
          $query->where('cpp.CPC_Fecha >=', $filters->fecha1);
        }

        if (isset($filters->fecha2) and !empty($filters->fecha2))
        {
          $query->where('cpp.CPC_Fecha <=', $filters->fecha2);
        }

        if (isset($filters->tipo_doc) and !empty($filters->tipo_doc))
        {
          $query->where('cpp.CPC_TipoDocumento', $filters->tipo_doc);
        }
      
        if (isset($filters->forma_pago) and !empty($filters->forma_pago))
        {
          $query->where('cpp.FORPAP_Codigo', $filters->forma_pago);
        }

        if (isset($filters->vendedor) and !empty($filters->vendedor))
        {
          $query->where('cpp.CPC_Vendedor', $filters->vendedor);
        }

        if (isset($filters->moneda) and !empty($filters->moneda))
        {
          $query->where('cpp.MONED_Codigo', $filters->moneda);
        }

        if (isset($filters->idProduct) and !empty($filters->idProduct))
        {
          $query->where('pro.PROD_Codigo', $filters->idProduct);
        }
      
        return $query->get()->result();
      }
    //FIN 

    //REPORTE DE VENTAS POR PRODUCTO
      public function productos_comprados_general($filter = NULL, $onlyRecords = true)
      {
          
          $compania = $this->somevar['compania'];

          $limit = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
          $order = (isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

          $filter->fech1 = ($filter->fech1 == NULL || $filter->fech1 == "0") ? date("Y-m-d 00:00:00") : "$filter->fech1 00:00:00";
          $filter->fech2 = ($filter->fech2 == NULL || $filter->fech2 == "0") ? date("Y-m-d 23:59:59") : "$filter->fech2 23:59:59";
          $where  = "";
          $where1 = "";

          if (isset($filter->producto) && $filter->producto!="") {
            $where  .= " AND p.PROD_Codigo=$filter->producto";
          }

          if (isset($filter->cliente) && $filter->cliente!="") {
            $where  .= " AND c.CLIP_Codigo = $filter->cliente";
            $where1 .= " AND cs.CLIP_Codigo = $filter->cliente";
          }

          if (isset($filter->moneda) && $filter->moneda!="") {
            $where  .= " AND c.MONED_Codigo = $filter->moneda";
            $where1 .= " AND cs.MONED_Codigo = $filter->moneda";
          }else{
            $where  .= " AND c.MONED_Codigo = '1'";
            $where1 .= " AND cs.MONED_Codigo = '1'";
          }

          $rec = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recF = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, SUM(cd.CPDEC_Total) as suma,
          
          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as cantidad_documentos,
          
          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recT = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, SUM(cd.CPDEC_Total) as suma,
          
          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as cantidad_documentos,
          
          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper'
          GROUP BY cd.PROD_Codigo
          ";

          $records = $this->db->query($rec);

          if ($onlyRecords == false) {
              $recordsFilter = $this->db->query($recF)->num_rows();
              $recordsTotal = $this->db->query($recT)->num_rows();
          }


          if ($records->num_rows() > 0) {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => $records->result(),
                      "recordsFilter" => $recordsFilter,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          } else {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => NULL,
                      "recordsFilter" => 0,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          }
          return $info;
      }

      public function productos_comprados_detalle($filter)
      {
        $compania = $this->somevar['compania'];
        $limit    = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
        $order    = (isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

        $filter->fech1 = ($filter->fech1 == NULL) ? date("Y-m-d 00:00:00") : "$filter->fech1";
        $filter->fech2 = ($filter->fech2 == NULL) ? date("Y-m-d 23:59:59") : "$filter->fech2";
        $where  = "";
        $where1 = "";

        if (isset($filter->producto) && $filter->producto!="") {
          $where  .= " AND cd.PROD_Codigo=$filter->producto";
        }

        if (isset($filter->cliente) && $filter->cliente!="") {
          $where  .= " AND c.CLIP_Codigo = $filter->cliente";
          $where1 .= " AND cs.CLIP_Codigo = $filter->cliente";
        }

        if (isset($filter->moneda) && $filter->moneda!="") {
          $where  .= " AND c.MONED_Codigo = $filter->moneda";
          $where1 .= " AND cs.MONED_Codigo = $filter->moneda";
        }

if ($filter->tipo_oper=="C") {
  $razon_social="(SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
  FROM cji_cliente cc
  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
  LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
  WHERE cc.CLIP_Codigo = c.CLIP_Codigo
  ) as Nombre,

  (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
  FROM cji_cliente cc
  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cc.EMPRP_Codigo
  LEFT JOIN cji_persona p ON p.PERSP_Codigo = cc.PERSP_Codigo
  WHERE cc.CLIP_Codigo = c.CLIP_Codigo
  ) as Documento,";
 
}else{
  $razon_social="(SELECT CONCAT_WS(' ', e.EMPRC_RazonSocial, p.PERSC_Nombre, p.PERSC_ApellidoPaterno, p.PERSC_ApellidoMaterno)
  FROM cji_proveedor pp
  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
  LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
  WHERE pp.PROVP_Codigo = c.PROVP_Codigo
  ) as Nombre,

  (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, p.PERSC_NumeroDocIdentidad)
  FROM cji_proveedor pp
  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = pp.EMPRP_Codigo
  LEFT JOIN cji_persona p ON p.PERSP_Codigo = pp.PERSP_Codigo
  WHERE pp.PROVP_Codigo = c.PROVP_Codigo
  ) as Documento, ";
}

        $where  .= " AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' ";

        $rec = "SELECT c.CPC_Fecha as fecha, c.CPC_FechaRegistro, c.CPC_Serie as serie, c.CPC_Numero as numero, cd.*, pd.PROD_Nombre, m.MARCC_CodigoUsuario, c.CLIP_Codigo, mo.MONED_Simbolo as moneda_simbolo, mo.MONED_Codigo, und.UNDMED_Simbolo as unidad, pd.PROD_CodigoUsuario as prod_cod, 
                  
              $razon_social

              n.CRED_Serie, n.CRED_Numero, nd.CREDET_Cantidad, nd.CREDET_Pu_ConIgv, nd.CREDET_Total

              FROM cji_comprobantedetalle cd
              INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
              LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
              LEFT JOIN  cji_notadetalle nd ON nd.CRED_Codigo = n.CRED_Codigo AND nd.CREDET_FlagEstado = 1 AND nd.PROD_Codigo = cd.PROD_Codigo
             
             
              INNER JOIN cji_producto pd ON pd.PROD_Codigo = cd.PROD_Codigo
              LEFT JOIN cji_marca m ON m.MARCP_Codigo = pd.MARCP_Codigo
              LEFT JOIN cji_moneda mo ON mo.MONED_Codigo = c.MONED_Codigo
              LEFT JOIN cji_unidadmedida und ON und.UNDMED_Codigo = cd.UNDMED_Codigo
              
              WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion LIKE '$filter->tipo_oper' $where
              ORDER BY c.CPC_Fecha, c.CPC_Numero ASC

        ";

          $recF = "SELECT c.CPC_Fecha as fecha, c.CPC_FechaRegistro, c.CPC_Serie as serie, c.CPC_Numero as numero, cd.*, pd.PROD_Nombre, m.MARCC_CodigoUsuario, c.CLIP_Codigo, mo.MONED_Simbolo as moneda_simbolo, mo.MONED_Codigo, und.UNDMED_Simbolo as unidad, pd.PROD_CodigoUsuario as prod_cod, 
                  
             $razon_social

              n.CRED_Serie, n.CRED_Numero, nd.CREDET_Cantidad, nd.CREDET_Pu_ConIgv, nd.CREDET_Total

              FROM cji_comprobantedetalle cd
              INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
              LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
              LEFT JOIN  cji_notadetalle nd ON nd.CRED_Codigo = n.CRED_Codigo AND nd.CREDET_FlagEstado = 1 AND nd.PROD_Codigo = cd.PROD_Codigo
              
              INNER JOIN cji_producto pd ON pd.PROD_Codigo = cd.PROD_Codigo
              LEFT JOIN cji_marca m ON m.MARCP_Codigo = pd.MARCP_Codigo
              LEFT JOIN cji_moneda mo ON mo.MONED_Codigo = c.MONED_Codigo
              LEFT JOIN cji_unidadmedida und ON und.UNDMED_Codigo = cd.UNDMED_Codigo
              
              WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' $where
              ORDER BY c.CPC_Fecha, c.CPC_Numero ASC

        ";
            $recT = "SELECT c.CPC_Fecha as fecha, c.CPC_FechaRegistro, c.CPC_Serie as serie, c.CPC_Numero as numero, cd.*, pd.PROD_Nombre, m.MARCC_CodigoUsuario, c.CLIP_Codigo, mo.MONED_Simbolo as moneda_simbolo, mo.MONED_Codigo, und.UNDMED_Simbolo as unidad, pd.PROD_CodigoUsuario as prod_cod, 
                  
             $razon_social

              n.CRED_Serie, n.CRED_Numero, nd.CREDET_Cantidad, nd.CREDET_Pu_ConIgv, nd.CREDET_Total

              FROM cji_comprobantedetalle cd
              INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
              LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
              LEFT JOIN  cji_notadetalle nd ON nd.CRED_Codigo = n.CRED_Codigo AND nd.CREDET_FlagEstado = 1 AND nd.PROD_Codigo = cd.PROD_Codigo
              
              INNER JOIN cji_producto pd ON pd.PROD_Codigo = cd.PROD_Codigo
              LEFT JOIN cji_marca m ON m.MARCP_Codigo = pd.MARCP_Codigo
              LEFT JOIN cji_moneda mo ON mo.MONED_Codigo = c.MONED_Codigo
              LEFT JOIN cji_unidadmedida und ON und.UNDMED_Codigo = cd.UNDMED_Codigo
              
              WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' 
              ORDER BY c.CPC_Fecha, c.CPC_Numero ASC

        ";

            $records = $this->db->query($rec);

            if ($onlyRecords == false) {
                $recordsFilter = $this->db->query($recF)->num_rows();
                $recordsTotal = $this->db->query($recT)->num_rows();
            }


            if ($records->num_rows() > 0) {
                if ($onlyRecords == false) {
                    $info = array(
                        "records" => $records->result(),
                        "recordsFilter" => $recordsFilter,
                        "recordsTotal" => $recordsTotal
                    );
                } else {
                    $info = $records->result();
                }
            } else {
                if ($onlyRecords == false) {
                    $info = array(
                        "records" => NULL,
                        "recordsFilter" => 0,
                        "recordsTotal" => $recordsTotal
                    );
                } else {
                    $info = $records->result();
                }
            }
            return $info;
      }


      public function compras_producto_mes($filter)
      {
        $compania = $this->somevar['compania'];

          $limit = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
          $order = (isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

          $filter->fech1 = ($filter->fech1 == NULL) ? date("Y-m-d") : $filter->fech1."-01";
          $filter->fech2 = ($filter->fech2 == NULL) ? date("Y-m-d") : $filter->fech2."-01";
          $where  = "";
          $where1 = "";

          if (isset($filter->producto) && $filter->producto!="") {
            $where  .= " AND p.PROD_Codigo=$filter->producto";
          }

          if (isset($filter->cliente) && $filter->cliente!="") {
            $where  .= " AND c.CLIP_Codigo = $filter->cliente";
            $where1 .= " AND cs.CLIP_Codigo = $filter->cliente";
          }

          if (isset($filter->moneda) && $filter->moneda!="") {
            $where  .= " AND c.MONED_Codigo = $filter->moneda";
            $where1 .= " AND cs.MONED_Codigo = $filter->moneda";
          }else{
            $where  .= " AND c.MONED_Codigo = '1'";
            $where1 .= " AND cs.MONED_Codigo = '1'";
          }

          $meses = "";

          foreach ($filter->listaMeses as $key => $value) {
            $valor = explode("-",$value);
            $a«Ðo = $valor[0];
            $mes = $valor[1];

            $meses .= "(SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = 'C' AND YEAR(cs.CPC_Fecha) = '$a«Ðo' AND MONTH(cs.CPC_Fecha) = '$mes' AND cds.PROD_Codigo = cd.PROD_Codigo $where1) as Mes_$key, ";


          }

          $rec = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          $meses

          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recF = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

         
          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recT = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          
          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND c.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' 
          GROUP BY cd.PROD_Codigo
          ";

          $records = $this->db->query($rec);

          if ($onlyRecords == false) {
              $recordsFilter = $this->db->query($recF)->num_rows();
              $recordsTotal = $this->db->query($recT)->num_rows();
          }

          if ($records->num_rows() > 0) {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => $records->result(),
                      "recordsFilter" => $recordsFilter,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          } else {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => NULL,
                      "recordsFilter" => 0,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          }
          return $info;
      }

      public function compras_producto_anio($filter)
      {
        $compania = $this->somevar['compania'];

          $limit = (isset($filter->start) && isset($filter->length)) ? " LIMIT $filter->start, $filter->length " : "";
          $order = (isset($filter->order) && isset($filter->dir)) ? "ORDER BY $filter->order $filter->dir " : "";

          $filter->fech1 = ($filter->fech1 == NULL) ? date("Y-m-d") : $filter->fech1."-01";
          $filter->fech2 = ($filter->fech2 == NULL) ? date("Y-m-d") : $filter->fech2."-01";
          $where  = "";
          $where1 = "";

          if (isset($filter->producto) && $filter->producto!="") {
            $where  .= " AND p.PROD_Codigo=$filter->producto";
          }

          if (isset($filter->cliente) && $filter->cliente!="") {
            $where  .= " AND c.CLIP_Codigo = $filter->cliente";
            $where1 .= " AND cs.CLIP_Codigo = $filter->cliente";
          }

          if (isset($filter->moneda) && $filter->moneda!="") {
            $where  .= " AND c.MONED_Codigo = $filter->moneda";
            $where1 .= " AND cs.MONED_Codigo = $filter->moneda";
          }else{
            $where  .= " AND c.MONED_Codigo = '1'";
            $where1 .= " AND cs.MONED_Codigo = '1'";
          }

          $anios = "";

          foreach ($filter->listaAnios as $key => $value) {
            $anio = $value;
            
            $anios .= "(SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) = '$anio' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as Anio_$key, ";
          }

          $rec = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          $anios

          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(c.CPC_Fecha )BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recF = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(c.CPC_Fecha )BETWEEN '$filter->fech1' AND '$filter->fech2' $where
          GROUP BY cd.PROD_Codigo
          ";

          $recT = "SELECT p.PROD_CodigoUsuario, p.PROD_Nombre, m.MARCC_Descripcion, mo.MONED_Simbolo, SUM(cd.CPDEC_Total) as suma,

          (SELECT COUNT(cs.CPP_Codigo) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_documentos,

          (SELECT GROUP_CONCAT( CONCAT_WS('-',cs.CPC_Serie, cs.CPC_Numero) ) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND cs.CPC_Fecha BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 GROUP BY cds.PROD_Codigo $where) as documentos,

          (SELECT SUM(cds.CPDEC_Cantidad) FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cds.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = 1 AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as cantidad_vendidos,

          (SELECT SUM(cds.CPDEC_Total)    FROM cji_comprobante cs INNER JOIN cji_comprobantedetalle cds ON cds.CPP_Codigo = cs.CPP_Codigo WHERE cs.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 AND cs.COMPP_Codigo = $compania AND cs.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(cs.CPC_Fecha) BETWEEN '$filter->fech1' AND '$filter->fech2' AND cds.PROD_Codigo = cd.PROD_Codigo AND cs.CPP_Codigo_Canje = 0 $where1) as total_venta

          FROM cji_producto p
          LEFT JOIN cji_marca m ON m.MARCP_Codigo = p.MARCP_Codigo
          INNER JOIN cji_comprobantedetalle cd ON cd.PROD_Codigo = p.PROD_Codigo
          INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
          LEFT JOIN cji_moneda mo ON c.MONED_Codigo = mo.MONED_Codigo
          WHERE c.CPC_FlagEstado = 1 AND c.CPP_Codigo_Canje = 0 AND cd.CPDEC_FlagEstado = 1 AND c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion = '$filter->tipo_oper' AND YEAR(c.CPC_Fecha )BETWEEN '$filter->fech1' AND '$filter->fech2'
          GROUP BY cd.PROD_Codigo
          ";

          $records = $this->db->query($rec);

          if ($onlyRecords == false) {
              $recordsFilter = $this->db->query($recF)->num_rows();
              $recordsTotal = $this->db->query($recT)->num_rows();
          }


          if ($records->num_rows() > 0) {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => $records->result(),
                      "recordsFilter" => $recordsFilter,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          } else {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => NULL,
                      "recordsFilter" => 0,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          }
          return $info;
      }
      
      public function anios_para_reportes($tipo) {
          $sql = "SELECT YEAR(CPC_Fecha) as anio FROM cji_comprobante WHERE CPC_TipoOperacion='" . $tipo . "' GROUP BY YEAR(CPC_Fecha)";
          $query = $this->db->query($sql);
          if ($query->num_rows > 0) {
              foreach ($query->result() as $fila) {
                  $data[] = $fila;
              }
              return $data;
          }
          return array();
      }

      //OLDS
        public function compras_por_producto_resumen($inicio,$fin)
        {
          $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
          p.PROD_Nombre AS NOMBRE,p.PROD_Comentario as comentario,
          SUM( IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total) ) AS VENTAS
          FROM cji_comprobantedetalle cd
          JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."

          JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
          WHERE c.CPC_FlagEstado=1 and c.CPC_Fecha BETWEEN DATE('$inicio') AND DATE('$fin') and c.CPC_TipoOperacion = 'C'
          GROUP BY p.PROD_Codigo";
          $query = $this->db->query($sql);

          $data = array();
          if($query->num_rows > 0)
          {
          foreach($query->result_array() as $result)
          {
          $data[] = $result;
          }
          }
          return $data;
        }

        public function compras_por_producto_mensual($inicio,$fin)
        {
          $inicio     = explode('-',$inicio);
          $mesInicio  = $inicio[1];
          $anioInicio = $inicio[0];
          $fin        = explode('-',$fin);
          $mesFin     = $fin[1];
          $anioFin    = $fin[0];

          if($anioFin > $anioInicio)
          {
            $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
            p.PROD_Nombre AS NOMBRE,
            ";
            for($j = $anioInicio; $j <= $anioFin; $j++)
            {
              if($j == $anioFin)
              {
                for($i = 1; $i <= intval($mesFin); $i++)
                {
                  $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
                }
              }else if($j==$anioInicio){
                for($i = intval($mesInicio); $i <= 12; $i++)
                {
                  $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
                }
              }else{
                for($i = 1; $i <= 12; $i++)
                {
                  $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i AND YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$j$i,";
                }
              }
            }
            $sql = substr($sql,0,strlen($sql)-1);

            $sql.= ", p.PROD_Comentario as comentario
            FROM cji_comprobantedetalle cd
            JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']." JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
            WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and and c.CPC_TipoOperacion = 'C'
            GROUP BY p.PROD_Nombre";

          }elseif($anioFin == $anioInicio){
          $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
          p.PROD_Nombre AS NOMBRE,
          ";
          if($mesInicio == $mesFin)
          {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=".intval($mesInicio).",IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin".intval($mesInicio)."";
          }else{
          for($i = intval($mesInicio); $i <= intval($mesFin); $i++)
          {
          $sql .= "SUM(IF(MONTH(CPC_Fecha)=$i,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as m$anioFin$i,";
          }
          $sql = substr($sql,0,strlen($sql)-1);
          }

          $sql.= " , p.PROD_Comentario as comentario
          FROM cji_comprobantedetalle cd
          JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
          JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo

          WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) = '$anioInicio' and c.CPC_TipoOperacion = 'C'
          GROUP BY p.PROD_Nombre";
          }

          $query = $this->db->query($sql);

          $data = array();
          if($query->num_rows > 0)
          {
          foreach($query->result_array() as $result)
          {
          $data[] = $result;
          }
          }

          return $data;
        }

        public function compras_por_producto_anual($inicio,$fin)
        {
          $inicio = explode('-',$inicio);
          $mesInicio = $inicio[1];
          $anioInicio = $inicio[0];
          $fin = explode('-',$fin);
          $mesFin = $fin[1];
          $anioFin = $fin[0];

          if($anioFin > $anioInicio)
          {

          $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
          p.PROD_Nombre AS NOMBRE,
          ";
          for($j = $anioInicio; $j <= $anioFin; $j++)
          {
          if($j == $anioFin)
          {
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
          }else{
          $sql .= "SUM(IF(YEAR(CPC_Fecha)=$j,IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total),0)) as y$j,";
          }
          }
          $sql = substr($sql,0,strlen($sql)-1);

          $sql.= "  p.PROD_Comentario as comentario
          FROM cji_comprobantedetalle cd
          JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
          JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
          WHERE c.CPC_FlagEstado=1 and YEAR(c.CPC_Fecha) BETWEEN '$anioInicio' AND '$anioFin' and c.CPC_TipoOperacion = 'C'
          GROUP BY  p.PROD_Nombre";

          }elseif($anioFin == $anioInicio){

          $sql = "SELECT p.PROD_CodigoUsuario as codigo, SUM(cd.CPDEC_Cantidad) as cantidad,
          p.PROD_Nombre AS NOMBRE,
          ";
          $sql .= "SUM(IF(c.MONED_Codigo=2,c.CPC_TDC*cd.CPDEC_Total,cd.CPDEC_Total)) as y$anioFin ";
          $sql.= "  , p.PROD_Comentario as comentario
          FROM cji_comprobantedetalle cd
          JOIN cji_comprobante c ON cd.CPP_Codigo = c.CPP_Codigo and c.COMPP_Codigo=".$this->somevar ['compania']."
          JOIN cji_producto p ON cd.PROD_Codigo = p.PROD_Codigo
          WHERE c.CPC_FlagEstado=1 and  YEAR(c.CPC_Fecha) = '$anioInicio' and c.CPC_TipoOperacion = 'C'
          GROUP BY  p.PROD_Nombre";
          }

          $query = $this->db->query($sql);

          $data = array();
          if($query->num_rows > 0)
          {
          foreach($query->result_array() as $result)
          {
          $data[] = $result;
          }
          }

          return $data;
        }
      //OLDS FIN

    //FIN REPORTE DE VENTAS POR PRODUCTO





















      public function estadisticas_compras_ventas_cliente($filter) {

          $compania = $this->somevar['compania'];

          if ($filter->tipo_oper == 'V'){
              $rec = "SELECT p.CLIP_Codigo, MONTH(c.CPC_FechaRegistro) 
                  AS mes, c.CPC_FechaRegistro,SUM(c.CPC_total) AS monto ,
                 CASE p.CLIC_TipoPersona
                      WHEN 0 THEN pe.PERSC_NumeroDocIdentidad
                      WHEN 1 THEN e.EMPRC_Ruc
                      ELSE ''
                  END as numero,
                  CASE p.CLIC_TipoPersona
                      WHEN 0 THEN CONCAT_WS(' ', pe.PERSC_Nombre, pe.PERSC_ApellidoPaterno, pe.PERSC_ApellidoMaterno)
                      WHEN 1 THEN e.EMPRC_RazonSocial
                      ELSE ''
                  END as razon_social
                  FROM cji_cliente p 
                  INNER JOIN cji_comprobante c ON p.CLIP_Codigo = c.CLIP_Codigo
                  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.CLIC_TipoPersona='1'
                  LEFT JOIN cji_persona pe ON pe.PERSP_Codigo=p.PERSP_Codigo AND p.CLIC_TipoPersona='0' 
                  WHERE c.COMPP_Codigo = $compania AND c.CPC_TipoOperacion='V' AND YEAR(CPC_Fecha)='$filter->anio' AND CPC_TipoDocumento='F' 
                  GROUP BY c.CLIP_Codigo,MONTH(CPC_FechaRegistro)
                  ";

          }
          else{
              $rec = "SELECT p.PROVP_Codigo,e.EMPRC_RazonSocial,MONTH(c.CPC_FechaRegistro) 
                  AS mes,c.CPC_FechaRegistro,SUM(c.CPC_total) AS monto ,
                  (SELECT CONCAT_WS(' ', e.EMPRC_Ruc, ' - ', e.EMPRC_RazonSocial) FROM cji_empresa e WHERE e.EMPRP_Codigo = p.EMPRP_Codigo) as clienteEmpresa,
                  (SELECT CONCAT_WS(' ', pp.PERSC_NumeroDocIdentidad, ' - ', pp.PERSC_Nombre, pp.PERSC_ApellidoPaterno, pp.PERSC_ApellidoMaterno) FROM cji_persona pp WHERE pp.PERSP_Codigo = p.PERSP_Codigo) as clientePersona,

                  FROM cji_proveedor p 
                  INNER JOIN cji_comprobante c ON p.PROVP_Codigo = c.PROVP_Codigo
                  LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=p.EMPRP_Codigo AND p.PROVC_TipoPersona='1'
                  WHERE c.COMPP_Codigo = $compania AND  c.CPC_TipoOperacion='" . $tipo . "' AND YEAR(CPC_FechaRegistro)=" . $anio . " AND CPC_TipoDocumento='F' 
                  GROUP BY c.PROVP_Codigo,MONTH(CPC_FechaRegistro)
                  ";
          }

         
          $records = $this->db->query($rec);

          if ($onlyRecords == false) {
              $recordsFilter = $this->db->query($rec)->num_rows();
              $recordsTotal = $this->db->query($rec)->num_rows();
          }


          if ($records->num_rows() > 0) {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => $records->result(),
                      "recordsFilter" => $recordsFilter,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          } else {
              if ($onlyRecords == false) {
                  $info = array(
                      "records" => NULL,
                      "recordsFilter" => 0,
                      "recordsTotal" => $recordsTotal
                  );
              } else {
                  $info = $records->result();
              }
          }
          return $info;
      }

    
//VENTAS POR CLIENTE
  public function ventas_reporte_rango($filter)
  {

    $acumulado = $filter->acumulado;
    $compania  = $_SESSION['compania'];

    $limit = ( isset($filter->start) && isset($filter->length) ) ? " LIMIT $filter->start, $filter->length " : "";
    $where = "";
    if ($filter->cliente>0){
      $where .= " AND cpc.CLIP_Codigo = ".$filter->cliente;
    }
    if( isset($filter->fecha_inicio) && $filter->fecha_inicio != "" && isset($filter->fecha_fin) && $filter->fecha_fin != "" ){
          $where .= " AND cpc.CPC_Fecha BETWEEN '$filter->fecha_inicio 00:00:00' AND '$filter->fecha_fin 23:59:59' ";
          $where2 .= " AND cpct.CPC_Fecha BETWEEN '$filter->fecha_inicio 00:00:00' AND '$filter->fecha_fin 23:59:59' ";
    }

    $select   = 'SELECT cpc.CLIP_Codigo, cpc.CPC_total as Total, cpc.CPC_FlagEstado as estado, ';
    $concat   = ",CONCAT_WS('-',cpc.CPC_Serie,LPAD(cpc.CPC_Numero, 6, '0')) as Comprobante, cpc.CPC_Fecha as fecha";            
    if ($acumulado > 0){
        $select='SELECT DISTINCT
                 cpc.CLIP_Codigo, "1" as estado,
                 (SELECT SUM(cpct.CPC_total) FROM cji_comprobante cpct WHERE cpct.CLIP_Codigo=cpc.CLIP_Codigo and cpct.CPC_FlagEstado=1 and m.MONED_Codigo=cpct.MONED_Codigo AND cpct.CPP_Codigo_Canje="0" '.$where2.') as Total,';
        $concat="";         
    }

    $sql = $select.
    '
      CASE c.CLIC_TipoPersona
       WHEN 1 THEN e.EMPRC_RazonSocial
       WHEN 0 THEN CONCAT_WS(" ",p.PERSC_Nombre,p.PERSC_ApellidoPaterno)
      END as Nombre,
      CASE c.CLIC_TipoPersona
       WHEN 1 THEN e.EMPRC_Ruc
       WHEN 0 THEN p.PERSC_NumeroDocIdentidad
      END as Documento,
      m.MONED_Simbolo as moneda,
      m.MONED_Codigo as moneda_cod
      '.$concat.'
      FROM cji_comprobante cpc 
      INNER JOIN cji_cliente c ON c.CLIP_Codigo=cpc.CLIP_Codigo
      LEFT JOIN cji_persona p ON p.PERSP_Codigo=c.PERSP_Codigo
      LEFT JOIN cji_empresa e ON e.EMPRP_Codigo=c.EMPRP_Codigo
      LEFT JOIN cji_moneda m ON m.MONED_Codigo=cpc.MONED_Codigo

      WHERE cpc.CPC_TipoOperacion="V" AND cpc.CPC_FlagEstado < 2 AND cpc.CPP_Codigo_Canje="0"
      AND cpc.COMPP_Codigo='.$compania.' 
      '.$where.' ORDER BY cpc.CPP_Codigo DESC
      '.$limit.'
    ';


    $query = $this->db->query($sql);
    $data = array();
    if($query->num_rows > 0)
    {
      foreach($query->result_array() as $result)
      {
        $data[] = $result;
      }
    }
    return $data;


  }

  public function ventas_cliente_producto($filter)
  {
    if ($filter->cliente>0){
      $where .= " AND c.CLIP_Codigo = ".$filter->cliente;
    }

    if ($filter->producto>0){
      $where .= " AND cd.PROD_Codigo = ".$filter->producto;
    }
    $filter->fecha_inicio = ($filter->fecha_inicio == NULL) ? date("Y-m-d 00:00:00") : "$filter->fecha_inicio 00:00:00";
    $filter->fecha_fin    = ($filter->fecha_fin == NULL) ? date("Y-m-d 23:59:59") : "$filter->fecha_fin 23:59:59";
    if( isset($filter->fecha_inicio) && $filter->fecha_inicio != "" && isset($filter->fecha_fin) && $filter->fecha_fin != "" ){
      $where  .= " AND c.CPC_Fecha BETWEEN '$filter->fecha_inicio 00:00:00' AND '$filter->fecha_fin 23:59:59' ";
    }

    $sql = "SELECT c.CPC_Fecha as fecha, c.CPC_FechaRegistro, c.CPC_Serie as serie, c.CPC_Numero as numero, cd.*, pd.PROD_Nombre, m.MARCC_CodigoUsuario, c.CLIP_Codigo, mo.MONED_Simbolo as moneda_simbolo, mo.MONED_Codigo, und.UNDMED_Simbolo as unidad, pd.PROD_CodigoUsuario as prod_cod, 
              CASE cli.CLIC_TipoPersona
               WHEN 1 THEN e.EMPRC_RazonSocial
               WHEN 0 THEN CONCAT_WS(' ',p.PERSC_Nombre,p.PERSC_ApellidoPaterno)
              END as Nombre,
              CASE cli.CLIC_TipoPersona
               WHEN 1 THEN e.EMPRC_Ruc
               WHEN 0 THEN p.PERSC_NumeroDocIdentidad
              END as Documento,

              n.CRED_Serie, n.CRED_Numero, nd.CREDET_Cantidad, nd.CREDET_Pu_ConIgv, nd.CREDET_Total

              FROM cji_comprobantedetalle cd
              INNER JOIN cji_comprobante c ON c.CPP_Codigo = cd.CPP_Codigo
              LEFT JOIN  cji_nota n ON n.CRED_ComproInicio = c.CPP_Codigo AND n.CRED_FlagEstado = 1 AND n.CRED_TipoNota LIKE 'C'
              LEFT JOIN  cji_notadetalle nd ON nd.CRED_Codigo = n.CRED_Codigo AND nd.CREDET_FlagEstado = 1 AND nd.PROD_Codigo = cd.PROD_Codigo
              INNER JOIN cji_cliente cli ON cli.CLIP_Codigo = c.CLIP_Codigo
              LEFT JOIN cji_persona p ON p.PERSP_Codigo = cli.PERSP_Codigo
              LEFT JOIN cji_empresa e ON e.EMPRP_Codigo = cli.EMPRP_Codigo
              INNER JOIN cji_producto pd ON pd.PROD_Codigo = cd.PROD_Codigo
              LEFT JOIN cji_marca m ON m.MARCP_Codigo = pd.MARCP_Codigo
              LEFT JOIN cji_moneda mo ON mo.MONED_Codigo = c.MONED_Codigo
              LEFT JOIN cji_unidadmedida und ON und.UNDMED_Codigo = cd.UNDMED_Codigo

              WHERE c.CPC_TipoOperacion = 'V' AND c.CPC_FlagEstado = 1 AND cd.CPDEC_FlagEstado = 1 $where
              ORDER BY c.CPC_Fecha, c.CPC_Numero ASC

            ";
        $query = $this->db->query($sql);
        if ($query->num_rows > 0) {
            return $query->result();
        }
        return array();
  }
  //FIN REPORTE POR CLIENTE
  
}
?>