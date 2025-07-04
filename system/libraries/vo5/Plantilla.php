<?php
defined('BASEPATH') OR exit('No direct script access allowed');

include("system/application/libraries/fpdf/fpdf.php");

class PDF extends FPDF
{
	function Header()
	{
		$this->Image('images/documentos/cabezera.png',5,5,30);
		$this->setFont('Arial','B',15);
		$this->Cell(30);
		$this->Cell(120,10,'reporte de Estado',0,0,'C');
		$this->Ln(20);
	}
	function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','I',8);
		$this->Cell(0,10,'Pagina '$this->PageNo().'/{nb}',0,0,'C');
	}
}
?>