<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
if (isset($_GET['nume'])) {
	$nume=$_GET['nume'];
}
else {
	$nume="";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Clienti</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
	
	<script type="text/javascript">
		function onOver(id,over,row){
			var changed = document.getElementById(id);
			if (over == 1) changed.className='row over';
			else {
				if (row%2) changed.className='row odd';
				else changed.className='row even';
			}
		}

		function cauta(){
			var a=$("#nume").val().length;
			if (a>1) 	document.location='client_list.php?nume=' + $("#nume").val();
		}
					
		$(function(){
			$("form").form();
			$("#form_client").validate({
		   		rules: {
		    		nume: {
						required: true,
						minlength: 2
						
			    	}
		    	}
		    });
			
		});
	</script>
	    
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>
<form id="form_client">
<div style="width: 324px;">
	<div id="divtelefon">
		<fieldset id="fs_nume">
			<legend>nume client</legend>
			<dl>
				<dt>
					
					<input type="text" name="nume" id="nume" class="standard" maxlength="30" value="<?php echo htmlentities($nume); ?>" />
					<input type="button" value="Cauta clienti" onclick="cauta()" />
				</dt>
			</dl>	
		</fieldset>
	</div>
</div>
<?php 
	if (strlen($nume)>1) {
		$sql="SELECT * FROM Client WHERE Nume LIKE '%".$nume."%' OR Prenume LIKE '%".$nume."%'";
		$clienti=Client::find_by_sql($sql);
		if (!empty($clienti)){
		
?>
<div id="oferte" class="ui-widget-content ui-corner-all" style="margin:2px;margin-top: 5px;">
	<div class="ui-widget-header ui-corner-all " style="padding: 4px;">lista clienti</div>
	<table width="100%">
		<tr class="row">
			<td class="column ui-widget-header ui-corner-all" width="15%">nume</td>
			<td class="column ui-widget-header ui-corner-all" width="20%">telefoane</td>
			<td class="column ui-widget-header ui-corner-all" width="15%">email</td>
			<td class="column ui-widget-header ui-corner-all" width="35%">adresa</td>
			<td class="column ui-widget-header ui-corner-all" width="15%">agent</td>
		</tr>
		<?php 
			$i=0;
			foreach ($clienti as $client){
				$i++;
				$class=$i%2 ? "odd" : "even";
		?>
		<tr id="<?php echo $client->id;?>" class="<?php echo $class;?>" style="cursor:pointer;height:30px;font-weight:bold;" onclick="document.location='client_view.php?id=<?php echo $client->id;?>';" onmouseover="onOver('<?php echo $client->id;?>',1,'<?php echo $i;?>')" onmouseout="onOver('<?php echo $client->id;?>',0,'<?php echo $i;?>')">
			<td><?php echo $client->full_name();?></td>
   			<td><?php 
   				$telefon="";
   				if ($client->TelefonMobil!="") {$telefon.=($telefon==""?"":", ").$client->TelefonMobil;}
   				if ($client->TelefonFix!="") {$telefon.=($telefon==""?"":", ").$client->TelefonFix;}
   				if ($client->TelefonServici!="") {$telefon.=($telefon==""?"":", ").$client->TelefonServici;}
   				if ($client->TelefonFax!="") {$telefon.=($telefon==""?"":", ").$client->TelefonFax;}
   				echo $telefon;
   				?>
   			</td>
   			<td><?php echo $client->Email;?></td>
   			<td><?php 
   				$strada=Strada::find_by_id($client->idStrada);
   				$adresa=$strada->Denumire;
   				if ($client->Numar>0){$adresa.=", nr.".$client->Numar;}
   				if ($client->Bloc!=""){$adresa.=", bl.".$client->Bloc;}
   				if ($client->Scara!=""){$adresa.=", sc.".$client->Scara;}
   				if ($client->Apartament>0){$adresa.=", ap.".$client->Apartament;}
   				if ($client->Sector>0){$adresa.=", sect.".$client->Sector;}
   				echo $adresa;
   			?></td>
   			<td><?php 
   				$agent=User::find_by_id($client->idUtilizator);
   				echo $agent->full_name();
   			?></td>
   				
   		</tr>
		<?php 
			}
		?>
	</table>
</div>
<?php 	
		}
	}?>
</form>
</body>
</html>