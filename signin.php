<!-- Copyright GRAPHITE 2013 -->
<!-- Grozinger P -->
<!-- Formulate v1.0 -->

<?php
	session_start();
?>

<html>
	<head>
		<?php
			// LOGIN
			if (isset($_SESSION["logged"])){
				if ($_SESSION["logged"]){
					echo "<script type='text/javascript'>window.location='index.php';</script>";
					die();
				}
			}
			include "head.php";
		?>
		<title>Formulate | Sign In</title>
	</head>
	<body>
		<header>
		<?php
			include "header.php";
		?>
		</header>
		<section>
			<div class="login">
				<h3>Sign In</h3>
				<form action="login.php" method="post">
					<label>USERNAME</label>
					<input name="user" type="text" />
					<label>PASSWORD</label>
					<input name="pass" type="password" />
					<input type="submit" class="button" />
				</form>
			</div>
		</section>
		<footer>
			
		</footer>
	</body>
</html>