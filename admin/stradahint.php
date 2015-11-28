<?php
	
	require_once(".././include/initialize.php");
	$q=$_GET["q"];
	$result="";
	if (strlen($q)>2) {
		$sql="SELECT * FROM Strada WHERE Denumire LIKE '%".$q."%' ";
		$stradaList=Strada::find_by_sql($sql);
		if (!empty($stradaList))
		{
			$i=0;
			$result="<table width=\"200px\" cellspacing=\"0\" cellpadding=\"0\">";
			foreach ($stradaList as $strada)
			{
				$i++;$Denumire=mysql_real_escape_string($strada->Denumire);
				$class=$i%2 ? "impar" : "par";
				//$result.="<tr id='StrHint".$strada->id."' class='".$class."' onclick=stradaHintSelect(\"".$strada->Denumire."\") onmouseover=this.style.cursor='hand';onOver('StrHint".$strada->id."',1,".$i.") onmouseout=onOver('StrHint".$strada->id."',0,".$i.")><td>".$strada->Denumire."</td></tr>";
				$result.="<tr id=\"StrHint{$strada->id}\" class=\"$class\" onclick=stradaHintSelect('".str_replace(" ","%20",$Denumire)."','divStradaHint') onmouseover=\"this.style.cursor='pointer';stradaHintOnOver('StrHint{$strada->id}',1,$i)\" onmouseout=\"stradaHintOnOver('StrHint{$strada->id}',0,$i)\"><td>{$strada->Denumire}</td></tr>";
			}
			$result.="</table>";
		}	
	}
	echo $result;	
?>