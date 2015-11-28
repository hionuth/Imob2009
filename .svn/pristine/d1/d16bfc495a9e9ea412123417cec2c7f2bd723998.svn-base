<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

include_layout_template('admin_header.php');
?>

<script type="text/javascript"> 
<!--

function addDotare(){
	//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
	document.location = ("dotare_new.php");
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
	<h3>Lista dotari</h3>
   	<table width="600px">
   		<tr>
   			<td class="header" width="10%">Cod</td>
   			<td class="header" width="60%">Denumire</td>
   			<td class="header" width="40%">Operatii</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Dotare";
   		$dotareList=Dotare::find_by_sql($sql);
   		if (!empty($dotareList)) {
   			$i=0;
   			foreach($dotareList as $dotare){
 	  			$i++;
   				$class=$i%2 ? "impar" : "par";
   				echo "<tr id='".$dotare->id."' class='".$class."' ondblclick=dotareEdit(".$dotare->id.") onmouseover=onOver(".$dotare->id.",1,".$i.") onmouseout=onOver(".$dotare->id.",0,".$i.") >";
   				echo "<td>".$dotare->id."</td>";
   				echo "<td>".$dotare->Descriere."</td>";
   				echo "<td> <a href=\"dotare_update.php?id=".$dotare->id."\">modifica</a> | <a href=\"dotare_delete.php?id=".$dotare->id."\">sterge</a></td>";
   			}
   		}
   		
   	?>
   	
   	</table>
</div>
<div id="butoane" class="butoane">
	<input type='button' id='close' value='Adauga' onclick=addDotare()>
</div>

<?php include_layout_template('admin_footer.php'); ?>