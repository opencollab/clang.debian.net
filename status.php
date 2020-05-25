<?
include("config.inc.php");
include("listErrors.php");
$keyGET=mysql_real_escape_string(htmlspecialchars($_GET['key']));
if (strpos($keyGET, "..") && $keyGET!="" ) {
   header("Location: /");
}

$versionGET=mysql_real_escape_string(htmlspecialchars($_GET['version']));

// TODO improve that
if (!$versionGET || (!(array_key_exists($versionGET, $clangVersions)))) {
	$versionGET=$currentVersion;
}

if ($versionGET != "2.9" && $versionGET != "3.0" && $versionGET != "3.1") {
   $suffix="unstable_clang";
   $ext="log";
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
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>

<title><?=($keyDSC)?$keyDSC. " - ":""?>Rebuild of the Debian archive with clang</title>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
<script type="text/javascript" src="jquery.js"></script>
<link rel="stylesheet" href="/styles/github.css">
<script src="/js/highlight.pack.js"></script>
<script>hljs.initHighlightingOnLoad();</script>

<script type="text/javascript">
$(document).ready(function() {
  $('pre').each(function(i, e) {hljs.highlightBlock(e)});
});

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
    if (!isset($keyGET) || $keyGET == "") {
?>
<div align="center">clang <?=$versionGET?></div><br />

<?
    resultClangDisplay($versionGET);
 } 
else 
{


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
<div class="ct-chart"></div>

<script>
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
</script>
<?
displayVersion($versionGET, $keyGET);
?>

<?
if ($versionGET=="2.9") {
	$suffix="lsid64c";
}
if ($versionGET=="3.1" || $versionGET=="3.3") {
   	$suffix="unstable_clang";
   	$ext="log";
}
if ($versionGET=="3.9.1" || $versionGET=="4.0.1" || $versionGET=="7.0.1" || $versionGET=="8svn" || $versionGET == "8.0.1"|| $versionGET == "9.0.1" || $versionGET == "10") {
// if the patch contains the version or not
    $sameDateJuly2017=true;
}
if ($versionGET == "8.0.1"|| $versionGET == "9.0.1" || $verisonGET = "10") {
   $suffix="unstable_clang" . $versionGET;
}
if ($versionGET == "10rc2") {
   $suffix="unstable_clang10";
}

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
$nb=mysql_num_rows($result);
if ($nb > 0) {
?>
<table class="data">
<tr><th>Package</th><th>Version</th><th>Supposed error message</th><th>Full log</th>
<th>Bug report</th>
</tr>
<?
} else {
?>
<b>No error detect for version <?=$versionGET?></b><br />
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
     if ($sameDateJuly2017) {
	$dateLog[0] = $dateLog[0] . "-" . $versionGET;
     }
?>

<tr><td> <?=$row->package?> </td><td><?=$row->version?></td><td><?=$row->detected_error?></td><td><a href="/logs/<?=$dateLog[0]?>/<?=$row->package?>_<?=$version?>_<?=$suffix?>.<?=$ext?>">Log</a></td>
<td><?=($secureMode==true)?"<a href='/bugs.php?pkg={$row->package}'>Report</a>":""?>
<?
if ($row->bug_number) {
if ($row->bug_type == "debian") {
?>
<a href="http://bugs.debian.org/<?=$row->bug_number?>"><?if ($row->status == "resolved") {?><del><?=$row->bug_number?></del><?}else{?><?=$row->bug_number?><? } ?></a>
<? } else { ?>
<a href="<?=$row->bug_number?>">Bug report</a>
<? } } ?>

</td>

</tr>
     <? // metaphone($row->detected_error)  ?>
        <? } ?>
</table>
<?=$nb?> errors
<div align="right"><a href="status.php">Return to the list</a></div>
<? } ?>
</div>
<?
include("footer.php");
?>
</body>
</html>
