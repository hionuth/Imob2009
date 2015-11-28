<?php
ini_set('display_errors', 1);
require_once(".././include/initialize.php");

//if (!$session->is_logged_in()) {
//	redirect_to("login.php");
//}
	//$url="http://cauta-imobiliare.ro/feed_sims.php";
	//$ch = curl_init($url);
    //$content = curl_exec( $ch );
    //$err     = curl_errno( $ch );
    //$errmsg  = curl_error( $ch );
    //$header  = curl_getinfo( $ch );
    //curl_close( $ch );

    //echo $content; ionut github
    echo SyncSite::modalitate("Imobiliare");
    echo SyncSite::modalitate("Imopedia");
    echo SyncSite::modalitate("SimsParkman");
?> 
