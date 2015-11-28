<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$Tara="Romania";

$user=User::find_by_id($_SESSION['user_id']);
if (isset($_GET['tel'])) { 
	$TelefonMobil=$_GET['tel'];
}
if (isset($_POST['submit'])) {
	$client=new Client();
	
	$actualizare=(isset($_POST["actualizare"]) ? 1 : 0);
	//$modagent=(isset($_POST["modagent"]) ? 1 : 0);
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		${$variable}=$_POST[$variable];
		switch ($variable){
			case "submit":break;
			default: $client->{$variable}=trim(${$variable});
				break;
		}	
	}
	
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$client->idStrada)."'";
	$stradaList=Strada::find_by_sql($sql);
	$strada=array_shift($stradaList);
	$client->idStrada=$strada->id;
	
	if ($user->NivelAcces!=0) {
		$client->idUtilizator=$user->id;
	}
	$client->DataActualizare=date("Y/m/d");
	
	$client->save();
	redirect_to("client_view.php?id={$client->id}");
	//$_SESSION['current_client_id']=$client->id;
	$message="Clientul cu ID: ".$client->id." a fost adaugat.";
}
?>

<?php //include_layout_template('admin_header.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Categorii dotari</title>
	
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	
	<script type="text/javascript" src=".././javascripts/stradahint.js"></script>
	<script type="text/javascript"> 
	<!--
	function onClick_close(){
		document.location = ("check_client.php");
	}
	function ofertaNew(id){
		//document.location = ("client_view.php?id=" + id);
		window.open("oferta_new.php?id=" + id,"oferta_new","toolbar=0,resizable=1,scrollbars=1");
	}
	function cerereNew(id){
		//document.location = ("client_view.php?id=" + id);
		window.open("cerere_new.php?id=" + id,"cerere_new","toolbar=0,resizable=1,scrollbars=1");
	}
	//-->
	</script> 
</head>
<body>

<?php require_once(".././include/meniu.php");?>

<form action="client_new.php" method="post">
	<div id="DetaliiGenerale" class="view" >
		<h3>Date generale</h3>
		<table>
			<tr>
				<td class="label">Prenume:</td>
				<td><input type="text" name="Prenume" value="<?php if (isset($Prenume)) {echo $Prenume;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Nume:</td>
				<td><input type="text" name="Nume" value="<?php if (isset($Nume)) {echo $Nume;}?>"></input></td>
			</tr>
			
			<tr>
				<td class="label">Telefon:</td>
				<td><input type="text" name="TelefonMobil" value="<?php if (isset($TelefonMobil)) {echo $TelefonMobil;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon 2:</td>
				<td><input type="text" name="TelefonFix" value="<?php if (isset($TelefonFix)) {echo $TelefonFix;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon 3:</td>
				<td><input type="text" name="TelefonServici" value="<?php if (isset($TelefonServici)) {echo $TelefonServici;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Telefon 4:</td>
				<td><input type="text" name="TelefonFax" value="<?php if (isset($TelefonFax)) {echo $TelefonFax;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Email:</td>
				<td><input type="text" name="Email" value="<?php if (isset($Email)) {echo $Email;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Permite SMS:</td>
				<?php 
					if (isset($PermiteSMS)) { if ($PermiteSMS==1) {$checked="checked='checked'";}}
					else {$checked="";}
				?>
				<td><input type="checkbox" name="PermiteSMS" value="1" <?php echo $checked; ?>></input></td>
			</tr>
			
		</table>
	</div>
	<div id="DetaliiIdentificare" class="view" >
		<h3>Date Identificare</h3>
		<table>
			<tr>
				<td class="label">CNP:</td>
				<td><input type="text" name="CNP" value="<?php if (isset($CNP)) {echo $CNP;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Carte identitate:</td>
				<td>serie <input type="text" name="SerieCI" size="2" value="<?php if (isset($SerieCI)) {echo $SerieCI;}?>"></input>
					nr. <input type="text" name="NumarCI" size="6" value="<?php if (isset($NumarCI)) {echo $NumarCI;}?>"></input>
				</td>
			</tr>
			<tr>
				<td class="label">Serie pasaport:</td>
				<td><input type="text" name="SeriePasaport" value="<?php if (isset($SeriePasaport)) {echo $SeriePasaport;}?>"></input></td>
			</tr>
		</table>
	</div>
	<div id="Adresa" class="view" >
		<h3>Adresa</h3>
		<table>
			<tr>
				<td class='label'>Strada:</td>
				<td>
					<input type="text" id="Strada" name="idStrada" onkeyup="showHint(this.value)"></input>
					<div id="divStradaHint" class="hint">
					</div> 
				</td>
				
				
			</tr>
			<tr>
				<td class="label">Numar:</td>
				<td><input type="text" name="Numar" value="<?php if (isset($Numar)) {echo $Numar;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Bloc:</td>
				<td><input type="text" name="Bloc" value="<?php if (isset($Bloc)) {echo $Bloc;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Scara:</td>
				<td><input type="text" name="Scara" value="<?php if (isset($Scara)) {echo $Scara;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Apartament:</td>
				<td><input type="text" name="Apartament" value="<?php if (isset($Apartament)) {echo $Apartament;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Interfon:</td>
				<td><input type="text" name="Interfon" value="<?php if (isset($Interfon)) {echo $Interfon;}?>"></input></td>
			</tr>
			<tr>
				<td class="label">Sector:</td>
				<td><input type="text" name="Sector" value="<?php if (isset($Sector)) {echo $Sector;}?>"></input></td>
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
								if ($agent->id==$user->id) {echo "selected='selected'";}
								echo "value='".$agent->id."'>{$agent->full_name()}";
								echo "</option>";
							}
						?>
					</select>
				</td>
			</tr>
			
			<?php 
			}
			?>
		</table>
	</div>

	<div id="butoane2" class="butoane">
		<table width="100%">
			<tr>
				<td align="left">
				<?php 
					if (isset($client->id)) { ?>
						<input type="button" value="Adauga oferta" <?php echo "onclick='ofertaNew(".$client->id.")'";?> />
						<input type="button" value="Adauga cerere" <?php echo "onclick='cerereNew(".$client->id.")'";?> />
				<?php 
					}?>
				</td>
				<td align="right">
					<input type='button' id='close' value='Inchide fereastra' onclick=onClick_close()/>
					<?php 
					if (!isset($client->id)) { ?>
						<input type='submit' name='submit' id='submit' value='Salveaza'/>
					<?php 
					}
					?>
						
				</td>
			</tr>
		</table>
	</div>
</form>
<script>
	hide("divStradaHint");
</script>
<?php 
	if (isset($message)) {echo "<br/>".$message."<br/><br/>";}
?>


<?php //include_layout_template('admin_footer.php'); ?>
</body>
</html>