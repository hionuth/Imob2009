<?php 

class PDF extends FPDF {
	function Header()
	{
	    $this->Image(SITE_ROOT.DS.'images'.DS.'pdf'.DS.'header.png',53,8,100);
	    $this->SetFont('Arial','B',15);
	    $this->Ln(30);
	}
	function Footer()
	{
	    //Position at 1.5 cm from bottom
	    $this->SetY(-15);
	    $this->SetX(0);
	    $this->Image(SITE_ROOT.DS.'images'.DS.'pdf'.DS.'footer.png',0,$this->hPt/$this->k-15,$this->wPt/$this->k);
	   	$this->SetY(-18);
	    //Arial italic 8
	    $this->SetFont('Arial','B',8);
	    $this->SetTextColor(255,255,255);
	    //Page number
	    $this->Cell(0,10,'tel 0723i',0,0,'C');
	    $this->Ln(4);
	    $this->Cell(0,10,'linia2',0,0,'C');
	    $this->SetY(-10);
	    $this->SetTextColor(0,0,0);
	    $this->Cell(0,10,'www.simsparman.ro',0,0,'C');
	}
}
?>