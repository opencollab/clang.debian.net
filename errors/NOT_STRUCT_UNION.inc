The following use case is failing with clang while working with g++
<pre class="failure">
template<typename Container>
struct ContTokenizer
{
    typedef typename Container::const_iterator const_iterator;

    ContTokenizer(Container* cont)
        {
            cont.begin();
        }
};
</pre>