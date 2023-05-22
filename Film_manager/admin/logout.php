<?php
	session_start(); 
	session_unset();
	$actual_link = "http://$_SERVER[HTTP_HOST]/Film_manager/admin/index.php";
    header("Location: ".$actual_link);
?>