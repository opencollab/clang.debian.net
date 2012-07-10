This is a difference of interpretation between gcc and clang.<br />
See <a href="http://gcc.gnu.org/bugzilla/show_bug.cgi?id=52136">gcc bug#52136</a> and
<a href="http://llvm.org/bugs/show_bug.cgi?id=6840">clang bug #6840</a>.

<pre class="failure">
class address 
{
protected:
    static int parseNext(int a);
};


class mailbox : public address
{
    friend class mailboxField;
};

class mailboxField
{
    void parse(int a)
        {
            address::parseNext(a);
            // will work with:
            // mailbox::parseNext(a);
        }
};
</pre>


clang will fail with:
<pre class="failure">
$  clang++    -c mailboxField.cpp   
mailboxField.cpp:18:22: error: 'parseNext' is a protected member of 'address'
            address::parseNext(a);
                     ^
mailboxField.cpp:5:16: note: declared protected here
    static int parseNext(int a);
               ^
1 error generated.
</pre>