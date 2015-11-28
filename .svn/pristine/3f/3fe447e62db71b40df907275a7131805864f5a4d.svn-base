<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";

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
			$docDet[$id]=$_POST[$variable];
		}
	}
	foreach($docDet as $id=>$value){
		$doc=Document::find_by_id($id);
		$doc->Detalii=$value;
		$doc->save();
	}
	redirect_to("oferta_view.php?id=".$idOferta);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Modificare documente</title>
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

		function stergeDoc(id,oferta){
			document.location = ("doc_delete.php?id=" + id + "&of=" + oferta);
		}

		function onClick_adauga(id,oferta){
			document.location = ("doc_upload.php?id=" + id + "&idOferta=" + oferta);
		}
		
    </script>
</head>
<body>
<form action="doc_update.php" method="post" id="formular">
	<input type="hidden" name="idApartament" value="<?php echo $idApartament;?>"></input>
	<input type="hidden" name="idOferta" value="<?php echo $idOferta;?>"></input>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='onClick_inapoi(<?php echo $idOferta;?>)'/>
		<input type="submit" name="submit" id="salveaza" value="salveaza" />
		<input type="button" id="adauga" value="adauga" onclick='onClick_adauga(<?php echo $idApartament;?>,<?php echo $idOferta;?>)' />
	</div>
	
	<div class="ui-widget-content ui-corner-all" style="margin-top: 5px; margin-left: 5px; width: 700px;" >
		<div class="ui-widget-header ui-corner-all " style="padding: 4px;">documentele ofertei <?php  echo "SP".str_pad($idOferta,5,"0",STR_PAD_LEFT);?></div>
		<table style="padding: 5px;">
			<tr class="row">
				<td class="column ui-widget-header ui-corner-left" style="width: 100px">nume fisier</td>
				<td class="column ui-widget-header " style="width: 350px">detalii</td>
				<td class="column ui-widget-header " style="width: 60px">marime</td>
				<td class="column ui-widget-header ui-corner-right" style="width: 160px">operatii</td>
			</tr>
			<?php 
			$sql="SELECT * FROM Documente WHERE idApartament={$idApartament}";
			$docList=Document::find_by_sql($sql);
			$i=0;
			if (!empty($docList)){
				foreach ($docList as $doc){
					$i++;
					$class=$i%2 ? "row odd" : "row even";
			?>
			<tr class="<?php echo $class;?>">
			<td class="ui-corner-left">
					<input type="text" value="<?php echo $doc->NumeFisier;?>" style="width: 90px;"/>
			</td>
			<td  style="text-align: center;"><input type="text" name="Det<?php echo $doc->id;?>" value="<?php echo $doc->Detalii;?>" style="width: 340px;"/></td>
			<td  style="text-align: right ;"><?php echo $doc->Marime;?></td>
			<td class="ui-corner-right" style="text-align: center;">
				<input type="button" id ="descarca" value="descarca" onclick="window.open('<?php echo "..".DS.$doc->doc_path() ?>','_blank')" />
				<input type="button" id ="adauga" value="sterge" onclick='stergeDoc(<?php echo $doc->id ?>,<?php echo $idOferta?>)' />
			</td>
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
