<?php
require_once(".././include/initialize.php");

if ($session->is_logged_in()) {
	$session->logout();
}
redirect_to("login.php");
?> 

<?php include_layout_template('header.php'); ?>

    <h3>Meniu</h3>
    <p>Logged out ...</p>
    <ul>
    	<li><a href="login.php">Login</a></li>
    </ul>
    
    <hr />    
<?php include_layout_template('admin_footer.php'); ?>