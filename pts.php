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
<?php
include("header.php");
?>
<div id="body">
<div class="table-wrap">
<table class="data">
<thead>
<tr><th>Package</th><th>Version</th><th>Full log</th><th>Supposed error message</th>
</tr>
</thead>
<tbody>
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
</tbody>
</table>
</div>
</div>
<?php
include("footer.php");
?>
</body>
</html>
<?php
}
?>
