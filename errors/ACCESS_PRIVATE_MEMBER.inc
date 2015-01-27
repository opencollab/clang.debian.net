This code is accepted by g++ but refused by clang.<br />
<a href="http://gcc.gnu.org/bugzilla/show_bug.cgi?id=52373">gcc bug #52373</a> has been reported, which is a duplicate of the <a href="http://gcc.gnu.org/bugzilla/show_bug.cgi?id=41437">bug #41437</a>.<br />
<pre class="failure">
class A
{
    struct st
    {
        static void f();
    };
};

template &lt;typename t&gt; void foo()
{
    A::st::f();
}
</pre>
