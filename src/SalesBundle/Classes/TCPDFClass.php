<?php


namespace SalesBundle\Classes;

use \TCPDF;

class TCPDFClass extends TCPDF
{
    //Page header
    public function Header() {
        $base = $_SERVER['DOCUMENT_ROOT'];
        // Logo
        $image_file = $base.'images/logo_labo.png';
        $this->Image($image_file, 5, 10, 50, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('helvetica', 'B', 18);
        $this->SetY(17);
        $this->SetX(20);
        // Title
        $this->Cell(0, 0, 'Liste des produits', 0, false, 'C', 0, '', 0, false, 'M', 'M');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-25);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $html = '<div style="width:50%;display:inline-block;height: 5px;text-align: center;"> <strong>Société Caremed</strong>, Rue Mohamed ben Hbib karma, Nabeul 8000 | <strong>Site web: </strong> http://www.caremed.com.tn</div>
                    <div style="width:100%;display:inline-block;height: 5px;text-align: center;"> labo@caremed.com.tn, Tél:(216) 72 287 588, Fax: (216) 72 287 499  </div>';

        $this->writeHTMLCell($w = 0, $h = 15, $x = '', $y = '', $html, $border = 0, $ln = 1, $fill = 0, $reseth = true, $align = '', $autopadding = true);
        $this->Cell(0, 5, 'Page '.$this->getAliasNumPage().'|'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}