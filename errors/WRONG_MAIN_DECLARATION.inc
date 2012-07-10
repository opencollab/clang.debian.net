main declaration should be:<br />
<pre class="failure">
int main(void);
int main(int argc, char *argv[]);
int main(int argc, char **argv);
int main(int argc, char **argv, char **envp);
</pre>
and clang refuses the declaration:
<pre class="failure">
main (int argc, char*argv[]) { }
# error: C++ requires a type specifier for all declarations

</pre>