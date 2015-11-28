<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

//include_layout_template('admin_header.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Verificare telefon</title>	
	<link rel="stylesheet" href=".././styles/thickbox.css" type="text/css" media="screen" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

	<script type="text/javascript"> 
	<!--
	
	function addSubzona(){
		//window.open("zona_new.php","subzona_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("subzona_new.php");
	}
	
	function onOver(id,over,row){
		var changed = document.getElementById(id);
		if (over == 1) changed.className='deasupra';
		else {
			if (row%2) changed.className='impar';
			else changed.className='par';
		}
	}
	//-->
	</script> 


</head>
<body>
<?php require_once(".././include/head.php");?>
<div class="view" align="center" >
	<h3>Lista subzone</h3>
   	<table>
   		<tr>
   			<td class="header" width="30px">Cod</td>
   			<td class="header" width="200px">Denumire</td>
   			<td class="header" width="100px">Cartier</td>
   			<td class="header" width="100px">Zona</td>
   			<td class="header" width="80px">Pitagora</td>
   			<td class="header" width="80px">Imobiliare</td>
   			<td class="header" width="80px">M.C.</td>
   			<td class="header" width="160px">Imopedia</td>
   			<td class="header" width="110px">Operatii</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Subzona";
   		$subzonaList=Subzona::find_by_sql($sql);
   		if (!empty($subzonaList)) {
   			$i=0;
   			foreach($subzonaList as $subzona){
 	  			$i++;
   				$class=$i%2 ? "impar" : "par";
   				$cartier=Cartier::find_by_id($subzona->idCartier);
   				$zona=Zona::find_by_id($cartier->idZona);
   				echo "<tr id='".$subzona->id."' class='".$class."' ondblclick=subzonaEdit(".$subzona->id.") onmouseover=onOver(".$subzona->id.",1,".$i.") onmouseout=onOver(".$subzona->id.",0,".$i.") >";
   				echo "<td>".$subzona->id."</td>";
   				echo "<td>".$subzona->Denumire."</td>";
   				echo "<td>".$cartier->Denumire."</td>";
   				echo "<td>".$zona->Denumire."</td>";
   				echo "<td>".$subzona->idPitagora."</td>";
   				echo "<td>".$subzona->idImobiliare."</td>";
   				echo "<td>".$subzona->idMC."</td>";
   				echo "<td>".$subzona->idImopedia."</td>";
   				echo "<td> <a href=\"subzona_update.php?id=".$subzona->id."\">modifica</a> | <a href=\"subzona_delete.php?id=".$subzona->id."\">sterge</a></td>";
   			}
   		}
   		
   	?>
   	
   	</table>
</div>
<div id="butoane" class="butoane">
	<input type='button' id='add' value='Adauga' onclick=addSubzona()></input>
</div>

<?php //include_layout_template('admin_footer.php'); ?>

</body>
</html>