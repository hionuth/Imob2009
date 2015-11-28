<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

include_layout_template('admin_header.php');
?>

<script type="text/javascript"> 
<!--

function addStrada(){
	document.location = ("strada_new.php");
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

<?php 
	if (isset($_POST['submit'])) {
		$strada=$_POST['strada'];
	}
	else {
		$strada="";
	}
		
?>

<form action="strada_list.php" method="post">
<div class="view" align="center" >
	<h3>Cautare strazi</h3>
   	<table width="600px">
   		<tr>
   			<td class="label">Strada:</td>
   			<td><input type="text" name="strada" maxlength="200" value="<?php echo htmlentities($strada); ?>" /></td>
   		</tr>
   	</table>
</div>
<div class="butoane">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr align="right"><td> 
			<input type="submit" name="submit" value="Cauta strazi" /> 
			<input type='button' id='close' value='Adauga' onclick=addStrada()>
		</td></tr>
	</table>
</div>
</form>

<?php 
	if (isset($_POST['submit'])) {
		
?>
<div class="view" align="center" >
	<h3>Lista strazi gasite</h3>
   	<table width="600px">
   		<tr>
   			<td class="header" width="10%">Cod</td>
   			<td class="header" width="60%">Denumire</td>
   			<td class="header" width="40%">Operatii</td>
   		</tr>
   	<?php 
   		$sql="SELECT * FROM Strada WHERE Denumire LIKE '%{$strada}%'";
   		$stradaList=Strada::find_by_sql($sql);
   		if (!empty($stradaList)) {
   			$i=0;
   			foreach($stradaList as $strada){
 	  			$i++;
   				$class=$i%2 ? "impar" : "par";
   				echo "<tr id='".$strada->id."' class='".$class."' ondblclick=stradaEdit(".$strada->id.") onmouseover=onOver(".$strada->id.",1,".$i.") onmouseout=onOver(".$strada->id.",0,".$i.") >";
   				echo "<td>".$strada->id."</td>";
   				echo "<td>".$strada->Denumire."</td>";
   				echo "<td> <a href=\"strada_update.php?id=".$strada->id."\">modifica</a> | <a href=\"strada_delete.php?id=".$strada->id."\">sterge</a></td>";
   			}
   		}
   		
   	?>
   	
   	</table>
</div>

<?php 
	}?>

<?php include_layout_template('admin_footer.php'); ?>