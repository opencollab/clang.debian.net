#!/bin/sh
for f in scanlog-*; do
	VERSION=$(echo $f|cut -d- -f2)
	DATE=$(echo $f|cut -d- -f3-)
	./insert.php $VERSION $DATE;
done

