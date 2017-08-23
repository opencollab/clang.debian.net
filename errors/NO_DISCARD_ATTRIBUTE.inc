clang generates an error, g++ generates a simple warning.
<pre class="failure">
int a [[]];
int & [[nodiscard]] b = a;
</pre>

<pre class="failure">
$ clang++ -std=c++11 -c foo.cpp
foo.cpp:2:9: error: 'nodiscard' attribute cannot be applied to types
int & [[nodiscard]] b = a;
        ^
1 error generated.

$ g++ -std=c++11 -c foo.cpp
foo.cpp:2:20: warning: attribute ignored [-Wattributes]
 int & [[nodiscard]] b = a;
                    ^
foo.cpp:2:20: note: an attribute that appertains to a type-specifier is ignored

</pre>

This is impacting mostly Qt based packages.<br />
Reported <a href="https://bugs.llvm.org/show_bug.cgi?id=34304">upstream</a>
