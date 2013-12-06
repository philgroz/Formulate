<!-- Copyright GRAPHITE 2013 -->
<!-- Grozinger P -->
<!-- Formulate v1.0 -->

<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "formulate.php";
			include "head.php";
		?>
		<title>Account | Formulate</title>
	</head>
	<body>
		<?php
			include "header.php";
		?>
		<section class="account">
			<h2>Account</h2>
			<p>Below is the all the information that is tied to your account.</p>
			<table class="table account">
				<tr>
					<td>Username</td><td><?php echo $_SESSION["user"] ?></td>
				</tr>
				<tr>
					<td>Name</td><td><?php echo $_SESSION["peep"] ?></td>
				</tr>
				<tr>
					<td>Password</td><td><a class="button danger icon lock" href="change-pass.php">Change Password</a></td>
				</tr>
			</table>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>