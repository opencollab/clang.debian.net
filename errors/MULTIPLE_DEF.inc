Final link is failing because of the <i>extern __inline__</i> declaration.<br />
Example:<br />
<pre class="failure">
// plop1.c
extern __inline__ void plop() { }
</pre>

<pre class="failure">
// plop2.c
extern __inline__ void plop() { }
</pre>

<pre class="failure">
// foo.c
int main () { }
</pre>

<pre class="failure">
# Makefile
CC=clang
all:
	$(CC) -c plop1.c plop2.c foo.c
	$(CC) -o plop foo.o plop1.o plop2.o
</pre>