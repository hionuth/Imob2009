<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

//include_layout_template('admin_header.php');

$message="";
if (isset($_GET['id'])){
	$subzona=Subzona::find_by_id($_GET['id']);
	//$cartier=Cartier::find_by_id();
	$Denumire=$subzona->Denumire;
	$idCartier=$subzona->idCartier;
	$idPitagora=$subzona->idPitagora;
	$idImobiliare=$subzona->idImobiliare;
	$idMC=$subzona->idMC;
	$idImopedia=$subzona->idImopedia;
	$_SESSION['curentIdSubzona']=$subzona->id;
}
if (isset($_POST['submit'])) {
	$subzona=new Subzona();
	$Denumire=$_POST['Denumire'];
	$idCartier=$_POST['idCartier'];
	$idPitagora=$_POST['idPitagora'];
	$idImobiliare=$_POST['idImobiliare'];
	$idMC=$_POST['idMC'];
	$idImopedia=$_POST['idImopedia'];
	$subzona=Subzona::find_by_id($_SESSION['curentIdSubzona']);
	unset($_SESSION['curentIdSubzona']);
	$subzona->Denumire=$Denumire;
	$subzona->idCartier=$idCartier;
	$subzona->idPitagora=$idPitagora;
	$subzona->idImobiliare=$idImobiliare;
	$subzona->idMC=$idMC;
	$subzona->idImopedia=$idImopedia;
	$subzona->save();
	$message="salvat";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Verificare telefon</title>	
	<link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

	<script type="text/javascript"> 
	<!--
	
	function back(){
		document.location = ("subzona_list.php");
	}
	
	//-->
	</script>
</head>
<body>
<?php require_once(".././include/head.php");?>
<form action="subzona_update.php" method="post">
	<div class="view" align="center" >
		<h3>Modificare subzona<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr style="height:20px">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Denumire" maxlength="30" value="<?php if (isset($Denumire)) {echo htmlentities($Denumire);} ?>" /></td>
            </tr>
             <tr>
            	<td class="label">Cartier:</td>
            	<td>
            		<select name='idCartier'>
            		<?php 
            			$cartierList=Cartier::find_all();
            			foreach ($cartierList as $cartier){
            				$selected=(isset($idCartier))&&($idCartier==$cartier->id) ? " selected " : "";
            				echo "<option value='".$cartier->id."'".$selected.">".$cartier->Denumire."</option>";
            			}
            		?>
            		</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">ID Pitagora: </td>
                <td><input type="text" name="idPitagora" maxlength="30" value="<?php if (isset($idPitagora)) {echo htmlentities($idPitagora);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">ID Imobiliare: </td>
                <td><input type="text" name="idImobiliare" maxlength="30" value="<?php if (isset($idImobiliare)) {echo htmlentities($idImobiliare);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">ID Mag. Case: </td>
                <td><input type="text" name="idMC" maxlength="30" value="<?php if (isset($idMC)) {echo htmlentities($idMC);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Imopedia: </td>
                <td><input type="text" name="idImopedia" maxlength="30" value="<?php if (isset($idImopedia)) {echo htmlentities($idImopedia);} ?>" /></td>
            </tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Salveaza" />
		</div>
</form>


<?php //include_layout_template('admin_footer.php'); ?>
</body>
</html>