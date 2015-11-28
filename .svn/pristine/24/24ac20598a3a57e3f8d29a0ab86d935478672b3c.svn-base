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

function corespondent($proprietate,$val1="",$val2="",$val3="",$val4=""){
	if ($proprietate<2) return $val1;
	if ($proprietate==2) return $val2;
	if ($proprietate==3) return $val3;
	if ($proprietate==4) return $val4;
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
	<oferta tip="';//."apartament"
	switch ($apartament->TipProprietate){
		case 0:$ofertaxml.="apartament"; break;
		case 1:$ofertaxml.="apartament"; break;
		case 2:$ofertaxml.="casavila"; break;
		case 3:$ofertaxml.="teren"; break;
		case 4:$ofertaxml.="spatiu"; break;
	} 
	$ofertaxml.='" versiune="3">
	<id2>'. $id . '</id2>'
	.($inchiriere>0 ? "<deinchiriat>1</deinchiriat>":"<devanzare>1</devanzare>").'
	<tara>1048</tara>
	<judet>10</judet>
	<localitate>13822</localitate>
	<zona>'.$subzona->idImobiliare.'</zona>
	<siteagentie>0</siteagentie>
	<portal>0</portal>';
	if ($apartament->TipProprietate<2) $ofertaxml.='<tiplocuinta>'.($apartament->NumarCamere>1 ? "110" : "111").'</tiplocuinta>';
	if ($apartament->TipProprietate==4) {
		switch ($apartament->TipSpatiu){
			case "birouri": $ofertaxml.='<tipspatiu>419</tipspatiu>';break;
			case "comercial": $ofertaxml.='<tipspatiu>420</tipspatiu>';break;
			case "industrial": $ofertaxml.='<tipspatiu>421</tipspatiu>';break;
			case "hotel": $ofertaxml.='<tipspatiu>422</tipspatiu>';break;
			default: $ofertaxml.='<tipspatiu>420</tipspatiu>';
		}
	}
	
	if ($apartament->TipProprietate<3) $ofertaxml.='<nrcamere>'.$apartament->NumarCamere.'</nrcamere>';
	if (strpos("013", $apartament->TipProprietate)!==false) $ofertaxml.='<etaj>'.($apartament->Etaj+45).'</etaj>';
	
	$ofertaxml.='<longitudine>'.$apartament->Lng.'</longitudine>
	<latitudine>'.$apartament->Lat.'</latitudine>
	<altitudine>200</altitudine>';
	
	if ($apartament->SuprafataConstruita>0) {$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";}
	
	if (!($inchiriere>0)){
		$ofertaxml.="<pretvanzare>".($oferta->Pret+0)."</pretvanzare>";
		$ofertaxml.="<monedavanzare>{$moneda[$oferta->Moneda]}</monedavanzare>";
	}
	else {
		$ofertaxml.="<pretinchiriere>{$oferta->PretChirie}</pretinchiriere>";
		$ofertaxml.="<monedainchiriere>{$moneda[$oferta->Moneda]}</monedainchiriere>";
	}
	if ($oferta->ComisionCumparatorZero=='1') $ofertaxml.="<comisionzero>1</comisionzero>";
	else {
		$ofertaxml.="<comisionzero>2</comisionzero>";
		$ofertaxml.="<comisioncumparator><lang id=\"1048\">".base64_encode($oferta->ComisionClient)."</lang></comisioncumparator>";
	}
	
	if ($apartament->TipProprietate!=3) {  // fara terenuri
		$ofertaxml.="<suprafatautila>{$apartament->SuprafataUtila}</suprafatautila>";
		$ofertaxml.="<anconstructie>{$apartament->AnConstructie}</anconstructie>";
		$ofertaxml.="<nrgaraje>{$apartament->NumarGaraje}</nrgaraje>";
		
	}
	
	if ($apartament->TipProprietate<3) {   // apartamente si case
		$ofertaxml.="<regimhotelier>0</regimhotelier>";
		$ofertaxml.="<nrnivele>{$apartament->EtajeBloc}</nrnivele>";
		$ofertaxml.="<nrbai>{$apartament->NrGrupuriSanitare}</nrbai>";
		$ofertaxml.="<nrbalcoane>{$apartament->NumarBalcoane}</nrbalcoane>";
		$ofertaxml.="<nrbucatarii>{$apartament->NumarBucatarii}</nrbucatarii>";
		$ofertaxml.="<nrlocuriparcare>{$apartament->NumarParcari}</nrlocuriparcare>";
	}

	
	if ($apartament->TipProprietate<4) {    // fara spatii
		$tmp="";
		if (are_dotarea("birouri", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,468,456,"","");
		if (are_dotarea("rezidential", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,466,454,471,"");
		if (are_dotarea("comercial", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,467,455,473,"");
		if (are_dotarea("agricol", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"","",472,"");
		if (are_dotarea("industrial", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,"","",474,"");
		$ofertaxml.="<destinatie>{$tmp}</destinatie>";
	}
	
	if ($apartament->TipProprietate<2) {     // doar apartamente
		$ofertaxml.='<tipcompartimentare>'.$compartimentare[$apartament->TipApartament].'</tipcompartimentare>';
		$ofertaxml.="<tipimobil>".(121+$apartament->TipProprietate)."</tipimobil>";
		$ofertaxml.="<confort>".($apartament->Confort+36)."</confort>";
		$ofertaxml.="<dotari>".dotari("Mobilier,Electrocasnice,Contorizare,Spatii utile,Dotari Imobil",$apartament->id)."</dotari>";
		$ofertaxml.="<finisaje>".dotari("Finisaje / Dotari",$apartament->id).
								(are_dotarea("renovat", $apartament->id) ? "24 " : "").
								(are_dotarea("stare buna", $apartament->id) ? "5 " : "").
								(are_dotarea("curat", $apartament->id) ? "5 " : "").
								(are_dotarea("necesita renovare", $apartament->id) ? "99 " : "")."</finisaje>";
		$ofertaxml.="<utilitati>".dotari("Utilitati,Sistem de incalzire",$apartament->id).
									(are_dotarea("aer conditionat", $apartament->id) ? "44 " : "")."</utilitati>";
		$ofertaxml.="<altedetaliizona>47,67,75</altedetaliizona>";
	}
	
	if ($apartament->TipProprietate==2) {  // doar case
		$ofertaxml.="<frontstradal>{$apartament->Deschidere}</frontstradal>";
		$ofertaxml.="<suprafatateren>{$apartament->SuprafataCurte}</suprafatateren>";
		$ofertaxml.="<nrterase>{$apartament->NumarTerase}</nrterase>";
		$ofertaxml.="<demisol>".($apartament->Demisol+0)."</demisol>";
		$ofertaxml.="<subsol>".($apartament->Subsol+0)."</subsol>";
		$ofertaxml.="<mansarda>".($apartament->Mansarda+0)."</mansarda>";
		$ofertaxml.="<nrfronturi>".($apartament->NumarDeschideri)."</nrfronturi>";
		$ofertaxml.="<destinatie>".dotari("Destinatie",$apartament->id)."</destinatie>";
	}
	
	if ($apartament->TipProprietate==3) {  // doar terenuri
		$ofertaxml.="<suprafatateren>{$apartament->SuprafataUtila}</suprafatateren>";
		$ofertaxml.="<frontstradal>{$apartament->Deschidere}</frontstradal>";
		$ofertaxml.="<umsuprafatateren>382</umsuprafatateren>";
		switch ($apartament->Clasificare) {
			case "intravilan":$ofertaxml.="<clasificareteren>373</clasificareteren>"; break;
			case "extravilan":$ofertaxml.="<clasificareteren>374</clasificareteren>"; break;
			default :$ofertaxml.="<clasificareteren>373</clasificareteren>"; break;
		}
		switch ($apartament->TipTeren) {
			case "constructii":$ofertaxml.="<tipteren>375</tipteren>"; break;
			case "agricol":$ofertaxml.="<tipteren>376</tipteren>"; break;
			case "padure":$ofertaxml.="<tipteren>377</tipteren>"; break;
			default:$ofertaxml.="<tipteren>375</tipteren>"; break;
			
		}
		$ofertaxml.="<nrfronturistradale>{$apartament->NumarDeschideri}</nrfronturistradale>";
		$ofertaxml.="<inclinatieteren>{$apartament->Inclinatie}</inclinatieteren>";
		$ofertaxml.="<latimedrumacces>{$apartament->LatimeDrumAcces}</latimedrumacces>";
		$ofertaxml.="<suprafataconstruita>{$apartament->SuprafataConstruita}</suprafataconstruita>";
		$ofertaxml.="<constructiepeteren>".($apartament->ConstructiePeTeren+0)."</constructiepeteren>";
	}
	
	if ($apartament->TipProprietate==4) {  // doar spatii
		$ofertaxml.="<nrincaperi>{$apartament->NumarCamere}</nrincaperi>";
		$ofertaxml.="<nrgrupurisanitare>{$apartament->NrGrupuriSanitare}</nrgrupurisanitare>";
		$ofertaxml.="<destinatierecomandata>".base64_encode(dotari("Destinatie",$apartament->id))."</destinatierecomandata>";
		switch ($apartament->ClasaBirouri){
			case "A": $ofertaxml.='<clasabirouri>554</clasabirouri>';break;
			case "B": $ofertaxml.='<clasabirouri>555</clasabirouri>';break;
			case "C": $ofertaxml.='<clasabirouri>556</clasabirouri>';break;
			default: $ofertaxml.='<clasabirouri></clasabirouri>';
		}
	}
	$ofertaxml.="<agent>{$agent->id}</agent>";
 		
	$tmp="";
	if ((are_dotarea("nou / finalizat", $apartament->id))||(are_dotarea("stare buna", $apartament->id))||(are_dotarea("necesita renovare", $apartament->id))||(are_dotarea("reabilitat termic", $apartament->id))) { 
		if ($apartament->TipProprietate<2) $tmp="127";
		if ($apartament->TipProprietate==2) $tmp="362";
		if ($apartament->TipProprietate==4) $tmp="551";
	}
	if (are_dotarea("nou / nefinalizat", $apartament->id)){
		if ($apartament->TipProprietate<2) $tmp="129";
		if ($apartament->TipProprietate==2) $tmp="364";
		if ($apartament->TipProprietate==4) $tmp="552";
	}
	if ($tmp!="") { 
		$ofertaxml.="<stadiuconstructie>{$tmp}</stadiuconstructie>";
	}
	
	$tmp="";
	if (are_dotarea("beton", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,136,368,"",432);
	if (are_dotarea("caramida", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,137,366,"",430);
	if (are_dotarea("bca", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,138,367,"",431);
	if (are_dotarea("lemn", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,139,369,"",433);
	if (are_dotarea("metal", $apartament->id)) $tmp=corespondent($apartament->TipProprietate,140,370,"",435);
	if ($tmp!="") { 
		$ofertaxml.="<structurarezistenta>{$tmp}</structurarezistenta>";
	}
		
	$ofertaxml.="<vecinatati><lang id=\"1048\">".base64_encode(dotari("Vecinatati",$apartament->id))."</lang></vecinatati>";
	$ofertaxml.="<descriere><lang id=\"1048\">".base64_encode($apartament->Detalii)."</lang></descriere>";
	$ofertaxml.="<sector>{$apartament->Sector}</sector>";
	$ofertaxml.="<alias>SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT)."</alias>";
	if ($oferta->Negociabil>0) { 
		$ofertaxml.="<pretnegociabil>1</pretnegociabil>"; 
	}
	if ($oferta->Exclusivitate>0) {
		$ofertaxml.="<exclusivitate>1</exclusivitate>";
	}
	if ($oferta->OfertaWeb>0) {
		$ofertaxml.="<linkextern>http://www.simsparkman.ro/detaliioferta.php?id={$oferta->id}</linkextern>";
	}
	// inca nu au fost reanalizate 
	
	
	// ?? nu mai e inm baza $ofertaxml.="<servicii>".dotari("Servicii???",$apartament->id)."</servicii>";
	
	//$ofertaxml.="<altedetaliizona>67,302,303</altedetaliizona>";
	
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
		$ofertaxml.="</imagini>";
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
	
	echo $ofertaxml;
	
	
	// publica oferta
	$ok=1;
	switch ($apartament->TipProprietate)
	{	
		case 0: $oftip=0; break;
		case 1: $oftip=0; break;
		case 2: $oftip=1; break;
		case 3: $oftip=3; break;
		case 4: $oftip=4; break;
		
	}
	
	try {
		$result = $s->__soapCall( 
			'publica_oferta', 
			array( 
				'publica_oferta' => array( 
					'id_str'		=> $oftip.':' . $id,
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
		
		//echo $agentxml."";
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
			$oferta->LinkImobiliare="http://www.imobiliare.ro/anunt/".$idImobiliare;
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