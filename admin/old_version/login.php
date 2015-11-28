<?php

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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<title>Sims Parkman</title>
</head>

<body>
	<div id="header">
		<h2></h2>
    	<h1><img src=".././images/sims.png" alt="Sims Parkman" /></h1>
    </div> 
    
    <div id="main">
    	<h3>Logare useri</h3>
    
    <?php echo output_message($message); ?>
	
    <form action="login.php" method="post">
    	<table align="center">
        	<tr>
            	<td>Utilizator:</td>
                <td>
                	<input type="text" name="username" maxlength="30" value="<?php echo htmlentities($username); ?>" />
                </td>
            </tr>
            <tr>
            	<td>Parola:</td>
                <td>
                	<input type="password" name="password" maxlength="30" value="<?php echo htmlentities($password); ?>" />
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                	<input type="submit" name="submit" value="Login" />
                </td>
            </tr>    
        </table>
    </form>
    </div>
    <div id="footer">Copyright <?php echo date("Y",time()); ?>, Ionut Hrinca
    </div>
    
</body>
</html>
<?php if (isset($database)) { $database->close_connection(); } ?>
