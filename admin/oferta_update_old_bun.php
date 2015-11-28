<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

if ((isset($_POST['submit']))||(isset($_POST['actualizare']))) {
	//print_r($_POST);
	$OfertaId=$_POST['xOfertaId'];
	$oferta=Oferta::find_by_id($OfertaId);
	$oferta->Vanzare="";
	$oferta->Inchiriere="";
	$oferta->OfertaSpeciala="";
	$oferta->OfertaWeb="";
	$oferta->Exclusivitate="";
	$oferta->Negociabil="";
		
	$apartament=Apartament::find_by_id($oferta->idApartament);
	$apartament->Subsol="";
	$apartament->Demisol="";
	$apartament->Parter="";
	$apartament->Mansarda="";
	$apartament->Pod="";
	$apartament->Duplex="";
	$apartament->ConstructiePeTeren="";
	$apartament->Vitrina="";
	
	
	
	$client=Client::find_by_id($apartament->idClient);
	$agent=User::find_by_id($client->idUtilizator);
		
	$subzona=Subzona::find_by_id($apartament->idSubzona);
	$sursa=Sursa::find_by_id($apartament->idSursa);
	
	$dotariList=array();
	
	$syncList=array('ExportPitagora','ExportImobiliare','ExportCI','ExportRoImobile','ExportRomimo', 'ExportNorc' , 'ExportMC');
	
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}
		$atribut=substr(array_shift(explode("_", $variable)),2);
		//echo $variable."\n";
		if (substr($variable,0,2)=="Ap") {
			$apartament->{$atribut}=${$variable};
		}
		if (substr($variable,0,2)=="Cl") {
			$client->{$atribut}=${$variable};
		}
		if (substr($variable,0,2)=="Of") {
			if (in_array($atribut, $syncList)){
				$syncsite=$atribut;
				$oferta->{$syncsite}=(($oferta->{$syncsite}>1) ? 2 : 1);
			}
			else {	$oferta->{$atribut}=${$variable};
			}
		}
		if (substr($variable,0,2)=="Dt") {
			$dotariList[]=substr($variable,4);
		}
		if (substr($variable,0,2)=="Cb") {
			if(${$variable}!=""){
				$dotariList[]=${$variable};
			}
		}
	}
	
	foreach ($syncList as $sync) {
		if (!isset(${"Of".$sync})) {
			$oferta->{$sync}=($oferta->{$sync}>1 ? 3 : 0);
		}
	}
	//print_r($apartament);
	//print_r($client);
	
	// creare/actializare apartament
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$apartament->idStrada)."' LIMIT 1";
	$stradaL=Strada::find_by_sql($sql);
	$strada=array_shift($stradaL);
	$apartament->idStrada=$strada->id;
	
	$sql="SELECT * FROM Subzona WHERE Denumire='".str_replace("%20"," ",$apartament->idSubzona)."' LIMIT 1";
	$SubzonaL=Subzona::find_by_sql($sql);
	$subzona=array_shift($SubzonaL);
	$apartament->idSubzona=$subzona->id;
	//$apartament->idClient=$ClientId;
	$apartament->DataIntrare=convert_date($apartament->DataIntrare,1);
	//$apartament->DataActualizare=date("Y-m-d");
	$apartament->save();
	
	
	// actializare oferta
	$oferta->idApartament=$apartament->id;
	$oferta->Data=convert_date($oferta->Data,1);
	if (isset($_POST['actualizare'])) {
		$oferta->DataActualizare=date("Y-m-d");
	}
	else {$oferta->DataActualizare=convert_date($oferta->DataActualizare,1);
	}
	
	//$oferta->Vanzare=1;
	$oferta->save();
	
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$client->idStrada)."' LIMIT 1";
	//print_r($_POST);
	$stradaLc=Strada::find_by_sql($sql);
	$strada=array_shift($stradaLc);
	$client->idStrada=$strada->id;
	$client->save();
	
	$sql="SELECT * FROM DotareApartament WHERE idApartament='{$apartament->id}'";
	$DAList=Dotareapartament::find_by_sql($sql);
	if (!empty($DAList)) {
		foreach($DAList as $dotAP){
			$dotAP->delete();
		}
	}
	
	if (!empty($dotariList)){
		foreach ($dotariList as $dotare){
			$dotAp=new Dotareapartament();
			$dotAp->idApartament=$apartament->id;
			$dotAp->idDotare=$dotare;
			$dotAp->save();
		}
	}
	redirect_to("oferta_view.php?id=".$oferta->id);
}
else {
	$xOfertaId=$_GET['id'];
	$oferta=Oferta::find_by_id($xOfertaId);
	$apartament=Apartament::find_by_id($oferta->idApartament);
	$client=Client::find_by_id($apartament->idClient);
	$agent=User::find_by_id($client->idUtilizator);
	$agentIntroducere=User::find_by_id($oferta->idAgentIntroducere);
	$agentVizionare=User::find_by_id($oferta->idAgentInchiriere);
	$agentLucreaza=User::find_by_id($oferta->IdAgentVanzare);
	$strada=Strada::find_by_id($apartament->idStrada);
	$stradaClient=Strada::find_by_id($client->idStrada);
	$subzona=Subzona::find_by_id($apartament->idSubzona);
	$sursa=Sursa::find_by_id($apartament->idSursa);
	switch ($apartament->TipProprietate) {
		case 0: $tipprop="xa";
		break;
		case 1: $tipprop="xb";
		break;
		case 2: $tipprop="xc";
		break;
		case 3: $tipprop="xt";
		break;
		case 4: $tipprop="xs";
		break;
		default: $tipprop="xa";
	}
}

function put_item($label,$var,$value="",$file,$prop,$ralign=0,$size=0)
{
	if ($value=="0") $value="";
	$style="";
	if ($ralign) $style=" text-align:right;";
	if ($size>0) $style.=" width:{$size}px;";
	if ($style!="") $style=" style=\"{$style}\"";
	$item="<label class=\"label\" id=\"label".$var."_".$prop."\">{$label}</label>";
	$item.="<input type=\"text\" class=\"standard\"{$style} value=\"{$value}\" id=\"".$var."_".$prop."\" name=\"{$file}".$var."\" ></input>";
	return $item;
}

function put_protected_item($var,$label,$tip="",$ralign=0,$size=0) {
	if (($tip=="T")&&($var=="")) return "";
	if (($tip=="N")&&($var<=0)) return "";
	$style="";
	if ($ralign) $style=" text-align:right;";
	if ($size>0) $style.=" width:{$size}px;";
	if ($style!="") $style=" style=\"{$style}\"";
	$item="<label class=\"label\">{$label}</label>";
	$item.="<input type=\"text\" class=\"standard\"{$style} disabled=\"disabled\" value=\"{$var}\" ></input>";
	return $item;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Modificare proprietate</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
   	
   	<link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/jscal2.css" />
   	<link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/gold/gold.css" />
   	<script type="text/javascript" src=".././javascripts/jscal/js/jscal2.js"></script>
   	<script type="text/javascript" src=".././javascripts/jscal/js/lang/en.js"></script>
   	
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
    <script type="text/javascript" src=".././javascripts/subzonahint2.js"></script>
    <script type="text/javascript">
		var map =null;
		$(function(){
			hide("divStradaHint2");
			$("form").form();
			$("#tabs").tabs();

			$("#formular").validate({
		   		rules: {
		   			ApTipProprietate: {
			    		required: true,
			    		min:0
			    	},
			    	ApDetalii : {
			    		maxlength: 780
			    	},
		   			ApidSubzona: "required",
				    ApidStrada:	"required",
				    OfVanzare:{
					    required: "#OfInchiriere:unchecked"
					},
			    	OfInchiriere:{
					    required: "#OfVanzare:unchecked"
					}
		    	}
		    });
			
		});
	
		function onClick_inapoi(id){
			document.location = ("oferta_view.php?id=" + id);;
		}

		function initialize() {
		    var latlng = new google.maps.LatLng(<?php echo ( $apartament->Lat>0 ? $apartament->Lat : 44.4257);?>, <?php echo ($apartament->Lng ? $apartament->Lng : "26.115");?>);
		    var myOptions = {
		      zoom: 11,
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

		    
		  	
		    map.zoomIn();
		    map.checkResize();
		}

		function fixeaza(){
			var ctr = map.getCenter();
			//var lg =ctr.Longitude;
			//var lt=ctr.Latitude;
			//alert(ctr.lng().toString());
			var lat=document.getElementById("ApLat");
			lat.value=ctr.lat().toString();
			var lng=document.getElementById("ApLng");
			lng.value=ctr.lng().toString();
		}

		function toggle(switchElement){
			if (switchElement.value=="0") {
				showOnly("xa");
			}
			if (switchElement.value=="1") {
				showOnly("xb");
			}
			if (switchElement.value=="2") {
				showOnly("xc");
			}
			if (switchElement.value=="3") {
				showOnly("xt");
			}
			if (switchElement.value=="4") {
				showOnly("xs");
			}

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

		function hide(menu){
			var menuStyle=document.getElementById(menu).style;
			menuStyle.display="none";
			// <link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/border-radius.css" />
		}
		function show(menu) {
			var menuStyle=document.getElementById(menu).style;
			menuStyle.display="block";
			
		}

	</script>
</head>
<body onload="initialize()">
<form action="oferta_update.php" method="post" id="formular">
	<input type='hidden' name='xOfertaId' value="<?php echo htmlentities($xOfertaId);?>" />
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $oferta->id;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="salveaza" />
		<input type="submit" name="actualizare" id="actualizeaza" value="salvare cu actualizare" />
	</div>

	<div id="tabs"> 
		<ul>
			<li><a href="#oferta">Detalii</a></li>
			<li><a href="#dotari">Dotari</a></li>
			<li><a href="#harta">Harta</a></li>
			<li><a href="#promovare">Promovare</a></li>
			<li><a href="#client">Client</a></li>
		</ul>
		
		<div id="oferta" style="overflow:auto; background-color: rgb(255,248,226);">
			<div style="display: inline-block; float: left">
				
				<fieldset>
					<legend>oferta <?php echo "SP".str_pad($oferta->id,5,"0",STR_PAD_LEFT);?></legend>
					<table width="100%">
						<tr>
							<td>
								<span id="vanz_xaxbxcxtxs">vanzare</span><input type="checkbox" id="OfVanzare" name="OfVanzare" <?php if ($oferta->Vanzare==1) {echo "checked=\"checked\"";}?> value="1"></input>
							</td>
							<td>
								<div id="inchi_xaxbxcxs">chirie<input type="checkbox" id="OfInchiriere" name="OfInchiriere" <?php if ($oferta->Inchiriere==1) {echo "checked=\"checked\"";}?> value="1"></input></div>
							</td>
							<td>
								<div id="neg_xaxbxcxtxs"><span >neg.</span><input type="checkbox" id="Negociabil" name="OfNegociabil" <?php if ($oferta->Negociabil==1) {echo "checked=\"checked\"";}?> value="1"></input></div>
							</td>
							<td align="right">
								<span id="vanz_xaxbxcxtxs">exclusiv</span><input type="checkbox" id="Exclusivitate" name="OfExclusivitate" <?php if ($oferta->Exclusivitate==1) {echo "checked=\"checked\"";}?> value="1"></input>
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
							<td  width="50%" align="center">
								<input id="OfPret" name="OfPret" class="standard" style="width: 130px;" value="<?php echo $oferta->Pret;?>"  ></input>
							</td>
							<td  width="50%" align="center">
								<input id="OfPretChirie" name="OfPretChirie" class="standard" style="width: 130px;" value="<?php echo $oferta->PretChirie;?>"></input>
							</td>
						</tr>
						<tr>
							<td class="column ui-widget-header ui-corner-all" width="50%" align="left">
									pret initial
							</td>
							<td class="column ui-widget-header ui-corner-all" width="50%" align="right">
								pret final
							</td>
						</tr>
						<tr>
							<td  width="50%" align="center">
								<input id="OfPretInitial" name="OfPretInitial" class="standard" style="width: 130px;" value="<?php echo $oferta->PretInitial;?>"  ></input>
							</td>
							<td  width="50%" align="center">
								<input id="OfPretFinal" name="OfPretFinal" class="standard" style="width: 130px;" value="<?php echo $oferta->PretFinal;?>"  ></input>
							</td>
						</tr>
					</table>
					<label class="label">moneda</label><select class="standard" id="OfMoneda" name="OfMoneda">
						<option value='RON' <?php if ($oferta->Moneda=="RON"){ echo " selected='selected'";} ?>>RON</option>
						<option value='EUR' <?php if ($oferta->Moneda=="EUR"){ echo " selected='selected'";} ?>>EUR</option>
						<option value='USD' <?php if ($oferta->Moneda=="USD"){ echo " selected='selected'";} ?>>USD</option>
						<option value='CHF' <?php if ($oferta->Moneda=="CHF"){ echo " selected='selected'";} ?>>CHF</option>
					</select>
					<?php echo put_item("comision vanzator", "Comision", $oferta->Comision, "Of", "")?>
					<?php echo put_item("comision client", "ComisionClient", $oferta->ComisionClient, "Of", "")?>
					<label class="label">comision client 0</label><input type="checkbox" id="ComisionCumparatorZero" name="OfComisionCumparatorZero" <?php if ($oferta->ComisionCumparatorZero==1) {echo "checked=\"checked\"";}?> value="1">
					<span style="margin-left: 73px;">of. speciala</span><input type="checkbox" id="OfertaSpeciala" name="OfOfertaSpeciala" <?php if ($oferta->OfertaSpeciala==1) {echo "checked=\"checked\"";}?> value="1">
					<br/>
					
					<label class="label">data adaugare</label><input class="standard" style="width: 145px;" type="text"  id="ApDataIntrare" name="ApDataIntrare" value=<?php echo convert_date($apartament->DataIntrare)?>></input>
					<input type="button" id="ApDataIntrare-trigger" value="..."/>
					
					<label class="label">data in piata</label><input class="standard" style="width: 145px;" type="text" id="OfDataIntrareInPiata" name="OfDataIntrareInPiata" value="<?php echo convert_date($oferta->DataIntrareInPiata);?>"></input>
					<input type="button" id="DataIntrareInPiata-trigger" value="..."/>
					
					<label class="label">data actualizare</label><input class="standard" style="width: 145px;" type="text"  id="OfDataActualizare" name="OfDataActualizare" value="<?php echo convert_date($oferta->DataActualizare)?>"></input>
					<input type="button" id="DataActualizare-trigger" value="..."/>
					<label class="label">stare</label><select class="standard" id="OfStare" name="OfStare">
						<option value="de actualitate" <?php if ($oferta->Stare=="de actualitate") {echo "selected";}?>>de actualitate</option>
						<option value="precontract" <?php if ($oferta->Stare=="precontract") {echo "selected";}?>>precontract</option>
						<option value="vandut de noi" <?php if ($oferta->Stare=="vandut de noi") {echo "selected";}?>>vandut de noi</option>
						<option value="vandut de altii" <?php if ($oferta->Stare=="vandut de altii") {echo "selected";}?>>vandut de altii</option>
						<option value="stand by" <?php if ($oferta->Stare=="stand by") {echo "selected";}?>>stand by</option>
					</select>
					<label class="label">sursa</label><select class="standard" id="ApidSursa" name="ApidSursa">
						<?php 
							$sursalist=Sursa::find_all();
							foreach ($sursalist as $xsursa) {
								echo "<option ";
								if($apartament->idSursa==$sursa->id){ echo " selected='selected'";};
								echo " value='".$xsursa->id."'>".$xsursa->Descriere;
								echo "</option>";
							}
						?>
					</select>
				</fieldset>
				<script type="text/javascript">
					var cal1=Calendar.setup({onSelect:function(){cal1.hide();}});
					cal1.manageFields("ApDataIntrare-trigger", "ApDataIntrare", "%d/%m/%Y");
					var cal2=Calendar.setup({onSelect:function(){cal1.hide();}});
					cal1.manageFields("DataIntrareInPiata-trigger", "OfDataIntrareInPiata", "%d/%m/%Y");
					var cal3=Calendar.setup({onSelect:function(){cal1.hide();}});
					cal1.manageFields("DataActualizare-trigger", "OfDataActualizare", "%d/%m/%Y");
				</script>
				
				<fieldset>
					<legend>Broker</legend>
					<?php $agentList=User::find_all(); ?>
					
					<?php if ($agentIntroducere) echo put_protected_item($agentIntroducere->full_name(), "adaugat");?>
					<label class="label">adaugare</label><select class="standard" id="OfidAgentIntroducere" name="OfidAgentIntroducere">
						<option value=''> </option>
					<?php 
						foreach ($agentList as $agentx){
							echo "<option value='{$agentx->id}'";
							if ($agentx->id==$oferta->idAgentIntroducere) {
								echo " selected='selected' ";
							}
							echo ">{$agentx->full_name()}</option>";
						}
					?>
					</select>
					<label class="label">lucreaza</label><select class="standard" id="OfIdAgentVanzare" name="OfIdAgentVanzare">
						<option value=''> </option>
					<?php 
						foreach ($agentList as $agentx){
							echo "<option value='{$agentx->id}'";
							if ($agentx->id==$oferta->IdAgentVanzare) {
								echo " selected='selected' ";
							}
							echo ">{$agentx->full_name()}</option>";
						}
					?>
					</select>
					<label class="label">evaluat</label><select class="standard" id="OfidAgentInchiriere" name="OfidAgentInchiriere">
						<option value=''> </option>
					<?php 
						foreach ($agentList as $agentx){
							echo "<option value='{$agentx->id}'";
							if ($agentx->id==$oferta->idAgentInchiriere) {
								echo " selected='selected' ";
							}
							echo ">{$agentx->full_name()}</option>";
						}
					?>
					</select>
					
				</fieldset>
			</div>
			<div style="display: inline-block; float: left">
				<fieldset>
					<legend>detalii <?php echo tip_proprietate($apartament->TipProprietate);?></legend>
					<label></label>
					<label class="label">tip proprietate</label><select class="standard" id="ApTipProprietate" name="ApTipProprietate" onchange="toggle(this)">
						<option value="0" <?php if ($apartament->TipProprietate==0){ echo " selected='selected'";} ?>>apartament</option>
						<option value="1" <?php if ($apartament->TipProprietate==1){ echo " selected='selected'";} ?>>apartament in vila</option>
						<option value="2" <?php if ($apartament->TipProprietate==2){ echo " selected='selected'";} ?>>casa / vila</option>
						<option value="3" <?php if ($apartament->TipProprietate==3){ echo " selected='selected'";} ?>>teren</option>
						<option value="4" <?php if ($apartament->TipProprietate==4){ echo " selected='selected'";} ?>>spatiu</option>
					</select>
					<label id="LabelApNumarCamere_xaxbxcxs" class="label">camere</label><select class="standard" id="ApNumarCamere_xaxbxcxs" name="ApNumarCamere">
						<option value=''> </option>
						<option id="optCam1_xaxb" value='1' <?php if ($apartament->NumarCamere==1) {echo "selected";}?> >garsoniera</option>
						<?php 
							for ($i=2;$i<=20;$i++) {
								echo "<option value='{$i}' ";
								if ($apartament->NumarCamere==$i) {
									echo "selected=\"selected\"";
								}
								echo ">{$i} camere </option>";
							}
						?>
					</select>
					<label id="LabelApConfort_xa" class="label">confort</label><select class="standard" id="ApConfort_xa" name="ApConfort">
						<option value='1' <?php if ($apartament->Confort==1) {echo "selected";}?>>confort I</option>
						<option value='2' <?php if ($apartament->Confort==2) {echo "selected";}?>>confort II</option>
					</select>
					<label id="LabelApTipApartament_xaxb" class="label">tip apartament</label><select class="standard" id="ApTipApartament_xaxb" name="ApTipApartament">
						<option value=''> </option>
						<option value='Decomandat' <?php if ($apartament->TipApartament=="Decomandat") {echo "selected";}?>>decomandat</option>
						<option value='Semidecomandat' <?php if ($apartament->TipApartament=="Semidecomandat") {echo "selected";}?>>semidecomandat</option>
						<option value='Comandat' <?php if ($apartament->TipApartament=="Comandat") {echo "selected";}?>>comandat</option>
						<option value='Circular' <?php if ($apartament->TipApartament=="Circular") {echo "selected";}?>>circular</option>
					</select>
					<label id="LabelApTipConstructie_xaxs" class="label">tip constructie</label><select id="ApTipConstructie_xaxs" name="ApTipConstructie" class="standard">
						<option value=''> </option>
						<option value='Mixt' id="opttip1_xa" <?php if ($apartament->TipConstructie=="Mixt") {echo "selected";} ?>>bloc mixt</option>
						<option value='Garsoniere'  id="opttip2_xa"  <?php if ($apartament->TipConstructie=="Garsoniere") {echo "selected";} ?>>bloc de garsoniere</option>
						<option value='bloc'  id="opttip3_xs"  <?php if ($apartament->TipConstructie=="bloc") {echo "selected";} ?>>bloc</option>
						<option value='cladire de birouri' id="opttip4_xs" <?php if ($apartament->TipConstructie=="cladire de birouri") {echo "selected";} ?>>cladire de birouri</option>
						<option value='hala' id="opttip5_xs" <?php if ($apartament->TipConstructie=="hala") {echo "selected";} ?>>hala</option>
						<option value='depozit' id="opttip6_xs" <?php if ($apartament->TipConstructie=="depozit") {echo "selected";} ?>>depozit</option>
						<option value='casa/vila' id="opttip6_xs" <?php if ($apartament->TipConstructie=="casa/vila") {echo "selected";} ?>>casa/vila</option>
						<option value='hotel' id="opttip6_xs" <?php if ($apartament->TipConstructie=="hotel") {echo "selected";} ?>>hotel</option>
						<option value='centru comercial' id="opttip6_xs" <?php if ($apartament->TipConstructie=="centru comercial") {echo "selected";} ?>>centru comercial</option>
						
					</select>
					<div id="dup_xaxb" style="display: block;"><label id="LabelDuplex" class="label">duplex</label><input type="checkbox" id="ApDuplex" name="ApDuplex"  <?php if ($apartament->Duplex==1) {echo "checked=\"checked\"";}?> value="1"></input><br/></div>
					<div id="EtajeDiv_xaxb"><label class="label">suprafete duplex</label>   
						1<input type="text" class="standard" value="<?php if ( $apartament->SuprafataEtaj1>0) echo $apartament->SuprafataEtaj1?>" name="ApSuprafataEtaj1" style="width: 30px;" ></input>
						2<input type="text" class="standard" value="<?php if ( $apartament->SuprafataEtaj2>0) echo $apartament->SuprafataEtaj2?>" name="ApSuprafataEtaj2" style="width: 30px;" ></input>
					 </div>
					<div id="etajdiv_xaxbxs">
						<label id="LabelApEtaj_xaxbxs" class="label">etaj</label><select id="ApEtaj_xaxbxs" name="ApEtaj_xaxbxs" class="standard" style="width: 60px;">
							<option value='' selected="selected"> </option>
							<option id="OptSubsol_xbxcxs" value='-3' <?php if ($apartament->Etaj==-3) {echo "selected";} ?>>subsol</option>
							<option id="OptDemisol_xbxcxs" value='-2' <?php if ($apartament->Etaj==-2) {echo "selected";} ?>>demisol</option>
							<option value='0' <?php if ($apartament->Etaj=="0") {echo "selected";} ?>>parter</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option id=\"OptEtaj{$i}_xaxs".($i<4 ? "xbxc":"")."\" value='".$i."'";
									if ($apartament->Etaj==$i) {echo "selected";}
									echo ">".$i."</option>";
								}
							?>
							<option id="OptMansarda_xbxcxs" value='-1' <?php if ($apartament->Etaj==-1) {echo "selected";} ?>>mansarda</option>
						</select> <span id="spanDin_xa">din</span> 
						<select id="ApEtajeBloc_xa" name="ApEtajeBloc" class="standard" style="width: 50px;">
							<option value=''> </option>
							<option value='0' <?php if ($apartament->EtajeBloc==0) {echo "selected";}?>>P</option>
							<?php 
								for ($i = 1; $i < 25; $i++) {
									echo "<option value='".$i."'";
									if ($apartament->EtajeBloc==$i) {echo "selected";}
									echo ">".$i."</option>";
								}
							?>
						</select>
					</div>
					<div id="structuradiv_xbxcxtxs">
						<label class="label" style="width: 74px;">structura</label>s<input type="checkbox" id="ApSubsol" name="ApSubsol"  <?php if ($apartament->Subsol==1) {echo "checked=\"checked\"";}?> value="1"></input>d<input type="checkbox" id="ApParter" name="ApDemisol"  <?php if ($apartament->Demisol==1) {echo "checked=\"checked\"";}?> value="1"></input>p<input type="checkbox" id="ApParter" name="ApParter"  <?php if ($apartament->Parter==1) {echo "checked=\"checked\"";}?> value="1"></input> <select id="ApEtaje" name="ApEtaje" class="standard" style="width: 40px;">
						<option value=''> </option>
						<?php 
							for ($i = 1; $i < 25; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->Etaje=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
						m<input type="checkbox" id="ApMansarda" name="ApMansarda"  <?php if ($apartament->Mansarda==1) {echo "checked=\"checked\"";}?> value="1"></input>p<input type="checkbox" id="ApPod" name="ApPod"  <?php if ($apartament->Pod==1) {echo "checked=\"checked\"";}?> value="1"></input>
					</div>
					
					<?php echo put_item("an constructie", "AnConstructie", $apartament->AnConstructie, "Ap", "xaxbxcxs")?>
					<?php echo put_item("an renovare", "AnRenovare", $apartament->AnRenovare, "Ap", "xaxbxcxs")?>
					<label class="label" id="LabelNrGrupuriSanitare_xaxbxcxs">grupuri sanitare</label><select id="NrGrupuriSanitare_xaxbxcxs" name="ApNrGrupuriSanitare" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 1; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NrGrupuriSanitare=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelNumarBalcoane_xaxb">balcoane</label><select id="NumarBalcoane_xaxb" name="ApNumarBalcoane" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 0; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarBalcoane=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelNumarBucatarii_xc">bucatarii</label><select id="NumarBucatarii_xc" name="ApNumarBucatarii" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 0; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarBucatarii=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelNumarTerase_xaxbxc">terase</label><select id="NumarTerase_xaxbxc" name="ApNumarTerase" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 0; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarTerase=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelNumarParcari_xaxbxcxs">parcari</label><select id="NumarParcari_xaxbxcxs" name="ApNumarParcari" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 0; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarParcari=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelNumarGaraje_xaxbxcxs">garaje</label><select id="NumarGaraje_xaxbxcxs" name="ApNumarGaraje" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 0; $i < 10; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarGaraje=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<?php echo put_item("sup utila", "SuprafataUtila", $apartament->SuprafataUtila, "Ap", "xaxbxcxtxs")?>  
					<?php echo put_item("sup totala constr.", "SuprafataConstruita", $apartament->SuprafataConstruita, "Ap", "xaxbxcxt")?> 
					<?php echo put_item("s balcoane/terase", "SuprafataTerasa", $apartament->SuprafataTerasa, "Ap", "xaxbxc")?>
					
					<?php echo put_item("sup teren", "SuprafataCurte", $apartament->SuprafataCurte, "Ap", "xbxc")?>
					<?php echo put_item("amprenta sol", "AmprentaSol", $apartament->AmprentaSol, "Ap", "xc")?>
					<?php echo put_item("deschidere", "Deschidere", $apartament->Deschidere, "Ap", "xcxt")?>
					<label class="label" id="LabelNumarDeschideri_xcxsxt">nr deschideri</label><select id="NumarDeschideri_xcxsxt" name="ApNumarDeschideri" class="standard">
						<option value=''> </option>
						<?php 
							for ($i = 1; $i < 5; $i++) {
								echo "<option value='".$i."'";
								if ($apartament->NumarDeschideri=="{$i}") {echo "selected";}
								echo ">".$i."</option>";
							}
						?>
					</select>
					<label class="label" id="LabelTipCurte_xbxc">tip curte</label><select id="TipCurte_xbxc" name="ApTipCurte" class="standard">
						<option value=''> </option>
						<option value='comuna' <?php if ($apartament->TipCurte=='comuna') {echo "selected";}?> >comuna</option>
						<option value='individuala' <?php if ($apartament->TipCurte=='individuala') {echo "selected";}?> >individuala</option>
					</select>
					<label class="label" id="LabelTipIntrare_xb">tip intrare</label><select id="TipIntrare_xb" name="ApTipIntrare" class="standard">
						<option value=''> </option>
						<option value='comuna' <?php if ($apartament->TipCurte=='comuna') {echo "selected";}?> >comuna</option>
						<option value='individuala' <?php if ($apartament->TipCurte=='individuala') {echo "selected";}?> >individuala</option>
					</select>
					<?php echo put_item("lat. drum acces", "LatimeDrumAcces", $apartament->LatimeDrumAcces, "Ap", "xt")?>
					<?php echo put_item("POT", "POT", $apartament->POT, "Ap", "xt")?>
					<?php echo put_item("CUT", "CUT", $apartament->CUT, "Ap", "xt")?>
					<?php echo put_item("inclinatie", "Inclinatie", $apartament->Inclinatie, "Ap", "xt")?>
					<div id="ConstructiePeTerenDiv_xt" style="display: block;"><label id="LabelConstructiePeTeren" class="label">constructie pe el</label><input type="checkbox" id="ApConstructiePeTeren" name="ApConstructiePeTeren"  <?php if ($apartament->ConstructiePeTeren=='1') {echo "checked=\"checked\"";}?> value="1"></input><br/></div>
					<?php echo put_item("destinatie", "Destinatie", $apartament->Destinatie, "Ap", "xs")?>
					<label class="label" id="LabelTipTeren_xt">tip teren</label><select id="TipTeren_xt" name="ApTipTeren" class="standard">
						<option value=''> </option>
						<option value='constructii' <?php if ($apartament->TipTeren=='constructii') {echo "selected";}?> >constructii</option>
						<option value='agricol' <?php if ($apartament->TipTeren=='agricol') {echo "selected";}?> >agricol</option>
						<option value='padure' <?php if ($apartament->TipTeren=='padure') {echo "selected";}?> >padure</option>
					</select>
					<label class="label" id="LabelClasificare_xt">clasificare</label><select id="Clasificare_xt" name="ApClasificare" class="standard">
						<option value=''> </option>
						<option value='intravilan' <?php if ($apartament->Clasificare=='intravilan') {echo "selected";}?> >intravilan</option>
						<option value='extravilan' <?php if ($apartament->Clasificare=='extravilan') {echo "selected";}?> >extravilan</option>
					</select>
					<label class="label" id="LabelTipSpatiu_xs">tip spatiu</label><select id="TipSpatiu_xs" name="ApTipSpatiu" class="standard">
						<option value=''> </option>
						<option value='birouri' <?php if ($apartament->TipSpatiu=='birouri') {echo "selected";}?> >birouri</option>
						<option value='comercial' <?php if ($apartament->TipSpatiu=='comercial') {echo "selected";}?> >comercial</option>
						<option value='industrial' <?php if ($apartament->TipSpatiu=='industrial') {echo "selected";}?> >industrial</option>
						<option value='hotel' <?php if ($apartament->TipSpatiu=='hotel') {echo "hotel";}?> >hotel</option>
					</select>
					<?php echo put_item("inaltime spatiu", "Inaltime", $apartament->Inaltime, "Ap", "xs")?>
					<div id="divvitrina_xs" style="display: block;"><label id="LabelVitrina" class="label">vitrina</label><input type="checkbox" id="ApVitrina" name="ApVitrina"  <?php if ($apartament->Vitrina==1) {echo "checked=\"checked\"";}?> value="1"></input><br/></div>
					<label class="label" id="LabelClasaBirouri_xs">clasa birouri</label><select id="ClasaBirouri_xs" name="ApClasaBirouri" class="standard">
						<option value=''> </option>
						<option value='A' <?php if ($apartament->TipSpatiu=='A') {echo "selected";}?> >A</option>
						<option value='B' <?php if ($apartament->TipSpatiu=='B') {echo "selected";}?> >B</option>
						<option value='C' <?php if ($apartament->TipSpatiu=='C') {echo "selected";}?> >C</option>
					</select>
				</fieldset>
			</div>
			<div style="display: inline-block; float: left">
				<fieldset style="vertical-align: top;">
					<legend>descriere</legend>
					<label class="label" style="vertical-align: top;">titlu</label><textarea  style="width:175px;min-height:35px;" name="OfTitlu"><?php echo htmlentities($oferta->Titlu);?></textarea>
					<label class="label" style="vertical-align: top;">descriere</label><textarea  style="width:175px;min-height:95px;" name="ApDetalii"><?php echo htmlentities($apartament->Detalii);?></textarea>
					<label class="label" style="vertical-align: top;">comentarii</label><textarea  style="width:175px;min-height:35px;" name="ApDetaliiInterne"><?php echo htmlentities($apartament->DetaliiInterne);?></textarea>
				</fieldset>
				<fieldset>
					<legend>localizare</legend>
					<label class="label">subzona</label><input type="text" id="Subzona" name="ApidSubzona" class="standard" onkeyup="showSubzonaHint(this.value)" value="<?php echo $subzona->Denumire; ?>"></input>
					<div id="divSubzonaHint" class="hint" style="margin-left: 105px;"></div>
					<label class="label">strada</label><input type="text" class="standard" id="Strada" name="ApidStrada" value="<?php echo $strada->Denumire;?>" onkeyup="showHint(this.value)"></input>
					<div id="divStradaHint" class="hint" style="margin-left: 105px;"></div>
					<?php echo put_item("numar", "Numar", $apartament->Numar, "Ap", "")?>
					<?php echo put_item("bloc", "Bloc", $apartament->Bloc, "Ap", "xaxs")?>
					<?php echo put_item("scara", "Scara", $apartament->Scara, "Ap", "xaxs")?>
					<?php echo put_item("apartament", "Apartament", $apartament->Apartament, "Ap", "xaxbxs")?>
					<?php echo put_item("interfon", "Interfon", $apartament->Interfon, "Ap", "xaxbxcxs")?>
					<label class="label">sector</label><select name='ApSector' class="standard" >
						<option value=''> - </option>
						<?php 
							for ($i=1;$i<=6;$i++){
								echo "<option value='".$i."'";
								if ($apartament->Sector=="{$i}"){ echo " selected";};
								echo ">Sector ".$i."</option>";
							}
							?>
					</select>
					
					<?php echo put_item("punct reper", "PunctReper", $apartament->PunctReper, "Ap", "")?>
				</fieldset>
				<script type="text/javascript">
					hide("divStradaHint");
					hide("divSubzonaHint");
				</script>
			</div>
			
		</div>
		
		<div id="dotari" style="overflow:auto; background-color: rgb(255,248,226); ">
			<div style="display: inline-block; width:165px; float: left;">
				<div>
			<?php 		//Dotari
				$tipp=$apartament->TipProprietate+1;
				$sql="SELECT * FROM CategorieDotari where TipControl='1' ORDER BY Prioritate";   ///
				$categorieDotariList=Categoriedotari::find_by_sql($sql);
				if (!empty($categorieDotariList)) {
						$rows=0;
			   			foreach($categorieDotariList as $categorie){
			   				$rows=$rows+2;
			   				if ($rows>24) {
			   					$rows=2;
			   					echo "</div></div>";
			   					echo "<div style=\"display: inline-block; width:165px; float: left\"><div>";
			   				}
			?>
				<fieldset style="width: 140px;" id="FS<?php echo $categorie->id."_".$categorie->Proprietati;?>">
					<legend><?php echo $categorie->Descriere;?></legend>
							<?php 
					   		$sql="SELECT * FROM Dotare WHERE idCategorieDotari={$categorie->id} ORDER BY Descriere";
					   		$dotareList=Dotare::find_by_sql($sql);
					   		if (!empty($dotareList)) {
					   			foreach($dotareList as $dotare){
					   				//echo $dotare->Proprietati,$tipprop);
					   				if ((strpos($categorie->Proprietati,$tipprop)!==false)&&((strpos($dotare->Proprietati,$tipprop)!==false)||($dotare->Proprietati==''))) {$rows++;}
					   				if ($rows>24) {
					   					$rows=2;
					   					echo "</fieldset></div></div>";
					   					echo "<div style=\"display: inline-block; width:165px; float: left\"><div><fieldset style=\"width: 140px;\" id=\"FS{$categorie->id}_{$categorie->Proprietati}\">";
					   					echo "<legend>{$categorie->Descriere}...</legend>";
					   				}
									//echo put_check_item_obj($dotare->Descriere,"DtID".$dotare->id);
									$sql="SELECT * FROM DotareApartament WHERE idDotare='{$dotare->id}' AND idApartament='{$apartament->id}' LIMIT 1";
									$dotapList=Dotareapartament::find_by_sql($sql);
									
							?>
					<div id="divDT<?php echo $dotare->id."_".$dotare->Proprietati;?>"><label class="label"><?php echo $dotare->Descriere;?></label><input type="checkbox" name="DtID<?php echo $dotare->id;?>" value="1" <?php if (!empty($dotapList)) {echo "checked=\"checked\"";}?> ></input><br/></div>
					<?php 			}
						   		}
		   			?>
				</fieldset>
				<?php 	}
				}?>
				</div>
			</div>
			
			
			<div style="display: inline-block; width:325px; float: left">
				<div>
			<?php 		//Dotari
				$tipp=$apartament->TipProprietate+1;
				$sql="SELECT * FROM CategorieDotari where TipControl='2' ORDER BY Prioritate";
				$categorieDotariList=Categoriedotari::find_by_sql($sql);
				if (!empty($categorieDotariList)) {
						$rows=0;
			   			foreach($categorieDotariList as $categorie){
			   				$rows=$rows+2;
			   				if ($rows>22) {
			   					$rows=0;
			   					echo "</div></div>";
			   					echo "<div style=\"display: inline-block; width:325px; float: left\"><div>";
			   				}
			?>
				<fieldset id="FS<?php echo $categorie->id."_".$categorie->Proprietati;?>">
					<legend><?php echo $categorie->Descriere;?></legend>
							<?php 
					   		$sql="SELECT * FROM Dotare WHERE idCategorieDotari={$categorie->id} ORDER BY Descriere";
					   		$dotareList=Dotare::find_by_sql($sql);
					   		if (!empty($dotareList)) {
					   			?>
					<label class="label"><?php echo $categorie->Descriere;?></label><select name="CbDt<?php echo $categorie->id;?>" class="standard">
						<option value="" selected="selected">alegeti...</option>
					   			<?php 		   				
					   			foreach($dotareList as $dotare){
					   				$rows++;
					   				if ($rows>22) {
					   					$rows=2;
					   					echo "</fieldset></div></div>";
					   					echo "<div style=\"display: inline-block; width:325px; float: left\"><div><fieldset>";
					   					echo "<legend>{$categorie->Descriere}...</legend>";
					   				}
									//echo put_check_item_obj($dotare->Descriere,"DtID".$dotare->id);
									$sql="SELECT * FROM DotareApartament WHERE idDotare='{$dotare->id}' AND idApartament='{$apartament->id}' LIMIT 1";
									$dotapList=Dotareapartament::find_by_sql($sql);
									
							?>
						<option id="optDT<?php echo $dotare->id."_".$dotare->Proprietati;?>" value="<?php echo $dotare->id;?>" <?php if (!empty($dotapList)) {echo "selected=\"selected\"";}?>><?php echo $dotare->Descriere;?></option>
						
					<?php 			}
					?>
					</select>
					<?php 
						   		}
		   			?>
				</fieldset>
				<?php 	}
				}?>
				</div>
			</div>
			
		</div>
		<div id="harta" style="overflow:auto;">
			<div >
				<div id="map_canvas" style="width:1000px; height:400px; "></div>
				Lat: <input type="text" name="ApLat" id="ApLat" value="<?php echo $apartament->Lat;?>" style="width:100px;" />
				Lng: <input type="text" name="ApLng" id="ApLng" value="<?php echo $apartament->Lng;?>" style="width:100px;"/>
				<input type="button" onclick="fixeaza()" value="Fixeaza pozitia" style="width: 200px;"/>
			</div>
		</div>
		<div id="promovare" style="overflow:auto;background-color: rgb(255,248,226);">
			<table style="width: 500px; padding-left: 5px;">
				<tr class="row">
					<td class="column ui-widget-header ui-corner-left" style="width: 200px">promovare</td>
					<td class="column ui-widget-header " style="width: 120px">normala</td>
					<td class="column ui-widget-header " style="width: 120px">exclusiv</td>
					<td class="column ui-widget-header ui-corner-right" style="width: 120px">top listing</td>
				</tr>
				<tr class="row odd" >
					<td class="ui-corner-left" style="padding-left: 5px;">simsparkman.ro</td>
					<td style="padding-left: 5px;" ><input type="checkbox" id="OfOfertaWeb" name="OfOfertaWeb"  <?php if ($oferta->OfertaWeb==1) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row even">
					<td class="ui-corner-left" style="padding-left: 5px;">pitagora</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportPitagora" name="OfExportPitagora"  <?php if (($oferta->ExportPitagora>0)&&($oferta->ExportPitagora!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row odd">
					<td class="ui-corner-left" style="padding-left: 5px;">imobiliare.ro</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportImobiliare" name="OfExportImobiliare"  <?php if (($oferta->ExportImobiliare>0)&&($oferta->ExportImobiliare!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row even">
					<td class="ui-corner-left" style="padding-left: 5px;">cauta imobiliare</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportCI" name="OfExportCI"  <?php if (($oferta->ExportCI>0)&&($oferta->ExportCI!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row odd">
					<td class="ui-corner-left" style="padding-left: 5px;">ro imobile</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportRoImobile" name="OfExportRoImobile"  <?php if (($oferta->ExportRoImobile>0)&&($oferta->ExportRoImobile!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row even">
					<td class="ui-corner-left" style="padding-left: 5px;">romimo</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportRomimo" name="OfExportRomimo"  <?php if (($oferta->ExportRomimo>0)&&($oferta->ExportRomimo!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row odd">
					<td class="ui-corner-left" style="padding-left: 5px;">norc</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportNorc" name="OfExportNorc"  <?php if (($oferta->ExportNorc>0)&&($oferta->ExportNorc!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
				<tr class="row even">
					<td class="ui-corner-left" style="padding-left: 5px;">magazinul de case</td>
					<td style="padding-left: 5px;"><input type="checkbox" id="OfExportMC" name="OfExportMC"  <?php if (($oferta->ExportMC>0)&&($oferta->ExportMC!=3)) {echo "checked=\"checked\"";}?> value="1"></input></td>
					<td style="padding-left: 5px;"></td>
					<td class="ui-corner-right" style="padding-left: 5px;"></td>
				</tr>
			</table>
		</div>
		<div id="client" style="overflow:auto; background-color: rgb(255,248,226);">
			<div style="display: inline-block; float: left">
				<fieldset>
					<legend>date identificare</legend>
					<dl>
						<dt><label class="label">prenume</label><input type="text" class="standard" name="ClPrenume"  value="<?php echo $client->Prenume; ?>" ></input></dt>
						<dt><label class="label">nume</label><input type="text" class="standard" name="ClNume"  value="<?php echo $client->Nume; ?>"></input></dt>
						<dt><label class="label">cnp</label><input type="text" class="standard" name="ClCNP" style="text-align: right;"  value="<?php echo $client->CNP; ?>"></input></dt>
						<dt><label class="label">c.i.</label><input type="text" id="SerieCI" name="ClSerieCI" style="width: 30px;"  value="<?php echo $client->SerieCI; ?>"></input><input type="text" style="text-align: right; width: 144px;" value="<?php echo $client->NumarCI; ?>"></input></dt>
						<dt><label class="label">pasaport</label><input type="text" class="standard" name="ClSeriePasaport" style="text-align: right;"  value="<?php echo $client->SeriePasaport; ?>" ></input></dt>
					</dl>		
				</fieldset>	
				<fieldset>
					<legend>date contact</legend>
					<dl style="margin-bottom : 0px;">
						<dt><label class="label">telefon 1</label><input type="text" class="standard" name="ClTelefonMobil" style="text-align: right;" value="<?php echo $client->TelefonMobil; ?>" ></input></dt>
						<dt><label class="label">telefon 2</label><input type="text" class="standard" name="ClTelefonFix" style="text-align: right;" value="<?php echo $client->TelefonFix; ?>" ></input></dt>
						<dt><label class="label">telefon 3</label><input type="text" class="standard" name="ClTelefonServici" style="text-align: right;" value="<?php echo $client->TelefonServici; ?>" ></input></dt>
						<dt><label class="label">telefon 4</label><input type="text" class="standard" name="ClTelefonFax" style="text-align: right;" value="<?php echo $client->TelefonFax; ?>" ></input></dt>
						<dt><label class="label">email</label><input type="text" class="standard" name="ClEmail" value="<?php echo $client->Email; ?>" ></input></dt>
						<dt><label class="label">permite SMS</label><input type="checkbox" class="standard" name="ClPermiteSMS" <?php echo ($client->PermiteSMS==1 ? "checked=\"checked\"" : "") ; ?> value="1" style="margin-top: 5px;"></input></dt>
						
					</dl>
						
				</fieldset>
			</div>
			<div style="display: inline-block; float: left">
				<fieldset>
					<legend>date administrative</legend>
					<dl>
						<dt><label class="label" style="vertical-align: top; padding-top: 5px;">detalii</label><textarea class="standard" style="min-height: 73px;"  name="ClDetalii" ><?php echo $client->Detalii;?></textarea></dt>
						<dt><label class="label">data actualizare</label><input type="text" name="ClDataActualizare" id="dataactualizare" value="<?php echo convert_date($client->DataActualizare);?>"></input>
							<input type="button" id="calendar-trigger" value='...'/><br/>
							<script>
			    				var cal1=Calendar.setup({onSelect:function(){cal1.hide();}});
			    				cal1.manageFields("calendar-trigger", "dataactualizare", "%d/%m/%Y");
							</script>
						</dt>
						<dt>
							<label class="label">agent</label><select name='ClidUtilizator' class="standard">
								<?php 
									$userlist=User::find_all();
									foreach ($userlist as $agent) {
										echo "<option ";
										if ($agent->id==$client->idUtilizator) {echo "selected='selected'";}
										echo "value='".$agent->id."'>{$agent->full_name()}";
										echo "</option>";
									}
								?>
							</select>
						</dt>
						
						
					</dl>		
				</fieldset>	
				<fieldset>
					<legend>adresa</legend>
					<label class="label">strada</label><input type="text" class="standard" id="Strada2" name="ClidStrada" value="<?php echo $stradaClient->Denumire;?>" onkeyup="showHint(this.value,2)"></input>
						<div id="divStradaHint2" class="hint" style="margin-left: 105px;"></div>
					<dl style="margin-top: 0px;">
						<dt>
							<label class="label">numar</label><input type="text" class="standard" name="ClNumar" value="<?php echo $client->Numar;?>" style="width: 30px;" ></input>
							<label>bl.</label><input type="text" class="standard" name="ClBloc" value="<?php echo $client->Bloc;?>" style="width: 30px;" ></input>
							<label>sc.</label><input type="text" class="standard" name="ClScara" value="<?php echo $client->Scara;?>" style="width: 20px;" ></input>
							<label>ap.</label><input type="text" class="standard" name="ClApartament" value="<?php echo $client->Apartament;?>" style="width: 23px;" ></input>
						</dt>
						<dt>
							<label class="label">interfon</label><input type="text" name="ClInterfon" value="<?php echo $client->Interfon;?>" style="width: 50px;" ></input>
							<label>sector</label><input type="text" class="standard" name="ClSector" value="<?php echo $client->Sector;?>" style="width: 87px;" ></input>
						</dt>
						<dt><label class="label">oras</label><input type="text" class="standard"  name="ClOras" value="<?php echo $client->Oras;?>"></input></dt>
						<dt><label class="label">judet</label><input type="text" class="standard" name="ClJudet" value="<?php echo $client->Judet;?>" ></input></dt>
						<dt><label class="label">tara</label><input type="text" class="standard" name="ClTara" value="<?php echo $client->Tara;?>"></input></dt>
					</dl>
				</fieldset>
			</div>
		</div>
	</div>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;min-height: 20px;"></div>
</form>
	<script type="text/javascript">
		showOnly("x<?php 
		switch ($apartament->TipProprietate) {
			case 0: echo "a";
					break;
			case 1: echo "b";
					break;
			case 2: echo "c";
					break;
			case 3: echo "t";
					break;
			case 4: echo "s";
					break;
			default: echo "a";
		}
	?>");
	</script>
</body>
</html>