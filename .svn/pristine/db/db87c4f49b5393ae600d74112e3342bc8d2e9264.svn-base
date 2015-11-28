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
$telefon=preg_replace("/[^0-9]/","",$telefon);
function afiseaza($var,$label,$id="") {
	if ($var=="") {return "";}
	else {
		$item="<dt".($id!=""? " id=\"{$id}\" ":"")."><span class=\"label\">{$label}</span> <span class=\"informatii\">{$var}</span></dt>";
		return $item;
	}
	return "";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - verificare telefon</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
  
   	
    <?php require_once(".././include/jquery.php");?>
    <link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src=".././javascripts/thickbox.js"></script>
    
    <script type="text/javascript">
	    function clientView(id){
			document.location = "client_view.php?id=" + id;
		}
		function ofertaNew(id){
			window.open("oferta_new.php?id=" + id);
		}
		function ofertaView(id){
			window.open("oferta_view.php?id=" + id);
		}
		function cerereNew(id){
			window.open("cerere_new.php?id=" + id);
		}
		function cerereView(id){
			window.open("cerere_view.php?id=" + id);
		}
		function addClient(tel){
			document.location = ("client_new.php?tel=" + tel);
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

		function onOver(id,over,row){
			var changed = document.getElementById(id);
			if (over == 1) changed.className='row over';
			else {
				if (row%2) changed.className='row odd';
				else changed.className='row even';
			}
		}
					
		$(function(){
			$("form").form();
			});
		$(document).ready(function(){
			$("#telefon").val($.trim($("#telefon").val()));
		    $("#formtelefon").validate({
		   		rules: {
		    		telefon: {
						required: true
						
			    	}
		    	}
		    });

			$("#RandDetalii").hide("fast");
		    $("#legdet").click(function(event){
				event.preventDefault();
				$("#RandDetalii").toggle("slow");
			});

		    $("#oferte").ocupa_restul();
			$("#cereri").ocupa_restul();
		});

		jQuery.fn.center = function () {
		    //this.css("position","absolute");
		    //this.css("top", (($(window).height() - this.outerHeight()) / 2) + $(window).scrollTop() + "px");
		    this.css("padding-left", (($(window).width() ) / 2 -150) + "px");
		    //this.css("left", "100px");
		    return this;
		};
		jQuery.fn.ocupa_restul = function () {
		    this.css("width", (($(window).width() ) - 343) + "px");
		    return this;
		};
		
		$(function(){
			//$("#divtelefon").center();
			//$("#oferte").ocupa_restul();
			//$("#cereri").ocupa_restul();
		});

		
	</script>
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>

<form action="check_client.php" id="formtelefon" method="post">

<div style="width: 324px; display: inline-block; float: left;">
	<div id="divtelefon">
		<fieldset id="fs_telefon">
			<legend>telefon</legend>
			<dl>
				<dt>
					
					<input type="text" name="telefon"  class="standard" maxlength="30" value="<?php echo htmlentities($telefon); ?>" />
					<input type="submit" name="submit" value="Cauta client" />
				</dt>
			</dl>	
		</fieldset>
	</div>

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
	<div id="divdet" style="width: 100%;">
		<fieldset >
			<?php //onclick="showHide('RandDetalii');"?>
			<legend id="legdet"  style="cursor:pointer;">detalii client</legend>
			<dl >
				<?php echo afiseaza($client->full_name(),"nume:");?>
				<?php echo afiseaza($client->TelefonMobil,"telefon 1:");?>
				<?php echo afiseaza($client->TelefonFix,"telefon 2:");?>
				<?php echo afiseaza($client->TelefonServici,"telefon 3:");?>
				<?php echo afiseaza($client->TelefonFax,"telefon 4:");?>
				<?php echo afiseaza($client->Email,"email:");?>
				<?php echo afiseaza($agent->full_name(),"agent:");?>
				<?php echo afiseaza($client->Detalii,"detalii:","RandDetalii");?>
			</dl>
		</fieldset>
		<script>
				<?php if ($client->Detalii!="") //echo "hide(\"RandDetalii\")";?>
			</script>
		<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px; text-align: center;">
			<input type="button" value="adauga oferta" <?php echo "onclick='ofertaNew(".$client->id.")'";?> />
			<input type="button" value="adauga cerere" <?php echo "onclick='cerereNew(".$client->id.")'";?> />
			<input type="button" value="detalii client" <?php echo "onclick='clientView(".$client->id.")'";?> />
		</div>
	</div>
</div>
				<?php 
				$sql="SELECT * FROM Apartament WHERE idClient='{$client->id}'";
				$apList=Apartament::find_by_sql($sql);
				if (!empty($apList)) {
				?>
<div id="oferte" class="ui-widget-content ui-corner-all" style="display: inline-block; float: left; margin-left: 5px;">
	<div class="ui-widget-header ui-corner-all " style="padding: 4px;">oferte ale clientului</div>
	<div style="padding: 4px;">
		<table width="100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="7%">cod</td>
				<td class="column ui-widget-header ui-corner-all" width="10%">tip</td>
				<td class="column ui-widget-header ui-corner-all" width="3%">cam</td>
				<td class="column ui-widget-header ui-corner-all" width="49%">detalii</td>
				<td class="column ui-widget-header ui-corner-all" width="14%">stare</td>
				<td class="column ui-widget-header ui-corner-all" width="12%">pret</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">foto</td>
			</tr>
				<?php 
					$i=0;
					foreach ($apList as $apartament) {
						$sql="SELECT * FROM Foto WHERE idApartament={$apartament->id} ORDER BY Ordin LIMIT 1";
						$fotos=Foto::find_by_sql($sql);
						$sql="SELECT * FROM Oferta WHERE idApartament='{$apartament->id}'";
						$ofertaList=Oferta::find_by_sql($sql);
						$strada=Strada::find_by_id($apartament->idStrada);
						$zona=Subzona::find_by_id($apartament->idSubzona);
						$cartier=Cartier::find_by_id($zona->idCartier);
						if (!empty($ofertaList)) {
							foreach ($ofertaList as $oferta) {
								$i++;
								$class=$i%2 ? "odd" : "even";
						?>
			<tr id="o<?php echo $oferta->id;?>" class="<?php echo $class;?>" style="font-weight: bold;" onmouseover="this.style.cursor='pointer';onOver('o<?php echo $oferta->id;?>',1,<?php echo $i;?>)" onmouseout="onOver('o<?php echo $oferta->id;?>',0,<?php echo $i;?>)" onclick="ofertaView(<?php echo $oferta->id;?>)">
				<td align="center"><?php echo "SP".str_pad($oferta->id, 5,"0",STR_PAD_LEFT);?></td>
				<td align="center"><?php echo tip_proprietate($apartament->TipProprietate);?></td>
				<td align="center"><?php 
					if ($apartament->TipProprietate<3) {
						if ($apartament->NumarCamere>1) {echo $apartament->NumarCamere;} 
						else { echo "Garsoniera";}
					}
					else echo "-";?></td>
				<td><?php 
					echo $cartier->Denumire.", ".$zona->Denumire.", ".$strada->Denumire.", Nr. ".$apartament->Numar;//.", Et. ".$apartament->Etaj."/".$apartament->EtajeBloc;
					if ($apartament->TipProprietate==0) {
						echo ", Et. ".($apartament->Etaj>0 ? $apartament->Etaj : "P")."/".$apartament->EtajeBloc;
					}
					//echo ", ".$apartament->TipApartament.", Confort ".$apartament->Confort;							
					?> 
				</td>
				<td align="center"><?php echo $oferta->Stare;?></td>
				<td align="right" style="pading-right:3px;"><?php 
						if ($oferta->Vanzare==1) {
							echo $oferta->Pret;
							if ($oferta->Inchiriere==1) echo "/".$oferta->PretChirie;
						}
						else echo $oferta->PretChirie;
						echo " ".$oferta->Moneda;?>
				</td>
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
				}
				?>
		</table>
	</div>
</div>
				<?php 
				}
				?>
	<?php 
				$sql="SELECT * FROM Cerere WHERE idClient='{$client->id}'";
				$cerereList=Cerere::find_by_sql($sql);
				if (!empty($cerereList)) {
					$i=0;
				?>
<div id="cereri" class="ui-widget-content ui-corner-all" style="display: inline-block; float: left; margin-left: 5px;margin-top: 7px;">
	<div class="ui-widget-header ui-corner-all " style="padding: 4px;">cereri ale clientului</div>
	<div style="padding: 4px;">
		<table width="100%">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-all" width="5%">cod</td>
				<td class="column ui-widget-header ui-corner-all" width="15%">tip proprietate</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">camere</td>
				<td class="column ui-widget-header ui-corner-all" width="10%">tip ap.</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">etaje</td>
				<td class="column ui-widget-header ui-corner-all" width="35%">zone</td>
				<td class="column ui-widget-header ui-corner-all" width="10%">stare</td>
				<td class="column ui-widget-header ui-corner-all" width="10%">buget</td>
				<td class="column ui-widget-header ui-corner-all" width="5%">plata</td>
			</tr>
				<?php 
				foreach($cerereList as $cerere){
						//$client=Client::find_by_id($cerere->idClient);
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
						$class=$i%2 ? "odd" : "even";
			?>
			<tr id="c<?php echo $cerere->id;?>"class="<?php echo $class;?> row" style="font-weight: bold;" onmouseover="this.style.cursor='pointer';onOver('c<?php echo $cerere->id;?>',1,<?php echo $i;?>)" onmouseout="onOver('c<?php echo $cerere->id;?>',0,<?php echo $i;?>)" onclick="cerereView(<?php echo $cerere->id;?>)">
				<td align="center"><?php echo $cerere->id;?></td>
				<td align="left"><?php echo $TipProprietateList;?></td>
				<td align="center"><?php echo $cerere->NumarCamere;?></td>
				<td align="center"><?php echo $cerere->TipApartament;?></td>
				<td align="center"><?php echo ($cerere->EtajMinim>0 ? $cerere->EtajMinim : "P")."-".($cerere->EtajMaxim ? $cerere->EtajMaxim : "-");?></td>
				<td align="left"><?php foreach($zoneIdList as $zonaId){
											if ($zonaId!=""){
												$zona=Subzona::find_by_id($zonaId);
												echo $zona->Denumire.",";
											}
										} ?></td>
				<td align="center"><?php echo $cerere->Stare;?></td>
				<td align="center"><?php echo $cerere->Buget." ".$cerere->Moneda;?></td>
				<td align="center"><?php echo ($cerere->Credit==1?"credit":"cash");?></td>
				
				
			</tr>
			<?php 	
					}
				
				?>

		</table>
	</div>
</div>
				<?php 
				
				}
				
			}
			else{
				?>
		
		<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px; text-align: center;">
			<span style="font-weight: bold; padding-right: 70px; color: black;">telefon inexistent</span>
			<input type="button" onclick="addClient('<?php echo htmlentities($telefon); ?>')" value="Adauga client"/>
		</div>
		<?php 	
			}
		}
	}
	?>


</form>
</body>
</html>