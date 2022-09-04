<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
   // HEADER
   function Header()
   {
      // Logo
      $this->Image('imagenes/logo_cabecera.jpg',10,8,33);
      // Arial bold 15
      $this->SetFont('Arial','B',20);
      // Movernos a la derecha
      $this->Cell(80);
      // T�tulo
      $this->Cell(30,10,'REPORTE MADERO CLEANER',0,0,'C');
      // Salto de l�nea
      $this->Ln(24);
   }
   
   // FOOTER
   function Footer()
   {
      // Posici�n: a 1,5 cm del final
      $this->SetY(-15);
      // Arial italic 8
      $this->SetFont('Arial','I',8);
      // N�mero de p�gina
      $this->Cell(0,10,utf8_decode(utf8_encode('P�gina ')).$this->PageNo().'/{nb}',0,0,'C');
   }
}