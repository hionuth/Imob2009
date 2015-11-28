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
<style>
<!--
.link{
	text-decoration: none;
	color: white;
}
.link:hover{
	text-decoration: none;
	color: rgb(200,200,200);
}
-->
</style>
<h2 style="margin-bottom: 10px;"></h2>
<?php 
$currentPage=$_SERVER['REQUEST_URI'];
$userMeniu = User::find_by_id($session->user_id);
?>
<div id="meniu">
    	<table style="width: 100%;">
    		<tr>
    			<td id="meniu0" onmouseout="" onclick="checkClient()" width="120">
	    			<a href="check_client.php" class="link">Verifica telefon</a>
    			</td>
				<td id="meniu1" onmouseout="" onclick="searchCerere()" width="100">
					<a href="cerere_search.php" class="link">Cereri</a>
				</td>
    			<td id="meniu2" onmouseout="" onclick="searchOferta()" width=100>
    				<a href="oferta_search.php" class="link">Oferte</a>
    			</td>
    			<td id="meniu5" onmouseout="" onclick="document.location = ('client_list.php');" width=100>
    				<a href="client_list.php" class="link">Clienti</a>
    			</td>
    			
    			<td id="meniu5" onmouseover="show('submeniu5')" onmouseout="hide('submeniu5')" width="100">
    				<a class="link">Rapoarte</a>
    				<div id="submeniu5">
    					<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
    						<tr onclick="salt_la('sync_status.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sincronizari</td>
    						</tr>
    						<tr style="padding: 0px; margin: 0px; border: 0px;" onclick="salt_la('raport_activitate2.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Activitate</td>
    						</tr>
    					</table>
    				</div>
    			</td>
    			<td id="meniu4" onmouseover="show('submeniu4')" onmouseout="hide('submeniu4')" width="140"><a class="link">Configurare</a>
    				<div id="submeniu4">
    					<table style="width: 100%; border-spacing: 0; border-collapse: collapse;">
    						<tr onclick="salt_la('zona_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Localitati</td>
    						</tr>
    						<tr onclick="salt_la('cartier_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Pozitionari</td>
    						</tr>
    						<tr onclick="salt_la('subzona_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Zone</td>
    						</tr>
    						<tr onclick="salt_la('strada_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Strazi</td>
    						</tr>
    						<tr><td><hr></td></tr>

    						<tr onclick="salt_la('categoriedotare_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Categorii dotari</td>
    						</tr>
    						<tr><td><hr></td></tr>
    						
    						<tr onclick="salt_la('user_list.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Utilizatori</td>
    						</tr>
    						<tr onclick="salt_la('config_sync.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sincronizari</td>
    						</tr>
    						
    						<tr><td><hr></td></tr>
    						<tr onclick="salt_la('sync_site.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sincronizare site</td>
    						</tr>
    						<tr onclick="salt_la('sync_imobiliare.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sync Imobiliare</td>
    						</tr>
    						<tr onclick="salt_la('sync_mc.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sync Mag. de case</td>
    						</tr>
    						<tr onclick="salt_la('sync_imopedia.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sync Imopedia</td>
    						</tr>
    						<tr onclick="salt_la('sync_pb.php')" onmouseover="this.className='menuover'" onmouseout="this.className='menuout'">
    							<td>Sync PropertyBook</td>
    						</tr>
    						
						</table>
    				</div>
    			</td>
    			<td style="text-align: right;"><?php echo $userMeniu->full_name()." - ";?><a href="logout.php" class="link">log out</a></td>
    		</tr>
    	</table>
    </div>
    
    
 

<script type="text/javascript">
	//hide('submeniu1');
	//hide('submeniu2');
	//hide('submeniu3');
	hide('submeniu4');
	hide('submeniu5');
</script>