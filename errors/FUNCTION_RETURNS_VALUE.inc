With the command<br />
<i>clang -c  -Werror plop.c</i><br />
the code<br />
<pre class="failure">
int myFunction() {
	return;
}
</pre>
is rejected by clang while accepted with gcc.