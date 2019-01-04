#!/bin/sh

oldpwd=$(pwd)
nodename="node-v10.15.0-linux-x64"

cd /tmp
curl -O "https://nodejs.org/dist/v10.15.0/$nodename.tar.xz" || exit 1
tar -xf "$nodename.tar.xz" || exit 1
cd "$nodename"
cp -R bin/ include/ lib/ share/ /usr/local/ || exit 1

echo "##### Installed node #####"
which node
which npm
echo "#####"

npm -g config set user root

npm install -g \
    uglify-js \
    uglifycss \
    node-sass

cd "$oldpwd"

