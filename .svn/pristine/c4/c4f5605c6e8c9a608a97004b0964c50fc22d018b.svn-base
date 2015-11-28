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
	document.location = ("strada_list.php");
}

//-->
</script>
<?php 
$message="";
if (isset($_GET['id'])){
	$strada=Strada::find_by_id($_GET['id']);
	$Denumire=$strada->Denumire;
	$_SESSION['curentIdStrada']=$strada->id;
}
if (isset($_POST['submit'])) {
	$strada=new Strada();
	$Denumire=$_POST['Denumire'];
	$strada=Strada::find_by_id($_SESSION['curentIdStrada']);
	unset($_SESSION['curentIdStrada']);
	$strada->Denumire=$Denumire;
	$strada->save();
	$message="salvat";
}

?>

<form action="strada_update.php" method="post">
	<div class="view" align="center" >
		<h3>Modificare strada<?php if ($message!="") {echo " - ".$message;}?></h3>
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