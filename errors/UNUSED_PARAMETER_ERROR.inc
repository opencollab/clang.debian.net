-Wextra of clang incluses -Wunused-parameter which is not the case with gcc.<br />
So, the following code will fail with clang but build with gcc:<br />
<pre class="failure">
int main(int argc, char *argv[])
{
}
</pre>
<i>clang  -Werror -Wextra  -c plop.c</i><br />
<i>gcc  -Werror -Wextra  -c plop.c</i>