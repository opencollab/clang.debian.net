clang generates an error, g++ generates a simple warning.
<pre class="failure">
int a [[]];
int & [[noreturn]] b = a;
</pre>

<pre class="failure">
$ clang++ -std=c++11 -c foo.cpp
foo.cpp:2:9: error: 'noreturn' attribute cannot be applied to types
int & [[noreturn]] b = a;
        ^
1 error generated.

$ g++ -std=c++11 -c foo.cpp
foo.cpp:2:20: warning: attribute ignored [-Wattributes]
 int & [[noreturn]] b = a;
                    ^
foo.cpp:2:20: note: an attribute that appertains to a type-specifier is ignored

</pre>