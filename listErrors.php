<?php
include_once("config.inc.php");
$known_errors= Array(
        Array("key" => "UNKNOWN_OPTION", "dsc" => "Unsupported option", "msg" => Array("the clang compiler does not support","error: '-I-' not supported"), "nb" => 0),
        Array("key" => "UNSUPPORTED_ARGUMENT","dsc" => "Unsupported argument with another option", "msg" => Array("unsupported option","error: unsupported argument"), "nb" => 0),
        Array("key" => "OPENMP_NOT_AVAILABLE", "dsc" => "OpenMP is not installed by default with clang", "msg" => Array("'omp.h' file not found","We need OpenMP","missing omp.h","Could not find omp.h", 'know how to enable OpenMP', 'seem to have a C compiler with OpenMP support installed'), "nb" => 0),
        Array("key" => "MAIN_RETURNS_INT", "dsc" => "main function must return int", "msg" => "error: 'main' must return 'int'", "nb" => 0),
        Array("key" => "FUNCTION_RETURNS_VALUE", "dsc" => "non-void function should return a value", "msg" => Array("should return a value [-Wreturn-type]","control may reach end of non-void function"), "nb" => 0),
        Array("key" => "LINK_ERROR", "dsc" => "Linker error", "msg" => "linker command failed with exit code", "nb" => 0),
        Array("key" => "OBJC", "dsc" => "Could not find objective C headers", "msg" => "'objc/objc.h' file not found", "nb" => 0),
        Array("key" => "WRONG_OPTIM_VAL", "dsc" => "Invalid value for -O", "msg" => Array("invalid value '6' in '-O6'", "invalid value '9' in '-O9'","invalid value '20' in '-O20'", "invalid integral value") , "nb" => 0),
        Array("key" => "CHANGE_SYM_LIB", "dsc" => "Change symbol in libs", "msg" => Array("dh_makeshlibs: dpkg-gensymbols","dh_makeshlibs: failing due to earlier errors"), "nb" => 0),
        Array("key" => "MULTIPLE_DEF", "dsc" => "Multiple definition", "msg" => "multiple definition of", "nb" => 0),
        Array("key" => "MISSING_OPTION_U", "dsc" => "Option -u not existing in clang", "msg" => "undefined reference to `base_GHCziTopHandler_flushStdHandles_closure'", "nb" => 0),
        Array("key" => "UNDEF_REF", "dsc" => "Missing symbols at link time", "msg" => Array("undefined reference to", "ome symbols or patterns disappeared in the symbols file"), "nb" => 0),

        Array("key" => "NO_REF_VALUE", "dsc" => "XXX does not refer to a value", "msg" => "does not refer to a value", "nb" => 0),
        Array("key" => "UNKNOWN_TYPE_NAME", "dsc" => "Unknown Type Name", "msg" => "unknown type name", "nb" => 0),
        Array("key" => "UNKNOWN_ARG", "dsc" => "Unknown argument in the command line", "msg" => Array("Unknown argument", "unknown argument"), "nb" => 0),
        Array("key" => "IMPLICIT_INSTANTIATION", "dsc" => "Implicit instantiation", "msg" => "implicit instantiation of undefined template", "nb" => 0),
        Array("key" => "USE_OF_UNDECLARED_IDENTIFIER", "dsc" => "Unqualified lookup into dependent bases of class templates", "msg" => "use of undeclared identifier", "nb" => 0),
        Array("key" => "EQUALITY_COMPARISON", "dsc" => "Equality comparison with extraneous parentheses", "msg" => "equality comparison with extraneous parentheses", "nb" => 0),
        Array("key" => "REDEF_NOT_SUPPORTED_C99", "dsc" => "Redefinition of a extern inline not supported in C99", "msg" => "is not supported in C99 mode", "nb" => 0),
        Array("key" => "WRONG_GCC_ASSUMPTION", "dsc" => "Wrong assumption about gcc/g++ output", "msg" => Array("g++ was not found","see the result of gcc","gcc >= 3.0 is needed","Compiler version 3.0","Gcc version error","GCC too old","You need gcc"), "nb" => 0),
        Array("key" => "AMBIGUOUS_DECLARATION", "dsc" => "Ambiguous declaration", "msg" => "is ambiguous", "nb" => 0),
        Array("key" => "POSIX_SPAWN_FAILED", "dsc" => "posix_spawn failed", "msg" => "posix_spawn failed: Cannot allocate memory", "nb" => 0),
        Array("key" => "CANNOT_USE_O_MULTI_OUTPUT", "dsc" => "Cannot use -o use multiple output", "msg" => "cannot specify -o when generating multiple output files", "nb" => 0),
        Array("key" => "REDEFINITION", "dsc" => "Redefinition failed", "msg" => Array("redefinition of","macro redefined"), "nb" => 0),
        Array("key" => "PARAMETER_CANNOT_BE_QUALIFIED", "dsc" => "Parameter could be qualified", "msg" => "parameter declarator cannot be qualified", "nb" => 0),
        Array("key" => "CONFLICTING_TYPE", "dsc" => "Conflicting types", "msg" => "error: conflicting types for", "nb" => 0),
        Array("key" => "WRONG_MAIN_DECLARATION", "dsc" => "Wrong main declaration", "msg" => Array("first parameter of 'main' (argument count) must be of type 'int'","error: second parameter of 'main'","too many parameters (4) for 'main'","error: C++ requires a type specifier for all"), "nb" => 0),
        Array("key" => "EMPTY_BODY", "dsc" => "Empty body declaration", "msg" => Array("if statement has empty body","for loop has empty body","while loop has empty body"), "nb" => 0),
        Array("key" => "CONFIGURE_FAILED", "dsc" => "Configure failed", "msg" => Array("compiler cannot create executables", "does not preserve whitespace with or without -traditional","fatal error: 'ac_nonexistent.h' file not found"), "nb" => 0),
        Array("key" => "FILE_NOT_FOUND", "dsc" => "Some headers could not be found", "msg" => "file not found", "nb" => 0),
        Array("key" => "SYMBOL_ERROR", "dsc" => "Symbol errors", "msg" => Array("could not read symbols: Bad value","could not read symbols: Invalid operation"), "nb" => 0),
        Array("key" => "SEG_FAULT", "dsc" => "Segmentation fault", "msg" => "Segmentation fault", "nb" => 0),
        Array("key" => "OLD_GNU_FIELD_DESIGNATOR", "dsc" => "Use of old GNU field designator", "msg" => "use of GNU old-style field designator extension", "nb" => 0),
        Array("key" => "TAUTOLOGICAL-COMPARE", "dsc" => "Tautological comparison", "msg" => Array("-Wtautological-compare"), "nb" => 0),
        Array("key" => "RESTRICT_REQ_POINTER", "dsc" => "restrict requires a pointer or reference", "msg" => "error: expected identifier or '('", "nb" => 0),
        Array("key" => "EXPECTED_DECLARATION", "dsc" => "Expected declaration (#define missing?)", "msg" => "error: expected", "nb" => 0),
        Array("key" => "XLIB_BUILD_FAIL", "dsc" => "xutils-dev build tool is failing", "msg" => Array("Imake.rules:2486:25: error:","Imake.rules:1674:27: error: empty character constant"), "nb" => 0),
        Array("key" => "EMPTY_CHAR_CONST", "dsc" => "Empty character constant ", "msg" => "error: empty character constant", "nb" => 0),
        Array("key" => "CANNOT_USE_TRY", "dsc" => "cannot use 'try' with exceptions disabled", "msg" => "cannot use 'try' with exceptions disabled", "nb" => 0),
        Array("key" => "ACCESS_PRIVATE_MEMBER", "dsc" => "Access to a private member", "msg" => "is a private member of", "nb" => 0),
        Array("key" => "ACCESS_PROTECTED_MEMBER", "dsc" => "Access to a protected member", "msg" => "is a protected member of", "nb" => 0),
        Array("key" => "CONVERSION_ERROR", "dsc" => "Conversion error", "msg" => "-Wconversion", "nb" => 0),
        Array("key" => "UNUSED_PARAMETER_ERROR", "dsc" => "Unused parameter", "msg" => Array("-Wunused-parameter","-Wunusedvalue"), "nb" => 0),
        Array("key" => "CLANG_FAILED", "dsc" => "clang command failed", "msg" => Array("gcc frontend command"), "nb" => 0),
        Array("key" => "NOT_STRUCT_UNION", "dsc" => "Member is not a structure or union", "msg" => Array("is not a structure or union"), "nb" => 0),
        Array("key" => "LINE_POSITIVE", "dsc" => "#line requires a positive integer", "msg" => Array("#line directive requires a positive integer argument"), "nb" => 0),
        Array("key" => "VARIABLE_LENGTH_ARRAY", "dsc" => "Variable length array in structure won't be supported", "msg" => Array("variable length array in structure' extension will never be supported"), "nb" => 0),
        Array("key" => "NON-POD", "dsc" => "Variable length array for a non POD (plain old data) element", "msg" => Array("variable length array of non-POD element"), "nb" => 0),
        Array("key" => "NOT_SUPPORTED_REGISTER", "dsc" => "Global register variable not supported ", "msg" => Array("error: global register variables are not supported"), "nb" => 0),
        Array("key" => "NO_MATCHING_FUNCTION_CALL", "dsc" => "No matching function call", "msg" => Array("error: no matching function for call"), "nb" => 0),
        Array("key" => "NO_MATCHING_MEMBER_CALL", "dsc" => "No matching member or constructor call", "msg" => Array("error: no matching member function for call","no matching constructor"), "nb" => 0),
        Array("key" => "BINDING_DROPS_QUALIFIERS", "dsc" => "Binding of reference drops qualifiers ", "msg" => Array("error: binding of reference to type"), "nb" => 0),
        Array("key" => "CANNOT_FIND_FUNCTION", "dsc" => "Unqualified lookup in templates", "msg" => Array("that is neither visible in the template definition nor found by argument-dependent lookup"), "nb" => 0),
        Array("key" => "INVALID_USE_NONSTATIC", "dsc" => "Invalid use of nonstatic data member", "msg" => Array("invalid use of nonstatic data member"), "nb" => 0),
        Array("key" => "DIFFERS_DECLARATION_RETURN", "dsc" => "Definition differs from the declaration in the return type ", "msg" => Array("error: out-of-line definition of"), "nb" => 0),
        Array("key" => "UNUSED_FUNCTION", "dsc" => "Unused function", "msg" => Array("error: unused function "), "nb" => 0),
	Array("key" => "NO_MEMBER", "dsc" => "Cannot find member in the struct", "msg" => Array("no member named"), "nb" => 0),
        Array("key" => "CONFLICTING_DECLARATION", "dsc" => "Conflicting declaration", "msg" => "error: declaration conflicts with target of using declaration already in scope", "nb" => 0),
        Array("key" => "WRONG_RESOLUTION_WITHOUT_TYPENAME", "dsc" => "Wrong resolution without typename", "msg" => "error: dependent using declaration resolved to type without", "nb" => 0),


        Array("key" => "SECURITY_FORMAT_STRING", "dsc" => "Security: Format string is not a string literal", "msg" => Array("format string is not a string literal","format string discouraged (potentially insecure)"), "nb" => 0),

        Array("key" => "CODE16_NOT_SUPPORTED", "dsc" => ".code16 not supported yet", "msg" => Array(".code16 not supported yet"), "nb" => 0),

        Array("key" => "C_WITH_LINKER", "dsc" => "-c is conflicting with the linker argument ", "msg" => Array("'linker' input unused when '-c' is present"), "nb" => 0),
//use 'template' keyword to treat 'find' as a dependent template name 
        Array("key" => "DEPENDENT_TEMPLATE", "dsc" => "Use of a keyword as dependent template name", "msg" => Array("as a dependent template name"), "nb" => 0),

//        Array("key" => "VOID_CONST_VOID", "dsc" => "Cannot initialize a parameter of type 'void *'  with 'const void *const'", "msg" => Array("cannot initialize a parameter of type 'void *' with an lvalue of type 'const void *const'"), "nb" => 0),

        Array("key" => "NO_RETURN", "dsc" => "Void function should not return a value", "msg" => Array("should not return a value [-Wreturn-type]"), "nb" => 0),

        Array("key" => "REF_MUST_BE_CALLED", "dsc" => "Reference to non-static member function must be called", "msg" => Array("reference to non-static member function must be called"), "nb" => 0),
        Array("key" => "EXPLICIT_SPECIALIZATION", "dsc" => "Explicit Specialization after instantiation", "msg" => Array("error: explicit specialization of"), "nb" => 0),
        Array("key" => "ELAB_TYPE_REFER_TO_TYPEDEF", "dsc" => "Elaborated type refers to a typedef", "msg" => Array("elaborated type refers to a typedef"), "nb" => 0),

        Array("key" => "EXPRESSION_RESULT_UNUSED", "dsc" => "Expression result unused", "msg" => Array("expression result unused"), "nb" => 0),
        Array("key" => "CANNOT_COMBINE_WITH_PREV_DECL", "dsc" => "Cannot combine with previous declaration specifier", "msg" => Array("cannot combine with previous"), "nb" => 0),
        Array("key" => "VARIABLE_UNINITIALIZED_HERE", "dsc" => "Variable is uninitialized when used here", "msg" => Array("is uninitialized when used here"), "nb" => 0),

        Array("key" => "PARAMETER_WITHOUT_TYPE", "dsc" => "Parameter list without types not allowed", "msg" => Array("parameter list without types is only allowed in a function definition"), "nb" => 0),

        Array("key" => "NO_SUCH_FILE", "dsc" => "Some files are gone in the process", "msg" => Array(": No such file or directory","no such file or directory"), "nb" => 0),

        Array("key" => "UNUSED_ARG", "dsc" => "Argument unused caused failure", "msg" => Array("argument unused during compilation: '--param ssp-buffer-size=4'","argument unused during compilation: "), "nb" => 0),

        Array("key" => "BUILD_DEP", "dsc" => "Build dependency issue", "msg" => Array("unsatisfiable build-dependencies","build-dependency not installable"), "nb" => 0),

        Array("key" => "UNKNOW_WARNING_OPTION", "dsc" => "Unknown warning option", "msg" => Array("unknown warning option"), "nb" => 0),

        Array("key" => "CANNOT_FIND_LIB", "dsc" => "Could not find a library", "msg" => Array("ld: cannot find -l"), "nb" => 0),

        Array("key" => "SOMETIMES_UNINITIALIZED", "dsc" => "Potential usage of an uninitialized variable", "msg" => Array("-Wsometimes-uninitialized"), "nb" => 0),

        Array("key" => "CANNOT_INIT_ELEM", "dsc" => "Cannot initialize a element", "msg" => Array("cannot initialize a variable of type","cannot initialize a parameter of type","cannot initialize return object of type","cannot initialize return object of type"), "nb" => 0),

        Array("key" => "NOT_ALLOWED_HERE", "dsc" => "No support of nested C function", "msg" => Array("error: function definition is not allowed here","error: expected ';' at end of declaration"), "nb" => 0),
	Array("key" => "DEFAULT_CONSTRUCTOR", "dsc" => "Changes of default constructor", "msg" => Array("error: addition of default argument on redeclaration makes this constructor a default constructor"), "nb" => 0),

	Array("key" => "LINKER_OPTION_UNUSED", "dsc" => "Linker option unused", "msg" => Array("' input unused"), "nb" => 0),

	Array("key" => "UNUSED_PRIV_FIELD", "dsc" => "Unused private field", "msg" => Array("-Wunused-private-field"), "nb" => 0),

	Array("key" => "INCOMPLETE_DEF_TYPE", "dsc" => "Incomplete definition of a type", "msg" => Array("error: incomplete definition of type"), "nb" => 0),

        Array("key" => "MISMATCHED_TAGS", "dsc" => "Mismatched Tags", "msg" => Array("-Wmismatched-tags"), "nb" => 0),

        Array("key" => "ENUM_CONVERSION", "dsc" => "Enum Conversion", "msg" => Array("-Wenum-conversion"), "nb" => 0),

        Array("key" => "MISSING_PROTOTYPE", "dsc" => "Missing prototypes", "msg" => Array("-Wmissing-prototypes"), "nb" => 0),

        Array("key" => "DEPRECATED_DECLARATION", "dsc" => "Deprecated declaration", "msg" => Array("-Wdeprecated-declarations"), "nb" => 0),

        Array("key" => "STRING_PLUS_INT", "dsc" => "String + int", "msg" => Array("-Wstring-plus-int"), "nb" => 0),

/* New in 3.4 */

Array("key" => "UNUSED_CONST_VARIABLE", "dsc" => "Unused const variable", "msg" => Array("-Werror,-Wunused-const-variable"), "nb" => 0),

Array("key" => "RECURSIVE_TEMPLATE_EXCEEDED", "dsc" => "Recursive template instantiation exceeded", "msg" => Array("recursive template instantiation exceeded"), "nb" => 0),

Array("key" => "WRONG_DEFAULT_DECLARATION", "dsc" => "Wrong C++ default declaration in a method", "msg" => Array("friend declaration specifying a default argument must be a definition", "default arguments cannot be added to an out-of-line definition"), "nb" => 0),

Array("key" => "RETURN_TYPE_DIFFER", "dsc" => "return type of out-of-line differs from that in the declaration", "msg" => Array("return type of out-of-line definition of"), "nb" => 0),

Array("key" => "INVALID_CXX11_USAGE", "dsc" => "Usage of C++11 feature without the argument", "msg" => Array("enabled with the -std=c++11 or -std=gnu++11 compiler options"), "nb" => 0),

        Array("key" => "READONLY_VAR_NOT_ASSIGN", "dsc" => "read-only variable is not assignable", "msg" => Array("read-only variable is not assignable"), "nb" => 0),

        Array("key" => "DEF_BUILTIN_FUNCTION", "dsc" => "Definition of a builtin function", "msg" => Array("error: definition of builtin function"), "nb" => 0),

        Array("key" => "BUILD_TIMEOUT", "dsc" => "The build timeout", "msg" => Array("Build killed with signal"), "nb" => 0),
	
// Added 3.5.0
	Array("key" => "EMBEDDED_DIRECTIVE_UNDEFINED", "dsc" => "Embedded directive has undefined behavior", "msg" => Array("embedding a directive within macro arguments has undefined behavior"), "nb" => 0),
        Array("key" => "NO_VIABLE_OVERLOADED", "dsc" => "No viable overloaded", "msg" => Array("no viable overloaded"), "nb" => 0),
	Array("key" => "HEADER_GUARD", "dsc" => "Header guard failure", "msg" => Array("is used as a header guard here"), "nb" => 0),
        Array("key" => "ABSOLUTE_VALUE_ERROR", "dsc" => "Absolute value error", "msg" => Array("Wabsolute-value"), "nb" => 0, "new" => "3.5.0"),
//+ tautolical
        Array("key" => "INT_POINTER_COMPARISON", "dsc" => "Comparison between pointer and integer", "msg" => Array("comparison between pointer and integer"), "nb" => 0),
        Array("key" => "INVALID_INSTRUCTION_MNEMONIC", "dsc" => "Invalid instruction mnemonic", "msg" => Array("invalid instruction mnemonic"), "nb" => 0),
        Array("key" => "FORWARD_WITH_NESTED", "dsc" => "Forward declaration of class cannot have a nested name specifier", "msg" => Array("forward declaration of class cannot have a nested name specifier"), "nb" => 0),
        Array("key" => "DEFAULT_INIT_NEEDS_USER_CONST", "dsc" => "Default initialization needs a user-provided default constructor", "msg" => Array("default initialization of an object of const type"), "nb" => 0),
        Array("key" => "NO_TYPE_NAMED_IN_NAMESPACE", "dsc" => "No type named in namespace", "msg" => Array("no type named"), "nb" => 0),
	Array("key" => "FUNCTION_DIFFER_RETURN_CANNOT_OVERLOADED", "dsc" => "Functions differ only in their return type cannot be overloaded", "msg" => Array("functions that differ only in their return type cannot be overloaded"), "nb" => 0),
        Array("key" => "DEFAULT_ARG_DECLARED_FUNC_TEMPLATE", "dsc" => "Default arguments cannot be added to a function template (already declared)", "msg" => Array("default arguments cannot be added to a function template that has already been declared"), "nb" => 0),
        Array("key" => "UNKNOWN_UNEXPECTED_DIRECTIVE", "dsc" => "Unknown/unexpected directive", "msg"  => Array("unknown directive", "unexpected directive"), "nb" => 0),
        Array("key" => "HIDES_OVERLOADED_VIRTUAL_FUNCTION", "dsc" => "Hides overloaded virtual function", "msg"  => Array("hides overloaded virtual function"), "nb" => 0),
	Array("key" => "ASSIGN_VAR_TO_TYPE", "dsc" => "Explicitly assigning a variable of type", "msg"  => Array("explicitly assigning a variable of type"), "nb" => 0),
	Array("key" => "VISIBILITY_NOT_MATCH", "dsc" => "Visibility does not match previous declaration", "msg"  => Array("visibility does not match previous declaration"), "nb" => 0),
        Array("key" => "NOT_FUNCTION_OR_FUNCTION_POINTER", "dsc" => "Object is not a function or function pointer ", "msg"  => Array(" is not a function or function pointer"), "nb" => 0),
        Array("key" => "NOT_COMPILE_TIME_CONSTANT", "dsc" => "Initializer element not compile-time constant", "msg"  => Array("initializer element is not a compile-time constant"), "nb" => 0),
        Array("key" => "TAUTOLOGICAL-POINTER-COMPARE", "dsc" => "Tautological pointer comparison", "msg" => Array("Wtautological-constant-out-of-range-compare","Wtautological-pointer-compare","tautological-undefined-compare"), "nb" => 0, "new" => "3.5.0"),
        Array("key" => "HASKELL_BUILD_FAIL", "dsc" => "openBinaryFile is not defined for haskell packages", "msg"  => Array("openBinaryFile: does not exist"), "nb" => 0),
        Array("key" => "KEYWORD_PRECEDE", "dsc" => "Keyword must precede function declarator", "msg" => Array("keyword must precede function declarator"), "nb" => 0),

        Array("key" => "INCORRECT_LOGICAL", "dsc" => "Incorrect logical operation", "msg" => Array("logical-not-parentheses","logical-op-parentheses"), "nb" => 0),

        Array("key" => "INCORRECT_CONVERSION", "dsc" => "Incorrect conversion", "msg" => Array("Wpointer-bool-conversion", "Wsign-conversion", "Wundefined-bool-conversion", "Wnull-conversion"), "nb" => 0, "new" => "3.6.0"),

        Array("key" => "SELF_ASSIGN", "dsc" => "Explicitly assigning value of variable", "msg" => Array("Wself-assign"), "nb" => 0),

        Array("key" => "CXX11_NARROWING", "dsc" => "Cannot be narrowed", "msg" => Array("Wc++11-narrowing"), "nb" => 0),

        Array("key" => "DUPLICATE_DECL_SPEC", "dsc" => "Duplicate declaration specifier", "msg" => Array("Wduplicate-decl-specifier"), "nb" => 0),

        // added in 3.8.1
        Array("key" => "MISSING_DECL", "dsc" => "Missing declaration", "msg" => Array("Wmissing-declarations"), "nb" => 0),
        Array("key" => "IGNORED_UNK_ATTRIB", "dsc" => "Ignored or unknown attributes", "msg" => Array("Wignored-attributes", "Wunknown-attributes"), "nb" => 0),
        Array("key" => "IMPL_FUNC_DECL", "dsc" => "Implicit function error", "msg" => Array("Wimplicit-function-declaration"), "nb" => 0),
        Array("key" => "OLD_STYLE_CAST", "dsc" => "Old style cast", "msg" => Array("Wold-style-cast"), "nb" => 0),
        Array("key" => "STATIC_IN_INLINE", "dsc" => "Static in inline", "msg" => Array("Wstatic-in-inline"), "nb" => 0),
        Array("key" => "UNEXP_TOKEN", "dsc" => "Unexpected token at start of statement", "msg" => Array("unexpected token at start of statement"), "nb" => 0),

        Array("key" => "EXCEPTION_SPEC", "dsc" => "Missing exception specification", "msg" => Array("is missing exception specification"), "nb" => 0),
        Array("key" => "NOT_ALLOW", "dsc" => "Not allowed args fails the build", "msg" => Array("not allowed with"), "nb" => 0),


// added in 3.9.1
        Array("key" => "QT_CPP_11_MISS", "dsc" => "Qt thinks that clang is not a C++11 compiler", "msg" => Array("Qt requires a C++11 compiler and yours does not seem to be that."), "nb" => 0, "new" => "3.9"),
        Array("key" => "LINK_FAILED_NONRE", "dsc" => "Linker issue - Nonrepresentable section on output", "msg" => Array(": Nonrepresentable section on output"), "nb" => 0, "new" => "3.9"),
        Array("key" => "SPACE_LITERAL", "dsc" => "C++11 requires a space between literal and identifier", "msg" => Array("[-Wreserved-user-defined-literal]"), "nb" => 0, "new" => "3.8"),
        Array("key" => "FORWARD_REF", "dsc" => "ISO C++ forbids forward references to 'enum' types ", "msg" => Array("ISO C++ forbids forward references to 'enum' types"), "nb" => 0, "new" => "3.8"),
        Array("key" => "NO-PIE-UNSUPPORTED", "dsc" => "no-pie is not an known option (breaks all haskell packages)", "msg" => Array("In file included from /tmp/"), "nb" => 0, "new" => "3.9"),
        Array("key" => "VARARGS_UNDEF", "dsc" => "-Wvarargs: undefined behavior with va_start", "msg" => Array("passing an object that undergoes default argument promotion to"), "nb" => 0, "new" => "3.9"),
        Array("key" => "ORDERED-COMP-PTR-ZERO", "dsc" => "Ordered comparison between pointer and zero", "msg" => Array("ordered comparison between pointer and zero"), "nb" => 0, "new" => "4.0"),
        Array("key" => "BOOL_LIT", "dsc" => "bool literal returned from a function", "msg" => Array("bool literal returned from"), "nb" => 0, "new" => "4.0"),
        Array("key" => "PACKED_NUMBER", "dsc" => "Taking address of packed member of class or structure may result in an unaligned pointer value", "msg" => Array("taking address of packed member"), "nb" => 0, "new" => "4.0"),

        Array("key" => "OPTIM_FLAG_NOT_SUPPORTED", "dsc" => "Optimization flag is not supported", "msg" => Array("ignored-optimization-argument"), "nb" => 0, "new" => "4.0"),
        Array("key" => "NO_TEMPLATE_NAMED", "dsc" => "Default is not C++11", "msg" => Array("error: no template named"), "nb" => 0),
        Array("key" => "AUTO_FUNC_NOT_ALLOWED", "dsc" => "auto not allowed in function return type", "msg" => Array("not allowed in function return type"), "nb" => 0, "new" => "5.0"),
        Array("key" => "NO_DISCARD_ATTRIBUTE", "dsc" => "nodiscard attribute cannot be applied to types", "msg" => Array("'nodiscard' attribute cannot be applied to types"), "nb" => 0, "new" => "5.0"),

        Array("key" => "UNSUPPORTED_DIRECTIVE_MACRO", "dsc" => "Unsupported include directive within macro arg", "msg" => Array("include directive within macro arguments is not supported"), "nb" => 0),
        Array("key" => "FAILED_PARSE_DEFAULT", "dsc" => "qmake: failed to parse default search paths from compiler", "msg" => Array("failed to parse default search paths from compiler"), "nb" => 0, "new" => "6.0"),
	Array("key" => "NO_ALLOW_DECL", "dsc" => "does not allow access declarations", "msg" => Array("does not allow access declarations; use using declarations"), "nb" => 0, "new" => "6.0"),
        Array("key" => "MISSING_FIELD_INIT", "dsc" => "Missing field initializer", "msg" => Array("error,-Wmissing-field-initializers"), "nb" => 0),
        Array("key" => "DELETE_NON_VIRTUAL_DTOR", "dsc" => "Has virtual functions but non-virtual destructor", "msg" => Array("error,-Wdelete-non-virtual-dtor"), "nb" => 0),
        Array("key" => "EXCEPT_NOT_MATCH", "dsc" => "Exception specification in declaration does not match previous declaration", "msg" => Array("exception specification in declaration does not match previous"), "nb" => 0),
        Array("key" => "NULL_POINTER_ARITHMETIC", "dsc" => "Performing pointer arithmetic on a null pointer has undefined behavior", "msg" => Array("error,-Wnull-pointer-arithmetic"), "nb" => 0, "new" => "6.0"),
        Array("key" => "PESSIMIZING_MOVE", "dsc" => "Moving a temporary object prevents copy elision", "msg" => Array("error,-Wpessimizing-move"), "nb" => 0),
        Array("key" => "INCONSISTENT_MISSING_OVERRIDE", "dsc" => "Overrides a member function but is not marked override", "msg" => Array("error,-Winconsistent-missing-override"), "nb" => 0),
        Array("key" => "UNUSED_VARIABLE", "dsc" => "Unused variable", "msg" => Array("error,-Wunused-variable"), "nb" => 0, "new" => "6.0"),
        Array("key" => "PRAGMA_PACK", "dsc" => "The current #pragma pack aligment value is modified in the included file", "msg" => Array("error,-Wpragma-pack"), "nb" => 0, "new" => "6.0"),
        Array("key" => "UNUSED_LAMBDA_CAPTURE", "dsc" => "Lambda capture is not used", "msg" => Array("error,-Wunused-lambda-capture"), "nb" => 0),
        Array("key" => "NON_LITERAL_NULL_CONVERSION", "dsc" => "Expression which evaluates to zero treated as a null pointer constant of type", "msg" => Array("error,-Wnon-literal-null-conversion"), "nb" => 0),
        Array("key" => "NON_POD_VARARGS", "dsc" => "Cannot pass non-trivial object of type 'xx' to variadic function", "msg" => Array("non-pod-varargs"), "nb" => 0, "new" => "6.0"),
        Array("key" => "CXX_14_EXT", "dsc" => "Is a C++14 extension", "msg" => Array("error,-Wc++14-extensions"), "nb" => 0, "new" => "6.0"),

	Array("key" => "ASM_GOTO", "dsc" => "'asm goto' constructs are not supported yet", "msg" => Array("'asm goto' constructs are not supp"), "nb" => 0),

	Array("key" => "ILLEGAL_STORAGE", "dsc" => "illegal storage class on function", "msg" => Array("illegal storage class on function"), "nb" => 0),
	Array("key" => "INCORRECT_COMP_DETECTION", "dsc" => "Incorrect compiler detection", "msg" => Array("could not configure a C compiler", "clang: not found", "clang++: not found"), "nb" => 0),
	Array("key" => "TESTSUITE_FAILED", "dsc" => "Testsuite is failing with clang", "msg" => Array("dh_auto_test: "), "nb" => 0),
        Array("key" => "APPLE_BLOCKS", "dsc" => "Source think that it is Mac Os X because of clang", "msg" => Array("blocks support disabled - compile with -fblocks or pick a deployment target "), "nb" => 0),

// General
        Array("key" => "NO_CAT", "dsc" => "Not categorized", "msg" => "", "nb" => 0),



        );

function get_number_errors_per_version($version, $keyGET)
{
// TODO moved to json
	$req="SELECT *, errors.package as package FROM errors LEFT JOIN bug_reports ON bug_reports.package=errors.package WHERE clang_version='{$version}' ";
	if ($keyGET == "NO_CAT") {
	   $keyGET="";
	}
	if ($keyGET!="all") {
	  $req.=" AND key_code='{$keyGET}'";
	}
	$result=mysql_query($req);
	return mysql_num_rows($result);
}

function parse_error($version)
{
    global $known_errors, $nbTotal, $totalFailed, $totalNbNotCat;

    $totalFailed=0;
    $totalNbNotCat=0;

    $req="SELECT * FROM errors WHERE clang_version='$version'";

    $result=mysql_query($req);
    $nbTotal=mysql_num_rows($result);

    while ($row = mysql_fetch_object($result)) {
        $set=false;
        $totalFailed++;
        get_key_clang($known_errors, $row->detected_error);
    }


    usort($known_errors, "cmp");
    return $known_errors;
}

function cmp($a, $b)
{
    return $a["nb"] < $b["nb"];
}

function get_key_clang(&$known_errors, $detected_error) {
    global $known_errors, $totalNbNotCat;

    foreach($known_errors as  $key => $err) {

        if (!is_array($err['msg'])) {  /* Several errors msgs can be attached to the same reason */
            $msg=Array($err['msg']);
        } else  {
            $msg=$err['msg'];
        }

        foreach($msg as $err2) {
            if ( strlen($err2)>0 && strpos($detected_error, $err2) !== FALSE)  {
                $known_errors[$key]["nb"]++;
//                $totalFailed++;
                $set=true;
                return $err['key'];
            }
        }
    }

    $lastPos=count($known_errors)-1;
    if ($known_errors[$lastPos]["key"]!="NO_CAT") {
        die("internal error. no_cat must be the last");
    }
    $known_errors[$lastPos]["nb"]++;
    $totalNbNotCat++;


}

function displayVersion($versionGET, $keyGET="") {
	 global $clangVersions;
	 
?>
<div align="right">Versions:
<?php
$nb=count($clangVersions);
$i=0;
foreach ($clangVersions as $version => $pkg) {
        $i++;
        if ($version==$versionGET) {
           echo "$version";
        }else{
	if ($keyGET) {
	   $urlEXT="&key={$keyGET}";
	}
                echo "<a href=\"/status.php?version={$version}{$urlEXT}\">$version</a> ";
        }
        if ($i < $nb) echo " - ";
}
?>
</div>
<?php
}

function resultClangDisplay($version, $display=true) {
    global $totalFailed, $clangVersions;

    $totalDebian=$clangVersions[$version];

    if (!$keyGET) {
        $errors=parse_error($version);
?>


<?=$totalDebian?> packages have been rebuild. Among them, <?=$totalFailed?> (<?=round($totalFailed*100/$totalDebian,1)?> %) failed.
<br />
Most of the errors are explained with test cases.
<?
if ($display) {
   displayVersion($version,"");
}
?>

<table class="data">
<tr><th>Type of error</th><th>Occurrence</th><th>clang % / Debian %</th><th></th></tr>
<?
foreach($errors as  $key => $err) {
                if ($err['nb']>0) {
            if ($err['key']!="NO_CAT") {

?>
    <tr><td><?=$err["dsc"]?> <?if (isset($err['new'])) { echo "<small> - new in " . $err['new'] . "</small>"; }?> </td>
<td><?=$err["nb"]?></td>
<td><?=round(100*$err["nb"]/$totalFailed,2)?>% / <?=round(100*$err["nb"]/$totalDebian,2)?>%</td>
<td><a href="status.php?version=<?=$version?>&key=<?=$err['key']?>">List of errors</a></td>
<? /* ?> 
 <td><?if (!is_file("errors/{$err['key']}.inc")) echo "no";?></td>
<? */ ?>
</tr>
<?
                    } else {
// Key the no cat stuff
                $key_NO_CAT=$key;
                $err_NO_CAT=$err;
                }
            }

}
?>
    <tr><td>Not categorized</td><td><?=$err_NO_CAT['nb']?></td>
<td><?=round(100*$err_NO_CAT['nb']/$totalFailed,2)?>% / <?=round(100*$err_NO_CAT['nb']/$totalDebian,2)?>%</td>
<td><a href="status.php?version=<?=$version?>&key=NO_CAT">List of errors</a></td>
</tr>
</table>
<?php
}
}
?>
