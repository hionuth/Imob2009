<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
//echo "Sterg foto ".$_GET['id'];
$doc=Document::find_by_id($_GET['id']);
$idOferte=$_GET['of'];
$apid=$doc->idApartament;
$done=$doc->destroy();
redirect_to("doc_update.php?id=".$apid."&idOferta=".$idOferte);
?>