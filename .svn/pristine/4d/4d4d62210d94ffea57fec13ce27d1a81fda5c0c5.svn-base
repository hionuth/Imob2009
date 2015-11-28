<?php
	require_once(".././include/initialize.php");
	$q=$_GET["q"];
	$result="";
	if (strlen($q)>2) {
		$sql="SELECT * FROM Subzona WHERE Denumire LIKE '%".$q."%' ";
		$subzonaList=Subzona::find_by_sql($sql);
		if (!empty($subzonaList))
		{
			$i=0;
			$result="<table width=\"200px\" cellspacing=\"0\" cellpadding=\"0\">";
			foreach ($subzonaList as $subzona)
			{
				$i++;$Denumire=mysql_real_escape_string($subzona->Denumire);
				$class=$i%2 ? "odd" : "even";
				$result.="<tr id=\"SubHint{$subzona->id}\" class=\"$class\" onclick=subzonaHintSelect('".str_replace(" ","%20",$Denumire)."','divSubzonaHint') onmouseover=\"this.style.cursor='pointer';subzonaHintOnOver('SubHint{$subzona->id}',1,$i)\" onmouseout=\"subzonaHintOnOver('SubHint{$subzona->id}',0,$i)\"><td>{$subzona->Denumire}</td></tr>";
			}
			$result.="</table>";
		}	
	}
	echo $result;	
?>