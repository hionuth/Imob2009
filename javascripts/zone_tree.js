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
function showHide(id,item2){
	item="zoneCartier" + id;
	var itemStyle=document.getElementById(item).style;
	if (itemStyle.display=="block") {
		itemStyle.display="none";
		document.getElementById(item2).innerHTML="+";
	}
	else {
		itemStyle.display="block";
		document.getElementById(item2).innerHTML="-";
		colapseZone(id);
		
	}
}
function extindeSubzone(id) {
	showHide(id,"cartierPlus"+id);
}

function extindeCartiere(id) {
	showHideZone(id,"zonaPlus"+id);
}

function showHideZone(id,item2){
	item="cartiereZona" + id;
	var itemStyle=document.getElementById(item).style;
	if (itemStyle.display=="block") {
		itemStyle.display="none";
		document.getElementById(item2).innerHTML="+";
	}
	else {
		itemStyle.display="block";
		document.getElementById(item2).innerHTML="-";
		colapseZone(id);
		
	}
}

function colapseZone(id){
	for (var i=0;i<100;i++) {
		var e=document.getElementById("zoneCartier"+i);
	    if ((i!=id) && (e != null)) {
	    	e.style.display = "none";
	    	document.getElementById("cartierPlus"+i).innerHTML="+";
	    }
	  }
}

function selectZone(checked,value,description){
	var text=document.getElementById("zoneAfisare").innerHTML;
	if (checked==0){
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

function checkZones(self, str){
	//Check cartier
	  $(self).parent().parent().parent().next().find('input[type="checkbox"]').attr('checked', $(self).is(':checked'));
	}


function xxcheckZones(fmobj,name,p){
	var lungime = name.length;
	p=document.getElementById("Cart"+p);
	for (var i=0;i<fmobj.elements.length;i++) {
	    var e = fmobj.elements[i];
	    if ( (e.id.substr(0,lungime) == name ) && (e.type=='checkbox') && (!e.disabled) ) {
	    	if (p.checked == 1) {
	    		e.checked = 1;
	    		e.click();
	    	}
	    	else {
	    		e.checked = 0;
	    		e.click();
	    	}
	    	//e.click();
	    }
	  }
}