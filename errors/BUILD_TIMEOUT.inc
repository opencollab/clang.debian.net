The binary produced by clang is wrong when built with -D_FORTIFY_SOURCE=2.
For example, the code:
<pre class="failure">
#include &lt;stdlib.h&gt;
#include &lt;unistd.h&gt;
#include &lt;fcntl.h&gt;

int main ()
{
    char *data;
    int  pagesize;
    int fd, foo;
    pagesize = getpagesize ();
    fd = open ("conftest.mmap", O_RDWR);
    data = (char *) malloc (pagesize);
    foo = read (fd, data, pagesize);
}
</pre>
compiled with:
<pre class="failure">
clang++ -o conftest -g  -O2  -D_FORTIFY_SOURCE=2 conftest.cpp
</pre>
will be stucked in an infinity loop.
Reported upstream as <a href="http://llvm.org/bugs/show_bug.cgi?id=16821">bug 16821</a>
