<pre class="failure">
int f(int b) {
  int n;
  if (b)
    n = 1;
  return n;
}
</pre>
In some cases, <i>n</i> can be uninitialized.<br />
<i>gcc -Werror plop.c</i> will accept this code while <i>clang -Werror plop.c</i> will fail.

