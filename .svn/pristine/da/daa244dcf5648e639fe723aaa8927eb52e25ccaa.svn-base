<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";
require_once("sync_site_lib.php");

if (isset($_GET['id'])){
	$idApartament=$_GET['id'];
	$idOferta=$_GET['idOferta'];
}
if (isset($_POST['submit'])) {
	$idApartament=$_POST['idApartament'];
	$idOferta=$_POST['idOferta'];
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if (substr($variable,0,3)=="Det") {
			$id=substr($variable,3,10);
			$fotoDet[$id]=$_POST[$variable];
		}
		if (substr($variable,0,3)=="Ord") {
			$id=substr($variable,3,10);
			$fotoOrd[$id]=$_POST[$variable];
		}
		if (substr($variable,0,3)=="Sch") {
			$id=substr($variable,3,10);
			$fotoSch[$id]=$_POST[$variable];
		}
		if (substr($variable,0,3)=="Pri") {
			$id=substr($variable,3,10);
			$fotoPri[$id]=$_POST[$variable];
		}
	}
	foreach($fotoDet as $id=>$value){
		$foto=Foto::find_by_id($id);
		$foto->Detalii=$value;
		$foto->Ordin=$fotoOrd[$id];
		$foto->Schita=$fotoSch[$id];
		$foto->Privat=$fotoPri[$id];
		$foto->save();
	}
	$oferta=Oferta::find_by_id($idOferta);
	$syncList=array('ExportPitagora','ExportImobiliare','ExportCI','ExportRoImobile','ExportRomimo', 'ExportNorc' , 'ExportMC');
	foreach ($syncList as $sync) {
		if ($oferta->{$sync}==4) $oferta->{$sync}=2;
	}
	if ($oferta->OfertaWeb==4) {
		$oferta->OfertaWeb=2;
	}
	$oferta->save();
	
	// sincronizare site
	if (($oferta->OfertaWeb>0)  && (SyncSite::modalitate("SimsParkman") == "automat")){
		$conexiune2=mysql_connect(NEW_SITE_SERVER, NEW_SITE_USER, NEW_SITE_PASSWORD, TRUE);
		$dbselect2=mysql_select_db(NEW_SITE_DB, $conexiune2);
		sync_Agenti();
		sync_Oferta($oferta->id);
	}
	
	redirect_to("oferta_view.php?id=".$idOferta);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Modificare fotografii</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
   	
    <?php require_once(".././include/jquery.php");?>
    <link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
    <script type="text/javascript" src=".././javascripts/thickbox.js"></script>
    
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
    <script type="text/javascript" src=".././javascripts/subzonahint2.js"></script>
    <script type="text/javascript">
	    $(function(){
			$("form").form();
		});

	    function onClick_inapoi(id){
			document.location = ("oferta_view.php?id=" + id);
		}

		function stergeFoto(id,oferta){
			document.location = ("foto_delete.php?id=" + id + "&of=" + oferta);
		}

		function onClick_adauga(id,oferta){
			document.location = ("foto_new.php?id=" + id + "&idOferta=" + oferta);
		}
		
    </script>
</head>
<body>
<form action="foto_update2.php" method="post" id="formular">
	<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
	<input type="hidden" name="idOferta" value="<?php echo $idOferta;?>"></input>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $idOferta;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="salveaza" />
		<input type="button" id="adauga" value="adauga" onclick='onClick_adauga(<?php echo $idApartament;?>,<?php echo $idOferta;?>)' />
	</div>
	
	<div class="ui-widget-content ui-corner-all" style="margin-top: 5px; margin-left: 5px; width: 700px;" >
		<div class="ui-widget-header ui-corner-all " style="padding: 4px;">fotografiile ofertei <?php  echo "SP".str_pad($idOferta,5,"0",STR_PAD_LEFT);?></div>
		<table style="padding: 5px;">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-left" style="width: 80px">foto</td>
				<td class="column ui-widget-header " style="width: 120px">detalii</td>
				<td class="column ui-widget-header " style="width: 60px">ordin</td>
				<td class="column ui-widget-header " style="width: 60px">schita</td>
				<td class="column ui-widget-header " style="width: 60px">privat</td>
				<td class="column ui-widget-header " style="width: 120px">tip</td>
				<td class="column ui-widget-header " style="width: 120px">marime</td>
				<td class="column ui-widget-header ui-corner-right" style="width: 60px">operatii</td>
			</tr>
			<?php 
			$sql="SELECT * FROM Foto WHERE idApartament={$idApartament} ORDER BY Ordin";
			$fotoList=Foto::find_by_sql($sql);
			$i=0;
			if (!empty($fotoList)){
				foreach ($fotoList as $foto){
					$i++;
					$class=$i%2 ? "row odd" : "row even";
			?>
			<tr class="<?php echo $class;?>">
			<td class="ui-corner-left">
					<a href="<?php echo "..".DS.$foto->image_path(); ?>" title="<?php echo $foto->Detalii;?>" class="thickbox">
					<img src="<?php echo "..".DS.$foto->image_path();?>" height="45"></img>
					</a>
			</td>
			<td  style="text-align: center;"><input type="text" name="Det<?php echo $foto->id;?>" value="<?php echo $foto->Detalii;?>" size="40"/></td>
			<td  style="text-align: center;"><input type="text" name="Ord<?php echo $foto->id;?>" value="<?php echo $foto->Ordin;?>" style="width: 40px; text-align: right;"/></td>
			<td  style="text-align: center;"><input type="checkbox" name="Sch<?php echo $foto->id;?>" value="1" <?php if ($foto->Schita==1){ echo "checked=\"checked\"";};?>/></td>
			<td  style="text-align: center;"><input type="checkbox" name="Pri<?php echo $foto->id;?>" value="1" <?php if ($foto->Privat==1){ echo "checked=\"checked\"";};?>/></td>
			<td  style="text-align: center;"><?php echo $foto->Tip;?></td>
			<td  style="text-align: right ;"><?php echo $foto->Marime;?></td>
			<td class="ui-corner-right" style="text-align: center;"><input type="button" id ="adauga" value="sterge" onclick='stergeFoto(<?php echo $foto->id ?>,<?php echo $idOferta?>)' /></td>
			</tr>
			<?php 
				}
			}
			
			?>
		</table>
		
	
	</div>
</form>
</body>
</html>
