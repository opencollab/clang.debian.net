# Ugly script to create the maintainers.txt file with links
# usage:
# bash -v generate-dd-list.sh 9.0.1 2020-02-24
VERSION=$1
DATE=$2
dd-list $(awk '{print $1}' scanlog-$VERSION-$DATE) > maintainers.txt

# Remove uploader symbol
sed -i -e "s| (U)$||g" maintainers.txt

# Remove email addresses
sed -i -e "s| <.*>$||g" maintainers.txt

LIST=$(grep "   " maintainers.txt)
for PKG in $LIST; do
    # Get the version. Without the epoch
    V=$(grep "^$PKG " scanlog-$VERSION-$DATE|awk '{print $2}'|cut -d: -f2)
    sed -i -e "s|^   $PKG\$|   <a href='/logs/$DATE-$VERSION/${PKG}_${V}_unstable_clang${VERSION}.log'>$PKG</a>|g" maintainers.txt
done

