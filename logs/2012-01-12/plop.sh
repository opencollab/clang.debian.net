FULLLIST=$(ls -1 |cut -d_ -f1|sort -u|grep -v plop)
for f in $FULLLIST; do
	nbLog=$(ls "$f"_*|wc -l)
	if test $nbLog -gt 2; then
		echo "$f"
	fi

done

