Incorrect code...
<pre class="failure">
#include <stddef.h>
void foo() {
 int arr[5];
 int x;
 // warn on these conditionals
 if (foo);
 if (arr);
 if (&x);
 if (foo == NULL);
 if (arr == NULL);
 if (&x == NULL);
}

void f(int &x) {
 if (&x == nullptr) { }
}
</pre>
gcc with -Wall also detects some of these errors but not the one involving NULL.


