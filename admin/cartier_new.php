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
if (isset($_POST['submit'])) {
	$cartier=new Cartier();
	$Denumire=$_POST['Denumire'];
	$idZona=$_POST['idZona'];
	$sql="SELECT * FROM Cartier WHERE Denumire='{$Denumire}'";
	$cartierList=Cartier::find_by_sql($sql);
	if (!empty($cartierList)) { $message="Cartier deja exista in baza de date"; }
	else {
		$cartier->Denumire=$Denumire;
		$cartier->idZona=$idZona;
		$cartier->save();
		$message="Adaugat";
	}
}

?>

<form action="cartier_new.php" method="post">
	<div class="view" align="center" >
		<h3>Adaugare cartier<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire:</td>
                <td><input type="text" name="Denumire" maxlength="30" value="<?php if (isset($Denumire)) {echo htmlentities($Denumire);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Zona:</td>
            	<td>
            		<select name='idZona'>
            			<option value="">alegeti ...</option>
            		<?php 
            			$cartierList=Zona::find_all();
            			foreach ($cartierList as $cartier){
            				$selected=(isset($idZona))&&($idZona==$cartier->id) ? " selected " : "";
            				echo "<option value='".$cartier->id."'".$selected.">".$cartier->Denumire."</option>";
            			}
            		?>
            		</select>
            	</td>
            </tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Adauga" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>