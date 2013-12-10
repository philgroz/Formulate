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
			$name = mysqli_query($data_con, "SELECT name FROM formulae WHERE id='".$_GET["id"]."'");
			if (mysqli_num_rows($name) != 0){
				if (mysqli_query($data_con, "DELETE FROM formulae WHERE id='".$_GET["id"]."'")){
					echo "Deleted";
					$name = mysqli_fetch_assoc($name);
					logThis($name["name"]." was successfully deleted by ".$_SESSION["peep"].".");
				}
				else {
					echo "Whooops... There was an error. Try again.";
				}
			}
		?>
		<script type="text/javascript">
			window.location = "open.php";
		</script>
	</body>
</html>