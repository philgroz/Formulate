<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "formulate.php";
		?>
	</head>
	<body>
		<?php
			$data_con = mysqli_connect("localhost", 'root', 'root', 'formulae');
			if ($_POST["type"] == 1){
				if ($_POST["s"] != "" && $_POST["s"] != "*"){
					$search = mysqli_query($data_con, "SELECT * FROM formulae WHERE name LIKE '%".$_POST["s"]."%'");
					echo '<p><i>Formulate found '.mysqli_num_rows($search).' result(s)</i></p><table class="table search">';
					while ($item = mysqli_fetch_assoc($search)){
						echo display($item, true);
					}
					echo "</table>";
					// echo "<span>".mysqli_num_rows($search)." result(s)</span>";
				}
				else if ($_POST["s"] != "") {
					$search = mysqli_query($data_con, "SELECT * FROM formulae");
					echo '<p><i>Formulate found '.mysqli_num_rows($search).' result(s)</i></p><table class="table search">';
					while ($item = mysqli_fetch_assoc($search)){
						echo display($item, true);
					}
					echo "</table>";
				}
			}
			else if ($_POST["type"] == 2){
				$search = mysqli_query($data_con, "SELECT * FROM formulae WHERE author='".$_SESSION["peep"]."'");
				echo '<p><i>Formulate found '.mysqli_num_rows($search).' result(s)</i></p><table class="table search">';
				while ($item = mysqli_fetch_assoc($search)){
					echo display($item, true);
				}
				echo "</table>";
			}
			else if ($_POST["type"] == 3){
				$search = mysqli_query($data_con, "SELECT * FROM formulae ORDER BY formulae.id DESC LIMIT 5 ");
				echo '<p><i>Recently created articles</i></p><table class="table search">';
				while ($item = mysqli_fetch_assoc($search)){
					echo display($item, true);
				}
				echo "</table>";
			}
		?>
	</body>
</html>