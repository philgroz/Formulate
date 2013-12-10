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
		<?php
			include "header.php";
		?>
		<section>
			<div class="login">
				<form action="login.php" method="post">
				<table>
					<tr>
						<td colspan="2">
							<h3>Sign In</h3>
						</td>
					</tr>
					<tr>
						<td>
							<label>Username</label>
						</td>
						<td>
							<input name="user" type="text" />
						</td>
					</tr>
					<tr>
						<td>
							<label>Password</label>
						</td>
						<td>
							<input name="pass" type="password" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" class="button big" />
						</td>
					</tr>
				</table>
				</form>
			</div>
		</section>
		<footer>
			
		</footer>
	</body>
</html>