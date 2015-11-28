<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">

<head>
    <title>Imobiliare - Dotari pe categorii</title>
	
	<link type="text/css" href=".././themes/base/ui.all.css" rel="stylesheet" />
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	
	<link type="text/css" href=".././themes/base/ui.all.css" rel="stylesheet" />
	<script type="text/javascript" src=".././javascripts/jquery-1.3.2.js"></script>
	<script type="text/javascript" src=".././ui/ui.core.js"></script>
	<script type="text/javascript" src=".././ui/ui.tabs.js"></script>
	<link type="text/css" href=".././styles/demos.css" rel="stylesheet" />
	<script type="text/javascript"> 
	$(function() {
		$("#tabs").tabs();
	});
	</script>
	
	<script type="text/javascript"> 
	<!--
	
	function addCategoriedotare(){
		//window.open("categoriedotare_new.php","categoriedotare_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("categoriedotare_new.php");
	}
	function delCategoriedotare(id){
		document.location = ("categoriedotare_delete.php?id=" + id);
	}

	function addDotare(idCateg){
		//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("dotare_new.php?idCateg="+idCateg);
	}
	function dotareEdit(id){
		//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("dotare_update.php?id="+id);
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
	$title="Dotari";
	require_once(".././include/head.php");?>
	<?php 
	function CategoriiDot($tip){
		if ($tip!="nc") { $tip="Proprietati LIKE '%{$tip}%'";}
		else {
			$tip="Proprietati='' OR Proprietati IS NULL";
		}
		?>
		<div id="butoane" class="butoanestanga">
			<input type="button" value="Adauga categorie" onclick="addCategoriedotare()"></input>
		</div>
		<?php 
		$sql="SELECT * FROM CategorieDotari WHERE {$tip} ORDER BY Prioritate";
		echo $sql;
		$categoriedotariList=Categoriedotari::find_by_sql($sql);
		if (!empty($categoriedotariList)) {
	   		foreach($categoriedotariList as $categoriedotari){?>
	   		<div class="view">
	   			<h3><?php echo $categoriedotari->Prioritate." - ".$categoriedotari->Descriere.($categoriedotari->Privat==1 ? " - Privat - " : "").($categoriedotari->TipControl==1?" - checkbox - ":" - lista - ");?>    | <a class="header" href="categoriedotare_update.php?id=<?php echo $categoriedotari->id;?>">modifica</a></h3>
	   			<?php 
	   			$sql="SELECT * FROM Dotare WHERE idCategorieDotari={$categoriedotari->id}";
	   			$dotareList=Dotare::find_by_sql($sql);
	   			if (!empty($dotareList)) {
	   				$i=0;
	   				?>
	   				<table width="650px">
				   		<tr>
				   			<td class="header" width="40%">Denumire</td>
				   			<td class="header" width="10%">Implicit</td>
				   			<td class="header" width="20%">ID Imobiliare</td>
				   			<td class="header" width="30%">Operatii</td>
				   		</tr>   	
	   				<?php 
	   				foreach ($dotareList as $dotare) {
	   					$i++;
	   					$class=$i%2 ? "impar" : "par";
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
		



</body>
</html>
<?php //include_layout_template('admin_footer.php'); ?>