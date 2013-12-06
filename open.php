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
		<title>Open | Formulate</title>
	</head>
	<body onload='search("3", "", "sr");'>
		<?php
			include "header.php";
		?>
		<section>
			<h2>Open from Database</h2>
			<p>Find recent articles, browse through your own articles, search the database and apply various filters to find what you're looking for.</p>
		</section>
		<section>
			<table class="table search-options">
				<tr>
					<td>
						<div class="button-group search-options">
							<button onclick='search("3", "", "sr");' class="button big icon clock">Recent</button>
							<button onclick='search("2", "", "sr");' class="button big icon user">Authored</button>
							<button onclick='document.getElementById("search-field").value = "*"; search("1", "*" , "sr");' class="button big icon favorite">All</button>
						</div>
					</td>
					<td>
						<input onkeyup='search("1", this.value , "sr");' placeholder="Search Formulate" class="search" id="search-field" />
					</td>
				</tr>
			</table>
		</section>
		<section>
			<div id="sr"></div>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>