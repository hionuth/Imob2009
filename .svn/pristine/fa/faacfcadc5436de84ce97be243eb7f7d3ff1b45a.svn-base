<?php
require_once(".././include/initialize.php");
//if (!$session->is_logged_in()) {
//	redirect_to("login.php");
//}
ini_set('display_errors', 1);

$url="http://cauta-imobiliare.ro/feed_sims.php";

$curl_handle = curl_init();
curl_setopt ($curl_handle, CURLOPT_URL, $url);
curl_setopt ($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt ($curl_handle, CURLOPT_CONNECTTIMEOUT, 1);
$content = curl_exec($curl_handle);
curl_close($curl_handle);

$cilist=explode("\n", $content);

if (!empty($cilist)) {
	foreach ($cilist as $cirow){
		$rec=explode("|", $cirow);
		if (isset($rec[2]))  {
			$oferta=Oferta::find_by_id($rec[2]);
			if (!empty($oferta)){
				$oferta->LinkCI=$rec[1];
				$oferta->save();
				echo "salvat {$oferta->id}\n";
				
			}
		}
	}
}
?>