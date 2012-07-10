This code is accepted by g++. On purpose, clang <a href="http://clang.llvm.org/compatibility.html#dep_lookup">does not accept this syntax</a>.
<pre class="failure">
// Uncomment this line will fix the issue.
// template&lt;typename Value_t&gt; void b(Value_t value)

template&lt;typename Value_t&gt; void a(Value_t value)
{
    b(value);
}

template&lt;typename Value_t&gt; void b(Value_t value)
{
}

void foo(int y)
{
    a(y);
}
</pre>