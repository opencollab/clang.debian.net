The following code is <a href="http://clang.llvm.org/compatibility.html#vla">not (and won't) supported by clang.</a><br />
<pre class="failure">
#include &lt;vector&gt;

void foo() {
    int N=2;
    std::vector&lt;int&gt; best[2][N];
}
</pre>
