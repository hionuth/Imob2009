<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
?> 

<?php include_layout_template('admin_header.php'); ?>

<?php 
function put_item($var,$label) {
		$item="<tr><td class='label'>".$label.":</td>";
		$item=$item."<td>".$var."</td></tr>";
		return $item;
	}

?>

<?php		
	
	if (isset($_POST['submit'])) {

		$client=new Client();
		
		if (isset($_SESSION['current_client_id'])) {
			$client->id=$_SESSION['current_client_id'];
			$message=" A fost modificat clientul cu ID: ".$client->id;
		}
		else {
			$message=" A fost adaugat clientul cu ID: ".$client->id;	
		}
		
		$postlist=array_keys($_POST);
		foreach($postlist as $variable) {
			if ($variable!="submit") {
				${$variable}=$_POST[$variable];
				$client->{$variable}=trim(${$variable});
			}	
		}
		if (!isset($idUtilizator)) {$client->idUtilizator=$_SESSION['user_id'];};

		$client->save();
		$_SESSION['current_client_id']=$client->id;
		$message=" A fost adaugat clientul cu ID: ".$client->id;
	}
	else {
		
		$message="";
		if (isset($_POST['delete'])) {
			$client = new Client();
			$client->id=$_SESSION['current_client_id'];
			$client->delete();
			$message=" A fost sters clientul cu ID ".$_SESSION['current_client_id'];
		}
		unset($_SESSION['current_client_id']);
	}
	if ($message!="") { echo output_message($message); }
	
?>
<div>
	<form action="client_new.php" method="post">
    	<table>
        	<tr>
            	<td>Nume</td>
                <td><input type="text" name="Nume" maxlength="30" value="<?php echo htmlentities(isset($Nume) ? $Nume : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Prenume</td>
                <td><input type="text" name="Prenume" maxlength="30" value="<?php echo htmlentities(isset($Prenume) ? $Prenume : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Tel. mobil</td>
                <td><input type="text" name="TelefonMobil" maxlength="30" value="<?php echo htmlentities(isset($TelefonMobil) ? $TelefonMobil : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Tel. fix</td>
                <td><input type="text" name="TelefonFix" maxlength="30" value="<?php echo htmlentities(isset($TelefonFix) ? $TelefonFix : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Tel. servici</td>
                <td><input type="text" name="TelefonServici" maxlength="30" value="<?php echo htmlentities(isset($TelefonServici) ? $TelefonServici : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Fax</td>
                <td><input type="text" name="TelefonFax" maxlength="30" value="<?php echo htmlentities(isset($TelefonFax) ? $TelefonFax : ""); ?>" /></td>
            </tr>
             <tr> 
            	<td>Permite SMS</td>
                <td><input type="checkbox" name="PermiteSms" value=1  <?php if (isset($PermiteSms)) {if ($PermiteSms==1) {echo 'checked="checked"';}} else { echo '';}?> /></td>
            </tr>
            <tr> 
            	<td>Email</td>
    			<td><input type="text" name="Email" maxlength="30" value="<?php echo htmlentities(isset($Email) ? $Email : ""); ?>" /></td>
            </tr>
             <tr> 
            	<td>CNP</td>
                <td><input type="text" name="CNP" maxlength="30" value="<?php echo htmlentities(isset($CNP) ? $CNP : ""); ?>" /></td>
            </tr>
            
             <tr> 
            	<td>Serie CI</td>
                <td><input type="text" name="SerieCI" maxlength="30" value="<?php echo htmlentities(isset($SerieCI) ? $SerieCI : ""); ?>" /></td>
            </tr>
             <tr> 
            	<td>Numar CI</td>
                <td><input type="text" name="NumarCI" maxlength="30" value="<?php echo htmlentities(isset($NumarCI) ? $NumarCI : ""); ?>" /></td>
            </tr>
             <tr> 
            	<td>Serie pasaport</td>
                <td><input type="text" name="SeriePasaport" maxlength="30" value="<?php echo htmlentities(isset($SeriePasaport) ? $SeriePasaport : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Adresa</td>
                <td><input type="text"  name="Adresa" maxlength="30" value="<?php echo htmlentities(isset($Adresa) ? $Adresa : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Strada</td>
                <td>
                	<select name='idStrada'>
						<option value='' selected='selected'>alegeti ...</option>
						<?php
						$stradalist=Strada::find_all();
						foreach ($stradalist as $strada) {
							echo "<option ";
							echo "label='".$strada->Denumire;
							echo "' value='".$strada->id."'";						
							echo "></option>";
						}
						?>
					</select>
				</td>
            </tr>
            <tr> 
            	<td>Oras</td>
                <td><input type="text" name="Oras" maxlength="30" value="<?php echo htmlentities(isset($Oras) ? $Oras : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Judet</td>
                <td><input type="text" name="Judet" maxlength="30" value="<?php htmlentities(isset($Judet) ? $Judet : ""); ?>" /></td>
            </tr>
            <tr> 
            	<td>Tara</td>
                <td><input type="text" name="Tara" maxlength="30" value="<?php echo htmlentities(isset($Tara) ? $Tara : ""); ?>" /></td>
            </tr>
            <tr> 
            <?php 
           		$user=User::find_by_id($_SESSION['user_id']);
				if ($user->NivelAcces==0){
					echo "<td>Agent:</td>";
					echo "<td>";
					echo "<select name='idUtilizator'>";
					$userlist=User::find_all();
					foreach ($userlist as $agent) {
						echo "<option ";
						echo "label='".$agent->Nume." ".$agent->Prenume."'";
						if ($agent->id==$_SESSION['user_id']) {echo "selected='selected'";}
						echo "value='".$agent->id."'>";
						echo "</option>";
					}
					echo "</select><br/>";
					echo "</td>";
				}
				?>
            </tr>
            <tr> 
            	<td>Detalii</td>
                <td>
                	<textarea name="Detalii" rows="3" cols="30"><?php echo htmlentities(isset($Detalii) ? $Detalii : ""); ?></textarea>
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                    <input type="submit" name="submit" value="Adauga / Modifica" />
                    <input type="submit" name="delete" <?php if (!isset($_SESSION['current_client_id'])) {echo 'disabled="disabled"';}?> value="Sterge" />
                </td>
            </tr>       
         </table>
    </form>

</div>


<?php include_layout_template('admin_footer.php'); ?>