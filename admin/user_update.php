<?php
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
	redirect_to("user_list.php");
}
else {
	$userobj=User::find_by_id($_GET['id']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Modificare utilizator</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <script>
	    $(function() {
			$( "#date_logare" ).draggable({grid: [ 5,5 ]});
			//$( "#date_logare" ).resizable();
			$( "#date_personale" ).draggable({grid: [ 5,5 ]});
			$( "#date_contact" ).draggable({grid: [ 5,5 ]});
			$( "#foto" ).draggable({grid: [ 5,5 ]});
		});
    	$(function(){
			$("form").form();
		});
    </script>
    	
</head>
<body>
<?php 
require_once(".././include/meniu.php");
?>

<form action="user_update.php?id=<?php echo $userobj->id?>" enctype="multipart/form-data" method="post">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
<div style="">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" value="inapoi" onclick="document.location='user_list.php'"/>
		<input type="submit" name="submit" value="salveaza"/>
	</div>
	<div style="display: inline-block; float: left;">
		<fieldset id="date_logare">
			<legend>date logare</legend>
			<dl>
				<dt><span class="label">username</span><input type="text" class="standard" name="User" value="<?php echo htmlentities($userobj->User); ?>" ></input></dt>
				<dt><span class="label">parola</span><input type="password" class="standard" name="Parola" ></input></dt>
				<dt><span class="label">repetare parola</span><input type="password" class="standard" name="Parola2" ></input></dt>
				<dt>
					<span class="label">nivel acces</span>
					
					<select id="nivel" name="NivelAcces" style="width: 180px;">
						<option value="0" <?php if ($userobj->NivelAcces==1) echo "selected=\"selected\""?>>administrator</option>
						<option value="1" <?php if ($userobj->NivelAcces==1) echo "selected=\"selected\""?>>utilizator</option>
					</select>
				</dt>
			</dl>		
		</fieldset>	
		<fieldset id="date_personale">
			<legend>date personale</legend>
			<dl>
				<dt><span class="label">nume</span><input type="text" class="standard" name="Nume" value="<?php echo htmlentities($userobj->Nume); ?>"></input></dt>
				<dt><span class="label">prenume</span><input type="text" class="standard" name="Prenume" value="<?php echo htmlentities($userobj->Prenume); ?>" ></input></dt>
				<dt><span class="label">cnp</span><input type="text" class="standard" name="CNP" value="<?php echo htmlentities($userobj->CNP); ?>" ></input></dt>
				<dt><span class="label">serie C.I.</span><input type="text" class="standard" name="SerieCI" value="<?php echo htmlentities($userobj->SerieCI); ?>" ></input></dt>
				<dt><span class="label">numar C.I.</span><input type="text" class="standard" name="NumarCI" value="<?php echo htmlentities($userobj->NumarCI); ?>"></input></dt>
			</dl>
		</fieldset>
	
	</div>
	<div  style="display:inline-block;">
		<fieldset id="date_contact">
			<legend>date contact</legend>
			<dl>
				<dt><span class="label">telefon</span><input type="text" class="standard" name="Telefon" value="<?php echo htmlentities($userobj->Telefon); ?>" ></input></dt>
				<dt><span class="label">e-mail</span><input type="text" class="standard" name="Email" value="<?php echo htmlentities($userobj->Email); ?>"></input></dt>
				<dt><span class="label">adresa</span><input type="text" class="standard" name="Adresa1" value="<?php echo htmlentities($userobj->Adresa1); ?>"></input></dt>
				<dt><span class="label"></span><input type="text" class="standard" name="Adresa2" value="<?php echo htmlentities($userobj->Adresa2); ?>"></input></dt>
				<dt><span class="label">oras</span><input type="text" class="standard" name="Oras" value="<?php echo htmlentities($userobj->Oras); ?>"></input></dt>
				<dt><span class="label">judet</span><input type="text" class="standard" name="Judet" value="<?php echo htmlentities($userobj->Judet); ?>"></input></dt>
				<dt><span class="label">tara</span><input type="text" class="standard" name="Tara" value="<?php echo htmlentities($userobj->Tara); ?>"></input></dt>
			</dl>
		</fieldset>
		<fieldset id="foto">
			<legend>foto</legend>
			<?php
			 if ($userobj->Poza!="") {
			?>
			 	<img src="..<?php echo DS.$userobj->image_path();?>"></img>
			 <?php 
			 }
			 ?>
			<dl>
				
				<dt><input type="file" style="width: 288px;" name="Imagine"></input></dt>
			</dl>
		</fieldset>
	</div>
</div>
</form>
</body>
</html>