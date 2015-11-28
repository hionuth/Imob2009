<?php
function build_query($var,$field) {
	$sqltmp="";
	foreach($var as $chk){
		if ($sqltmp=="") {$sqltmp="A.".$field."='".$chk."' ";}
		else {$sqltmp=$sqltmp."OR A.".$field."='".$chk."' ";}
	}
	return $sqltmp;
}
function build_queryO($var,$field) {
	$sqltmp="";
	foreach($var as $chk){
		if ($sqltmp=="") {$sqltmp="O.".$field."='".$chk."' ";}
		else {$sqltmp=$sqltmp."OR O.".$field."='".$chk."' ";}
	}
	return $sqltmp;
}
if (!isset($_POST['submit'])){
	$tipOferta=1;
	$tipSortareActualizare=1;
	$Stare[1]="de actualitate";
}
date_default_timezone_set ("Europe/Bucharest");
?>
<form action="<?php echo $curentPage;?>" method="post" id="searchForm">
	<input type="hidden" name="idCerere" value="<?php if (isset($idCerere)) {echo $idCerere;}?>"></input>
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="submit" name="submit" value="cauta"/>
		<input type="button" name="reset" value="reset" onclick="document.location = 'oferta_search.php';"/>
	</div>
	
	<div id="filtru" class="ui-widget-content ui-corner-all" style="margin-top: 5px;">
		
		<table style="width:100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">tip proprietate</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">camere</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">tip apartament</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">pozitie etaj</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">etaj</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">an constructie</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px" >pret</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">tip oferta</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">cod / strada</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">agent</td>
			</tr>
			<tr style="vertical-align: top">
				<td class="odd">
					<input type="checkbox" class="standard" name="TipProprietate[1]" value="0" <?php if (isset($TipProprietate[1])) {echo "Checked";}?> ></input><label>apartament</label><br/>
					<input type="checkbox" class="standard" name="TipProprietate[2]" value="1" <?php if (isset($TipProprietate[2])) {echo "Checked";}?>></input><label>ap in vila</label><br/>
					<input type="checkbox" class="standard" name="TipProprietate[3]" value="2" <?php if (isset($TipProprietate[3])) {echo "Checked";}?>></input><label>casa/vila</label><br/>
					<input type="checkbox" class="standard" name="TipProprietate[4]" value="3" <?php if (isset($TipProprietate[4])) {echo "Checked";}?>></input><label>teren</label><br/>
					<input type="checkbox" class="standard" name="TipProprietate[5]" value="4" <?php if (isset($TipProprietate[5])) {echo "Checked";}?>></input><label>spatiu</label>
				</td>
				<td class="even">
					<input type="checkbox" class="standard" name="NumarCamere[1]" value="1" <?php if (isset($NumarCamere[1])) {echo "Checked";}?>></input><label>garsoniera</label><br/>
					<input type="checkbox" class="standard" name="NumarCamere[2]" value="2" <?php if (isset($NumarCamere[2])) {echo "Checked";}?>></input><label>2 camere</label><br/>
					<input type="checkbox" class="standard" name="NumarCamere[3]" value="3" <?php if (isset($NumarCamere[3])) {echo "Checked";}?>></input><label>3 camere</label><br/>
					<input type="checkbox" class="standard" name="NumarCamere[4]" value="4" <?php if (isset($NumarCamere[4])) {echo "Checked";}?>></input><label>4 camere</label><br/>
					<input type="checkbox" class="standard" name="NumarCamere[5]" value="5" <?php if (isset($NumarCamere[5])) {echo "Checked";}?>></input><label>5 camere</label>
				</td>
				<td class="odd">
					<input type="checkbox" class="standard" name="TipApartament[1]" value="Decomandat" <?php if (isset($TipApartament[1])) {echo "Checked";}?>></input><label>decomandat</label><br/>
					<input type="checkbox" class="standard" name="TipApartament[2]" value="Semidecomandat" <?php if (isset($TipApartament[2])) {echo "Checked";}?>></input><label>semidecom.</label><br/>
					<input type="checkbox" class="standard" name="TipApartament[3]" value="Comandat" <?php if (isset($TipApartament[3])) {echo "Checked";}?>></input><label>comandat</label><br/>
					<input type="checkbox" class="standard" name="TipApartament[4]" value="Circular" <?php if (isset($TipApartament[4])) {echo "Checked";}?>></input><label>circular</label><br/>
					<input type="checkbox" class="standard" name="TipApartament[5]" value="Duplex" <?php if (isset($TipApartament[5])) {echo "Checked";}?>></input><label>duplex</label><br/>
					
				</td>
				<td class="even">
					<input type="checkbox" class="standard" name="Pozitie[1]" value="0" <?php if (isset($Pozitie[1])) {echo "Checked";}?>></input><label>parter</label><br/>
					<input type="checkbox" class="standard" name="Pozitie[2]" value="1" <?php if (isset($Pozitie[2])) {echo "Checked";}?>></input><label>intermediar</label><br/>
					<input type="checkbox" class="standard" name="Pozitie[3]" value="2" <?php if (isset($Pozitie[3])) {echo "Checked";}?>></input><label>ultimul</label><br/>
				</td>
				<td class="odd">
					etaj:<br/>
					<div style="text-align: center">
						<select name="EtajMin">
							<option value="" selected="selected">min</option>
							<option value="0" <?php if (isset($EtajMin)){if ($EtajMin=='0') { echo " selected=\"selected\" "; }}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value=\"".$i."\"";
									if (isset($EtajMin)){
										if ($EtajMin==$i) { echo " selected=\"selected\" "; }
									}
									echo ">".$i."</option>";
								}
							?>
						</select> - 
						<select name="EtajMax">
							<option value="" selected="selected">max</option>
							<option value='0' <?php if (isset($EtajMax)){if ($EtajMax=='0') { echo " selected=\"selected\" "; }}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if (isset($EtajMax)){
										if ($EtajMax==$i) { echo " selected=\"selected\" "; }
									}
									echo ">".$i."</option>";
								}
							?>
						</select>
					</div>
					<br/>
					<br/>
					etaje bloc: <br/>
					<div style="text-align: center">
						<select name="EtajeBlocMin">
							<option value="" selected="selected">min</option>
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
							<option value="" selected="selected">max</option>
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
					</div>
				</td>
				<td class="even">
					<div style="text-align: center">
						min - max <br/>
						<input name="AnConstructieMin" class="standard" value="<?php if (isset($AnConstructieMin)) {echo htmlentities($AnConstructieMin);}?>" style="width: 40px;"></input> - 
						<input name="AnConstructieMax" class="standard" value="<?php if (isset($AnConstructieMax)) {echo htmlentities($AnConstructieMax);}?>" style="width: 40px;"></input>
					</div>
				</td>
				<td class="odd">
					<div style="text-align: center">
						min - max <br/>
						<input class="standard" name="PretMin" style="width: 40px;" value="<?php if (isset($PretMin)) {echo htmlentities($PretMin);}?>"/> - 
						<input class="standard" name="PretMax" style="width: 40px;" value="<?php if (isset($PretMax)) {echo htmlentities($PretMax);}?>"/><br />
						
					</div>
					
				</td>
				<td class="even">
					<input type="radio" name="tipOferta" value="1" class="par" 
						<?php 
							if (!isset($tipOferta)){echo "checked";}
							else {
								if ($tipOferta==1) {echo "checked";}
							}
						?>/>Vanzare<br/>
					<input type="radio" name="tipOferta" value="2" class="par" 
						<?php 
							if (isset($tipOferta)) {
								if ($tipOferta==2) {echo "checked";}
							}
						?>/>Chirie<br/>
				</td>
				<td class="odd">
					<div style="margin-top:15px; text-align: right; padding-right: 5px;">
						cod <input class="standard" name="Cod" style="width: 80px;" value="<?php if (isset($Cod)) {echo $Cod;}?>"/><br/><br/>
						str <input class="standard" id="Strada" name="Strada" onkeyup="showHint(this.value)" style="width: 80px;" value="<?php if (isset($Strada)) {echo $Strada;}?>"></input>
						<div id="divStradaHint" class="hint">
						</div>
					</div>
				</td>
				<td class="even">
					<div style="margin-top:15px; text-align: center;">
						<select name="Agent" style="width: 110px; max-width: 110px;">
							<option value="" selected="selected"> </option>
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
					</div>
				</td>
			</tr>
		</table>
	</div>

	<?php include 'zone_tree.php';?>
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;padding-left:5px; margin: 2px;" onclick="showHide1('filtreExtra')" onmouseover="this.style.cursor='pointer';">extra optiuni </div>
	
	<div id="filtreExtra" class="ui-widget-content ui-corner-all" style="margin-top: 2px;">
		<table>
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">confort</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">stare</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">proprietar</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 120px">sortare</td>
			</tr>
			<tr style="vertical-align: top;" >
				<td class="odd" style="vertical-align: text-bottom;">
					<input type="checkbox" class="impar" name="Confort[1]" value=1 />confort I<br/>
					<input type="checkbox" class="impar" name="Confort[2]" value=2 <?php if (isset($Confort[2])) {echo "Checked";}?>/>confort II<br/>
				</td>
				<td class="even" style="vertical-align: text-bottom;">
					<input type="checkbox" class="par" name="Stare[1]" value="de actualitate" <?php if (isset($Stare[1])) {echo "Checked";}?>/>de actualitate<br/>
					<input type="checkbox" class="par" name="Stare[2]" value="precontract" <?php if (isset($Stare[2])) {echo "Checked";}?>/>precontract<br/>
					<input type="checkbox" class="par" name="Stare[3]" value="vandut de noi" <?php if (isset($Stare[3])) {echo "Checked";}?> />vandut de noi<br/>
					<input type="checkbox" class="par" name="Stare[4]" value="vandut de altii" <?php if (isset($Stare[4])) {echo "Checked";}?> />vandut de altii<br/>
					<input type="checkbox" class="par" name="Stare[5]" value="inchiriat" <?php if (isset($Stare[5])) {echo "Checked";}?> />inchiriat<br/>
					<input type="checkbox" class="par" name="Stare[6]" value="stand by" <?php if (isset($Stare[6])) {echo "Checked";}?> />stand by<br/>
				</td>
				<td class="odd" style="vertical-align: text-bottom; text-align: center;">
					<input type="text" name="Proprietar" style="size: 80px;" value="<?php if (isset($Proprietar)) {echo $Proprietar;}?>"></input>
				</td>
				<td class="even" style="vertical-align: text-bottom;">
					<input type="radio" name="tipSortareActualizare" value="1" class="par" 
						<?php 
							if (!isset($tipSortareActualizare)){echo "checked";}
							else {
								if ($tipSortareActualizare==1) {echo "checked";}
							}
						?>/>actualizare desc<br/>
					<input type="radio" name="tipSortareActualizare" value="2" class="par" 
						<?php 
							if (isset($tipSortareActualizare)) {
								if ($tipSortareActualizare==2) {echo "checked";}
							}
						?>/>actualizare cresc<br/>
					<input type="radio" name="tipSortareActualizare" value="3" class="par" 
						<?php 
							if (isset($tipSortareActualizare)) {
								if ($tipSortareActualizare==3) {echo "checked";}
							}
						?>/>pret crescator<br/>
					<input type="radio" name="tipSortareActualizare" value="4" class="par" 
						<?php 
							if (isset($tipSortareActualizare)) {
								if ($tipSortareActualizare==4) {echo "checked";}
							}
						?>/>pret desc<br/>
				</td>
			</tr>
		</table>
	</div>
</form>



<?php 
if (isset($_POST['submit'])) {
	$oferta=new Oferta();
	
	$sql="SELECT A.NumarCamere, A.Confort, O.id, O.Pret, O.PretChirie, O.Moneda, O.idApartament, O.DataActualizare ";
	//$sql=$sql."FROM Oferta as O INNER JOIN Apartament as A ON O.idApartament=A.id ";
	//$sql.="FROM Utilizator as U INNER JOIN (Strada as S INNER JOIN ((Client as C INNER JOIN Apartament as A ON C.id = A.idClient) INNER JOIN Oferta as O ON A.id = O.idApartament) ON S.id = A.idStrada) ON U.id = C.idUtilizator ";
	$sql.="FROM Utilizator as U INNER JOIN (Strada as S INNER JOIN ((Client as C INNER JOIN Apartament as A ON C.id = A.idClient) INNER JOIN Oferta as O ON A.id = O.idApartament) ON S.id = A.idStrada) ON U.id = C.idUtilizator ";
	$sql=$sql."WHERE 1 ";
	//if (($NumarCamere==0)&&($NumarCamere==0)&&($TipApartament==0)) {$sql=$sql."1";}
	if (isset($TipProprietate)) {$sql=$sql."AND (".build_query($TipProprietate,"TipProprietate").") ";}
	if (isset($NumarCamere)) {$sql=$sql."AND (".build_query($NumarCamere,"NumarCamere").") ";}
	if (isset($Confort)) {$sql=$sql."AND (".build_query($Confort,"Confort").") ";}
	if (isset($TipApartament)) {$sql=$sql."AND (".build_query($TipApartament,"TipApartament").") ";}
	if (isset($Pozitie)){
		$sqltmp="";
		if (isset($Pozitie[1])){
			$sqltmp="(A.Etaj='0' OR A.Etaj='parter') ";
		}
		if (isset($Pozitie[2])){
			if ($sqltmp==""){ $sqltmp="(A.Etaj>0 AND A.Etaj<A.EtajeBloc) ";}
			else { $sqltmp=$sqltmp."OR (A.Etaj>0 AND A.Etaj<A.EtajeBloc) ";}
		}
		if (isset($Pozitie[3])){
			if ($sqltmp==""){ $sqltmp="A.Etaj=A.EtajeBloc";}
			else { $sqltmp=$sqltmp."OR A.Etaj=A.EtajeBloc";}
		}
		$sql=$sql."AND (".$sqltmp.") ";
	}
	if (isset($subZonaChecked)){$sql=$sql."AND (".build_query($subZonaChecked,"idSubzona").") ";}
	if (!isset($Stare)) {$Stare[]="de actualitate";}
	if (isset($Stare)){$sql=$sql."AND (".build_queryO($Stare,"Stare").") ";}
	if (($EtajMin!="")||($EtajMax!=""))	{
		$sqltmp="";
		if (($EtajMin!="")&&($EtajMax!="")) { $sqltmp="A.Etaj>=".$EtajMin." AND A.Etaj<=".$EtajMax;}
		else {
			if ($EtajMin!="") { $sqltmp="A.Etaj>=".$EtajMin;}
			if ($EtajMax!="") { $sqltmp="A.Etaj<=".$EtajMax;}
		}
		$sql=$sql."AND (".$sqltmp.") ";
	}
	if (($EtajeBlocMin!="")||($EtajeBlocMax!=""))	{
		$sqltmp="";
		if (($EtajeBlocMin!="")&&($EtajeBlocMax!="")) { $sqltmp="A.EtajeBloc>=".$EtajeBlocMin." AND A.EtajeBloc<=".$EtajeBlocMax;}
		else {
			if ($EtajeBlocMin!="") { $sqltmp="A.EtajeBloc=".$EtajeBlocMin;}
			if ($EtajeBlocMax!="") { $sqltmp="A.EtajeBloc=".$EtajeBlocMax;}
		}
		$sql=$sql."AND (".$sqltmp.") ";
	}
	if ($AnConstructieMin!="") {
		$sql.="AND A.AnConstructie>=".$AnConstructieMin." ";
	}
	if ($AnConstructieMax!="") {
		$sql.="AND A.AnConstructie<=".$AnConstructieMax." ";
	}
	$sql.="AND O.".($tipOferta==1? "Vanzare" : "Inchiriere")."=1 ";
	if ($PretMin!="") {
		$sql.="AND O.".($tipOferta==1? "Pret" : "PretChirie").">=".$PretMin." ";
	}
	if ($PretMax!="") {
		$sql.="AND O.".($tipOferta==1? "Pret" : "PretChirie")."<=".$PretMax." ";
	}
	if ($Cod!="") {
		$CodArray=explode(",", $Cod);
		foreach ($CodArray as $key=>$value){
			$clean[$key]=trim($value);
		}
		$sql.="AND (O.id=".implode(" OR O.id=", $clean).") ";
	}
	if ($Strada!="") {
		$sql.="AND S.Denumire LIKE '%".str_replace("%20"," ",$Strada)."%' ";
	}
	if ($Agent!="") {
		$sql.="AND O.IdAgentVanzare=".$Agent." ";
	}
	if ($Proprietar!="") {
		$sql.="AND ((C.Nume LIKE '%".$Proprietar."%') OR (C.Prenume LIKE '%".$Proprietar."%')) ";
	}
	
	
	$sort="";
	switch ($tipSortareActualizare){
		case 1: $sort="O.DataActualizare DESC"; break;
		case 2: $sort="O.DataActualizare"; break;
		case 3: $sort="CAST(O.Pret AS SIGNED)"; break;
		case 4: $sort="CAST(O.Pret AS SIGNED) DESC"; break;
	}
	if ($sort!="") $sql.="ORDER BY {$sort}";

	//echo htmlentities($sql);
	$ofertaList=$oferta->find_by_sql($sql);
	if (!empty($ofertaList)) {
		?>
	<div id="oferte" class="ui-widget-content ui-corner-all" style="margin:2px;margin-top: 2px;">
		<table style="width: 100%;">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="3%">nr</td>
				<td class="column ui-widget-header ui-corner-all" width="3%">act.</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">cod</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">tip</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">camere</td>
				<td class="column ui-widget-header ui-corner-all" width="57%">detalii</td>
				<td class="column ui-widget-header ui-corner-all" width="7%"><?php echo ($tipOferta==1 ? "pret" : "chirie");?></td>
				<td class="column ui-widget-header ui-corner-all" width="5%">foto</td>
			</tr>
		<?php 
		
		$i=0;
		
		$proprietateIcon = array(
				0	=> 'apartament.png',
				1	=> 'apvila.png',
				2	=> 'casa.png',
				3	=> 'teren.png',
				4	=> 'spatiu.png'
		);
		$stareIcon = array(
				0	=> 'bullet_ball_glass_grey.png',
				1	=> 'bullet_ball_glass_yellow.png',
				2	=> 'bullet_ball_glass_yellow.png',
				3	=> 'bullet_ball_glass_red.png',
				4	=> 'bullet_ball_glass_green.png',
		
		);

		$locatieIcons = "..".DS."images".DS."icons".DS;
		
		foreach($ofertaList as $ofertax){
			$i=$i+1;
			$class=$i%2 ? "row odd" : "row even";
			$apartament=Apartament::find_by_id($ofertax->idApartament);
			$strada=Strada::find_by_id($apartament->idStrada);
			$subzona=Subzona::find_by_id($apartament->idSubzona);
			$cartier=Cartier::find_by_id($subzona->idCartier);
			if ($i%2) {$color="#ffffff";}
			else {$color="#CCCCCC";}
			$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin LIMIT 1";
			$fotos=Foto::find_by_sql($sql);?>
			<tr <?php echo "id='".$ofertax->id."' class='".$class."' onclick=ofertaView(".$ofertax->id.") onmouseover=this.style.cursor='pointer';onOver(".$ofertax->id.",1,".$i.") onmouseout=onOver(".$ofertax->id.",0,".$i.")";?> >
			
			<?php 
			echo "<td align='center' style='font-weight: bold;'>{$i}</td>";
			
			$days = (strtotime(date("Y-m-d")) - strtotime($ofertax->DataActualizare)) / (60 * 60 * 24);
			
			if ( $apartament->TipProprietate == 0 ) {
				if ( $days <= 7 )  { $indexSare = 4; }
				else {
					if ( $days > 14 ) { $indexSare = 3; }
					else { $indexSare = 2; } 
				}		
			}
			else {
				if ( $days <= 21 )  { $indexSare = 4; }
				else {
					if ( $days > 35 ) { $indexSare = 3; }
					else { $indexSare = 2; }
				}
			}
			
			echo "<td align='center' style='font-weight: bold;'><img src='".$locatieIcons.$stareIcon[$indexSare]."' height='20'></img></td>";
			
			echo "<td align='center' style='font-weight: bold;'>"."SP".str_pad($ofertax->id, 5,"0",STR_PAD_LEFT)."</td>";
			//echo "<td align='center' style='font-weight: bold;'>".tip_proprietate($apartament->TipProprietate)."</td>";
			echo "<td style='text-align:center;'><img src='".$locatieIcons.$proprietateIcon[$apartament->TipProprietate]."' height='25'></img></td>";
			echo "<td align='center' style='font-weight: bold;'>";
			if ($apartament->TipProprietate<3 ) {
					//echo ($apartament->NumarCamere!="1"?$apartament->NumarCamere." camere":"garsoniera");
				echo $apartament->NumarCamere;
			}
			else echo "-";
			echo "</td>";
			
			echo "<td style='font-weight: bold;'>";
			echo $cartier->Denumire.", ".$subzona->Denumire.", ".$strada->Denumire.", Nr. ".$apartament->Numar;
			if ($apartament->TipProprietate==0) echo ", Et. ".$apartament->Etaj."/".$apartament->EtajeBloc.", ".$apartament->TipApartament.", Confort ".$apartament->Confort;		
			echo "</td>";
			echo "<td align=\"right\" style='font-weight: bold;'>".($tipOferta==1 ? $ofertax->Pret : $ofertax->PretChirie)." ".$ofertax->Moneda."</td>";?>
			<td align="center">
				<?php if (!empty($fotos)){ ?>
				<a id="FotoPreviewA" href="<?php echo "..".DS.$fotos[0]->image_path(); ?>" title="<?php echo $fotos[0]->Detalii;?>" class="thickbox"><img id="FotoPreviewI" src="<?php echo "..".DS.$fotos[0]->thumbnail_path();?>" alt="Foto 1" height="30" /></a> 
				<?php }
				else {?> 
					<img src="<?php echo "..".DS."images".DS."noimage.jpg";?>" height="30" ></img>
				<?php }?>
			</td> 
			</tr><?php 
		}
		?>
		</table>
		<?php 
	}
	?>
	</div>
	<?php
}

?>