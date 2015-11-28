<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);

$oferta = new Oferta();

$oferta 	= Oferta::find_by_id(1706);
$apartament	= Apartament::find_by_id($oferta->idApartament);
$subzona	= Subzona::find_by_id($apartament->idSubzona);
$cartier	= Cartier::find_by_id($subzona->idCartier);
$oras		= Zona::find_by_id($cartier->idZona);

$imopedia = new Imopedia($apartament, $oferta, $subzona, $cartier, $oras);
//$imopedia->syncronize();
$imopedia->deleteOferta();
//
?>