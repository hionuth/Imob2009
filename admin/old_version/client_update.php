<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$user=User::find_by_id($_SESSION['user_id']);
if (isset($_POST['submit'])) {
	//$client=new Client();
	$flow=$_POST['flow'];
	$client=Client::find_by_id($_POST['id']);
	
	$actualizare=(isset($_POST["actualizare"]) ? 1 : 0);
	$modagent=(isset($_POST["modagent"]) ? 1 : 0);
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		${$variable}=$_POST[$variable];
		switch ($variable){
			case "submit":break;
			case "flow": break;
			case "DataActualizare":
				if ($actualizare) {$client->{$variable}=trim(${$variable});}
				break;
			case "Detalii":
				if ($actualizare) {$client->{$variable}=trim(${$variable});}
				break;
			case "idUtilizator":
				if ($modagent) {$client->{$variable}=trim(${$variable});}
				break;
			default: $client->{$variable}=trim(${$variable});
				break;
		}	
	}
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$client->idStrada)."'";
	$stradaList=Strada::find_by_sql($sql);
	$strada=array_shift($stradaList);
	$client->idStrada=$strada->id;
	
	$client->save();
	redirect_to("client_view.php?id=".$client->id);
}
else {
	$client=Client::find_by_id($_GET['id']);
	$flow=$_GET['flow'];
	$strada=Strada::find_by_id($client->idStrada);
}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Vizualizare oferta</title>
	
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<script type="text/javascript" src=".././javascripts/stradahint.js"></script>

	<script type="text/javascript"> 
	function back(id){
		<?php if ($flow==0) {echo "document.location = \"client_view.php?id=\"+id;"; }
		else  {echo "window.close();";}
		?>
	}
	</script> 
</head>
<body>

<?php
	$title="Client - modificare";
	require_once(".././include/head.php");
?>

<form action="client_update.php" method="post">
	<input type="hidden" name="id" value="<?php echo htmlentities($client->id);?>"></input>
	<input type="hidden" name="flow" value="<?php echo htmlentities($flow);?>"></input>
	<div id="DetaliiGenerale" class="view" >
		<h3>Date generale</h3>
		<table>
			<tr>
				<td class="label">Nume:</td>
				<td><input type="text" name="Nume" value="<?php echo htmlentities($client->Nume);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Prenume:</td>
				<td><input type="text" name="Prenume" value="<?php echo htmlentities($client->Prenume);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon mobil:</td>
				<td><input type="text" name="TelefonMobil" value="<?php echo htmlentities($client->TelefonMobil);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon fix:</td>
				<td><input type="text" name="TelefonFix" value="<?php echo htmlentities($client->TelefonFix);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon servici:</td>
				<td><input type="text" name="TelefonServici" value="<?php echo htmlentities($client->TelefonServici);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon fax:</td>
				<td><input type="text" name="TelefonFax" value="<?php echo htmlentities($client->TelefonFax);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Email:</td>
				<td><input type="text" name="Email" value="<?php echo htmlentities($client->Email);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Permite SMS:</td>
				<td><input type="checkbox" name="PermiteSMS" value="1" <?php echo (($client->PermiteSMS==1) ? "checked=\"checked\"" : ""); ?>></input></td>
			</tr>
		</table>
	</div>
	<div id="DetaliiIdentificare" class="view" >
		<h3>Date Identificare</h3>
		<table>
			<tr>
				<td class="label">CNP:</td>
				<td><input type="text" name="CNP" value="<?php echo htmlentities($client->CNP);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Carte identitate:</td>
				<td>serie <input type="text" name="SerieCI" size="2" value="<?php echo htmlentities($client->SerieCI);?>"></input>
					nr. <input type="text" name="NumarCI" size="6" value="<?php echo htmlentities($client->NumarCI);?>"></input>
				</td>
			</tr>
			<tr>
				<td class="label">Serie pasaport:</td>
				<td><input type="text" name="SeriePasaport" value="<?php echo htmlentities($client->SeriePasaport);?>"></input></td>
			</tr>
		</table>
	</div>
	<div id="Adresa" class="view" >
		<h3>Adresa</h3>
		<table>
			<tr>
				<td class='label'>Strada:</td>
				<td>
					<input type="text" id="Strada" name="idStrada" value="<?php echo $strada->Denumire;?>" onkeyup="showHint(this.value)"></input>
					<div id="divStradaHint" class="hint">
					</div> 
				</td>
			</tr>
			<tr>
				<td class="label">Numar:</td>
				<td><input type="text" name="Numar" value="<?php echo htmlentities($client->Numar);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Bloc:</td>
				<td><input type="text" name="Bloc" value="<?php echo htmlentities($client->Bloc);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Scara:</td>
				<td><input type="text" name="Scara" value="<?php echo htmlentities($client->Scara);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Apartament:</td>
				<td><input type="text" name="Apartament" value="<?php echo htmlentities($client->Apartament);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Interfon:</td>
				<td><input type="text" name="Interfon" value="<?php echo htmlentities($client->Interfon);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Sector:</td>
				<td><input type="text" name="Sector" value="<?php echo htmlentities($client->Sector);?>"></input></td>
			</tr>
			<tr>
				<td class="label">Oras:</td>
				<td><input type="text" name="Oras" value="<?php if (isset($Oras)) {echo $Oras;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Judet:</td>
				<td><input type="text" name="Judet" value="<?php if (isset($Judet)) {echo $Judet;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Tara:</td>
				<td><input type="text" name="Tara" value="<?php if (isset($Tara)) {echo $Tara;}?>"></input></td>
			</tr>
		</table>
	</div>
	<div id="Administrativ" class="view" >
		<h3>Administrativ</h3>
		<table>
			<tr valign="top">
				<td class="label">Detalii client:</td>
				<td><textarea rows="3" cols="30" name="Detalii"><?php if (isset($Detalii)) {echo $Detalii;}?></textarea></td>
			</tr>
			<tr>
				<td class="label">Data actualizarii:</td>
				<td><input type="text" name="DataActualizare" id="dataactualizare" value="<?php if (isset($DataActualizare)) {echo $DataActualizare;}?>"></input>
				<input type="button" id="calendar-trigger" value='...'/><br/>
				<script>
    				Calendar.setup({
        				trigger    : "calendar-trigger",
        				inputField : "dataactualizare",
        				onSelect   : function() { this.hide();}
    				});
				</script>
				</td>
			</tr>
			<tr>
				<td class="label">Actualizeaza:</td>
				<td><input type="checkbox" name="actualizare" value="1"></input></td>
			</tr>
			<?php 
			if ($user->NivelAcces==0){
			?>
			<tr>
				<td class="label">Agent:</td>
				<td>
					<select name='idUtilizator'>
						<?php 
							$userlist=User::find_all();
							foreach ($userlist as $agent) {
								echo "<option ";
								if ($agent->id==$client->idUtilizator) {echo "selected='selected'";}
								echo "value='".$agent->id."'>";
								echo "{$agent->full_name()}</option>";
							}
						?>
					</select>
					 salveaza<input type='checkbox' name='modagent' value=1 />
				</td>
			</tr>
			
			<?php 
			}
			?>
		</table>
	</div>

	<div id="Butoane" class="butoane"  >
		<input type='button' id='close' value='Inchide fereastra' onclick='back(<?php echo $client->id;?>)'/>
		<input type='submit' name='submit' id='submit' value='Salveaza'/>
	</div>
</form>
<script>
	hide("divStradaHint");
</script>
</body>
</html>