<?php
require_once(".././include/initialize.php");

if (!$session->is_logged_in()) {
	redirect_to("login.php");
}
$user=User::find_by_id($_SESSION['user_id']);
if (isset($_POST['submit'])) {
	$flow=$_POST['flow'];
	$client=Client::find_by_id($_POST['id']);
	
	$client->PermiteSMS="";
	
	$actualizare=(isset($_POST["actualizare"]) ? 1 : 0);
	//$modagent=(isset($_POST["modagent"]) ? 1 : 0);
	$postlist=array_keys($_POST);
	foreach($postlist as $variable) {
		${$variable}=$_POST[$variable];
		switch ($variable){
			case "submit":break;
			case "flow": break;
			case "DataActualizare":
				if ($actualizare) {$client->{$variable}=convert_date(trim(${$variable}),1);}
				break;
			case "Detalii":
				if ($actualizare) {$client->{$variable}=trim(${$variable});}
				break;
			//case "idUtilizator":
			//	if ($modagent) {$client->{$variable}=trim(${$variable});}
			break;
			default: $client->{$variable}=trim(${$variable});
				break;
		}	
	}
	$sql="SELECT * FROM Strada WHERE Denumire='".str_replace("%20"," ",$client->idStrada)."'";
	$stradaList=Strada::find_by_sql($sql);
	$strada=array_shift($stradaList);
	$client->idStrada=$strada->id;
	$client->TelefonMobil=preg_replace("/[^0-9]/","",$client->TelefonMobil);
	$client->TelefonFix=preg_replace("/[^0-9]/","",$client->TelefonFix);
	$client->TelefonFax=preg_replace("/[^0-9]/","",$client->TelefonFax);
	$client->TelefonServici=preg_replace("/[^0-9]/","",$client->TelefonServici);
	
	$client->save();
	redirect_to("client_view.php?id=".$client->id);
}
else {
	$client=Client::find_by_id($_GET['id']);
	$flow=$_GET['flow'];
	$strada=Strada::find_by_id($client->idStrada);
}

?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ro" lang="ro">
<head>
    <title>Imobiliare - Modificare client</title>
   	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />   
   	
   	<link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/jscal2.css" />
   	<link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/gold/gold.css" />
   	<script type="text/javascript" src=".././javascripts/jscal/js/jscal2.js"></script>
   	<script type="text/javascript" src=".././javascripts/jscal/js/lang/en.js"></script>
   	
    <?php require_once(".././include/jquery.php");?>
    <script type="text/javascript" src=".././javascripts/stradahint2.js"></script>
	<script type="text/javascript">
	function onClickB(operation,id){
		if (operation==1) document.location=("client_update.php?id=" + id);
		if (operation==2) window.open("oferta_new.php?id=" + id);
		if (operation==3) window.open("cerere_new.php?id=" + id);
		if (operation==4) document.location = ("check_client.php?telefon=" + id);
	}
		$(function(){
			hide("divStradaHint");
			$("form").form();
			$("#formular").validate({
		   		rules: {
		   			TelefonMobil: {
			    		required: true,
			    		min:0
			    	},
		   			Prenume: "required",
				    Nume:	"required",
		    	}
		    });
		});
	function back(id){
		<?php if ($flow==0) {echo "document.location = \"client_view.php?id=\"+id;"; }
		else  {echo "window.close();";}
		?>
	}
	</script>
</head>
<body>
<?php require_once(".././include/meniu.php");?>
<form action="client_update.php" method="post">
	<input type="hidden" name="id" value="<?php echo $client->id;?>"></input>
	<input type="hidden" name="flow" value="<?php echo $flow;?>"></input>
	<div class="ui-widget-header ui-corner-all" style="padding: 2px;margin: 2px;">
		<input type="button" id="inapoi" value="inapoi" onclick='back(<?php echo $client->id;?>)'/>
		<input type="submit" name="submit" value="salveaza"/>
	</div>

	
	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date identificare</legend>
			<dl>
				<dt><label class="label">prenume</label><input type="text" class="standard" name="Prenume"  value="<?php echo $client->Prenume; ?>" ></input></dt>
				<dt><label class="label">nume</label><input type="text" class="standard" name="Nume"  value="<?php echo $client->Nume; ?>"></input></dt>
				<dt><label class="label">cnp</label><input type="text" class="standard" name="CNP" style="text-align: right;"  value="<?php echo $client->CNP; ?>"></input></dt>
				<dt><label class="label">c.i.</label><input type="text" id="SerieCI" name="SerieCI" style="width: 30px;"  value="<?php echo $client->SerieCI; ?>"></input><input type="text" name="NumarCI" style="text-align: right; width: 144px;" value="<?php echo $client->NumarCI; ?>"></input></dt>
				<dt><label class="label">pasaport</label><input type="text" class="standard" name="SeriePasaport" style="text-align: right;"  value="<?php echo $client->SeriePasaport; ?>" ></input></dt>
			</dl>		
		</fieldset>	
		<fieldset>
			<legend>date contact</legend>
			<dl style="margin-bottom : 0px;">
				<dt><label class="label">telefon 1</label><input type="text" class="standard" name="TelefonMobil" style="text-align: right;" value="<?php echo $client->TelefonMobil; ?>" ></input></dt>
				<dt><label class="label">telefon 2</label><input type="text" class="standard" name="TelefonFix" style="text-align: right;" value="<?php echo $client->TelefonFix; ?>" ></input></dt>
				<dt><label class="label">telefon 3</label><input type="text" class="standard" name="TelefonServici" style="text-align: right;" value="<?php echo $client->TelefonServici; ?>" ></input></dt>
				<dt><label class="label">telefon 4</label><input type="text" class="standard" name="TelefonFax" style="text-align: right;" value="<?php echo $client->TelefonFax; ?>" ></input></dt>
				<dt><label class="label">email</label><input type="text" class="standard" name="Email" value="<?php echo $client->Email; ?>" ></input></dt>
				<dt><label class="label">permite SMS</label><input type="checkbox" class="standard" name="PermiteSMS" <?php echo ($client->PermiteSMS==1 ? "checked=\"checked\"" : "") ; ?> value="1" style="margin-top: 5px;"></input></dt>
				
			</dl>
				
		</fieldset>
	</div>
	
	<div style="display: inline-block; float: left">
		<fieldset>
			<legend>date administrative</legend>
			<dl>
				<dt><label class="label" style="vertical-align: top; padding-top: 5px;">detalii</label><textarea class="standard" style="min-height: 73px;"  name="Detalii" ><?php echo $client->Detalii;?></textarea></dt>
				<dt><label class="label">data actualizare</label><input type="text" name="DataActualizare" id="dataactualizare" value="<?php echo convert_date($client->DataActualizare);?>"></input>
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
								if ($agent->id==$client->idUtilizator) {echo "selected='selected'";}
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
			<label class="label">strada</label><input type="text" class="standard" id="Strada" name="idStrada" value="<?php echo $strada->Denumire;?>" onkeyup="showHint(this.value)"></input>
			<div id="divStradaHint" class="hint" style="margin-left: 105px;"></div>
			<dl style="margin-top: 0px;">
				<dt>
					<label class="label">numar</label><input type="text" class="standard" name="Numar" value="<?php echo $client->Numar;?>" style="width: 30px;" ></input>
					<label>bl.</label><input type="text" class="standard" name="Bloc" value="<?php echo $client->Bloc;?>" style="width: 30px;" ></input>
					<label>sc.</label><input type="text" class="standard" name="Scara" value="<?php echo $client->Scara;?>" style="width: 20px;" ></input>
					<label>ap.</label><input type="text" class="standard" name="Apartament" value="<?php echo $client->Apartament;?>" style="width: 23px;" ></input>
				</dt>
				<dt>
					<label class="label">interfon</label><input type="text" name="Interfon" value="<?php echo $client->Interfon;?>" style="width: 50px;" ></input>
					<label>sector</label><input type="text" class="standard" name="Sector" value="<?php echo $client->Sector;?>" style="width: 87px;" ></input>
				</dt>
				<dt><label class="label">oras</label><input type="text" class="standard"  name="Oras" value="<?php echo $client->Oras;?>"></input></dt>
				<dt><label class="label">judet</label><input type="text" class="standard" name="Judet" value="<?php echo $client->Judet;?>" ></input></dt>
				<dt><label class="label">tara</label><input type="text" class="standard" name="Tara" value="<?php echo $client->Tara;?>"></input></dt>
			</dl>
		</fieldset>
	</div>
	
	
	
	

	
</form>
</body>
</html>