var xmlhttp;

function showSubzonaHint(str)
{
	if (str.length<3)
	{
		document.getElementById("divSubzonaHint").innerHTML="";
		hide("divSubzonaHint");
		return;
	}
	show("divSubzonaHint");
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Browserul nu suporta XMLHTTP ");
		return;
	}
	var url="subzonahint.php";
	url=url+"?q="+str;
	xmlhttp.onreadystatechange=stateSubzonaChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateSubzonaChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("divSubzonaHint").innerHTML=xmlhttp.responseText;
	}
}

function subzonaHintOnOver(id,over,row){
	var changed = document.getElementById(id);
	if (over == 1) changed.className='deasupra';
	else {
		if (row%2) changed.className='impar';
		else changed.className='par';
	}
}
function subzonaHintSelect(stri,div)
{
	document.getElementById("Subzona").value=stri.replace("%20"," ");
	hide(div);
}