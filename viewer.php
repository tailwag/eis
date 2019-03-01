<?php 
	if (isset($_GET['url'])) {
		$url = $_GET['url'];
	}
?>
<html>
<head>
<title>
<?php 
	if (isset($url)) { 
		echo $url;
	}
	else { echo "Image Viewer"; }
?>
</title>
<style>
body {
	text-align: center;
	background-color: #333333;
	margin: 0px;
	padding: 0px;
	height: auto;
}
h1, b, p {
	color: #EEEEEE;
}
video {
	max-width: 1280px;
}
div#back {
	position: absolute;
	top: 10px;
	right: 10px;
}
img#back {
	width: 35px;
}
div.nav {
	height: 100%;
	width: 5%;
}
div#prev {
	position: absolute;
	left: 0px;
	top: 250px;
}
div#next {
	position: absolute;
	right: 0px;
	top: 250px;
}
img.nav {
	height: 125px;
}
img.vd {
	max-width: 96%;
	max-height: 96%;
}
div#view {
	position: absolute;
	left: 0;
	right: 0;
	margin-left: auto;
	margin-right: auto;
	bottom: -200px;
}
img.bottom {
	max-height: 270px;
	max-width: 270px;
}
div#parent {
	height: 90%;
	width: 100%;
}
</style>
</head>
<body>
<br>
<?php 
	$ppath = explode("/", $url);
	$count = sizeof($ppath);
	$stop = $count - 1;
	$bing = 0;
	$path = "";
	foreach ($ppath as $val) {
		if ($bing < $stop) {
			$path = $path.$val."/";
			$bing++;
		}
		else {
			$file = $val;
		}
	}
	$boop = 0;
	#echo $boop;
	$filesw = scandir($path);
	$files=array();
	foreach ($filesw as $finder) {
		$tarray = explode("_", $finder);
		$rarray = array_reverse($tarray);
		$parray = array_pop($rarray);
		if ( $parray == "thumb" ) {
			continue;
		}
		else {
			$files[] = $finder;
		}
	}
	foreach ($files as $line) {
		if ($file == $line) {
			$thisp = $boop;
			$nextp = $boop + 1; 
			$prevp = $boop - 1;
			break;
		}
		else {
			$boop++; 
		}
	}
	$next = $files[$nextp];
	$prev = $files[$prevp];
	
	echo "<div id=\"parent\">\n";
	echo "<a id=\"main\" href=\"viewer.php?url=".$path.$next."\">\n";
	echo "<img class=\"vd\" src=\"".$path.$file."\"></a>";
	echo "</div>\n";

	echo "<div class=\"nav\" id=\"prev\">\n";
	echo "<a id=\"previmg\" href=\"viewer.php?url=".$path.$prev."\"><img class=\"nav\" src=\"./.prev.png\"></a></div>\n";
	echo "<div class=\"nav\" id=\"next\">\n";
	echo "<a id=\"nextimg\" href=\"viewer.php?url=".$path.$next."\"><img class=\"nav\" src=\"./.next.png\"></a></div>\n";
	echo "<div id=\"back\">\n";
	echo "<a id=\"exitimg\" href=\"index.php?dir=".$path."\"><img id=\"back\" src=\"./.close.png\"></a></div>\n";

	echo "<div id=\"view\">\n";

	if (--$prevp >= 2) {
		echo "<a href=\"viewer.php?url=".$path.$files[$prevp]."\">";
		echo "<img class=\"bottom\" src=\"".$path.$files[$prevp]."\"></a>\n";
	}
	if (++$prevp >= 2) {
		echo "<a href=\"viewer.php?url=".$path.$files[$prevp]."\">";
		echo "<img class=\"bottom\" src=\"".$path.$files[$prevp]."\"></a>\n";
	}
	echo "<a href=\"viewer.php?url=".$path.$file."\"><img class=\"bottom\" src=\"".$path.$file."\"></a>\n";
	if (($nextp + 1) <= count($files)) {
		echo "<a href=\"viewer.php?url=".$path.$files[$nextp]."\">";
		echo "<img class=\"bottom\" src=\"".$path.$files[$nextp]."\"></a>\n";
	}
	if ((++$nextp + 1) <= count($files)) {	
		echo "<a href=\"viewer.php?url=".$path.$files[$nextp]."\">";
		echo "<img class=\"bottom\" src=\"".$path.$files[$nextp]."\"></a>\n";
	}
	
	echo "</div>\n";
		
?>
<script>
document.onkeydown = checkKey;

function checkKey(e) {

    e = e || window.event;

    if (e.keyCode == '37' || e.keyCode == '65') {
       // left arrow / A
	document.getElementById("previmg").click();
    }
    else if (e.keyCode == '39' || e.keyCode == '68') {
       // right arrow / D
	document.getElementById("nextimg").click();
    }
    else if (e.keyCode == '27') {
       // esc
	document.getElementById("exitimg").click();
    }

}
</script>
</body>
</html>
