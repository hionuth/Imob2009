<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

include_layout_template('admin_header.php');
?>

<script type="text/javascript"> 
<!--

function addCartier(){
	//window.open("zona_new.php","cartier_new","toolbar=0,resizable=1,scrollbars=1");
	document.location = ("cartier_new.php");
}

function editCartier(id){
	//window.open("zona_new.php","cartier_new","toolbar=0,resizable=1,scrollbars=1");
	document.location = ("cartier_update.php?id="+id);
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
	<h3>Lista cartiere</h3>
   	<table width="600px">
   		<tr>
   			<td class="header" width="10%">Cod</td>
   			<td class="header" width="40%">Denumire</td>
   			<td class="header" width="20%">Zona</td>
   			<td class="header" width="20%">Operatii</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Cartier";
   		$cartierList=Cartier::find_by_sql($sql);
   		if (!empty($cartierList)) {
   			$i=0;
   			foreach($cartierList as $cartier){
 	  			$i++;
   				$class=$i%2 ? "impar" : "par";
   				$zona=Zona::find_by_id($cartier->idZona);
   				echo "<tr id='".$cartier->id."' class='".$class."' ondblclick=editCartier(".$cartier->id.") onmouseover=onOver(".$cartier->id.",1,".$i.") onmouseout=onOver(".$cartier->id.",0,".$i.") >";
   				echo "<td>".$cartier->id."</td>";
   				echo "<td>".$cartier->Denumire."</td>";
   				echo "<td>".$zona->Denumire."</td>";
   				echo "<td> <a href=\"cartier_update.php?id=".$cartier->id."\">modifica</a> | <a href=\"cartier_delete.php?id=".$cartier->id."\">sterge</a></td>";
   			}
   		}
   		
   	?>
   	
   	</table>
</div>
<div id="butoane" class="butoane">
	<input type='button' id='close' value='Adauga' onclick=addCartier()>
</div>

<?php include_layout_template('admin_footer.php'); ?>