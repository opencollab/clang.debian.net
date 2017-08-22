
<pre class="failure">
#include <stdio.h>

void foo() {
    printf("foo"
#include "version.h"
);
}

with version.h
#define foo 1


</pre>
<pre class="failure">
$ clang -c  -O2 -D_FORTIFY_SOURCE=2 foo.c
foo.c:5:2: error: embedding a #include directive within macro arguments is not
      supported
#include "version.h"
 ^
1 error generated.

# Works
$ gcc -c  -O2 -D_FORTIFY_SOURCE=2 foo.c


</pre>