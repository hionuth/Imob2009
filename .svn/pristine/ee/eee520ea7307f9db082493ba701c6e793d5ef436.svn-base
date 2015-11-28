<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
if (isset($_POST['nume'])) {
	$nume=$_POST['nume'];
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
    <script type="text/javascript"> 
		<!--
		
		function addStrada(){
			document.location = ("strada_new.php");
		}
		
		function onOver(id,over,row){
			var changed = document.getElementById(id);
			if (over == 1) changed.className='deasupra';
			else {
				if (row%2) changed.className='impar';
				else changed.className='par';
			}
		}
		//-->
	</script> 
    
</head>
<body>
<?php 
$title="Clienti";
require_once(".././include/head.php");
?>

<form action="client_list.php" method="post">
<div class="view" style="align:center" >
	<h3>Cautare clienti</h3>
   	<table>
   		<tr>
   			<td class="label">Client:</td>
   			<td><input type="text" name="nume" maxlength="200" value="<?php echo htmlentities($nume); ?>" /></td>
   			<td><input type="submit" name="submit" value="Cauta clienti" /></td>
   		</tr>
   	</table>
</div>
<div class="butoane">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr align="right">
			<td>&nbsp;</td>
		</tr>
	</table>
</div>
</form>

<?php 
	if (isset($_POST['submit'])) {
		
?>
<div class="view" align="center" >
	<h3>Lista clienti gasiti</h3>
   	<table width="100%">
   		<tr>
   			<td class="header" style="font-weight:bold" width="15%">Nume</td>
   			<td class="header" style="font-weight:bold" width="20%">Telefoane</td>
   			<td class="header" style="font-weight:bold" width="15%">Email</td>
   			<td class="header" style="font-weight:bold" width="35%">Adresa</td>
   			<td class="header" style="font-weight:bold" width="15%">Agent</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Client WHERE Nume LIKE '%".$nume."%' OR Prenume LIKE '%".$nume."%'";
   		$clienti=Client::find_by_sql($sql);
   		if (!empty($clienti)){
   			$i=0;
   			foreach ($clienti as $client){
   				$i++;
   				$class=$i%2 ? "impar" : "par";
   				?>
   		<tr id="<?php echo $client->id;?>" class="<?php echo $class;?>" style="cursor:pointer;height:30px;font-weight:bold;" ondblclick="document.location='client_view.php?id=<?php echo $client->id;?>';" onmouseover="onOver('<?php echo $client->id;?>',1,'<?php echo $i;?>')" onmouseout="onOver('<?php echo $client->id;?>',0,'<?php echo $i;?>')">
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
   		}
   	?>
   	</table>
</div>
<?php 
	}
?>
</body>
</html>