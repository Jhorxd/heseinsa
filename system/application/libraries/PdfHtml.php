<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
require_once APPPATH."/third_party/dompdf-master/vendor/autoload.php";
 
use Dompdf\Dompdf;
use Dompdf\Options;

class PdfHtml extends Dompdf 
{
    public function __construct()
    {
        parent::__construct(); 
    }
}