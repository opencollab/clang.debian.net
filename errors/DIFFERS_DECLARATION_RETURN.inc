For some reasons, clang refuses the following syntax while g++ accepts it:
<pre class="failure">
#include &lt;streambuf&gt;

struct S { typedef int fd_type; };

template <typename C> class A : public std::basic_streambuf<C>, public S
{ fd_type& foo(); };

template <typename C> typename A<C>::fd_type& A<C>::foo()
{ return NULL; }
</pre>
