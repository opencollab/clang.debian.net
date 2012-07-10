-Wempty-body warning is enabled by default which is not the case with gcc.<br />
So, the following code will fail with clang but build with gcc:<br />
<pre class="failure">
int main() {
    if (1);
}
</pre>
<i>clang  -Werror  -c plop.c</i><br />
<i>gcc  -Werror  -c plop.c</i>
