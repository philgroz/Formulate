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
		<title>Editor | Formulate</title>
	</head>
	<body style="margin-top:150px;" onload="$('textarea.editor').focus();">
		<?php
			include "header.php";
		?>
		<section class="editor-controls">
			<table>
				<tr>
					<td>
						<a href="save.php" class="button icon approve">Save</a>
						<a href="https://github.com/GRAPHITE-GITHUB/FormulaeView/wiki/FormulaeView-XML-Syntax" target="_blank" class="button icon log">View Reference</a>
					</td>
					<td>
						<span class="icon">b</span>
					</td>
					<td>
						<?php
							if ($_GET['opt'] == "preview"){
								$optButton = "";
								if (isset($_GET["id"])){
									$optButton = "&id=".$_GET["id"];
								}
								echo '<a href="editor.php?opt=edit'.$optButton.'" class="button icon edit">Edit</a>';
							}
							else {
								$optButton = "";
								if (isset($_GET["id"])){
									$optButton = "&id=".$_GET["id"];
								}
								echo '<a href="editor.php?opt=preview'.$optButton.'" class="button icon favorite">Preview</a>';
							}
						?>
					</td>
				</tr>
			</table>
		</section>
		<section>
			<input placeholder="New Article" type="text" class="editor-name" />
			<table class="table">
				<tr>
					<td>
						&ltconcept&gt<br/>
						&ltauthor&gt<?php echo $_SESSION["peep"]; ?>&lt/author&gt<br/>
						<textarea placeholder="write here using the FormulaeView XML Syntax" class="editor"></textarea><br/>
						&lt/concept&gt
					</td>
				</tr>
			</table>
		</section>
		<section>
			<?php
				if (isset($_GET["id"])){
					echo '<a href="" class="button icon trash danger">Delete this Article</a>';
				}
			?>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>