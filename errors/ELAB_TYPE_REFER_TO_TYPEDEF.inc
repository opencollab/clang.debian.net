The following code is rejected by clang while accepted by g++
<pre class="failure">
#include &lt;string&gt;


template&lt;typename T&gt; T foo(T s)
{
    class T::iterator b=s.begin(), e=s.end(), p=b;
}

void foo(char *a)
{
    foo&lt;std::string&gt;(a);
}
</pre>