<?php

function execute_querry($sql,$conexiune){
	//echo $sql;
	$result=mysql_query($sql, $conexiune);
	if (!$result) {
		$output="Eroare in executia comenzii: ".mysql_error();
		$output.=" Ultima comanda executata: ".$sql;
		die($output);
	}
	return $result;
}

function site_stare($stare){
	switch ($stare){
		case "vandut de altii": return "vandut";break;
		case "vandut de noi": return "vandut";break;
		case "precontract": return "vandut";break;
		default: return $stare;
	}
}

function sync_Agenti(){
	global $conexiune2;
	//global $ftp_conn;
	$ftp_conn = ftp_connect(FTP_SERVER) or die("Could not connect to ftp location");
	$login_result = ftp_login($ftp_conn, FTP_USER, FTP_PASSWORD);
	
	
	$sql="SELECT * FROM Utilizator WHERE id=3";   // Doar Igor
	$useri=User::find_by_sql($sql);
	$sql="DELETE FROM fes_Agent";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE fes_Agent AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$agent=array();
	$sql_agent="INSERT INTO fes_Agent (id,Nume,Prenume,Telefon,Email,Poza) VALUES ";
	foreach ($useri as $usr){
		$agent["id"]=$usr->id;
		$agent["Nume"]=$usr->Nume;
		$agent["Prenume"]=$usr->Prenume;
		$agent["Telefon"]=$usr->Telefon;
		$agent["Email"]=$usr->Email;
		$agent["Poza"]=$usr->Poza;
		$sql_agent.="('".join("', '",array_values($agent))."'),";
		if (!ftp_put($ftp_conn, NEW_FTP_PATH.DS.$usr->Poza, "..".DS."images".DS.$usr->Poza, FTP_BINARY)) {
			echo "Nu am putut transfera poza agentului ".$usr->full_name().".</br>";
		}
	}
	$sql_agent=substr($sql_agent,0,strlen($sql_agent)-1);
	$result=execute_querry($sql_agent, $conexiune2);
	
	ftp_close($ftp_conn);
}

function sync_CategorieDotari(){
	global $conexiune2;
	
	$sql="SELECT * FROM CategorieDotari";
	$categorii=CategorieDotari::find_by_sql($sql);
	$sql="DELETE FROM fes_CategorieDotari";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE fes_CategorieDotari AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$CategorieDotari=array();
	$sql_catdot="INSERT INTO fes_CategorieDotari (id,Descriere,Prioritate) VALUES ";
	foreach ($categorii as $tmp){
		$CategorieDotari["id"]=$tmp->id;
		$CategorieDotari["Descriere"]=$tmp->Descriere;
		$CategorieDotari["Prioritate"]=$tmp->Prioritate;
		$sql_catdot.="('".join("', '",array_values($CategorieDotari))."'),";
	}
	$sql_catdot=substr($sql_catdot,0,strlen($sql_catdot)-1);
	$result=execute_querry($sql_catdot, $conexiune2);
}

function sync_Dotari(){
	global $conexiune2;
	
	$sql="SELECT * FROM Dotare";
	$tmparr=Dotare::find_by_sql($sql);
	$sql="DELETE FROM fes_Dotare";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE fes_Dotare AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$record=array();
	$sql="INSERT INTO fes_Dotare (id,Descriere,idCategorieDotari) VALUES ";
	foreach ($tmparr as $tmp){
		$record["id"]=$tmp->id;
		$record["Descriere"]=$tmp->Descriere;
		$record["idCategorieDotari"]=$tmp->idCategorieDotari;
		$sql.="('".join("', '",array_values($record))."'),";
	}
	$sql=substr($sql,0,strlen($sql)-1);
	$result=execute_querry($sql, $conexiune2);
}

function sync_Oferta($id){
	global $conexiune2;
	global $ftp_conn;
	
	$ftp_conn = ftp_connect(FTP_SERVER) or die("Could not connect to ftp location");
	$login_result = ftp_login($ftp_conn, FTP_USER, FTP_PASSWORD);
	
	
	$oferta_fields=array("id","idApartament","IdAgentVanzare","idAgentInchiriere","Pret","Moneda","Negociabil","DataActualizare",
						"OfertaSpeciala","Exclusivitate","Vanzare","Stare","ComisionClient","ComisionCumparatorZero","Inchiriere",
						"PretChirie","Titlu");
	
	$apartament_fields=array("id","DataIntrare","TipProprietate","NumarCamere","Confort","TipApartament","Duplex","Etaj","EtajeBloc",
						"TipConstructie","Subsol","Demisol","Parter","Etaje","Mansarda","Pod","Oras","Zona","Subzona","AnConstructie",
						"AnRenovare","NrGrupuriSanitare","Detalii","SuprafataUtila","SuprafataConstruita","SuprafataTerasa",
						"SuprafataEtaj1","SuprafataEtaj2","SuprafataEtaj3","SuprafataCurte","AmprentaSol","Deschidere","NumarDeschideri",
						"TipCurte","TipIntrare","NumarBalcoane","NumarBucatarii","NumarTerase","NumarParcari","NumarGaraje",
						"ProiectNefinalizat","Lat","Lng","LatimeDrumAcces","POT","CUT","Inclinatie","ConstructiePeTeren","Destinatie",
						"TipTeren","Clasificare","Localizare","TipSpatiu","Inaltime","Vitrina","ClasaBirouri","youtube");
	
	$oferta=Oferta::find_by_id($id);
	$apartament=Apartament::find_by_id($id);
	
	// sincronizare dotari
	sync_CategorieDotari();
	sync_Dotari();

	//echo $oferta->OfertaWeb;
	
	if (($oferta->OfertaWeb==2)||($oferta->OfertaWeb==3)) {
		$sql="SELECT NumeFisier FROM fes_Foto WHERE idApartament='{$apartament->id}'";
		$result=execute_querry($sql, $conexiune2);
		while ($row=mysql_fetch_array($result)){
			ftp_delete($ftp_conn, NEW_FTP_PATH.DS.$row[0]);
		}
		$sql="DELETE FROM fes_Apartament WHERE id='{$apartament->id}'";
		$result=execute_querry($sql, $conexiune2);
		$sql="DELETE FROM fes_Oferta WHERE id='{$oferta->id}'";
		$result=execute_querry($sql, $conexiune2);
		$sql="DELETE FROM fes_DotareApartament WHERE idApartament='{$apartament->id}'";
		$result=execute_querry($sql, $conexiune2);
		$sql="DELETE FROM fes_Foto WHERE idApartament='{$apartament->id}'";
		$result=execute_querry($sql, $conexiune2);
		
		if ($oferta->OfertaWeb==3) {
			$oferta->OfertaWeb=0;
			$oferta->save();
			return ;
		}
	}
	
	$subzona=Subzona::find_by_id($apartament->idSubzona);
	$cartier=Cartier::find_by_id($subzona->idCartier);
	$oras=Zona::find_by_id($cartier->idZona);
	
	
	foreach ($oferta_fields as $field){
		switch ($field){
			case "Stare": $site_oferta[]=site_stare($oferta->Stare);break;
			default: $site_oferta[]=$oferta->{$field};break;
		}
	}
	
	foreach ($apartament_fields as $field){
		switch ($field){
			case "Oras":$site_apartament[]=$oras->Denumire;break;
			case "Zona":$site_apartament[]=$cartier->Denumire;break;
			case "Subzona":$site_apartament[]=$subzona->Denumire;break;
			default:$site_apartament[]=$apartament->{$field};break;
		}
		
	}
	
	$sql_oferta="INSERT INTO fes_Oferta ";
	$sql_oferta.="(".join(",",array_values($oferta_fields)).")";
	$sql_oferta.=" VALUES ('".join("','",array_values($site_oferta))."')";

	
	$sql_apartament="INSERT INTO fes_Apartament ";	
	$sql_apartament.="(".join(",",array_values($apartament_fields)).")";
	$sql_apartament.=" VALUES ('".join("','",array_values($site_apartament))."')";
	
	$result=execute_querry($sql_apartament, $conexiune2);
	$result=execute_querry($sql_oferta, $conexiune2);
	
	// sincronizare dotari
	$sql="SELECT * FROM DotareApartament WHERE idApartament='{$apartament->id}'";
	$dotariApartament=Dotareapartament::find_by_sql($sql);
	if (!empty($dotariApartament)) {
		$sql_dotare="INSERT INTO fes_DotareApartament (idApartament,idDotare) VALUES ";
		foreach ($dotariApartament as $dotareApartament){
			$da["idApartament"]=$oferta->id;;
			$da["idDotare"]=$dotareApartament->idDotare;
			$sql_dotare.="('".join("', '",array_values($da))."'),";
		}
		$sql_dotare=substr($sql_dotare, 0,strlen($sql_dotare)-1);
		$result=execute_querry($sql_dotare, $conexiune2);
	}
	
	//sincronizare poze 
	
	if ($oferta->Vanzare) {
		if ($oferta->Inchiriere) {
			$pozaPrefix="Vanzare-Inchiriere-";
		}
		else {
			$pozaPrefix="Vanzare-";
		}
	}
	else {
		$pozaPrefix="Inchiriere-";
	}
	if ($apartament->TipProprietate<2) {
		$pozaPrefix.=($apartament->NumarCamere>1 ? ucfirst(tip_proprietate($apartament->TipProprietate))." ".$apartament->NumarCamere." camere ":"Garsoniera ");
	}
	else {
		if ($apartament->TipProprietate==2){
				$pozaPrefix.=($apartament->Etaje<1 ? "Casa " : "Vila ").$apartament->NumarCamere." camere ";
		}
		else {
			$pozaPrefix.=ucfirst(tip_proprietate($apartament->TipProprietate))." ";
			if ($apartament->TipProprietate==4){
				$pozaPrefix.=$apartament->TipSpatiu." ";
			}
		}
	}
	$zona=Zona::find_by_id($cartier->idZona);
	$pozaPrefix.=$zona->Denumire."-".$cartier->Denumire."-".$subzona->Denumire;
	
	$sql="SELECT * FROM Foto WHERE idApartament='{$apartament->id}'";
	$fotografii=Foto::find_by_sql($sql);
	if (!empty($fotografii)) {
		$sql_foto="INSERT INTO fes_Foto (idApartament, NumeFisier, Detalii, Ordin, Schita) VALUES ";
		foreach ($fotografii as $foto){
			$f["idProprietate"]=$oferta->id;
			
			$f["NumeFisier"]=str_replace(" ","-",$pozaPrefix)."-".$foto->NumeFisier;
			$f["Detalii"]=$foto->Detalii;
			$f["Ordin"]=$foto->Ordin;
			$f["Schita"]=$foto->Schita;
			$sql_foto.="('".join("', '",array_values($f))."'),";
			$ftp_file[]=$foto->NumeFisier;
			if (!ftp_put($ftp_conn, NEW_FTP_PATH.DS.$f["NumeFisier"], "..".DS."images".DS.$foto->NumeFisier, FTP_BINARY)){
				echo "Nu am reusit sa transfer foto {$foto->NumeFisier} al proprietatii {$oferta->id}";
			}
		}
		$sql_foto=substr($sql_foto, 0,strlen($sql_foto)-1);
		$result=execute_querry($sql_foto, $conexiune2);
	}
	
	//echo $sql_apartament."</br>";
	//echo $sql_oferta."</br";
	//echo $sql_dotare."</br";
	
	switch ($oferta->OfertaWeb){
		case 1:$oferta->OfertaWeb=4;break;
		case 2:$oferta->OfertaWeb=4;break;
		case 3:$oferta->OfertaWeb=0;break;
	}

	$oferta->save();
	
	ftp_close($ftp_conn);
}

?>