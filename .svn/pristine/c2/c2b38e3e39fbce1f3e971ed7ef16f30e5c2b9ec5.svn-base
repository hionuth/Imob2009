<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) { 
	redirect_to("login.php");
}
if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}	
	}
}


//include_layout_template('admin_header.php');
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Cautare cereri</title>
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<script type="text/javascript" src=".././javascripts/cereri.js"></script>
</head>
<body>
<?php 
require_once(".././include/head.php");
?>
<div id="Filtre">
	<?php 
		$curentPage="cerere_search.php";
		require_once("cerere_search_engine.php");
	?>
</div>
</body>
</html>