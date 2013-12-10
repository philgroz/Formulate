<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "formulate.php";
			include "head.php";
			$data_con = mysqli_connect("localhost", 'root', 'root', 'formulae');
		?>
		<title>Manage Categories | Formulate</title>
		<script type="text/javascript">
			function changeCategory(type, id){
				if (type == 2){
					var params = "id=" + id + "&type=" + type + "&name=" + document.getElementById("n-" + id).value + "&description=" + document.getElementById("d-" + id).value;
				}
				else if (type == 1 || type == 3) {
					var params = "id=" + id + "&type=" + type + "&name=" + document.getElementById("n-" + id).innerHTML + "&description=" + document.getElementById("d-" + id).innerHTML;					
				}
				else if (type == 4){
					var params = "type=" + type + "&name=" + document.getElementById("new-name").value + "&description=" + document.getElementById("new-description").value;
					cancelCategory();
				}
				else {
					var params = "type=" + type;
				}
				var request = $.ajax({
					url: "category-engine.php",
					data: params,
					dataType: 'html',
					type: "POST"
				});
				request.done(function(result){
					document.getElementById("categories-result").innerHTML = result;
				});
			}
			function newCategory(){
				document.getElementById("new-category").style.display = "block";
				document.getElementById("button-new").style.display = "none";
			}
			function cancelCategory(){
				document.getElementById("new-category").style.display = "none";
				document.getElementById("button-new").style.display = "block";
				document.getElementById("new-name").value = "";
				document.getElementById("new-description").value = "";
			}
		</script>
	</head>
	<body>
		<?php
			include "header.php";
		?>
		<section>
			<h2>Manage Categories</h2>
			<p>Below is all the information and options associated with the categories.</p>
			<button id="button-new" onclick="newCategory()" class="button icon add">New Category</button>
			<div style="display:none;" id="new-category">
				<table class="table categories">
					<tr><td><input placeholder="Name" id="new-name" type="text"></td><td><input placeholder="Description" id="new-description" type="text"></td><td><div class="button-group"><button class="button icon approve" onclick="changeCategory(4)">Save</button><button class="button icon remove" onclick="cancelCategory()">Cancel</button></div></td></tr>
				</table>
			</div>
		</section>
		<section>
			<table class="table categories" id="categories-result">
				<?php 
					$categories = mysqli_query($data_con, "SELECT * FROM categories");
					while ($a = mysqli_fetch_assoc($categories)){
						echo "<tr><td id='n-".$a["id"]."'>".$a['name']."</td><td id='d-".$a["id"]."'>".$a['description']."</td><td><div class='button-group'><button class='button icon edit' onclick='changeCategory(1, ".$a["id"].")'>Edit</button><button onclick='if (confirm(".'"Are you sure you want to delete this?"'.")) {changeCategory(3, ".$a["id"].");}' class='button icon danger trash'>Delete</button></div></td></tr>";
					}
				?>
			</table>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>