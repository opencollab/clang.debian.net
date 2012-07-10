clang refuses this code while gcc accepts it:
<pre class="failure">
// foo.c:5:6: error: redefinition of a 'extern inline' function 'foo' is not
//      supported in C99 mode
extern inline void foo ()
{
}

void foo ()
{
}
</pre>