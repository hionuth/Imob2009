<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}

$Tara="Romania";
$TelefonMobil="";

$user=User::find_by_id($_SESSION['user_id']);
if (isset($_GET['tel'])) { 
	$TelefonMobil=$_GET['tel'];
}
if (isset($_POST['submit'])) {
	$client=new Client();
	
	$actualizare=(isset($_POST["actualizare"]) ? 1 : 0);
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		${$variable}=$_POST[$variable];
		switch ($variable){
			case "submit":break;
			default: $client->{$variable}=trim(${$variable});
				break;
		}	
	}
	
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$client->idStrada)."'";
	$stradaList=Strada::find_by_sql($sql);
	$strada=array_shift($stradaList);
	$client->idStrada=$strada->id;
	
	if ($user->NivelAcces!=0) {
		$client->idUtilizator=$user->id;
	}
	$client->DataActualizare=date("Y/m/d");
	$client->TelefonMobil=preg_replace("/[^0-9]/","",$client->TelefonMobil);
	$client->TelefonFix=preg_replace("/[^0-9]/","",$client->TelefonFix);
	$client->TelefonFax=preg_replace("/[^0-9]/","",$client->TelefonFax);
	$client->TelefonServici=preg_replace("/[^0-9]/","",$client->TelefonServici);
	$client->save();
	redirect_to("check_client.php?telefon={$client->TelefonMobil}");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Adaugare client</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
	<script>
		$(function(){
			hide("divStradaHint");
			$("form").form();
			//$("SerieCI").css({width:20,margin:2,height:20});

			$("#formular").validate({
		   		rules: {
		   			TelefonMobil: {
			    		required: true,
			    		min:0
			    	},
		   			Prenume: {
						required: "#Nume:blank"		
				   	},
			    	Nume: {
			    		required: "#Prenume:blank"	
				   	}
		    	}
		    });
		});
	</script>
</head>
<body>
<?php require_once(".././include/meniu.php");?>
<form id="formular" action="client_new.php" method="post">
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" value="inapoi" onclick="document.location='check_client.php?telefon=<?php echo $TelefonMobil;?>'"/>
		<input type="submit" name="submit" value="salveaza"/>
	</div>

	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date identificare</legend>
			<dl>
				<dt><label class="label">prenume</label><input type="text" id="Prenume" class="standard" name="Prenume" ></input></dt>
				<dt><label class="label">nume</label><input type="text" id="Nume" class="standard" name="Nume"></input></dt>
				<dt><label class="label">cnp</label><input type="text" class="standard" name="CNP" style="text-align: right;"></input></dt>
				<dt><label class="label">c.i.</label><input type="text" id="SerieCI" name="SerieCI" style="width: 30px;"></input><input type="text" name="NumarCI" style="text-align: right; width: 144px;"></input></dt>
				<dt><label class="label">pasaport</label><input type="text" class="standard" name="SeriePasaport" style="text-align: right;"></input></dt>
			</dl>		
		</fieldset>	
		<fieldset>
			<legend>date contact</legend>
			<dl style="margin-bottom : 0px;">
				<dt><label class="label">telefon 1</label><input type="text" class="standard" name="TelefonMobil" style="text-align: right;" value="<?php echo $TelefonMobil; ?>" ></input></dt>
				<dt><label class="label">telefon 2</label><input type="text" class="standard" name="TelefonFix" style="text-align: right;"></input></dt>
				<dt><label class="label">telefon 3</label><input type="text" class="standard" name="TelefonServici" style="text-align: right;" ></input></dt>
				<dt><label class="label">telefon 4</label><input type="text" class="standard" name="TelefonFax" style="text-align: right;"></input></dt>
				<dt><label class="label">email</label><input type="text" class="standard" name="Email" ></input></dt>
				<dt><label class="label">permite SMS</label><input type="checkbox" class="standard" name="PermiteSMS" value="1" style="margin-top: 5px;"></input></dt>
				
			</dl>
				
		</fieldset>
	</div>
	
	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date administrative</legend>
			<dl>
				<dt><label class="label" style="vertical-align: top; padding-top: 5px;">detalii</label><textarea class="standard" style="min-height: 73px;"  name="Detalii" ></textarea></dt>
				<dt><label class="label">data actualizare</label><input type="text" name="DataActualizare" id="dataactualizare"></input>
					<input type="button" id="calendar-trigger" value='...'/><br/>
					<script>
	    				var cal1=Calendar.setup({onSelect:function(){cal1.hide();}});
	    				cal1.manageFields("calendar-trigger", "dataactualizare", "%d/%m/%Y");
					</script>
				</dt>
				<dt>
					<label class="label">agent</label><select name='idUtilizator' class="standard">
						<?php 
							$userlist=User::find_all();
							foreach ($userlist as $agent) {
								echo "<option ";
								if ($agent->id==$user->id) {echo "selected='selected' ";}
								echo "value='".$agent->id."'>{$agent->full_name()}";
								echo "</option>";
							}
						?>
					</select>
				</dt>
				
				
			</dl>		
		</fieldset>	
		<fieldset>
			<legend>adresa</legend>
			<label class="label">strada</label><input type="text" class="standard" id="Strada" name="idStrada" onkeyup="showHint(this.value)"></input>
			<div id="divStradaHint" class="hint" style="margin-left: 105px;"></div>
			<dl style="margin-top: 0px;">
				<dt>
					<label class="label">numar</label><input type="text" class="standard" name="Numar"  style="width: 30px;" ></input>
					<label>bl.</label><input type="text" class="standard" name="Bloc"  style="width: 30px;" ></input>
					<label>sc.</label><input type="text" class="standard" name="Scara" style="width: 20px;" ></input>
					<label>ap.</label><input type="text" class="standard" name="Apartament" style="width: 23px;" ></input>
				</dt>
				<dt>
					<label class="label">interfon</label><input type="text" name="Interfon" style="width: 50px;" ></input>
					<label>sector</label><input type="text" class="standard" name="Sector"  style="width: 87px;" ></input>
				</dt>
				<dt><label class="label">oras</label><input type="text" class="standard"  name="Oras" ></input></dt>
				<dt><label class="label">judet</label><input type="text" class="standard" name="Judet"  ></input></dt>
				<dt><label class="label">tara</label><input type="text" class="standard" name="Tara" ></input></dt>
			</dl>
		</fieldset>
	</div>

</form>
</body>
</html>
