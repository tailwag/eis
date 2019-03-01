<html>
<head>
<title>~Essex Image Server~</title>
<style>
	@import 'https://fonts.googleapis.com/css?family=Oswald';
	body {
		background-color: #333333;
		font-family: 'Oswald', sans-serif;
	}
	div.list {
		margin-left: 30px;
		margin-right: auto;
	}
	h1,b,p {
		color: #EEEEEE;
	}
	a {
		color: #FFFFFF;
		text-decoration: none;
	}
	a:hover {
		text-decoration: underline;
	}
	img.folder {
		height: 22px;
		margin: 0px;
	}
	img.logo {
		max-width: 400px;
	}
	table#tree {
		position: absolute;
		left: 0px;
		width: 300px;
		border-top: 1px solid #BBBBBB;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 20px;
		padding-bottom: 20px;
	}
	table#pics {
		position: absolute;
		left: 300px;
		border-top: 1px solid #BBBBBB;
		max-width: 80%;
		padding-left: 20px;
		padding-right: 20px;
		padding-top: 20px;
		padding-bottom: 20px;
		border-collapse: separate; 
		border-spacing: 8px 8px;

	}
	img.thumb {
		max-width: 200px;
		max-height: 200px;
	}
	td.thumb {
		height: 200px;
		width: 280px;
		padding: 5px;
		background-color: #444444;
		text-align: center;
		vertical-align: middle;
	}
</style>
</head>
<body>
<h1>pr0n.fag.dog</h1>
<br>
<?php
function dget($dgdir = "null") {
	$coa = explode("/", $dgdir);
	array_shift($coa);
	$earray = explode("/", $dgdir);
	$result = end($earray)."\n";
	echo "<tr><td>|\n";
	foreach($coa as $dash) {
		echo "--";
	}		
	echo "<img class=\"folder\" src=\".folder.png\">\n";
	echo "<a href=\"index.php?dir=./".$dgdir."\">";
	echo $result."</a>\n</td></tr>\n";
	$dfil = scandir($dgdir);
	foreach($dfil as $sfil) {
		if (is_dir($dgdir."/".$sfil) && $sfil != ".." && $sfil != ".") {
			dget($dgdir."/".$sfil);
		}
	}

}
// Sets sirectory
if (isset($_GET['dir'])) {
	$travcheck = explode("/", $_GET['dir']);
	if ($travcheck[0] == "..") { $dir = "./"; }
	else { $dir = $_GET['dir']; }
}
else {
	$dir = '.';
}
// Echoes current working directory
if ($dir != '.') {
	$diray = explode('/', $dir);
	$slashcount = -1;
	foreach ($diray as $useless) {
		++$slashcount;
	}
	$namd = $diray[$slashcount];
	if ($namd == "r") { echo "<b>reactions</b><br><br>\n"; }
	else if ($namd == "s") { echo "<b>screenshots</b><br><br>\n"; }
	else { echo "<b>".$namd."</b>\n"; echo "<br><br>\n"; }
}
// Retrieves full list of files
// this is for the directory tree on the left 
// always scans from root dir, doesn't change with directory
$flist = scandir("."); 
echo "<table id=\"tree\">\n"; 
echo "<tr><td><img class=\"folder\" src=\".folder.png\">\n";
echo "<a href=\"index.php\">[home]</a></td></tr>\n";
foreach ($flist as $pfile) {
	if (is_dir($pfile) && substr($pfile, 0, 1) != ".") {
		dget($pfile);
	}
}
// Retrieves full listing of files for pictures 
// creates tables with picture previews 
// uses ?dir=[x] 
$ilist = scandir($dir);
$count = 1;
echo "<table id=\"pics\">\n";
foreach ($ilist as $image) {
	
$tarray = explode("_", $image);
$rarray = array_reverse($tarray);
$parray = array_pop($rarray);

$boom = explode(".", $image);
if (substr($image, 0, 1) != "." && substr($image, 0, 2) != "40" && substr($image, -3) != "php" 
	&& count($boom) >= 2 && $parray != "thumb") {
	if ($count == 0) { echo "<tr>\n"; }
	echo "<td class=\"thumb\">\n";
	echo "<a href=\"viewer.php?url=".$dir."/".$image."\">\n";
	
	if (file_exists($dir."/thumb_".$image)) {
		echo "<img class=\"thumb\" src=\"".$dir."/thumb_".$image."\"></a>\n";
		echo "<br><a href=\"".$dir."/".$image."\">".$image."</a>\n";
	}
	else {
		echo "<img class=\"thumb\" src=\"".$dir."/".$image."\"></a>\n";	
		echo "<br><a href=\"".$dir."/".$image."\">".$image."</a><b>(*)</b>\n";
	}
	echo "</td>\n";
	if ($count == 5) { echo "</tr>\n"; $count = 1; }
	else { ++$count; }
}
}
echo "</table>";
?>
</body>
</html>
