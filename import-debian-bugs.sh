#!/bin/bash
cd /tmp/
URL="https://bugs.debian.org/cgi-bin/pkgreport.cgi?tag=clang-ftbfs;users=pkg-llvm-team@lists.alioth.debian.org;archive=both;"
lynx -dump -nolist $URL > foo.txt
cat foo.txt|grep '^[[:space:]]*\* #' |sed -e "s|src:||g" -e "s|.*\* #\(.*\) \[.*\] \[\(.*\)\].*|REPLACE INTO bug_reports(bug_number, package, bug_type) VALUES ('\1', '\2', 'debian');|g" > sql.txt
mysql -u clang -p__+45c--lang___ clang  < sql.txt


URL_FIXED="https://bugs.debian.org/cgi-bin/pkgreport.cgi?archive=both;include=pending%3Adone;tag=clang-ftbfs;users=pkg-llvm-team@lists.alioth.debian.org;"
lynx -dump -nolist $URL_FIXED > foo.txt
cat foo.txt|grep '^[[:space:]]*\* #' |sed -e "s|src:||g" -e "s|.*\* #\(.*\) \[.*\] \[\(.*\)\].*|REPLACE INTO bug_reports(bug_number, package, bug_type, status) VALUES ('\1', '\2', 'debian', 'resolved');|g" > sql.txt
mysql -u clang -p__+45c--lang___ clang  < sql.txt

rm -f foo.txt sql.txt
