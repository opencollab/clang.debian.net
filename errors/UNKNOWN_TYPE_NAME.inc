Some type detections are failing or wrong assumptions were made.
For example, with strace, old configure are doing some tests on the bool (stdbool.h) declaration but fails on:
<pre class="failure">
conftest.c:84:16: error: initializer element is not a compile-time constant
         int xlcbug = 1 / (&(digs + 5)[-2 + (bool) 1] == &digs[4] ? 1 : -1);
                      ^~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
# Provided by the macro AC_HEADER_STDBOOL but removed in recent release of autoconf</pre>
