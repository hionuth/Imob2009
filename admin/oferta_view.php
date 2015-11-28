<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
if (isset($_GET['id'])) {
	$idOferta=$_GET['id'];
}

if (isset($_POST['submit'])) {
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${
				$variable}=$_POST[$variable];
		}
	}
}

$cnt=0;

function put_item($var,$label,$tip="",$ralign=0,$size=0,$prop="") {
	global $cnt;
	$cnt++;
	if (($tip=="T")&&($var=="")) return "";
	if (($tip=="N")&&($var<=0)) return "";
	$style="";
	if ($ralign) $style=" text-align:right;";
	if ($size>0) $style.=" width:{$size}px;";
	if ($style!="") $style=" style=\"{$style}\"";
	$item="<label id=\"lab{$cnt}_{$prop}\" class=\"label\">{$label}</label>";
	$item.="<input id=\"tex{$cnt}_{$prop}\" type=\"text\" class=\"standard\"{$style} disabled=\"disabled\"  value=\"{$var}\" />";
	return $item;
}


function put_check($var,$label,$prop=""){
	global $cnt;
	$cnt++;	
	$item="<div id=\"div{$cnt}_{$prop}\"><label class=\"label\">{$label}</label>";
	$checked="";
	if (($var>0)&&($var!=3)) $checked=" checked=\"checked\"";
	$item.="<input type=\"checkbox\"{$checked}disabled=\"disabled\"></input></div>";
	return $item;
}

function sync($site){
	if (($site>0)&&($site!=3)) return 1;
	return 0;
}

$oferta=Oferta::find_by_id($idOferta);
$apartament=Apartament::find_by_id($oferta->idApartament);
$client=Client::find_by_id($apartament->idClient);
$agent=User::find_by_id($client->idUtilizator);
$strada=Strada::find_by_id($apartament->idStrada);
$subzona=Subzona::find_by_id($apartament->idSubzona);
$cartier=Cartier::find_by_id($subzona->idCartier);
$oras=Zona::find_by_id($cartier->idZona);
$sursa=Sursa::find_by_id($apartament->idSursa);

$agentIntroducere=User::find_by_id($oferta->idAgentIntroducere);
$agentInchiriere=User::find_by_id($oferta->idAgentInchiriere);
$agentVanzare=User::find_by_id($oferta->IdAgentVanzare);


$sql="SELECT * FROM CategorieDotari WHERE TipProprietate=1 ORDER BY Prioritate";
$CatDotList=CategorieDotari::find_by_sql($sql);
if (!empty($CatDotList)) {
	foreach($CatDotList as $CatDot){
		$sql="SELECT * FROM Dotare WHERE idCategorieDotari='{$CatDot->id}'";
		$DotList=Dotare::find_by_sql($sql);
		if (!empty($DotList)){
			foreach($DotList as $Dot){
				$sql="SELECT * FROM DotareApartament WHERE idDotare='{$Dot->id}' AND idApartament='{$apartament->id}'";
				$DotApList=Dotareapartament::find_by_sql($sql);
				if (!empty($DotApList)){
					foreach($DotApList as $DotAp){
						if (!isset($dotString[$CatDot->id])) {
							$dotCat[$CatDot->id]=$CatDot->Descriere;
							$dotString[$CatDot->id]=$Dot->Descriere;
						}
						else {$dotString[$CatDot->id].=", ".$Dot->Descriere;
						}
					}
				}
			}
		}
	}

}

$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin";
$fotos=Foto::find_by_sql($sql);

switch ($apartament->TipProprietate) {
			case 0: $tipp="xa";
					break;
			case 1: $tipp="xb";
					break;
			case 2: $tipp="xc";
					break;
			case 3: $tipp="xt";
					break;
			case 4: $tipp="xs";
					break;
			default: $tipp="xa";
		}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>

    <title>Imobiliare - Vizualizare oferta</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href=".././styles/jquery.lightbox-0.5.css" media="screen" />
	<script type="text/javascript" src=".././javascripts/thickbox.js"></script>
	<script type="text/javascript" src=".././javascripts/cereri.js"></script>
	<script type="text/javascript" src=".././javascripts/jquery.lightbox-0.5.js"></script>
	<script>
		$(function(){
			$("form").form();
			showOnly("<?php echo $tipp;?>");
			$("#promovari").hide("fast");
		    $("#promfs").click(function(event){
				event.preventDefault();
				$("#promovari").toggle("slow");
			});

		    $("#comentariu_div").hide("fast");
		    $("#comentariu").click(function(event){
				event.preventDefault();
				$("#comentariu_div").toggle("slow");
			});
		});

		function close_tab(){
			window.open('', '_self', '');
			window.close();
		}

		$(function() {
		    $('#gallery a').lightBox();
		});

		function initialize() {
		    var latlng = new google.maps.LatLng(<?php echo ( $apartament->Lat>0 ? $apartament->Lat : 44.4257);?>, <?php echo ($apartament->Lng ? $apartament->Lng : "26.115");?>);
		    var myOptions = {
		      zoom: 13,
		      center: latlng,
		      mapTypeId: google.maps.MapTypeId.ROADMAP
		    };
		    map = new google.maps.Map(document.getElementById("map_canvas"),
		        myOptions);
		    
		    var marker = new google.maps.Marker({
		        position: latlng, 
		        map: map,
		        title:"Locatie aproximativa"
		  	});
		}

		function onClick_update(id){
			document.location = ("oferta_update.php?id=" + id);
		}
		function onClick_foto(id,oferta){
			document.location = ("foto_update2.php?id=" + id + "&idOferta=" + oferta);
		}
		function onClick_video(id,oferta){
			document.location = ("video_update.php?id=" + id + "&idOferta=" + oferta);
		}

		
		function showOnly(tip){
			//var elem=document.getElementById("formular").elements;
			var elem=document.getElementsByTagName("*");
			for(var i = 0; i < elem.length; i++)
	        {
		        var nume=elem[i].id;
		        //var nume="sdsds";
		        if (nume.indexOf("_x")!= -1){
			        if (nume.indexOf(tip) !=-1) {
				        //elem[i].style.visibility = 'visible';
				        //alert(elem[i].tagName);
			        	if (elem[i].tagName!="DIV") elem[i].style.display="inline-block";
			        	else {
			        		elem[i].style.display="block";
						}
				    }
			        else {
			        	//elem[i].style.visibility = 'hidden';
			        	elem[i].style.display="none";
					}
		        }
	        }
		}
	</script>
	 <style type="text/css">
	/* jQuery lightBox plugin - Gallery style */
	#gallery {
		
		
	
	}
	#gallery ul { list-style: none; }
	#gallery ul li { display: inline; }
	#gallery ul img {
		border: 2px solid #3e3e3e;
		border-width: 2px 2px 10px;
	}
	#gallery ul a:hover img {
		border: 2px solid #fff;
		border-width: 2px 2px 10px;
		color: #fff;
	}
	#gallery ul a:hover { color: #fff; }
	</style>
</head>
<body onload="initialize()">
<?php //require_once(".././include/meniu.php");?>
<form action="">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inchide" value="inchide" onclick='close_tab();'/>
		<input type="button" id="updatep" value="modifica" onclick='onClick_update(<?php echo $oferta->id;?>)'/>
		<input type="button" id="updatef" value="foto" onclick='onClick_foto(<?php echo $apartament->id;?>,<?php echo $oferta->id;?>)'/>
		<input type="button" id="updatef" value="video" onclick='onClick_video(<?php echo $apartament->id;?>,<?php echo $oferta->id;?>)'/>
		<input type="button" id="updatef" value="documente" onclick='document.location = ("doc_update.php?id=" + <?php echo $apartament->id;?> + "&idOferta=" + <?php echo $oferta->id;?>);'/>
		<input type="button" value="descarca pdf" onclick="window.open('ofertapdf.php?id=<?php echo $oferta->id;?>','_blank')"></input>
	</div>
	<div style="overflow:auto; background-color: rgb(255,248,226);">
	<div style="display: inline-block; float: left">
		<div >
		<fieldset>
			<legend>oferta <?php echo "SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT);?></legend>
			<table width="100%">
					<tr>
						<td>
							vanzare<input type="checkbox" disabled="disabled" <?php if ($oferta->Vanzare==1) {echo "checked=\"checked\"";}?>></input>
						</td>
						<td>
							inchiriere<input type="checkbox" disabled="disabled" <?php if ($oferta->Inchiriere==1) {echo "checked=\"checked\"";}?>></input>
						</td>
						<td>
							neg.<input type="checkbox" disabled="disabled" <?php if ($oferta->Negociabil==1) {echo "checked=\"checked\"";}?>></input>
						</td>
						<td align="right">
							exclusiv<input type="checkbox" disabled="disabled" <?php if ($oferta->Exclusivitate==1) {echo "checked=\"checked\"";}?>></input>
						</td>
					</tr>
			</table>
			<table width="100%">
					<tr>
						<td class="column ui-widget-header ui-corner-all" width="50%" align="left">
								pret vanzare
						</td>
						<td class="column ui-widget-header ui-corner-all" width="50%" align="right">
							pret inchiriere
						</td>
					</tr>
					<tr>
						<td class="odd " width="50%" align="left">
							<?php if ($oferta->Vanzare==1) {echo $oferta->Pret." ".$oferta->Moneda;}?>
						</td>
						<td class="odd " width="50%" align="right">
							<?php if ($oferta->Inchiriere==1) {echo $oferta->PretChirie." ".$oferta->Moneda;}?>
						</td>
					</tr>
			<?php
				if (($oferta->PretInitial>0)||($oferta->PretFinal>1)) {
			?> 
					<tr>
						<td class="column ui-widget-header ui-corner-all" width="50%" align="left">
								pret initial
						</td>
						<td class="column ui-widget-header ui-corner-all" width="50%" align="right">
							pret final
						</td>
					</tr>
					<tr>
						<td class="odd " width="50%" align="left">
							<?php if ($oferta->PretInitial>0) {echo $oferta->PretInitial." ".$oferta->Moneda;}?>
						</td>
						<td class="odd " width="50%" align="right">
							<?php if ($oferta->PretFinal>1) {echo $oferta->PretFinal." ".$oferta->Moneda;}?>
						</td>
					</tr>
				<?php }
				?>
				</table>
				
			<?php 
				echo put_item($oferta->PretFinal, "pret final", "N",1);
				echo put_item( $oferta->Comision, "comision vanzator");
				echo put_item( $oferta->ComisionClient, "comision client");
				?>
				<label class="label">comision client 0</label><input type="checkbox" id="ComisionCumparatorZero" name="OfComisionCumparatorZero" <?php if ($oferta->ComisionCumparatorZero==1) {echo "checked=\"checked\"";}?> value="1" disabled="disabled">
				<span style="margin-left: 73px;">of. speciala</span><input type="checkbox" id="OfertaSpeciala" name="OfOfertaSpeciala" <?php if ($oferta->OfertaSpeciala==1) {echo "checked=\"checked\"";}?> value="1" disabled="disabled">
				<?php 
				//echo put_check($oferta->Negociabil, "negociabil");
				echo put_item( convert_date($apartament->DataIntrare), "data adaugare","","","","");
				echo put_item( convert_date($oferta->DataIntrareInPiata), "data in piata","T");
				echo put_item( convert_date($oferta->DataActualizare), "data actualizare");
				echo put_item( $oferta->Stare, "stare");
				echo put_item( $sursa->Descriere, "sursa");
				
			?>
		</fieldset>	
		</div>
		<div>
			<fieldset>
				<legend>detalii <?php echo tip_proprietate($apartament->TipProprietate);?></legend>
				<?php 
				//echo put_item( tip_proprietate($apartament->TipProprietate), "tip proprietate");
				echo put_item($apartament->NumarCamere,"camere","","","30","xaxbxcxs");
				?>
				<span style="margin-left: 66px; margin-right: 5px;" id="spanConfort_xa">confort</span><input type="text" id="Confort_xa" style="width: 30px;" value="<?php echo $apartament->Confort;?>" disabled="disabled"/><br id="brcamere_xaxcxs"/><br id="brconf_xaxbxc"/>
				<?php 
				//echo put_item($apartament->Confort,"confort","","","30","xa");
				echo put_item($apartament->TipApartament,"tip apartament","","","","xaxb");
				echo put_item($apartament->TipConstructie,"tip constructie","","","","xaxs");
				if ($apartament->Duplex==1) echo put_check($apartament->Duplex, "duplex","xaxb");
				$etaj=$apartament->Etaj;
				switch ($etaj){
					case -3: $etaj="subsol"; break;
					case -2: $etaj="demisol"; break ;
					case -1: $etaj="mansarda"; break;
					case "0": $etaj="parter"; break;
					default:$etaj=$apartament->Etaj;
				}
				if ($apartament->TipProprietate=='0') $etaj.=" / ".$apartament->EtajeBloc;
				echo put_item($etaj,"etaj","","","","xaxbxs");
				$structura="";
				if ($apartament->Subsol==1) $structura.="+ s ";
				if ($apartament->Demisol==1) $structura.="+ d ";
				if ($apartament->Parter==1) $structura.="+ p ";
				if ($apartament->Etaje>0) $structura.="+ ".$apartament->Etaje." ";
				if ($apartament->Mansarda==1) $structura.="+ m";
				if ($apartament->Pod==1) $structura.="+ pod";
				$label= ($apartament->TipProprietate==3 ? "regim inaltime" : "structura");
				echo put_item(substr($structura,1),$label,"","","","xbxcxtxs");
				echo put_item($apartament->AnConstructie,"an constructie","","","40","xaxcxs");
				?>
				<span id="spanAnRenovare_xaxcxs" style="margin-left: 19px; margin-right: 5px;">an renovare</span><input type="text" id="AnRenovare_xaxcxs" style="width: 40px;" value="<?php echo $apartament->AnRenovare;?>" disabled="disabled"/><br id="brren_xaxcxs"/>
				<?php 
				//echo put_item($apartament->AnRenovare,"an renovare","T","","","xaxcxs");
				echo put_item($apartament->NrGrupuriSanitare,"grupuri sanitare","","","","xaxbxcxs");
				echo put_item($apartament->NumarBucatarii,"numar bucatarii","","","","xc");
				if (($apartament->NumarBalcoane !="")||($apartament->NumarTerase!="")) {
					echo put_item($apartament->NumarBalcoane,"numar balcoane","","","40","xaxbxcxs");
					?>
					<span id="spanNumarTerase_xaxbxc" style="margin-left: 30px; margin-right: 5px;">nr. terase</span><input type="text" id="NumarTerase_xaxbxc" style="width: 40px;" value="<?php echo $apartament->NumarTerase;?>" disabled="disabled"/><br id="brterasec_xaxbxc"/>
					<?php

					//echo put_item($apartament->NumarTerase,"numar terase","T","","","xaxbxc");
				}
				if (($apartament->NumarParcari !="")||($apartament->NumarGaraje!="")) {
					echo put_item($apartament->NumarParcari,"numar parcari","","","40","xaxbxcxs");
				?>
					<span id="spanNumarGaraje_xaxbxcxs" style="margin-left: 31px; margin-right: 5px;">nr. garaje</span><input type="text" id="NumarGaraje_xaxbxcxs" style="width: 40px;" value="<?php echo $apartament->NumarGaraje;?>" disabled="disabled"/><br id="brparc_xaxbxcxs"/>
				<?php 
				}
				//echo put_item($apartament->NumarGaraje,"numar garaje","T","","","xaxbxc");
				echo put_item($apartament->SuprafataUtila,"sup. utila");
				echo put_item($apartament->SuprafataConstruita,"sup totala constr.","","","","xaxbxcxtxs");
				echo put_item($apartament->SuprafataTerasa,"s. balcon/terasa","","","","xaxbxcxs");
				echo put_item($apartament->SuprafataCurte,"sup. teren","","","","xbxcxs");
				echo put_item($apartament->AmprentaSol,"amprenta sol","","","","xc");
				echo put_item($apartament->Deschidere,"deschidere","","","","xcxt");
				echo put_item($apartament->NumarDeschideri,"nr deschideri","","","","xcxsxt");
				echo put_item($apartament->TipCurte,"tip curte","T","","","xbxc");
				echo put_item($apartament->TipIntrare,"tip intrare","T","","","xb");
				echo put_item($apartament->LatimeDrumAcces,"lat. drum acces","","","","xt");
				echo put_item($apartament->POT,"POT","","","","xt");
				echo put_item($apartament->CUT,"CUT","","","","xt");
				echo put_item($apartament->Inclinatie,"inclinatie","","","","xt");
				//echo put_item($apartament->ConstructiePeTeren,"constructie pe el","","","","xt");
				echo put_check($apartament->ConstructiePeTeren,"constructie pe el","xt");
				echo put_item($apartament->Destinatie,"destinatie","","","","xs");
				echo put_item($apartament->TipTeren,"tip teren","T","","","xt");
				echo put_item($apartament->Clasificare,"clasificare","T","","","xt");
				echo put_item($apartament->TipSpatiu,"tip spatiu","","","","xs");
				echo put_item($apartament->Inaltime,"inaltime spatiu","T","","","xs");
				echo put_check($apartament->Vitrina, "vitrina","xs");
				echo put_item($apartament->ClasaBirouri,"clasa birouri","T","","","xs");
				?>
			</fieldset>
		</div>
	</div>
	
	<div style="display: inline-block; float: left">
		<div>
			<fieldset style="width: 400px;">
				<legend>titlu</legend>
				<?php echo $oferta->Titlu;?>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 400px;">
				<legend>descriere publica</legend>
				<?php echo $apartament->Detalii;?>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 400px;">
				<legend id="comentariu" style="cursor: pointer;">comentarii</legend>
				<div id="comentariu_div">
				<?php echo $apartament->DetaliiInterne;?> <br />
				</div>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 400px;">
				<legend>amenajari si detalii</legend>
				<table>
				<?php 
				if (!empty($dotCat)) {
					foreach($dotCat as $key => $categorie){
						echo "<tr>";
						echo "<td style=\"width:100px;\">";
						echo $categorie;
						echo "</td>";
						echo "<td>";
						echo $dotString[$key];
						echo "</td>";
						echo "</tr>";
					}
				}
				?>
				</table>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 400px;">
				<legend>fotografii</legend>
				<table width="100%" >	

						<tr>
							<td>
							<div id="gallery" style="height : 84px ;overflow : auto;">
								<ul style="margin: 0px; padding: 2px;">
									<?php 
										if (!empty($fotos)){
											foreach($fotos as $foto){?>
												<li>
													<a href="<?php echo "..".DS.$foto->image_path();?>" title="<?php echo $foto->Detalii;?>">
                										<img src="<?php echo "..".DS.$foto->image_path();?>"	 height="50" alt="" />
													</a>
												</li>	
											<?php 
											}
										}
									?>
								</ul>
							</div>
							</td>
						</tr>
					</table>
			</fieldset>
		</div>
		<div>
			<fieldset style="width: 400px;">
				<legend id="promfs" style="cursor: pointer;">promovare</legend>
				<div id="promovari">
				<?php if (sync($oferta->OfertaWeb)) {?>
					<label class="label">simsparkman</label>
					<a href="http://www.simsparkman-imobiliare.ro/oferte-imobiliare/
					<?php 
					$tmp="";
					if ($oferta->Vanzare==1) $tmp="vanzare";
					if ($oferta->Inchiriere==1) {
						if ($tmp!="") $tmp.="-";
						$tmp.="inchiriere";
					}
					switch ($apartament->TipProprietate) {
						case 0:$tmp.="-apartament-in-bloc";break;
						case 1:$tmp.="-apartament-in-vila";break;
						case 2:$tmp.="-casa-vila";break;
						case 3:$tmp.="-teren";break;
						case 4:$tmp.="-spatiu-".$apartament->TipSpatiu;
					}
					if ($apartament->TipProprietate<3) $tmp.="-{$apartament->NumarCamere}-camere";
					$tmp.="-".$oras->Denumire."-".$cartier->Denumire."-".$subzona->Denumire;
					$tmp.="--sp".str_pad($oferta->id,5,"0",STR_PAD_LEFT).".html";
					$lista=array("\s"," ");
					echo str_replace($lista,"-",html_entity_decode($tmp));
					?>" title="http://www.simsparkman.ro/detaliioferta.php?id=<?php echo $oferta->id;?>" target="_blank"><?php echo "SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT); ?></a><br />
				<?php }?>
				 <?php if (sync($oferta->ExportImobiliare)) {?>
					<label class="label">imobiliare</label>
					<a href="<?php echo $oferta->LinkImobiliare;?>" target="_blank" title="<?php echo $oferta->LinkImobiliare; ?>"><?php echo array_pop(explode("/",$oferta->LinkImobiliare));?></a><br />
				<?php }?>
				<?php if (sync($oferta->ExportCI)) {?>
					<label class="label">cauta imobiliare</label>
					<a href="<?php echo $oferta->LinkCI;?>" target="_blank" title="<?php echo $oferta->LinkCI; ?>"><?php echo array_pop(explode("/",$oferta->LinkCI));?> link</a><br />
				<?php }?>
				 <?php if (sync($oferta->ExportNorc)) {?>
					<?php echo put_check($oferta->ExportNorc, "norc");
				 }?>
				 <?php if (sync($oferta->ExportMC)) {?>
					<label class="label">mag. de case</label>
					<a href="<?php echo "http://www.magazinuldecase.ro/ia/".$oferta->idMC;?>" target="_blank" title="<?php echo $oferta->idMC; ?>"><?php echo $oferta->idMC;?></a><br />
				<?php }?>
				<?php if (sync($oferta->ExportImopedia)) {?>
					<label class="label">imopedia</label>
					<a href="<?php echo "http://www.imopedia.ro/index.php?section=oferte&screen=index&id=1173run".$oferta->id;?>" target="_blank" title="<?php echo "1173run".$oferta->id; ?>"><?php echo "1173run".$oferta->id;?></a><br />
				<?php }?>
				</div>
			</fieldset>
		</div>
	</div>
	<div style="display: inline-block; float: left">
		<div>
			<fieldset>
				<legend>broker</legend>
				<?php 
					if ($agentIntroducere) {echo put_item($agentIntroducere->full_name(), "adaugat");}
					if ($agentVanzare) echo put_item($agentVanzare->full_name(), "lucreaza");
					if ($agentInchiriere) echo put_item($agentInchiriere->full_name(), "evaluat");
				?>
			</fieldset>
		</div>
		<div>
			<fieldset>
				<legend>client</legend>
				<?php 
					echo put_item($client->full_name(), "nume");
					echo put_item($client->TelefonMobil, "telefon 1","T");
					echo put_item($client->TelefonFix, "telefon 2","T");
					echo put_item($client->TelefonFax, "telefon 3","T");
					echo put_item($client->TelefonServici, "telefon 4","T");
					echo put_item($client->Email, "email");
				?>
			</fieldset>
		</div>
		<div >
			<fieldset >
				<legend>localizare</legend>
				<?php 	echo put_item($cartier->Denumire,"Zona");
						echo put_item($subzona->Denumire,"Subzona");?>
					<label class="label" style="vertical-align: top;">adresa</label><textarea  style="width:175px;min-height:55px;"><?php echo $strada->Denumire.", Nr. ".$apartament->Numar.", Bl. ".$apartament->Bloc.", Sc. ".$apartament->Scara.", Ap. ".$apartament->Apartament.", Interfon ".$apartament->Interfon;?></textarea>
				<?php 
					//echo put_item($strada->Denumire.", Nr. ".$apartament->Numar.", Bl. ".$apartament->Bloc.", Sc. ".$apartament->Scara.", Ap. ".$apartament->Apartament.", Interfon ".$apartament->Interfon,"Adresa");
					echo put_item($apartament->PunctReper, "Punct reper");
				?>
				<label class="label">Coordonate</label>
				<?php echo "Lat: ".number_format($apartament->Lat,6).", Lng: ".number_format($apartament->Lng,6);?>
			</fieldset>
			<div id="map_canvas" class="ui-widget-header ui-corner-all" style="width:317px; height:200px; margin:3px;"></div>
		</div>
	</div>
	</div>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;min-height: 20px;"></div>
</form>
</body>
</html>