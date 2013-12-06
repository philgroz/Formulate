<?php
	date_default_timezone_set('Australia/Adelaide');
	// LOGIN
	if (isset($_SESSION["logged"])){
		if ($_SESSION["logged"]){
			// if there is already someone logged in, define the functions below
			function display($item, $opt){
				// this function takes an object with the properties of an uncompiled Formulate document
				$i = "<tr onclick='openfromid(".$item["id"].");'>";
				if ($opt){
					$i = $i."<td><span class='icon'>".generateIcon($item)."</span></td>";
				}
				$i = $i."<td><span class='search time'>".convertTime($item["id"])."</span><span class='search title'><h3>".$item['name']."</h3></span><span class='search category'>".$item['category']."</span><span class='search author'>".$item["author"]."</span>";
				return $i."</td></tr>";
			}
			function convertTime($n){
				// this function takes id strings and turns them into the time they were created
				$n = substr($n, 0, -1);
				return date("G:i jS M Y", $n);
			}
			function generateIcon($item){
				if ($item["category"] == "Documents"){
					return "d";
				}
				else {
					return "b";
				}
			}
		}
		else {
			echo "<script type='text/javascript'>window.location='signin.php';</script>";
			die();
		}
	}
	else {
		// if no one is logged in, redirect to the sign in page and terminate this script
		echo "<script type='text/javascript'>window.location='signin.php';</script>";
		die();
	}
?>
<html>
</html>