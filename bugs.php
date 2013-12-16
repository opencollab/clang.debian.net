<?php
include("config.inc.php");
if ($secureMode != true) {
   die("wrong ip");
}

$pkg=$_GET['pkg'];

echo "bugs of $pkg<br />";
$client = new SoapClient(NULL,
        array('location'     => "http://bugs.debian.org/cgi-bin/soap.cgi",
        'uri'     => "Debbugs/SOAP",
        'proxy_host'  => "http://bugs.debian.org"));

$response = $client->__soapCall("get_bugs", array("key" => "package", "value" => $pkg ));

$clangReported=false;
$RCbugs=Array();
 foreach ($response as $key => $bugnumber) {
$bugresponse = $client->__soapCall("get_status", array('bug'=>$bugnumber));

$bugobj = $bugresponse[$bugnumber];
if (strpos($bugobj->subject, "FTBFS with clang instead of gcc") !== false) {
     $clangReported = true;
     $bugReported = $bugnumber;
} else {

  if (in_array($bugobj->severity, array("serious","grave","critical")) && !($bugobj->fixed) && !($bugobj->done)) {
     array_push($RCbugs, $bugobj);
     }
}
// var_dump($bugobj);
// echo "<pre>";
// echo "Number: $bugnumber\n";
// echo "Subject: $bugobj->subject\n";
// echo "Package: $bugobj->package\n";
// echo "Severity: $bugobj->severity\n";
// echo "Tags: $bugobj->tags\n";
// echo "Originator: $bugobj->originator\n";
// $bugdate = date("c", $bugobj->date);
// echo "Date: $bugdate\n";
// $modified = date("c", $bugobj->log_modified);
// echo "Modified: $modified\n";
// if ($bugobj->done) { echo "Done: $bugobj->done\n"; }
// if ($bugobj->fixed) { echo "Done: $bugobj->fixed\n"; }
}

if ($clangReported == true) {
   echo "reported {$bugnumber}";
   } else {
   if (count($RCbugs) > 0) {
     echo "RC bug(s) found:<br />";
     foreach ($RCbugs as $key => $bugobj) {
     
      echo "Number: $bugobj->id<br />";
      echo "Subject: $bugobj->subject<br /><br />";
      }
}
}
?>

<form>
<table><tr>
<td>Subject:</td><td>
<input type="text" name="subject" value="<?=$pkg?>: FTBFS with clang instead of gcc" size="80">
</td>
</tr>
<tr>
<td>Text:</td><td>
<textarea name="text" rows="30" cols="80">
Package: <?=$pkg?>

Severity: minor
Usertags: clang-ftbfs
User: pkg-llvm-team@lists.alioth.debian.org 

Hello,

Using the rebuild infrastructure http://debile.debian.net/, your package fails to build with clang (instead of gcc).

You can see the full log here:
http://debile.debian.net/TODO

Thanks,
Sylvestre
</textarea>
</td>
</tr>
</table>
<input type="submit" value="Send bug report"/>
</form>
