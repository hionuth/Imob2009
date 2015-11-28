<?php
require_once(".././include/initialize.php");
ini_set('display_errors', 1);

if (!$session->is_logged_in()) {
	redirect_to("login.php");
} 

function pune_camp($label,$varname,$size=180) {
	global ${$varname};
	//$item="<tr><td class='label'>".$label.":</td>";
	$item="<td><input type='text' style='width:{$size}px;' name='".$varname."' value='".htmlentities(${$varname})."'></input>";
	return $item;
}

if (isset($_POST['submit'])) {
	$userobj=new User();
	
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
			$userobj->{$variable}=trim(${$variable});
		}	
	}
	if ($userobj->Parola!=""){
		$Parola="";
		$userobj->Parola=md5($userobj->Parola);
	}
	else {unset($userobj->Parola);}
	
	foreach($_FILES as $key=>$file){
		if ($file['error']!=4){
			$userobj->ataseaza_poza($file);
		}
	}
	
	$userobj->save();
	//$_SESSION['current_user_id']=$userobj->id;
	redirect_to("user_list.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Crearea utilizator</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <style>
    	

	</style>
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
<form action="user_new.php" enctype="multipart/form-data" method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
<div style="">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" value="inapoi" onclick="document.location='user_list.php'"/>
		<input type="submit" name="submit" value="creaza cont"/>
	</div>

	<div style="display: inline-block; float: left;">
	<fieldset id="date_logare">
		<legend>date logare</legend>
		<dl>
			<dt><label class="label">username</label><input type="text" name="User" class="standard"></input></dt>
			<dt><span class="label">parola</span><input type="password" name="Parola" class="standard"></input></dt>
			<dt><span class="label">repetare parola</span><input type="password" name="Parola2" class="standard"></input></dt>
			<dt>
				<span class="label">nivel acces</span>
				
				<select id="nivel" style="width: 180px;">
					<option value="0">administrator</option>
					<option value="1">utilizator</option>
				</select>
			</dt>
		</dl>		
	</fieldset>	
	
	<fieldset id="date_personale">
		<legend>date personale</legend>
		<dl>
			<dt><span class="label">nume</span><input type="text" name="Nume" class="standard"></input></dt>
			<dt><span class="label">prenume</span><input type="text" name="Prenume" class="standard"></input></dt>
			<dt><span class="label">cnp</span><input type="text" name="CNP" class="standard"></input></dt>
			<dt><span class="label">serie C.I.</span><input type="text" name="SerieCI" class="standard" ></input></dt>
			<dt><span class="label">numar C.I.</span><input type="text" name="NumarCI" class="standard"></input></dt>
		</dl>
	</fieldset>
	
	</div>
	<div  style="display:inline-block;">
	<fieldset id="date_contact">
		<legend>date contact</legend>
		<dl>
			<dt><span class="label">telefon</span><input type="text" class="standard" name="Telefon" ></input></dt>
			<dt><span class="label">e-mail</span><input type="text" class="standard" name="Email" ></input></dt>
			<dt><span class="label">adresa</span><input type="text" class="standard" name="Adresa1" ></input></dt>
			<dt><span class="label"></span><input type="text" class="standard" name="Adresa2" ></input></dt>
			<dt><span class="label">oras</span><input type="text" class="standard" name="Oras" ></input></dt>
			<dt><span class="label">judet</span><input type="text" class="standard" name="Judet" ></input></dt>
			<dt><span class="label">tara</span><input type="text" class="standard" name="Tara" ></input></dt>
		</dl>
	</fieldset>
	<fieldset id="foto">
		<legend>foto</legend>
		<dl>
			<dt><input type="file" style="width: 288px;" name="Imagine"></input></dt>
		</dl>
	</fieldset>
	</div>
</div>
</form>
</body>
</html>