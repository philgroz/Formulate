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
		<title>Formulate | Dashboard</title>
		<script type="text/javascript">
				function noticeRequest(action, save, cid, ccol){
					var http = new XMLHttpRequest();
					if (action == "2"){
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol) + "&title=" + document.getElementById('title').value + "&text=" + document.getElementById('text').value;
					}
					else if (action == "4"){
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol) + "&cid=" + encodeURIComponent(cid);
					}
					else if (action == "5"){
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol) + "&ctext=" + document.getElementById('ctext').value;
					}
					else if (action == "6"){
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol) + "&cid=" + encodeURIComponent(cid);
					}
					else if (action == "7"){
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol) + "&cid=" + encodeURIComponent(cid) + "&ctext=" + document.getElementById('ctext').value;
					}
					else {
						var params = "action=" + encodeURIComponent(action) + "&save=" + encodeURIComponent(save) + "&ccol=" + encodeURIComponent(ccol);
					}
					var request = $.ajax({
						url: "noticeboard.php",
						data: params,
						dataType: 'html',
						type: "POST"
					});
					request.done(function(result){
						showNotices(result);
					});
				}
				function showNotices(content){
					document.getElementById('noticeboard').innerHTML = content;
				}
				function sureDeleteNotice(id){
					document.getElementById(id).innerHTML = "<p>Are you sure you want to delete this notice?</p><button class='button' onClick='noticeRequest(" + '"0", "")' + "'>Cancel</button><button class='button' onClick='noticeRequest(" + '"3", "' + id +'")' + "'>DELETE</button>";
				}
				function sureDeleteComment(id, cid, nin){
					document.getElementById(id).innerHTML = "<p>Are you sure you want to delete this comment?</p><button class='button' onClick='noticeRequest(" + '"0", "")' + "'>Cancel</button><button class='button' onClick='noticeRequest(" + '"6", "' + nin +'", "' + cid +'")' + "'>DELETE</button>";
				}
				function commentShowDelete(id){
					document.getElementById(id).style.display = "inline";
				}
				function commentHideDelete(id){
					document.getElementById(id).style.display = "none";
				}
		</script>
	</head>
	<body onload="noticeRequest('0', '')">
		<?php
			include "header.php";
		?>
		<section class="dash">
			<h2>Dashboard</h2>
			<a href="editor.php" class="button icon add">New Article</a>
			<a href="open.php" class="button icon edit">Open Article</a>
		</section>
		<section>
			<div class="noticeBoardControls">
				<table>
					<tr>
						<td class="noticeBoardt">
							<h3>Noticeboard</h3>
						</td>
						<td class="noticeBoardc nopadding">
							<button class='button icon add' onClick="noticeRequest('1', 'new', '', '0');">New Post</button>
							<button class='button icon reload' onClick="noticeRequest('0', '');">Refresh</button>
						</td>
					</tr>
				</table>
			</div>
			<div id="noticeboard">
			</div>
		</section>
		<?php
			include "footer.php";
		?>
	</body>
</html>