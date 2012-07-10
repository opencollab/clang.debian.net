<a href="http://gcc.gnu.org/onlinedocs/gcc/Global-Reg-Vars.html">Global register variable</a> are <a href="http://clang.llvm.org/docs/UsersManual.html#c_unimpl_gcc">not supported by clang</a>.
This code will fail to build with clang:
<pre class="failure">
register void *ptr asm("rbx") ;
</pre>