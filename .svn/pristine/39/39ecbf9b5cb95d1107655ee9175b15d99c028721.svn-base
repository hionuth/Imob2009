<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
	$userobj=User::find_by_id($_GET['id']);
	$userobj->delete();
	redirect_to("user_list.php");
?>