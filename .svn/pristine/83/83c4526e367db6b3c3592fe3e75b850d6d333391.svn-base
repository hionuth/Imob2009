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
	document.location = ("zona_list.php");
}

//-->
</script>
<?php 
$message="";
if (isset($_POST['submit'])) {
	$zona=new Zona();
	$Denumire=$_POST['Denumire'];
	$sql="SELECT * FROM Zona WHERE Denumire='{$Denumire}'";
	$zonaList=Zona::find_by_sql($sql);
	if (!empty($zonaList)) { $message="Zona deja exista in baza de date"; }
	else {
		$zona->Denumire=$Denumire;
		$zona->save();
		$message="Adaugat";
	}
}

?>

<form action="zona_new.php" method="post">
	<div class="view" align="center" >
		<h3>Adaugare zona<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Denumire: </td>
                <td><input type="text" name="Denumire" maxlength="30" value="<?php if (isset($Denumire)) {echo htmlentities($Denumire);} ?>" /></td>
            </tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Adauga" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>