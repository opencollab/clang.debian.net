<?php
include("config.inc.php");
include("listErrors.php");
$keyGET=mysql_real_escape_string(htmlspecialchars($_GET['key']));
$versionGET=mysql_real_escape_string(htmlspecialchars($_GET['version']));
if (!$versionGET || ($versionGET!="2.9" && $versionGET!="3.0" && $versionGET!="3.1" && $versionGET!="3.2")) {
        $versionGET="3.5";
}
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
<h2 id="subtitle">Rebuild of the Debian archive with clang</h2>
<div id="body">

    By <a href="mailto:sylvestre@debian.org">Sylvestre Ledru</a> (<a href="http://www.debian.org/">Debian</a>, <a href="http://www.irill.org/">IRILL</a>). <br />


<h1>Presentation</h1>
This document presents the result of the rebuild of the Debian archive (the distribution) with clang, a C/C++ compiler.<br />
<br />
clang is now ready to build software for production (either for C, C++ or Objective-C). This compiler is providing many more warnings and interesting errors than the gcc suite while not carrying the same legacy as gcc.<br />
This rebuild has several goals. The first one is to prove (or not) that clang is a viable alternative. Second, building a software with different compilers improves the overall quality of code by providing different checks and alerts.

<br />
<h1>Rebuild results</h1>

The detailed list of errors:<br />
<?

    resultClangDisplay($currentVersion, false);
?>
<br />
Errors can be caused by several reasons:<br />
<ul>
<li>Rejected declarations. See <a href="/status.php?version=<?=$currentVersion?>&key=FUNCTION_RETURNS_VALUE">example 1</a>, <a href="/status.php?version=<?=$currentVersion?>&key=MAIN_RETURNS_INT">example 2</a>, etc. </li>
<li>Different warnings options list in <i>-Wall</i> or <i>-Wextra</i> (which will fail with -Werror). See <a href="/status.php?version=<?=$currentVersion?>&key=TAUTOLOGICAL-COMPARE">example 1</a>, <a href="status.php?version=<?=$currentVersion?>&key=LINE_POSITIVE">example 2</a>, etc.</li>
<li>g++ accepts codes which should be rejected by the compiler. See <a href="/status.php?version=<?=$currentVersion?>&key=ACCESS_PRIVATE_MEMBER">example 1</a>, <a href="/status.php?version=<?=$currentVersion?>&key=USE_OF_UNDECLARED_IDENTIFIER">example 2</a> or <a href="/status.php?version=<?=$currentVersion?>&key=CANNOT_FIND_FUNCTION">example 3</a></li>
<li>Some different in the C++ standard appreciation. See <a href="/status.php?version=<?=$currentVersion?>&key=ACCESS_PROTECTED_MEMBER">example 1</a></li>
<li>Unsupported features by clang. See <a href="/status.php?version=<?=$currentVersion?>&key=NON-POD">example 1</a>, <a href="/status.php?version=<?=$currentVersion?>&key=VARIABLE_LENGTH_ARRAY">example 2</a></li>
<li>Different default C standard (C99 for clang & C89 for gcc). See <a href="/status.php?version=<?=$currentVersion?>&key=UNDEF_REF">example 1</a>.
<li>Mangling issues. See <a href="/status.php?version=<?=$currentVersion?>&key=CHANGE_SYM_LIB">example 1</a>, etc.</li>

<li>...</li>
</ul>
Of course, a bug can hide other bugs.<br />
Bugs (with patches) will be reported in the Debian bug tracker.
They will be tagged as wishlist.<br />

<br />
<h1>Detailed results</h1>

Evolution over time:
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
    $totalDebian = $clangVersions[$version];
    $totalFailed = get_number_errors_per_version($version);
    $percent = round($totalFailed*100/$totalDebian,1);
?>
<?=$percent?>,
<? } ?>
]
]
}, {
  height: 200,
        axisY: {
            labelInterpolationFnc: function(value) {
              return value + '%';
            }}}
);
</script>

The full list of all the results with logs are available at the following URL:<br />
<ul>
<li>
<a href="/status.php?version=2.9">clang 2.9</a> (September 2011)</li>
<li>
<a href="/status.php?version=3.0">clang 3.0</a> (January 2012) - <a href="http://sylvestre.ledru.info/blog/sylvestre/2012/02/29/rebuild_of_the_debian_archive_with_clang">Blog post</a></li>
<li>
<a href="/status.php?version=3.1">clang 3.1</a> (June 2012) - <a href="http://sylvestre.ledru.info/blog/sylvestre/2012/07/24/news_on_debian_aamp_clang_1">Blog post</a></li>
<li>
<a href="/status.php?version=3.2">clang 3.2</a> (January 2013) - <a href="http://sylvestre.ledru.info/blog/sylvestre/2013/02/06/rebuild_of_debian_using_clang_3_2">Blog post</a></li>
<li>
<a href="/status.php?version=3.3">clang 3.3</a> (July 2013) - <a href="http://sylvestre.ledru.info/blog/2013/08/19/clang-3-3-and-debian">Blog post</a></li>
</li>
<li>
<a href="/status.php?version=3.4">clang 3.4</a> (January 2014) - <a href="http://sylvestre.ledru.info/blog/2014/03/21/rebuild-of-debian-using-clang">Blog post</a></li>
<li>
<a href="/status.php?version=3.5.0">clang 3.5.0</a> (September 2014) - <a href="http://sylvestre.ledru.info/blog/2014/09/11/rebuild-of-debian-using-clang-3-5">Blog post</a></li>
<li>
<a href="/status.php?version=3.6.0">clang 3.6.0</a> (March 2015) <!-- - <a href="http://sylvestre.ledru.info/blog/2014/09/11/rebuild-of-debian-using-clang-3-5">Blog post</a>--></li>
<li>
<a href="/status.php?version=3.8.0">clang 3.8.0</a> (August 2016) <!-- - <a href="http://sylvestre.ledru.info/blog/2014/09/11/rebuild-of-debian-using-clang-3-5">Blog post</a>--></li>
<li>
<a href="/status.php?version=3.9.1">clang 3.9.1</a> (July 2017) - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a></li>
<li>
<a href="/status.php?version=4.0.1">clang 4.0.1</a> (July 2017) - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a></li>
<li>
<a href="/status.php?version=5.0">clang 5.0</a> (August 2017) - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a></li>
<li>
<a href="/status.php?version=6.0">clang 6.0</a> (May 2018)<!-- - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a>--></li>
<li>
<a href="/status.php?version=7.0.1">clang 7.0</a> (Jan 2019)<!-- - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a>--></li>
<li>
<a href="/status.php?version=8svn">clang 8svn</a> (Jan 2019)<!-- - <a href="http://sylvestre.ledru.info/blog/2017/08/16/rebuild-of-debian-using-clang-2">Blog post</a>--></li>


</ul>

<h1>Status</h1>
    The Debian archive is regularly rebuilt against the latest version of clang. This to achieve three goals:<br />
1) See which packages get fixed<br />
2) See the impact of new clang releases<br />
3) Find bugs or gcc-compatibility issues in gcc itself<br />
<br />
<br />

<br />
<h1>Annexes</h1>
<h2>Rebuild</h2>
    The 2.9 and 3.0 rebuild itself have been done on a cluster called Grid 5000.<br />
    3.1, 3.2 and later rebuilds have been done on AWS, the Amazon cloud, sponsoring Debian.<br />
<br />
Each packages in the Debian archive has been rebuild with the chroot described further. <br />
     For each packages failing to build from the source with clang, the package has been rebuild with a "normal" Debian sid chroot. If working, we considered that it was due to a clang bug. Otherwise, the package is not listed in this list.<br />
<br />

<a name="configuration_chroot"></a>
<h2>Configuration of the chroot</h2>
The procedure for 2.9 & 3.0 was the following:<br />
<ul>
<li>a chroot has been created with a minimal build environment</li>
<li>gcc and g++ have been put on hold to make sure then are not changed during the installation of the dependencies<br />
(echo "gcc hold"|dpkg --set-selections)</li>
<li>clang 3.0-5 has been installed (no changes from the version available in the<br />
Debian archive has been made)</li>
<li> /usr/bin/gcc, /usr/bin/g++ and /usr/bin/cpp symlinks has been changed to point to clang</li>
<li>g++-4.6, gcc-4.6 and cpp-4.6 have been removed to make sure they are not used.</li>
</ul>
<pre class="failure">
VERSION=4.6
cd /usr/bin
rm g++-$VERSION gcc-$VERSION cpp-$VERSION
ln -s clang++ g++-$VERSION
ln -s clang gcc-$VERSION
ln -s clang cpp-$VERSION
cd -
</pre>
<br />
All packages of the archive (15658 sources packages) have been rebuild this chroot (even the one without any C or C++ code). Build dependencies used are the same as Debian. For example, that means that the libxml2 used to build a package will be the one from Debian, not the one built with clang. <br />
 <br />

From clang 3.1, with the EC2 Amazon cloud, an <i>chroot-setup-commands</i> is used for each sbuild to setup the environnement.<br />
The init code is the following:
<pre class="failure">
apt-get update

echo "Install of clang"
apt-get update
apt-get install --yes --no-install-recommends clang -t unstable

echo "Replace gcc, g++ & cpp by clang"

cd /usr/bin
VERSIONS="4.8 4.7 4.6"
for VERSION in $VERSIONS; do
rm g++-$VERSION gcc-$VERSION cpp-$VERSION
ln -s clang++ g++-$VERSION
ln -s clang gcc-$VERSION
ln -s clang cpp-$VERSION
done

echo "Block the installation of new gcc version"
echo "gcc-4.6 hold"|dpkg --set-selections
echo "cpp-4.6 hold"|dpkg --set-selections
echo "g++-4.6 hold"|dpkg --set-selections
echo "gcc-4.7 hold"|dpkg --set-selections
echo "cpp-4.7 hold"|dpkg --set-selections
echo "g++-4.7 hold"|dpkg --set-selections

echo "Check if gcc, g++ & cpp are actually clang"
gcc --version|grep clang > /dev/null || exit 1

</pre>
The same procedure has been used for the 3.2 rebuild except that the clang packages have been rebuild for unstable (instead of the experimental packages).


<h2>Acknowledgments</h2>
Many thanks to <a href="http://www.lucas-nussbaum.net/">Lucas Nussbaum</a> for his time and patience.<br />
<a href="http://upsilon.cc/~zack/">Stefano Zacchiroli</a> for the review (among other things).
<br />Thanks also to <a href="https://www.grid5000.fr/">Grid 5000</a> for their infrastructure and Amazon for their credit to use AWS.<br />

</div>
<?
include("footer.php");
?>
</body>
</html>
