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

	function addDotare(idCateg){
		//window.open("dotare_new.php","dotare_new","toolbar=0,resizable=1,scrollbars=1");
		document.location = ("dotare_new.php?idCateg="+idCateg);
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


	<div class="demo">
		<div id="tabs"> 
			<ul>
				<?php 
				$sql="SELECT * FROM CategorieDotari";
   				$categoriedotariList=Categoriedotari::find_by_sql($sql);
   				if (!empty($categoriedotariList)) {
   					foreach($categoriedotariList as $categoriedotari){
   					?>
   						<li><a href="#tabs-<?php echo $categoriedotari->id;?>"><?php echo $categoriedotari->Descriere;?></a></li> 
   					<?php      						
   					}
   				}
   				?>
			</ul>
			
			<?php 
			$sql="SELECT * FROM CategorieDotari";
   			$categoriedotariList=Categoriedotari::find_by_sql($sql);
   			if (!empty($categoriedotariList)) {
   				foreach($categoriedotariList as $categoriedotari){
   				?>
   					<div id="tabs-<?php echo $categoriedotari->id;?>">
   						
   						<?php
   						if ($categoriedotari->TipProprietate==1){ ?><h3>Apartament</h3><?php }
   						if ($categoriedotari->TipProprietate==2){ ?><h3>Apartament in vila</h3><?php }
   						if ($categoriedotari->TipProprietate==3){ ?><h3>Casa</h3><?php }
   						if ($categoriedotari->TipProprietate==4){ ?><h3>Teren</h3><?php }?>
   						<input type="button" value="Adauga" onclick="addDotare(<?php echo $categoriedotari->id;?>)"></input>
   						<div align="center">
   						<?php 
   						$sql="SELECT * FROM Dotare WHERE idCategorieDotari={$categoriedotari->id}";
   						$dotareList=Dotare::find_by_sql($sql);
   						if (!empty($dotareList)) {
   							$i=0;
   							?>
   							<table width="600px">
						   		<tr>
						   			<td class="header" width="10%">Cod</td>
						   			<td class="header" width="60%">Denumire</td>
						   			<td class="header" width="40%">Operatii</td>
						   		</tr>   	
   							<?php 
   							foreach ($dotareList as $dotare) {
   								$i++;
   								$class=$i%2 ? "impar" : "par";
   								?>
				   				<tr id="<?php echo $dotare->id;?>" class="<?php echo $class;?>" ondblclick=dotareEdit("<?php echo $dotare->id;?>") onmouseover=onOver("<?php echo $dotare->id;?>",1,<?php echo $i;?>) onmouseout=onOver("<?php echo $dotare->id;?>",0,<?php echo $i;?>)>
				   					<td><?php echo $dotare->id;?></td>
				   					<td><?php echo $dotare->Descriere;?></td>
				   					<td> <a href="dotare_update.php?id=<?php echo $dotare->id;?>">modifica</a> | <a href="dotare_delete.php?id=<?php $dotare->id;?>">sterge</a></td>
				   				</tr>
   								<?php 
   							}
   							?>
							</table>
   						<?php 
   						}
   						?>
   						</div>
					</div> 
   				<?php      						
   				}
   			}
   			?>		
		</div>
	</div>
		

<div id="butoane" class="butoane">
	<input type="button" value="Adauga" onclick="addCategoriedotare()"></input>
</div>

</body>
</html>
<?php //include_layout_template('admin_footer.php'); ?>