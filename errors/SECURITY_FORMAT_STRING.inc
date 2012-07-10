The following code builds without any issue with gcc and fails with clang:
<pre class="failure">
#include &lt;stdio.h&gt;

void foo(void) {
    char buffer[1024];
    sprintf(buffer, "%n", 2);
}
</pre>
<i>gcc -Werror -c foo.c</i><br />
<i>clang -Werror -c foo.c</i>