<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$client=Client::find_by_id($_GET['id']);
$strada=Strada::find_by_id($client->idStrada);
$agent=User::find_by_id($client->idUtilizator);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Vizualizare client</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
	<script>
	function onClickB(operation,id){
		if (operation==1) document.location=("client_update.php?id=" + id);
		if (operation==2) window.open("oferta_new.php?id=" + id);
		if (operation==3) window.open("cerere_new.php?id=" + id);
		if (operation==4) document.location = ("check_client.php?telefon=" + id);
	}
		$(function(){
			$("form").form();
		});
	</script>
</head>
<body>
<?php require_once(".././include/meniu.php");?>
<form action="">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClickB(4,"<?php echo $client->TelefonMobil;?>")'/>
		<input type="button" id="update" value="modifica" onclick='onClickB(1,"<?php echo $client->id;?>")'/>
		<input type="button" id="cerere" value="adauga cerere" onclick='onClickB(3,"<?php echo $client->id;?>")'/>
		<input type="button" id="oferta" value="adauga oferta" onclick='onClickB(2,"<?php echo $client->id;?>")'/>
	</div>

	
	
	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date identificare</legend>
			<dl>
				<dt><label class="label">prenume</label><input type="text" class="standard" name="Prenume"  disabled="disabled"  value="<?php echo $client->Prenume; ?>" ></input></dt>
				<dt><label class="label">nume</label><input type="text" class="standard" name="Nume"  disabled="disabled"  value="<?php echo $client->Nume; ?>"></input></dt>
				<dt><label class="label">cnp</label><input type="text" class="standard" name="CNP"  disabled="disabled" style="text-align: right;"  value="<?php echo $client->CNP; ?>"></input></dt>
				<dt><label class="label">c.i.</label><input type="text" id="SerieCI" name="SerieCI"  disabled="disabled" style="width: 30px;"  value="<?php echo $client->SerieCI; ?>"></input><input type="text"  disabled="disabled" name="NumarCI" style="text-align: right; width: 144px;" value="<?php echo $client->NumarCI; ?>"></input></dt>
				<dt><label class="label">pasaport</label><input type="text" class="standard"  disabled="disabled" name="SeriePasaport" style="text-align: right;"  value="<?php echo $client->SeriePasaport; ?>" ></input></dt>
			</dl>		
		</fieldset>	
		<fieldset>
			<legend>date contact</legend>
			<dl style="margin-bottom : 0px;">
				<dt><label class="label">telefon 1</label><input type="text" class="standard" disabled="disabled" name="TelefonMobil" style="text-align: right;" value="<?php echo $client->TelefonMobil; ?>" ></input></dt>
				<dt><label class="label">telefon 2</label><input type="text" class="standard" disabled="disabled" name="TelefonFix" style="text-align: right;" value="<?php echo $client->TelefonFix; ?>" ></input></dt>
				<dt><label class="label">telefon 3</label><input type="text" class="standard" disabled="disabled" name="TelefonServici" style="text-align: right;" value="<?php echo $client->TelefonServici; ?>" ></input></dt>
				<dt><label class="label">telefon 4</label><input type="text" class="standard" disabled="disabled" name="TelefonFax" style="text-align: right;" value="<?php echo $client->TelefonFax; ?>" ></input></dt>
				<dt><label class="label">email</label><input type="text" class="standard" disabled="disabled" name="Email" value="<?php echo $client->Email; ?>" ></input></dt>
				<dt><label class="label">permite SMS</label><input type="checkbox" class="standard"  disabled="disabled" name="PermiteSMS" <?php echo ($client->PermiteSMS==1 ? "checked=\"checked\"" : "") ; ?> value="1" style="margin-top: 5px;"></input></dt>
				
			</dl>
				
		</fieldset>
	</div>
	
	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date administrative</legend>
			<dl>
				<dt><label class="label" style="vertical-align: top; padding-top: 5px;">detalii</label><textarea class="standard"  disabled="disabled" style="min-height: 73px;"  name="Detalii" ><?php echo $client->Detalii;?></textarea></dt>
				<dt><label class="label">data actualizare</label><input type="text" class="standard" disabled="disabled" name="DataActualizare" id="dataactualizare" value="<?php echo convert_date($client->DataActualizare);?>"></input></dt>
				<dt>
					<label class="label">agent</label><input type="text" class="standard" disabled="disabled" value="<?php echo $agent->full_name();?>"></input>
				</dt>
				
				
			</dl>		
		</fieldset>	
		<fieldset>
			<legend>adresa</legend>
			<label class="label">strada</label><input type="text" class="standard" id="Strada" disabled="disabled" name="idStrada" value="<?php echo $strada->Denumire;?>"></input>
			<dl style="margin-top: 0px;">
				<dt>
					<label class="label">numar</label><input type="text" class="standard" disabled="disabled" name="Numar" value="<?php echo $client->Numar;?>" style="width: 30px;" ></input>
					<label>bl.</label><input type="text" class="standard" disabled="disabled" name="Bloc" value="<?php echo $client->Bloc;?>" style="width: 30px;" ></input>
					<label>sc.</label><input type="text" class="standard" disabled="disabled" name="Scara" value="<?php echo $client->Scara;?>" style="width: 20px;" ></input>
					<label>ap.</label><input type="text" class="standard" disabled="disabled" name="Apartament" value="<?php echo $client->Apartament;?>" style="width: 23px;" ></input>
				</dt>
				<dt>
					<label class="label">interfon</label><input type="text" disabled="disabled" name="Interfon" value="<?php echo $client->Interfon;?>" style="width: 50px;" ></input>
					<label>sector</label><input type="text" class="standard" disabled="disabled" name="Sector" value="<?php echo $client->Sector;?>" style="width: 87px;" ></input>
				</dt>
				<dt><label class="label">oras</label><input type="text" class="standard" disabled="disabled"  name="Oras" value="<?php echo $client->Oras;?>"></input></dt>
				<dt><label class="label">judet</label><input type="text" class="standard" disabled="disabled" name="Judet" value="<?php echo $client->Judet;?>" ></input></dt>
				<dt><label class="label">tara</label><input type="text" class="standard" disabled="disabled" name="Tara" value="<?php echo $client->Tara;?>"></input></dt>
			</dl>
		</fieldset>
	</div>
	
</form>
</body>
</html>