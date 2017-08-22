This code will fail to build with clang++ with the default args:
<pre class="failure">
auto k() -> auto;
</pre>
<pre class="failure">
# Works:
$ g++ -c foo.cpp

# Fails
$ clang++ -std=c++11 foo.cpp
foo.cpp:1:13: error: 'auto' not allowed in function return type
auto k() -> auto;
            ^~~~
1 error generated.


# Works
$ g++ -std=c++11 foo.cpp

</pre>