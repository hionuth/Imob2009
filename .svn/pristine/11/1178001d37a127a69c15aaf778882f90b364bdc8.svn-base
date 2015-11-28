<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";
$telefon="";
$nrFotoMax=16;
for ($i=1;$i<=$nrFotoMax;$i++) { ${"OrdinFis".$i}=$i;}

if ((isset($_GET['id']))||(isset($_GET['of']))){
	$idApartament=$_GET['id'];
	$idOferta=$_GET['of'];
	$telefon=$_GET['telefon'];
}

if (isset($_POST['submit'])){
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}
	}
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
					if ($foto->save()) {$message.="Incarcat cu succes ".$file['name'].";";}
					else {
						foreach($foto->errors as $error) {$message.=$error."(".$file['name'].");";}		
					}
				} else {
					foreach($foto->errors as $error) {$message.=$error."(".$file['name'].");";}
				}
			}
			
		}
	}
}

function randuri_upload($nr,$start)
{
	echo "<table>";
	for ($i=1;$i<=$nr;$i++) {
		echo "<tr>";
		echo "<td class=\"label\">Foto{$i}:</td>";
		echo "<td><input type=\"file\" name=\"Fis{$i}\"></input></td>";
		echo "<td> Descriere:<input type=\"text\" id=\"DetaliiFis{$i}\" name=\"DetaliiFis{$i}\" size=\"30\"></input></td>";
		echo "<td> Nr ordine:<input type=\"text\" id=\"OrdinFis{$i}\" name=\"OrdinFis{$i}\" value=\"".($start+$i)."\" size=\"2\"></input></td>";
		echo "<td> Schita:<input type=\"checkbox\" id=\"SchitaFis{$i}\" name=\"SchitaFis{$i}\"></input></td>";
		echo "<tr>";
	}
	echo "</table>";
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Incarcare fotografii</title>
	
	<link type="text/css" href=".././themes/base/ui.all.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	
	<script type="text/javascript"> 
	function back(id,tel){
		if (tel=="") {
			document.location = ("oferta_update.php?id="+id);
		}
		else {
			document.location = ("check_client.php?telefon="+tel);
		}
	}
	</script>
</head>
<body>
	<?php 
	$title="Incarcare fotografii";
	require_once(".././include/head.php");
	?>
	<?php if (!empty($message)) { echo "<p>{$message}</p>";}?>
	
	<form action="upload.php?<?php echo "id={$idApartament}&of={$idOferta}&telefon={$telefon}";?>" enctype="multipart/form-data" method="post">
		<input type="hidden" name="MAX_FILE_SIZE" value="2000000"></input>
		<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
		<input type="hidden" name="telefon" value="<?php echo $telefon;?>"></input>
	<div id="UploadFisiere" class="view"> 
		<h3>Fotografii proprietate</h3>
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
	</div>
	<div id="butoane" class="butoane">
		<input type="button" id="close" value="Inchide fereastra" onclick="back(<?php echo $idOferta;?>,'<?php echo $telefon;?>')"></input>
		<input type="submit" name="submit" value="Incarca"></input>
	</div>
	</form>
</body>
</html>