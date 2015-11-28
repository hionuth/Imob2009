<?php
require_once(".././include/initialize.php");
if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);

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

$sql="SELECT * FROM Oferta WHERE ExportImopedia>0 AND ExportImopedia<4";
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
		
		$apartament	= Apartament::find_by_id($oferta->idApartament);
		$subzona	= Subzona::find_by_id($apartament->idSubzona);
		$cartier	= Cartier::find_by_id($subzona->idCartier);
		$oras		= Zona::find_by_id($cartier->idZona);
		
		$imopedia = new Imopedia($apartament, $oferta, $subzona, $cartier, $oras);
		
		if (( $oferta->ExportImopedia < 3 ) && ( $oferta->Stare == 'de actualitate' )) {
			$imopedia->syncronize();
			echo " - sincronizat<br />";
		}
		else {
			$imopedia->deleteOferta();
			echo " - sters<br />";
		}
		$oferta->ExportImopedia = ( $oferta->ExportImopedia==3 ? 0 : 4 );
		if ( $oferta->Stare != 'de actualitate' ) {
			$oferta->ExportImopedia = 0;
		}
		
		$oferta->save();
	}
}
?>
		
		