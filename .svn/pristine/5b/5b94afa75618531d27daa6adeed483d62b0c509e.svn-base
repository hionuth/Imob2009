<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$message="";
$nrDocMax=16;

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
				$document=new Document();
				if ($document->attach_file($file)){
					$document->idApartament=$idApartament;
					$detalii="Detalii".$key;
					$document->Detalii=${$detalii};
					//print_r($document);
					if ($document->save()) {$message.="";}//"Incarcat cu succes ".$file['name'].";";}
					else {
						foreach($document->errors as $error) {$message.=$error."(".$file['name'].");";}		
					}
				} else {
					foreach($document->errors as $error) {$message.=$error."(".$file['name'].");";}
				}
			}
			
		}
	}
	if ($message=="") {redirect_to("doc_update.php?id={$idApartament}&idOferta={$idOferta}");}
	echo $message;
}

function randuri_upload($nr,$start)
{
	for ($i=1;$i<=$nr;$i++) {
		$class=$i%2 ? "row odd" : "row even";
		echo "<tr class=\"{$class}\">";
		echo "<td class=\"ui-corner-left\" style=\"text-align: center;\">{$i}</td>";
		echo "<td><input type=\"file\" name=\"Fis{$i}\" style=\"width: 320px;\"></input></td>";
		echo "<td><input type=\"text\" id=\"DetaliiFis{$i}\" name=\"DetaliiFis{$i}\" style=\"width: 342px;\"></input></td>";
		echo "<tr>";
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
<title>Imobiliare - Incarcare documente</title>
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
			document.location = ("doc_update.php?id=" + id + "&idOferta=" + oferta);
		}

    </script>
</head>
<body>
<?php //if (!empty($message)) { echo "<p>{$message}</p>";}?>
<form action="doc_upload.php" method="post" id="formular" enctype="multipart/form-data">
	<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
	<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
	<input type="hidden" name="idOferta" value="<?php echo $idOferta;?>"></input>
	
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $idApartament;?>,<?php echo $idOferta;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="incarca" />
	</div>
	
	<div class="ui-widget-content ui-corner-all" style="margin-top: 5px; margin-left: 5px; width: 720px;">
		<div class="ui-widget-header ui-corner-all " style="padding: 4px;">incarcare documente pentru <?php  echo "SP".str_pad($idOferta,5,"0",STR_PAD_LEFT);?></div>
		<table style="padding: 5px;">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-left" style="width: 40px">doc</td>
				<td class="column ui-widget-header " style="width: 330px">fisier</td>
				<td class="column ui-widget-header ui-corner-right" style="width: 350px">descriere</td>
			</tr>
		<?php 
			randuri_upload($nrDocMax,0);
		?>
		</table>
	</div>
</form>
</body>
</html>