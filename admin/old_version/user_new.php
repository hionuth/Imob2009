<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
?> 

<?php include_layout_template('admin_header.php'); ?>
<h3>Utilizator - adaugare</h3>


<script type="text/javascript"> 
<!--
function onClick_close(){
	window.close();
}
function back(){
	document.location = ("user_list.php");
}
//-->
</script>

<?php		
	if (isset($_POST['submit'])) {
		$userobj=new User();
		
		$postlist=array_keys($_POST);
		foreach($postlist as $variable) {
			if ($variable!="submit") {
				${$variable}=$_POST[$variable];
				$userobj->{$variable}=trim(${$variable});
			}	
		}
		if ($userobj->Parola!=""){
			$Parola="";
			$userobj->Parola=md5($userobj->Parola);
		}
		else {unset($userobj->Parola);}
		
		$userobj->save();
		$_SESSION['current_user_id']=$userobj->id;
		$message=" - A fost adaugat utilizatorul cu ID: ".$userobj->id;
	}
	else {
		$message="";
	}
?>
<form action="user_new.php" method="post">
<div class="view">
<h3>Date utilizator<?php echo $message;?></h3>
    <table>
    	<?php 
    		echo put_text_item("Utilizator","User",0);
    		echo put_text_item("Parola","Parola",0);
    		echo put_text_item("Nume","Nume",0);
    		echo put_text_item("Prenume","Prenume",0);
    		echo put_text_item("Telefon","Telefon");
    		echo put_text_item("Email","Email");
    		echo put_text_item("CNP","CNP",0);
    		echo put_text_item("CI Seria","SerieCI",2);
    		echo put_text_item("CI Numar","NumarCI",6);
    		echo put_text_item("Nivel acces ","NivelAcces",1);
    	?>
            <tr> 
            	<td class="label">Adresa</td>
                <td><input type="text" name="Adresa1" maxlength="30" value="<?php echo htmlentities(isset($Adresa1) ? $Adresa1 : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td class="label"></td>
                <td><input type="text" name="Adresa2" maxlength="30" value="<?php echo htmlentities(isset($Adresa2) ? $Adresa2 : ""); ?>" /></td>
            </tr>
       	<?php
			echo put_text_item("Oras","Oras",0);
			echo put_text_item("Judet","Judet",0);
			echo put_text_item("Tara","Tara",0);
       	?>     
	</table>
</div>
<div id="butoane" class="butoane">
	<input type="button" name="inapoi" value="Inapoi" onclick="back()" />
	<input type="submit" name="submit" value="Adauga" <?php if (isset($_POST['submit'])) {echo " disabled";} ?> />
</div>
</form>
<?php include_layout_template('admin_footer.php'); ?>