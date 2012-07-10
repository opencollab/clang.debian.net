<?
include("config.inc.php");
include("listErrors.php");
$keyGET=mysql_real_escape_string($_GET['key']);
$versionGET=mysql_real_escape_string($_GET['version']);
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<link type="text/css" rel="stylesheet" href="revamp.css" />
<link rel="StyleSheet" type="text/css" href="pkg.css" />
<link rel="StyleSheet" type="text/css" href="status.css" />
</head>
<body>
<h1 id="title">Debian Package rebuild</h1>
<h2 id="subtitle">Rebuild of the Debian archive with clang</h2>
<div id="body">


<h1>Presentation</h1>
This document presents the result of the rebuild of the Debian archive (the distribution) with clang, a new C/C++ compiler.<br />
<br />
clang is now ready to build most of the software (either for C, C++ or Objective-C). In the next few years, clang might replace gcc/g++ (it will soon be the case under *BSD  TODO). Beside this personnal opinion, I believe that building a software with various compilers is always a good thing. Due to the fact that compilers behave differently from one to the other, one will found some bugs other accepted, etc.<br />
<br />
clang is now stable and good enough to rebuild most of the packages in the Debian archive.<br />
<br />
<br />
<h1>Rebuild</h1>
    The rebuild itself has been done on a cluster called Grid 5000.<br />
<br />
Each packages in the Debian archive has been rebuild with the chroot descrived further. <br />
     For each packages failing to build from the source with clang, the package has been rebuild with a "normal" Debian sid chroot. If working, we considered that it was due to a clang bug. Otherwise, the package is not listed in this list.<br />
<br />
<br />
<h1>Bug results</h1>

The detailled list of errors:<br />
<?
    resultClangDisplay($currentVersion);
?>
<br />
The most common errors is a difference in the symbol list generated with gcc/g++ and clang.<br />
Other errors can be caused by several reasons:<br />
<ul>
<li>mangling issues</li>
<li>implicit declarations</li>
<li>different warnings options list in <i>-Wall</i> or <i>-Wextra</i> (which will fail with -Werror)</li>
<li>define qui serait existent mais pas trouvé (donc il met le symbol en implicit et remplace pas le define => verifier)</li>
</ul>
<br />
<br />
Some kind of errors are listed with 0 failure. Those are issues which occured with clang 2.9 which has been fixed by upstream with the version 3.0.<br />
<br />
<br />
<br />
<br />
<h1>Detailed results</h1>
The full list of all the results with logs are available at the following URL:<br />
clang 2.9 (September 2011)<br />
<br />
clang 3.0 (January 2012)<br />
<br />
<br />
<h1>About the bugs</h1>
Obviously, there are different categories of bugs:<br />
* The one from clang itself<br />
* Not implemented features of clang<br />
* Unwanteed features from clang developers.<br />
* if -Werror is used, the list of default warning is not the same between gcc/g++ and clang. This could lead to build failure (idem with -Wextra)<br />
* bugs tolerated by gcc/g++ but refused by clang. <br />
For example:<br />
FCluster.c:675:3: error: non-void function 'outputCluster' should return a value [-Wreturn<br />
-type]<br />
  return;<br />
<br />
Bugs (with patches) will be reported. They will be tagged as wishlist.<br />
<br />
<h1>Build time, binary size or performances</h1>
For now, none of this aspect have been checked in this analyze. Some of this aspects could be done in the future.<br />
<br />
<br />
<h1>Configuration of the chroot</h1>
The procedure has been the following:<br />
* a chroot has been created with a minimal build environnement<br />
* gcc and g++ have been put on hold to make sure then are not changed during the installation of the dependencies<br />
(echo "gcc hold"|dpkg --set-selections)<br />
* clang 3.0-5 has been installed (no changes from the version available in the<br />
Debian archive has been made)<br />
* /usr/bin/gcc, /usr/bin/g++ and /usr/bin/cpp symlinks has been changed to point to clang<br />
* g++-4.6, gcc-4.6 and cpp-4.6 have been removed to make sure they are not used.<br />
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
<h1>Future</h1>
The next step I would like to acheive would be an automatic rebuild of each new packages in the Debian archive with clang.<br />
<br />
An other aspect I am working on is to rebuild the archive using its static analyzer: scan-build. scan-build provides a great detection on some painful bugs.<br />
<br />
There are still some works to do in the LLVM/Clang world. libc++ should be packaged into Debian. LLDB should be ported to GNU/Linux.<br />
<br />
<br />
<br />
Many thanks to Lucas Nussbaum for his time and patient (especially since I did a few screw up :p). Thanks also to grid 5000 for their infrastructure.<br />
</div>
</body>
</html>
