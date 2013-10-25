<?php
	// LOGIN
	if (isset($_SESSION["logged"])){
		if ($_SESSION["logged"]){
			// if there is already someone logged in, define the functions below
		}
		else {
			echo "<script type='text/javascript'>window.location='signin.php';</script>";
			die();
		}
	}
	else {
		// if no one is logged in, redirect to the sign in page and terminate this script
		echo "<script type='text/javascript'>window.location='signin.php';</script>";
		die();
	}
?>
<html>
</html>