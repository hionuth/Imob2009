<?php
require_once(".././include/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);

function dotari($categorie="",$idApartament=""){
	$ret="";
	$categorieList=explode(",", $categorie);
	$categorie=implode("' OR CD.Descriere='", $categorieList);
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D, CategorieDotari AS CD
		WHERE D.idCategorieDotari = CD.id
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND (CD.Descriere = '{$categorie}')
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)){
		foreach ($dotareList as $dotare){
			if ($dotare->idImobiliare>0) {$ret.=$dotare->idImobiliare." ";}
			if ($categorie=="Vecinatati") {$ret.=$dotare->Descriere.", ";}
		}
	}
	return $ret;
}

function count_dotari($categorie="",$idApartament=""){
	$ret=0;
	$categorieList=explode(",", $categorie);
	$categorie=implode("' OR CD.Descriere='", $categorieList);
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D, CategorieDotari AS CD
		WHERE D.idCategorieDotari = CD.id
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND (CD.Descriere = '{$categorie}')
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)){
		foreach ($dotareList as $dotare){
			$ret=$ret+1;
		}
	}
	return $ret;
}

function are_dotarea($dotare,$idApartament){
	$ret=0;
	$sql="
		SELECT D.Descriere,D.idImobiliare
		FROM Apartament AS A, DotareApartament AS DA, Dotare AS D
		WHERE D.Descriere = '{$dotare}'
		AND DA.idDotare = D.id
		AND DA.idApartament = A.id
		AND A.id ={$idApartament}";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)) $ret=1;
	return $ret;
}

function posteazaAnunt($inchiriere=0){
	
	global $oferta;
	global $apartament;
	global $client;
	global $agent;
	global $subzona;
	global $fotografii;
	global $s;
	global $session_id;
	global $idImobiliare;
	global $ok;
	
	$id=$oferta->id;
	if ($inchiriere) { $id+=90000;}
	
	$compartimentare=array(	"Decomandat" => 26 ,
						   	"Semidecomandat" => 27,
							"Circular" => 29,
							"Comandat" => 28,
							"Duplex" => 26);
	$moneda=array(
					"EUR"=>172,
					"RON"=>173,
					"LEI"=>173,
					"USD"=>174
	);
	
	$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
	<oferta tip="apartament" versiune="2">
	<id2>'. $id . '</id2>'
	.($inchiriere>0 ? "<deinchiriat>1</deinchiriat>":"<devanzare>1</devanzare>").'
	<tara>1048</tara>
	<judet>10</judet>
	<localitate>13822</localitate>
	<zona>'.$subzona->idImobiliare.'</zona>
	<nrcamere>'.$apartament->NumarCamere.'</nrcamere>
	<tiplocuinta>'.($apartament->NumarCamere>1 ? "110" : "111").'</tiplocuinta>
	<tipcompartimentare>'.$compartimentare[$apartament->TipApartament].'</tipcompartimentare>
	<etaj>'.($apartament->Etaj+45).'</etaj>
	<tipimobil>121</tipimobil>
	<longitudine>'.$apartament->Lng.'</longitudine>
	<latitudine>'.$apartament->Lat.'</latitudine>
	<altitudine>200</altitudine>';
	if ($apartament->SuprafataUtila>0) { $ofertaxml.="<suprafatautila>{$apartament->SuprafataUtila}</suprafatautila>";}
	if ($apartament->SuprafataConstruita>0) {$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";}
	
	if($oferta->Titlu!="") {
		$ofertaxml.="<titlu><lang id=\"1048\">".base64_encode($oferta->Titlu)."</lang></titlu>";
	}

	if (!($inchiriere>0)){
		$ofertaxml.="<pretvanzare>".($oferta->Pret+0)."</pretvanzare>";
		$ofertaxml.="<monedavanzare>{$moneda[$oferta->Moneda]}</monedavanzare>";
	}
	else {
		$ofertaxml.="<pretinchiriere>{$oferta->PretChirie}</pretinchiriere>";
		$ofertaxml.="<monedainchiriere>{$moneda[$oferta->Moneda]}</monedainchiriere>";
	}
	$ofertaxml.="<comisioncumparator><lang id=\"1048\">".base64_encode($oferta->ComisionClient)."</lang></comisioncumparator>";
	$ofertaxml.="<confort>".($apartament->Confort+36)."</confort>
	<anconstructie>{$apartament->AnConstructie}</anconstructie>
	<nrnivele>{$apartament->EtajeBloc}</nrnivele>
	<nrbai>{$apartament->NrGrupuriSanitare}</nrbai>
	<nrbalcoane>{$apartament->NumarBalcoane}</nrbalcoane>
	<nrbucatarii>1</nrbucatarii>
	<nrgaraje>".(are_dotarea("parcare subterana", $apartament->id)+are_dotarea("garaj", $apartament->id))."</nrgaraje>
	<nrlocuriparcare>".(are_dotarea("parcare inchiriata", $apartament->id)+are_dotarea("parcare proprie", $apartament->id))."</nrlocuriparcare>
	<agent>{$agent->id}</agent>";
 		
	$tmp="";
	if (are_dotarea("nou / finalizat", $apartament->id)) $tmp="127";
	if (are_dotarea("stare buna", $apartament->id)) $tmp="127";
	if (are_dotarea("necesita renovare", $apartament->id)) $tmp="127";
	if (are_dotarea("reabilitat termic", $apartament->id)) $tmp="127";
	if (are_dotarea("nou / nefinalizat", $apartament->id)) $tmp="129";
	if ($tmp!="") { 
		$ofertaxml.="<stadiuconstructie>{$tmp}</stadiuconstructie>";
	}
	
	$tmp="";
	if (are_dotarea("beton", $apartament->id)) $tmp="136";
	if (are_dotarea("caramida", $apartament->id)) $tmp="137";
	if (are_dotarea("bca", $apartament->id)) $tmp="138";
	if (are_dotarea("lemn", $apartament->id)) $tmp="139";
	if (are_dotarea("metal", $apartament->id)) $tmp="140";
	if ($tmp!="") { 
		$ofertaxml.="<structurarezistenta>{$tmp}</structurarezistenta>";
	}
	
	// destinatie 
	$ofertaxml.="<destinatie>".dotari("Destinatie",$apartament->id)."</destinatie>\n";
	$ofertaxml.="<dotari>".dotari("Mobilier,Electrocasnice,Contorizare,Spatii utile,Dotari Imobil",$apartament->id)."</dotari>\n";
	$ofertaxml.="<finisaje>".dotari("Finisaje / Dotari",$apartament->id).
				(are_dotarea("renovat", $apartament->id) ? "24 " : "").
				(are_dotarea("stare buna", $apartament->id) ? "5 " : "").
				(are_dotarea("curat", $apartament->id) ? "5 " : "").
				(are_dotarea("necesita renovare", $apartament->id) ? "99 " : "")."</finisaje>\n";
	$ofertaxml.="<utilitati>".dotari("Utilitati,Sistem de incalzire",$apartament->id).
				(are_dotarea("aer conditionat", $apartament->id) ? "44 " : "")."</utilitati>\n";
	$ofertaxml.="<vecinatati><lang id=\"1048\">".base64_encode(dotari("Vecinatati",$apartament->id))."</lang></vecinatati>\n";
	$ofertaxml.="<servicii>".dotari("Servicii???",$apartament->id)."</servicii>\n";
	$ofertaxml.="<descriere><lang id=\"1048\">".base64_encode($apartament->Detalii)."</lang></descriere>";
	$ofertaxml.="<altedetaliizona>67,302,303</altedetaliizona>";
	$ofertaxml.="<sector>{$apartament->Sector}</sector>";
	$ofertaxml.="<alias>SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT)."</alias>";
	if ($oferta->Negociabil>0) { $ofertaxml.="<pretnegociabil>1</pretnegociabil>";}
	if ($oferta->Exclusivitate>0) { $ofertaxml.="<exclusivitate>1</exclusivitate>"; }
	if ($oferta->OfertaWeb>0) {$ofertaxml.="<linkextern>http://www.simsparkman.ro/detaliioferta.php?id={$oferta->id}</linkextern>";}
	
	$sql="SELECT COUNT(*) FROM Foto WHERE idApartament={$apartament->id}";
	$nrimagini=Foto::count_by_sql($sql);
	if ($nrimagini>0){
		$ofertaxml.="<imagini nrimagini=\"{$nrimagini}\">";
		$fotoList=Foto::find_by_sql("SELECT * FROM Foto WHERE idApartament={$apartament->id}");
		foreach ($fotoList as $foto) {
			$ofertaxml.="<imagine dummy=\"False\" modificata=\"1228840157\" latime=\"800\" inaltime=\"600\" pozitie=\"{$foto->Ordin}\">";
			$ofertaxml.="<descriere>".base64_encode($foto->Detalii)."</descriere>";
			$ofertaxml.="<blob>";
			$ofertaxml.= base64_encode(file_get_contents("..".DS.$foto->image_path()));			
			$ofertaxml.="</blob>";
			$ofertaxml.="</imagine>";
		}
		$ofertaxml.="</imagini>\n";
	}
	
	

	//echo $ofertaxml;
	
		
	
	if (($oferta->ExportImobiliare<3)&&($oferta->Stare=='de actualitate')) {
		if ($oferta->ExportImobiliare=1) {
			$operatie="MOD";
			$ofertaxml.="<datamodificare>".time()."</datamodificare>";
		}
		else { 
			$operatie="ADD";
			$ofertaxml.="<dataadaugare>".time()."</dataadaugare>";
		}
	}
	else { $operatie="DEL";}
	
	$ofertaxml.='</oferta>';
	//echo $ofertaxml;
	
	
	// publica oferta
	$ok=1;
	try {
		$result = $s->__soapCall( 
			'publica_oferta', 
			array( 
				'publica_oferta' => array( 
					'id_str'		=> '0:' . $id,
					'sid' 			=> $session_id, 
					'operatie'		=> $operatie,
					'ofertaxml' 	=> $ofertaxml,
				) 	
			) 
		); 
	} catch( Exception $e ) {
		$ok=0;
		die( 'Eroare Publicare oferta: ' . $e->getMessage() );
	}
	if (isset($result->mesaj)) {$idImobiliare=array_pop(explode(" ", $result->mesaj));}
	echo '<pre>PUBLICARE OFERTA: ' . print_r( $result, true ) . '</pre>';
}

function posteazaAgent(){
	
	global $s;
	global $session_id;
	
	$agenti=User::find_all();
	foreach ($agenti as $agent){
		$agentxml="<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>";
		$agentxml.="<agent>
		<id>{$agent->id}</id>
		<email>{$agent->Email}</email>
		<mobil>{$agent->Telefon}</mobil>
		<nume>".$agent->full_name()."</nume>
		<username>{$agent->User}</username>
		<password>{$agent->Parola}</password>
		<functie>Broker imobiliar</functie>
		";
		if ($agent->Poza!=""){
			$agentxml.="<poza>".base64_encode(file_get_contents("..".DS.$agent->image_path()))."</poza>";
		}
		// <telefon>0314398268</telefon>
		$agentxml.="</agent>";
		
		//echo $agentxml."\n";
		// publica AGENT

		$operatie="MOD";

		try {
			$result = $s->__soapCall( 
				'publica_agent', 
				array( 
					'publica_agent' => array( 
						'id'			=> $agent->id,
						'sid' 			=> $session_id, 
						'operatie'		=> $operatie,
						'agentxml' 		=> $agentxml,
					) 	
				) 
			); 
		} catch( Exception $e ) {
			die( 'Eroare Publicare agent: ' . $e->getMessage() );
		}
		echo '<pre>PUBLICARE Agent id '.$agent->id.': ' . print_r( $result, true ) . '</pre>';
		
	}
}



echo "Sincronizare in curs ...<br/>";

$s = new SoapClient( API_URI ); 
// login
echo "Login<br/>";
try {
	$result = $s->__soapCall( 
		'login', 
		array( 
			'login' => array( 
				'id' 	=> API_USER, 
				'hid' 	=> API_KEY,
				'server' => '',
				'agent'	 	=> '',
				'parola'	=> '',
			) 
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Login: ' . $e->getMessage() );
}

$extra = explode( '#', $result->extra );
// id-ul de sesiune va fi folosit ulterior la orice request
$session_id = $extra[ 1 ];
echo "<pre> LOGIN: " . print_r( $result, true ) . '</pre>';

posteazaAgent();


$sql="SELECT * FROM Oferta WHERE ExportImobiliare>0 AND ExportImobiliare<4"; // AND Stare='de actualitate'";
// status oferta: 
//					0 - nu se exporta
//					1 - creare
//					2 - update
//					3 - delete
//					4 - exportat
$oferte=Oferta::find_by_sql($sql);
if (!empty($oferte)){
	foreach ($oferte as $oferta) {
		echo $oferta->id;
		$apartament=Apartament::find_by_id($oferta->idApartament);
		$client=Client::find_by_id($apartament->idClient);
		$agent=User::find_by_id($client->idUtilizator);
		$subzona=Subzona::find_by_id($apartament->idSubzona);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin";
		$fotografii=Foto::find_by_sql($sql);
		$ok=0;
		$idImobiliare="";
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportImobiliare=($oferta->ExportImobiliare==3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportImobiliare=0;}
		if ($ok==1){
			$oferta->LinkImobiliare="http://www.imobiliare.ro/apartamente/".$idImobiliare;
		}
		else	{$oferta->LinkImobiliare="";}
		$oferta->save();
	}
}

// logout
try {
	$result = $s->__soapCall( 
		'logout', 
		array( 
			'logout' => array( 
				'sid' 		=> $session_id, 
				'id'		=> '',
				'jurnal'	=> '',
			) 
		) 
	); 
} catch( Exception $e ) {
	die( 'Eroare Logout: ' . $e->getMessage() );
}
echo '<pre>LOGOUT: ' . print_r( $result, true ) . '</pre>';

echo "<br/>Sincronizare terminata.";
//require_once(".././include/head.php");
//redirect_to($currentPage)
?>