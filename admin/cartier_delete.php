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
	$cartier=Cartier::find_by_id($_GET['id']);
	$cartier->delete();
?>

<h3>Cartierul <?php echo $cartier->Denumire;?> a fost sters.</h3>

<div id="butoane" class="butoane">
		<input type="button" name="submit" value="Inapoi" onclick="back()" />
</div>
<?php include_layout_template('admin_footer.php'); ?>