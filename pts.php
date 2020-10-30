<?php
include_once("config.inc.php");

$package = mysqli_real_escape_string($conn_db, isset($_GET['p']) ? htmlspecialchars($_GET['p']) : NULL);
$html_format = isset($_GET['format']) ? htmlspecialchars($_GET['format']) == "html" : false;

$req="SELECT * FROM errors WHERE clang_version='$currentVersion'";
if ($package) {
	$req.=" AND package='$package'";
}
$req.=" ORDER BY package";

$result=mysql_query($req);
if (!$result) {
	echo mysql_error();
}

$suffix="unstable_clang";
$ext="log";

if ($html_format) {
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
</head>
<body>
<h1 id="title">Debian Package rebuild</h1>
<h2 id="subtitle">Rebuild of the Debian archive with clang</h2>
<div id="body">
<table class="data">
<tr><th>Package</th><th>Version</th><th>Full log</th><th>Supposed error message</th>
</tr>
<?php
}
while ($row = mysql_fetch_object($result)) {
$dateLog=explode(" ",$row->date_build);

	if ($html_format) {
		echo "<tr><td>{$row->package}</td><td>{$row->version}</td>"
			."<td><a href=\"/logs/{$dateLog[0]}/{$row->package}_{$row->version}_{$suffix}.{$ext}\">Log</a></td>"
			."<td>".trim($row->detected_error)."</td></tr>";
	} else {
		echo "{$row->package} {$row->version} "
			."http://{$_SERVER['HTTP_HOST']}/logs/{$dateLog[0]}/{$row->package}_{$row->version}_{$suffix}.{$ext} ".trim($row->detected_error)."\n";
	}
}
if ($html_format) {
?>
</table>
</div>
</body>
</html>
<?php
}
?>
