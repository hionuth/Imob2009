<?php
//ini_set('display_errors', 1);

require_once(".././include/initialize.php");
$message="";

if ($session->is_logged_in()) {
	redirect_to("index.php");
}

if (isset($_POST['submit'])) {
	$username=trim($_POST['username']);
	$password=trim($_POST['password']);
	
	// verifica utilizatorul 
	
	$found_user = User::authenticate($username,$password); 
	
	if ($found_user) {
		$session->login($found_user);
		redirect_to("index.php");
	}
	else {
		$message="Utilizator sau parola incorecte. ";
	}
}
else {
	$username="";
	$password="";
}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <style>
    	

	</style>
	<script type="text/javascript">
	
	$(function() {
		//$( "#date_logare" ).draggable({grid: [ 5,5 ]});
		//$( "#date_logare" ).resizable();
		//$( "#date_personale" ).draggable({grid: [ 5,5 ]});
		//$( "#date_contact" ).draggable({grid: [ 5,5 ]});
		//$( "#foto" ).draggable({grid: [ 5,5 ]});
	});
					
		$(function(){
			$("form").form();
			});
		$(document).ready(function(){
		    $("#formlogare").validate({
		    	  rules: {
		    		    username: "required",
			    		password: "required"
		    		  }
		    		});
		  });
	
	</script>
</head>

<body>

<form action="login.php" id="formlogare" method="post">

	<h2 style="height: 18px;margin-bottom: 7px;"></h2>

	<div id="header" style="margin-left:20px;margin-right:20px; inline-block; float: left;">
    	<h1><img src=".././images/sims.png" alt="Sims Parkman" /></h1>
    </div> 

	<div id="login" style="display: inline-block; float: left;">
		<fieldset id="date_logare">
			<legend>autentificare in aplicatie</legend>
			<dl>
				<dt><span class="label">utilizator</span><input type="text" id="username" name="username" value="<?php echo htmlentities($username); ?>"  ></input></dt>
				<dt><span class="label">parola</span><input type="password" id="password" name="password" value="<?php echo htmlentities($password); ?>"></input></dt>
				<dt><span class="label"> </span><input type="submit" name="submit" value="autentificare" /></dt>
			</dl>
		</fieldset>
	</div>
</form>
</body>
</html>
<?php if (isset($database)) { $database->close_connection(); } ?>