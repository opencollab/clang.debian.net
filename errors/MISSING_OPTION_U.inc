The option -u in gcc (<i>Pretend the symbol symbol is undefined, to force linking of library modules to define it.</i>)<br />
is not implemented in clang causing all haskell packages to fail to build.<br />
See <a href="http://llvm.org/bugs/show_bug.cgi?id=18250">clang bug #18250</a> and <a href="https://ghc.haskell.org/trac/ghc/ticket/8615">GHC bug #8615</a>