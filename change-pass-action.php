<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "head.php";
			// LOGIN
			if (isset($_SESSION["logged"])){
				if ($_SESSION["logged"] && $_POST["new"] == $_POST["new2"]){
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
	</head>
	<body>
		<?php
			$user_con = mysqli_connect("localhost", 'root', 'root', 'formulate_users');
			$users = mysqli_query($user_con, "SELECT * FROM users WHERE user='".$_SESSION["user"]."'");
			$user = mysqli_fetch_assoc($users);
			if (mysqli_connect_errno()){ // if mysql error
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			if (isset($_POST["pass"])){
				if (crypt($_POST["pass"], $user["pass"]) == $user["pass"]){
					// if the passwords match, perform the following
					mysqli_query($user_con, "UPDATE users SET pass='".crypt($_POST["new"])."' WHERE user='".$_SESSION["user"]."'");
					echo "<script type='text/javascript'>var r=confirm('Your password was changed successfully'); if (r==true){window.location='account.php';} else{window.location='account.php';}</script>";
				}
				else {
					echo "<script type='text/javascript'>window.location='signin.php';</script>";
					die();
				}
			}
			else {
				echo "<script type='text/javascript'>window.location='signin.php';</script>";
				die();
			}
		?>
	</body>
</html>