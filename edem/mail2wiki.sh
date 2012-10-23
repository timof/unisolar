#!/bin/bash

cd /t/unisolar/kongress.edemokratie
cat > teilnehmerliste.txt <<EOF
----
[[:start]] * [[unisolar:kongress_energiedemokratie]] * [[unisolar:teilnehmerliste]]


\\\\ 
\\\\ 
**Diese Datei wird automatisch erzeugt und bei Eingang einer Anmeldung ueberschrieben - bitte nicht manuell edieren!**
\\\\ 
\\\\ 

Download: {{:unisolar:teilnehmerliste.csv|}}

\\\\ 

^ Anrede ^ Vorname ^ Name ^ Strasse ^ PLZ ^ Ort ^ email ^ ^ Vormittag 1 ^^^ ^ Vormittag 2 ^^^ ^ Nachmittag 1 ^^^  ^ Nachmittag 2 ^^^^ ^ Anmerkung ^
EOF
echo -n > teilnehmerliste.csv

for f in anmeldung.????????.?????? ; do

  msg=`sed -e '/^\(Vor\|Nach\)mittagsworkshops /s/ /_/' -e 's&<br />$&&' -e 's/^Stra..e, Nr./Strasse/' < $f`
  anrede=
  vorname=
  name=
  strasse=
  plz=
  ort=
  vormittag1=
  nachmittag1=
  vormittag2=
  nachmittag2=
  anmerkung=
  checkv11=-
  checkv12=-
  checkv13=-
  checkv21=-
  checkv22=-
  checkv23=-
  checkn11=-
  checkn12=-
  checkn13=-
  checkn21=-
  checkn22=-
  checkn23=-
  checkn24=-
  while read tag dash reminder ; do
    [ "$dash" = '-' ] || continue
    value=`echo "$reminder" | sed 's&/<br />&&'`
    case "$tag" in
      Anrede )
        anrede="$value"
      ;;
      Vorname )
        vorname="$value"
      ;;
      Name )
        name="$value"
      ;;
      Stra??e )
        strasse="$value"
      ;;
      PLZ )
        plz="$value"
      ;;
      Ort )
        ort="$value"
      ;;
      E-Mail )
        email="$value"
      ;;
      Vormittagsworkshops_1.Phase )
        vormittag1="$value"
      ;;
      Vormittagsworkshops_2.Phase )
        vormittag2="$value"
      ;;
      Nachmittagsworkshops_1.Phase )
        nachmittag1="$value"
      ;;
      Nachmittagsworkshops_2.Phase )
        nachmittag2="$value"
      ;;
      Anmerkung )
        anmerkung="$value"
      ;;
    esac
  done < <(echo "$msg")
  case "$vormittag1" in
    *Erneuerbare* )
       checkv11=X
    ;;
    *Arbeitsrecht* )
       checkv12=X
    ;;
    *Kommunaler* )
       checkv13=X
    ;;
  esac
  case "$vormittag2" in
    *Windenergie* )
       checkv21=X
    ;;
    *Datenschutz* )
       checkv22=X
    ;;
    *Exkurs* )
       checkv23=X
    ;;
  esac
  case "$nachmittag1" in
    *Entwicklungsmotor* )
       checkn11=X
    ;;
    *Energiecluster* )
       checkn12=X
    ;;
    *TRIPLEX* )
       checkn13=X
    ;;
  esac
  case "$nachmittag2" in
    *Energiearmut* )
       checkn21=X
    ;;
    *Alternative* )
       checkn22=X
    ;;
    *Stadtwerk* )
       checkn23=X
    ;;
    *KulturEnergieBunkerAltona* )
       checkn24=X
    ;;
  esac
  echo "$anrede,$vorname,$name,$strasse,$plz,$ort,$email,$vormittag1,$vormittag2,$nachmittag1,$nachmittag2" >> teilnehmerliste.csv
  echo "|  $anrede  |  $vorname  |  $name  |  $strasse  |  $plz  |  $ort  |  $email  |  |  $checkv11  |  $checkv12  |  $checkv13  | |  $checkv21  |  $checkv22  |  $checkv23  | |  $checkn11  |  $checkn12  |  $checkn13  | |  $checkn21  |  $checkn22  |  $checkn23  |  $checkn24  | |  $anmerkung  | " >> teilnehmerliste.txt
done

scp teilnehmerliste.csv root@selene:/Users/unisolar/wiki/data/media/unisolar
scp teilnehmerliste.txt root@selene:/Users/unisolar/wiki/data/pages/unisolar

