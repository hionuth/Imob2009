<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
//include_layout_template('header.php');

if (isset($_GET['id'])) {$idCerere=$_GET['id'];}

if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}	
	}
}

$cerere=Cerere::find_by_id($idCerere);
$cerere->NumarCamere=substr($cerere->NumarCamere,1,-1);
$cerere->TipProprietate=substr($cerere->TipProprietate,1,-1);
$cerere->Zona=substr($cerere->Zona,1,-1);
$cerere->TipApartament=substr($cerere->TipApartament,1,-1);
$cerere->Confort=substr($cerere->Confort,1,-1);
$client=Client::find_by_id($cerere->idClient);
$agent=User::find_by_id($client->idUtilizator);

if (!isset($_POST['submit'])) {
	$TipProprietate[1]=1;
	$NumarCamere[$apartament->NumarCamere]=1;
	//$zoneSelectate=
	$subZonaChecked[$subzona->id]=1;
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
</head>
<body>
<div id="DetaliiClient" class="view"> 
	<h3 onclick="showHide1('extraClient')" onmouseover="this.style.cursor='pointer'">Detalii client  -  extinde ...</h3>
	<table>
		<tr>
			<td class="label">Nume client:</td>
			<td><?php echo $client->full_name(); ?></td>
		</tr>
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
	</table>
	<div id="extraClient">
		<table>
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

<div id="Zone" class="view"> 
	<h3>Detalii apartament</h3>
	<table>
		<tr>
			<td class="label">Zone:</td>
			<td>
				<?php 
				$zone="";
				if (strlen($cerere->Zona)>0){
					$zoneList=explode(",",$cerere->Zona);
					foreach ($zoneList as $idZona){
						$zona=Subzona::find_by_id($idZona);
						if ($zone!="") {$zone.=", {$zona->Denumire}";}
						else {$zone=$zona->Denumire;}
					}
				}
				echo $zone;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Tip proprietate:</td>
			<td><?php 
				$tmp="";
				if (strlen($cerere->TipProprietate)>0){
					$tmplist=explode(",",$cerere->TipProprietate);
					foreach ($tmplist as $tmpx){
						if ($tmpx==1) {$tmpx="apartament";}
						if ($tmpx==2) {$tmpx="ap. in vila";}
						if ($tmpx==3) {$tmpx="casa";}
						if ($tmpx==4) {$tmpx="teren";}
						if ($tmp!="") {$tmp.=", ".($tmpx==1?"garsoniera":$tmpx);}
						else {$tmp=$tmpx;} 
					}
				}
				echo $tmp;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Camere:</td>
			<td><?php 
				$tmp="";
				if (strlen($cerere->NumarCamere)>0){
					$tmplist=explode(",",$cerere->NumarCamere);
					foreach ($tmplist as $tmpx){
						if ($tmp!="") {$tmp.=", ".($tmpx==1?"garsoniera":$tmpx);}
						else {$tmp=($tmpx==1?"garsoniera":$tmpx);}
					}
				}
				echo $tmp;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Confort:</td>
			<td>
			<?php 
				$tmp="";
				if (strlen($cerere->Confort)>0){
					$tmplist=explode(",",$cerere->Confort);
					foreach ($tmplist as $tmpx){
						if ($tmp!="") {$tmp.=", ".($tmpx==1?"confort I":"confort II");}
						else {$tmp=($tmpx==1?"confort I":"confort II");}
					}
				}
				echo $tmp;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Tip apartament:</td>
			<td>
				<?php 
				$tmp="";
				if (strlen($cerere->TipApartament)>0){
					$tmplist=explode(",",$cerere->TipApartament);
					foreach ($tmplist as $tmpx){
						if ($tmp!="") {$tmp.=", ".$tmpx;}
						else {$tmp=$tmpx;}
					}
				}
				echo $tmp;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">Etaj:</td>
			<td><?php echo ($cerere->EtajMinim>0 ? $cerere->EtajMinim : "P")." -> ".($cerere->EtajMaxim ? $cerere->EtajMaxim : "-");?></td>
		</tr>
		<tr>
			<td class="label">Etaje bloc:</td>
			<td><?php echo ($cerere->EtajeBlocMin>0 ? $cerere->EtajeBlocMin : "P")." -> ".($cerere->EtajeBlocMax ? $cerere->EtajeBlocMax : "-");?></td>
		</tr>
		<tr>
			<td class="label">Pozitionare:</td>
			<td>
				<?php 
				$tmp="";
				if ($cerere->Parter==1) {$tmp.=($tmp==""?"":", ")."parter";}
				if ($cerere->EtajIntermediar==1) {$tmp.=($tmp==""?"":", ")."etaj intermediar";}
				if ($cerere->UltimulEtaj==1) {$tmp.=($tmp==""?"":", ")."ultimul etaj";}
				echo $tmp;
				?>
			</td>
		</tr>
		<tr>
			<td class="label">An constructie min:</td>
			<td><?php if ($cerere->AnConstructie>0) {echo $cerere->AnConstructie;}?></td>
		</tr>
	</table>
</div>

<div id="DetaliiCerere" class="view"> 
	<h3>Detalii cerere</h3>
	<table>
		<tr>
			<td class="label">Tip cerere:</td>
			<td><?php echo ($cerere->Inchiriere==1?"inchiriere":"cumparare");?></td>
		</tr>
		<tr>
			<td class="label">Buget:</td>
			<td><?php echo $cerere->Buget." ".$cerere->Moneda.($cerere->Credit==1?", credit":"");?></td>
		</tr>
		<tr>
			<td class="label">Detalii:</td>
			<td><?php echo $cerere->Detalii;?></td>
		</tr>
		<tr>
			<td class="label">Data creare:</td>
			<td><?php echo $cerere->DataCreare;?></td>
		</tr>
		<tr>
			<td class="label">Data actualizare:</td>
			<td><?php echo $cerere->DataActualizare;?></td>
		</tr>
	</table>
</div>

<div id="Butoane" class="butoane">
	<table  width="100%" cellpadding="0" cellspacing="0">
		<tr>
			<td align="right" >
				<input type="button" id="close" value="Inchide fereastra" onclick="window.close()"></input>
				<input type="button"  id="update" value="Modifica" <?php echo "onclick=document.location=('cerere_update.php?id={$cerere->id}')";?>></input>
			</td>
		</tr>
	</table>
</div>

<div id="Oferte" class="view">
	<h3 onmouseover="this.style.cursor='pointer'" onclick="showHide1('OferteSearchDiv')">Cautare oferte</h3>
	<div id="OferteSearchDiv">
		
		<?php
		if (!isset($_POST['submit'])) {
			$idx="";
			if (strlen($cerere->NumarCamere)>0){
				$tmpArr=explode(",",$cerere->NumarCamere);
				foreach ($tmpArr as $idx){
					if ( $idx!="") {${"NumarCamere"}[$idx]=1;}
				}
			}
			if (strlen($cerere->TipApartament)>0){
				$tmpArr=explode(",",$cerere->TipApartament);
				foreach ($tmpArr as $idx){
					if ( $idx=="Decomandat") {${"TipApartament"}[1]=1;}
					if ( $idx=="Semidecomandat") {${"TipApartament"}[2]=1;}
					if ( $idx=="Comandat") {${"TipApartament"}[3]=1;}
					if ( $idx=="Circular") {${"TipApartament"}[4]=1;}
					if ( $idx=="Duplex") {${"TipApartament"}[5]=1;}
				}
			}
			if ($cerere->EtajMinim>0) {$EtajMin=$cerere->EtajMinim;}
			if ($cerere->EtajMaxim>0) {$EtajMax=$cerere->EtajMaxim;}
			if ($cerere->EtajeBlocMin>0) {$EtajeBlocMin=$cerere->EtajeBlocMin;}
			if ($cerere->EtajeBlocMax>0) {$EtajeBlocMax=$cerere->EtajeBlocMax;}
			if ($cerere->AnConstructie>0) {$AnConstructieMin=$cerere->AnConstructie;}
			if ($cerere->Cumparare==1) {$tipOferta=1;}
			else {$tipOferta=2;}
			
			if (strlen($cerere->Zona)>0){
				$zoneList=explode(",",$cerere->Zona);
				foreach ($zoneList as $idZona){
					$subZonaChecked[$idZona]=1;
				}
			}
		}
		$curentPage="cerere_view.php";
		require 'oferta_search_engine.php';
		?>
	</div>
</div>

<script>
<?php if (!isset($_POST['submit'])){
	?>
	var itemStyle=document.getElementById('OferteSearchDiv').style;
	itemStyle.display="none";
<?php }?>var itemStyle2=document.getElementById('zoneTree').style;
	itemStyle2.display="none";
</script>

</body>
</html>