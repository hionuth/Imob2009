<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare</title>
    <link rel="stylesheet" type="text/css" href=".././styles/main.css" />
</head>
<body>
<?php 
//$title="Acasa";
require_once(".././include/meniu.php");
?>
	<div id="header" style="margin-left:20px;margin-right:20px; inline-block; float: left;">
    	<h1><img src=".././images/sims.png" alt="Sims Parkman" /></h1>
    </div> 
</body>   
</html>
