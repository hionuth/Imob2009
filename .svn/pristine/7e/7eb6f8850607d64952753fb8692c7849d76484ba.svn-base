<script type="text/javascript" src=".././javascripts/zone_tree.js"></script>

<div class="ui-widget-header ui-corner-all" style="padding: 2px; padding-left:5px; margin: 2px;" onclick="showHide1('zoneTree')" onmouseover="this.style.cursor='pointer';">zone</div>
<div class="ui-widget-content ui-corner-all" style="margin-top: 5px;padding: 2px;margin: 2px; min-height: 22px;" onclick="showHide1('zoneTree')" onmouseover="this.style.cursor='pointer';" >
	<table>
		<tr class="row">
			<td class="column ui-widget-header ui-corner-all">zone selectate</td>
			<td><input type="hidden" id="zoneSelectate" name="zoneSelectate" ></input>
			<span id="zoneAfisare">Nimic selectat</span></td>
		</tr>
	</table>

</div>

	<div id="zoneTree" class="ui-widget-content ui-corner-all" style="padding: 2px;margin: 2px;">
		<table style="border: 0px; width: 100%; margin: 0px; padding: 0px;">
		<?php 
		$selzones="";
		$sql="SELECT * FROM Zona ORDER BY Denumire";
		$zonalist=Zona::find_by_sql($sql);
		if (!empty($zonalist)){
			foreach ($zonalist as $zona){
				echo "<tr style=\"border: 0px; width: 100%; margin: 0px; padding: 0px; vertical-align: middle;\">";
				echo "<td width=\"20px\" class=\"ui-widget-header ui-corner-all\" align=\"center\" onmouseover=\"this.style.cursor='pointer';\" onclick=\"extindeCartiere('".$zona->id."')\"><span id=\"zonaPlus".$zona->id."\">+</span></td>";
				echo "<td >".$zona->Denumire."</td>";
				echo "</tr>";
				echo "<tr><td></td><td>";
				echo "<div id=\"cartiereZona".$zona->id."\">";
				echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\"><tr><td>";
		
				$sql="SELECT * FROM Cartier WHERE Dezactivat='0' AND idZona='{$zona->id}' ORDER BY Denumire";
				$cartierList=Cartier::find_by_sql($sql);
				
				if (!empty($cartierList)){
					foreach ($cartierList as $cartier) {
						echo "<tr style=\"border: 0px; width: 100%; margin: 0px; padding: 0px; vertical-align: middle;\">";
						echo "<td width=\"20px\" class=\"ui-widget-header ui-corner-all\" align=\"center\" onmouseover=\"this.style.cursor='pointer';\" onclick=\"extindeSubzone('".$cartier->id."')\"><span id=\"cartierPlus".$cartier->id."\">+</span></td>";
						//echo "<td ><input type=\"checkbox\" class=\"impar\" name=\"Cart{$cartier->id}\" id=\"Cart{$cartier->id}\" onclick=\"checkZones(document.getElementById('searchForm'),'{$cartier->Denumire}','{$cartier->id}')\" />".$cartier->Denumire."</td>";
						echo "<td ><input type=\"checkbox\" class=\"impar\" name=\"Cart{$cartier->id}\" id=\"Cart{$cartier->id}\" onclick=\"checkZones(this,'{$cartier->Denumire}')\" />".$cartier->Denumire."</td>";
						echo "</tr>";
						echo "<tr><td></td><td>";
						echo "<div id=\"zoneCartier".$cartier->id."\">";
						$sql="SELECT * FROM Subzona WHERE idCartier='{$cartier->id}' ORDER BY Denumire";
						$subzonaList=Subzona::find_by_sql($sql);
						if (!empty($subzonaList)) {
							echo "<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\" width=\"100%\">";
							$i=0;
							foreach($subzonaList as $subzona) {
								$i+=1;
								echo "<tr ".($i%2 ? "class=\"odd\"" : "").">";
								echo "<td></td>";
								echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;";
								echo "<input ".($i%2 ? "class=\"even\"" : "")." type=\"checkbox\" id=\"".$cartier->Denumire.$subzona->id."\" name=\"subZonaChecked[".$subzona->id."]\" value=\"".$subzona->id."\" ";
								if (isset($subZonaChecked[$subzona->id])) {
									echo "Checked";
									$selzones=$selzones.(strlen($selzones)>0 ? ", ": "").$subzona->Denumire;
								}
								echo " onclick=\"selectZone(this.checked,this.value,'".$subzona->Denumire."')\"";
								echo " >".$subzona->Denumire;
								echo "</td>";
								
								echo "</tr>";
							}
							echo "</table>";
						}
						echo "</div>";
						echo "</td></tr>";
					}
				}
				echo "</td></tr></table>";
				echo "</div>";
				echo "</td></tr>";
			}
		}
		?>
		</table>
		
	</div>

<script type="text/javascript"> 

<?php
	
	$zonalist=Zona::find_all();
	if (!empty($zonalist)){
		foreach ($zonalist as $zona){
			echo "hide(\"cartiereZona".$zona->id."\");";
		}
	} 
	$sql="SELECT * FROM Cartier WHERE Dezactivat='0' ORDER BY Denumire";
	$cartierList=Cartier::find_by_sql($sql);
	if (!empty($cartierList)){
		foreach ($cartierList as $cartier) {
			echo "hide(\"zoneCartier".$cartier->id."\");"; 
		}
	}
?>
	hide("zoneTree");
//console.log($('#zoneTree table').find('input[type="checkbox"][onClick^="checkZone"]').eq(0));
	$('#zoneTree table').find('input[type="checkbox"][onClick^="checkZone"]').each(function(ii, sel){
		$(sel).attr('onChange', "triggerChangeZone(this);");
		});

	function triggerChangeZone(self){
        var kids = $(self).parent().parent().parent().next().find('div > table').children().find('input[type="checkbox"][onclick^="selectZone"]');
		if($(self).is(':checked')){
                        //kids.attr('className', 'ui-state-active');
                        kids.each(function(ii, sel){
                            $(sel).click();
                            $(sel).parent().next().children().eq(0).attr('className', 'ui-icon ui-icon-check');
});
        }
        else{
                        kids.each(function(ii, sel){
                            $(sel).click();
                            $(sel).parent().next().children().eq(0).attr('className', '');
});
                                }
	}
	
	
</script> 


<script type="text/javascript">
		
		<?php 
			if(strlen($selzones)>0){
				echo "document.getElementById(\"zoneAfisare\").innerHTML=\"".$selzones."\"";
			}
		?>
	
		</script>