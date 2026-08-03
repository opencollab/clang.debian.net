<?php
include_once("config.inc.php");
include_once("listErrors.php"); // for build_log_url()

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
$logURL=build_log_url($dateLog[0], $row->package, $row->version, $currentVersion);

	if ($html_format) {
		echo "<tr><td>{$row->package}</td><td>{$row->version}</td>"
			."<td>".($logURL ? "<a href=\"{$logURL}\">Log</a>" : "n/a")."</td>"
			."<td>".trim($row->detected_error)."</td></tr>";
	} else {
		echo "{$row->package} {$row->version} "
			.($logURL ? "https://{$_SERVER['HTTP_HOST']}{$logURL} " : "")
			.trim($row->detected_error)."\n";
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
