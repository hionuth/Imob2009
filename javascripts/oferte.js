function ofertaView(id){
		window.open("oferta_view.php?id=" + id,"_blank");//"oferta_view","width=1046,height=742,toolbar=0,resizable=1,scrollbars=1");
	
}
function onOver(id,over,row){
	var changed = document.getElementById(id);
	if (over == 1) changed.className='row over';
	else {
		if (row%2) changed.className='row odd';
		else changed.className='row even';
	}
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
