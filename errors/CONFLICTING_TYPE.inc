clang considers conflicting declarations as error while gcc just shows a warning
<pre class="failure">
// clang  -c  foo.c
#include <stdio.h>
char *getline(int fd) { return NULL; }
</pre>