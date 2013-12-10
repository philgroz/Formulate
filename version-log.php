<?php
	session_start();
?>

<html>
	<head>
		<?php
			include "formulate.php";
			include "head.php";
		?>
		<title>Formulate | Version Log</title>
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
						url: "version-engine.php",
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
		<section>
			<h2>Formulate</h2>
			<p>Formulate is a content management system for Formulae which utilises the power of the FormulaeView framework to create, read, edit, manage and deploy Formulae content. Below you can find the version log, showing entries for each new update to the system.</p>
			<p>Enjoy!</p>
			<p>Philipp Grozinger<br/>Formulate Developer</p>
		</section>
		<section>
			<div class="noticeBoardControls">
				<table>
					<tr>
						<td class="noticeBoardt">
							<h3>Version Log</h3>
						</td>
						<td class="noticeBoardc nopadding">
							<div class="button-group">
								<button class='button icon add' onClick="noticeRequest('1', 'new', '', '0');">New Version</button>
								<button class='button icon reload' onClick="noticeRequest('0', '');">Refresh</button>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="noticeboard">
			</div>
		</section>
		<footer>
		<?php
			include "footer.php";
		?>
		</footer>
	</body>
</html>