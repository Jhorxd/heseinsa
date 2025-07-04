<?php 
//defined('BASEPATH') OR exit('No direct script access allowed');

//include_once (__DIR__ .'\..\fpdf\fpdf.php');
//include_once (__DIR__ . "/fpdf/fpdf.php");
//echo  __DIR__."..\.";
include_once("system/application/libraries/fpdf/fpdf.php");
//var_dump($ruta);
/**
* 
*/
class Plantilla extends FPDF
{
	/*var $somevar;
	protected $CI;

	public function __construct() {
		parent::__construct();
		$this->CI =& get_instance();
		$this->CI->load->library('session');

		$this->somevar['compania'] = $this->CI->session->userdata('compania');
	}*/

	public function Header()
	{
		//$compania = $this->somevar['compania'];
		//var_dump($compania);
		//if($compania==1)
			$this->Image('images/documentos/cabezera.png',0,0,210);
		//else
			
		$this->SetFont('Arial','B',15);
		$this->Cell(30);
		//$this->Cell(120,10,'rEPORTE DE ESTADO',0,0,'C');

		$this->Ln(35);
	}
	public function Footer()
	{
		//$this->SetY(-500);
		/*$this->SetFont('Arial','I',15);
		$this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0);*/
		$this->Image('images/documentos/footer.png',0,275,210);
	}
}
 ?>