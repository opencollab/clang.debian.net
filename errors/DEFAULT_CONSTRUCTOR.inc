This code is a defect of the C++ standard:<br />
<a href="http://www.open-std.org/jtc1/sc22/wg21/docs/cwg_active.html#1344">http://www.open-std.org/jtc1/sc22/wg21/docs/cwg_active.html#1344</a>

<pre class="failure">
class foo {
    int a;
    foo(int);
};

foo::foo(int c = 5) : a(c) {

}

</pre>