<?
include("config.inc.php");
include("listErrors.php");
$keyGET=mysql_real_escape_string($_GET['key']);
if (strpos($keyGET, "..") && $keyGET!="" ) {
   header("Location: /");
}
$versionGET=mysql_real_escape_string($_GET['version']);
if (!$versionGET || ($versionGET!="2.9" && $versionGET!="3.0" && $versionGET="3.1")) {
	$versionGET=$currentVersion;
}

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Rebuild of the Debian archive with clang</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
<script type="text/javascript" src="jquery.js"></script>

<script type="text/javascript">
$(document).ready(function () {
  $("#pkg_field").focus();

  $(".status").each(function (){
    var id = $(this).attr('id');
    if (id && id.substr(0,7) == 'status-') {
      otherid = id.replace('status-','problem-');
      problem = $('#'+otherid);
      title = $(this).attr('title');
      if (title) { title += ':\n';}
      title += $(problem).text();
      $(this).attr('title',title);
    }
  });
});
</script>

</head>
<body>
<img src="irill.png" align="right" />
<h1 id="title"><a href="/">Debian Package rebuild</a></h1>
<h2 id="subtitle">Rebuild of the Debian archive with clang</h2>
<div id="body">

<? 


    $totalDebian=$clangVersions[$versionGET];
    if (!$keyGET) {
?>
<div align="center">clang <?=$versionGET?></div><br />

<?
    resultClangDisplay($versionGET);
 } 
else 
{

    foreach ($known_errors as $key => $err) {
// retrieve of the name
        if ($err['key']==$keyGET) {
            $keyDSC=$err['dsc'];
            break;
        }

    }
    if ($keyGET=="NO_CAT") {
        $keyGET="";
    }

?>
<div align="center">
    <i>"<?=$keyDSC?>"</i> build failure(s)<br />clang <?=$versionGET?>
</div>
<div align="right">    <a href="status.php">Return to the list</a></div>
<?
    if (is_file("errors/".$keyGET.".inc")) {
        include("errors/".$keyGET.".inc");
    }
?><br />

<?
displayVersion($versionGET, $keyGET);
?>

<table class="data">
<tr><th>Package</th><th>Version</th><th>Supposed error message</th><th>Full log</th></tr>
<?
if ($versionGET=="2.9") {
	$suffix="lsid64c";
}
if ($versionGET=="3.1") {
	$suffix="unstable_clang";
    $ext="log";
}

$req="SELECT * FROM errors WHERE clang_version='{$versionGET}' AND key_code='{$keyGET}' order by package";
// order by SOUNDEX(reverse(detected_error))"; //package";

$result=mysql_query($req);
while ($row = mysql_fetch_object($result)) {
$dateLog=explode(" ",$row->date_build);
?>

<tr><td> <?=$row->package?> </td><td><?=$row->version?></td><td><?=$row->detected_error?></td><td><a href="/logs/<?=$dateLog[0]?>/<?=$row->package?>_<?=$row->version?>_<?=$suffix?>.<?=$ext?>">Log</a></td></tr>
     <? // metaphone($row->detected_error)  ?>
        <? } ?>
</table>
<div align="right"><a href="status.php">Return to the list</a></div>
<? } ?>
</div><div id="footer">
Pages written by <a href="mailto:sylvestre@debian.org">Sylvestre Ledru</a> for <a href="http://www.debian.org/">Debian</a> and <a href="http://www.irill.org">IRILL</a><br />
<span class="tiny">
</span>
</div>
</body>
</html>
