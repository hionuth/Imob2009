<?php
function build_query_list($var,$field,$file="X") {
	$sqltmp="";
	$file=$file.".";
	foreach($var as $chk){
		if ($sqltmp=="") {$sqltmp=$file.$field." LIKE '%{$chk}%' ";}
		else {$sqltmp=$sqltmp."OR ".$file.$field." LIKE '%{$chk}%' ";}
	}
	return $sqltmp;
}
function build_query_field($var,$field,$file="X") {
	$sqltmp="";
	$file=$file.".";
	$sqltmp=$file.$field."='{$var}' ";
	return $sqltmp;
}
function build_query($var,$field,$file="X") {
	$sqltmp="";
	foreach($var as $chk){
		if ($sqltmp=="") {$sqltmp="{$file}.{$field}='{$chk}' ";}
		else {$sqltmp=$sqltmp."OR {$file}.{$field}='{$chk}' ";}
	}
	return $sqltmp;
}
function build_query_zone($var,$field,$file="X") {
	$sqltmp="";
	foreach($var as $chk){
		if ($sqltmp=="") {$sqltmp="{$file}.{$field} LIKE '%,{$chk},%' ";}
		else {$sqltmp=$sqltmp."OR {$file}.{$field} LIKE '%,{$chk},%' ";}
	}
	return $sqltmp;
}
?>

<h3>Cerere - cautare</h3>
<form action="<?php echo $curentPage;?>" method="post" id="searchForm">
	<input type="hidden" name="idOferta" value="<?php if (isset($idOferta)) {echo $idOferta;}?>"></input>
<div id="Filtre" class="view" >
	<h3>Optiuni cautare</h3>
	<table>
		<tr>
			<td class="impar" width="120px">Tip proprietate:</td>
			<td class="par" width="120px">Tip cerere:</td>
			<td class="impar" width="120px">Camere:</td>
			<td class="par" width="120px">Buget:</td>
			<td class="impar" width="120px">Pozitie:</td>
			<td class="par" width="150px">Etaj:</td>
			<td class="impar" width="180px">Client:</td>
			<td class="par" width="120px">Agent:</td>
			<td class="impar" width="120px">Stare:</td>
		</tr>
		<tr>
			<td valign="top" class="impar">
				<input type="checkbox" class="impar" name="TipProprietate[1]" value="Apartament" <?php if (isset($TipProprietate[1])) {echo "Checked";}?> />Apartament<br/>
				<input type="checkbox" class="impar" name="TipProprietate[2]" value="Apartament in vila" <?php if (isset($TipProprietate[2])) {echo "Checked";}?>/>Ap. in vila<br/>
				<input type="checkbox" class="impar" name="TipProprietate[3]" value="Casa" <?php if (isset($TipProprietate[3])) {echo "Checked";}?>/>Casa<br/>
				<input type="checkbox" class="impar" name="TipProprietate[4]" value="Teren" <?php if (isset($TipProprietate[4])) {echo "Checked";}?>/>Teren<br/>
			</td>
			<td valign="top" class="par">
				<input type="checkbox" class="par" name="Cumparare" value="1" <?php if (isset($Cumparare)) {echo "Checked";}?> />Cumparare<br/>
				<input type="checkbox" class="par" name="Inchiriere" value="1" <?php if (isset($Inchiriere)) {echo "Checked";}?>/>Inchiriere<br/>
			</td>
			<td valign="top" class="impar">
				<input type="checkbox" class="impar" name="NumarCamere[1]" value=1 <?php if (isset($NumarCamere[1])) {echo "Checked";}?> />Garsoniera<br/>
				<input type="checkbox" class="impar" name="NumarCamere[2]" value=2 <?php if (isset($NumarCamere[2])) {echo "Checked";}?>/>2 camere<br/>
				<input type="checkbox" class="impar" name="NumarCamere[3]" value=3 <?php if (isset($NumarCamere[3])) {echo "Checked";}?>/>3 camere<br/>
				<input type="checkbox" class="impar" name="NumarCamere[4]" value=4 <?php if (isset($NumarCamere[4])) {echo "Checked";}?>/>4 camere<br/>
				<input type="checkbox" class="impar" name="NumarCamere[5]" value=5 <?php if (isset($NumarCamere[5])) {echo "Checked";}?>/>5 camere<br/>
			</td>
			<td valign="top" class="par">
				<input type="text" name="Buget" size="10" value="<?php if (isset($Buget)) {echo htmlentities($Buget);}?>"/><br/>
				<input type="checkbox" class="par" name="Credit" value=1 <?php if (isset($Credit)) {echo "Checked";}?> />Credit<br/>
				<input type="checkbox" class="par" name="Cash" value=1 <?php if (isset($Cash)) {echo "Checked";}?> />Cash<br/>
			</td>
			<td valign="top" class="impar">
				<input type="checkbox" class="impar" name="Parter" value="1" <?php if (isset($Parter)) {echo "Checked";}?> />Parter<br/>
				<input type="checkbox" class="impar" name="EtajIntermediar" value="1" <?php if (isset($EtajIntermediar)) {echo "Checked";}?> />Etaj intermediar<br/>
				<input type="checkbox" class="impar" name="UltimulEtaj" value="1" <?php if (isset($UltimulEtaj)) {echo "Checked";}?> />Ultimul etaj<br/>
			</td>
			<td valign="top" class="par">
				<table border="0" >
					<tr>
						<td>Etaje:</td>
						<td>
							<select name="EtajMinim">
								<option value='' selected> </option>
								<option value='0' <?php if (isset($EtajMinim)){if ($EtajMinim=='0') { echo " selected=\"selected\" "; }}?>>P</option>
								<?php 
									for ($i = 1; $i < 25; $i++) {
										echo "<option value='".$i."'";
										if (isset($EtajMinim)){
											if ($EtajMinim==$i) { echo " selected=\"selected\" "; }
										}
										echo ">".$i."</option>";
									}
								?>
							</select> - 
							<select name="EtajMaxim">
								<option value='' selected> </option>
								<option value='0' <?php if (isset($EtajMaxim)){if ($EtajMaxim=='0') { echo " selected=\"selected\" "; }}?>>P</option>
								<?php 
									for ($i = 1; $i < 25; $i++) {
										echo "<option value='".$i."'";
										if (isset($EtajMaxim)){
											if ($EtajMaxim==$i) { echo " selected=\"selected\" "; }
										}
										echo ">".$i."</option>";
									}
								?>
							</select>
						</td>
					</tr>
					<tr>
						<td>Bloc:</td>
						<td>
							<select name="EtajeBlocMin">
								<option value='' selected> </option>
								<option value='0' <?php if (isset($EtajeBlocMin)){if ($EtajeBlocMin=='0') { echo " selected=\"selected\" "; }}?>>P</option>
								<?php 
									for ($i = 1; $i < 25; $i++) {
										echo "<option value='".$i."'";
										if (isset($EtajeBlocMin)){
											if ($EtajeBlocMin==$i) { echo " selected=\"selected\" "; }
										}
										echo ">".$i."</option>";
									}
								?>
							</select> - 
							<select name="EtajeBlocMax">
								<option value='' selected> </option>
								<option value='0' <?php if (isset($EtajeBlocMax)){if ($EtajeBlocMax=='0') { echo " selected=\"selected\" "; }}?>>P</option>
								<?php 
									for ($i = 1; $i < 25; $i++) {
										echo "<option value='".$i."'";
										if (isset($EtajeBlocMax)){
											if ($EtajeBlocMax==$i) { echo " selected=\"selected\" "; }
										}
										echo ">".$i."</option>";
									}
								?>
							</select>
						</td>
					</tr>
				</table>
			</td>
			<td valign="top" class="impar">
				<table>
					<tr>
						<td>Nume:</td>
						<td><input type="text" name="ClientNume" size="15" value="<?php if (isset($ClientNume)) {echo htmlentities($ClientNume);}?>"/></td>
					</tr>
					<tr>
						<td>Cod:</td>
						<td><input type="text" name="ClientCod" size="10" value="<?php if (isset($ClientCod)) {echo htmlentities($ClientCod);}?>"/></td>
					</tr>
				</table>
			</td>
			<td valign="top" class="par" align="center">
				<select name="Agent">
					<option value='' selected> </option>
					<?php 
					$userlist=User::find_all();
					foreach ($userlist as $agent1) {
						echo "<option ";
						if (isset($Agent)) {
							if ($agent1->id==$Agent) {echo "selected='selected'";}
						}
						echo "value='".$agent1->id."'>".$agent1->full_name();								
						echo "</option>";
					}
					?>
				</select>
			</td>
			<td valign="top" class="impar" align="center">
				<select name='Stare'>
					<option value='' <?php if (isset($Stare)) {if ($Stare=="") {echo "selected=\"selected\"";}}?>></option>
					<option value="de actualitate" <?php if (isset($Stare)) {if ($Stare=="de actualitate") {echo "selected";}} else {echo "selected=\"selected\"";}?>>de actualitate</option>
					<option value="vandut de noi" <?php if (isset($Stare)) { if ($Stare=="vandut de noi") {echo "selected";}}?>>vandut de noi</option>
					<option value="vandut de altii" <?php if (isset($Stare)) { if ($Stare=="vandut de altii") {echo "selected";}}?>>vandut de altii</option>
					<option value="stand by" <?php if (isset($Stare)) { if ($Stare=="stand by") {echo "selected";}}?>>stand by</option>
				</select>
			</td>
		</tr>
	</table>
</div>

<?php include 'zone_tree.php';?>

<div id="butoane" class="butoane" >
	<input type='submit' name='submit' id='submit' value='Cauta'>
	<input type='button' name='reset' id='reset' value='Reseteaza' onClick="document.location='<?php echo $curentPage.(isset($idOferta)?"?id=".$idOferta:"");?>';"/>
</div>

<script type="text/javascript"> 
<!--
	//hide("zoneTree");
//-->
</script>

</form>
<?php 
if (isset($_POST['submit'])) {
	$sql="SELECT * FROM Utilizator AS U INNER JOIN (Client AS C INNER JOIN Cerere AS X ON C.id=X.idClient) ON U.id=C.idUtilizator WHERE 1 ";
	
	if (isset($Inchiriere)||(isset($Cumparare))){
		$sqltmp="AND (0";
		if (isset($Inchiriere)){ $sqltmp.=" OR X.Inchiriere='1'";} 
		if (isset($Cumparare)) {$sqltmp.=" OR X.Cumparare='1'";}
		$sql.=$sqltmp.") ";
	}
	if (isset($NumarCamere)) {$sql.="AND (".build_query_list($NumarCamere,"NumarCamere").") ";}
	if ((isset($Cash))||(isset($Credit))) {
		if ((isset($Cash))&&(!isset($Credit))) { $sql.="AND X.Credit<>1 ";}
		if ((!isset($Cash))&&(isset($Credit))) { $sql.="AND X.Credit=1 ";}
	}
	if ($Buget>0) {$sql.="AND X.Buget<={$Buget} "; }
	if (isset($Parter)||isset($EtajIntermediar)||isset($UltimulEtaj)) {
		$sqltmp="AND (0 ";
		if (isset($Parter)){ $sqltmp.="OR X.Parter='1'";}
		if (isset($EtajIntermediar)){ $sqltmp.="OR X.EtajIntermediar='1' ";}
		if (isset($UltimulEtaj)){ $sqltmp.="OR X.UltimulEtaj='1' ";}
		$sql.=$sqltmp.") ";
	}
	if (($EtajMinim!="")||($EtajMaxim!=""))	{
		if (($EtajMinim!="")&&($EtajMaxim!="")) { $sql.="AND X.EtajMinim<={$EtajMinim} AND X.EtajMaxim>={$EtajMaxim} ";}
		else {
			$sqltmp="AND (0";
			if ($EtajMinim!="") { $sqltmp.=" OR X.EtajMinim<=".$EtajMinim;}
			if ($EtajMaxim!="") { $sqltmp.=" OR X.EtajMaxim>=".$EtajMaxim;}
			$sql.=$sqltmp.") ";
		}
	}
	if (($EtajeBlocMin!="")||($EtajeBlocMax!=""))	{
		if (($EtajeBlocMin!="")&&($EtajeBlocMax!="")) { $sql.="AND X.EtajeBlocMin<={$EtajeBlocMin} AND X.EtajeBlocMax>={$EtajeBlocMax} ";}
		else {
			$sqltmp="AND (0";
			if ($EtajeBlocMin!="") { $sqltmp.=" OR X.EtajMinim<=".$EtajeBlocMin;}
			if ($EtajeBlocMax!="") { $sqltmp.=" OR X.EtajMaxim>=".$EtajeBlocMax;}
			$sql.=$sqltmp.") ";
		}
	}
	if ($ClientNume!="") { $sql.="AND ((C.Nume LIKE '%{$ClientNume}%') OR (C.Prenume LIKE '%{$ClientNume}%')) ";}
	if ($ClientCod!="") {$sql.="AND C.id='{$ClientCod}' ";}
	if ($Agent!="") {$sql.="AND U.id='{$Agent}' ";}
	if ($Stare!="") {$sql.="AND X.Stare='{$Stare}' ";}
	if (isset($subZonaChecked)){$sql=$sql."AND (".build_query_zone($subZonaChecked,"Zona").") ";}
	$sql.="ORDER BY X.DataCreare DESC ";
	$cerereList=Cerere::find_by_sql($sql);
	if (!empty($cerereList)){
	?>
		<div id="oferte" class="view">
			<h3>Cereri gasite</h3>
			<table width="100%">
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
			echo "<td align=\"center\">".substr($cerere->NumarCamere,1,-1)."</td>";
			echo "<td>".substr($cerere->TipApartament,1,-1)."</td>";
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
?>