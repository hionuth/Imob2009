function cerereView(id){
	window.open("cerere_view.php?id=" + id,"cerere_view","toolbar=0,resizable=1,scrollbars=1");

}
function onOver(id,over,row){
	var changed = document.getElementById(id);
	if (over == 1) changed.className='deasupra';
	else {
		if (row%2) changed.className='impar';
		else changed.className='par';
	}
}
function onClickExpandZona() {
	//document.getElementById('zoneAfisare').innerText='ionut';
	hide("zonaExpand");
	show("zoneTree");
	//show("zonaCollapse");
}
function onClickCollapseZona() {
	//document.getElementById('zoneAfisare').innerText='ionut';
	hide("zoneTree");
	show("zonaExpand");
	//hide("zonaCollapse");
	
}
function showHide1(item){
	var itemStyle=document.getElementById(item).style;
	if (itemStyle.display!="none") {
		itemStyle.display="none";
	}
	else {
		itemStyle.display="block";
	}
}
function showHide(item,item2){
	var itemStyle=document.getElementById(item).style;
	if (itemStyle.display=="block") {
		itemStyle.display="none";
		document.getElementById(item2).innerHTML="+";
	}
	else {
		itemStyle.display="block";
		document.getElementById(item2).innerHTML="-";
	}
}
function extindeSubzone(id) {
	showHide("zoneCartier"+id,"cartierPlus"+id);
}
function selectZone(checked,value,description){
	var text=document.getElementById("zoneAfisare").innerHTML;
	if (checked==1){
		if (text=="Nimic selectat") {
			text=description;
		}
		else{
			text=text+', '+ description;
		}
	}
	else{
		startpos=text.indexOf(description);
		if (startpos>0) {
			description=", "+description;
		}
		if ((startpos==0)&&(text!=description)) {
			description+=", ";
		}
		text=text.replace(description,"");
		if (text=="") {
			text="Nimic selectat";
		}
	}
	document.getElementById("zoneAfisare").innerHTML=text;
}
function checkZones(fmobj,name,p){
	var lungime = name.length;
	p=document.getElementById("Cart"+p);
	for (var i=0;i<fmobj.elements.length;i++) {
	    var e = fmobj.elements[i];
	    if ( (e.id.substr(0,lungime) == name ) && (e.type=='checkbox') && (!e.disabled) ) {
	    	if (p.checked == 1) {
	    		e.checked = 1;
	    	}
	    	else {
	    		e.checked = 0;
	    	}
	    }
	  }
}