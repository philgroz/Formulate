<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "head.php";
		?>
	</head>
	<body>
		<?php
			$user_con = mysqli_connect("localhost", 'root', 'root', 'formulate_users');
			$users = mysqli_query($user_con, "SELECT * FROM users WHERE user='".$_POST["user"]."'");
			$user = mysqli_fetch_assoc($users);
			if (mysqli_connect_errno()){ // if mysql error
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			if (isset($_SESSION["logged"])){
				if ($_SESSION["logged"]){
					echo "<script type='text/javascript'>window.location='index.php';</script>";
					die();
				}
			}
			if (isset($_POST["pass"])){
				if (crypt($_POST["pass"], $user["pass"]) == $user["pass"]){
					// if the passwords match, set the required variables
					$_SESSION["logged"] = true; // login status
					$_SESSION["user"] = $_POST["user"];
					$_SESSION["first"] = $user["first"];
					$_SESSION["last"] = $user["last"];
					$_SESSION["peep"] = $user["first"]." ".$user["last"];
					// go to the dashboard
					echo "<script type='text/javascript'>window.location='index.php';</script>";
					die();
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