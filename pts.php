<?
include_once("config.inc.php");

$req="SELECT * FROM errors WHERE clang_version='$currentVersion'";
$result=mysql_query($req);

$suffix="unstable_clang";
$ext="log";

while ($row = mysql_fetch_object($result)) {
$dateLog=explode(" ",$row->date_build);

     echo "{$row->package} {$row->version} http://clang.debian.net/logs/{$dateLog[0]}/{$row->package}_{$row->version}_{$suffix}.{$ext} ".trim($row->detected_error)."\n";

}
?>