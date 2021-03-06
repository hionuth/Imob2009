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
    <title>Imobiliare - Raport sincronizari</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
	
	<script type="text/javascript">
		function onOver(id,over,row){
			var changed = document.getElementById(id);
			if (over == 1) changed.className='row over';
			else {
				if (row%2) changed.className='row odd';
				else changed.className='row even';
			}
		}

		function ofertaView(id){
			window.open("oferta_view.php?id=" + id,"_blank");//"oferta_view","width=1046,height=742,toolbar=0,resizable=1,scrollbars=1");
		
		}

		$(function(){
			$("form").form();
		});
	</script>
	    
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>
<form action="">
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" value="inchide" onclick='document.location = ("index.php");'/>
	</div>

	<div id="oferte" class="ui-widget-content ui-corner-all" style="margin:2px;margin-top: 2px;">
	<table width="100%">
	<tr class="row">
        <td class="column ui-widget-header ui-corner-all" width="5%">cod</td>
        <td class="column ui-widget-header ui-corner-all" width="4%">tip</td>
        <td class="column ui-widget-header ui-corner-all" width="4%">oferta</td>
        <td class="column ui-widget-header ui-corner-all" width="4%">camere</td>
        <td class="column ui-widget-header ui-corner-all" width="68%">detalii</td>
        <td class="column ui-widget-header ui-corner-all" width="3%">SP</td>
        <td class="column ui-widget-header ui-corner-all" width="3%">imob</td>
        <td class="column ui-widget-header ui-corner-all" width="3%">mc</td>
        <td class="column ui-widget-header ui-corner-all" width="3%">imop</td>
        <td class="column ui-widget-header ui-corner-all" width="3%">pb</td>
        
    </tr>
    
    <?php
		$stareSync = array(
				1	=> 'de adaugat',
				2	=> 'de sync',
				3	=> 'de sters',
				4	=> 'sincronizat'
		);
		
		$stareIcon = array(
				0	=> 'bullet_ball_glass_grey.png',
				1	=> 'bullet_ball_glass_yellow.png',
				2	=> 'bullet_ball_glass_yellow.png',
				3	=> 'bullet_ball_glass_red.png',
				4	=> 'bullet_ball_glass_green.png',
				
		);
		
		$proprietateIcon = array(
				0	=> 'apartament.png',
				1	=> 'apvila.png',
				2	=> 'casa.png',
				3	=> 'teren.png',
				4	=> 'spatiu.png'
		);
		$total = array(
				"sp"	=> 0,
				"imob"	=> 0,
				"ci"	=> 0,
				"norc"	=> 0,
				"mc"	=> 0,
				"imop"	=> 0
		);
		
    	$locatieIcons = "..".DS."images".DS."icons".DS;
		
	    $sql = "SELECT * FROM Oferta WHERE ((OfertaWeb>0) OR (ExportImobiliare>0)";// OR (ExportCI>0) OR (ExportNorc>0)";
	    $sql.= " OR (ExportMC>0) OR (ExportImopedia>0)  OR (ExportPB>0)) AND (Stare='de actualitate')";
	    
	    $oferte = Oferta::find_by_sql($sql);
	    
	    $i = 0;
	    foreach ($oferte as $oferta){
			$i=$i+1;
			$class=$i%2 ? "row odd" : "row even";
			
			$apartament = Apartament::find_by_id($oferta->idApartament);
			$subzona	= Subzona::find_by_id($apartament->idSubzona);
			$cartier	= Cartier::find_by_id($subzona->idCartier);
			$strada		= Strada::find_by_id($apartament->idStrada);
			
			$total["sp"] 	= $total["sp"] + ( $oferta->OfertaWeb > 0 ? 1 : 0 );
			$total["imob"] 	= $total["imob"] + ( $oferta->ExportImobiliare > 0 ? 1 : 0 );
// 			$total["ci"] 	= $total["ci"] + ( $oferta->ExportCI > 0 ? 1 : 0 );
// 			$total["norc"] 	= $total["norc"] + ( $oferta->ExportNorc > 0 ? 1 : 0 );
			$total["mc"] 	= $total["mc"] + ( $oferta->ExportMC > 0 ? 1 : 0 );
			$total["imop"] 	= $total["imop"] + ( $oferta->ExportImopedia > 0 ? 1 : 0 );
			$total["pb"] 	= $total["pb"] + ( $oferta->ExportPB > 0 ? 1 : 0 );
			
			echo "<tr id='".$oferta->id."' class='".$class."' onclick=ofertaView(".$oferta->id.") onmouseover=this.style.cursor='pointer';onOver(".$oferta->id.",1,".$i.") onmouseout=onOver(".$oferta->id.",0,".$i.") >";
			echo "<td align='center' style='font-weight: bold;'>"."SP".str_pad($oferta->id, 5,"0",STR_PAD_LEFT)."</td>";
			//echo "<td align='center' style='font-weight: bold;'>".tip_proprietate($apartament->TipProprietate)."</td>";
			echo "<td style='text-align:center;'><img src='".$locatieIcons.$proprietateIcon[$apartament->TipProprietate]."' height='25'></img></td>";
			
			$ofertaIcon="";
			if ( $oferta->Vanzare == 1) {
				$ofertaIcon = "<img src='{$locatieIcons}vanzare_icon.png' height='15'></img>";
			}
			if ( $oferta->Inchiriere == 1) {
				$ofertaIcon .= ( $ofertaIcon =="" ? "" : "&nbsp;" )."<img src='{$locatieIcons}inchiriere_icon.png' height='15'></img>";
			}
			echo "<td style='text-align:center;'>{$ofertaIcon}</td>";
			
			$descriere = "-";
			if ($apartament->TipProprietate<3 ) {
				$descriere = $apartament->NumarCamere;
			}
			echo "<td align='center' style='font-weight: bold;'>{$descriere}</td>";
			$descriere=$cartier->Denumire.", ".$subzona->Denumire.", ".$strada->Denumire.", Nr. ".$apartament->Numar;
			if ($apartament->TipProprietate==0) $descriere.= ", Et. ".$apartament->Etaj."/".$apartament->EtajeBloc.", ".$apartament->TipApartament.", Confort ".$apartament->Confort;

			echo "<td style='font-weight: bold;'>{$descriere}</td>";
			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->OfertaWeb > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->OfertaWeb]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportImobiliare > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportImobiliare]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
// 			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportCI > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportCI]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
// 			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportNorc > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportNorc]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportMC > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportMC]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportImopedia > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportImopedia]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
			echo "<td style='font-weight: bold;text-align: center;'>".( $oferta->ExportPB > 0 ? "<img src='".$locatieIcons.$stareIcon[$oferta->ExportPB]."' height='20'></img>" : "<img src='".$locatieIcons.$stareIcon[0]."' height='20'></img>" )."</td>";
			
			echo "</tr>".PHP_EOL;
		}
    ?>
		<tr class="row">
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $i;?></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"></td>
        	<td class="column ui-widget-header ui-corner-all"></td>
        	<td class="column ui-widget-header ui-corner-all"></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $total["sp"];?></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $total["imob"];?></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $total["mc"];?></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $total["imop"];?></td>
        	<td align="center" class="column ui-widget-header ui-corner-all"><?php echo $total["pb"];?></td>
        </tr>
    </table>
    </div>
    
    <div>
    	<fieldset style="float: right; display: inline; margin: 5px;">
			<legend>legenda</legend>
			<dl>
				<dt><img src='<?php echo $locatieIcons.$stareIcon[4];?>' height='20' style="vertical-align: middle;"></img><span style="padding-left: 5px;">sincronizat</span></dt>
				<dt><img src='<?php echo $locatieIcons.$stareIcon[2];?>' height='20' style="vertical-align: middle;"></img><span style="padding-left: 5px;">de sincronizat</span></dt>
				<dt><img src='<?php echo $locatieIcons.$stareIcon[3];?>' height='20' style="vertical-align: middle;"></img><span style="padding-left: 5px;">scos de la sincronizare - de sincronzat</span></dt>
				<dt><img src='<?php echo $locatieIcons.$stareIcon[0];?>' height='20' style="vertical-align: middle;"></img><span style="padding-left: 5px;">nu se sincronizeaza</span></dt>
			</dl>
		</fieldset>
    </div>
</form>
</body>
</html>