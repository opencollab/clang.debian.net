Undefined references can have different reasons. Here are some:<br />
1) The most common issue is about the the <i>inline</i> behavior.
clang is following by default the C99 standard while gcc promote GNU89.<br />
The following code will build with gcc but fails with:<br />
<i>main.c:(.text+0x12): undefined reference to `xrealloc'</i>

<pre class="failure">
// the right declaration in C99 is:
// static inline void xrealloc() 
inline void xrealloc() { }

int main(){
    xrealloc();
    return 1;
}
</pre>
besides the static, the command:<br />
<i>clang -std=gnu89 -o plop.exe main.c</i><br />
will fix the issue.<br />
See the <a href="http://clang.llvm.org/compatibility.html#inline">clang website</a> for more information.
<br /><br />
2) 
An other issue is that gcc is that gcc optimizes the call to some functions at -O0 (causing -lm to be not necessary)
<pre class="failure">
#include &lt;math.h&gt;
// Works: gcc -O0 -o plop plop.c 
// Fails:  clang -O0 -o plop plop.c
// Works: clang -lm -O0 -o plop plop.c
int main() {
    double plop = fabs(2.0);
    return 1;
}
</pre>
3) There are also some rare issues with the --relocatable/-r linker flag.

