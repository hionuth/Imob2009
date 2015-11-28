<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${
				$variable}=$_POST[$variable];
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Cautare oferte</title>
    <link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src=".././javascripts/thickbox.js"></script>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
    <script type="text/javascript" src=".././javascripts/oferte.js"></script>
    <script>
		function onClickB(operation,id){
			if (operation==1) document.location=("client_update.php?id=" + id);
			if (operation==2) window.open("oferta_new.php?id=" + id);
			if (operation==3) window.open("cerere_new.php?id=" + id);
			if (operation==4) document.location = ("check_client.php?telefon=" + id);
		}
		$(function(){
			hide("divStradaHint");
			hide("filtreExtra");
			$("form").form();
		});
	</script>
</head>
<body>
<?php require_once(".././include/meniu.php");?>
<div id="Filtre">
	<?php 
		$curentPage="oferta_search.php";
		require_once("oferta_search_engine.php");
	?>
</div>
</body>
</html>
