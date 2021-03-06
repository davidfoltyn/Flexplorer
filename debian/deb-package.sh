#!/bin/bash
cd ..

PACKAGE=`cat composer.json | grep '"name"' | head -n 1 |  awk -F'"' '{print $4}' | awk -F'/' '{print $2}'`
VERSION=`cat composer.json | grep version | awk -F'"' '{print $4}'`
REVISION=`cat debian/revision | perl -ne 'chomp; print join(".", splice(@{[split/\./,$_]}, 0, -1), map {++$_} pop @{[split/\./,$_]}), "\n";'`
CHANGES=`git log -n 1 | tail -n+5`
dch -b -v $VERSION-$REVISION --package $PACKAGE $CHANGES

sed -i '/"version":/c\    "version": "'$VERSION.$REVISION'",' debian/conf/composer.json

debuild -i -us -uc -b


LASTVERSION=`cat debian/lastversion`
if [ $LASTVERSION == $VERSION  ];
then
    echo $REVISION > debian/revision
else
    echo 0 > debian/revision
    echo $VERSION > debian/lastversion
fi

rm -rf debian/$PACKAGE

cd ..
ls *.deb

#~/bin/publish-deb-packages.sh
