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
	$apartament=Apartament::find_by_id($idApartament);
	$oferta=Oferta::find_by_id($idOferta);
	
}
if (isset($_POST['submit'])) {
	$apartament=Apartament::find_by_id($_POST['idApartament']);
	$oferta=Oferta::find_by_id($_POST['idOferta']);
	$apartament->youtube=$_POST['youtube'];
	$apartament->save();
	
	$syncList=array('ExportPitagora','ExportImobiliare','ExportCI','ExportRoImobile','ExportRomimo', 'ExportNorc' , 'ExportMC');
	foreach ($syncList as $sync) {
		if ($oferta->{$sync}==4) $oferta->{$sync}=2;
	}
	if ($oferta->OfertaWeb==4) {
		$oferta->OfertaWeb=2;
	}
	$oferta->save();
	
	// sincronizare site
	if ($oferta->OfertaWeb>0){
		$conexiune2=mysql_connect(NEW_SITE_SERVER, NEW_SITE_USER, NEW_SITE_PASSWORD, TRUE);
		$dbselect2=mysql_select_db(NEW_SITE_DB, $conexiune2);
		sync_Agenti();
		sync_Oferta($oferta->id);
	}
	
	redirect_to("oferta_view.php?id=".$oferta->id);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Modificare video</title>
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
		
    </script>
</head>
<body>
<form action="video_update.php" method="post" id="formular">
	<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
	<input type="hidden" name="idOferta" value="<?php echo $idOferta;?>"></input>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $idOferta;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="salveaza" />
	</div>
	
	<div class="ui-widget-content ui-corner-all" style="margin-top: 5px; margin-left: 5px; width: 800px; padding: 5px;" >
		<label class="label">link youtube</label><input type="text" name="youtube" value="<?php echo $apartament->youtube;?>" style="width:670px;"/>
	</div>
	
	<iframe width="800" height="480" style="margin:5px;" src="<?php echo $apartament->youtube;?>" frameborder="0" allowfullscreen></iframe>
	
	

</form>
</body>
</html>