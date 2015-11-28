<?php
	echo "2";
	require_once(".././include/initialize.php");
	$q=$_GET["q"];
	$sql="SELECT * FROM Strada WHERE Denumire LIKE '%".$q."%' ";
	$stradaList=Strada::find_by_sql($sql);
	$result="";
	if (!empty($strdaList))
	{
		foreach ($stradaList as $strada)
		{
			if (result=="") {$result=$strada->id."|".$strada->Denumire;}
			else {$result.=",".$strada->id."|".$strada->Denumire;}
		}
	}
	echo $result
?>