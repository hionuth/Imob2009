<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
} 

function pune_camp($label,$varname,$size=180) {
	global ${$varname};
	//$item="<tr><td class='label'>".$label.":</td>";
	$item="<td><input type='text' style='width:{$size}px;' name='".$varname."' value='".htmlentities(${$varname})."'></input>";
	return $item;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Crearea utilizator</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" /> 
    <?php require_once(".././include/jquery.php");?>
    <style>
    	fieldset { 
    		width: 300px; 
    		margin-top: 5px;
    	}
    	legend {
    		margin: 3px;
    		padding: 3px;
    		
    		//text-align: center;
    	}
    	span{
    		display: inline-block; width: 100px;
    		//text-align: right;
    		padding-right: 5px;
    	}
    	input{
    		width: 180px;
    	}
		.toggler { width: 500px; height: 200px; position: relative; }
		#button { padding: .5em 1em; text-decoration: none; }
		#effect { width: 240px; height: 135px; padding: 0.4em; position: relative; }
		#effect h3 { margin: 0; padding: 0.4em; text-align: center; }
		.ui-effects-transfer { border: 2px dotted gray; } 
	</style>
	<script>
				
		$(function(){
			$("form").form();
			});
			
	</script>
</head>

<body>



<?php 
	require_once(".././include/meniu.php");

?>

<form action="user_new2.php" method="post">

	<fieldset>
		<legend>date logare</legend>
		<dl>
			<dt><span>username</span><input type="text" name="User" ></input></dt>
			<dt><span>parola</span><input type="password" name="Parola" ></input></dt>
			<dt><span>repetare parola</span><input type="password" name="Parola" ></input></dt>
		</dl>		
	</fieldset>	
	<fieldset>
		<legend>date personale</legend>
		<dl>
			<dt><span>nume</span><input type="text" name="Nume" ></input></dt>
			<dt><span>prenume</span><input type="text" name="Prenume" ></input></dt>
			<dt><span>cnp</span><input type="text" name="" ></input></dt>
			<dt><span>:</span><input type="text" name="" ></input></dt>
			<dt><span>:</span><input type="text" name="" ></input></dt>
			<dt><span>:</span><input type="text" name="" ></input></dt>
			<dt><span>:</span><input type="text" name="" ></input></dt>
		</dl>
	</fieldset>


	
</form>
</body>
</html>