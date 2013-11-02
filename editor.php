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
			$data_con = mysqli_connect("localhost", 'root', 'root', 'formulae');
			$data = array("title","top","mid","bottom");
			function openWithId($id){
				global $data, $data_con;
				$data = mysqli_fetch_assoc(mysqli_query($data_con, "SELECT * FROM formulae WHERE id='".$id."'"));
			}
			if (isset($_GET["id"])){
				 openWithId($_GET["id"]);
			}
		?>
		<title>Editor | Formulate</title>
		<script type="text/javascript">
			function getCurrentId(){
				return decodeURIComponent((new RegExp('[?|&]' + 'id' + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
			}
			function save(){
				var params = "top=" + document.getElementById('doc-top').innerHTML.replace(/\s+/g, ' ').replace(/\<br\>/g, "") + "&title=<title>" + document.getElementById('editor-title').value + "</title>&mid=" + document.getElementById('t-mid').value + "&bottom=" + document.getElementById('doc-bottom').innerHTML.replace(/\s+/g, ' ').replace(/\<br\>/g, "") + "&id=" + getCurrentId() + "&name=" + document.getElementById('editor-title').value + "&author=" + "<?php if (isset($_GET["id"]) == false){echo $_SESSION["peep"];} ?>";
				var request = $.ajax({
					url: "save.php",
					data: params.replace(/\&lt;/g, '<').replace(/\&gt;/g, '>').replace("  ", " ").replace("> ", ">").replace(" <", "<"),
					dataType: 'html',
					type: "POST"
				});
				request.done(function(result){
					msg(result);
				});
			}
			function title(){
				document.getElementById("editor-title").value = document.getElementById("editor-title").value.replace("<title>", "").replace("</title>", "");
				document.getElementById("editor-title").style.opacity = "1";
			}
			function msg(msg){
				document.getElementById("status").innerHTML = "<span>" + msg + "</span>";
				if (getCurrentId() == null){
					window.location = "editor.php?id=" + document.getElementById('genID').innerHTML;
				}
				setTimeout(function(){
					document.getElementById("status").innerHTML = "<span class='icon'>b</span>";
				}, 2500)
			}
		</script>
	</head>
	<body style="margin-top:150px;" onload="$('textarea.editor').focus(); title();">
		<?php
			include "header.php";
		?>
		<section class="editor-controls">
			<table>
				<tr>
					<td>
						<div class="button-group">
							<a onclick="save();" class="button icon approve">Save</a>
						</div>
						<div class="button-group">
							<a href="editor.php" class="button icon add">New</a>
							<a href="open.php" class="button icon edit">Open</a>
						</div>
					</td>
					<td id="status">
						<span class="icon">b</span>
					</td>
					<td>
						<a href="https://github.com/GRAPHITE-GITHUB/FormulaeView/wiki/FormulaeView-XML-Syntax" target="_blank" class="button icon log">View Reference</a>
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
			<input placeholder="New Article" type="text" id="editor-title" class="editor-name" onkeyup='this.value = this.value.replace("<title>", "").replace("</title>", "");' value="<?php if (isset($_GET['id'])){echo $data["title"];} ?>" />
			<table class="table">
				<tr>
					<td>
						<div id="doc-top">
							<?php
								if (isset($_GET["id"]) == false){
									echo "&ltconcept&gt";
									echo "&ltauthor&gt".$_SESSION["peep"]."&lt/author&gt";
								}
								else {
									echo htmlspecialchars($data['top']);
								}
							?><br/>
						</div>
						<textarea id="t-mid" placeholder="write here using the FormulaeView XML Syntax" class="editor"><?php if (isset($_GET['id'])){echo htmlspecialchars($data['mid']);} ?></textarea><br/>
						<div id="doc-bottom">
							<?php
								if (isset($_GET["id"]) == false){
									echo "&lt/concept&gt";
								}
								else {
									echo htmlspecialchars($data['bottom']);
								}
							?>
						</div>
					</td>
				</tr>
			</table>
		</section>
		<section>
			<?php
				if (isset($_GET["id"])){
					echo '<a href="" class="button icon trash danger">Delete this Article</a>';
					mysqli_free_result($data);
				}
			?>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>