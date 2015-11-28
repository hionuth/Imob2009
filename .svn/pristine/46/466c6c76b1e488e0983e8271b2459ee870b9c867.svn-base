<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";
$xa="";
$xb="";
$xc="";
$xt="";
$xs="";

if (isset($_GET['id'])){
	$categorie=Categoriedotari::find_by_id($_GET['id']);
	if (strpos($categorie->Proprietati,"xa")!==false) {
		$xa=1;
	}
	if (strpos($categorie->Proprietati,"xb")!==false) {
		$xb=1;
	}
	if (strpos($categorie->Proprietati,"xc")!==false) {
		$xc=1;
	}
	if (strpos($categorie->Proprietati,"xt")!==false) {
		$xt=1;
	}
	if (strpos($categorie->Proprietati,"xs")!==false) {
		$xs=1;
	}
}

if (isset($_POST['submit'])) {
	$categorie=Categoriedotari::find_by_id($_POST['id']);
	$categorie->Descriere=$_POST['Descriere'];
	$categorie->TipProprietate=$_POST['TipProprietate'];
	$categorie->TipControl=$_POST['TipControl'];
	$categorie->Prioritate=$_POST['Prioritate'];
	if (isset($_POST['Privat'])) {$categorie->Privat=$_POST['Privat'];}
	else {$categorie->Privat=0;}	
	$categorie->Proprietati="";
	if (isset($_POST['xa'])) {
		$xa=1;
		$categorie->Proprietati=$categorie->Proprietati."xa";
	}
	if (isset($_POST['xb'])) {
		$xb=1;
		$categorie->Proprietati=$categorie->Proprietati."xb";
	}
	if (isset($_POST['xc'])) {
		$xc=1;
		$categorie->Proprietati=$categorie->Proprietati."xc";
	}
	if (isset($_POST['xt'])) {
		$xt=1;
		$categorie->Proprietati=$categorie->Proprietati."xt";
	}
	if (isset($_POST['xs'])) {
		$xs=1;
		$categorie->Proprietati=$categorie->Proprietati."xs";
	}
	
	$categorie->save();
	redirect_to("categoriedotare_list.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Modificare categorie dotari</title>
	
	<link type="text/css" href=".././themes/base/ui.all.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	
	<script type="text/javascript"> 
	function back(){
		document.location = ("categoriedotare_list.php");
	}
	</script>
	
	
</head>
<body>
	<?php 
	//$title="Dotari";
	require_once(".././include/head.php");
	?>
	<form action="categoriedotare_update.php" method="post">
	<div class="view" align="left" >
		<h3>Modificare categorie dotari<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr>
    			<td>
    				<input type="hidden" name="id" value="<?php echo $categorie->id;?>"></input>
    			</td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Descriere" maxlength="30" value="<?php echo htmlentities($categorie->Descriere); ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Tip proprietate: </td>
            	<td>
            		<select name="TipProprietate">
						<option value='1' <?php if ($categorie->TipProprietate==1){echo "selected=\"selected\"";}?>>Apartament</option>
						<option value='2' <?php if ($categorie->TipProprietate==2){echo "selected=\"selected\"";}?>>Apartament in vila</option>
						<option value='3' <?php if ($categorie->TipProprietate==3){echo "selected=\"selected\"";}?>>Casa</option>
						<option value='4' <?php if ($categorie->TipProprietate==4){echo "selected=\"selected\"";}?>>Teren</option>
					</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">Tip control: </td>
            	<td>
            		<select name="TipControl">
					<option value='1' <?php if ($categorie->TipControl==1){echo "selected=\"selected\"";}?>>Check box</option>
					<option value='2' <?php if ($categorie->TipControl==2){echo "selected=\"selected\"";}?>>Combo box</option>
				</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">Prioritate: </td>
            	<td>
            		<input type="text" name="Prioritate" size="2" value="<?php echo htmlentities($categorie->Prioritate); ?>" />
            	</td>
            </tr>
            <tr>
            	<td class="label">Privat: </td>
            	<td><input type="checkbox" name="Privat" value="1" <?php if ($categorie->Privat==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td>Aplicabil la: </td>
            	<td></td>
          	</tr>
          	<tr>
            	<td class="label">Apartamente: </td>
            	<td><input type="checkbox" name="xa" value="1" <?php if ($xa==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Ap in vila: </td>
            	<td><input type="checkbox" name="xb" value="1" <?php if ($xb==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Case: </td>
            	<td><input type="checkbox" name="xc" value="1" <?php if ($xc==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Terenuri: </td>
            	<td><input type="checkbox" name="xt" value="1" <?php if ($xt==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Spatii: </td>
            	<td><input type="checkbox" name="xs" value="1" <?php if ($xs==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
		</table>
	</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Salveaza" />
		</div>
	</form>
		
</body>
</html>