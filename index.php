<?
include("config.inc.php");
include("listErrors.php");
$keyGET=mysql_real_escape_string($_GET['key']);
$versionGET=mysql_real_escape_string($_GET['version']);
if (!$versionGET || ($versionGET!="2.9" && $versionGET!="3.0" && $versionGET!="3.1" && $versionGET!="3.2")) {
        $versionGET="3.4";
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Build of the Debian archive with clang</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
</head>
<body>
<img src="irill.png" align="right" />
<h1 id="title"><a href="/">Debian Package rebuild</a></h1>
<h2 id="subtitle">Rebuild of the Debian archive with clang</h2>
<div id="body">

    By <a href="mailto:sylvestre@debian.org">Sylvestre Ledru</a> (<a href="http://www.debian.org/">Debian</a>, <a href="http://www.irill.org/">IRILL</a>). February 28th 2012 (clang 3.0),  June 23th 2012 (clang 3.1), January 28th 2013 (clang 3.2), July 14th 2013 (clang 3.3), January 10th 2014 (clang 3.4), June 6th 2014 (clang 3.4.2)<br />


<h1>Presentation</h1>
This document presents the result of the rebuild of the Debian archive (the distribution) with <a href="http://packages.qa.debian.org/c/clang.html">clang</a>, a new C/C++ compiler.<br />
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
<li>Refused declarations. See <a href="/status.php?version=<?=$currentVersion?>&key=FUNCTION_RETURNS_VALUE">example 1</a>, <a href="/status.php?version=<?=$currentVersion?>&key=MAIN_RETURNS_INT">example 2</a>, etc. </li>
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

</ul>
<br />
    Many issues listed in the 2.9 have been fixed with the version 3.0. However, due to the improvements of error detections and some more warnings, 3.1 triggers more failure than 3.0. Consequently, the percentage of failure changed from about 8 % to 12 %.
<br />
<h1>Build time, binary size or performances</h1>
For now, none of this aspect have been checked in this analyze.
I will try to introduce some measures of build time in the next analyzes.
<br />

Some pointers:<br />
<ul>
<li><a href="http://gcc.gnu.org/ml/gcc/2012-02/msg00134.html">gcc/clang compile-time measurements in Chromium</a></li>
<li><a href="http://weblogs.java.net/blog/simonis/archive/2011/02/10/compiling-hotspot-vm-clang">Compiling the HotSpot VM with Clang</a> (not up-to-date)</li>
</ul>
<br />

<h1>Future</h1>
I will rebuild regularly the Debian archive with two goals in mind:<br />
1) See which packages get fixed<br />
2) See the impact of new clang releases<br />
<br />
The next step I would like to achieve would be an automatic rebuild of each new packages in the Debian archive with clang.<br />
To complete this goal, I proposed a Google Summer project called <a href="http://wiki.debian.org/SummerOfCode2012/Projects#clang_support_for_build_services">clang support for build services</a> in the Debian context.<br >
<br />
An other aspect I am working on is to rebuild the archive using its static analyzer: scan-build. scan-build provides a great detection on some painful bugs.<br />
<br />
There are still some works to do in the LLVM/Clang world. libc++ should be packaged into Debian. LLDB should be ported to GNU/Linux.<br />
I wrote an other GSoC subject called <a href="http://wiki.debian.org/SummerOfCode2012/Projects#Provide_an_alternative_to_libstdc.2B-.2B-_with_libc.2B-.2B-">Provide an alternative to libstdc++ with libc++</a>.
<br />
<br />
<br />

<h1>Conclusions</h1>
When I had the idea to rebuild Debian with a new compiler, I was expecting many issues and bugs caused by clang but I have been surprised to notice that most of the issues are either difference in C standard supported, difference of interpretation or corner cases.<br /> 
My personal opinion is that clang is now stable and good enough to rebuild most of the packages in the Debian archive, even if many of them will need minor tweaks to compile properly.<br />
In the next few years, coupled with better static analysis tools, clang might replace gcc/g++ as the C/C++ compiler used by default in Linux and BSD distributions.<br />The clang developers are progressing very fast: 14.5% of the packages were failing with version 2.9 against 8.8% with version 3.0 and 12.1% with 3.1.<br />
Several major steps in the clang adoptions have been made like chromium/chrome being built by default with clang, Xcode providing clang by default, FreeBSD working on the gcc => clang switch, etc.<br />
However, from Debian's point of view, one important step would be to make sure that clang manages correctly all Debian kernels and release architectures (11 official, 6 unofficial)
<br />
<br />
<br />
<h1>Annexes</h1>
<h2>Rebuild</h2>
    The 2.9 and 3.0 rebuild itself have been done on a cluster called Grid 5000.<br />
    3.1, 3.2 and 3.3 rebuilds have been done on EC2, the Amazon cloud, sponsoring Debian.<br />
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
Many thanks to <a href="http://www.lucas-nussbaum.net/">Lucas Nussbaum</a> for his time and patience (especially since I did a few screw up :p).<br />
<a href="http://upsilon.cc/~zack/">Stefano Zacchiroli</a> for the review (among other things).
<br />Thanks also to <a href="https://www.grid5000.fr/">Grid 5000</a> for their infrastructure and Amazon for their credit to use AWS.<br />

</div>
<div id="footer">
Pages written by <a href="mailto:sylvestre@debian.org">Sylvestre Ledru</a> for <a href="http://www.debian.org/">Debian</a> and <a href="http://www.irill.org">IRILL</a><br />
<span class="tiny">
</span>
</div>
</body>
</html>
