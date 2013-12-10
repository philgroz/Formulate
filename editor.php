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
			window.selectedCategory = 0;
			function getCurrentId(){
				return decodeURIComponent((new RegExp('[?|&]' + 'id' + '=' + '([^&;]+?)(&|#|;|$)').exec(location.search)||[,""])[1].replace(/\+/g, '%20'))||null;
			}
			function save(){
				var params = "top=" + document.getElementById('doc-top').innerHTML.replace(/\s+/g, ' ').replace(/\<br\>/g, "") + "&title=<title>" + document.getElementById('editor-title').value + "</title>&mid=" + document.getElementById('t-mid').value + "&bottom=" + document.getElementById('doc-bottom').innerHTML.replace(/\s+/g, ' ').replace(/\<br\>/g, "") + "&id=" + getCurrentId() + "&name=" + document.getElementById('editor-title').value + "&author=" + "<?php if (isset($_GET["id"]) == false){echo $_SESSION["peep"];} ?>" + "&category=" + document.getElementById('category-select').value;
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
			
			function deleteConfirm(id){
				if (confirm("Are you sure you want to delete this article?")){
					window.location = "delete.php?id=" + id;
				}
			}
			
			/*
			 * http://mosttw.wordpress.com/
			 *
			 * Licensed under MIT License: http://en.wikipedia.org/wiki/MIT_License
			 *
			 * Copyright (c) 2010 MostThingsWeb
			 */
			
			
			(function($){
			    $.countLines = function(textarea, o){
			    // The textarea
			    var ta;
			
			    if (typeof textarea == "string")
			        ta = $(textarea);
			    else if (typeof textarea == "object")
			        ta = textarea;
			
			    if (ta.size() != 1)
			        return;
			
			    // Get the textarea value
			    var value = ta.val();
			
			    var options = $.extend({
			        recalculateCharWidth : false,
			        chars : "",
			        charsMode : "random",
			        fontAttrs : ["font-family", "font-size", "text-decoration", "font-style", "font-weight"]
			    }, o);
			    var masterCharacters = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
			    var counter;
			    switch (options.charsMode){
			        case "random":
			        // Build a random collection of characters
			        options.chars = "";
			        masterCharacters += ".,?!-+;:'\"";
			        for (counter = 1; counter <= 12; counter++)
			            options.chars += masterCharacters[(Math.floor(Math.random() * masterCharacters.length))];
			        break;
			        case "alpha":
			        options.chars = masterCharacters;
			        break;
			        case "alpha_extended":
			        options.chars = masterCharacters + ".,?!-+;:'\"";
			        break;
			        case "from_ta":
			        // Build a random collection of characters from the textarea
			        if (value.length < 15)
			            options.chars = masterCharacters;
			        else
			            for (counter = 1; counter <= 15; counter++)
			            options.chars += value[(Math.floor(Math.random() * value.length))];
			        break;
			           case "custom":
			                // Already defined in options.chars
			                break;
			    }
			
			    // Decode chars
			    if (!$.isArray(options.chars))
			        options.chars = options.chars.split("");
			
			    // Generate a span after the textarea with a random ID
			    var id = "";
			    for (counter = 1; counter <= 10; counter++)
			        id += (Math.floor(Math.random() * 10) + 1);
			
			    ta.after("<span id='s" + id + "'></span>");
			    var span = $("#s" + id);
			
			    // Hide the span
			    span.hide();
			
			    // Apply the font properties of the textarea to the span class
			    $.each(options.fontAttrs, function(i, v){
			        span.css(v, ta.css(v));
			    });
			
			    // Get the number of lines
			    var lines = value.split("\n");
			    var linesLen = lines.length;
			
			    var averageWidth;
			
			    // Check if the textarea has a cached version of the average character width
			    if (options.recalculateCharWidth || ta.data("average_char") == null) {
			        // Get a pretty good estimation of the width of a character in the textarea. To get a better average, add more characters and symbols to this list
			        var chars = options.chars;
			
			        var charLen = chars.length;
			        var totalWidth = 0;
			
			        $.each(chars, function(i, v){
			        span.text(v);
			        totalWidth += span.width();
			        });
			
			        // Store average width on textarea
			        ta.data("average_char", Math.ceil(totalWidth / charLen));
			    }
			
			    averageWidth = ta.data("average_char");
			
			    // We are done with the span, so kill it
			    span.remove();
			
			    // Determine missing width (from padding, margins, borders, etc); this is what we will add to each line width
			    var missingWidth = (ta.outerWidth() - ta.width()) * 2;
			
			    // Calculate the number of lines that occupy more than one line
			    var lineWidth;
			
			    var wrappingLines = 0;
			    var wrappingCount = 0;
			    var blankLines = 0;
			
			    $.each(lines, function(i, v){
			        // Calculate width of line
			        lineWidth = ((v.length + 1) * averageWidth) + missingWidth;
			        // Check if the line is wrapped
			        if (lineWidth >= ta.outerWidth()){
			        // Calculate number of times the line wraps
			        var wrapCount = Math.floor(lineWidth / ta.outerWidth());
			        wrappingCount += wrapCount;
			        wrappingLines++;
			        }
			
			        if ($.trim(value) == "")
			        blankLines++;
			    });
			
			    var ret = {};
			    ret["actual"] = linesLen;
			    ret["wrapped"] = wrappingLines;
			    ret["wraps"] = wrappingCount;
			    ret["visual"] = linesLen + wrappingCount;
			    ret["blank"] = blankLines;
			
			    return ret;
			    };
			})(jQuery);
			
			
			function ajustLines(){
			    var r = $.countLines("#t-mid");
			    if (r.visual > 20){
				    document.getElementById("t-mid").rows = r.visual;
			    }
			    else {
				    document.getElementById('t-mid').rows = 20;
			    }
				 
			    /* text += "Number of actual lines: " + r.actual + "<br/>";
			    * text += "Number of lines that wrap: " + r.wrapped + "<br/>";
			    * text += "Number of wraps total: " + r.wraps + "<br/>";
			    * text += "Number of blank lines: " + r.blank + "<br/>";
			    * text += "Number of lines you should see: " + r.visual; */
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
							<a href="index.php" class="button icon remove">Cancel</a>
						</div>
					</td>
					<td id="status">
						<span class="icon">b</span>
					</td>
					<td>
						<div class="button-group">
							<a href="editor.php" class="button icon add">New</a>
							<a href="open.php" class="button icon edit">Open</a>
						<!-- <a href="https://github.com/GRAPHITE-GITHUB/FormulaeView/wiki/FormulaeView-XML-Syntax" target="_blank" class="button icon log">View Reference</a> -->
						<?php
							if (isset($_GET["opt"])){
								if ($_GET['opt'] == "preview"){
									$optButton = "";
									if (isset($_GET["id"])){
										$optButton = "&id=".$_GET["id"];
									}
									echo '<a href="editor.php?opt=edit'.$optButton.'" class="button icon edit">Edit</a>';
								}
								
							}
							else {
								$optButton = "";
								if (isset($_GET["id"])){
									$optButton = "&id=".$_GET["id"];
								}
								echo '<a href="editor.php?opt=preview'.$optButton.'" class="button icon favorite">Preview</a>';
							}
						?>
						</div>	
					</td>
				</tr>
			</table>
		</section>
		<section>
			<select class="" id="category-select" onchange="if (this.value == 'Manage Categories') {if (confirm('Are you sure you want to leave the page?')){window.location = 'categories.php'} else {this.selectedIndex = selectedCategory}}; selectedCategory = this.selectedIndex;">
				<optgroup label="Categories">
				<?php 
					$categories = mysqli_query($data_con, "SELECT name FROM categories");
					while ($a = mysqli_fetch_assoc($categories)){
						echo "<option>".$a['name']."</option>";
					}
				?>
				</optgroup>
				<option>Manage Categories</option>
			</select>
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
						<textarea id="t-mid" onkeyup="ajustLines();" rows="20" placeholder="write here using the FormulaeView XML Syntax" class="editor"><?php if (isset($_GET['id'])){echo htmlspecialchars($data['mid']);} ?></textarea><br/>
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
					echo '<button class="button icon trash danger" onclick="deleteConfirm('.$_GET["id"].');">Delete this Article</button>';
				}
			?>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>