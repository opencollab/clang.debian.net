gcc accepts nested function:<br />
<pre class="failure">
int myFunction() {
       void stack_push() {
       }
}
</pre>
while <a href=" http://clang.llvm.org/docs/UsersManual.html#c_unimpl_gcc">clang does not</a>.
