#!/usr/bin/php5
<?php
//$_SERVER['HTTP_HOST']="localhost";
$_SERVER['HTTP_HOST']="clang.debian.net";
include "config.inc.php";
include "listErrors.php";

if (isset($argv[1])) {
  $CLANG_VERSION=$argv[1];
} else {
  $CLANG_VERSION="3.6.0rc1";
}

if (isset($argv[2])) {
  $DATE_REBUILD=$argv[2];
} else {
  $DATE_REBUILD="2015-01-23";
}

$QUERY="DELETE FROM errors WHERE clang_version='$CLANG_VERSION' AND date_build='$DATE_REBUILD 00:00:00'";
mysql_query($QUERY);

$handle = fopen("scanlog-".$CLANG_VERSION."-".$DATE_REBUILD, "r");
if ($handle==FALSE) {
    die("Could not find source datafile");
}
$i=1;
$previous_pkg_name="";
if ($handle) {
    while (($buffer = fgets($handle, 4096)) !== false) {

        $line = explode(" ", $buffer);
        if ($line[2] != "OK") {

            if ($line[0] == "UNKNOWN") {
                echo "Fix line $i";
            } else {
                if ($line[2] != "Failed" && $line[2] != "Unknown") {
                    echo "error on line $buffer";
                    die();
                }
                $msg="";
                for ($j=4; $j < count($line); $j++) {
                    $msg .= $line[$j]. " ";
                }
                $key_code=get_key_clang($known_errors, $msg);
                if ($key_code != "BUILD_DEP") {
                    $pkg_name=mysql_real_escape_string($line[0]);
                    if (trim($msg)=="XXX") {
                        $msg="Undetected error";
                    }

                    if ($previous_pkg_name == $pkg_name) {
                        // Duplicate. Delete the former one
                        $sql="DELETE FROM errors WHERE package='{$pkg_name}' AND clang_version='{$CLANG_VERSION}'";
                        mysql_query($sql);
                        $i--;
                    }
                    $SQL="INSERT INTO errors (package, version, detected_error, error_code, date_build, clang_version, key_code) VALUES (";

                    $SQL.="'".$pkg_name."', '". mysql_real_escape_string($line[1])."', '". mysql_real_escape_string($msg)."', '". mysql_real_escape_string($line[3])."','$DATE_REBUILD','$CLANG_VERSION','$key_code')";
                    $result=mysql_query($SQL);
                    if (!$result) {
                        die('Invalid query: ' . mysql_error());
                    }
                    $previous_pkg_name = $pkg_name;
                }
          
            }
        }
        $i++;
    }
    if (!feof($handle)) {
        echo "Error: unexpected fgets() fail\n";
    }
    fclose($handle);
}
$query="delete from errors where clang_version=3.2  and trim(detected_error)='\n'";
mysql_query($query);
$query="delete from errors where clang_version=3.2  and trim(detected_error) like '%Dependencies installation failed%'";
mysql_query($query);
echo "$i lines processed\n";

?>

