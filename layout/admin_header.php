<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>SimsParkmen</title>
	<link rel="stylesheet" type="text/css" href=".././styles/main.css" />
	<link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/jscal2.css" />
    
    <link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/gold/gold.css" />
    <script type="text/javascript" src=".././javascripts/jscal/js/jscal2.js"></script>
    <script type="text/javascript" src=".././javascripts/jscal/js/lang/en.js"></script>
	<script type="text/javascript" src=".././javascripts/stradahint.js"></script>
	
	<script type="text/javascript">
	function hide(menu){
		var menuStyle=document.getElementById(menu).style;
		menuStyle.display="none";
		// <link rel="stylesheet" type="text/css" href=".././javascripts/jscal/css/border-radius.css" />
	}

	function show(menu) {
		var menuStyle=document.getElementById(menu).style;
		menuStyle.display="block";
		
	}
	
	function checkClient() { 
		document.location = ("check_client.php");
	}
	
	function searchCerere() { 
		document.location = ("cerere_search.php");
	}

	function searchOferta() { 
		document.location = ("oferta_search.php");
	}
	function salt_la(locatie){
		document.location = (locatie);
	}
	</script>
	

</head>

<body>
	<div id="header">
		<h2></h2>
    	<h1><img src=".././images/sims.png" alt="Sims Parkman" /></h1>
    	<?php if (isset($title)) {echo "<h3>".$title."</h3>";}?>
    </div> 
    
    <div id="meniu">
    	<table width="100%">
    		<tr>
    			<td id="meniu0" onmouseout="" onclick="checkClient()" width="120">Verifica telefon</td>
				
				<td id="meniu1" onmouseout="" onclick="searchCerere()" width="120">Cereri</td>
    			
    			<td id="meniu2" onmouseout="" onclick="searchOferta()" width=100>Oferte</td>
    			
    			<td id="meniu3" onmouseover="show('submeniu3')" onmouseout="hide('submeniu3')" width="100">Utilizator
    				<div id="submeniu3">
    					<table cellpadding="0" cellspacing="0" width="100">
    						<tr onclick="salt_la('logout.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Logout</td>
    						</tr>
    						<tr onclick="salt_la('user_new.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Adauga</td>
    						</tr>
    						<tr onclick="salt_la('user_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Listeaza</td>
    						</tr>
    					</table>
    				</div>
    			</td>
    			<td id="meniu4" onmouseover="show('submeniu4')" onmouseout="hide('submeniu4')" width="100">Configurare
    				<div id="submeniu4">
    					<table cellpadding="0" cellspacing="0" width="100">
    						<tr onclick="salt_la('zona_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Oras</td>
    						</tr>
    						<tr onclick="salt_la('cartier_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Zone</td>
    						</tr>
    						<tr onclick="salt_la('subzona_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Subzone</td>
    						</tr>
    						<tr onclick="salt_la('strada_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Strazi</td>
    						</tr>
    						<tr><td><hr></td></tr>
    						<tr onclick="salt_la('dotare_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Dotari</td>
    						</tr>
    						<tr onclick="salt_la('categoriedotare_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Categorii dotari</td>
    						</tr>
						</table>
    				</div>
    			</td>
    			<td></td>
    		</tr>
    	</table>
    </div>
    
    
 

<script type="text/javascript">
	//hide('submeniu1');
	//hide('submeniu2');
	hide('submeniu3');
	hide('submeniu4');
</script>
    

