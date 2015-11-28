<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$message="";
if (isset($_POST['submit'])) {
	$subzona=new Subzona();
	$Denumire=$_POST['Denumire'];
	$idCartier=$_POST['idCartier'];
	$sql="SELECT * FROM Subzona WHERE Denumire='{$Denumire}'";
	$subzonaList=Subzona::find_by_sql($sql);
	if (!empty($subzonaList)) { $message="Subzona deja exista in baza de date"; }
	else {
		$subzona->Denumire=$Denumire;
		$subzona->idCartier=$idCartier;
		$subzona->save();
		$message="Adaugat";
		redirect_to("subzona_list.php");
	}
}

include_layout_template('admin_header.php');
?>
<script type="text/javascript"> 
<!--

function back(){
	document.location = ("subzona_list.php");
}

//-->
</script>
<?php 


?>

<form action="subzona_new.php" method="post">
	<div class="view" align="center" >
		<h3>Adaugare subzona<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire:</td>
                <td><input type="text" name="Denumire" maxlength="30" value="<?php if (isset($Denumire)) {echo htmlentities($Denumire);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Cartier:</td>
            	<td>
            		<select name='idCartier'>
            			<option value="">alegeti ...</option>
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
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Adauga" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>