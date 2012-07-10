clang refuses <i>void main(...</i><br />This code fails:
<br />
<pre class="failure">
#include &lt;stdio.h&gt;
void main() {
    printf("Hello world\n");
}
</pre>
Replacing <i>void</i> by <i>int</i> fixes the issue.

