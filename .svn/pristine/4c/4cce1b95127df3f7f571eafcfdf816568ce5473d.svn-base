<?php
	ini_set('display_errors', 1); 
	
	function execute_querry($sql,$conexiune){
		$result=mysql_query($sql, $conexiune);
		if (!$result) {
			$output="Eroare in executia comenzii: ".mysql_error();
			$output.=" Ultima comanda executata: ".$sql;
			die($output);
		}
		return $result;
	}

	require_once(".././include/initialize.php");
	if (!$session->is_logged_in()) {
		redirect_to("login.php");
	}
	$pagina="";
	if (isset($_GET['pagina'])){
		$pagina=$_GET['pagina'];
	}

	$t1=time();
	//$database->close_connection();
	
	//$server2="localhost";
	//$user2="imobiliare";
	//$pass2="q123456";
	//$db2="imob_site";
	
	//$ftp_location="localhost.localdomain";
	//$ftp_user_name="ionut";
	//$ftp_user_pass="gv101888";
	$ftp_conn = ftp_connect(FTP_SERVER) or die("Could not connect to ftp location");
	$login_result = ftp_login($ftp_conn, FTP_USER, FTP_PASSWORD);
	
	$tu1=time();
	
	$conexiune2=mysql_connect(SITE_SERVER, SITE_USER, SITE_PASSWORD, TRUE);
	$dbselect2=mysql_select_db(SITE_DB, $conexiune2);
	//mysql_close($conexiune2);

	//$database->open_connection();
	
	
	// refresh agenti
	$sql="SELECT * FROM Utilizator";
	$useri=User::find_by_sql($sql);
	$sql="DELETE FROM Agent";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE Agent AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$agent=array();
	$sql_agent="INSERT INTO Agent (id,User,Parola,Nume,Prenume,NivelAcces,Adresa1,Adresa2,Oras,Judet,Tara,CNP,SerieCI,NumarCI,Telefon,Email) VALUES ";
	foreach ($useri as $usr){
		$agent["id"]=$usr->id;
		$agent["User"]=$usr->User;
		$agent["Parola"]=$usr->Parola;
		$agent["Nume"]=$usr->Nume;
		$agent["Prenume"]=$usr->Prenume;
		$agent["NivelAcces"]=$usr->NivelAcces;
		$agent["Adresa1"]=$usr->Adresa1;
		$agent["Adresa2"]=$usr->Adresa2;
		$agent["Oras"]=$usr->Oras;
		$agent["Judet"]=$usr->Judet;
		$agent["Tara"]=$usr->Tara;
		$agent["CNP"]=$usr->CNP;
		$agent["SerieCI"]=$usr->SerieCI;
		$agent["NumarCI"]=$usr->NumarCI;
		$agent["Telefon"]=$usr->Telefon;
		$agent["Email"]=$usr->Email;
		$sql_agent.="('".join("', '",array_values($agent))."'),";
	}
	$sql_agent=substr($sql_agent,0,strlen($sql_agent)-1);
	$result=execute_querry($sql_agent, $conexiune2);
	
	// refresh subzona
	$sql="SELECT * FROM Cartier";
	$cartiere=Cartier::find_by_sql($sql);
	$sql="DELETE FROM Subzona";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE Subzona AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$subzona=array();
	$sql_subzone="INSERT INTO Subzona (id,Denumire,idCartier) VALUES ";
	foreach ($cartiere as $tmp) {
		$subzona["id"]=$tmp->id;
		$subzona["Denumire"]=$tmp->Denumire;
		$subzona["idCartier"]=$tmp->idZona;
		$sql_subzone.="('".join("', '",array_values($subzona))."'),";
	}
	$sql_subzone=substr($sql_subzone,0,strlen($sql_subzone)-1);
	$result=execute_querry($sql_subzone, $conexiune2);
	
	
	// refresh CategorieDotari
	$sql="SELECT * FROM CategorieDotari";
	$categorii=CategorieDotari::find_by_sql($sql);
	$sql="DELETE FROM CategorieDotari";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE CategorieDotari AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$CategorieDotari=array();
	$sql_catdot="INSERT INTO CategorieDotari (id,Descriere,TipProprietate,TipControl,Prioritate,Privat) VALUES ";
	foreach ($categorii as $tmp){
		$CategorieDotari["id"]=$tmp->id;
		$CategorieDotari["Descriere"]=$tmp->Descriere;
		$CategorieDotari["TipProprietate"]=$tmp->TipProprietate;
		$CategorieDotari["TipControl"]=$tmp->TipControl;
		$CategorieDotari["Prioritate"]=$tmp->Prioritate;
		$CategorieDotari["Privat"]=$tmp->Privat;
		$sql_catdot.="('".join("', '",array_values($CategorieDotari))."'),";
	}
	$sql_catdot=substr($sql_catdot,0,strlen($sql_catdot)-1);
	$result=execute_querry($sql_catdot, $conexiune2);
	
	// refresh Dotari
	$sql="SELECT * FROM Dotare";
	$tmparr=Dotare::find_by_sql($sql);
	$sql="DELETE FROM Dotare";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE Dotare AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$record=array();
	$sql="INSERT INTO Dotare (id,Descriere,idCategorieDotari,Implicit) VALUES ";
	foreach ($tmparr as $tmp){
		$record["id"]=$tmp->id;
		$record["Descriere"]=$tmp->Descriere;
		$record["idCategorieDotari"]=$tmp->idCategorieDotari;
		$record["Implicit"]=$tmp->Implicit;
		$sql.="('".join("', '",array_values($record))."'),";
	}
	$sql=substr($sql,0,strlen($sql)-1);
	$result=execute_querry($sql, $conexiune2);
	
	$ftp_file=array();
	
	$sql_proprietate="INSERT INTO Proprietate (id,idSubzona,idAgent,TipProprietate,Titlu,Descriere,Vanzare,";
	$sql_proprietate.="Inchiriere,Pret,PretChirie,Moneda,NumarCamere,Confort,TipApartament,Etaj,EtajeBloc,";
	$sql_proprietate.="TipConstructie,NrGrupuriSanitare,NumarBalcoane,SuprafataTerasa,CodBazaDate,AnConstructie,";
	$sql_proprietate.="DataActualizare,SuprafataUtila,SuprafataConstruita,OfertaSpeciala) VALUES ";
	
	$sql_dotare="INSERT INTO DotareApartament (idApartament,idDotare) VALUES ";
	$sql_foto="INSERT INTO Foto (idProprietate, NumeFisier, Tip, Marime, Detalii, Ordin, Schita) VALUES ";
	
	
	$sql="SELECT * FROM Oferta WHERE (Exportat<>1 OR Exportat=NULL)";
	$oferte=Oferta::find_by_sql($sql);
	
	//$oferta=array_shift($oferte);
	$td=0;
	$ti=0;
	$tu=0;
	$sync=0;
	$insert=0;
	foreach ($oferte as $oferta) {
		$sync++;
		$apartament=Apartament::find_by_id($oferta->id);
		$client=Client::find_by_id($apartament->idClient);
		$agent=User::find_by_id($client->idUtilizator);
		
		$sql="SELECT * FROM Proprietate WHERE CodBazaDate={$oferta->id}";
		$update=0;
		$result=mysql_query($sql, $conexiune2);
		if ($row=mysql_fetch_array($result)){
			$update=1;
			$idProprietate=$row["id"];
		}
		if ($update){
			$td1=time();
			$sql="DELETE FROM DotareApartament WHERE idApartament={$idProprietate}";
			$result=execute_querry($sql, $conexiune2);
			//$sql="ALTER TABLE DotareApartament AUTO_INCREMENT = 1";
			//$result=execute_querry($sql, $conexiune2);
			$sql="DELETE FROM Foto WHERE idProprietate={$idProprietate}";
			$result=execute_querry($sql, $conexiune2);
			//$sql="ALTER TABLE Foto AUTO_INCREMENT = 1";
			//$result=execute_querry($sql, $conexiune2);
			if (($oferta->OfertaWeb!=1)||($oferta->Stare!="de actualitate")){
				$sql="DELETE FROM Proprietate WHERE id={$idProprietate}";
				//$result=execute_querry($sql, $conexiune2);
				//$sql="ALTER TABLE Proprietate AUTO_INCREMENT = 1";
				$result=execute_querry($sql, $conexiune2);
			}
			$td=$td+(time()-$td1);
		}
		$ti1=time();
		if (($oferta->OfertaWeb==1)&&($oferta->Stare=="de actualitate")){
			$proprietate=array();
			$proprietate["id"]=$oferta->id;
			$subzona=Subzona::find_by_id($apartament->idSubzona);
			$proprietate["idSubzona"]=$subzona->idCartier;
			$proprietate["idAgent"]=$client->idUtilizator;
			$proprietate["TipProprietate"]=$apartament->TipProprietate;
			$proprietate["Titlu"]=$oferta->Titlu;
			if ($proprietate["Titlu"]==""){
				$proprietate["Titlu"]=($apartament->NumarCamere>1?"Apartament ".$apartament->NumarCamere." camere ":"Garsoniera ");
				$zona=Subzona::find_by_id($apartament->idSubzona);
				$proprietate["Titlu"].=$zona->Denumire;
				if ($apartament->PunctReper!="") {$proprietate["Titlu"].=" - ".$apartament->PunctReper;}
			}
			$proprietate["Descriere"]=$apartament->Detalii;
			$proprietate["Vanzare"]=$oferta->Vanzare;
			$proprietate["Inchiriere"]=$oferta->Inchiriere;
			$proprietate["Pret"]=$oferta->Pret;
			$proprietate["PretChirie"]=$oferta->PretChirie;
			$proprietate["Moneda"]=$oferta->Moneda;
			$proprietate["NumarCamere"]=$apartament->NumarCamere;
			$proprietate["Confort"]=$apartament->Confort;
			$proprietate["TipApartament"]=$apartament->TipApartament;
			$proprietate["Etaj"]=$apartament->Etaj;
			$proprietate["EtajeBloc"]=$apartament->EtajeBloc;
			$proprietate["TipConstructie"]=$apartament->TipConstructie;
			$proprietate["NrGrupuriSanitare"]=$apartament->NrGrupuriSanitare;
			$proprietate["NumarBalcoane"]=$apartament->NumarBalcoane;
			$proprietate["SuprafataTerasa"]=$apartament->SuprafataTerasa;
			$proprietate["CodBazaDate"]=$oferta->id;
			$proprietate["AnConstructie"]=$apartament->AnConstructie;
			$proprietate["DataActualizare"]=$oferta->DataActualizare;
			$proprietate["SuprafataUtila"]=$apartament->SuprafataUtila;
			$proprietate["SuprafataConstruita"]=$apartament->SuprafataConstruita;
			$proprietate["OfertaSpeciala"]=$oferta->OfertaSpeciala;
			if ($update==0){
				$insert=1;
				$sql_proprietate.="('".join("', '",array_values($proprietate))."'),";
				//$sql_proprietate="INSERT INTO Proprietate (".join(", ",array_keys($proprietate)).") VALUES ('".join("', '",array_values($proprietate))."')";
				//$result=execute_querry($sql_proprietate, $conexiune2);
				//$idProprietate=mysql_insert_id($conexiune2);
			}
			else {
				$tu1=time();
				$attribute_pairs = array();
				foreach($proprietate as $key => $value) {
					$attribute_pairs[] = "{$key}='{$value}'";
				}
				$sql_upd_proprietate="UPDATE Proprietate SET ".join(", ",$attribute_pairs)." WHERE id=".$idProprietate;
				$result=execute_querry($sql_upd_proprietate, $conexiune2);
				$tu=$tu+(time()-$tu1);
			}
			$oferta->Exportat=1;
			$oferta->save();
			
			// sincronizare dotari
			$sql="SELECT * FROM DotareApartament WHERE idApartament='{$apartament->id}'";
			$dotariApartament=Dotareapartament::find_by_sql($sql);
			if (!empty($dotariApartament)) {
				foreach ($dotariApartament as $dotareApartament){
					$da["idApartament"]=$oferta->id;;
					$da["idDotare"]=$dotareApartament->idDotare;
					$sql_dotare.="('".join("', '",array_values($da))."'),";
				}
			}
			
			//sincronizare poze 
			$sql="SELECT * FROM Foto WHERE idApartament='{$apartament->id}'";
			$fotografii=Foto::find_by_sql($sql);
			if (!empty($fotografii)) {
				foreach ($fotografii as $foto){
					$f["idProprietate"]=$oferta->id;;
					$f["NumeFisier"]=$foto->NumeFisier;
					$f["Tip"]=$foto->Tip;
					$f["Marime"]=$foto->Marime;
					$f["Detalii"]=$foto->Detalii;
					$f["Ordin"]=$foto->Ordin;
					$f["Schita"]=$foto->Schita;
					$sql_foto.="('".join("', '",array_values($f))."'),";
					$ftp_file[]=$foto->NumeFisier;
				}
			}
			$ti=$ti+(time()-$ti1);
		}
	}
	// begin insert
	if ($insert==1){
		$sql_proprietate=substr($sql_proprietate, 0,strlen($sql_proprietate)-1);
		$result=execute_querry($sql_proprietate, $conexiune2);
	}
	$sql="ALTER TABLE DotareApartament AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	$sql="ALTER TABLE Foto AUTO_INCREMENT = 1";
	$result=execute_querry($sql, $conexiune2);
	if ($sync>0){
		$sql_dotare=substr($sql_dotare, 0,strlen($sql_dotare)-1);
		if (strlen($sql_dotare)>80)$result=execute_querry($sql_dotare, $conexiune2);
		$sql_foto=substr($sql_foto,0,strlen($sql_foto)-1);
		if (strlen($sql_foto)>90)$result=execute_querry($sql_foto, $conexiune2);
	}
	if (!empty($ftp_file)){
		foreach ($ftp_file as $file){
			$upload = ftp_put($ftp_conn, FTP_PATH.DS.$file, "..".DS."images".DS.$file, FTP_BINARY);
		}
		
	}
	$tu2=time();
	ftp_close($ftp_conn);
	$t2=time();
	//echo "<br/>Delete time: ".$td;
	//echo "<br/>Insert time: ".$ti;
	//echo "<br/>Sync time: ".$tu;
	//echo "<br/>Total time: ".($t2-$t1);
	echo "<script type=\"text/javascript\">";
		echo "document.location='".($pagina!=""?$pagina:"index.php")."'";
	echo "</script>";
?>