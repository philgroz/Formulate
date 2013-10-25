<?php
	session_start();
?>
<html>
<body>
	<?php
		date_default_timezone_set('Australia/Adelaide');
		$z = 0;
		$notices = array();
		function writeThis($write, $file, $method){
			$writeFile = fopen($file, $method);
			fwrite($writeFile, $write);
			fclose($writeFile);
		}
		function getComments($entry){
			$xml = simplexml_load_file("noticeboard/notices/".$entry.".xml");
			$c = "<comments>1</comments>";
			if ($xml->comments == "1"){
				foreach ($xml->comment as $comment){
					$c = $c."<comment><cid>".$comment->cid."</cid><person>".$comment->person."</person><ctext>".$comment->ctext."</ctext><ctime>".$comment->ctime."</ctime></comment>";
				}
			}
			return $c;
		}
		function getRemainingComments($entry, $cid){
			$xml = simplexml_load_file("noticeboard/notices/".$entry.".xml");
			$c = "<comments>1</comments>";
			if ($xml->comments == "1"){
				foreach ($xml->comment as $comment){
					if ($comment->cid != $cid){
						$c = $c."<comment><cid>".$comment->cid."</cid><person>".$comment->person."</person><ctext>".$comment->ctext."</ctext><ctime>".$comment->ctime."</ctime></comment>";
					}
				}
			}
			return $c;
		}
		function getNewComments($entry, $cid, $ctext){
			$xml = simplexml_load_file("noticeboard/notices/".$entry.".xml");
			$c = "<comments>1</comments>";
			if ($xml->comments == "1"){
				foreach ($xml->comment as $comment){
					if ($comment->cid == $cid){
						$c = $c."<comment><cid>".$comment->cid."</cid><person>".$comment->person."</person><ctext>".$ctext."</ctext><ctime>".date(DATE_RFC822)."</ctime></comment>";
					}
					else {
						$c = $c."<comment><cid>".$comment->cid."</cid><person>".$comment->person."</person><ctext>".$comment->ctext."</ctext><ctime>".$comment->ctime."</ctime></comment>";
					}
				}
			}
			return $c;
		}
		function generateCommentId($entry){
			$xml = simplexml_load_file("noticeboard/notices/".$entry.".xml");
			$y = 0;
			if ($xml->comments == "1"){
				foreach ($xml->comment as $comment){
					$y = $comment->cid;
					$y = $y + 1;
				}
			}
			return $y;
		}
		function countComments($entry){
			$xml = simplexml_load_file("noticeboard/notices/".$entry.".xml");
			$w = 0;
			if ($xml->comments == "1"){
				foreach ($xml->comment as $comment){
					$w = $w + 1;
				}
			}
			return $w;
		}
		function writeComments($xml){
			if ($xml->comments == "1"){
				global $z;
				$s = 0;
				if (sizeof($xml->comment) > 2 && $_POST['ccol'] == "1" && $_POST['save'] == $xml->nin){
					echo "<section class='comment showMore'><p onClick='noticeRequest(".'"0", '.'"'.$xml->nin.'", '.'"", '.'"0"'.")'>collapse comments</p></section>";
				}
				else if (sizeof($xml->comment) > 2){
					echo "<section class='comment showMore'><p onClick='noticeRequest(".'"0", '.'"'.$xml->nin.'", '.'"", '.'"1"'.")'>show all comments (".sizeof($xml->comment).")</p></section>";
				}
				foreach ($xml->comment as $comment){
					if ($_POST['ccol'] == "1" && $_POST['save'] == $xml->nin){
						if ($comment->person == $_SESSION['peep']){
							$delete = " - <a onClick='noticeRequest(".'"4", '.'"'.$xml->nin.'", '.'"'.$comment->cid.'"'.")'>edit</a> - <a onClick='sureDeleteComment(".'"'.$z."cc".$s.'", '.'"'.$comment->cid.'", '.'"'.$xml->nin.'"'.")'>delete</a>";
						}
						else {
							$delete = "";
						}
						echo "<section id='".$z."cc".$s."' class='comment' onmouseover='".'commentShowDelete("'.$z."c".$s.'")'."' onmouseout='".'commentHideDelete("'.$z."c".$s.'")'."'><h5>".$comment.$comment->person."<span class='light dnone' id='".$z."c".$s."'> - ".$comment->ctime.$delete."</span></h5>";
						echo "<p>".$comment->ctext."</p></section>";
					}
					else if ($s > sizeof($xml->comment) - 3){
						if ($comment->person == $_SESSION['peep']){
							$delete = " - <a onClick='noticeRequest(".'"4", '.'"'.$xml->nin.'", '.'"'.$comment->cid.'"'.")'>edit</a> - <a onClick='sureDeleteComment(".'"'.$z."cc".$s.'", '.'"'.$comment->cid.'", '.'"'.$xml->nin.'"'.")'>delete</a>";
						}
						else {
							$delete = "";
						}
						echo "<section id='".$z."cc".$s."' class='comment' onmouseover='".'commentShowDelete("'.$z."c".$s.'")'."' onmouseout='".'commentHideDelete("'.$z."c".$s.'")'."'><h5>".$comment.$comment->person."<span class='light dnone' id='".$z."c".$s."'> - ".$comment->ctime.$delete."</span></h5>";
						echo "<p>".$comment->ctext."</p></section>";
					}
					$s++;
				}
			}
		}
		function writeNotices(){
			if ($handle = opendir('./noticeboard/notices')) {
	    		while (false !== ($entry = readdir($handle))){
	    		    if ($entry != "." && $entry != ".." && $entry != ".htaccess"){
	    		    	$xml = simplexml_load_file("noticeboard/notices/".$entry);
	    		    	$time = $xml->time;
						$nin = $xml->nin.".xml";
						$notices["$time"] = $nin;
	    			}
	    		}
	    		closedir($handle);
	    		krsort($notices);
	    		foreach ($notices as $entry){
	    			$xml = simplexml_load_file("noticeboard/notices/".$entry);
					echo "<tr><td class='notice' id='".$xml->nin."'>";
					echo "<table><tr><td class='noticeHeaders'>";
					echo "<h4>".$xml->title."</h4>";
					echo "<h5>".$xml->author."<span class='light'> - ".$xml->dtime."</span></h5></td>";
					echo "<td class='noticeEditDelete'>";
					if ($xml->author == $_SESSION['peep']){
						echo "<p><a onClick='".'noticeRequest("1", "'.$xml->nin.'")'."'>edit</a>"." - "."<a onClick='sureDeleteNotice(".$xml->nin.")'>delete</a></p>";
					}
					echo "</td><td><button class='commentButton button' onClick='".'noticeRequest("4", "'.$xml->nin.'")'."'>Comment</button></td></tr></table>";
					echo "<p>".$xml->text."</p>";
					writeComments($xml);
					global $z;
					$z++;
					echo "</td></tr>";
				}
	    	}
		}
		echo "<table>";
		if ($_POST['action'] == "0"){
			writeNotices();
		}
		else if ($_POST['action'] == "1"){
			if ($_POST['save'] == "new"){
				echo "<tr><td class='notice' id='new'>";
				echo '<p>Title</p>';
				echo '<input name="title" id="title" class="textField newNotice" type="text" />';
				echo '<p>Message</p>';
				echo '<textarea name="text" id="text" class="textField paragraph newNotice" wrap="virtual" rows="5"></textarea>';
				echo "<div><button class='button' onClick='".'noticeRequest("2", "'.$_POST['save'].'")'."'>Save</button><button class='button' onClick='".'noticeRequest("0", "")'."'>Cancel</button></div>";
				echo "</td></tr>";
			}
			if ($handle = opendir('./noticeboard/notices')) {
	    		while (false !== ($entry = readdir($handle))) {
	    		    if ($entry != "." && $entry != ".." && $entry != ".htaccess") {
	    		    	$xml = simplexml_load_file("noticeboard/notices/".$entry);			
						if ($entry != "." && $entry != ".." && $entry != ".htaccess"){
							$xml = simplexml_load_file("noticeboard/notices/".$entry);
	    		   			$time = $xml->time;
							$nin = $xml->nin.".xml";
							$notices["$time"] = $nin;
	    				}
	    			}
	    		}
	    		closedir($handle);
	    		krsort($notices);
	    		foreach ($notices as $entry){
	    			$xml = simplexml_load_file("noticeboard/notices/".$entry);
	    			if ($_POST['save'] == $xml->nin){
						echo "<tr><td class='notice' id='".$xml->nin."'>";
						echo '<p>Title</p>';
						echo '<input name="title" value="'.$xml->title.'" id="title" class="textField newNotice" type="text" />';
						echo '<p>Message</p>';
						echo '<textarea name="text" id="text" class="textField paragraph newNotice" wrap="virtual" rows="5">'.$xml->text.'</textarea>';
						echo "<div><button class='button' onClick='".'noticeRequest("2", "'.$_POST['save'].'")'."'>Save</button><button class='button' onClick='".'noticeRequest("0", "")'."'>Cancel</button></div>";
						echo "</td></tr>";
					}
					else {
						echo "<tr><td class='notice' id='".$xml->nin."'>";
						echo "<table><tr><td class='noticeHeaders'>";
						echo "<h4>".$xml->title."</h4>";
						echo "<h5>".$xml->author."<span class='light'> - ".$xml->dtime."</span></h5></td>";
						echo "<td class='noticeEditDelete'>";
						if ($xml->author == $_SESSION['peep']){
							echo "<p><a onClick='".'noticeRequest("1", "'.$xml->nin.'")'."'>edit</a>"." - "."<a onClick='sureDeleteNotice(".$xml->nin.")'>delete</a></p>";
						}
						echo "</td><td><button class='commentButton button' onClick='".'noticeRequest("4", "'.$xml->nin.'")'."'>Comment</button></td></tr></table>";
						echo "<p>".$xml->text."</p>";
						writeComments($xml);
						$z++;
					}
					echo "</td></tr>";
				}
			}
		}
		else if ($_POST['action'] == "2"){
			if ($_POST['save'] == "new"){
				include('noticeboard/currentNIN.php');
				$noticeXML = '<?xml version="1.0" encoding="utf-8"?><notice><author>'.$_SESSION["peep"].'</author><title>'.$_POST["title"].'</title><text>'.$_POST["text"].'</text><dtime>'.date(DATE_RFC822).'</dtime><time>'.time().'</time><nin>'.$NIN.'</nin><comments>0</comments></notice>';
				writeThis($noticeXML, "noticeboard/notices/".$NIN.".xml", "w");
				$newNIN = $NIN + 1;
				$ninXML = "<html><body><?php ".'$NIN = '.$newNIN."; ?></body></html>";
				writeThis($ninXML, "noticeboard/currentNIN.php", "w");
			}
			else if ($_POST['save'] != ""){
				$xml = simplexml_load_file("noticeboard/notices/".$_POST['save'].".xml");
				$noticeXML = '<?xml version="1.0" encoding="utf-8"?><notice><author>'.$xml->author.'</author><title>'.$_POST["title"].'</title><text>'.$_POST["text"].'</text><dtime>'.date(DATE_RFC822).'</dtime><time>'.time().'</time><nin>'.$_POST['save'].'</nin>'.getComments($_POST['save']).'</notice>';
				writeThis($noticeXML, "noticeboard/notices/".$_POST['save'].".xml", "w");
			}
			writeNotices();
		}
		else if ($_POST['action'] == "3"){
			unlink("noticeboard/notices/".$_POST['save'].".xml");
			writeNotices();
		}
		else if ($_POST['action'] == "4"){
			if ($handle = opendir('./noticeboard/notices')) {
	    		while (false !== ($entry = readdir($handle))) {
	    		    if ($entry != "." && $entry != ".." && $entry != ".htaccess") {
	    		    	$xml = simplexml_load_file("noticeboard/notices/".$entry);			
						if ($entry != "." && $entry != ".." && $entry != ".htaccess"){
							$xml = simplexml_load_file("noticeboard/notices/".$entry);
	    		   			$time = $xml->time;
							$nin = $xml->nin.".xml";
							$notices["$time"] = $nin;
	    				}
	    			}
	    		}
	    		closedir($handle);
	    		krsort($notices);
	    		foreach ($notices as $entry){
	    			$xml = simplexml_load_file("noticeboard/notices/".$entry);
					echo "<tr><td class='notice' id='".$xml->nin."'>";
					echo "<table><tr><td class='noticeHeaders'>";
					echo "<h4>".$xml->title."</h4>";
					echo "<h5>".$xml->author."<span class='light'> - ".$xml->dtime."</span></h5></td>";
					echo "<td class='noticeEditDelete'>";
					if ($xml->author == $_SESSION['peep']){
						echo "<p><a onClick='".'noticeRequest("1", "'.$xml->nin.'")'."'>edit</a>"." - "."<a onClick='sureDeleteNotice(".$xml->nin.")'>delete</a></p>";
					}
					echo "</td><td><button class='commentButton button' onClick='".'noticeRequest("4", "'.$xml->nin.'")'."'>Comment</button></td></tr></table>";
					echo "<p>".$xml->text."</p>";
					$x = "0";
					if ($xml->comments == "1"){
						$s = 0;
						if (sizeof($xml->comment) > 2 && $_POST['ccol'] == "1" && $_POST['save'] == $xml->nin){
							echo "<section class='comment showMore'><p onClick='noticeRequest(".'"0", '.'"'.$xml->nin.'", '.'"", '.'"0"'.")'>collapse comments</p></section>";
						}
						else if (sizeof($xml->comment) > 2){
							echo "<section class='comment showMore'><p onClick='noticeRequest(".'"0", '.'"'.$xml->nin.'", '.'"", '.'"1"'.")'>show all comments (".sizeof($xml->comment).")</p></section>";
						}
						foreach ($xml->comment as $comment){
							if ($comment->cid == $_POST['cid'] && $xml->nin == $_POST['save']){
								echo "<section id='".$z."cc".$s."'>";
								echo '<textarea name="ctext" id="ctext" class="textField paragraph newNotice" wrap="virtual" rows="3">'.$comment->ctext.'</textarea>';
								echo "<div><button class='button' onClick='".'noticeRequest("7", "'.$_POST['save'].'", "'.$_POST['cid'].'")'."'>Save</button><button class='button' onClick='".'noticeRequest("0", "")'."'>Cancel</button></div>";
								echo "</section>";
								$x = "1";
							}
							else {
								if ($_POST['ccol'] == "1" && $_POST['save'] == $xml->nin){
									if ($comment->person == $_SESSION['peep']){
										$delete = " - <a onClick='noticeRequest(".'"4", '.'"'.$xml->nin.'", '.'"'.$comment->cid.'"'.")'>edit</a> - <a onClick='sureDeleteComment(".'"'.$z."cc".$s.'", '.'"'.$comment->cid.'", '.'"'.$xml->nin.'"'.")'>delete</a>";
									}
									else {
										$delete = "";
									}
									echo "<section id='".$z."cc".$s."' class='comment' onmouseover='".'commentShowDelete("'.$z."c".$s.'")'."' onmouseout='".'commentHideDelete("'.$z."c".$s.'")'."'><h5>".$comment.$comment->person."<span class='light dnone' id='".$z."c".$s."'> - ".$comment->ctime.$delete."</span></h5>";
									echo "<p>".$comment->ctext."</p></section>";
								}
								else if ($s > sizeof($xml->comment) - 3){
									if ($comment->person == $_SESSION['peep']){
										$delete = " - <a onClick='noticeRequest(".'"4", '.'"'.$xml->nin.'", '.'"'.$comment->cid.'"'.")'>edit</a> - <a onClick='sureDeleteComment(".'"'.$z."cc".$s.'", '.'"'.$comment->cid.'", '.'"'.$xml->nin.'"'.")'>delete</a>";
									}
									else {
										$delete = "";
									}
									echo "<section id='".$z."cc".$s."' class='comment' onmouseover='".'commentShowDelete("'.$z."c".$s.'")'."' onmouseout='".'commentHideDelete("'.$z."c".$s.'")'."'><h5>".$comment.$comment->person."<span class='light dnone' id='".$z."c".$s."'> - ".$comment->ctime.$delete."</span></h5>";
									echo "<p>".$comment->ctext."</p></section>";
								}
							}
							$s++;
						}
					}
					$z++;
					if ($_POST['save'] == $xml->nin && $x == "0"){
						echo '<p>Post Comment</p>';
						echo '<textarea name="ctext" id="ctext" class="textField paragraph newNotice" wrap="virtual" rows="3"></textarea>';
						echo "<div><button class='button' onClick='".'noticeRequest("5", "'.$_POST['save'].'")'."'>Save</button><button onClick='".'noticeRequest("0", "")'."'>Cancel</button></div>";
					}
					echo "</td></tr>";
				}
			}
		}
		else if ($_POST['action'] == "5"){
			$xml = simplexml_load_file("noticeboard/notices/".$_POST['save'].".xml");
			$noticeXML = '<?xml version="1.0" encoding="utf-8"?><notice><author>'.$xml->author.'</author><title>'.$xml->title.'</title><text>'.$xml->text.'</text><dtime>'.$xml->dtime.'</dtime><time>'.$xml->time.'</time><nin>'.$_POST['save'].'</nin>'.getComments($_POST['save']).'<comment><cid>'.generateCommentId($_POST['save']).'</cid><person>'.$_SESSION['peep'].'</person><ctext>'.$_POST['ctext'].'</ctext><ctime>'.date(DATE_RFC822).'</ctime></comment></notice>';
			writeThis($noticeXML, "noticeboard/notices/".$_POST['save'].".xml", "w");
			writeNotices();
		}
		else if ($_POST['action'] == "6"){
			$xml = simplexml_load_file("noticeboard/notices/".$_POST['save'].".xml");
			$noticeXML = '<?xml version="1.0" encoding="utf-8"?><notice><author>'.$xml->author.'</author><title>'.$xml->title.'</title><text>'.$xml->text.'</text><dtime>'.$xml->dtime.'</dtime><time>'.$xml->time.'</time><nin>'.$_POST['save'].'</nin>'.getRemainingComments($_POST['save'], $_POST['cid']).'</notice>';
			writeThis($noticeXML, "noticeboard/notices/".$_POST['save'].".xml", "w");
			writeNotices();
		}
		else if ($_POST['action'] == "7"){
			$xml = simplexml_load_file("noticeboard/notices/".$_POST['save'].".xml");
			$noticeXML = '<?xml version="1.0" encoding="utf-8"?><notice><author>'.$xml->author.'</author><title>'.$xml->title.'</title><text>'.$xml->text.'</text><dtime>'.$xml->dtime.'</dtime><time>'.$xml->time.'</time><nin>'.$_POST['save'].'</nin>'.getNewComments($_POST['save'], $_POST['cid'], $_POST['ctext']).'</notice>';
			writeThis($noticeXML, "noticeboard/notices/".$_POST['save'].".xml", "w");
			writeNotices();
		}
		echo "</table>";
	?>
</body>
</html>