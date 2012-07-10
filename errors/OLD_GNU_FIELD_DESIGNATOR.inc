This piece of code is triggering a warning by clang on purpose while gcc does not complain. -Werror is failing the build.
<pre class="failure">
struct Point { int x; }
p = { x: 10 };
</pre>
