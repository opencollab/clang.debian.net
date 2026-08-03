<?php
include("config.inc.php");
?>
<?
$pageTitle="Build of the Debian archive with clang - per maintainer";
$pageSubtitle="Rebuild of the Debian archive with clang - per maintainer";
include("header.php");
?>
<div id="body">
<p>This is the list per maintainer of the packages failing with clang <?=$currentVersion?></p>
<?php
$file = file_get_contents('./maintainers.txt', true);
echo nl2br($file);
?>
</div>
<?
include("footer.php");
?>
</body>
</html>
