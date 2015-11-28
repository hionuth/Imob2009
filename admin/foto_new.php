<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
//ini_set('display_errors', 1); 
require_once("sync_site_lib.php");

$message="";
$nrFotoMax=16;
for ($i=1;$i<=$nrFotoMax;$i++) { ${"OrdinFis".$i}=$i;}

if ((isset($_GET['id']))||(isset($_GET['idOferta']))){
	$idApartament=$_GET['id'];
	$idOferta=$_GET['idOferta'];
}

if (isset($_POST['submit'])){
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}
	}
	//print_r($_POST);
	if (!empty($_FILES)) {
		foreach($_FILES as $key=>$file){
			if ($file['error']!=4){
				$foto=new Foto();
				if ($foto->attach_file($file)){
					$foto->idApartament=$idApartament;
					$detalii="Detalii".$key;
					$foto->Detalii=${$detalii};
					$ordin="Ordin".$key;
					$foto->Ordin=${$ordin};
					$schita="Schita".$key;
					$foto->Schita=${$schita};
					$privat="Privat".$key;
					$foto->Privat=${$privat};
					if ($foto->save()) {$message.="";}//"Incarcat cu succes ".$file['name'].";";}
					else {
						foreach($foto->errors as $error) {$message.=$error."(".$file['name'].");";}		
					}
				} else {
					foreach($foto->errors as $error) {$message.=$error."(".$file['name'].");";}
				}
			}
			
		}
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
	if (($oferta->OfertaWeb>0)  && (SyncSite::modalitate("SimsParkman") == "automat")) {
		$conexiune2=mysql_connect(NEW_SITE_SERVER, NEW_SITE_USER, NEW_SITE_PASSWORD, TRUE);
		$dbselect2=mysql_select_db(NEW_SITE_DB, $conexiune2);
		sync_Agenti();
		sync_Oferta($oferta->id);
	}
	
	if ($message=="") {redirect_to("foto_update2.php?id={$idApartament}&idOferta={$idOferta}");}
	echo $message;
}

function randuri_upload($nr,$start)
{
	for ($i=1;$i<=$nr;$i++) {
		$class=$i%2 ? "row odd" : "row even";
		echo "<tr class=\"{$class}\">";
		echo "<td class=\"ui-corner-left\" style=\"text-align: center;\">{$i}</td>";
		echo "<td><input type=\"file\" name=\"Fis{$i}\" style=\"width: 228px;\"></input></td>";
		echo "<td><input type=\"text\" id=\"DetaliiFis{$i}\" name=\"DetaliiFis{$i}\" style=\"width: 198px;\"></input></td>";
		echo "<td><input type=\"text\" id=\"OrdinFis{$i}\" name=\"OrdinFis{$i}\" value=\"".($start+$i)."\" size=\"2\"></input></td>";
		echo "<td><input type=\"checkbox\" id=\"SchitaFis{$i}\" name=\"SchitaFis{$i}\" value=\"1\"></input></td>";
		echo "<td><input type=\"checkbox\" id=\"PrivatFis{$i}\" name=\"PrivatFis{$i}\" value=\"1\"></input></td>";
		echo "<tr>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
<title>Imobiliare - Modificare fotografii</title>
<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
    <script type="text/javascript" src=".././javascripts/subzonahint2.js"></script>
    <script type="text/javascript">
	    $(function(){
			$("form").form();
		});

	    function onClick_inapoi(id,oferta){
			document.location = ("foto_update2.php?id=" + id + "&idOferta=" + oferta);
		}

    </script>
</head>
<body>
<?php //if (!empty($message)) { echo "<p>{$message}</p>";}?>
<form action="foto_new.php" method="post" id="formular" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
	<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
	<input type="hidden" name="idOferta" value="<?php echo $idOferta;?>"></input>
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $idApartament;?>,<?php echo $idOferta;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="incarca" />
	</div>
	
	<div class="ui-widget-content ui-corner-all" style="margin-top: 5px; margin-left: 5px; width: 720px;" >
		<div class="ui-widget-header ui-corner-all " style="padding: 4px;">incarcare foto pentru <?php  echo "SP".str_pad($idOferta,5,"0",STR_PAD_LEFT);?></div>
		<table style="padding: 5px;">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-left" style="width: 40px">foto</td>
				<td class="column ui-widget-header " style="width: 230px">fisier</td>
				<td class="column ui-widget-header " style="width: 200px">descriere</td>
				<td class="column ui-widget-header " style="width: 60px">ordin</td>
				<td class="column ui-widget-header ui-corner-right" style="width: 60px">schita</td>
				<td class="column ui-widget-header ui-corner-right" style="width: 60px">privat</td>
			</tr>
		<?php 
			$sql="SELECT * FROM Foto WHERE idApartament='{$idApartament}' ORDER BY Ordin DESC LIMIT 1";
			$tmpList=Foto::find_by_sql($sql);
			if (!empty($tmpList)) {
				$tmp=array_shift($tmpList);
				$start=$tmp->Ordin;
			}
			else {$start=0;}
			randuri_upload($nrFotoMax,$start);
		?>
		</table>
	</div>
</form>
</body>
</html>