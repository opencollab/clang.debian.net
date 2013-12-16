clang -Wall -Werror will fail because bar is private (by default) and never used. g++ does not complain here.

<pre class="failure">
class foo
{
    int bar;
};
</pre>