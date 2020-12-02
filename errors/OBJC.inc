<p>gobjc is the ObjC runtime of GCC. Therefor clang does not include gobjc headers.</p>
<p><a href="https://github.com/gnustep/libobjc2">libobjc2</a> is the free drop-in replacement for the GCC runtime by the GNUstep project. It is meant to be used together with clang.<br />
libobjc2 supports the following features above and beyond the GCC runtime (copied from the project's README, MIT license):</p>
<ul>
  <li>The modern Objective-C runtime APIs, initially introduced with OS X 10.5.</li>
  <li>Blocks (closures).</li>
  <li>Synthesised property accessors.</li>
  <li>Efficient support for @synchronized()</li>
  <li>Type-dependent dispatch, eliminating stack corruption from mismatched selectors.</li>
  <li>Support for the associated reference APIs introduced with Mac OS X 10.6.</li>
  <li>Support for the automatic reference counting APIs introduced with Mac OS X 10.7</li>
</ul>

<p>There are no official Debian packages for libobjc2 yet. Packaging work in progress is done as part of the <a href="https://github.com/trunkmaster/nextspace/tree/master/Packaging/Debian">Nextspace project</a>.</p>

<p>The wish <a href="http://bugs.debian.org/cgi-bin/bugreport.cgi?bug=680784">#680784</a> may be removed as it does not seem to provide a sufficient solution.</p>
