Usually fail when trying to link with another language like Fortran. Fails with:
<pre class="failure">
/usr/bin/ld: ../testlib/do_loops.o: relocation R_X86_64_32S against `.data' can not be used when making a PIE object; recompile with -fPIE
collect2: error: ld returned 1 exit status
</pre>