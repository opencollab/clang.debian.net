With -Wall, clang detects useless const declaration:<br />
<pre class="failure">
static const int foo = 4;
</pre>
and will fails with
<pre class="failure">
$ clang -Werror -Wall -c foo.c 
foo.c:1:18: error: unused variable 'cbib_initial_size'
      [-Werror,-Wunused-const-variable]
static const int cbib_initial_size = 4;
                 ^
1 error generated.
</pre>

