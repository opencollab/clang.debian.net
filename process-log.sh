#!/bin/bash

if test "$#" -ne 4; then
	echo "$0 ref results-rebuild results_dir clang_version target"
    echo "ex: bash -v process-log.sh res.unstable scanlog-8-2020-02-24 logs/2020-02-24-8 8"
	exit 1
fi
BASEDIR=$(pwd)
REF=$1
REF_REBUILD=$2
RESULTS=$(pwd)/$3
CLANG_VERSION=$4

if test ! -f $REF; then
    echo "Could not find $REF"
    exit 1
fi

if test ! -f $REF_REBUILD; then
    echo "Could not find $REF_REBUILD"
    exit 1
fi

LIST=$(grep " Failed " $REF |awk '{print $1}')
grep -v " OK " $2  > res.clang${CLANG_VERSION}.failed
for f in $LIST; do
    sed -i "/$f /d" res.clang${CLANG_VERSION}.failed
done
cd $RESULTS
LIST=$(awk '{print $1}' ../../res.clang${CLANG_VERSION}.failed)
rm -rf results/
mkdir results/
for f in $LIST; do
    F=$(ls "$f"_*log)
    echo "Copy of $F"
    cp "$F" results/
done
cd results
echo "if you are happy, run:"
echo "rm $(pwd)/../*"
echo "mv $(pwd)/* $(pwd)/../"
cqa-scanlogs > $BASEDIR/$REF_REBUILD
