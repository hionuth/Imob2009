<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
//echo "Sterg foto ".$_GET['id'];
$foto=Foto::find_by_id($_GET['id']);
$idOferte=$_GET['of'];
$apid=$foto->idApartament;
$done=$foto->destroy();
redirect_to("foto_update2.php?id=".$apid."&idOferta=".$idOferte);
?>