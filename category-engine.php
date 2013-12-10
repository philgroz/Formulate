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
			$categories = mysqli_query($data_con, "SELECT * FROM categories");
			
			if ($_POST["type"] == 1){ // edit
				while ($a = mysqli_fetch_assoc($categories)){
					if ($_POST["id"] == $a["id"]){
						echo "<tr><td><input id='n-".$a["id"]."' type='text' value='".$a['name']."' /></td><td><input id='d-".$a["id"]."' type='text' value='".$a['description']."'/></td><td><div class='button-group'><button class='button icon approve' onclick='changeCategory(2, ".$a["id"].")'>Save</button><button class='button icon remove' onclick='changeCategory(0)'>Cancel</button></div></td></tr>";
					}
					else {
						echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
					}
				}
			}
			else if ($_POST["type"] == 2){
				mysqli_query($data_con, "UPDATE categories SET name='".$_POST["name"]."', description='".$_POST["description"]."' WHERE id='".$_POST["id"]."'");
				$categories = mysqli_query($data_con, "SELECT * FROM categories");
				while ($a = mysqli_fetch_assoc($categories)){
					echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
				}
				logThis("The category '".$_POST["name"]."' was successfully updated by ".$_SESSION["peep"].".");
			}
			else if ($_POST["type"] == 3){ // delete
				if (mysqli_query($data_con, "DELETE FROM categories WHERE id='".$_POST["id"]."'")){
					logThis("The category '".$_POST["name"]."' was successfully deleted by ".$_SESSION["peep"].".");
					while ($a = mysqli_fetch_assoc($categories)){
						if ($a["id"] != $_POST["id"]){
							echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
						}
					}
				}
			}
			else if ($_POST["type"] == 4){ // new
				if (mysqli_query($data_con, "INSERT INTO categories (name, description, id) VALUES ('".$_POST["name"]."', '".$_POST["description"]."', '".time().rand(0,9)."')")){
					$categories = mysqli_query($data_con, "SELECT * FROM categories");
					while ($a = mysqli_fetch_assoc($categories)){
						echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
					}
					logThis("The new category '".$_POST["name"]."' was successfully created by ".$_SESSION["peep"].".");
				}
			}
			else { // all
				while ($a = mysqli_fetch_assoc($categories)){
					echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
				}
			}
		?>
	</body>
</html>