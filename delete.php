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
		?>
	</head>
	<body>
		<?php
			echo "hi";
			$data_con = mysqli_connect("localhost", 'root', 'root', 'formulae');
			if (mysqli_query($data_con, "DELETE FROM formulae WHERE id='".$_GET["id"]."'")){
				echo "Deleted";
			}
			else {
				echo "Whooops... There was an error. Try again.";
			}
		?>
		<script type="text/javascript">
			window.location = "open.php";
		</script>
	</body>
</html>