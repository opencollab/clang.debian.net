The default argument must be set in the definition or the definition done in the method declaration.

<pre class="failure">
class string
{
    friend string foo(int bar = 0);
};
</pre>
