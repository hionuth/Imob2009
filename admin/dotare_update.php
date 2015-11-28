<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$message="";
$xa="";
$xb="";
$xc="";
$xt="";
$xs="";
if (isset($_GET['id'])){
	$dotare=Dotare::find_by_id($_GET['id']);
	$Descriere=$dotare->Descriere;
	$Implicit=$dotare->Implicit;
	$idCategorieDotari=$dotare->idCategorieDotari;
	$idImobiliare=$dotare->idImobiliare;
	$_SESSION['curentIdDotare']=$dotare->id;
	if (strpos($dotare->Proprietati,"xa")!==false) {
		$xa=1;
	}
	if (strpos($dotare->Proprietati,"xb")!==false) {
		$xb=1;
	}
	if (strpos($dotare->Proprietati,"xc")!==false) {
		$xc=1;
	}
	if (strpos($dotare->Proprietati,"xt")!==false) {
		$xt=1;
	}
	if (strpos($dotare->Proprietati,"xs")!==false) {
		$xs=1;
	}
}
if (isset($_POST['submit'])) {
	$dotare=new Dotare();
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		if ($variable!="submit") {
			${$variable}=$_POST[$variable];
		}
	}
	//$Descriere=$_POST['Descriere'];
	$dotare=Dotare::find_by_id($_SESSION['curentIdDotare']);
	unset($_SESSION['curentIdDotare']);
	$dotare->Descriere=$Descriere;
	$dotare->idCategorieDotari=$idCategorieDotari;
	$dotare->idImobiliare=$idImobiliare;
	$dotare->Implicit=(isset($Implicit)?$Implicit:0);
	$dotare->Proprietati="";
	if (isset($_POST['xa'])) {
		$xa=1;
		$dotare->Proprietati=$dotare->Proprietati."xa";
	}
	if (isset($_POST['xb'])) {
		$xb=1;
		$dotare->Proprietati=$dotare->Proprietati."xb";
	}
	if (isset($_POST['xc'])) {
		$xc=1;
		$dotare->Proprietati=$dotare->Proprietati."xc";
	}
	if (isset($_POST['xt'])) {
		$xt=1;
		$dotare->Proprietati=$dotare->Proprietati."xt";
	}
	if (isset($_POST['xs'])) {
		$xs=1;
		$dotare->Proprietati=$dotare->Proprietati."xs";
	}
	//print_r($dotare);
	$dotare->save();
	$message="salvat";
	redirect_to("categoriedotare_list.php");
}

include_layout_template('admin_header.php');
?>
<script type="text/javascript"> 
<!--

function back(){
	document.location = ("categoriedotare_list.php");
}

//-->
</script>
<?php 


?>

<form action="dotare_update.php" method="post">
	<div class="view" align="center" >
		<h3>Modificare dotare<?php if ($message!="") {echo " - ".$message;}?></h3>
    	<table>
    		<tr height="20">
    			<td></td>
    		</tr>
        	<tr>
            	<td class="label">Descriere: </td>
                <td><input type="text" name="Descriere" maxlength="30" value="<?php if (isset($Descriere)) {echo htmlentities($Descriere);} ?>" /></td>
            </tr>
            <tr>
            	<td class="label">Categorie: </td>
                <td>
            		<select name='idCategorieDotari'>
            		<?php 
            			$categoriedotariList=Categoriedotari::find_all();
            			foreach ($categoriedotariList as $categoriedotari){
            				$selected=(isset($idCategorieDotari))&&($idCategorieDotari==$categoriedotari->id) ? " selected " : "";
            				echo "<option value='".$categoriedotari->id."'".$selected.">".$categoriedotari->Descriere."</option>";
            			}
            		?>
            		</select>
            	</td>
			</tr>
			<tr>
				<td class="label">Selectat implicit</td>
				<td>
					<input type="checkbox" name="Implicit" <?php if ($Implicit==1) {echo "checked=\"checked\"";}?> value="1"/>
				</td>
			</tr>
            <tr>
            	<td class="label">ID Imobiliare: </td>
                <td><input type="text" name="idImobiliare" maxlength="30" value="<?php if (isset($idImobiliare)) {echo htmlentities($idImobiliare);} ?>" /></td>
            </tr>
            <tr>
            	<td>Aplicabil la: </td>
            	<td></td>
          	</tr>
          	<tr>
            	<td class="label">Apartamente: </td>
            	<td><input type="checkbox" name="xa" value="1" <?php if ($xa==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Ap in vila: </td>
            	<td><input type="checkbox" name="xb" value="1" <?php if ($xb==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Case: </td>
            	<td><input type="checkbox" name="xc" value="1" <?php if ($xc==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Terenuri: </td>
            	<td><input type="checkbox" name="xt" value="1" <?php if ($xt==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
          	<tr>
            	<td class="label">Spatii: </td>
            	<td><input type="checkbox" name="xs" value="1" <?php if ($xs==1) {echo "checked='checked'";}?>></input></td>
          	</tr>
		</table>
		</div>
		<div id="butoane" class="butoane">
			<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
			<input type="submit" name="submit" value="Salveaza" />
		</div>
</form>


<?php include_layout_template('admin_footer.php'); ?>