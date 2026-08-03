<?
include("config.inc.php");
include("listErrors.php");
$keyGET=mysqli_real_escape_string($conn_db, htmlspecialchars($_GET['key']));
if (strpos($keyGET, "..") && $keyGET!="" ) {
   header("Location: /");
}

$versionGET=mysqli_real_escape_string($conn_db, htmlspecialchars($_GET['version']));

// TODO improve that
if (!$versionGET || (!(array_key_exists($versionGET, $clangVersions)))) {
	$versionGET=$currentVersion;
}

if ($keyGET) {

   foreach ($known_errors as $key => $err) {
   	// retrieve of the name
        if ($err['key']==$keyGET) {
            $keyDSC=$err['dsc'];
            break;
        }
    }

    if ($keyGET=="NO_CAT") {
//       $keyGET="";
    }
}


?>
<?
$pageTitle=(isset($keyDSC) ? $keyDSC . " - " : "") . "Rebuild of the Debian archive with clang";
$pageHighlight=true;
include("header.php");
?>
<div id="body">

<?
    $totalDebian=$clangVersions[$versionGET];
    if (!isset($keyGET) || $keyGET == "") {
?>
<p class="lead">clang <?=$versionGET?></p>

<?
    resultClangDisplay($versionGET);
 }
else
{


?>
<p class="lead">
    <i>"<?=$keyDSC?>"</i> build failure(s) &mdash; clang <?=$versionGET?>
</p>
<p class="back-link"><a href="status.php">&larr; Return to the list</a></p>
<?
    if (is_file("errors/".$keyGET.".inc")) {
        include("errors/".$keyGET.".inc");
    }
?>
<div class="ct-chart"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
new Chartist.Line('.ct-chart', {

  labels: [
<?
foreach ($clangVersions as $version => $pkg) {
?>
'<?=$version?>',
<? } ?>
],
  series: [
[
<?
foreach ($clangVersions as $version => $pkg) {
?>
    <?=get_number_errors_per_version($version, $keyGET)?>,
<? } ?>
]
]
}, {
  height: 200
});
});
</script>
<?
displayVersion($versionGET, $keyGET);
?>

<?
// The log file layout (directory, suffix and extension) varies from one
// rebuild to the other: build_log_url() resolves it against the files on disk.

$req="SELECT *, errors.package as package FROM errors LEFT JOIN bug_reports ON bug_reports.package=errors.package WHERE clang_version='{$versionGET}' ";
if ($keyGET == "NO_CAT") {
   $keyGET="";
}
if ($keyGET!="all") {
  $req.=" AND key_code='{$keyGET}'";
}
if (isset($_GET['sort'])) {
  $req.=" order by SOUNDEX(reverse(detected_error))"; //package";
} else {
  $req.="		 order by errors.package";
}


$result=mysql_query($req);
$nb=mysqli_num_rows($result);
if ($nb > 0) {
?>
<div class="table-wrap">
<table class="data">
<thead>
<tr><th>Package</th><th>Version</th><th>Supposed error message</th><th>Full log</th>
<th>Bug report</th>
</tr>
</thead>
<tbody>
<?
} else {
?>
<p><strong>No error detected for version <?=$versionGET?></strong></p>
<?
}
while ($row = mysql_fetch_object($result)) {
      $dateLog=explode(" ",$row->date_build);
      $version=$row->version;
      if (strpos($version , ":")) {
      	 // We have an epoch
         $version_ = explode(":", $version);
	 $version = $version_[1];
     }
     $logURL=build_log_url($dateLog[0], $row->package, $version, $versionGET);
?>

<tr><td> <?=$row->package?> </td><td><?=$row->version?></td><td><?=$row->detected_error?></td><td><?if ($logURL) {?><a href="<?=$logURL?>">Log</a><?} else {?><span class="tiny">n/a</span><?}?></td>
<td><?=($secureMode==true)?"<a href='/bugs.php?pkg={$row->package}'>Report</a>":""?>
<?
if ($row->bug_number) {
if ($row->bug_type == "debian") {
?>
<a href="https://bugs.debian.org/<?=$row->bug_number?>"><?if ($row->status == "resolved") {?><del><?=$row->bug_number?></del><?}else{?><?=$row->bug_number?><? } ?></a>
<? } else { ?>
<a href="<?=$row->bug_number?>">Bug report</a>
<? } } ?>

</td>

</tr>
     <? // metaphone($row->detected_error)  ?>
        <? } ?>
<? if ($nb > 0) { ?>
</tbody>
</table>
</div>
<p class="tally"><?=$nb?> errors</p>
<? } ?>
<p class="back-link"><a href="status.php">&larr; Return to the list</a></p>
<? } ?>
</div>
<?
include("footer.php");
?>
</body>
</html>
