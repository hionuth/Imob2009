<?php
require_once(".././include/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);

require_once("sync_imobiliare_lib.php");

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

echo "<pre> sincronizare agenti ...</pre>";
posteazaAgent(1);


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
		$sinc=false;
		if ($oferta->Vanzare==1){
			$sinc=posteazaAnunt(0);
		}
		if ($oferta->Inchiriere==1){
			$sinc=posteazaAnunt(1);
		}
		if ($sinc) {
			$oferta->ExportImobiliare=($oferta->ExportImobiliare==3 ? 0 : 4);
			if ($oferta->Stare!='de actualitate') {$oferta->ExportImobiliare=0;}
		}
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