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
			<h2>Your Account</h2>
			<table class="table account">
				<tr>
					<td>Username</td><td><?php echo $_SESSION["user"] ?></td>
				</tr>
				<tr>
					<td>Name</td><td><?php echo $_SESSION["peep"] ?></td>
				</tr>
			</table>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>