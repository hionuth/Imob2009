<?php
	ini_set('display_errors', 1); 
	require_once(".././include/initialize.php");
	if (!$session->is_logged_in()) {
		redirect_to("login.php");
	}
	$pagina="";
	if (isset($_GET['pagina'])){
		$pagina=$_GET['pagina'];
	}
	
	require_once("sync_site_lib.php");
	
	// conectare ftp
	$ftp_conn = ftp_connect(FTP_SERVER) or die("Could not connect to ftp location");
	$login_result = ftp_login($ftp_conn, FTP_USER, FTP_PASSWORD);
	
	// stergere integrala poze
	/*
	$files=ftp_nlist($ftp_conn,NEW_FTP_PATH);
	foreach ($files as $file)
	{
    	if (($file!=".")&&($file!="..")) ftp_delete($ftp_conn, NEW_FTP_PATH.DS.$file);
	} 
	*/	
		
	// conectare BD site
	$conexiune2=mysql_connect(NEW_SITE_SERVER, NEW_SITE_USER, NEW_SITE_PASSWORD, TRUE);
	$dbselect2=mysql_select_db(NEW_SITE_DB, $conexiune2);
	
	// refresh agenti
	sync_Agenti();

	
	// refresh CategorieDotari
	sync_CategorieDotari();
	
	// refresh Dotari
	sync_Dotari();
	
	
	// sync oferte
	//sync_Oferta(1565);
	$sql="SELECT * FROM Oferta WHERE OfertaWeb>0 AND OfertaWeb<4";
	// status oferta:
	//					0 - nu se exporta
	//					1 - creare
	//					2 - update
	//					3 - delete
	//					4 - exportat
	$oferte=Oferta::find_by_sql($sql);
	if (!empty($oferte)){
		foreach ($oferte as $oferta) {
			echo "Sincronizare oferta cu ID {$oferta->id}".PHP_EOL;
			
			sync_Oferta($oferta->id);
		}
	}
	
	echo PHP_EOL."Sincronizare terminata"
?>