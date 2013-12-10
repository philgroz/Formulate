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
			$var = mysqli_query($data_con, "SELECT id FROM formulae WHERE id='".$_POST["id"]."'");
			if (mysqli_num_rows($var) > 0){
				if (mysqli_query($data_con, "UPDATE formulae SET title='".htmlspecialchars_decode($_POST["title"])."', top='".htmlspecialchars_decode($_POST["top"])."', mid='".htmlspecialchars_decode($_POST["mid"])."', bottom='".htmlspecialchars_decode($_POST["bottom"])."', name='".$_POST["name"]."', category='".$_POST["category"]."' WHERE id='".$_POST["id"]."'")){
					echo "Saved";
					logThis($_POST['name']." was successfully updated by ".$_SESSION["peep"].".");
				}
				else {
					echo "Whooops... There was an error. Try again.";
				}
			}
			else {
				$genID = time().rand(0,9);
				mysqli_query($data_con, "INSERT INTO formulae (id, title, top, mid, bottom, name, author, category) VALUES ('".$genID."','".htmlspecialchars_decode($_POST["title"])."','".htmlspecialchars_decode($_POST["top"])."','".htmlspecialchars_decode($_POST["mid"])."','".htmlspecialchars_decode($_POST["bottom"])."','".$_POST["name"]."','".$_POST["author"]."','".$_POST["category"]."')");
				echo "New Article Created";
				logThis($_POST['name']." was successfully created by ".$_SESSION["peep"].".");
				echo "<span style='display:none;' id='genID'>".$genID."</span>";
			}
		?>
	</body>
</html>