All this build failure are caused by the <a href="https://bugs.freedesktop.org/show_bug.cgi?id=45509">same bug</a> in imake (xutils-dev). Looks like that clang preprocessor is eating some tab/space which matters for imake.

