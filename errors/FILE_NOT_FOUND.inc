In some cases, the <i>-MM</i> option will change the include directory list.
For example, the code
<pre class="failure">
#include &lt;libxml/parser.h&gt;
</pre>
will fail with clang but success with gcc.
<pre class="failure">
$ gcc -MM  foo.c
foo.o: foo.c

$ clang -MM  foo.c
foo.c:1:10: fatal error: 'libxml/parser.h' file not found
#include &lt;libxml/parser.h&gt;
         ^
foo.o: foo.c
1 error generated.
</pre>
Note all these problems are caused by <i>-MM</i>.

<pre class="failure">
Imake.tmpl:2243:10: fatal error: ' X11 .rules' file not found
</pre>
has been reported on the <a href="https://gitlab.freedesktop.org/xorg/util/imake/issues/1">xorg bug tracker</a>.
