<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$telefon="";
//if (isset($_POST['telefon'])) {$telefon=trim($_POST['telefon']);}

if (isset($_GET['telefon'])){
	$telefon=$_GET['telefon'];
} else {
	if (isset($_POST['submit'])) {
		$telefon=trim($_POST['telefon']);
		$telefon=strip_digits($telefon);
	}
}

function put_item($var,$label) {
	if ($var=="") {return "";}
	else {
		$item="<tr><td class='label'>".$label.":</td>";
		$item=$item."<td>".$var."</td></tr>";
		return $item;
	}
	return "";
}
?> 

<?php //include_layout_template('admin_header.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Verificare telefon</title>
	
	<script type="text/javascript" src=".././javascripts/jquery-1.3.2.js"></script>
	
	<link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<script type="text/javascript" src=".././javascripts/thickbox.js"></script>

	<script type="text/javascript"> 
	<!--
	function clientView(id){
		document.location = "client_view.php?id=" + id;
	}
	function ofertaNew(id){
		document.location = ("oferta_new.php?id=" + id);
		//window.open("oferta_new.php?id=" + id,"oferta_new","toolbar=0,resizable=1,scrollbars=1");
	}
	function ofertaView(id){
		//document.location = ("client_view.php?id=" + id);
		//window.open("oferta_view.php?id=" + id,"oferta_view","toolbar=0,resizable=1,scrollbars=1,width=1024");
		window.open("oferta_view.php?id=" + id,"oferta_view","width=1046,height=742,toolbar=0,resizable=1,scrollbars=1");
	}
	function cerereNew(id){
		document.location = ("cerere_new.php?id=" + id);
		//window.open("cerere_new.php?id=" + id,"cerere_new","toolbar=0,resizable=1,scrollbars=1");
	}
	function cerereView(id){
		//document.location = ("client_view.php?id=" + id);
		window.open("cerere_view.php?id=" + id,"cerere_view","width=1046,height=742,toolbar=0,resizable=1,scrollbars=1");
	}
	function addClient(tel){
		document.location = ("client_new.php?tel=" + tel);
		//window.open("client_new.php?tel=" + tel,"client_new","toolbar=0,resizable=1,scrollbars=1");
	}
	
	function onOver(id,over,row){
		var changed = document.getElementById(id);
		if (over == 1) changed.className='deasupra';
		else {
			if (row%2) changed.className='impar';
			else changed.className='par';
		}
	}
	
	function showHide(item){
		var itemStyle=document.getElementById(item).style;
		if (itemStyle.display!="none") {
			itemStyle.display="none";
		}
		else {
			itemStyle.display="block";
		}
	}
	//-->
	</script> 
</head>
<body>
<?php 
	
?>

<?php require_once(".././include/head.php");?>
<form action="check_client.php" method="post">
		<div class="view" align="center" >
		<h3>Cautare dupa numar de telefon</h3>
    	<table>
    		<tr>
    			<td></td>
    		</tr>
        	<tr>
            	<td>Telefon: </td>
                <td><input type="text" name="telefon" maxlength="30" value="<?php echo htmlentities($telefon); ?>" /></td>
                <td><input type="submit" name="submit" value="Cauta client" /></td>
            </tr>
		</table>
		</div>
		<div class="butoane" align="right">
			<table cellpadding="0" cellspacing="0" width='100%'>
				<tr>
					<td align="right"> </td>
				</tr>
			</table>
		</div>
</form>


<?php 
if ((isset($_POST['submit']))||(isset($_GET['telefon']))) {
	if ($telefon!="") {
		$client=new Client();
		$sql="SELECT * FROM Client WHERE TelefonMobil='{$telefon}' ";
		$sql=$sql."OR TelefonFix='{$telefon}' OR TelefonServici='{$telefon}' OR TelefonFax='{$telefon}' ";
		$clientList=Client::find_by_sql($sql);
		if (!empty($clientList)) {
			$client=array_shift($clientList);
			$agent=User::find_by_id($client->idUtilizator);
			?>
			<div id="DetaliiClient" class="view" onclick="showHide('RandDetalii');" style="cursor:pointer;">
				<h3>Detalii client</h3>
				<table cellspacing="" cellpadding="">
					<?php echo put_item($client->full_name(),"Nume");?>
					<?php echo put_item($client->TelefonMobil,"Telefon 1");?>
					<?php echo put_item($client->TelefonFix,"Telefon 2");?>
					<?php echo put_item($client->TelefonServici,"Telefon 3");?>
					<?php echo put_item($client->TelefonFax,"Telefon 4");?>
					<?php echo put_item($client->Email,"Email");?>
					<?php echo put_item($agent->full_name(),"Agent");?>
					<tr id="RandDetalii">
						<td class="label">Detalii:</td>
						<td><?php echo $client->Detalii;?></td>
					</tr>
				</table>
			</div>
			<script>
				hide("RandDetalii");
			</script>
			<div id="butoane2" class="butoane">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr>
						<td align="left">
							<input type="button" value="Adauga oferta" <?php echo "onclick='ofertaNew(".$client->id.")'";?> />
							<input type="button" value="Adauga cerere" <?php echo "onclick='cerereNew(".$client->id.")'";?> />
						</td>
						<td align="right">
							<input type="button" value="Modifica client" onclick="document.location = ('client_update.php?id=' + <?php echo $client->id;?>)" />
							<input type="button" value="Detalii client" <?php echo "onclick='clientView(".$client->id.")'";?> />
						</td>
					</tr>
				</table>
			</div>
			<?php 
			$sql="SELECT * FROM Apartament WHERE idClient='{$client->id}'";
			$apList=Apartament::find_by_sql($sql);
			if (!empty($apList)) {
			?>
				<div id="oferte" class="view">
					<h3 onclick="showHide('listaOferte')" onmouseover="this.style.cursor='pointer'">Oferte ale clientului</h3>
					<table width="100%" id="listaOferte">
						<tr >
							<td class="header" width="5%" align="center">Cod</td>
							<td class="header" width="10%" align="center">Camere</td>
							<td class="header" width="70%">Detalii</td>
							<td class="header" width="10%" align="center">Pret</td>
							<td class="header" width="5%" align="center">Foto</td>
						</tr>
						<?php 
							$i=0;
							foreach ($apList as $apartament) {
								$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin LIMIT 1";
								$fotos=Foto::find_by_sql($sql);
								$sql="SELECT * FROM Oferta WHERE idApartament='{$apartament->id}'";
								$ofertaList=Oferta::find_by_sql($sql);
								$strada=Strada::find_by_id($apartament->idStrada);
								if (!empty($ofertaList)) {
									foreach ($ofertaList as $oferta) {
										$i++;
										$class=$i%2 ? "impar" : "par";
						?>
						<tr id="<?php echo $oferta->id;?>" class="<?php echo $class;?>" style="font-weight: bold;" onmouseover="this.style.cursor='pointer';onOver(<?php echo $oferta->id;?>,1,<?php echo $i;?>)" onmouseout="onOver(<?php echo $oferta->id;?>,0,<?php echo $i;?>)" ondblclick="ofertaView(<?php echo $oferta->id;?>)">
							<td align="center"><?php echo $apartament->id;?></td>
							<td align="center"><?php if ($apartament->NumarCamere>1) {echo $apartament->NumarCamere." camere";} else { echo "Garsoniera";}?></td>
							<td><?php 
								echo $strada->Denumire.", Nr. ".$apartament->Numar.", Et. ".$apartament->Etaj."/".$apartament->EtajeBloc;
								echo ", ".$apartament->TipApartament.", Confort ".$apartament->Confort;							
								?> 
							</td>
							<td align="right" style="pading-right:3px;"><?php echo $oferta->Pret." ".$oferta->Moneda;?></td>
							<td align="center">
								<?php if (!empty($fotos)){ ?>
								<a id="FotoPreviewA" href="<?php echo "..".DS.$fotos[0]->image_path(); ?>" title="<?php echo $fotos[0]->Detalii;?>" class="thickbox"><img id="FotoPreviewI" src="<?php echo "..".DS.$fotos[0]->image_path();?>" alt="Foto 1" height="30" /></a> 
								<?php }
									else {?> 
								<img src="<?php echo "..".DS."images".DS."noimage.jpg";?>" height="30" ></img>
								<?php }?>
							</td>
						</tr>
						<?php
									}
								} 
							}?>
					</table>
				</div>
			<?php 
			}
			$sql="SELECT * FROM Cerere WHERE idClient='{$client->id}'";
			$cerereList=Cerere::find_by_sql($sql);
			if (!empty($cerereList)) {
				$i=0;
				?>
				<br></br>
				<div id="cereri" class="view" >
					<h3 onclick="showHide('listaCereri')" onmouseover="this.style.cursor='pointer'">Cereri ale clientului</h3>
					<table width="100%" id="listaCereri">
						<tr >
							<td class="header" width="5%">Cod</td>
							<td class="header" width="15%">Client</td>
							<td class="header" width="10%">Telefon</td>
							<td class="header" width="5%">Tip proprietate</td>
							<td class="header" width="5%">Camere</td>
							<td class="header" width="10%">Tip ap.</td>
							<td class="header" width="5%">Etaje</td>
							<td class="header" width="30%">Zone</td>
							<td class="header" width="10%">Buget</td>
							<td class="header" width="5%">Plata</td>
						</tr>
				<?php
					$i=0;
					foreach($cerereList as $cerere){
						
						$client=Client::find_by_id($cerere->idClient);
						$zoneIdList=explode(",",$cerere->Zona);
						$cerere->NumarCamere=substr($cerere->NumarCamere,1,-1);
						$cerere->Zona=substr($cerere->Zona,1,-1);
						$cerere->TipApartament=substr($cerere->TipApartament,1,-1);
						
						$TipProprietateList="";
						if (strlen($cerere->TipProprietate)>0){
							$tmplist=explode(",",substr($cerere->TipProprietate,1,-1));
							foreach ($tmplist as $tmpx){
								if ($tmpx==1) {$tmpx="apartament";}
								if ($tmpx==2) {$tmpx="ap. in vila";}
								if ($tmpx==3) {$tmpx="casa";}
								if ($tmpx==4) {$tmpx="teren";}
								if ($TipProprietateList!="") {$TipProprietateList.=", ".($tmpx==1?"garsoniera":$tmpx);}
								else {$TipProprietateList=$tmpx;} 
							}
						}
						$i=$i+1;
						$class=$i%2 ? "impar" : "par";	
						echo "<tr id='".$cerere->id."' class='".$class."' ondblclick=cerereView(".$cerere->id.") onmouseover=this.style.cursor='pointer';onOver(".$cerere->id.",1,".$i.") onmouseout=onOver(".$cerere->id.",0,".$i.") style=\"height:30px;font-weight:bold;\">";
						echo "<td>".$cerere->id."</td>";
						echo "<td>".$client->full_name()."</td>";
						echo "<td>".$client->TelefonMobil."</td>";
						echo "<td>".$TipProprietateList."</td>";
						echo "<td align=\"center\">".$cerere->NumarCamere."</td>";
						echo "<td>".$cerere->TipApartament."</td>";
						echo "<td>".($cerere->EtajMinim>0 ? $cerere->EtajMinim : "P")." -> ".($cerere->EtajMaxim ? $cerere->EtajMaxim : "-")."</td>";
						echo "<td>";
						foreach($zoneIdList as $zonaId){
							if ($zonaId!=""){
								$zona=Subzona::find_by_id($zonaId);
								echo $zona->Denumire.",";
							}
						}
						echo "</td>";
						echo "<td align=\"right\">".$cerere->Buget." ".$cerere->Moneda."</td>";
						echo "<td>".($cerere->Credit==1?"credit":"cash")."</td>";
						echo "</tr>";
					}
				?>
					</table>
				</div>
			<?php 	
			}
		}
		else { ?>
			<div id="butoane3" class="butoane">
				<table width="100%" cellpadding="0" cellspacing="0">
					<tr >
						<td width="56%" align="right"><p class="attention">Nu am gasit nici un client&nbsp;&nbsp;&nbsp;</p></td>
						<td width="44%" align="left">
							<input type="button" onclick="addClient('<?php echo htmlentities($telefon); ?>')" value="Adauga client"/>
						</td>
						
					</tr>
				</table>
			</div>
		<?php 
		}
	}
	else {
		?>
		<div  class="butoane">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr align="center">
					<td><p class="attention">Numarul de telefon este gol!</p></td>
				</tr>
			</table>
		</div>
		<?php 
	}
}

?>
</body>
</html>
