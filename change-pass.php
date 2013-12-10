<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "formulate.php";
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
				<form action="change-pass-action.php" method="post">
				<table>
					<tr>
						<td colspan="2">
							<h3>Change your Password</h3>
						</td>
					</tr>
					<tr>
						<td>
							<label>Current Password</label>
						</td>
						<td>
							<input name="pass" type="password" />
						</td>
					</tr>
					<tr>
						<td>
							<label>New Password</label>
						</td>
						<td>
							<input name="new" type="password" />
						</td>
					</tr>
					<tr>
						<td>
							<label>Confirm New Password</label>
						</td>
						<td>
							<input name="new2" type="password" />
						</td>
					</tr>
					<tr>
						<td colspan="2">
							<input type="submit" value="Change Password" class="button big danger" />
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