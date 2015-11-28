<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
ini_set('display_errors', 1);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html version="-//W3C//DTD HTML 4.01 Transitional//EN" lang="ro">
<head>
    <title>Imobiliare - Dotari pe categorii</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
	
	<script type="text/javascript">
		function onOver(id,over,row){
			var changed = document.getElementById(id);
			if (over == 1) changed.className='over';
			else {
				if (row%2) changed.className='odd';
				else changed.className='even';
			}
		}

		function addCategoriedotare(){
			document.location = ("categoriedotare_new.php");
		}
		function delCategoriedotare(id){
			document.location = ("categoriedotare_delete.php?id=" + id);
		}

		function addDotare(idCateg){
			document.location = ("dotare_new.php?idCateg="+idCateg);
		}
		function dotareEdit(id){
			document.location = ("dotare_update.php?id="+id);
		}
		
		$(function(){
			$("form").form();
			$("#tabs").tabs();
		});
		
	</script>
	    
</head>
<body>
<?php 
	require_once(".././include/meniu.php");
?>
<form action="">
<?php 
	function CategoriiDot($tip){
		if ($tip!="nc") { $tip="Proprietati LIKE '%{$tip}%'";}
		else {
			$tip="Proprietati='' OR Proprietati IS NULL";
		}
		?>
		<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
			<input type="button" value="Adauga categorie" onclick="addCategoriedotare()"></input>
		</div>
		<?php 
		$sql="SELECT * FROM CategorieDotari WHERE {$tip} ORDER BY Prioritate";
		//echo $sql;
		$categoriedotariList=Categoriedotari::find_by_sql($sql);
		if (!empty($categoriedotariList)) {
	   		foreach($categoriedotariList as $categoriedotari){?>
	   		<div>
	   			<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
	   				<?php echo $categoriedotari->Prioritate." - ".$categoriedotari->Descriere.($categoriedotari->Privat==1 ? " - Privat - " : "").($categoriedotari->TipControl==1?" - checkbox - ":" - lista - ");?>    | <a class="header" href="categoriedotare_update.php?id=<?php echo $categoriedotari->id;?>">modifica</a>
	   			</div>
	   			<?php 
	   			$sql="SELECT * FROM Dotare WHERE idCategorieDotari={$categoriedotari->id}";
	   			$dotareList=Dotare::find_by_sql($sql);
	   			if (!empty($dotareList)) {
	   				$i=0;
	   				?>
	   				<table width="650px">
				   		<tr class="row">
				   			<td class="column ui-widget-header ui-corner-all" width="40%">Denumire</td>
				   			<td class="column ui-widget-header ui-corner-all" width="10%">Implicit</td>
				   			<td class="column ui-widget-header ui-corner-all" width="20%">ID Imobiliare</td>
				   			<td class="column ui-widget-header ui-corner-all" width="30%">Operatii</td>
				   		</tr>   	
	   				<?php 
	   				foreach ($dotareList as $dotare) {
	   					$i++;
	   					$class=$i%2 ? "odd" : "even";
	   					?>
		   				<tr id="<?php echo $dotare->id;?>" class="<?php echo $class;?>" ondblclick='dotareEdit("<?php echo $dotare->id;?>")' onmouseover='onOver("<?php echo $dotare->id;?>",1,<?php echo $i;?>)' onmouseout='onOver("<?php echo $dotare->id;?>",0,<?php echo $i;?>)'>
		   					<td><?php echo $dotare->Descriere;?></td>
		   					<td><input type="checkbox" disabled="disabled" <?php if ($dotare->Implicit==1){echo "checked=\"checked\"";}?>/></td>
		   					<td><?php echo $dotare->idImobiliare;?></td>
		   					<td> <a href="dotare_update.php?id=<?php echo $dotare->id;?>">modifica</a> | <a href="dotare_delete.php?id=<?php echo $dotare->id;?>">sterge</a> | <a href="dotare_new.php?idCateg=<?php echo $categoriedotari->id;?>">adauga</a></td>
		   				</tr>
	   					<?php 
	   				}
	   				?>
					</table>
	   			<?php 
	   			}
	   			else {?>
	   				<input type="button" value="Adauga Dotare" onclick="addDotare(<?php echo $categoriedotari->id;?>)"></input>
	   				<input type="button" value="Sterge Categorie" onclick="delCategoriedotare(<?php echo $categoriedotari->id;?>)"></input> <?php 
	   			}?>
	   		</div>
	   		<?php 	
	   		}
		}
	}
?>

	<div class="demo">
		<div id="tabs"> 
			<ul>
				<li><a href="#tabs-apartamente">Apartamente</a></li>
				<li><a href="#tabs-apartamentevila">Apartamente in vila</a></li>
				<li><a href="#tabs-case">Case si vile</a></li>
				<li><a href="#tabs-terenuri">Terenuri</a></li>
				<li><a href="#tabs-spatii">Spatii comerciale</a></li>
				<li><a href="#tabs-nc">Neconfigurate</a></li>
			</ul>
			
			<div id="tabs-apartamente">
				<?php CategoriiDot("xa");?>
			</div>
			
			<div id="tabs-apartamentevila">
				<?php CategoriiDot("xb");?>
			</div>
			
			<div id="tabs-case">
				<?php CategoriiDot("xc");?>
			</div>
			
			<div id="tabs-terenuri">
				<?php CategoriiDot("xt");?>
			</div>
			
			<div id="tabs-spatii">
				<?php CategoriiDot("xs");?>
			</div>	
			
			<div id="tabs-nc">
				<?php CategoriiDot("nc");?>
			</div>
		
		</div>
	</div>
</form>
</body>
</html>