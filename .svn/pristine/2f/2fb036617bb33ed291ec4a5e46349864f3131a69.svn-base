var xmlhttp;

function showHint(str,divno)
{
	divno = typeof divno !== 'undefined' ? divno : "";
	if (str.length<3)
	{
		document.getElementById("divStradaHint"+divno).innerHTML="";
		hide("divStradaHint"+divno);
		return;
	}
	show("divStradaHint"+divno);
	xmlhttp=GetXmlHttpObject();
	if (xmlhttp==null)
	{
		alert ("Browserul nu suporta XMLHTTP ");
		return;
	}
	var url="stradahint2.php";
	url=url+"?q="+str+"&ord="+divno;
	if (divno!=2) {xmlhttp.onreadystatechange=stateChanged;}
	else {
		xmlhttp.onreadystatechange=stateChanged2;
	}
	xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
}

function stateChanged()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById('divStradaHint').innerHTML=xmlhttp.responseText;
	}
}
function stateChanged2()
{
	if (xmlhttp.readyState==4)
	{
		document.getElementById('divStradaHint2').innerHTML=xmlhttp.responseText;
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
	if (over == 1) changed.className='over';
	else {
		if (row%2) changed.className='odd';
		else changed.className='even';
	}
}
function stradaHintSelect(stri,div,divno)
{
	divno = typeof divno !== 'undefined' ? divno : "";
	var StradaId="Strada"+divno;
	document.getElementById(StradaId).value=stri.replace("%20"," ");
	hide(div);
}