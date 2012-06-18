#!/bin/sh
#
# this file is generated - do not modify!
#

export LANG=C
BRANCH=`git branch | sed -e '/^[^*]/d' -e 's/^\* \(.*\)/\1/'`
COMMIT=`git rev-parse --short HEAD`
COMMIT_FULL=`git rev-parse HEAD`
DIRTY=""
git status | grep -qF 'working directory clean' || DIRTY='-dirty'
echo "<a href='http://github.com/timof/unisolar/commits/$COMMIT_FULL'>$BRANCH-$COMMIT$DIRTY</a>" >version.txt

chmod 700 monitoring
chmod 600 monitoring/exp
chmod 700 monitoring/csv.download
chmod 700 monitoring/xml.download
chmod 700 monitoring/fix
chmod 700 monitoring/json.download
chmod 600 monitoring/channels
chmod 600 monitoring/t
chmod 600 monitoring/out
chmod 644 monitoring/csv.out
chmod 600 monitoring/1csv.download
chmod 700 monitoring/j
chmod 600 monitoring/passwd
chmod 600 monitoring/references.php
chmod 600 monitoring/sample
chmod 700 monitoring/zip
chmod 600 monitoring/zip/2011-06-20_131000.xml
chmod 600 monitoring/zip/2011-06-20_130000.xml
chmod 600 monitoring/zip/2011-06-20_130500.xml
chmod 600 monitoring/zip/2011-06-20_130000.zip
chmod 644 monitoring/csv.tmp
chmod 755 daten
chmod 644 daten/roof.php
chmod 644 daten/d2.php
chmod 644 daten/.first
chmod 644 daten/current.php
chmod 600 daten/c
chmod 600 daten/1current.php
chmod 644 daten/c2.php
chmod 644 daten/1roof.php
chmod 644 daten/gray.png
chmod 644 daten/last_production
chmod 644 daten/bla
chmod 700 daten/deploy.sh
chmod 644 daten/.last
chmod 644 daten/c.php
chmod 644 daten/lens.php
chmod 777 daten/yellow.png
chmod 777 daten/last
chmod 644 daten/d.php
chmod 644 daten/grandtotal
chmod 777 daten/y.png
chmod 600 daten/version.txt
chmod 700 .git
