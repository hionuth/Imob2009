<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$logged_user=User::find_by_id($_SESSION['user_id']);
$user_list=array();
$user_list=User::find_all();

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Listare utilizatori</title>
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />

	<script type="text/javascript"> 
	<!--
	
	function addUser(){
		//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("user_new.php");
	}
	
	function userEdit(id){
		//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
		<?php if ($logged_user->NivelAcces==0) {echo "document.location = (\"user_update.php?id=\"+id);";} ?>
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
<?php 
require_once(".././include/head.php");
?>
<h3>Utilizatori - lista</h3>

<div id="Utilizatori" class="view" align="center">
	<h3>Utilizatori</h3>
	<table width="100%">
	<tr>
        <td class="header" width="10%">User</td>
        <td class="header" width="20%">Nume</td>
        <td class="header" width="5%">Acc</td>
        <td class="header" width="35%">Adresa</td>
        <td class="header" width="5%">Logs</td>
        <td class="header" width="10%">Ultima</td>
        <td class="header" width="15%">Operatii</td>

    </tr>
	<?php
		$i=0;
		
		foreach($user_list as $user) {
			$i++;
   			$class=$i%2 ? "impar" : "par";
			echo "<tr id='".$user->id."' class='".$class."' ondblclick=userEdit(".$user->id.") onmouseover=onOver(".$user->id.",1,".$i.") onmouseout=onOver(".$user->id.",0,".$i.") >";
			//echo "<td align='right'>".$user->id."</td>";
			echo "<td>".$user->User."</td>";
			echo "<td>".$user->full_name()."</td>";
			echo "<td>".$user->NivelAcces."</td>";
			$adresa="";
			if ($user->Adresa1!="") { $adresa.=$user->Adresa1 ;}
			if ($user->Adresa2!="") { $adresa.=", ".$user->Adresa2 ;}
			if ($user->Oras!="") { $adresa.=", ".$user->Oras ;}
			if ($user->Judet!="") { $adresa.=", ".$user->Judet ;}
			if ($user->Tara!="") { $adresa.=", ".$user->Tara ;}
			echo "<td>".$adresa."</td>";
			$sql="SELECT count(DataLogare) from Userlog WHERE idUtilizator={$user->id}";
			$result_set=$database->query($sql);
			$object_array = array();
			$row=$database->fetch_array($result_set);
			echo "<td>".$row[0]."</td>";
			$sql="SELECT DataLogare from Userlog WHERE idUtilizator={$user->id} ORDER BY DataLogare DESC LIMIT 1";
			$result_set=$database->query($sql);
			$object_array = array();
			$row=$database->fetch_array($result_set);
			echo "<td>".$row[0]."</td>";
			
			echo "<td>";
			if (($_SESSION['user_id']==$user->id)||($logged_user->NivelAcces==0)) {echo "<a href=\"user_update.php?id=".$user->id."\">modifica</a>";}
			if ($logged_user->NivelAcces==0) {echo " | <a href=\"user_delete.php?id=".$user->id."\">sterge</a>";}
			echo "</td>";
			echo "</tr>";	
		}
	?>
	
	</table>
</div>
<?php 
	if ($logged_user->NivelAcces==0) {
?>
<div id="butoane" class="butoane">
	<input type='button' id='close' value='Adauga' onclick=addUser()></input>
</div>
<?php }?>
</body>
</html>