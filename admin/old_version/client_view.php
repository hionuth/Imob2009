<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$client=Client::find_by_id($_GET['id']);

function put_item($var,$label) {
	$item="<tr><td class='label'>".$label.":</td>";
	$item=$item."<td>".$var."</td></tr>";
	return $item;
}
?> 

<?php //include_layout_template('admin_header.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Vizualizare oferta</title>
	
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

	<script type="text/javascript"> 
	<!--
	function onClickB(operation,id){
		if (operation==1) document.location=("client_update.php?id=" + id);
		if (operation==2) document.location=("oferta_new.php?id=" + id);
		if (operation==3) document.location = ("cerere_new.php?id=" + id);
		if (operation==4) document.location = ("check_client.php?telefon=" + id);
	}
	
	//-->
	</script> 
</head>
<body>
	<?php 
	$title="Client - vizualizare";
	require_once(".././include/head.php");?>
	
	<div id="DetaliiGenerale" class="view" >
		<h3>Date generale</h3>
		<table>
			<?php echo put_item($client->full_name(),"Nume");?>
			<?php echo put_item($client->TelefonMobil,"Telefon 1");?>
			<?php echo put_item($client->TelefonFix,"Telefon 2");?>
			<?php echo put_item($client->TelefonServici,"Telefon 3");?>
			<?php echo put_item($client->TelefonFax,"Telefon 4");?>
			<?php echo put_item($client->Email,"Email");?>
			<?php 
				if ($client->PermiteSMS==1) {$PermiteSMS="Da";}
				else {$PermiteSMS="Nu";}	
				echo put_item($PermiteSMS,"Permite SMS");?>
			
			
		</table>
	</div>
	<div id="DetaliiIdentificare" class="view" >
		<h3>Date Identificare</h3>
		<table>
			<?php echo put_item($client->id,"Cod client");?>
			<?php echo put_item($client->CNP,"CNP");?>
			<?php echo put_item($client->SerieCI." ".$client->NumarCI,"CI");?>
			<?php echo put_item($client->SeriePasaport,"Pasaport");?>
		</table>
	</div>
	<div id="Adresa" class="view" >
		<h3>Adresa</h3>
		<table>
			<?php 
				$strada=Strada::find_by_id($client->idStrada);
				$adresa=$strada->Denumire;
				if ($client->Numar>0) {$adresa.=", nr. {$client->Numar}";}
				if ($client->Bloc!="") {$adresa.=", bl. {$client->Bloc}";}
				if ($client->Scara!="") {$adresa.=", sc. {$client->Scara}";}
				if ($client->Apartament>0) {$adresa.=", ap. {$client->Apartament}";}
				if ($client->Interfon!="") {$adresa.=", int. {$client->Interfon}";}
				if ($client->Sector>0) {$adresa.=", sect. {$client->Sector}";}
				echo put_item($adresa,"Adresa");?>
			<?php echo put_item($client->Oras,"Oras");?>
			<?php echo put_item($client->Judet,"Judet");?>
			<?php echo put_item($client->Tara,"Tara");?>
			
		</table>
	</div>
	<div id="Administrativ" class="view" >
		<h3>Administrativ</h3>
		<table>
			<?php echo put_item($client->Detalii,"Detalii");?>
			<?php echo put_item($client->DataActualizare,"Data actualizarii");?>
			<?php 
				$agent=User::find_by_id($client->idUtilizator);
				echo put_item($agent->full_name(),"Agent");?>
		</table>
	</div>
	<div id="Butoane" class="butoane" >
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr>
				<td align="left">
					<input type="button" id="cerere" value="Adauga cerere" onclick='onClickB(3,"<?php echo $client->id;?>")'/>
					<input type="button" id="oferta" value="Adauga oferta" onclick='onClickB(2,"<?php echo $client->id;?>")'/>
				</td>
				<td align="right">
					<input type="button" id="update" value="Modifica" onclick='onClickB(1,"<?php echo $client->id;?>")'/>
					<input type="button" id="inapoi" value="Inchide fereastra" onclick='onClickB(4,"<?php echo $client->TelefonMobil;?>")'/>
				</td>
			</tr>
		</table>
		
	</div>


<?php //include_layout_template('admin_footer.php'); ?>
</body>
</html>