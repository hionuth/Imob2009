<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";

if ((isset($_GET['id']))||(isset($_GET['of']))){
	$idApartament=$_GET['id'];
	$idOferta=$_GET['of'];
}
if (isset($_POST['submit'])) {
	$idApartament=$_POST['idApartament'];
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
	}
	foreach($fotoDet as $id=>$value){
		$foto=Foto::find_by_id($id);
		$foto->Detalii=$value;
		$foto->Ordin=$fotoOrd[$id];
		$foto->Schita=$fotoSch[$id];
		$foto->save();
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Modificare fotografii</title>
	
	<link type="text/css" href=".././themes/base/ui.all.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	
	<script type="text/javascript"> 
	function back(id){
		document.location = ("oferta_update.php?id="+id);
	}
	</script>
</head>
<body>
	<?php 
	$title="Incarcare fotografii";
	require_once(".././include/head.php");
	?>
	<?php if (!empty($message)) { echo "<p>{$message}</p>";}?>
	
	<form action="foto_update.php<?php echo "?id={$idApartament}&of={$idOferta}" ?>" method="post">
	<div id="UploadFisiere" class="view"> 
		
		<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
		<table cellspacing="4">
			<tr>
   			<td class="header" >Foto</td>
   			<td class="header" >Detalii</td>
   			<td class="header" >Ordin</td>
   			<td class="header" >Schita</td>
   			<td class="header" >Tip</td>
   			<td class="header" >Marime</td>
   			<td class="header" >Operatii</td>
   		</tr>
		<?php 
		$sql="SELECT * FROM Foto WHERE idApartament={$idApartament} ORDER BY Ordin";
		$fotoList=Foto::find_by_sql($sql);
		if (!empty($fotoList)){
			foreach ($fotoList as $foto){
			?>
		<tr>
			<td>
				<div class="fotopreview" align="center">
					<img src="<?php echo "..".DS.$foto->image_path();?>" height="45"></img>
				</div>
			</td>
			<td><input type="text" name="Det<?php echo $foto->id;?>" value="<?php echo $foto->Detalii;?>" size="40"/></td>
			<td><input type="text" name="Ord<?php echo $foto->id;?>" value="<?php echo $foto->Ordin;?>" size="2"/></td>
			<td><input type="checkbox" name="Sch<?php echo $foto->id;?>" value="1" <?php if ($foto->Schita==1){ echo "checked=\"checked\"";};?>"/></td>
			<td><?php echo $foto->Tip;?></td>
			<td><?php echo $foto->Marime;?></td>
			<td><a href="foto_delete.php?id=<?php echo $foto->id ?>&of=<?php echo $idOferta?>">sterge</a></td>
		</tr>
			<?php 
			}
		}
		
		?>
		</table>
	</div>
	<div id="butoane" class="butoane">
		<input type="button" id="close" value="Inapoi" onclick="back(<?php echo $idOferta;?>)" />
		<input type="submit" name="submit" id="submit" value="Salveaza"/>
	</div>	
	</form>
</body>
</html>