<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$title="Oferta - Cautare";
if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}	
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Cautare oferte</title>
	<link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<script type="text/javascript" src=".././javascripts/jquery-1.3.2.js"></script>
	<script type="text/javascript" src=".././javascripts/thickbox.js"></script>
	<script type="text/javascript" src=".././javascripts/stradahint.js"></script>
	<script type="text/javascript" src=".././javascripts/oferte.js"></script>
</head>
<body>
<?php 
require_once(".././include/head.php");
?>
<div id="Filtre">
	<?php 
		$curentPage="oferta_search.php";
		require_once("oferta_search_engine.php");
	?>
</div>
</body>
</html>
