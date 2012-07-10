This problem is that g++ accepts code which should be refused. g++ is doing an unqualified lookup into dependent bases of class templates. See the <a href="http://clang.llvm.org/compatibility.html#dep_lookup_bases">official website</a>.
<br />
The attached code clearly shows the issue and the fix:
<pre class="failure">
#include &lt;vector&gt;

template<class T> class A: public std::vector<T> {
public:
	void del() {
        // The right syntax is:
        // this->erase(std::vector<T>::begin());
        erase(std::vector<T>::begin());
	}

};

void foo() {
    A<int> B;
    B.del();	
}
</pre>
