<?php
?>

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
		
	</tr>	
	</table>
</div>
<script>
	hide("divStradaHint");
</script>

<div id="ZoneView" class="view">
	<h3 onclick="showHide1('zoneTree')" onmouseover="this.style.cursor='pointer';">Zone</h3>
	<table width="100%">
		<tr onclick="showHide1('zoneTree')" onmouseover="this.style.cursor='pointer';">
			<td class="label" >Zone selectate</td>
			<td width="800">
				<input type="hidden" id="zoneSelectate" name="zoneSelectate"></input>
				<span id="zoneAfisare">Nimic selectat</span>
			</td>
		</tr>
	</table>
	<div id="zoneTree">
		<table width="100%" border="0" cellpadding="0" cellspacing="1">
		<?php 
			$cartierList=Cartier::find_all();
			$selzones="";
			if (!empty($cartierList)){
				foreach ($cartierList as $cartier) {
					echo "<tr>";
					echo "<td width=\"20px\" class=\"impar\" align=\"center\" onmouseover=\"this.style.cursor='pointer';\" onclick=\"extindeSubzone('".$cartier->id."')\"><span id=\"cartierPlus".$cartier->id."\">+</span></td>";
					echo "<td class=\"impar\"><input type=\"checkbox\" class=\"impar\" name=\"Cart{$cartier->id}\" id=\"Cart{$cartier->id}\" onclick=\"checkZones(document.getElementById('searchForm'),'{$cartier->Denumire}','{$cartier->id}')\" />".$cartier->Denumire."</td>";
					echo "</tr>";
					echo "<tr><td></td><td>";
					echo "<div id=\"zoneCartier".$cartier->id."\">";
					echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td>";
					$sql="SELECT * FROM Subzona WHERE idCartier='{$cartier->id}'";
					$subzonaList=Subzona::find_by_sql($sql);
					if (!empty($subzonaList)) {
						echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
						$i=0;
						foreach($subzonaList as $subzona) {
							$i+=1;
							echo "<tr ".($i%2 ? "class=\"par\"" : "").">";
							echo "<td></td>";
							echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;";
							echo "<input ".($i%2 ? "class=\"par\"" : "")." type=\"checkbox\" id=\"".$cartier->Denumire.$subzona->id."\" name=\"subZonaChecked[".$subzona->id."]\" value=\"".$subzona->id."\" ";
							if (isset($subZonaChecked[$subzona->id])) {echo "Checked";$selzones.=(strlen($selzones)>0?", ":"").$subzona->Denumire;}
							echo " onclick=\"selectZone(this.checked,this.value,'".$subzona->Denumire."')\"";
							echo ">".$subzona->Denumire;
							echo "</td>";
							
							echo "</tr>";
						}
						echo "</table>";
					}
					echo "</td></tr></table>";
					echo "</div>";
					echo "</td></tr>";
				}
			}
		?>
		</table>
		<script type="text/javascript">
		<!--
		<?php 
			if(strlen($selzones)>0){
				echo "document.getElementById(\"zoneAfisare\").innerHTML=\"".$selzones."\"";
			}
		?>
		//-->
		</script>
	</div>
</div>
<script type="text/javascript"> 
<?php 
	$cartierList=Cartier::find_all();
	if (!empty($cartierList)){
		foreach ($cartierList as $cartier) {
			echo "hide(\"zoneCartier".$cartier->id."\");"; 
		}
	}
?>
</script> 

<div id="optiuniExtra" class="view">
	<h3 onmouseover="this.style.cursor='pointer'" onclick="showHide1('filtreExtra')">Extra optiuni</h3>
	<div id="filtreExtra">
		<table>
			<tr>
				<td class="impar" width="120px">Confort:</td>
				<td class="par" width="120px">Stare:</td>
				<td class="impar" width="120px">Proprietar:</td>
				<td class="par" width="120px">Agent:</td>
				
				
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
</div>

<div id="butoane" class="butoane" >
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td align="right">
				<input type='submit' name='submit' id='submit' value='Cauta'/>
				<input type='button' name='reset' id='reset' value='Reseteaza' onClick="document.location='<?php echo $curentPage;?>';"/>
			</td>
		</tr>
	</table>
</div>

<script type="text/javascript"> 
<!--
	hide("zoneTree");
	hide("filtreExtra");
	//hide("zonaCollapse");
//-->
</script> 