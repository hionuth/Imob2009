<?php
/**
 * Cod PHP functional pentru demonstrarea functionalitatii API imobiliare.ro
 * ------------------------------------------------------------------
 * 
 * ACEST COD ESTE PUS LA DISPOZITIE CU TITLU DEMONSTRATIV, SI NU ESTE
 * SUB NICI O FORMA INDICAT SA FIE UTILIZAT IN PRODUCTIE.
 * 
 * REALMEDIA NETWORK NU ISI ASUMA NICI O VINA PENTRU EVENTUALELE PAGUBE
 * PRODUSE DE ACEST SCRIPT.
 *
 */

require_once(".././include/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

function posteazaAnunt($inchiriere=0){
	
	global $oferta;
	global $apartament;
	global $client;
	global $agent;
	global $subzona;
	global $fotografii;
	
	$id=$oferta->id;
	if ($inchiriere) { $id+=90000;}
	
	$ofertaxml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
	<oferta tip="apartament" versiune="2">
	<id2>'. $id . '</id2>
	<adresa>'. '' .'</adresa>
	<longitudine>'.$apartament->Lng.'</longitudine>
	<latitudine>'.$apartament->Lat.'</latitudine>
	<altitudine>200</altitudine>
	
	
	</oferta>';
	
	$s = new SoapClient( API_URI ); 
	
	// login
	echo "Login<br/>";
	try {
		$result = $s->__soapCall( 
			'login', 
			array( 
				'login' => array( 
					'id' 	=> 'X36V',//API_USER, 
					'hid' 	=> '89cn23489fn32r',//API_KEY,
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
	echo '<pre>LOGIN: ' . print_r( $result, true ) . '</pre>';
	
	// publica oferta
	echo "Publica<br/>";
	if (($oferta->ExportImobiliare<3)&&($oferta->Stare=='de actualitate')) {
		if ($oferta->ExportImobiliare=1) {$operatie="MOD";}
		else { $operatie="ADD";}
	}
	else { $operatie="DEL";}
	try {
		$result = $s->__soapCall( 
			'publica_oferta', 
			array( 
				'publica_oferta' => array( 
					'id_str'		=> '0:' . $id2random,
					'sid' 			=> $session_id, 
					'operatie'		=> $operatie,
					'ofertaxml' 	=> $ofertaxml,
				) 	
			) 
		); 
	} catch( Exception $e ) {
		die( 'Eroare Publicare oferta: ' . $e->getMessage() );
	}
	echo '<pre>PUBLICARE OFERTA: ' . print_r( $result, true ) . '</pre>';

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
}



echo "Sincronizare in curs ...<br/>";

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
		$apartament=Apartament::find_by_id($oferta->idApartament);
		$client=Client::find_by_id($apartament->idClient);
		$agent=User::find_by_id($client->idUtilizator);
		$subzona=Subzona::find_by_id($apartament->idSubzona);
		$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin";
		$fotografii=Foto::find_by_sql($sql);
		if ($oferta->Vanzare==1){
			posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			posteazaAnunt(1);
		}
		$oferta->ExportImobiliare=($oferta->ExportImobiliare===3 ? 0 : 4);
		if ($oferta->Stare!='de actualitate') {$oferta->ExportImobiliare=0;}
		$oferta->save();
	}
}
echo "<br/>Sincronizare terminata.";
//require_once(".././include/head.php");
//redirect_to($currentPage)
?>