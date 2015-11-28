<?php
ini_set('display_errors', 1);
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";		
if (isset($_POST['submit'])) {
	$userobj=User::find_by_id($_GET['id']);
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			if (($variable!="Parola")){ //||(($variable=="Parola")&&($_POST[$variable]!=""))) {
				${$variable}=$_POST[$variable];
				$userobj->{$variable}=trim(${$variable});
			}
		}	
	}
	
	$pass=$_POST['Parola'];
	if ($pass!=""){
		$Parola="";
		$userobj->Parola=md5($pass);
	}
	
	foreach($_FILES as $key=>$file){
		if ($file['error']!=4){
			$userobj->ataseaza_poza($file);
		}
	}
	$userobj->save();
	unset($_SESSION['current_user_id']);
	$message=" - Datele utilizatoruli cu ID: ".$userobj->id." au fost modificate.";
}
else {
	$userobj=User::find_by_id($_GET['id']);
	$User=$userobj->User;
	$Parola="";
	$Nume=$userobj->Nume;
	$Prenume=$userobj->Prenume;
	$CNP=$userobj->CNP;
	$SerieCI=$userobj->SerieCI;
	$NumarCI=$userobj->NumarCI;
	$NivelAcces=$userobj->NivelAcces;
	$Adresa1=$userobj->Adresa1;
	$Adresa2=$userobj->Adresa2;
	$Oras=$userobj->Oras;
	$Judet=$userobj->Judet;
	$Tara=$userobj->Tara;
	$Telefon=$userobj->Telefon;
	$Email=$userobj->Email;
	$_SESSION['current_user_id']=$_GET['id'];
}
?> 


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Modificare utilizator</title>
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

	<script type="text/javascript"> 
	<!--
	function onClick_close(){
		window.close();
	}
	function back(){
		document.location = ("user_list.php");
	}
	//-->
	</script>

</head>
<body>
<?php 
require_once(".././include/head.php");
?>

<?php //include_layout_template('admin_header.php'); ?>
<h3>Utilizator - modificare</h3>

<form action="user_update.php?id=<?php echo $userobj->id?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
	<div class="view">
	<h3>Date utilizator<?php echo $message;?></h3>
	    <table>
	    	<?php 
	    		echo put_text_item("Utilizator","User",0);?>
	    		<tr> 
	            	<td class="label">Parola</td>
	                <td><input type="password" name="Parola" maxlength="30" value="<?php echo htmlentities(isset($Parola) ? $Parola : ""); ?>" /></td>
	            </tr>
	    	<?php 
	    		echo put_text_item("Nume","Nume",0);
	    		echo put_text_item("Prenume","Prenume",0);
	    		echo put_text_item("Telefon","Telefon");
	    		echo put_text_item("Email","Email");
	    		echo put_text_item("CNP","CNP",0);
	    		echo put_text_item("CI Seria","SerieCI",2);
	    		echo put_text_item("CI Numar","NumarCI",6);
	    		echo put_text_item("Nivel acces ","NivelAcces",1);
	    	?>
	            <tr> 
	            	<td class="label">Adresa</td>
	                <td><input type="text" name="Adresa1" maxlength="30" value="<?php echo htmlentities(isset($Adresa1) ? $Adresa1 : ""); ?>" /></td>
	            </tr>
	            <tr> 
	            	<td class="label"></td>
	                <td><input type="text" name="Adresa2" maxlength="30" value="<?php echo htmlentities(isset($Adresa2) ? $Adresa2 : ""); ?>" /></td>
	            </tr>
	       	<?php
				echo put_text_item("Oras","Oras",0);
				echo put_text_item("Judet","Judet",0);
				echo put_text_item("Tara","Tara",0);
	       	?>   
				<tr>
					<td class="label">Foto</td>
					<td>
						<?php
						 if ($userobj->Poza!="") {
						?>
						 	<img src="..<?php echo DS.$userobj->image_path();?>"></img>
						 <?php 
						 }
						 ?>
					<input type="file" name="Imagine"></input></td>
				</tr>       	  
		</table>
	</div>
	<div id="butoane" class="butoane">
		<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
		<input type="submit" name="submit" value="Modifica" <?php if (isset($_POST['submit'])) {echo " disabled";} ?> />
	</div>
</form>
</body>
</html>