<html>
	<header>
		<table>
			<tr>
				<td>
					<a href="index.php"><h1>Formulate</h1></a>
					<a href="version-log.php"><span><i>v0.1.1-alpha</i></span></a>
				</td>
				<td> 
					<?php 
						if ($_SESSION["logged"]){
							echo '<div class="button-group minor-group"><a href="index.php" class="button primary icon home">Dashboard</a><a href="statistics.php" class="button icon log">Statistics</a><a href="account.php" class="button icon user">Account ('.$_SESSION["first"][0]."".$_SESSION["last"][0].')</a><a href="logout.php" class="button icon arrowright">Logout</a></div>';
						}
						else {
							
						}
					?>
				</td>
			</tr>
		</table>
	</header>
</html>