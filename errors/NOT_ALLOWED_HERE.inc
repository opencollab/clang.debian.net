clang rejects inner functions while gcc accepts them.

<pre class="failure">
void foo() {

     void bar() {

     }

}
</pre>