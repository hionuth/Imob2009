<?php
	ini_set('display_errors', 1); 
	require_once(".././include/initialize.php");
	
	$oferta=Oferta::find_by_id($_GET['id']);
	$apartament=Apartament::find_by_id($oferta->idApartament);
	$client=Client::find_by_id($apartament->idClient);
	$agent=User::find_by_id($client->idUtilizator);
	
	$pdf=new PDF();
	$pdf->AddPage();
	$pdf->SetMargins(15, 15);
	//descriere proprietate
	$pdf->Image(PDF_PATH.DS.'bara1.png',15,45,130.5);
	$pdf->SetFont("Times","",14);
	$pdf->SetXY(25, 42.5);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'PROPRIETATE ',0,1);

	$pdf->SetXY(15.35, 51);
	$pdf->SetDrawColor(175,37,28);
    $pdf->SetLineWidth(.5);
	$pdf->Cell(130,18,"",1);
	// descriere proprietate
	$pdf->SetXY(18, 53);
	$pdf->SetTextColor(0);
	$pdf->Cell(130,7,$oferta->Titlu);
	//$pdf->SetXY(18, 60);
	//$pdf->Cell(130,7,$proprietate->Descriere);
	//pret
	$pdf->Image(PDF_PATH.DS.'bara2.png',155,45,42);
	$pdf->SetFont("Times","",14);
	$pdf->SetXY(165, 42.5);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'PRET',0,1);
	$pdf->SetXY(155.35, 51);
	$pdf->SetDrawColor(175,37,28);
    $pdf->SetLineWidth(.5);
	$pdf->Cell(41.3,18,"",1);
	$pdf->SetXY(158, 58);
	$pdf->SetTextColor(0);
	$pdf->Cell(40,7,$oferta->Pret." ".$oferta->Moneda);
	// imagini
	$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin"; 
	$poze=Foto::find_by_sql($sql);
	if (!empty($poze)){
		$i=0;
		foreach ($poze as $poza){
			$i++;
			if ($i==1){
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,15,75,97.0833,72.8125);
			}
			if ($i==2){
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,117.3,      75,27.9167,20.9375);
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,117.3,100.9375,27.9167,20.9375);
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,117.3, 126.875,27.9167,20.9375);
			}
			if ($i==3){
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,117.3,100.9375,27.9167,20.9375);
			}
			if ($i==4){
				$pdf->Image(PHOTO_PATH.DS.$poza->NumeFisier,117.3, 126.875,27.9167,20.9375);
			}
		}
	}
	
	// detalii
	
	$pdf->Image(PDF_PATH.DS.'bara2.png',155,75,42);
	$pdf->SetFont("Times","",14);
	$pdf->SetXY(165, 72.5);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'Detalii',0,1);
	
	$pdf->SetFont("Arial","",10);
	$pdf->SetXY(155, 82);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,11,'Suprafata utila:',0,1);
	$pdf->SetXY(155, 87);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,11,$apartament->SuprafataUtila.' mp',0,1);
	
	$pdf->SetFont("Arial","",10);
	$pdf->SetXY(155, 95);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,11,'Suprafata totala:',0,1);
	$pdf->SetXY(155, 100);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,11,$apartament->SuprafataConstruita.' mp',0,1);

	$pdf->SetFont("Arial","",10);
	$pdf->SetXY(155, 108);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,11,'Numar camere:',0,1);
	$pdf->SetXY(155, 113);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,11,$apartament->NumarCamere,0,1);

	$pdf->SetFont("Arial","",10);
	$pdf->SetXY(155, 121);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,11,'Anul constructiei:',0,1);
	$pdf->SetXY(155, 126);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,11,$apartament->AnConstructie,0,1);

	$pdf->SetFont("Arial","",10);
	$pdf->SetXY(155, 134);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,11,'Numar balcoane:',0,1);
	$pdf->SetXY(155, 139);
	$pdf->SetTextColor(0);
	$pdf->Cell(15,11,$apartament->NumarBalcoane,0,1);
	
	$pdf->Image(PDF_PATH.DS.'bara3.png',15,153,182);
	$pdf->SetFont("Times","",14);
	$pdf->SetXY(25, 151);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'Descriere',0,1);
	
	$pdf->SetFont("Arial","",10);
	//$pdf->SetXY(15, 161);
	$pdf->SetTextColor(0);
	$pdf->MultiCell(182,4.5,$apartament->Detalii,0);
	
	$pdf->SetY($pdf->y+5);
	$pdf->Image(PDF_PATH.DS.'bara3.png',$pdf->x,$pdf->y,182);
	$pdf->SetY($pdf->y-2.2);
	$pdf->SetX($pdf->x+10);
	$pdf->SetFont("Times","",14);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'Amenajari si alte detalii',0,1);
	
	//$sql="SELECT * FROM CategorieDotari WHERE TipProprietate={$proprietate->TipProprietate} ORDER BY Prioritate";
	$sql="SELECT * FROM CategorieDotari WHERE TipProprietate='1' AND Privat<>1 ORDER BY Prioritate";
	$CatDotList=CategorieDotari::find_by_sql($sql);
			
	if (!empty($CatDotList)) {
		foreach($CatDotList as $CatDot){
			$sql="SELECT * FROM Dotare WHERE idCategorieDotari='{$CatDot->id}'";
			$DotList=Dotare::find_by_sql($sql);
			if (!empty($DotList)){
				foreach($DotList as $Dot){
					$sql="SELECT * FROM DotareApartament WHERE idDotare='{$Dot->id}' AND idApartament='{$apartament->id}'";
					$DotApList=Dotareapartament::find_by_sql($sql);
					if (!empty($DotApList)){
						foreach($DotApList as $DotAp){
							if (!isset($dotString[$CatDot->id])) {
		   						$dotCat[$CatDot->id]=$CatDot->Descriere;
		   						$dotString[$CatDot->id]=$Dot->Descriere;
		   					}
		   					else {$dotString[$CatDot->id].=", ".$Dot->Descriere; }
						}
					}
						
				}
			}
		}
		
	}
	if (!empty($dotCat)) {
   		foreach($dotCat as $key => $categorie){
			$pdf->SetFont("Arial","",10);
			$pdf->SetTextColor(175,37,28);
			$pdf->Cell(15,4.5,$categorie.':',0,1);
			$pdf->SetXY(60,$pdf->y-4.5);
			$pdf->SetTextColor(0);
			$pdf->MultiCell(137, 4.5,$dotString[$key],0);
			$pdf->SetY($pdf->y+2);
   		}
	}
	
	$pdf->SetY($pdf->y+3);
	$pdf->Image(PDF_PATH.DS.'bara3.png',$pdf->x,$pdf->y,182);
	$pdf->SetY($pdf->y-2);
	$pdf->SetX($pdf->x+10);
	$pdf->SetFont("Times","",14);
	$pdf->SetTextColor(255,255,255);
	$pdf->Cell(15,11,'CONTACT',0,1);
	
	
	$pdf->SetFont("Arial","",10);
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,4.5,'Broker:',0,1);
	$pdf->SetXY(60,$pdf->y-4.5);
	$pdf->SetTextColor(0);
	$pdf->MultiCell(137, 4.5,$agent->full_name(),0);
	
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,4.5,'Telefon:',0,1);
	$pdf->SetXY(60,$pdf->y-4.5);
	$pdf->SetTextColor(0);
	$pdf->MultiCell(137, 4.5,$agent->Telefon,0);
	
	$pdf->SetTextColor(175,37,28);
	$pdf->Cell(15,4.5,'Email:',0,1);
	$pdf->SetXY(60,$pdf->y-4.5);
	$pdf->SetTextColor(0);
	//$pdf->MultiCell(137, 4.5,$agent->Email,0);
	
	$pdf->Output();
?>