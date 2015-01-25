Probably a mistake:
<pre class="failure">
#include &lt;stdlib.h&gt;
void foo() {
 unsigned int i=0; /* absolute value function 'abs' given an argument of type 'long long' but has parameter of type 'int' which may cause truncation of value [-Wabsolute-value] */
 abs(i);
 unsigned int j=0; /* taking the absolute value of unsigned type 'unsigned int' has no effect */
 abs(j);
}
</pre>
gcc does not display any warning.
