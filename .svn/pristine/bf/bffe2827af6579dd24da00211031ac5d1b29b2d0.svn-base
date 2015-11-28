<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$CatDot=Categoriedotari::find_by_id($_GET['id']);
$CatDot->delete();
redirect_to("categoriedotare_list.php");
?>