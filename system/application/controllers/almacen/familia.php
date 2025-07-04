<?php
//ini_set('error_reporting', 1); 
class Familia extends Controller{
	private $compania;
    private $usuario;
    private $url;
    function __construct(){
		parent::Controller();
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('date');
		$this->load->library('form_validation');
		$this->load->library('pagination');		
		$this->load->library('html');
		$this->load->library('table');
		$this->load->model('almacen/familia_model');		
		$this->load->model('compras/proveedor_model');		
		$this->load->model('maestros/empresa_model');	
		$this->load->model('maestros/persona_model');	
		$this->load->library('layout','layout_main'); 
		$this->compania = $this->session->userdata("compania");
        $this->usuario = $this->session->userdata("user");
        $this->url = base_url(); 
	}

	function index(){
		$this->layout->view('seguridad/inicio');
	}

	public function familias( $flagBS='B', $j='0' ){
        $conf['base_url']   = $this->url;
        $data['flagBS']     = $flagBS;	
        if($flagBS=="B"){
        	$data['titulo']    	= "LISTA DE FAMILIAS DE ARTICULOS";
        }else{

        	$data['titulo']    	= "LISTA DE FAMILIAS DE SERVICIOS";
        }
        $data['titulo_busqueda'] = "BUSCAR FAMILIA";
        $this->layout->view('almacen/familia_index',$data);
    }

	public function datatable_familia(){

        $columnas = array(
                            0 => "",
                            1 => "FAMI_Descripcion",
                            2 => "",
                            3 => ""
                        );
        
        $filter = new stdClass();
        $filter->start = $this->input->post("start");
        $filter->length = $this->input->post("length");
        $filter->search = $this->input->post("search")["value"];

        $ordenar = $this->input->post("order")[0]["column"];
        if ($ordenar != ""){
            $filter->order = $columnas[$ordenar];
            $filter->dir = $this->input->post("order")[0]["dir"];
        }

        $item = ($this->input->post("start") != "") ? $this->input->post("start") : 0;

        $filter->nombre = $this->input->post('nombre');
        $filter->flagBS = $this->input->post('flagBS');

        $famiInfo = $this->familia_model->getFamilias($filter);
        $lista = array();
        
        if (count($famiInfo) > 0) {
            foreach ($famiInfo as $indice => $valor) {
                $btn_modal = "<button type='button' onclick='editar($valor->FAMI_Codigo)' class='btn btn-default'><img src='".$this->url."/images/modificar.png' class='image-size-1b'></button>";
                $btn_borrar = "<button type='button' onclick='deshabilitar($valor->FAMI_Codigo)' class='btn btn-default'><img src='".$this->url."/images/documento-delete.png' class='image-size-1b'></button>";

                $lista[] = array(
                                    0 => $indice + 1,
                                    1 => $valor->FAMI_CodigoUsuario,
                                    2 => $valor->FAMI_Descripcion,
                                    3 => $btn_modal,
                                    4 => $btn_borrar
                                );
            }
        }

        unset($filter->start);
        unset($filter->length);

        $json = array(
                            "draw"            => intval( $this->input->post('draw') ),
                            "recordsTotal"    => count($this->familia_model->getFamilias()),
                            "recordsFiltered" => intval( count($this->familia_model->getFamilias($filter)) ),
                            "data"            => $lista
                    );

        echo json_encode($json);
    }

    public function guardar_registro(){

        $familia = $this->input->post("familia");
        $nombre = strtoupper( $this->input->post("familia_nombre") );
        $descripcion = strtoupper( $this->input->post("familia_descripcion") );
        $flagBS = $this->input->post("flagBS");

        $filter = new stdClass();
        $filter->FAMI_Descripcion 		= strtoupper($nombre);
        $filter->FAMI_CodigoUsuario 	= strtoupper($descripcion);
        $filter->FAMI_FlagBienServicio 	= $flagBS;
        $filter->FAMI_FlagEstado    	= "1";

        if ($familia != ""){
            $filter->FAMI_Codigo = $familia;
            $result = $this->familia_model->actualizar($familia, $filter);
        }
        else
            $result = $this->familia_model->insertar($filter);

        if ($result)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);
    }

    public function deshabilitar_familia(){

        $familia = $this->input->post("familia");

        $filter = new stdClass();
        $filter->FAMI_FlagEstado  = "0";

        if ($familia != "")
            $result = $this->familia_model->actualizar($familia, $filter);

        if ($result)
            $json = array("result" => "success");
        else
            $json = array("result" => "error");
        
        echo json_encode($json);
    }

    public function getFamilia(){

        $codigo = $this->input->post("familia");

        $familiaInfo = $this->familia_model->getfamilia($codigo);
        $lista = array();
        
        if ( $familiaInfo != NULL ){
            foreach ($familiaInfo as $indice => $val) {
                $lista = array(
                                    "familia" => $val->FAMI_Codigo,
                                    "nombre" => $val->FAMI_Descripcion,
                                    "descripcion" => $val->FAMI_CodigoUsuario
                                );
            }

            $json = array("match" => true, "info" => $lista);
        }
        else
            $json = array("match" => false, "info" => "");

        echo json_encode($json);
    }

/*****************************************************************************/	
	function familias_old($flagBS='B', $j='0'){
		$data['codigo']    = "";
        $data['nombre']    = "";
        $data['codigohf']=$j;     
                $listar_familias    = $this->familia_model->listar_familias($flagBS,$j);		
		$data['titulo_busqueda'] = "BUSCAR FAMILIAS DE ".($flagBS=='B' ? 'ARTICULOS' : 'SERVICIOS');
                $data['action']          = base_url()."index.php/almacen/familia/buscar_familias";
		$url_familia             = "<a href='#' onclick='abrir_familia(0);'>FAMILIAS DE ".($flagBS=='B' ? 'ARTICULOS' : 'SERVICIOS')."</a>";
		$data['titulo_tabla']= $j=='0'?"FAMILIAS DE ".($flagBS=='B' ? 'ARTICULOS' : 'SERVICIOS'):$url_familia." :::: ".$this->nombre_familia($j);
		$data['registros']   = count($this->familia_model->listar_familias($flagBS, $j));
		$data['subtitulo']   = "CATALOGO";
		$item 			     = 1;
		$lista               = array();
		$codanterior         = $j;
		if(count($listar_familias)>0){
			foreach($listar_familias as $indice=>$valor){
				$codigo          = $valor->FAMI_Codigo;
				$codanterior     = $valor->FAMI_Codigo2;
				$codigo_interno  = $valor->FAMI_CodigoInterno;
                                $codigo_usuario  = $valor->FAMI_CodigoUsuario;
				$lista_familias2 = $this->familia_model->listar_familias($flagBS, $codigo);
				$cantidad        = count($lista_familias2);
				$nombre          = $valor->FAMI_Descripcion."(".$cantidad.")";
				$cajaCodigo      = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";
				$descripcion     = "<a href='#' onclick='abrir_familia(".$codigo.")'>".$nombre."</a>";
				$ingresar        = "";#"<a href='#' onclick='abrir_familia(".$codigo.")'><img src='".base_url()."images/ingresar.png' width='16' height='16' border='0' title='Abrir'></a>";
				$imprimir        = "";#"<a href='#' onclick='imprimir_familia(".$codigo.")'><img src='".base_url()."images/icono_imprimir.png' width='16' height='16' border='0' title='Abrir'></a>";
				$editar          = "<a href='#' onclick='editar_familia(".$item.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar        = "<a href='#' onclick='eliminar_familia(".$item.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Eliminar'></a>";
				$lista[]         = array($item++,$codigo_interno,$codigo_usuario,$cajaCodigo.$descripcion,$ingresar,$editar,$eliminar,$imprimir);
			}
		}
		if($j=='0' || $j==''){
			$ver_regresar = "style='display:none;'";
		}
		else{
			$ver_regresar = "";
		}
                $data['flagBS']          = $flagBS;
		$data['ver_regresar']    = $ver_regresar;
		$data['lista']           = $lista;		
		$data['paginacion']      = "";
		$data['codanterior']     = $codanterior;
		$datos_familia           = $this->familia_model->obtener_familia($codanterior);
		$data['codanterior2']    = count($datos_familia)!='0'?$datos_familia[0]->FAMI_Codigo2:'';       
		$this->layout->view('almacen/familia_index',$data);
	}

	function nueva_familia($flagBS='B'){
		$fila="";
		$cbo= array();
		$data['onload']     = "";
		$data['titulo']     = "SELECCIONAR FAMILIA";
		$data['formulario'] = "frmFamilia";
		$cbo1               = $this->seleccionar_familia($flagBS, '0','');
		$nivel              = $this->input->post('nivel');
		$cantidad           = count($nivel);
		$codproducto        = "";		
		if($cantidad==1 && !isset($nivel[0])){
			$cbo[0]        = $this->seleccionar_familia($flagBS, '0','');
			$codinterno[0] = "";
		}
 		else{
			$anterior = "";
			$visible  = 1;
			 $codanterior="";
			 $codigointerno="";
			foreach($nivel as $indice=>$valor){
				$codigo         = $valor;
				$datos_familia  = $this->familia_model->obtener_familia($valor);
				if(count($datos_familia)>0){ 
				$codanterior  = $datos_familia[0]->FAMI_Codigo2; 
				$codigointerno= $datos_familia[0]->FAMI_CodigoInterno; 
				}
				if($codigo==''){
					$visible         = 0;				
					break;
				}
				elseif($codanterior!=$anterior && $indice>0){
					$codanterior     = $anterior;
					$codigo          = '';
					$visible         = 0;
					break;
				}		
				$cbo[$indice]        = $this->seleccionar_familia($flagBS, $codanterior,$codigo);
				$codinterno[$indice] = $codigointerno;
				$indice2             = $indice+1;
				$listar_familias     = $this->familia_model->listar_familias($flagBS, $codigo);
				if(count($listar_familias)>0){
					$cbo[$indice2]        = $this->seleccionar_familia($flagBS, $codigo,'');	
					$codinterno[$indice2] = "";
				}
				$anterior            = $codigo;
				$codproducto   		 = $codproducto.".".$codigointerno;
			}		
		}
		
		$fila               = "<table id='tablaFamilia2' class='fuente8' border='0' width='70%' cellpadding='3' cellspacing='2'>";
		for($i=0;$i<count($cbo);$i++){
			$j               = $i+1;
			$fila           .= "<tr>";
			$fila           .= "<td align='left'>Nivel  ".$j."</td>";
			$fila           .= "<td align='left'>";
			$fila           .= "<select name='nivel[".$i."]' id='nivel[".$i."]' class='comboMedio' onchange='submit();'>".$cbo[$i]."</select>";
			$fila           .= "&nbsp;".$codinterno[$i];
			$fila           .= "</td>";
			$fila           .= "</tr>";
		}
		$fila               .= "</table>";
		$data['fila']        = $fila;
        $data['flagBS']        = $flagBS;
		$data['codproducto'] = substr($codproducto,1);
		$this->load->view("almacen/familia_nueva",$data);
	}

	function insertar_familia(){
		$flagBS   = $this->input->post('flagBS');
        $codanterior   = $this->input->post('codanterior');
		$descripcion   = $this->input->post('descripcion');
		$codigointerno = $this->input->post('codigointerno');
        $codigousuario = $this->input->post('codigousuario');

    	$this->familia_model->insertar_familia($flagBS,$descripcion,$codanterior,$codigointerno,$codigousuario);
    }

	function editar_familia(){
		$flagBS         = $this->input->post('flagBS');
                $codanterior    = $this->input->post('codanterior');
		$familia        = $this->input->post('familia');
		$lista_familias = $this->familia_model->listar_familias($flagBS,$codanterior);
		$resultado      = $this->tabla_familia($lista_familias,$familia);
		echo $resultado;
	}
	
	function modificar_familia(){
		$familia       = $this->input->post('codigo');
		$descripcion   = $this->input->post('descripcion');
                $codigousuario = $this->input->post('codigousuario');
		$this->familia_model->modificar_familia($familia,$descripcion, $codigousuario);
		$this->index();
	}

	function buscar_familias($j='0'){
		$codigo         = $this->input->post('txtCodigo');
                $nombre         = $this->input->post('txtNombre');
                $flagBS         = $this->input->post('flagBS');
                  $data['codigohf']='';
                $filter = new stdClass();
                $filter->codigo   = $codigo;
                $filter->nombre   = $nombre;
                $filter->flagBS   = $flagBS;
                
                $data['codigo']    = $codigo;
                $data['nombre']    = $nombre;
                $data['flagBS']    = $flagBS;
                $listar_familias    = $this->familia_model->buscar_familias($j, $filter);		
		$data['titulo_busqueda'] = "BUSCAR FAMILIAS";
                $data['action']          = base_url()."index.php/almacen/familia/buscar_familias";
		$url_familia             = "<a href='#' onclick='abrir_familia(0);'>FAMILIAS</a>";
		$data['titulo_tabla']= $j=='0'?"FAMILIAS":$url_familia." :::: ".$this->nombre_familia($j);
		$data['registros']   = count($this->familia_model->buscar_familias($j, $filter));
		$data['subtitulo']   = "CATALOGO";
		$item 			     = 1;
		$lista               = array();
		$codanterior         = $j;
		if(count($listar_familias)>0){
			foreach($listar_familias as $indice=>$valor){
				$codigo          = $valor->FAMI_Codigo;
				$codanterior     = $valor->FAMI_Codigo2;
				$codigo_interno  = $valor->FAMI_CodigoInterno;
                                $codigo_usuario  = $valor->FAMI_CodigoUsuario;
				$lista_familias2 = $this->familia_model->listar_familias($codigo);
				$cantidad        = count($lista_familias2);
				$nombre          = $valor->FAMI_Descripcion."(".$cantidad.")";
				$cajaCodigo      = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";
				$descripcion     = "<a href='#' onclick='abrir_familia(".$codigo.")'>".$nombre."</a>";
				$ingresar        = "<a href='#' onclick='abrir_familia(".$codigo.")'><img src='".base_url()."images/ingresar.png' width='16' height='16' border='0' title='Abrir'></a>";
				$imprimir        = "<a href='#' onclick='imprimir_familia(".$codigo.")' target='blank'><img src='".base_url()."images/icono_imprimir.png' width='16' height='16' border='0' title='Abrir'></a>";
				$editar          = "<a href='#' onclick='editar_familia(".$item.")'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$eliminar        = "<a href='#' onclick='eliminar_familia(".$item.")'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				$lista[]         = array($item++,$codigo_interno,$codigo_usuario,$cajaCodigo.$descripcion,$ingresar,$editar,$eliminar,$imprimir);
			}
		}
		if($j=='0' || $j==''){
			$ver_regresar = "style='display:none;'";
		}
		else{
			$ver_regresar = "";
		}
		$data['ver_regresar']    = $ver_regresar;
		$data['lista']           = $lista;		
		$data['paginacion']      = "";
		$data['codanterior']     = $codanterior;
		$datos_familia           = $this->familia_model->obtener_familia($codanterior);
		$data['codanterior2']    = count($datos_familia)!='0'?$datos_familia[0]->FAMI_Codigo2:'';       
		$this->layout->view('almacen/familia_index',$data);
	}
    
    function eliminar_familia(){
		$flagBS       = $this->input->post('flagBS');
                $familia       = $this->input->post('codigo');
		$lista_familia = $this->familia_model->listar_familias($flagBS, $familia);
		$resultado     = '0';
		if(count($lista_familia)==0){
			$this->familia_model->eliminar_familia($familia);
			$resultado = '1';
		}
                    
		echo json_encode(array('resultado'=>$resultado));
	}
	
	function correlativo_familia($flagBS='B'){
		$codanterior       = $this->input->post('codanterior');
		$data_correlativo  = $this->familia_model->obtener_familia_max($flagBS, $codanterior);
		$numero            = $data_correlativo[0]->FAMI_CodigoInterno + 1;
		echo str_pad($numero,3,'0',STR_PAD_LEFT);
	}	
	
	function seleccionar_familia($flagBS, $codanterior,$indDefault=''){
		$array_familia = $this->familia_model->listar_familias($flagBS, $codanterior);
		$arreglo       = array();

		if(count($array_familia)>0){
			foreach($array_familia as $indice=>$valor){
				$indice1   = $valor->FAMI_Codigo;
				$valor1    = $valor->FAMI_Descripcion;
				$arreglo[$indice1] = $valor1;
			}
		}
		$resultado = $this->html->optionHTML($arreglo,$indDefault,array('00','::Seleccione::'));
		return $resultado;
	}	
	
	/*Complementarios*/
	function tabla_familia($datos,$familia=''){
		$data[0] = array('ITEM','COD. INTERNO','COD. USUARIO','DESCRIPCION','&nbsp;','&nbsp;','&nbsp;');		
		$item   = 1;
		if(count($datos)>0){
			foreach($datos as $valor){
				$codigo            = $valor->FAMI_Codigo;
				$codanterior       = $valor->FAMI_Codigo2;
				$datos_familia     = $this->familia_model->listar_familias($codigo);
				$cantidad          = count($datos_familia);
				$valor2            = $valor->FAMI_Descripcion."(".$cantidad.")";	
				$codigointerno     = "<input type='text' style='background-color: #E6E6E6' readonly='readonly' class='cajaMinima' name='codigointerno[".$item."]' id='codigointerno[".$item."]' value='".$valor->FAMI_CodigoInterno."' maxlength='3'>";	
                                
				if($codigo==$familia && $familia!=''){					
					$codigointerno     = "<input type='text' style='background-color: #E6E6E6' readonly='readonly' class='cajaMinima' name='codigointerno[".$item."]' id='codigointerno[".$item."]' value='".$valor->FAMI_CodigoInterno."' maxlength='3'>";	
                                        $codigousuario = "<input type='text' class='cajaPequena' name='codigousuario[".$item."]' id='codigousuario[".$item."]' value='".$valor->FAMI_CodigoUsuario."' maxlength='20'>";
                                        $concepto      = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";
					$concepto     .= "<input type='text' class='cajaGrande' name='descripcion[".$item."]' id='descripcion[".$item."]' value='".$valor->FAMI_Descripcion."'>";
				}
				else{
					$codigointerno =$valor->FAMI_CodigoInterno;
                                        $codigousuario = $valor->FAMI_CodigoUsuario;
                                        $concepto  = "<input type='hidden' name='familia[".$item."]' id='familia[".$item."]' value='".$codigo."'>";				
					$concepto .= $valor2;	
				}
				if($codigo==$familia && $familia!=''){
					$ingresar    = "";
					$editar      = "<a href='#' onclick='modificar_familia(".$item.")' target='_parent'><img src='".base_url()."images/save.gif' width='16' height='16' border='0' title='Modificar'></a>";
					$eliminar    = "";
				}
				else{
					$ingresar    = "<a href='#' onclick='abrir_familia(".$item.")' target='_parent'><img src='".base_url()."images/ingresar.png' width='16' height='16' border='0' title='Abrir'></a>";
					$editar      = "<a href='#' onclick='editar_familia(".$item.")' target='_parent'><img src='".base_url()."images/modificar.png' width='16' height='16' border='0' title='Modificar'></a>";
					$eliminar    = "<a href='#' onclick='eliminar_familia(".$item.")' target='_parent'><img src='".base_url()."images/eliminar.png' width='16' height='16' border='0' title='Modificar'></a>";
				}
				$data[$item] = array(
								$item,
								$codigointerno,
                                                                $codigousuario,
								$concepto,
								$ingresar,
								$editar,
								$eliminar
								);
				$item++;
			}	
		}	
		$tmpl   = array (
						'table_open'          => '<table class="fuente8" width="100%" cellspacing="0" cellpadding="3" border="0" id="tablaFamilia">',
						
						'heading_row_start'   => '<tr class="cabeceraTabla">',
						'heading_row_end'     => '</tr>',
						'heading_cell_start'  => '<th width="5%">',
						'heading_cell_end'    => '</th>',

						'row_start'           => '<tr class="itemParTabla">',
						'row_end'             => '</tr>',
						'cell_start'          => '<td class="aCentro" width="8%">',
						'cell_end'            => '</td>',

						'row_alt_start'       => '<tr class="itemImparTabla">',
						'row_alt_end'         => '</tr>',
						'cell_alt_start'      => '<td class="aCentro" width="8%">',
						'cell_alt_end'        => '</td>',
												
						'table_close'         => '</table>'
						);
		$this->table->set_template($tmpl);		
		$resultado = $this->table->generate($data);
		$this->table->clear();
		return $resultado;	
	}	

	function nombre_familia($codigo){
		$datos_familia = $this->familia_model->obtener_familia($codigo);
		$codigo        = $datos_familia[0]->FAMI_Codigo;
		$nombre        = $datos_familia[0]->FAMI_Descripcion;
		$codanterior   = $datos_familia[0]->FAMI_Codigo2;
		$cadena        = anchor('almacen/familia/familias/'.$codigo,$nombre);
		while($codanterior!='0'){
			$datos_familia = $this->familia_model->obtener_familia($codanterior);
			$codigo        = $datos_familia[0]->FAMI_Codigo;
			$nombre        = $datos_familia[0]->FAMI_Descripcion;
			$codanterior   = $datos_familia[0]->FAMI_Codigo2;	
			$cadena        = anchor('almacen/familia/familias/'.$codigo,$nombre)."&nbsp;/&nbsp;".$cadena;
		}
		return $cadena;
	}

	function numero_de_familias($codigo){
		$datos_familia = $this->familia_model->obtener_familia($codigo);
		$codanterior   = $datos_familia[0]->FAMI_Codigo2;
		$item          = 1;
		while($codanterior!='0'){
			$datos_familia = $this->familia_model->obtener_familia($codanterior);
			$codanterior   = $datos_familia[0]->FAMI_Codigo2;	
			$item++;
		}
		return $item;
	}

    function ventana_busqueda_familia($flagBS='B'){
        $data['onload']     = "";
        $data['titulo']     = "SELECCIONAR FAMILIA";
        $data['formulario'] = "frmFamilia";
        $idfamilia="";
        $cbo1               = $this->seleccionar_familia($flagBS, '0','');
        $nivel              = $this->input->post('nivel');
        $cantidad           = count($nivel);
        $codproducto        = "";		
        if($cantidad==1 && !isset($nivel[0])){
                $cbo[0]        = $this->seleccionar_familia($flagBS, '0','');
                $codinterno[0] = "";
        }
        else{
                $anterior = "";
                $visible  = 1;
                $i=0;
                foreach($nivel as $indice=>$valor){
                    
                        $codigo         = $valor;
                        $datos_familia  = $this->familia_model->obtener_familia($codigo);
                        $codanterior    = $datos_familia[0]->FAMI_Codigo2; 
                        $codigointerno  = $datos_familia[0]->FAMI_CodigoInterno; 
                        if($codigo==''){
                                $visible         = 0;				
                                break;
                        }
                        elseif($codanterior!=$anterior && $indice>0){
                                $codanterior     = $anterior;
                                $codigo          = '';
                                $visible         = 0;
                                break;
                        }		
                        $cbo[$indice]        = $this->seleccionar_familia($flagBS, $codanterior,$codigo);
                        $codinterno[$indice] = $codigointerno;
                        $indice2             = $indice+1;
                        $listar_familias     = $this->familia_model->listar_familias($flagBS, $codigo);
                        if(count($listar_familias)>0){
                                $cbo[$indice2]        = $this->seleccionar_familia($flagBS, $codigo,'');	
                                $codinterno[$indice2] = "";
                        }
                        $anterior            = $codigo;
                        if($i>0){
                            $idfamilia.='-';
                        }
                        $idfamilia.=$codigo;
                        $codproducto   		 = $codproducto.".".$codigointerno;
                        $i++;
                }		
        }
        $fila               = "<table id='tablaFamilia2' class='fuente8' border='0' width='70%' cellpadding='3' cellspacing='2'>";
        for($i=0;$i<count($cbo);$i++){
                $j               = $i+1;
                $fila           .= "<tr>";
                $fila           .= "<td align='left'>Nivel ".$j."</td>";
                $fila           .= "<td align='left'>";
                $fila           .= "<select name='nivel[".$i."]' id='nivel[".$i."]' class='comboMedio' onchange='submit();'>".$cbo[$i]."</select>";
                $fila           .= "&nbsp;".$codinterno[$i];
                //$fila           .= "<img src='".base_url()."images/add.png'>";
                $fila           .= "</td>";
                $fila           .= "</tr>";
        }
        $fila               .= "</table>";
        $data['fila']        = $fila;
        $data['flagBS']        = $flagBS;
        $data['codproducto'] = substr($codproducto,1);
        $data['idfamilia']=$idfamilia;
        $this->load->view("almacen/ventana_familia_busqueda",$data);
    }
}
?>