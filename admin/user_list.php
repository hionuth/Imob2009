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
    <?php require_once(".././include/jquery.php");?>
	<script>

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
		if (over == 1) changed.className='row over';
		else {
			if (row%2) changed.className='row odd';
			else changed.className='row even';
		}
	}

	$(function(){
		$("form").form();
	});
	</script>
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>
<form action="">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type='button' id='close' value='Adauga' onclick=addUser()></input>
	</div>
	<table width="100%">
	<tr class="row">
        <td class="column ui-widget-header ui-corner-all" width="10%">utilizator</td>
        <td class="column ui-widget-header ui-corner-all" width="20%">nume</td>
        <td class="column ui-widget-header ui-corner-all" width="5%">acces</td>
        <td class="column ui-widget-header ui-corner-all" width="35%">adresa</td>
        <td class="column ui-widget-header ui-corner-all" width="5%">logari</td>
        <td class="column ui-widget-header ui-corner-all" width="10%">ultima</td>
        <td class="column ui-widget-header ui-corner-all" width="15%">operatii</td>
    </tr>
    <?php
		$i=0;
		
		foreach($user_list as $user) {
			$i++;
   			$class=$i%2 ? "odd" : "even";
			echo "<tr id='".$user->id."' class='row ".$class."' ondblclick=userEdit(".$user->id.") onmouseover=onOver(".$user->id.",1,".$i.") onmouseout=onOver(".$user->id.",0,".$i.") >";
			//echo "<td align='right'>".$user->id."</td>";
			echo "<td class=\"column\">".$user->User."</td>";
			echo "<td class=\"column\">".$user->full_name()."</td>";
			echo "<td class=\"column\">".$user->NivelAcces."</td>";
			$adresa="";
			if ($user->Adresa1!="") { $adresa.=$user->Adresa1 ;}
			if ($user->Adresa2!="") { $adresa.=", ".$user->Adresa2 ;}
			if ($user->Oras!="") { $adresa.=", ".$user->Oras ;}
			if ($user->Judet!="") { $adresa.=", ".$user->Judet ;}
			if ($user->Tara!="") { $adresa.=", ".$user->Tara ;}
			echo "<td class=\"column\">".$adresa."</td>";
			$sql="SELECT count(DataLogare) from Userlog WHERE idUtilizator={$user->id}";
			$result_set=$database->query($sql);
			$object_array = array();
			$row=$database->fetch_array($result_set);
			echo "<td class=\"column\">".$row[0]."</td>";
			$sql="SELECT DataLogare from Userlog WHERE idUtilizator={$user->id} ORDER BY DataLogare DESC LIMIT 1";
			$result_set=$database->query($sql);
			$object_array = array();
			$row=$database->fetch_array($result_set);
			echo "<td class=\"column\">".$row[0]."</td>";
			
			echo "<td class=\"column\">";
			if (($_SESSION['user_id']==$user->id)||($logged_user->NivelAcces==0)) {echo "<a href=\"user_update.php?id=".$user->id."\">modifica</a>";}
			if ($logged_user->NivelAcces==0) {echo " | <a href=\"user_delete.php?id=".$user->id."\">sterge</a>";}
			echo "</td class=\"column\">";
			echo "</tr>";	
		}
	?>
    </table>
</form>
</body>
</html>