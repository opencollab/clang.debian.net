Always true:
<pre class="failure">
int main() {
    unsigned int i = 0;
    i < 0;
}
</pre>
<i>gcc -Werror plop.c</i> will accept this code while <i>clang -Werror plop.c</i> will fail.

