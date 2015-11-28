<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if (substr($variable,0,3)=="Mod") {
			$id=substr($variable,3,10);
			$Mod[$id]=$_POST[$variable];
		}
	}
	foreach ($Mod as $id=>$value){
		$syncSite = SyncSite::find_by_id($id);
		//$syncSite->Site = $value;
		$syncSite->Modalitate	= $value;
		$syncSite->save();
	}
	redirect_to("index.php");
		
}
else {
	$syncSiteArr = SyncSite::find_all();
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Configurare sincronizari</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
	<script>
	
	$(function(){
		$("form").form();
	});
	</script>
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>
<form action="config_sync.php" method="post">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type='submit' id='close' name='submit' value='Salveaza'></input>
	</div>
	<table width="500px">
		<tr class="row">
			<td class="column ui-widget-header ui-corner-all" width="50%">Site</td>
			<td class="column ui-widget-header ui-corner-all" width="50%">Modalite</td>
		</tr>
		<?php 
			if (!empty($syncSiteArr)){
				foreach ($syncSiteArr as $syncSite) {
					$i++;
					$class=$i%2 ? "row odd" : "row even";
					?>
			<tr class="<?php echo $class;?>">
				<td class="ui-corner-left"><label><?php echo $syncSite->Site;?></label></td>
				<td class="ui-corner-right">
					<select class="standard" name="Mod<?php echo $syncSite->id;?>">
						<option value="0" <?php if ($syncSite->Modalitate==0) echo "selected"?>>manual</option>
						<option value="1" <?php if ($syncSite->Modalitate==1) echo "selected"?>>automat</option>
					</select>
				
				</td>
			</tr>
					<?php
				}
			} 
		
		?>
		
	</table>
	
</form>
</body>
</html>