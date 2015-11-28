<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
//include_layout_template('header.php');

function build_list($var) {
	$tmp="";
	if (!empty($var)){		
		foreach($var as $chk){
			if ($tmp=="") {$tmp=$chk;}
			else {$tmp=$tmp.",".$chk;}
		}
	}
	return ",".$tmp.",";
}

	$message="";
	if (isset($_GET['id'])){
		$idCerere=$_GET['id'];
		$cerere=Cerere::find_by_id($idCerere);
		$client=Client::find_by_id($cerere->idClient);
		$ClientId=$client->id;
		if (strlen($cerere->Zona)>0){
			$zoneList=explode(",",$cerere->Zona);
			foreach ($zoneList as $idZona) { $subZonaChecked[$idZona]=1; }
		}
		if (strlen($cerere->TipProprietate)>0){
			$tmplist=explode(",",$cerere->TipProprietate);
			foreach ($tmplist as $tmpx) { $TipProprietate[$tmpx]=1; }
		}
		if (strlen($cerere->NumarCamere)>0){
			$tmplist=explode(",",$cerere->NumarCamere);
			foreach ($tmplist as $tmpx) { $NumarCamere[$tmpx]=1; }
		}
		if (strlen($cerere->Confort)>0){
			$tmplist=explode(",",$cerere->Confort);
			foreach ($tmplist as $tmpx){$Confort[$tmpx]=1;}
		}
		if (strlen($cerere->Confort)>0){
			$tmplist=explode(",",$cerere->TipApartament);
			foreach ($tmplist as $tmpx){
				switch ($tmpx) {
					case "Decomandat":
						$TipApartament[1]=1;
						break;
					case "Semidecomandat":
						$TipApartament[2]=1;
						break;
					case "Comandat":
						$TipApartament[3]=1;
						break;
					case "Circular":
						$TipApartament[4]=1;
						break;
					case "Duplex":
						$TipApartament[5]=1;
						break;
				}
				
			}
		}
		$EtajMin=$cerere->EtajMinim;
		$EtajMax=$cerere->EtajMaxim;
		$EtajeBlocMin=$cerere->EtajeBlocMin;
		$EtajeBlocMax=$cerere->EtajeBlocMax;
		$Parter=$cerere->Parter;
		$EtajIntermediar=$cerere->EtajIntermediar;
		$UltimulEtaj=$cerere->UltimulEtaj;
		$AnConstructie=$cerere->AnConstructie;
		$Cumparare=$cerere->Cumparare;
		$Inchiriere=$cerere->Inchiriere;
		$Buget=$cerere->Buget;
		$Moneda=$cerere->Moneda;
		$Credit=$cerere->Credit;
		$Detalii=$cerere->Detalii;
		$Stare=$cerere->Stare;
	}
	if (isset($_POST['submit'])) {
		$postlist=array_keys($_POST);
		foreach($postlist as $variable) {
			if ($variable!="submit") {${$variable}=$_POST[$variable];}
		}
		$cerere=new Cerere();
		$client=Client::find_by_id($ClientId);
		
		$cerere->id=$idCerere;
		$cerereStatic=Cerere::find_by_id($idCerere);
		
		$cerere->idClient=$ClientId;
		if (isset($subZonaChecked)) {$cerere->Zona=build_list($subZonaChecked);}
		if (isset($TipProprietate)) {$cerere->TipProprietate=build_list($TipProprietate);}
		if (isset($NumarCamere)) {$cerere->NumarCamere=build_list($NumarCamere);}
		if (isset($Confort)) {$cerere->Confort=build_list($Confort);}
		if (isset($TipApartament)) {$cerere->TipApartament=build_list($TipApartament);}
		$cerere->EtajMinim=$EtajMin;
		$cerere->EtajMaxim=$EtajMax;
		$cerere->EtajeBlocMin=$EtajeBlocMin;
		$cerere->EtajeBlocMax=$EtajeBlocMax;
		$cerere->Parter=$Parter;
		$cerere->EtajIntermediar=$EtajIntermediar;
		$cerere->UltimulEtaj=$UltimulEtaj;
		$cerere->AnConstructie=$AnConstructie;
		if ($TipOferta==1) {
			$cerere->Cumparare=1;
			$cerere->Inchiriere=0;
		}
		else {
			$cerere->Cumparare=0;
			$cerere->Inchiriere=1;
		}
		$cerere->Buget=$Buget;
		$cerere->Moneda=$Moneda;
		if (isset($Credit)) {$cerere->Credit=$Credit;}
		$cerere->Detalii=$Detalii;
		$cerere->Stare=$Stare;
		$cerere->DataCreare=$cerereStatic->DataCreare;
		$cerere->DataActualizare=date("Y-m-d");
		
		$cerere->save();
		redirect_to("cerere_view.php?id=".$cerere->id);
		$message="Salvat cu ID: ".$cerere->id;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Vizualizare cerere</title>
	
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<script type="text/javascript" src=".././javascripts/oferte.js"></script>

	<script type="text/javascript">
	
	function hide(id){
		var menuStyle=document.getElementById(id).style;
		menuStyle.display="none";
	}
	</script>


<script type="text/javascript"> 
function onClick_close(id){
	document.location = ("cerere_view.php?id=" + id);
}

function showHide(item){
	var itemStyle=document.getElementById(item).style;
	if (itemStyle.display=="block") {
		itemStyle.display="none";
	}
	else {
		itemStyle.display="block";
	}
}
</script>

</head>
<body>
<?php if ($message!="") {echo "<h3>{$message}</h3>";}?>
<form action="cerere_update.php" method="post">

<div id="DetaliiClient" class="view"> 
	<h3 onclick="showHide('extraClient')" onmouseover="this.style.cursor='hand'">Detalii client  -  extinde ...</h3>
	<input type="hidden" id="idCerere" name="idCerere" value="<?php echo $idCerere;?>"/>
	<input type="hidden" name="ClientId" value="<?php echo htmlentities($ClientId);?>" />
	<table>
		<tr>
			<td class="label">Nume client:</td>
			<td><?php echo $client->full_name(); ?></td>
		</tr>
	</table>
	<div id="extraClient">
		<table>
			<tr >
				<td class="label">Telefoane:</td>
				<td>
					<?php 
						echo $client->TelefonMobil;
						if ($client->TelefonFix!="") {echo ", ".$client->TelefonFix;};
						if ($client->TelefonServici!="") {echo ", ".$client->TelefonServici;};
						if ($client->TelefonFax!="") {echo ", ".$client->TelefonFax;};
					?>
				</td>
			</tr>
			<tr >
				<td class="label">Email:</td>
				<td>
					<?php echo $client->Email;?>
				</td>
			</tr>
			<tr >
				<td class="label">Adresa:</td>
				<td>
					<?php
						$strada=Strada::find_by_id($client->idStrada);
						echo $strada->Denumire.", "; 
						echo $client->Adresa;
					?>
				</td>
			</tr>
			<tr >
				<td class="label">Agent:</td>
				<td>
					<?php 
						$agent=User::find_by_id($client->idUtilizator);
						echo $agent->full_name();
					?>
				</td>
			</tr>
		</table>
	</div>
</div>
<script>
	hide("extraClient");
</script>

<?php include 'zone_tree.php';?>

<div id="DetaliiApartament" class="view"> 
	<h3>Detalii Apartament</h3>
	<table>
	<tr>
		<td class="label" valign="top">Tip proprietate:</td>
		<td valign="top">
			<input type="checkbox" name="TipProprietate[1]" value="1" <?php if (isset($TipProprietate[1])) {echo "Checked";}?> />Apartament<br/>
			<input type="checkbox" name="TipProprietate[2]" value="2" <?php if (isset($TipProprietate[2])) {echo "Checked";}?>/>Ap. in vila<br/>
			<input type="checkbox" name="TipProprietate[3]" value="3" <?php if (isset($TipProprietate[3])) {echo "Checked";}?>/>Casa<br/>
			<input type="checkbox" name="TipProprietate[4]" value="4" <?php if (isset($TipProprietate[4])) {echo "Checked";}?>/>Teren<br/>
		</td>
	</tr>
	<tr>
		<td class="label" valign="top">Camere:</td>
		<td>
			
			<table cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="150">
						<input type="checkbox" name="NumarCamere[1]" value=1 <?php if (isset($NumarCamere[1])) {echo "Checked";}?>/>Garsoniera<br/>
						<input type="checkbox" name="NumarCamere[2]" value=2 <?php if (isset($NumarCamere[2])) {echo "Checked";}?>/>2 camere<br/>
						<input type="checkbox" name="NumarCamere[3]" value=3 <?php if (isset($NumarCamere[3])) {echo "Checked";}?>/>3 camere<br/>
					</td>
					<td width="150">
						<input type="checkbox" name="NumarCamere[4]" value=4 <?php if (isset($NumarCamere[4])) {echo "Checked";}?>/>4 camere<br/>
						<input type="checkbox" name="NumarCamere[5]" value=5 <?php if (isset($NumarCamere[5])) {echo "Checked";}?>/>5 camere<br/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="label" valign="top">Confort:</td>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="150">
						<input type="checkbox" name="Confort[1]" value=1 <?php if (isset($Confort[1])) {echo "Checked";}?>/>Confort I<br/>
					</td>
					<td width="150">
						<input type="checkbox" name="Confort[2]" value=2 <?php if (isset($Confort[2])) {echo "Checked";}?>/>Confort II<br/>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="label" valign="top">Tip apartament:</td>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr valign="top">
					<td width="150">
						<input type="checkbox" name="TipApartament[1]" value=Decomandat <?php if (isset($TipApartament[1])) {echo "Checked";}?>/>Decomandat<br/>
						<input type="checkbox" name="TipApartament[2]" value=Semidecomandat <?php if (isset($TipApartament[2])) {echo "Checked";}?>/>Semidecomandat<br/>
						<input type="checkbox" name="TipApartament[3]" value=Comandat <?php if (isset($TipApartament[3])) {echo "Checked";}?>/>Comandat<br/>
					</td>
					<td width="150">
						<input type="checkbox" name="TipApartament[4]" value=Circular <?php if (isset($TipApartament[3])) {echo "Checked";}?>/>Circular<br/>
						<input type="checkbox" name="TipApartament[5]" value=Duplex <?php if (isset($TipApartament[3])) {echo "Checked";}?>/>Duplex<br/>
					</td>
				</tr>
			</table>
		</td>
	</tr>	
	<tr>
		<td class="label" valign="top"> Etaj:</td>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<select name="EtajMin">
							<option value='' selected="selected"> </option>
							<option value='0' <?php if (isset($EtajMin)) {if ($EtajMin==0){echo " selected=\"selected\"";}}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if (isset($EtajMin)) {if ($i==$EtajMin){echo " selected=\"selected\"";}}
									echo ">".$i."</option>";
								}
							?>
						</select> - 
						<select name="EtajMax">
							<option value=''> </option>
							<option value='0' <?php if (isset($EtajMax)) {if ($EtajMax==0){echo " selected=\"selected\"";}}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if (isset($EtajMax)) {if ($i==$EtajMax){echo " selected=\"selected\"";}}
									echo ">".$i."</option>";
								}
							?>
						</select>	
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="label" valign="top"> Etaje bloc:</td>
		<td>
			<table cellpadding="0" cellspacing="0">
				<tr>
					<td>
						<select name="EtajeBlocMin">
							<option value='' selected="selected"> </option>
							<option value='0' <?php if (isset($EtajeBlocMin)) {if ($EtajeBlocMin==0){echo " selected=\"selected\"";}}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if (isset($EtajeBlocMin)) {if ($i==$EtajeBlocMin){echo " selected=\"selected\"";}}
									echo ">".$i."</option>";
								}
							?>
						</select> - 
						<select name="EtajeBlocMax">
							<option value=''> </option>
							<option value='0' <?php if (isset($EtajeBlocMax)) {if ($EtajeBlocMax==0){echo " selected=\"selected\"";}}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if (isset($EtajeBlocMax)) {if ($i==$EtajeBlocMax){echo " selected=\"selected\"";}}
									echo ">".$i."</option>";
								}
							?>
						</select>	
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="label" valign="top">Pozitionare:</td>
		<td>
			<input type="checkbox" name="Parter" value=1 <?php if (isset($Parter)) {if ($Parter==1) {echo "Checked";}}?>/>Parter<br/>
			<input type="checkbox" name="EtajIntermediar" value=1 <?php if (isset($EtajIntermediar)) {if ($EtajIntermediar==1){echo "Checked";}}?>/>Etaj intermediar<br/>
			<input type="checkbox" name="UltimulEtaj" value=1 <?php if (isset($UltimulEtaj)) {if ($UltimulEtaj==1) {echo "Checked";}}?>/>Ultimul etaj					
		</td>
	</tr>
	<tr>
		<td class="label">An constructie min:</td>
		<td><input type="text" name="AnConstructie" value="<?php if (isset($AnConstructie)) {echo htmlentities($AnConstructie);}?>" /></td>
	</tr>				
	</table>
</div>

<div id="DetaliiCerere" class="view">
	<h3>Detalii cerere</h3>
	<table>
	<tr>
		<td class="label" valign="top">Tip cerere:</td>
		<td>
			<input type="radio" name="TipOferta" value=1 checked="checked"/>Cumparare<br/>
			<input type="radio" name="TipOferta" value=0 <?php if(isset($Cumparare)){if ($Cumparare==0){ echo " checked=\"checked\"";}}?>/>Inchiriere
		</td>
	</tr>
	<tr>
		<td class="label">Buget:</td>
		<td>
			<input type="text" name="Buget" value="<?php if (isset($Buget)) {echo htmlentities($Buget);}?>" /> 
			<select name="Moneda">
				<option value="">...</option>
				<option value="RON" <?php if(isset($Moneda)){if ($Moneda=="RON"){ echo " selected=\"selected\"";}}?> >RON</option>
				<option value="EUR" <?php if(isset($Moneda)){if ($Moneda=="EUR"){ echo " selected=\"selected\"";}}?> >EUR</option>
				<option value="USD" <?php if(isset($Moneda)){if ($Moneda=="USD"){ echo " selected=\"selected\"";}}?> >USD</option>
				<option value="CHF" <?php if(isset($Moneda)){if ($Moneda=="CHD"){ echo " selected=\"selected\"";}}?> >CHF</option>
			</select> 
			<input type="checkbox" name="Credit" value=1 <?php if (isset($Credit)) {if ($Credit==1) {echo "Checked";}}?>/>Credit
		</td>
	</tr>
	<tr>
		<td class="label" valign="top">Detalii:</td>
		<td><textarea rows="3" cols="30" name="Detalii"><?php echo htmlentities(isset($Detalii) ? $Detalii : "");?></textarea></td>
	</tr>
	<tr>
		<td class="label">Stare:</td>
		<td>
			<select name='Stare'>
				<option value="de actualitate" <?php if (!isset($Stare)) {echo "selected";} else { if ($Stare=="de actualitate") {echo "selected";}}?>>de actualitate</option>
				<option value="vandut de noi" <?php if (isset($Stare)) { if ($Stare=="vandut de noi") {echo "selected";}}?>>vandut de noi</option>
				<option value="vandut de altii" <?php if (isset($Stare)) { if ($Stare=="vandut de altii") {echo "selected";}}?>>vandut de altii</option>
				<option value="stand by" <?php if (isset($Stare)) { if ($Stare=="stand by") {echo "selected";}}?>>stand by</option>
			</select>
		</td>
	</tr>
	</table>
</div>

<div id="butoane" class="butoane">
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr align="right">
			<td>
				<input type="button" id="close" value="Inchide fereastra" onclick="onClick_close('<?php echo $cerere->id?>')"/>
				<input type="submit" id="submit" name="submit" value="Salveaza"/>
			</td>
		</tr>
	</table>
</div>
<script type="text/javascript">
	<?php if (isset($_POST['submit'])){?>
		hide("submit");
	<?php }?>
</script>
</form>
<?php //include_layout_template('admin_footer.php'); ?>
</body>
</html>
