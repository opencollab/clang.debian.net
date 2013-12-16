<pre class="failure">
template <int N> struct X {
  static const int value = X<N-1>::value;
};

template struct X<1000>;
</pre>