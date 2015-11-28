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

	//require_once(".././include/initialize.php");
	//if (!$session->is_logged_in()) {
	//	redirect_to("login.php");
	//}
	$t1=time();
	//$database->close_connection();
	
	$server2="localhost";
	$user2="igor_site";
	$pass2="igor_site";
	$db2="imob_site";
	
	$ftp_location="localhost.localdomain";
	$ftp_user_name="igor";
	$ftp_user_pass="floarealbastra";
	$ftp_conn = ftp_connect($ftp_location) or die("Could not connect to ftp location");
	$login_result = ftp_login($ftp_conn, $ftp_user_name, $ftp_user_pass);
	
	$tu1=time();
	
	$conexiune2=mysql_connect($server2, $user2, $pass2, TRUE);
	$dbselect2=mysql_select_db($db2, $conexiune2);

	echo "<br/>".mysql_error()."<br/>";
	//mysql_close($conexiune2);

	//$database->open_connection();
	
	$sql="SELECT * FROM Oferta WHERE (Exportat<>1 OR Exportat=NULL)";
	$oferte=Oferta::find_by_sql($sql);
	
	//$oferta=array_shift($oferte);
	$td=0;
	$ti=0;
	foreach ($oferte as $oferta) {
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
			$sql="ALTER TABLE Foto AUTO_INCREMENT = 1";
			$result=execute_querry($sql, $conexiune2);
			if ($oferta->OfertaWeb!=1){
				echo "fac delete;";
				$sql="DELETE FROM Proprietate WHERE id={$idProprietate}";
				//$result=execute_querry($sql, $conexiune2);
				//$sql="ALTER TABLE Proprietate AUTO_INCREMENT = 1";
				$result=execute_querry($sql, $conexiune2);
			}
			$td=$td+(time()-$td1);
		}
		$ti1=time();
		if ($oferta->OfertaWeb==1){
			$proprietate=array();
			$proprietate["idSubzona"]=$apartament->idSubzona;
			$proprietate["idAgent"]=$client->idUtilizator;
			$proprietate["TipProprietate"]=$apartament->TipProprietate;
			$proprietate["Titlu"]=$oferta->Titlu;
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
				$sql_proprietate="INSERT INTO Proprietate (".join(", ",array_keys($proprietate)).") VALUES ('".join("', '",array_values($proprietate))."')";
				$result=execute_querry($sql_proprietate, $conexiune2);
				$idProprietate=mysql_insert_id($conexiune2);
			}
			else {
				$attribute_pairs = array();
				foreach($proprietate as $key => $value) {
					$attribute_pairs[] = "{$key}='{$value}'";
				}
				$sql_proprietate="UPDATE Proprietate SET ".join(", ",$attribute_pairs)." WHERE id=".$idProprietate;
				$result=execute_querry($sql_proprietate, $conexiune2);
			}
			//$oferta->Exportat=1;
			//$oferta->save();
			
			// sincronizare dotari
			
			$sql="SELECT * FROM DotareApartament WHERE idApartament='{$apartament->id}'";
			$dotariApartament=Dotareapartament::find_by_sql($sql);
			if (!empty($dotariApartament)) {
				$sql_dotare="INSERT INTO DotareApartament (idApartament,idDotare) VALUES ";
				foreach ($dotariApartament as $dotareApartament){
					$da["idApartament"]=$idProprietate;
					$da["idDotare"]=$dotareApartament->idDotare;
					$sql_dotare.="('".join("', '",array_values($da))."'),";
					
				}
				$sql_dotare=substr($sql_dotare, 0,strlen($sql_dotare)-1);
				$result=execute_querry($sql_dotare, $conexiune2);
			}
			
			//sincronizare poze 
			
			$sql="SELECT * FROM Foto WHERE idApartament='{$apartament->id}'";
			$fotografii=Foto::find_by_sql($sql);
			if (!empty($fotografii)) {
				$ftp_file=array();
				$sql_foto="INSERT INTO Foto (idProprietate, NumeFisier, Tip, Marime, Detalii, Ordin) VALUES ";
				foreach ($fotografii as $foto){
					$f["idProprietate"]=$idProprietate;
					$f["NumeFisier"]=$foto->NumeFisier;
					$f["Tip"]=$foto->Tip;
					$f["Marime"]=$foto->Marime;
					$f["Detalii"]=$foto->Detalii;
					$f["Ordin"]=$foto->Ordin;
					$sql_foto.="('".join("', '",array_values($f))."'),";
					$ftp_file[]=$foto->NumeFisier;
				}
				$sql_foto=substr($sql_foto,0,strlen($sql_foto)-1);
				$result=execute_querry($sql_foto, $conexiune2);
				if (!empty($ftp_file)){
					foreach ($ftp_file as $file){
						//$upload = ftp_put($ftp_conn, "foto".DS.$file, "..".DS."images".DS.$file, FTP_BINARY);
					}
					
				}
			}
			$ti=$ti+(time()-$ti1);
		}
	}
	$tu2=time();
	ftp_close($ftp_conn);
	$t2=time();
	echo "<br/>Delete time: ".$td;
	echo "<br/>Insert time: ".$ti;
	echo "<br/>Sync time: ".($tu2-$tu1);
	echo "<br/>Total time: ".($t2-$t1);
?>
