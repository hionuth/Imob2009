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
}
?>

<form action="<?php echo $curentPage;?>" method="post" id="searchForm">
	<input type="hidden" name="idCerere" value="<?php if (isset($idCerere)) {echo $idCerere;}?>"></input>
<div id="Filtre" class="view" >
	<h3>Optiuni cautare</h3>
	<table>
	<tr>
		<td class="impar" width="120px">Tip proprietate:</td>
		<td class="par" width="120px">Camere:</td>
		<td class="impar" width="120px">Tip apartament:</td>
		<td class="par" width="120px">Pozitie:</td>
		<td class="impar" width="140px">Etaj:</td>
		<td class="par" width="120px">An constructie:</td>
		<td class="impar" width="120px">Pret:</td>
		<td class="par" width="120px">Tip oferta:</td>
		<td class="impar" width="120px">Cod / Strada:</td>
		<td class="par" width="120px">Agent:</td>
	</tr>
	<tr>
		<td valign="top" class="impar">
			<input type="checkbox" class="impar" name="TipProprietate[1]" value="Apartament" <?php if (isset($TipProprietate[1])) {echo "Checked";}?> />Apartament<br/>
			<input type="checkbox" class="impar" name="TipProprietate[2]" value="Apartament in vila" <?php if (isset($TipProprietate[2])) {echo "Checked";}?>/>Ap. in vila<br/>
			<input type="checkbox" class="impar" name="TipProprietate[3]" value="Casa" <?php if (isset($TipProprietate[3])) {echo "Checked";}?>/>Casa<br/>
			<input type="checkbox" class="impar" name="TipProprietate[4]" value="Teren" <?php if (isset($TipProprietate[4])) {echo "Checked";}?>/>Teren<br/>
		</td>
		<td valign="top" class="par">
			<input type="checkbox" class="par" name="NumarCamere[1]" value=1 <?php if (isset($NumarCamere[1])) {echo "Checked";}?> />Garsoniera<br/>
			<input type="checkbox" class="par" name="NumarCamere[2]" value=2 <?php if (isset($NumarCamere[2])) {echo "Checked";}?>/>2 camere<br/>
			<input type="checkbox" class="par" name="NumarCamere[3]" value=3 <?php if (isset($NumarCamere[3])) {echo "Checked";}?>/>3 camere<br/>
			<input type="checkbox" class="par" name="NumarCamere[4]" value=4 <?php if (isset($NumarCamere[4])) {echo "Checked";}?>/>4 camere<br/>
			<input type="checkbox" class="par" name="NumarCamere[5]" value=5 <?php if (isset($NumarCamere[5])) {echo "Checked";}?>/>5 camere<br/>
		</td>
		
		<td valign="top" class="impar">
			<input type="checkbox" class="impar" name="TipApartament[1]" value="Decomandat" <?php if (isset($TipApartament[1])) {echo "Checked";}?> />Decomandat<br/>
			<input type="checkbox" class="impar" name="TipApartament[2]" value="Semidecomandat" <?php if (isset($TipApartament[2])) {echo "Checked";}?> />Semidecomandat<br/>
			<input type="checkbox" class="impar" name="TipApartament[3]" value="Comandat" <?php if (isset($TipApartament[3])) {echo "Checked";}?> />Comandat<br/>
			<input type="checkbox" class="impar" name="TipApartament[4]" value="Circular" <?php if (isset($TipApartament[4])) {echo "Checked";}?> />Circular<br/>
			<input type="checkbox" class="impar" name="TipApartament[5]" value="Duplex" <?php if (isset($TipApartament[5])) {echo "Checked";}?> />Duplex<br/>
		</td>
		<td valign="top" class="par">
			<input type="checkbox" class="par" name="Pozitie[1]" value="0" <?php if (isset($Pozitie[1])) {echo "Checked";}?> />Parter<br/>
			<input type="checkbox" class="par" name="Pozitie[2]" value="1" <?php if (isset($Pozitie[2])) {echo "Checked";}?> />Etaj intermediar<br/>
			<input type="checkbox" class="par" name="Pozitie[3]" value="2" <?php if (isset($Pozitie[3])) {echo "Checked";}?> />Ultimul etaj<br/>
		</td>
		<td valign="top" class="impar">
			<table border="0" >
				<tr>
					<td align="left">Etaje:</td>
				</tr>
				<tr>
					<td align="center">
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
						</select>-
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
					</td>
				</tr>
				<tr>
					<td align="left">Etaje bloc:</td>
				</tr>
				<tr>
					<td align="center">
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
						</select>-
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
					</td>
				</tr>
			</table>
		</td>
		<td valign="top" class="par">
			<table>
				<tr>
					<td>Min:</td>
					<td>
						<input name="AnConstructieMin" value="<?php if (isset($AnConstructieMin)) {echo htmlentities($AnConstructieMin);}?>" size="4"></input>
					</td>
				</tr>
				<tr>
					<td>Max:</td>
					<td>
						<input name="AnConstructieMax" value="<?php if (isset($AnConstructieMax)) {echo htmlentities($AnConstructieMax);}?>" size="4"></input>
					</td>
				</tr>
			</table>
			
		</td>
		<td valign="top" class="impar">
			<table>
				<tr>
					<td>Min:</td>
					<td><input type="text" name="PretMin" size="10" value="<?php if (isset($PretMin)) {echo htmlentities($PretMin);}?>"/></td>
				</tr>
				<tr>
					<td>Max:</td>
					<td><input type="text" name="PretMax" size="10" value="<?php if (isset($PretMax)) {echo htmlentities($PretMax);}?>"/></td>
				</tr>
			</table>
		</td>
		<td valign="top" class="par">
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
		<td valign="top" class="impar" align="center" >
		<table>
			<tr>
				<td>
					cod:<br/>
					<input type="text" name="Cod" size="16" value="<?php if (isset($Cod)) {echo $Cod;}?>"></input>
				</td>
			</tr>
			<tr>
				<td>
					strada:<br/>
					<input type="text" id="Strada" name="Strada" onkeyup="showHint(this.value)" size="16" value="<?php if (isset($Strada)) {echo $Strada;}?>"></input>
					<div id="divStradaHint" class="hint">
					</div>
					
				</td>
			</tr>
		</table>
		</td>
		<td valign="top" class="par" align="center">
			<select name="Agent">
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
		</td>
		
	</tr>	
	</table>
</div>
<script>
	hide("divStradaHint");
</script>

<?php include 'zone_tree.php';?>

<div id="optiuniExtra" class="view">
	<h3 onmouseover="this.style.cursor='pointer'" onclick="showHide1('filtreExtra')">Extra optiuni</h3>
	<div id="filtreExtra">
		<table>
			<tr>
				<td class="impar" width="120px">Confort:</td>
				<td class="par" width="120px">Stare:</td>
				<td class="impar" width="120px">Proprietar:</td>
				<td class="par" width="120px">Data actualizare:</td>
				
			</tr>
			<tr>
				<td valign="top" class="impar">
					<input type="checkbox" class="impar" name="Confort[1]" value=1 checked="checked"/>Confort I<br/>
					<input type="checkbox" class="impar" name="Confort[2]" value=2 <?php if (isset($Confort[2])) {echo "Checked";}?>/>Confort II<br/>
				</td>
				<td valign="top" class="par">
					<input type="checkbox" class="par" name="Stare[1]" value="de actualitate" checked="checked"/>De actualitate<br/>
					<input type="checkbox" class="par" name="Stare[2]" value="vandut de noi" <?php if (isset($Stare[2])) {echo "Checked";}?> />Vandut de noi<br/>
					<input type="checkbox" class="par" name="Stare[3]" value="vandut de altii" <?php if (isset($Stare[3])) {echo "Checked";}?> />Vandut de altii<br/>
					<input type="checkbox" class="par" name="Stare[4]" value="stand by" <?php if (isset($Stare[4])) {echo "Checked";}?> />Stand by<br/>
				</td>
				
				<td valign="top" class="impar" align="center">
					 <input type="text" name="Proprietar" size="16" value="<?php if (isset($Proprietar)) {echo $Proprietar;}?>"></input>
				</td>
				<td valign="top" class="par">
					<input type="radio" name="tipSortareActualizare" value="1" class="par" 
						<?php 
							if (!isset($tipSortareActualizare)){echo "checked";}
							else {
								if ($tipSortareActualizare==1) {echo "checked";}
							}
						?>/>Descrescator<br/>
					<input type="radio" name="tipSortareActualizare" value="2" class="par" 
						<?php 
							if (isset($tipSortareActualizare)) {
								if ($tipSortareActualizare==2) {echo "checked";}
							}
						?>/>Crescator<br/>
				</td>
				
			</tr>
		</table>
	</div>
</div>

<div id="butoane" class="butoane" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="right">
				<input type='submit' name='submit' id='submit' value='Cauta'/>
				<input type='button' name='reset' id='reset' value='Reseteaza' onClick="document.location='<?php echo $curentPage.(isset($idCerere)?"?id=".$idCerere:"");?>';"/>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript"> 
<!--
	//hide("zoneTree");
	hide("filtreExtra");
	//hide("zonaCollapse");
//-->
</script> 

</form>
<?php 
if (isset($_POST['submit'])) {
	$oferta=new Oferta();
	
	$sql="SELECT A.NumarCamere, A.Confort, O.id, O.Pret, O.PretChirie, O.Moneda, O.idApartament ";
	//$sql=$sql."FROM Oferta as O INNER JOIN Apartament as A ON O.idApartament=A.id ";
	$sql.="FROM Utilizator as U INNER JOIN (Strada as S INNER JOIN ((Client as C INNER JOIN Apartament as A ON C.id = A.idClient) INNER JOIN Oferta as O ON A.id = O.idApartament) ON S.id = A.idStrada) ON U.id = C.idUtilizator ";
	$sql=$sql."WHERE 1 ";
	//if (($NumarCamere==0)&&($NumarCamere==0)&&($TipApartament==0)) {$sql=$sql."1";}
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
		$sql.="AND (A.id=".implode(" OR A.id=", $clean).") ";
	}
	if ($Strada!="") {
		$sql.="AND S.Denumire LIKE '%".str_replace("%20"," ",$Strada)."%' ";
	}
	if ($Agent!="") {
		$sql.="AND U.id=".$Agent." ";
	}
	if ($Proprietar!="") {
		$sql.="AND ((C.Nume LIKE '%".$Proprietar."%') OR (C.Prenume LIKE '%".$Proprietar."%')) ";
	}
	$sql.="ORDER BY O.DataActualizare ".($tipSortareActualizare==1?"DESC":"");
	//echo htmlentities($sql);
	$ofertaList=$oferta->find_by_sql($sql);
	if (!empty($ofertaList)) {
		?>
	<div id="oferte" class="view">
		<h3>Oferte gasite</h3>
		<table width="100%">
			<tr >
				<td class="header" align="center" width="5%">Cod</td>
				<td class="header" align="center" width="10%">Camere</td>
				<td class="header" width="70%">Detalii</td>
				<td class="header" align="center" width="10%"><?php echo ($tipOferta==1 ? "Pret" : "Chirie");?></td>
				<td class="header" align="center" width="5%">Foto</td>
			</tr>
		<?php 
		
		$i=0;
		foreach($ofertaList as $ofertax){
			$i=$i+1;
			$class=$i%2 ? "impar" : "par";
			$apartament=Apartament::find_by_id($ofertax->idApartament);
			$strada=Strada::find_by_id($apartament->idStrada);
			$subzona=Subzona::find_by_id($apartament->idSubzona);
			if ($i%2) {$color="#ffffff";}
			else {$color="#CCCCCC";}
			$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin LIMIT 1";
			$fotos=Foto::find_by_sql($sql);?>
			<tr <?php echo "id='".$ofertax->id."' class='".$class."' ondblclick=ofertaView(".$ofertax->id.") onmouseover=this.style.cursor='pointer';onOver(".$ofertax->id.",1,".$i.") onmouseout=onOver(".$ofertax->id.",0,".$i.")";?> >
			
			<?php 
			echo "<td align='center' style='font-weight: bold;'>".$ofertax->id."</td>";
			
			echo "<td align='center' style='font-weight: bold;'>".($apartament->NumarCamere!="1"?$apartament->NumarCamere." camere":"garsoniera")."</td>";
			echo "<td style='font-weight: bold;'>";
			echo $subzona->Denumire.", ".$strada->Denumire.", Nr. ".$apartament->Numar.", Et. ".$apartament->Etaj."/".$apartament->EtajeBloc;
			echo ", ".$apartament->TipApartament.", Confort ".$apartament->Confort;		
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