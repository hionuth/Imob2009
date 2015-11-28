<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

include_layout_template('admin_header.php');
?>

<script type="text/javascript"> 
<!--

function addZona(){
	//window.open("zona_new.php","zona_new","toolbar=0,resizable=1,scrollbars=1");
	document.location = ("zona_new.php");
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

<div class="view" align="center" >
	<h3>Lista zone</h3>
   	<table width="600px">
   		<tr>
   			<td class="header" width="10%">Cod</td>
   			<td class="header" width="60%">Denumire</td>
   			<td class="header" width="40%">Operatii</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Zona";
   		$zonaList=Zona::find_by_sql($sql);
   		if (!empty($zonaList)) {
   			$i=0;
   			foreach($zonaList as $zona){
 	  			$i++;
   				$class=$i%2 ? "impar" : "par";
   				echo "<tr id='".$zona->id."' class='".$class."' ondblclick=zonaEdit(".$zona->id.") onmouseover=onOver(".$zona->id.",1,".$i.") onmouseout=onOver(".$zona->id.",0,".$i.") >";
   				echo "<td>".$zona->id."</td>";
   				echo "<td>".$zona->Denumire."</td>";
   				echo "<td> <a href=\"zona_update.php?id=".$zona->id."\">modifica</a> | <a href=\"zona_delete.php?id=".$zona->id."\">sterge</a></td>";
   			}
   		}
   		
   	?>
   	
   	</table>
</div>
<div id="butoane" class="butoane">
	<input type="button" id="add" value="Adauga" onclick="addZona()"/>
</div>

<?php include_layout_template('admin_footer.php'); ?>