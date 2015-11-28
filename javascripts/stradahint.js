var xmlhttp;

function showHint(str)
{
	if (str.length<3)
	{
		document.getElementById("divStradaHint").innerHTML="";
		hide("divStradaHint");
		return;
	}
	show("divStradaHint");
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Browserul nu suporta XMLHTTP ");
		return;
	}
	var url="stradahint.php";
	url=url+"?q="+str;
	xmlhttp.onreadystatechange=stateChanged;
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById("divStradaHint").innerHTML=xmlhttp.responseText;
	}
}

function GetXmlHttpObject()
{
	if (window.XMLHttpRequest)
	{
		return new XMLHttpRequest();
	}
	if (window.ActiveXObject)
	{
		return new ActiveXObject("Microsoft.XMLHTTP");
	}
	return null;
}

function stradaHintOnOver(id,over,row){
	var changed = document.getElementById(id);
	if (over == 1) changed.className='deasupra';
	else {
		if (row%2) changed.className='impar';
		else changed.className='par';
	}
}
function stradaHintSelect(stri,div)
{
	document.getElementById("Strada").value=stri.replace("%20"," ");
	hide(div);
}