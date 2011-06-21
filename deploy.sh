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
chmod 600 monitoring/FTPD.tmp
chmod 700 monitoring/json.download
chmod 600 monitoring/channels
chmod 600 monitoring/out
chmod 600 monitoring/FTPD.tmp.old
chmod 600 monitoring/download.log
chmod 700 monitoring/j
chmod 600 monitoring/passwd
chmod 600 monitoring/sample
chmod 700 monitoring/zip
chmod 600 monitoring/zip/2011-06-20_131000.xml
chmod 600 monitoring/zip/2011-06-20_130000.xml
chmod 600 monitoring/zip/2011-06-20_130500.xml
chmod 600 monitoring/zip/2011-06-20_130000.zip
chmod 755 daten
chmod 644 daten/roof.php
chmod 644 daten/d2.php
chmod 755 daten/2old
chmod 644 daten/2old/20110427.csv
chmod 644 daten/2old/20110604.csv
chmod 644 daten/2old/20110513.csv
chmod 644 daten/2old/20110508.csv
chmod 644 daten/2old/20110514.csv
chmod 644 daten/2old/20110424.csv
chmod 644 daten/2old/20110612.csv
chmod 644 daten/2old/20110518.csv
chmod 644 daten/2old/20110421.csv
chmod 644 daten/2old/20110422.csv
chmod 644 daten/2old/20110525.csv
chmod 644 daten/2old/20110601.csv
chmod 644 daten/2old/20110509.csv
chmod 644 daten/2old/20110506.csv
chmod 644 daten/2old/20110419.csv
chmod 644 daten/2old/20110529.csv
chmod 644 daten/2old/20110505.csv
chmod 644 daten/2old/20110528.csv
chmod 644 daten/2old/20110530.csv
chmod 644 daten/2old/20110607.csv
chmod 644 daten/2old/20110516.csv
chmod 644 daten/2old/20110608.csv
chmod 644 daten/2old/20110522.csv
chmod 644 daten/2old/20110515.csv
chmod 644 daten/2old/20110507.csv
chmod 644 daten/2old/20110517.csv
chmod 644 daten/2old/20110606.csv
chmod 644 daten/2old/20110504.csv
chmod 644 daten/2old/20110526.csv
chmod 644 daten/2old/20110429.csv
chmod 644 daten/2old/20110610.csv
chmod 644 daten/2old/20110524.csv
chmod 644 daten/2old/20110531.csv
chmod 644 daten/2old/20110501.csv
chmod 644 daten/2old/20110426.csv
chmod 644 daten/2old/20110527.csv
chmod 644 daten/2old/20110420.csv
chmod 644 daten/2old/20110511.csv
chmod 644 daten/2old/20110425.csv
chmod 644 daten/2old/20110512.csv
chmod 644 daten/2old/20110520.csv
chmod 644 daten/2old/20110602.csv
chmod 644 daten/2old/20110519.csv
chmod 644 daten/2old/20110603.csv
chmod 644 daten/2old/20110502.csv
chmod 644 daten/2old/20110609.csv
chmod 644 daten/2old/20110430.csv
chmod 644 daten/2old/20110605.csv
chmod 644 daten/2old/20110423.csv
chmod 644 daten/2old/20110521.csv
chmod 644 daten/2old/20110611.csv
chmod 644 daten/2old/20110428.csv
chmod 644 daten/2old/20110510.csv
chmod 644 daten/2old/20110523.csv
chmod 644 daten/2old/20110503.csv
chmod 644 daten/current.php
chmod 600 daten/c
chmod 600 daten/1current.php
chmod 644 daten/c2.php
chmod 644 daten/gray.png
chmod 644 daten/last_production
chmod 755 daten/2011
chmod 755 daten/2011/05
chmod 644 daten/2011/05/01.first
chmod 644 daten/2011/05/12.txt
chmod 644 daten/2011/05/05.last
chmod 644 daten/2011/05/08.last
chmod 644 daten/2011/05/raw.20110514.csv
chmod 644 daten/2011/05/07.txt
chmod 644 daten/2011/05/raw.20110517.csv
chmod 644 daten/2011/05/03.first
chmod 644 daten/2011/05/05.txt
chmod 644 daten/2011/05/raw.20110502.csv
chmod 644 daten/2011/05/07.last
chmod 644 daten/2011/05/17.first
chmod 644 daten/2011/05/raw.20110515.csv
chmod 644 daten/2011/05/19.txt
chmod 644 daten/2011/05/17.last
chmod 644 daten/2011/05/02.last
chmod 644 daten/2011/05/30.first
chmod 644 daten/2011/05/16.last
chmod 644 daten/2011/05/28.first
chmod 644 daten/2011/05/20.last
chmod 644 daten/2011/05/08.txt
chmod 644 daten/2011/05/23.last
chmod 644 daten/2011/05/06.txt
chmod 644 daten/2011/05/06.first
chmod 644 daten/2011/05/raw.20110526.csv
chmod 644 daten/2011/05/15.txt
chmod 644 daten/2011/05/25.first
chmod 644 daten/2011/05/23.first
chmod 644 daten/2011/05/12.first
chmod 644 daten/2011/05/16.txt
chmod 644 daten/2011/05/04.txt
chmod 644 daten/2011/05/21.last
chmod 644 daten/2011/05/09.first
chmod 644 daten/2011/05/raw.20110506.csv
chmod 644 daten/2011/05/raw.20110516.csv
chmod 644 daten/2011/05/29.last
chmod 644 daten/2011/05/25.last
chmod 644 daten/2011/05/05.first
chmod 644 daten/2011/05/raw.20110513.csv
chmod 644 daten/2011/05/11.first
chmod 644 daten/2011/05/31.first
chmod 644 daten/2011/05/raw.20110507.csv
chmod 644 daten/2011/05/26.first
chmod 644 daten/2011/05/raw.20110529.csv
chmod 644 daten/2011/05/03.txt
chmod 644 daten/2011/05/24.txt
chmod 644 daten/2011/05/22.txt
chmod 644 daten/2011/05/15.last
chmod 644 daten/2011/05/10.last
chmod 644 daten/2011/05/28.last
chmod 644 daten/2011/05/22.last
chmod 644 daten/2011/05/13.first
chmod 644 daten/2011/05/03.last
chmod 644 daten/2011/05/raw.20110509.csv
chmod 644 daten/2011/05/raw.20110524.csv
chmod 644 daten/2011/05/31.txt
chmod 644 daten/2011/05/31.last
chmod 644 daten/2011/05/24.last
chmod 644 daten/2011/05/21.first
chmod 644 daten/2011/05/14.last
chmod 644 daten/2011/05/14.first
chmod 644 daten/2011/05/27.first
chmod 644 daten/2011/05/18.txt
chmod 644 daten/2011/05/10.txt
chmod 644 daten/2011/05/21.txt
chmod 644 daten/2011/05/raw.20110511.csv
chmod 644 daten/2011/05/09.txt
chmod 644 daten/2011/05/raw.20110504.csv
chmod 644 daten/2011/05/22.first
chmod 644 daten/2011/05/01.last
chmod 644 daten/2011/05/14.txt
chmod 644 daten/2011/05/raw.20110501.csv
chmod 644 daten/2011/05/13.txt
chmod 644 daten/2011/05/20.first
chmod 644 daten/2011/05/25.txt
chmod 644 daten/2011/05/02.txt
chmod 644 daten/2011/05/08.first
chmod 644 daten/2011/05/raw.20110518.csv
chmod 644 daten/2011/05/raw.20110523.csv
chmod 644 daten/2011/05/13.last
chmod 644 daten/2011/05/12.last
chmod 644 daten/2011/05/29.txt
chmod 644 daten/2011/05/23.txt
chmod 644 daten/2011/05/09.last
chmod 644 daten/2011/05/04.first
chmod 644 daten/2011/05/16.first
chmod 644 daten/2011/05/10.first
chmod 644 daten/2011/05/raw.20110525.csv
chmod 644 daten/2011/05/raw.20110530.csv
chmod 644 daten/2011/05/raw.20110505.csv
chmod 644 daten/2011/05/raw.20110519.csv
chmod 644 daten/2011/05/raw.20110508.csv
chmod 644 daten/2011/05/raw.20110521.csv
chmod 644 daten/2011/05/raw.20110531.csv
chmod 644 daten/2011/05/raw.20110527.csv
chmod 644 daten/2011/05/18.first
chmod 644 daten/2011/05/raw.20110512.csv
chmod 644 daten/2011/05/19.first
chmod 644 daten/2011/05/02.first
chmod 644 daten/2011/05/24.first
chmod 644 daten/2011/05/01.txt
chmod 644 daten/2011/05/11.txt
chmod 644 daten/2011/05/raw.20110522.csv
chmod 644 daten/2011/05/raw.20110510.csv
chmod 644 daten/2011/05/20.txt
chmod 644 daten/2011/05/28.txt
chmod 644 daten/2011/05/29.first
chmod 644 daten/2011/05/raw.20110520.csv
chmod 644 daten/2011/05/30.last
chmod 644 daten/2011/05/raw.20110528.csv
chmod 644 daten/2011/05/19.last
chmod 644 daten/2011/05/26.txt
chmod 644 daten/2011/05/27.txt
chmod 644 daten/2011/05/18.last
chmod 644 daten/2011/05/07.first
chmod 644 daten/2011/05/27.last
chmod 644 daten/2011/05/11.last
chmod 644 daten/2011/05/raw.20110503.csv
chmod 644 daten/2011/05/26.last
chmod 644 daten/2011/05/15.first
chmod 644 daten/2011/05/04.last
chmod 644 daten/2011/05/30.txt
chmod 644 daten/2011/05/06.last
chmod 644 daten/2011/05/17.txt
chmod 755 daten/2011/04
chmod 644 daten/2011/04/raw.20110420.csv
chmod 644 daten/2011/04/raw.20110419.csv
chmod 644 daten/2011/04/19.txt
chmod 644 daten/2011/04/raw.20110427.csv
chmod 644 daten/2011/04/30.first
chmod 644 daten/2011/04/28.first
chmod 644 daten/2011/04/20.last
chmod 644 daten/2011/04/23.last
chmod 644 daten/2011/04/25.first
chmod 644 daten/2011/04/23.first
chmod 644 daten/2011/04/21.last
chmod 644 daten/2011/04/29.last
chmod 644 daten/2011/04/25.last
chmod 644 daten/2011/04/26.first
chmod 644 daten/2011/04/24.txt
chmod 644 daten/2011/04/22.txt
chmod 644 daten/2011/04/28.last
chmod 644 daten/2011/04/22.last
chmod 644 daten/2011/04/raw.20110430.csv
chmod 644 daten/2011/04/24.last
chmod 644 daten/2011/04/21.first
chmod 644 daten/2011/04/27.first
chmod 644 daten/2011/04/21.txt
chmod 644 daten/2011/04/22.first
chmod 644 daten/2011/04/20.first
chmod 644 daten/2011/04/25.txt
chmod 644 daten/2011/04/29.txt
chmod 644 daten/2011/04/23.txt
chmod 644 daten/2011/04/raw.20110425.csv
chmod 644 daten/2011/04/raw.20110424.csv
chmod 644 daten/2011/04/raw.20110422.csv
chmod 644 daten/2011/04/19.first
chmod 644 daten/2011/04/raw.20110426.csv
chmod 644 daten/2011/04/24.first
chmod 644 daten/2011/04/raw.20110429.csv
chmod 644 daten/2011/04/20.txt
chmod 644 daten/2011/04/28.txt
chmod 644 daten/2011/04/29.first
chmod 644 daten/2011/04/30.last
chmod 644 daten/2011/04/19.last
chmod 644 daten/2011/04/26.txt
chmod 644 daten/2011/04/27.txt
chmod 644 daten/2011/04/raw.20110421.csv
chmod 644 daten/2011/04/27.last
chmod 644 daten/2011/04/raw.20110423.csv
chmod 644 daten/2011/04/26.last
chmod 644 daten/2011/04/raw.20110428.csv
chmod 644 daten/2011/04/30.txt
chmod 755 daten/2011/06
chmod 644 daten/2011/06/01.first
chmod 644 daten/2011/06/12.txt
chmod 600 daten/2011/06/2011-06-21_054500.xml
chmod 644 daten/2011/06/raw.20110608.csv
chmod 644 daten/2011/06/raw.20110607.csv
chmod 644 daten/2011/06/05.last
chmod 644 daten/2011/06/08.last
chmod 644 daten/2011/06/07.txt
chmod 644 daten/2011/06/03.first
chmod 644 daten/2011/06/05.txt
chmod 644 daten/2011/06/07.last
chmod 644 daten/2011/06/17.first
chmod 644 daten/2011/06/19.txt
chmod 644 daten/2011/06/17.last
chmod 644 daten/2011/06/02.last
chmod 644 daten/2011/06/16.last
chmod 644 daten/2011/06/20.last
chmod 644 daten/2011/06/08.txt
chmod 644 daten/2011/06/06.txt
chmod 644 daten/2011/06/06.first
chmod 644 daten/2011/06/15.txt
chmod 644 daten/2011/06/12.first
chmod 644 daten/2011/06/16.txt
chmod 644 daten/2011/06/04.txt
chmod 644 daten/2011/06/21.last
chmod 644 daten/2011/06/09.first
chmod 644 daten/2011/06/raw.20110617.csv
chmod 644 daten/2011/06/raw.20110605.csv
chmod 644 daten/2011/06/05.first
chmod 644 daten/2011/06/11.first
chmod 644 daten/2011/06/raw.20110618.csv
chmod 644 daten/2011/06/raw.20110616.csv
chmod 644 daten/2011/06/03.txt
chmod 644 daten/2011/06/raw.20110603.csv
chmod 644 daten/2011/06/raw.20110614.csv
chmod 644 daten/2011/06/raw.20110619.csv
chmod 644 daten/2011/06/raw.20110615.csv
chmod 644 daten/2011/06/15.last
chmod 644 daten/2011/06/10.last
chmod 644 daten/2011/06/raw.20110621.csv
chmod 644 daten/2011/06/13.first
chmod 644 daten/2011/06/03.last
chmod 644 daten/2011/06/21.first
chmod 644 daten/2011/06/14.last
chmod 644 daten/2011/06/14.first
chmod 644 daten/2011/06/raw.20110612.csv
chmod 644 daten/2011/06/raw.20110613.csv
chmod 644 daten/2011/06/18.txt
chmod 644 daten/2011/06/10.txt
chmod 644 daten/2011/06/21.txt
chmod 644 daten/2011/06/09.txt
chmod 644 daten/2011/06/01.last
chmod 644 daten/2011/06/14.txt
chmod 644 daten/2011/06/raw.20110604.csv
chmod 644 daten/2011/06/raw.20110601.csv
chmod 644 daten/2011/06/13.txt
chmod 644 daten/2011/06/20.first
chmod 644 daten/2011/06/02.txt
chmod 644 daten/2011/06/08.first
chmod 644 daten/2011/06/13.last
chmod 644 daten/2011/06/12.last
chmod 644 daten/2011/06/09.last
chmod 644 daten/2011/06/04.first
chmod 644 daten/2011/06/16.first
chmod 644 daten/2011/06/10.first
chmod 644 daten/2011/06/raw.20110602.csv
chmod 644 daten/2011/06/18.first
chmod 644 daten/2011/06/raw.20110609.csv
chmod 644 daten/2011/06/19.first
chmod 644 daten/2011/06/02.first
chmod 644 daten/2011/06/01.txt
chmod 644 daten/2011/06/11.txt
chmod 644 daten/2011/06/raw.20110620.csv
chmod 644 daten/2011/06/20.txt
chmod 644 daten/2011/06/raw.20110606.csv
chmod 644 daten/2011/06/19.last
chmod 644 daten/2011/06/raw.20110610.csv
chmod 644 daten/2011/06/raw.20110611.csv
chmod 644 daten/2011/06/18.last
chmod 644 daten/2011/06/07.first
chmod 644 daten/2011/06/11.last
chmod 644 daten/2011/06/15.first
chmod 644 daten/2011/06/04.last
chmod 644 daten/2011/06/06.last
chmod 644 daten/2011/06/17.txt
chmod 755 daten/old
chmod 600 daten/old/20110324.csv
chmod 600 daten/old/20110323.csv
chmod 600 daten/old/20110409.csv
chmod 600 daten/old/20110316.csv
chmod 600 daten/old/20110412.csv
chmod 600 daten/old/20110408.csv
chmod 600 daten/old/20110404.csv
chmod 600 daten/old/20110317.csv
chmod 600 daten/old/20110319.csv
chmod 600 daten/old/20110318.csv
chmod 600 daten/old/20110326.csv
chmod 600 daten/old/20110413.csv
chmod 600 daten/old/20110405.csv
chmod 600 daten/old/20110401.csv
chmod 600 daten/old/20110327.csv
chmod 600 daten/old/20110417.csv
chmod 600 daten/old/20110322.csv
chmod 600 daten/old/20110402.csv
chmod 600 daten/old/20110415.csv
chmod 600 daten/old/20110321.csv
chmod 600 daten/old/20110320.csv
chmod 600 daten/old/20110330.csv
chmod 600 daten/old/20110411.csv
chmod 600 daten/old/20110331.csv
chmod 600 daten/old/20110329.csv
chmod 600 daten/old/20110406.csv
chmod 600 daten/old/20110325.csv
chmod 600 daten/old/20110416.csv
chmod 600 daten/old/20110414.csv
chmod 600 daten/old/20110418.csv
chmod 600 daten/old/20110407.csv
chmod 600 daten/old/20110328.csv
chmod 600 daten/old/20110403.csv
chmod 644 daten/lens.php
chmod 777 daten/yellow.png
chmod 777 daten/last
chmod 644 daten/d.php
chmod 644 daten/grandtotal
chmod 777 daten/y.png
chmod 700 .git
