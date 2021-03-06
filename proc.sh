#!/bin/sh

echo "source,target" > cache/tmp$1.edges
for file in cache/friendsrelation$1-*.json
do
cat $file| sed 's/},{/\n/g'| sed 's/\[{//g' | sed 's/}\]//g' | sed -n 's/"are_friends":1,"uid2":\([0-9]*\),"uid1":\([0-9]*\)/\1,\2/p' >> cache/tmp$1.edges
done

echo "uid,sex,name" > cache/tmp$1.nodes
cat cache/friendsinfo$1.json| sed 's/},{/\n/g' | sed 's/\[{//g' | sed 's/}\]//g' | sed 's/"uid":\([0-9]*\),"sex":\([01]\),"name":"\(.*\)"/\1,\2,\3/p' -n >> cache/tmp$1.nodes

