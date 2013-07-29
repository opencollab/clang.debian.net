clang triggers a warning on this useless usage of the define. The -Werror causes the failure.
<br />
<pre class="failure">
#define bar(int) (1)

void foo() {
    bar(2);
}

</pre>
With gcc, this warning is only displayed with -Wall.
