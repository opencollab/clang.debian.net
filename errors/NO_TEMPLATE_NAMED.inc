This code will fail to build with clang++ with the default args:
<pre class="failure">
#include <memory>
int main(int argc, char* args[]) {
	std::shared_ptr<int> somePtr;
	return 0;
};
</pre>
<pre class="failure">
# Works:
$ g++ foo.cpp

# Fails
$  clang++ foo.cpp
foo.cpp:4:7: error: no member named 'shared_ptr' in namespace 'std'
        std::shared_ptr<int> somePtr;
        ~~~~~^
foo.cpp:4:21: error: expected '(' for function-style cast or type construction
        std::shared_ptr<int> somePtr;
                        ~~~^
foo.cpp:4:23: error: use of undeclared identifier 'somePtr'
        std::shared_ptr<int> somePtr;
                             ^
3 errors generated.

# Works
$ g++ -std=c++11 foo.cpp
</pre>