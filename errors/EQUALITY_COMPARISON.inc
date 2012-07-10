clang -Wall option integrates the option -Wparentheses-equality which gcc does not know about.

<pre class="failure">
// clang -Wall -Werror -c plop.c

void foo() {
     int a=1;
     if ((a == 1)) {
        return;
     }
}
</pre>