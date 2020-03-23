<?php
include("config.inc.php");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Build of the Debian archive with clang</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
</head>
<body>
<img src="irill.png" align="right" />
<h1 id="title"><a href="/">Debian Package rebuild</a></h1>
<h2 id="subtitle">Rebuild of the Debian archive with clang - per maintainer</h2>
<br />
This is the list per maintainer of the packages failing with clang <?=$currentVersion?><br /><br />
<?php
$file = file_get_contents('./maintainers.txt', true);
echo nl2br($file);
?>
<?
include("footer.php");
?>
</body>
</html>
