<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";
if (isset($_POST['submit'])) {
	$dotare=new Categoriedotari();
	$Descriere=$_POST['Descriere'];
	$TipProprietate=$_POST['TipProprietate'];
	$TipControl=$_POST['TipControl'];
	$Prioritate=$_POST['Prioritate'];
	if (isset($_POST['Privat'])) {$Privat=$_POST['Privat'];}
	else {$Privat=0;}
	$sql="SELECT * FROM CategorieDotari WHERE Descriere='{$Descriere}' AND TipProprietate='{$TipProprietate}'";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)) { $message="Categoria deja exista in baza de date"; }
	else {
		$dotare->Descriere=$Descriere;
		$dotare->TipProprietate=$TipProprietate;
		$dotare->TipControl=$TipControl;
		$dotare->Prioritate=$Prioritate;
		$dotare->Privat=$Privat;
		$categorie->Proprietati="";
		if (isset($_POST['xa'])) {
			$xa=1;
			$dotare->Proprietati=$dotare->Proprietati."xa";
		}
		if (isset($_POST['xb'])) {
			$xb=1;
			$dotare->Proprietati=$dotare->Proprietati."xb";
		}
		if (isset($_POST['xc'])) {
			$xc=1;
			$dotare->Proprietati=$dotare->Proprietati."xc";
		}
		if (isset($_POST['xt'])) {
			$xt=1;
			$dotare->Proprietati=$dotare->Proprietati."xt";
		}
		if (isset($_POST['xs'])) {
			$xs=1;
			$dotare->Proprietati=$dotare->Proprietati."xs";
		}
		$dotare->save();
		$message="Adaugat";
		//print_r($_POST);
		redirect_to("categoriedotare_list.php");
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Categorii dotari</title>
	
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
	<form action="categoriedotare_new.php" method="post">
	<div class="view" align="left" >
		<h3>Adaugare categorie dotari<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr>
    			<td>
    			</td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Descriere" maxlength="100" value="<?php if (isset($Descriere)) {echo htmlentities($Descriere);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Tip proprietate: </td>
            	<td>
            		<select name="TipProprietate">
						<option value='1' selected='selected'>Apartament</option>
						<option value='2'>Apartament in vila</option>
						<option value='3'>Casa</option>
						<option value='4'>Teren</option>
						<option value='5'>Spatiu comercial</option>
					</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">Tip control: </td>
            	<td>
            		<select name="TipControl">
					<option value='1' selected='selected'>Check box</option>
					<option value='2'>Combo box</option>
				</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">Prioritate: </td>
            	<td>
            		<input type="text" name="Prioritate" size="2" value="<?php if (isset($Prioritate)) {echo htmlentities($Prioritate);} ?>" />
            	</td>
            </tr>
            <tr>
            	<td class="label">Privat: </td>
            	<td><input type="checkbox" name="Privat" value="1"></input></td>
          	</tr>
          	<tr>
            	<td >Aplicabil la: </td>
            	<td></td>
          	</tr>
          	<tr>
            	<td class="label">Apartamente: </td>
            	<td><input type="checkbox" name="xa" value="1" ></input></td>
          	</tr>
          	<tr>
            	<td class="label">Ap in vila: </td>
            	<td><input type="checkbox" name="xb" value="1" ></input></td>
          	</tr>
          	<tr>
            	<td class="label">Case: </td>
            	<td><input type="checkbox" name="xc" value="1" ></input></td>
          	</tr>
          	<tr>
            	<td class="label">Terenuri: </td>
            	<td><input type="checkbox" name="xt" value="1" ></input></td>
          	</tr>
          	<tr>
            	<td class="label">Spatii: </td>
            	<td><input type="checkbox" name="xs" value="1" ></input></td>
          	</tr>
		</table>
	</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Adauga" />
		</div>
	</form>
		
</body>
</html>