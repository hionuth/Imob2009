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
	$zona=Zona::find_by_id($_GET['id']);
	$zona->delete();
?>

<h3>Zona <?php echo $zona->Denumire;?> a fost stearsa.</h3>

<div id="butoane" class="butoane">
		<input type="button" name="submit" value="Inapoi" onclick="back()" />
</div>
<?php include_layout_template('admin_footer.php'); ?>