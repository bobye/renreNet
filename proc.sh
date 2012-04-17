#!/bin/sh


cat cache/friendsrelation.json| sed 's/},{/\n/g'| sed 's/\[{//g' | sed 's/}\]//g'>  cache/tmp.txt
echo "source,target" > cache/tmp.edges
cat cache/tmp.txt | sed -n 's/"are_friends":1,"uid2":\([0-9]*\),"uid1":\([0-9]*\)/\1,\2/p' >> cache/tmp.edges

cat cache/friendsinfo.json| sed 's/},{/\n/g' | sed 's/\[{//g' | sed 's/}\]//g' > cache/tmp.txt 
echo "uid,sex,name" > cache/tmp.nodes
cat cache/tmp.txt | sed 's/"uid":\([0-9]*\),"sex":\([01]\),"name":"\(.*\)"/\1,\2,\3/p' -n >> cache/tmp.nodes
