<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Alumno extends controller{
    
    private $empresa;
    private $compania;
    private $url;

    public function __construct(){
        parent::__construct();
        $this->load->helper('url');

        $this->load->library('tcpdf');
        $this->load->library('Excel');
        

        $this->load->model('alumno_model');
        
        $this->empresa = $this->session->userdata('empresa');
        $this->compania = $this->session->userdata('compania');
        $this->url = base_url();
    }


    #########################
    ###### FUNCTIONS NEWS
    #########################

        public function listar(){
            $data['base_url'] = $this->url;
            $data['titulo_busqueda'] = "BUSCAR ALUMNOS";
            $data['titulo'] = "RELACIÓN DE ALUMNOS";
            $this->layout->view('alumno_index', $data);
        }

        public function datatable_alumno(){

            $columnas = array(
                                0 => "apellidos",
                                1 => "nombres",
                                2 => "correo",
                                3 => "grupo",
                                4 => "grupo"
                            );

            # NOMBRES
            # APELLIDOS
            # CORREO
            # GRUPO
            # AÑO
            # NIVEL
            # SECCIÓN
            
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

            $filter->descripcion = $this->input->post('descripcion');
            $filter->nivel = $this->input->post('nivel');
            $filter->curso = $this->input->post('curso');
            $filter->seccion = $this->input->post('seccion');

            $alumnoInfo = $this->alumno_model->getAlumnos($filter);
            $lista = array();
            
            if (count($alumnoInfo) > 0) {
                foreach ($alumnoInfo as $indice => $valor) {
                    $btn_modal = "<button type='button' onclick='editar($valor->alumno)' class='btn btn-default'>
                                    <img src='".$this->url."/images/modificar.png' class='image-size-1b'>
                                </button>";

                    $btn_eliminar = "<button type='button' onclick='deshabilitar($valor->alumno)' class='btn btn-default'>
                                    <img src='".$this->url."/images/documento-delete.png' class='image-size-1b'>
                                </button>";

                    if ($valor->grupo != "" ){
                        $x = explode("@",$valor->grupo);
                        $xx = explode("2020",$x[0]);
                        $info = $xx[0];

                        $ano = substr($info,0,1);
                        $seccion = strtoupper( substr($info,-1,1) );

                        $lvl = strtoupper( substr($info,1,-1) );

                        switch ( substr($lvl, 0, 2) ) {
                            case 'RO':
                                $nivel = substr($lvl, 2);
                                break;
                            case 'DO':
                                $nivel = substr($lvl, 2);
                                break;
                            case 'TO':
                                $nivel = substr($lvl, 2);
                                break;
                            case 'GR':
                                $nivel = "PRIMARIA";
                                break;
                            case 'AN':
                                $nivel = "SECUNDARIA";
                                break;
                            case 'IN':
                                $nivel = $lvl;
                                break;
                            
                            default:
                                $nivel = "";
                                break;
                        }
                    }
                    else
                        $nivel = "";

                    $correo = ( strlen($valor->correo) > 40 ) ? substr($valor->correo, 0, 37) . "..." : $valor->correo;
                    $grupo = ( strlen($valor->grupo) > 40 ) ? substr($valor->grupo, 0, 37) . "..." : $valor->grupo;

                    $lista[] = array(
                                        0 => $valor->apellidos,
                                        1 => $valor->nombres,
                                        2 => $correo,
                                        3 => $grupo,
                                        4 => $ano,
                                        5 => $nivel,
                                        6 => $seccion,
                                        7 => $btn_modal,
                                        8 => $btn_eliminar
                                    );
                }
            }

            unset($filter->start);
            unset($filter->length);

            $json = array(
                                "draw"            => intval( $this->input->post('draw') ),
                                "recordsTotal"    => count($this->alumno_model->getAlumnos()),
                                "recordsFiltered" => intval( count($this->alumno_model->getAlumnos($filter)) ),
                                "data"            => $lista
                        );

            echo json_encode($json);
        }

        public function getAlumno(){

            $alumno = $this->input->post("alumno");

            $alumnoInfo = $this->alumno_model->getAlumno($alumno);
            $lista = array();
            
            if ( $alumnoInfo != NULL ){
                foreach ($alumnoInfo as $indice => $val) {
                    $lista = array(
                                        "alumno" => $val->alumno,
                                        "nombres" => $val->nombres,
                                        "apellidos" => $val->apellidos,
                                        "grupo" => $val->grupo,
                                        "correo" => $val->correo
                                    );
                }

                $json = array("match" => true, "info" => $lista);
            }
            else
                $json = array("match" => false, "info" => "");

            echo json_encode($json);
        }

        public function getGrupo(){

            $grupo = $this->input->post("grupo");

            $gruposInfo = $this->alumno_model->getGruposA($grupo);
            $lista = array();
            
            if ( $gruposInfo != NULL ){
                foreach ($gruposInfo as $indice => $val) {
                    $info = $this->formatNivel($val->grupo);
                    $ano = $info->anoLT;
                    $nivel = $info->nivel;
                    $seccion = $info->seccion;

                    $lista[] = array(
                                        "value" => $val->grupo,
                                        "label" => "$ano $nivel $seccion -> $val->grupo"
                                    );
                }

                $json = $lista;
            }
            else
                $json = NULL;

            echo json_encode($json);
        }

        public function guardar_registro(){

            $alumno = $this->input->post("alumno");
            $nombres = $this->input->post("nombres_alumno");
            $apellidos = $this->input->post("apellidos_alumno");
            $grupo = $this->input->post("grupo_alumno");
            $correo = $this->input->post("correo_alumno");
            
            $filter = new stdClass();
            $filter->nombres = strtoupper($nombres);
            $filter->apellidos = strtoupper($apellidos);
            $filter->grupo = $grupo;
            $filter->correo = $correo;

            if ($alumno != ""){
                $filter->alumno = $alumno;
                $result = $this->alumno_model->actualizar_alumno($alumno, $filter);
            }
            else{
                $result = $this->alumno_model->insertar_alumno($filter);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function deshabilitar_alumno(){

            $alumno = $this->input->post("alumno");

            if ($alumno != ""){
                $result = $this->alumno_model->deshabilitar_alumno($alumno);
            }

            if ($result)
                $json = array("result" => "success");
            else
                $json = array("result" => "error");
            
            echo json_encode($json);
        }

        public function pdf(){
            
            $medidas = "a4"; // a4 - carta
            $this->pdf = new pdf('P', 'mm', $medidas, true, 'UTF-8', false);
            $this->pdf->SetMargins(10, 20, 10); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
            $this->pdf->SetTitle("ALUMNOS");
            $this->pdf->SetFont('freesans', '', 9);

            $this->pdf->setPrintHeader(true);

            $style = new stdClass();
            $style->border_top = "border-top:#cccccc 1mm solid;";
            $style->border_bottom = "border-bottom:#cccccc 1mm solid;";
            $style->border_tb = "border-top:#cccccc 1mm solid; border-bottom:#cccccc 1mm solid;";

            $gruposInfo = $this->alumno_model->getGrupos();
                
            foreach ($gruposInfo as $key => $value) {
                $this->pdf->AddPage();
                $this->pdf->SetAutoPageBreak(true, 1);

                $titleHoja = $this->formatNivel($value->grupo);
                $cursoHTML = '<table border="0">
                                <tr>
                                    <td rowspan="4" style="width:4.5cm;">
                                    </td>

                                    <td style="width:15.0cm; font-weight:bold; font-size: 12pt;">ALUMNOS POR AULA<br></td>
                                </tr>
                                <tr>
                                    <td style="width:1.5cm; font-weight:bold;">AÑO:</td>
                                    <td style="width:5.0cm;">'.$titleHoja->anoLarge.'</td>
                                </tr>
                                <tr>
                                    <td style="width:1.5cm; font-weight:bold;">NIVEL:</td>
                                    <td style="width:5.0cm;">'.$titleHoja->nivel.'</td>
                                </tr>
                                <tr>
                                    <td style="width:2.0cm; font-weight:bold;">SECCIÓN:</td>
                                    <td style="width:3.0cm;">'.$titleHoja->seccion.'</td>
                                </tr>
                            </table>';
                $this->pdf->writeHTML($cursoHTML,true,false,true,'');
                $this->pdf->Ln(5);

                $filter = new stdClass();
                $filter->grupo = $value->grupo;
                
                $alumnoInfo = $this->alumno_model->getAlumnos($filter);
                $lista = array();
                
                if (count($alumnoInfo) > 0) {
                    $alumnosDetaHTML = "";
                    
                    foreach ($alumnoInfo as $indice => $valor) {

                        if ($valor->grupo != "" ){
                            $data = $this->formatNivel($valor->grupo);
                            $ano = $data->ano;
                            $nivel = $data->nivel;
                            $seccion = $data->seccion;
                        }
                        else{
                            $ano = "";
                            $nivel = "";
                            $seccion = "";
                        }

                        $correo = $valor->correo;
                        $grupo = $valor->grupo;

                        $numero = $indice + 1;

                        $bgcolor = ($indice % 2 == 0) ? "#FFFFFF" : "#F1F1F1";

                        $alumnosDetaHTML .= '<tr bgcolor="'.$bgcolor.'">
                                    <td style="'.$style->border_tb.' text-align:center; width:1.0cm;">'.$numero.'</td>
                                    <td style="'.$style->border_tb.' text-align:left; width:4.0cm;">'.$valor->apellidos.'</td>
                                    <td style="'.$style->border_tb.' text-align:left; width:4.0cm;">'.$valor->nombres.'</td>
                                    <td style="'.$style->border_tb.' text-align:left; width:10.0cm;">'.$correo.'</td>
                                </tr>';
                    }

                    $alumnosHTML = '<table border="0" style="font-size: 8pt; line-height:5mm;">
                        <thead>
                            <tr style="font-size: 8pt" bgcolor="#F1F1F1">
                                <th style="'.$style->border_tb.' font-weight:bold; text-align:center; width:1.0cm;">N</th>
                                <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:4.0cm;">APELLIDOS</th>
                                <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:4.0cm;">NOMBRES</th>
                                <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:10.0cm;">USUARIO</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$alumnosDetaHTML.'
                        </tbody>
                    </table>';
                    $this->pdf->writeHTML($alumnosHTML,true,false,true,"");
                }
            }

            $this->pdf->Output("alumnos.pdf", 'I');
        }

        public function zip(){
            
            $gruposInfo = $this->alumno_model->getGrupos();

            $folder = './downloads/alumnos/';
            if ( !file_exists($folder) ){
                if(!mkdir($folder, 0777, true))
                    die('Fallo al crear las carpetas...');
            }

            unlink('alumnos.zip');
            $zip = new ZipArchive();
            $zip->open("alumnos.zip",ZipArchive::CREATE);

            $style = new stdClass();
            $style->border_top = "border-top:#cccccc 1mm solid;";
            $style->border_bottom = "border-bottom:#cccccc 1mm solid;";
            $style->border_tb = "border-top:#cccccc 1mm solid; border-bottom:#cccccc 1mm solid;";
            $medidas = "a4"; // a4 - carta
            
            ################
            #### PDF
            ################
                foreach ($gruposInfo as $key => $value) {
                    $this->pdf = new pdf('P', 'mm', $medidas, true, 'UTF-8', false);
                    $this->pdf->SetMargins(10, 20, 10); // Cada 10 es 1cm - Como es hoja estoy tratando las medidad en cm -> Rawil
                    $this->pdf->SetTitle("ALUMNOS");
                    $this->pdf->SetFont('freesans', '', 9);

                    $this->pdf->setPrintHeader(true);
                    $this->pdf->AddPage();
                    $this->pdf->SetAutoPageBreak(true, 1);

                    $titleHoja = $this->formatNivel($value->grupo);
                    $cursoHTML = '<table border="0">
                                    <tr>
                                        <td rowspan="4" style="width:4.5cm;">
                                        </td>

                                        <td style="width:15.0cm; font-weight:bold; font-size: 12pt;">ALUMNOS POR AULA<br></td>
                                    </tr>
                                    <tr>
                                        <td style="width:1.5cm; font-weight:bold;">AÑO:</td>
                                        <td style="width:5.0cm;">'.$titleHoja->anoLarge.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:1.5cm; font-weight:bold;">NIVEL:</td>
                                        <td style="width:5.0cm;">'.$titleHoja->nivel.'</td>
                                    </tr>
                                    <tr>
                                        <td style="width:2.0cm; font-weight:bold;">SECCIÓN:</td>
                                        <td style="width:3.0cm;">'.$titleHoja->seccion.'</td>
                                    </tr>
                                </table>';
                    $this->pdf->writeHTML($cursoHTML,true,false,true,'');
                    $this->pdf->Ln(5);

                    $filter = new stdClass();
                    $filter->grupo = $value->grupo;
                    
                    $alumnoInfo = $this->alumno_model->getAlumnos($filter);
                    $lista = array();
                    
                    if (count($alumnoInfo) > 0) {
                        $alumnosDetaHTML = "";
                        
                        foreach ($alumnoInfo as $indice => $valor) {

                            if ($valor->grupo != "" ){
                                $data = $this->formatNivel($valor->grupo);
                                $ano = $data->ano;
                                $nivel = $data->nivel;
                                $seccion = $data->seccion;
                            }
                            else{
                                $ano = "";
                                $nivel = "";
                                $seccion = "";
                            }

                            $correo = $valor->correo;
                            $grupo = $valor->grupo;

                            $numero = $indice + 1;

                            $bgcolor = ($indice % 2 == 0) ? "#FFFFFF" : "#F1F1F1";

                            $alumnosDetaHTML .= '<tr bgcolor="'.$bgcolor.'">
                                        <td style="'.$style->border_tb.' text-align:center; width:1.0cm;">'.$numero.'</td>
                                        <td style="'.$style->border_tb.' text-align:left; width:4.0cm;">'.$valor->apellidos.'</td>
                                        <td style="'.$style->border_tb.' text-align:left; width:4.0cm;">'.$valor->nombres.'</td>
                                        <td style="'.$style->border_tb.' text-align:left; width:10.0cm;">'.$correo.'</td>
                                    </tr>';
                        }

                        $alumnosHTML = '<table border="0" style="font-size: 8pt; line-height:5mm;">
                            <thead>
                                <tr style="font-size: 8pt" bgcolor="#F1F1F1">
                                    <th style="'.$style->border_tb.' font-weight:bold; text-align:center; width:1.0cm;">N</th>
                                    <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:4.0cm;">APELLIDOS</th>
                                    <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:4.0cm;">NOMBRES</th>
                                    <th style="'.$style->border_tb.' font-weight:bold; text-align:left; width:10.0cm;">USUARIO</th>
                                </tr>
                            </thead>
                            <tbody>
                                '.$alumnosDetaHTML.'
                            </tbody>
                        </table>';
                        $this->pdf->writeHTML($alumnosHTML,true,false,true,"");
                    }

                    $folderSave = FCPATH.'downloads/alumnos/';
                    $this->pdf->Output($folderSave."$titleHoja->anoLT-$titleHoja->nivel-$titleHoja->seccion.pdf", 'F');
                    $zip->addFile("downloads/alumnos/$titleHoja->anoLT-$titleHoja->nivel-$titleHoja->seccion.pdf", "$titleHoja->nivel/$titleHoja->anoLT-$titleHoja->nivel-$titleHoja->seccion.pdf");
                }
            ################
            #### EXCEL
            ################
                $hoja = 0;

                ###########################################
                ######### ESTILOS
                ###########################################
                    $estiloTitulo = array(
                                                    'font' => array(
                                                        'name'      => 'Calibri',
                                                        'bold'      => true,
                                                        'color'     => array(
                                                            'rgb' => '000000'
                                                        ),
                                                        'size' => 14
                                                    ),
                                                    'alignment' =>  array(
                                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                            'wrap'          => TRUE
                                                    )
                                                );

                    $estiloColumnasTitulo = array(
                                                    'font' => array(
                                                        'name'      => 'Calibri',
                                                        'bold'      => true,
                                                        'color'     => array(
                                                            'rgb' => '000000'
                                                        ),
                                                        'size' => 11
                                                    ),
                                                    'fill'  => array(
                                                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('argb' => 'ECF0F1')
                                                    ),
                                                    'alignment' =>  array(
                                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                            'wrap'          => TRUE
                                                    )
                                                );

                    $estiloColumnasPar = array(
                                                    'font' => array(
                                                        'name'      => 'Calibri',
                                                        'bold'      => false,
                                                        'color'     => array(
                                                            'rgb' => '000000'
                                                        )
                                                    ),
                                                    'fill'  => array(
                                                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('argb' => 'FFFFFFFF')
                                                    ),
                                                    'alignment' =>  array(
                                                            'wrap'          => TRUE
                                                    ),
                                                    'borders' => array(
                                                        'allborders' => array(
                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                            'color' => array( 'rgb' => "000000")
                                                        )
                                                    )
                                                );

                    $estiloColumnasImpar = array(
                                                    'font' => array(
                                                        'name'      => 'Calibri',
                                                        'bold'      => false,
                                                        'color'     => array(
                                                            'rgb' => '000000'
                                                        )
                                                    ),
                                                    'fill'  => array(
                                                        'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                        'color' => array('argb' => 'DCDCDCDC')
                                                    ),
                                                    'alignment' =>  array(
                                                            'wrap'          => TRUE
                                                    ),
                                                    'borders' => array(
                                                        'allborders' => array(
                                                            'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                            'color' => array( 'rgb' => "000000")
                                                        )
                                                    )
                                                );
                    $estiloBold = array(
                                                    'font' => array(
                                                        'name'      => 'Calibri',
                                                        'bold'      => true,
                                                        'color'     => array(
                                                            'rgb' => '000000'
                                                        ),
                                                        'size' => 11
                                                    )
                                                );
                    $estiloCenter = array(
                                                    'alignment' =>  array(
                                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                            'wrap'          => TRUE
                                                    )
                                                );
                    $estiloRight = array(
                                                    'alignment' =>  array(
                                                            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                                            'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                            'wrap'          => TRUE
                                                    )
                                                );

                    # ROJO PARA ANULADOS
                    $colorCelda = array(
                                            'font' => array(
                                                'name'      => 'Calibri',
                                                'bold'      => false,
                                                'color'     => array(
                                                    'rgb' => '000000'
                                                )
                                            ),
                                            'fill'  => array(
                                                'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array('argb' => "F28A8C")
                                            )
                                        );

                ################
                ###### HOJA 0
                ################
                    
                    $this->excel->setActiveSheetIndex($hoja);
                    $this->excel->getActiveSheet()->setTitle("ALUMNOS");

                    $this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTitulo);

                    $lugar = 7;
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "N")
                                                            ->setCellValue("B$lugar",  "APELLIDOS")
                                                            ->setCellValue("C$lugar",  "NOMBRES")
                                                            ->setCellValue("D$lugar",  "USUARIO")
                                                            ->setCellValue("E$lugar",  "AÑO")
                                                            ->setCellValue("F$lugar",  "NIVEL")
                                                            ->setCellValue("G$lugar",  "SECCIÓN");
                    $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
                    $lugar++;
                    
                    $alumnoInfo = $this->alumno_model->getAlumnos();
                    $lista = array();
                    
                    if (count($alumnoInfo) > 0) {
                        foreach ($alumnoInfo as $indice => $valor) {

                            if ($valor->grupo != "" ){
                                $data = $this->formatNivel($valor->grupo);
                                $ano = $data->ano;
                                $nivel = $data->nivel;
                                $seccion = $data->seccion;
                            }
                            else{
                                $ano = "";
                                $nivel = "";
                                $seccion = "";
                            }

                            $correo = $valor->correo;
                            $grupo = $valor->grupo;

                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $indice + 1)
                                                            ->setCellValue("B$lugar",  $valor->apellidos)
                                                            ->setCellValue("C$lugar",  $valor->nombres)
                                                            ->setCellValue("D$lugar",  $correo)
                                                            ->setCellValue("E$lugar",  $ano)
                                                            ->setCellValue("F$lugar",  $nivel)
                                                            ->setCellValue("G$lugar",  $seccion);

                            if ($indice % 2 == 0)
                                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                            else
                                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

                            $lugar++;
                        }
                    }

                    for($i = 'A'; $i <= 'G'; $i++){
                        if ($i != "E")
                            $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
                    }

                    $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth('6');

                    $img = "images/cabeceras/au.jpg";
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('Logo');
                    $objDrawing->setDescription('logo');
                    $objDrawing->setPath($img);
                    $objDrawing->setOffsetX(0); # setOffsetX works properly
                    $objDrawing->setOffsetY(0); # setOffsetY has no effect
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setHeight(110); # height
                    $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($hoja));

                    $filename = "downloads/alumnos/alumnos.xls";
                    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                    $objWriter->save($filename);

                    $zip->addFile($filename, "alumnos.xls");

                ####################
                ###### EXCEL GRUPOS
                ####################
                    /*foreach ($gruposInfo as $key => $val) {
                        $libro = $this->generatedGroupExcel($val->grupo);
                        $zip->addFile($libro->file, $libro->name);
                    }*/

            $zip->close();
            
            $files = glob('downloads/alumnos/*'); //obtenemos todos los nombres de los ficheros
            foreach($files as $file){
                if (is_file($file))
                    unlink($file); //elimino el fichero
            }
            rmdir("downloads/alumnos");

            #header("Content-type: application/octet-stream");
            #header("Content-disposition: attachment; filename=alumnos.zip");
            readfile('alumnos.zip');
            #unlink('alumnos.zip');
        }

        private function generatedGroupExcel($group){

            $Spreadsheet = new Spreadsheet();            
            $hoja = $Spreadsheet->getActiveSheet();
            
            $titleHoja = $this->formatNivel($group);
            $hoja->setTitle($titleHoja->anoLT . " " . $titleHoja->nivel . " " . $titleHoja->seccion);

            #$this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTitulo);
            $lugar = 7;

            $hoja->setCellValue("A$lugar",  "N")
                    ->setCellValue("B$lugar",  "APELLIDOS")
                    ->setCellValue("C$lugar",  "NOMBRES")
                    ->setCellValue("D$lugar",  "USUARIO")
                    ->setCellValue("E$lugar",  "AÑO")
                    ->setCellValue("F$lugar",  "NIVEL")
                    ->setCellValue("G$lugar",  "SECCIÓN");

            #$this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
            $lugar++;
            $filter = new stdClass();
            $filter->grupo = $group;
                    
            $alumnoInfo = $this->alumno_model->getAlumnos($filter);
            $lista = array();
            
            if (count($alumnoInfo) > 0) {
                foreach ($alumnoInfo as $indice => $valor) {
                    if ($valor->grupo != "" ){
                        $data = $this->formatNivel($valor->grupo);
                        $ano = $data->ano;
                        $nivel = $data->nivel;
                        $seccion = $data->seccion;
                    }
                    else{
                        $ano = "";
                        $nivel = "";
                        $seccion = "";
                    }
                    $correo = $valor->correo;
                    $grupo = $valor->grupo;
                    $hoja->setCellValue("A$lugar",  $indice + 1)
                        ->setCellValue("B$lugar",  $valor->apellidos)
                        ->setCellValue("C$lugar",  $valor->nombres)
                        ->setCellValue("D$lugar",  $correo)
                        ->setCellValue("E$lugar",  $ano)
                        ->setCellValue("F$lugar",  $nivel)
                        ->setCellValue("G$lugar",  $seccion);
                    #if ($indice % 2 == 0)
                    #    $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                    #else
                    #    $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

                    $lugar++;
                }
            }

            #for($i = 'A'; $i <= 'G'; $i++){
            #    if ($i != "E")
                    #$this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            #}

            #$this->excel->getActiveSheet()->getColumnDimension("E")->setWidth('6');
            
            $img = "images/cabeceras/au.jpg";
            $sheeti = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $sheeti->setName('Logo');
            $sheeti->setDescription('logo');
            $sheeti->setPath($img);
            $sheeti->setHeight(110);
            $sheeti->setCoordinates("A1");
            $sheeti->setOffsetX(0);
            $sheeti->setOffsetY(0);
            $sheeti->setWorksheet($hoja);

            $filename = "downloads/alumnos/".$titleHoja->anoLT . "-" . $titleHoja->nivel . "-" . $titleHoja->seccion.".xls";
            $writer = IOFactory::createWriter($Spreadsheet, 'Xlsx');
            $writer->save($filename);

            $routeFile = new stdClass();
            $routeFile->file = $filename;
            $routeFile->name = "excel/".$titleHoja->anoLT."-".$titleHoja->nivel."-".$titleHoja->seccion.".xls";
            
            return $routeFile;
        }

        private function generatedGroupExcel2($group){
            $hoja = 0;
            $this->excel->createSheet($hoja);
            $this->excel->setActiveSheetIndex($hoja);
            
            $titleHoja = $this->formatNivel($group);
            $this->excel->getActiveSheet()->setTitle($titleHoja->anoLT . " " . $titleHoja->nivel . " " . $titleHoja->seccion);
            $this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTitulo);
            $lugar = 7;
            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "N")
                                                    ->setCellValue("B$lugar",  "APELLIDOS")
                                                    ->setCellValue("C$lugar",  "NOMBRES")
                                                    ->setCellValue("D$lugar",  "USUARIO")
                                                    ->setCellValue("E$lugar",  "AÑO")
                                                    ->setCellValue("F$lugar",  "NIVEL")
                                                    ->setCellValue("G$lugar",  "SECCIÓN");
            $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
            $lugar++;
            $filter = new stdClass();
            $filter->grupo = $group;
                    
            $alumnoInfo = $this->alumno_model->getAlumnos($filter);
            $lista = array();
            
            if (count($alumnoInfo) > 0) {
                foreach ($alumnoInfo as $indice => $valor) {
                    if ($valor->grupo != "" ){
                        $data = $this->formatNivel($valor->grupo);
                        $ano = $data->ano;
                        $nivel = $data->nivel;
                        $seccion = $data->seccion;
                    }
                    else{
                        $ano = "";
                        $nivel = "";
                        $seccion = "";
                    }
                    $correo = $valor->correo;
                    $grupo = $valor->grupo;
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $indice + 1)
                                                    ->setCellValue("B$lugar",  $valor->apellidos)
                                                    ->setCellValue("C$lugar",  $valor->nombres)
                                                    ->setCellValue("D$lugar",  $correo)
                                                    ->setCellValue("E$lugar",  $ano)
                                                    ->setCellValue("F$lugar",  $nivel)
                                                    ->setCellValue("G$lugar",  $seccion);
                    if ($indice % 2 == 0)
                        $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                    else
                        $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

                    $lugar++;
                }
            }

            for($i = 'A'; $i <= 'G'; $i++){
                if ($i != "E")
                    $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
            }

            $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth('6');
            
            $img = "images/cabeceras/au.jpg";
            $objDrawing = new PHPExcel_Worksheet_Drawing();
            $objDrawing->setName('Logo');
            $objDrawing->setDescription('logo');
            $objDrawing->setPath($img);
            $objDrawing->setOffsetX(0); # setOffsetX works properly
            $objDrawing->setOffsetY(0); # setOffsetY has no effect
            $objDrawing->setCoordinates('A1');
            $objDrawing->setHeight(110); # height
            $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($hoja));

            $filename = "downloads/alumnos/".$titleHoja->anoLT . "-" . $titleHoja->nivel . "-" . $titleHoja->seccion.".xls";
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save($filename);

            $routeFile = new stdClass();
            $routeFile->file = $filename;
            $routeFile->name = "excel/".$titleHoja->anoLT."-".$titleHoja->nivel."-".$titleHoja->seccion.".xls";

            return $routeFile;
        }

        public function excel(){
            $hoja = 0;

            ###########################################
            ######### ESTILOS
            ###########################################
                $estiloTitulo = array(
                                                'font' => array(
                                                    'name'      => 'Calibri',
                                                    'bold'      => true,
                                                    'color'     => array(
                                                        'rgb' => '000000'
                                                    ),
                                                    'size' => 14
                                                ),
                                                'alignment' =>  array(
                                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                        'wrap'          => TRUE
                                                )
                                            );

                $estiloColumnasTitulo = array(
                                                'font' => array(
                                                    'name'      => 'Calibri',
                                                    'bold'      => true,
                                                    'color'     => array(
                                                        'rgb' => '000000'
                                                    ),
                                                    'size' => 11
                                                ),
                                                'fill'  => array(
                                                    'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('argb' => 'ECF0F1')
                                                ),
                                                'alignment' =>  array(
                                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                        'wrap'          => TRUE
                                                )
                                            );

                $estiloColumnasPar = array(
                                                'font' => array(
                                                    'name'      => 'Calibri',
                                                    'bold'      => false,
                                                    'color'     => array(
                                                        'rgb' => '000000'
                                                    )
                                                ),
                                                'fill'  => array(
                                                    'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('argb' => 'FFFFFFFF')
                                                ),
                                                'alignment' =>  array(
                                                        'wrap'          => TRUE
                                                ),
                                                'borders' => array(
                                                    'allborders' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                        'color' => array( 'rgb' => "000000")
                                                    )
                                                )
                                            );

                $estiloColumnasImpar = array(
                                                'font' => array(
                                                    'name'      => 'Calibri',
                                                    'bold'      => false,
                                                    'color'     => array(
                                                        'rgb' => '000000'
                                                    )
                                                ),
                                                'fill'  => array(
                                                    'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                                    'color' => array('argb' => 'DCDCDCDC')
                                                ),
                                                'alignment' =>  array(
                                                        'wrap'          => TRUE
                                                ),
                                                'borders' => array(
                                                    'allborders' => array(
                                                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                                                        'color' => array( 'rgb' => "000000")
                                                    )
                                                )
                                            );
                $estiloBold = array(
                                                'font' => array(
                                                    'name'      => 'Calibri',
                                                    'bold'      => true,
                                                    'color'     => array(
                                                        'rgb' => '000000'
                                                    ),
                                                    'size' => 11
                                                )
                                            );
                $estiloCenter = array(
                                                'alignment' =>  array(
                                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                                                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                        'wrap'          => TRUE
                                                )
                                            );
                $estiloRight = array(
                                                'alignment' =>  array(
                                                        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
                                                        'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                                                        'wrap'          => TRUE
                                                )
                                            );

                # ROJO PARA ANULADOS
                $colorCelda = array(
                                        'font' => array(
                                            'name'      => 'Calibri',
                                            'bold'      => false,
                                            'color'     => array(
                                                'rgb' => '000000'
                                            )
                                        ),
                                        'fill'  => array(
                                            'type'      => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('argb' => "F28A8C")
                                        )
                                    );

            ################
            ###### HOJA 0
            ################
                
                $this->excel->setActiveSheetIndex($hoja);
                $this->excel->getActiveSheet()->setTitle("ALUMNOS");

                $this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTitulo);

                $lugar = 7;
                $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "N")
                                                        ->setCellValue("B$lugar",  "APELLIDOS")
                                                        ->setCellValue("C$lugar",  "NOMBRES")
                                                        ->setCellValue("D$lugar",  "USUARIO")
                                                        ->setCellValue("E$lugar",  "AÑO")
                                                        ->setCellValue("F$lugar",  "NIVEL")
                                                        ->setCellValue("G$lugar",  "SECCIÓN");
                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
                $lugar++;

                    
                $filter = new stdClass();

                $filter->order = "grupo";
                $filter->dir = "ASC";

                $filter->descripcion = $this->input->post('descripcion');
                $filter->nivel = $this->input->post('nivel');
                $filter->curso = $this->input->post('curso');
                $filter->seccion = $this->input->post('seccion');

                $alumnoInfo = $this->alumno_model->getAlumnos($filter);
                $lista = array();
                
                if (count($alumnoInfo) > 0) {
                    foreach ($alumnoInfo as $indice => $valor) {

                        if ($valor->grupo != "" ){
                            $data = $this->formatNivel($valor->grupo);
                            $ano = $data->ano;
                            $nivel = $data->nivel;
                            $seccion = $data->seccion;
                        }
                        else{
                            $ano = "";
                            $nivel = "";
                            $seccion = "";
                        }

                        $correo = $valor->correo;
                        $grupo = $valor->grupo;

                        $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $indice + 1)
                                                        ->setCellValue("B$lugar",  $valor->apellidos)
                                                        ->setCellValue("C$lugar",  $valor->nombres)
                                                        ->setCellValue("D$lugar",  $correo)
                                                        ->setCellValue("E$lugar",  $ano)
                                                        ->setCellValue("F$lugar",  $nivel)
                                                        ->setCellValue("G$lugar",  $seccion);

                        if ($indice % 2 == 0)
                            $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                        else
                            $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

                        $lugar++;
                    }
                }

                for($i = 'A'; $i <= 'G'; $i++){
                    if ($i != "E")
                        $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
                }

                $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth('6');

                $img = "images/cabeceras/au.jpg";
                $objDrawing = new PHPExcel_Worksheet_Drawing();
                $objDrawing->setName('Logo');
                $objDrawing->setDescription('logo');
                $objDrawing->setPath($img);
                $objDrawing->setOffsetX(0); # setOffsetX works properly
                $objDrawing->setOffsetY(0); # setOffsetY has no effect
                $objDrawing->setCoordinates('A1');
                $objDrawing->setHeight(110); # height
                $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($hoja)); 

            ################
            ###### HOJAS
            ################
                
                $gruposInfo = $this->alumno_model->getGrupos();
                
                foreach ($gruposInfo as $key => $value) {

                    $hoja++;
                    $this->excel->createSheet($hoja);
                    $this->excel->setActiveSheetIndex($hoja);
                    
                    $titleHoja = $this->formatNivel($value->grupo);

                    $this->excel->getActiveSheet()->setTitle($titleHoja->anoLT . " " . $titleHoja->nivel . " " . $titleHoja->seccion);
                    $this->excel->getActiveSheet()->getStyle('A1:L1')->applyFromArray($estiloTitulo);

                    $lugar = 7;
                    $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  "N")
                                                            ->setCellValue("B$lugar",  "APELLIDOS")
                                                            ->setCellValue("C$lugar",  "NOMBRES")
                                                            ->setCellValue("D$lugar",  "USUARIO")
                                                            ->setCellValue("E$lugar",  "AÑO")
                                                            ->setCellValue("F$lugar",  "NIVEL")
                                                            ->setCellValue("G$lugar",  "SECCIÓN");
                    $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasTitulo);
                    $lugar++;

                    $filter = new stdClass();
                    $filter->grupo = $value->grupo;
                    
                    $alumnoInfo = $this->alumno_model->getAlumnos($filter);
                    $lista = array();
                    
                    if (count($alumnoInfo) > 0) {
                        foreach ($alumnoInfo as $indice => $valor) {

                            if ($valor->grupo != "" ){
                                $data = $this->formatNivel($valor->grupo);
                                $ano = $data->ano;
                                $nivel = $data->nivel;
                                $seccion = $data->seccion;
                            }
                            else{
                                $ano = "";
                                $nivel = "";
                                $seccion = "";
                            }

                            $correo = $valor->correo;
                            $grupo = $valor->grupo;

                            $this->excel->setActiveSheetIndex($hoja)->setCellValue("A$lugar",  $indice + 1)
                                                            ->setCellValue("B$lugar",  $valor->apellidos)
                                                            ->setCellValue("C$lugar",  $valor->nombres)
                                                            ->setCellValue("D$lugar",  $correo)
                                                            ->setCellValue("E$lugar",  $ano)
                                                            ->setCellValue("F$lugar",  $nivel)
                                                            ->setCellValue("G$lugar",  $seccion);

                            if ($indice % 2 == 0)
                                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasPar);
                            else
                                $this->excel->getActiveSheet()->getStyle("A$lugar:G$lugar")->applyFromArray($estiloColumnasImpar);

                            $lugar++;
                        }
                    }

                    for($i = 'A'; $i <= 'G'; $i++){
                        if ($i != "E")
                            $this->excel->setActiveSheetIndex($hoja)->getColumnDimension($i)->setAutoSize(true);
                    }

                    $this->excel->getActiveSheet()->getColumnDimension("E")->setWidth('6');
                    
                    $img = "images/cabeceras/au.jpg";
                    $objDrawing = new PHPExcel_Worksheet_Drawing();
                    $objDrawing->setName('Logo');
                    $objDrawing->setDescription('logo');
                    $objDrawing->setPath($img);
                    $objDrawing->setOffsetX(0); # setOffsetX works properly
                    $objDrawing->setOffsetY(0); # setOffsetY has no effect
                    $objDrawing->setCoordinates('A1');
                    $objDrawing->setHeight(110); # height
                    $objDrawing->setWorksheet($this->excel->setActiveSheetIndex($hoja));
                }

            $filename = "alumnos.xls";
            header("Content-Type: application/vnd.ms-excel");
            header("Content-Disposition: attachment;filename=$filename");
            header("Cache-Control: max-age=0");
            $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
            $objWriter->save('php://output');
        }

        public function formatNivel($grupo){
            $x = explode("@",$grupo);
            $xx = explode("2020",$x[0]);
            $info = $xx[0];

            $ano = substr($info,0,1);
            $seccion = strtoupper( substr($info,-1,1) );

            $lvl = strtoupper( substr($info,1,-1) );

            switch ( substr($lvl, 0, 2) ) {
                case 'RO':
                    $nivel = substr($lvl, 2);
                    break;
                case 'DO':
                    $nivel = substr($lvl, 2);
                    break;
                case 'TO':
                    $nivel = substr($lvl, 2);
                    break;
                case 'GR':
                    $nivel = "PRIMARIA";
                    break;
                case 'AN':
                    $nivel = "SECUNDARIA";
                    break;
                case 'IN':
                    $nivel = $lvl;
                    break;
                
                default:
                    $nivel = "";
                    break;
            }

            switch ($ano){
                case '1':
                    $anoLT .= $ano."RO";
                    $anoLarge .= "PRIMERO";
                    break;
                case '2':
                    $anoLT .= $ano."DO";
                    $anoLarge .= "SEGUNDO";
                    break;
                case '3':
                    $anoLT .= $ano."RO";
                    $anoLarge .= "TERCERO";
                    break;
                case '4':
                    $anoLT .= $ano."TO";
                    $anoLarge .= "CUARTO";
                    break;
                case '5':
                    $anoLT .= $ano."TO";
                    $anoLarge .= "QUINTO";
                    break;
                case '6':
                    $anoLT .= $ano."TO";
                    $anoLarge .= "SEXTO";
                    break;
                
                default:
                    $anoLT .= $ano;
                    break;
            }

            $format = new stdClass();
            $format->ano = $ano;
            $format->anoLT = $anoLT;
            $format->anoLarge = $anoLarge;
            $format->nivel = $nivel;
            $format->seccion = $seccion;

            return $format;
        }
}
?>