<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

include_layout_template('admin_header.php');
?>
<script type="text/javascript"> 
<!--

function back(){
	document.location = ("cartier_list.php");
}

//-->
</script>
<?php 
$message="";
if (isset($_GET['id'])){
	$cartier=Cartier::find_by_id($_GET['id']);
	//$zona=Zona::find_by_id();
	$Denumire=$cartier->Denumire;
	$idZona=$cartier->idZona;
	$_SESSION['curentIdCartier']=$cartier->id;
}
if (isset($_POST['submit'])) {
	$cartier=new Cartier();
	$Denumire=$_POST['Denumire'];
	$idZona=$_POST['idZona'];
	$cartier=Cartier::find_by_id($_SESSION['curentIdCartier']);
	unset($_SESSION['curentIdCartier']);
	$cartier->Denumire=$Denumire;
	$cartier->idZona=$idZona;
	$cartier->Dezactivat=$_POST['Dezactivat'];
	$cartier->save();
	$message="salvat";
}

?>

<form action="cartier_update.php" method="post">
	<div class="view" align="center" >
		<h3>Modificare cartier<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Denumire" maxlength="30" value="<?php if (isset($Denumire)) {echo htmlentities($Denumire);} ?>" /></td>
            </tr>
             <tr>
            	<td class="label">Zona:</td>
            	<td>
            		<select name='idZona'>
            		<?php 
            			$zonaList=Zona::find_all();
            			foreach ($zonaList as $zona){
            				$selected=(isset($idZona))&&($idZona==$zona->id) ? " selected " : "";
            				echo "<option value='".$zona->id."'".$selected.">".$zona->Denumire."</option>";
            			}
            		?>
            		</select>
            	</td>
            </tr>
            <tr>
            	<td class="label">Dezactivat: </td>
                <td><input type="checkbox" name="Dezactivat" value="1"<?php if ($cartier->Dezactivat==1) {echo "checked=\"checked\"";} ?> /></td>
            </tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Salveaza" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>