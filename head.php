<link rel="stylesheet/less" type="text/css" href="global.less" />		
<script src="frameworks/less.js" type="text/javascript"></script>
<script src="frameworks/jquery.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="frameworks/gh-buttons.css" />
<script src="frameworks/smoke.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="frameworks/smoke.css" />
<script type="text/javascript">
	function search(t, s, i){
		if (s == "" && t == 1){
			search("3", "", "sr");
		}
		else {
			var params = "type=" + t + "&s=" + s;
			var request = $.ajax({
				url: "search.php",
				data: params,
				dataType: 'html',
				type: "POST"
			});
			request.done(function(result){
				document.getElementById(i).innerHTML = result;
			});
		}
	}
	function openfromid(id){
		window.location = "editor.php?id=" + id;
	}
</script>