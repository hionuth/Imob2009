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
if (isset($_GET['id'])){
	$zona=Zona::find_by_id($_GET['id']);
	$Denumire=$zona->Denumire;
	$_SESSION['curentIdZona']=$zona->id;
}
if (isset($_POST['submit'])) {
	$zona=new Zona();
	$Denumire=$_POST['Denumire'];
	$zona=Zona::find_by_id($_SESSION['curentIdZona']);
	unset($_SESSION['curentIdZona']);
	$zona->Denumire=$Denumire;
	$zona->save();
	$message="salvat";
}

?>

<form action="zona_update.php" method="post">
	<div class="view" align="center" >
		<h3>Modificare zona<?php if ($message!="") {echo " - ".$message;}?></h3>
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
			<input type="submit" name="submit" value="Salveaza" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>