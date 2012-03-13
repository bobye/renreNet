#!/bin/sh

cat cache/friendsrelation.txt| sed 's/},{/\n/g'| sed 's/\[{//g' | sed 's/}\]//g'>  cache/tmp.txt

cat cache/tmp.txt | sed -n 's/"are_friends":1,"uid2":\([0-9]*\),"uid1":\([0-9]*\)/\1 \2/p' > cache/tmp.edges
