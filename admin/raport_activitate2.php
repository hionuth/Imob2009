<?php 
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Raport activitate</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
	
	<script type="text/javascript">

		$(function(){
			$("form").form();
			$("#tabs").tabs();
		});
	</script>
	    
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
	
	$proprietateIcon = array(
			0	=> 'apartament.png',
			1	=> 'apvila.png',
			2	=> 'casa.png',
			3	=> 'teren.png',
			4	=> 'spatiu.png'
	);

	$locatieIcons = "..".DS."images".DS."icons".DS;
?>
<form action="">
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" value="inchide" onclick='document.location = ("index.php");'/>
	</div>
	
	<div id="tabs"> 
		<ul>
			<li><a href="#actualizari">actualizari</a></li>
			<li><a href="#adaugari">adaugari</a></li>
			<li><a href="#sincronizari">sincronizari</a></li>
		</ul>

		<div id="actualizari">
			
			<table width="100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width=""></td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte active</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte actualizate / 7 zile</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte actualizate / 30 zile</td>
			</tr>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">agent</td>
				<td class="column ui-widget-header ui-corner-all" style="text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
			</tr>
			
			<?php 
				$agenti = User::find_all();
				
				$total 			= array();
				$oferte_active 	= array();
				
				for ($i=0;$i<=24;$i++) {
					$total[$i]=0;
				}
				
				
				$i = 0;
				foreach ($agenti as $agent){
					if ($agent->id == 1 ) continue;
					
					$i++;
					$class = $i%2 ? "row odd" : "row even";
					
					echo "<tr class='{$class}'>";
					echo "<td style='font-weight: bold;'>{$agent->full_name()}</td>";
		
					// oferte active
		
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_active($j);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[5] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					// oferte actualizate saptamanal
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_actualizate_perioada($j,7);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+6] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[11] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					// oferte adaugate la 30 zile
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_actualizate_perioada($j,30);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+12] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[17] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					echo "</tr>";
					
				}
			
			?>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">TOTAL</td>
				
			<?php 
				for ($j=0;$j<=17;$j++){
					echo "<td class='column ui-widget-header ui-corner-all' style='text-align:center;'>{$total[$j]}</td>";
				}
			?>
			</tr>
			
			</table>
			
		</div>
		
		<div id="adaugari">
			<table width="100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width=""></td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte adaugate</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte adaugate / 7 zile</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">oferte adaugate / 30 zile</td>
			</tr>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">agent</td>
				<td class="column ui-widget-header ui-corner-all" style="text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
			</tr>
			
			<?php 
				$agenti = User::find_all();
				
				$total 			= array();
				$oferte_active 	= array();
				
				for ($i=0;$i<=24;$i++) {
					$total[$i]=0;
				}
				
				
				$i = 0;
				foreach ($agenti as $agent){
					if ($agent->id == 1 ) continue;
					
					$i++;
					$class = $i%2 ? "row odd" : "row even";
					
					echo "<tr class='{$class}'>";
					echo "<td style='font-weight: bold;'>{$agent->full_name()}</td>";
		
					// oferte active
		
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_adaugate($j);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[5] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					// oferte actualizate saptamanal
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_adaugate($j,7);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+6] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[11] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					// oferte adaugate la 30 zile
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_adaugate($j,30);
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+12] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[17] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					echo "</tr>";
					
				}
			
			?>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">TOTAL</td>
				
			<?php 
				for ($j=0;$j<=17;$j++){
					echo "<td class='column ui-widget-header ui-corner-all' style='text-align:center;'>{$total[$j]}</td>";
				}
			?>
			</tr>
			
			</table>
		</div>
		
		<div id="sincronizari">
			<table width="100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width=""></td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">Sims Parkman</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">imobiliare</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">norc</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">magazinul de case</td>
				<td class="column ui-widget-header ui-corner-all" style="width: 100px;" colspan="6">imopedia</td>
			</tr>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">agent</td>
				<td class="column ui-widget-header ui-corner-all" style="text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[0];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[1];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[2];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[3];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;"><img src='<?php echo $locatieIcons.$proprietateIcon[4];?>'  height='25'></img></td>
				<td class="column ui-widget-header ui-corner-all" style=" text-align:center;">total</td>
			</tr>
			
			<?php 
				$agenti = User::find_all();
				
				$total 			= array();
				$oferte_active 	= array();
				
				for ($i=0;$i<=29;$i++) {
					$total[$i]=0;
				}
				
				
				$i = 0;
				foreach ($agenti as $agent){
					if ($agent->id == 1 ) continue;
					
					$i++;
					$class = $i%2 ? "row odd" : "row even";
					
					echo "<tr class='{$class}'>";
					echo "<td style='font-weight: bold;'>{$agent->full_name()}</td>";
		
		
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_sincronizate($j,"OfertaWeb");
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[5] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_sincronizate($j,"ExportImobiliare");
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+6] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[11] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_sincronizate($j,"ExportNorc");
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+12] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[17] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_sincronizate($j,"ExportMC");
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+18] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[23] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					$subtotal = 0;
					for ($j=0;$j<=4;$j++) {
						$oferte_active = $agent->numar_oferte_sincronizate($j,"ExportImopedia");
						echo "<td style='text-align:center;'>{$oferte_active}</td>";
						$total[$j+24] += $oferte_active;
						$subtotal += $oferte_active;
					}
					$total[29] += $subtotal;
					echo "<td style='text-align:center; font-weight: bold;'>{$subtotal}</td>";
					
					echo "</tr>";
					
				}
			
			?>
			
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="">TOTAL</td>
				
			<?php 
				for ($j=0;$j<=29;$j++){
					echo "<td class='column ui-widget-header ui-corner-all' style='text-align:center;'>{$total[$j]}</td>";
				}
			?>
			</tr>
			
			</table>
		</div>
	</div>

</form>
</body>
</html>