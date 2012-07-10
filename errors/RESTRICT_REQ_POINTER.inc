clang complains about the syntax (while gcc accepts it)
<pre class="failure">
void foo()
{
    register int i, restrict;
}
</pre>