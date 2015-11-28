<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}


$message="";
if (isset($_GET['idCateg'])){
	$idCategorieDotari=$_GET['idCateg'];
}
if (isset($_POST['submit'])) {
	$dotare=new Dotare();
	$Descriere=$_POST['Descriere'];
	$idCategorieDotari=$_POST['idCategorieDotari'];
	$sql="SELECT * FROM Dotare WHERE Descriere='{$Descriere}' AND idCategorieDotari='{$idCategorieDotari}'";
	$dotareList=Dotare::find_by_sql($sql);
	if (!empty($dotareList)) { $message="Dotare deja exista in baza de date"; }
	else {
		$dotare->Descriere=$Descriere;
		$dotare->idCategorieDotari=$idCategorieDotari;
		$dotare->save();
		$message="Adaugat";
		redirect_to("categoriedotare_list.php");
	}
}


include_layout_template('admin_header.php');
?>
<script type="text/javascript"> 
<!--

function back(){
	document.location = ("categoriedotare_list.php");
}

//-->
</script>


<form action="dotare_new.php" method="post">
	<div class="view" align="center" >
		<h3>Adaugare dotare<?php if ($message!="") {echo " - ".$message;}?></h3>
		<input type='hidden' name='idCategorieDotari' value="<?php echo htmlentities($idCategorieDotari);?>" />
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Descriere" maxlength="30" value="<?php if (isset($Descriere)) {echo htmlentities($Descriere);} ?>" /></td>
            </tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Adauga" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>