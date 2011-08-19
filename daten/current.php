<?

define( 'A_UTC', "<a title='UTC: koordinierte Weltzeit' href='http://de.wikipedia.org/wiki/UTC' target='_new'>UTC</a>" );

function vbar_graph( $data, $height, $caption = '' ) {
  echo " <table class='graph'>";
  if( $caption ) {
    printf( "<caption>%s</caption>", $caption );
  }

  echo "<tr>";
  foreach( $data as $d ) {
    $val = $d[ 1 ];
    $label = $d[ 2 ];
    if( $val === null ) {
      printf( "\n  <td class='vbar null' title='%s' style='height:$height;width:3px;' />", $label );
    } else {
      printf( "\n  <td class='vbar' title='%s' style='height:$height;width:3px;'>", $label );
      if( $val >= 1 ) {
        printf( "<img src='y.png' style='width:3px;height:%upx;' />" , $val );
      }
      printf( "</td>" );
    }
  }
  echo "\n</tr><tr>";
  $s = '';
  $last = '';
  foreach( $data as $d ) {
    if( $last == $d[ 0 ] ) {
      $colspan++;
    } else {
      if( $last ) {
        echo "<th class='vbar' colspan='$colspan'>$last</th>";
      }
      $last = $d[ 0 ];
      $colspan = 1;
    }
  }
  if( $last ) {
    echo "<th class='vbar' colspan='$colspan'>$last</th>";
  }
  echo "</tr>";
}


function day_graph( $Y, $m, $d, $caption = '' ) {
  $lines = file( "$Y/$m/$d.txt" );

  $data = array();
  $n = 0;
  foreach( $lines as $l ) {
    $f = explode( ' ', $l );
    $data[] = array( substr( $f[ 0 ], 0, 2 ), $f[ 2 ] / 300, sprintf( '%04uUTC: %u W', $f[0], $f[ 2 ] ) );
  }
  $t = $f[ 0 ];
  while( $t < 2355 ) {
    $t += 5;
    if( $t % 100 >= 60 ) {
      $t += 40;
    }
    $data[] = array( sprintf( '%02u', $t / 100 ), null, 'n/a' );
  }
  vbar_graph( $data, 96, $caption );
}



function daily_production( $Y, $m, $d ) {
  $path  = sprintf( "%04u/%02u/%02u.txt", $Y, $m, $d );
  if( is_readable( $path ) ) {
    $lines = file( $path );
    $f1 = explode( ' ', $lines[ 0 ] );
    $f2 = explode( ' ', $lines[ count($lines) - 1 ] );
    return $f2[ 1 ] - $f1[ 1 ];
  } else {
    return false;
  }
}





echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">

<html>
<head>
  <title>UniSolar Daten</title>
  <style type='text/css'>
    body, div, caption, th, span {
      font-size:10pt;
      font-family:arial,sans-serif;
    }
    table.graph {
      padding:0pt;
      margin:0pt;
      border-collapse:collapse !important;
      empty-cells:show !important;
    }
    table.graph td.hbar {
      background-color:#0000ff;
      text-align:left;
    }
    table.graph td.hbar img.hbar {
      height:4px !important;
      width:1px;
    }
    table.graph th.vbar {
      font-size:10pt;
      font-family:arial,sans-serif;
      border:1px solid black;
    }
    table.graph td.vbar {
      padding:0pt;
      margin:0pt;
      background-color:#3355bb;
      text-align:left;
      vertical-align:bottom;
    }
    table.graph td.vbar.null {
      background-color:#bbbbbb;
    }
    #timer {
      background-image:url(gray.png);
      background-repeat:repeat-y;
    }
  </style>
</head>
<body>
";


  $now = explode( ',' , date( 'Y,m,d,H,i,s' ) );
  $year = $now[0];
  $month = $now[1];
  $day = $now[2];
  $hour = $now[3];

  $caption = "
    <div style='text-align:center;font-size:12pt;'>Photovoltaik-Anlage Haus 6, Campus Golm
    <span style='padding:0px 1em 0px 1em;'>---</span>
    <a target='_new' href='roof.php'>Detailansicht...</a></div>
  ";
  $caption .= "<div id='timer' style='text-align:center;'>";
  // $gt = file( 'grandtotal' );
  //   if( count( $gt ) == 1 )
  //     $gt = $gt[0];
  //   else
  //     $gt = false;
  $lines = file( 'last' );
  if( count( $lines ) == 4 ) {
    $caption .= sprintf( "<span>Ablesung %s%s:</span>", $lines[ 0 ], A_UTC );
    $caption .= sprintf( "<span style='padding-left:3em;padding-right:3em;'>Leistung: %s</span>", $lines[ 1 ] );
    sscanf( $lines[ 1 ], '%f %s', & $power, & $power_unit );

    $lp_lines = file( 'last_production' );
    sscanf( $lp_lines[0], '%d', & $lp );
    if( $lp >= ( $year * 100 + $month ) * 100 + $day ) {
      sscanf( $lines[ 2 ], '%f %s', & $work_today, & $work_today_unit );
    } else {
      $work_today = 'n/a';
      $work_today_unit = '';
    }
    $caption .= sprintf( "<span>Arbeit heute: %s %s", $work_today, $work_today_unit );

    sscanf( $lines[ 3 ], '%f %s', & $gt, & $gt_unit );
    switch( $gt_unit ) {
      case 'kWh':
        $gt /= 1000;
      case 'MWh':
        $caption .= sprintf( " / seit Inbetriebnahme: %.2f MWh", $gt );
        break;
      default:
        break;
    }
    $caption .= "</span>";
  } else {
    $caption .= '(Echtzeit-Daten nicht verf&uuml;gbar';
  }
  $caption .= '</div>';

//   $lines = file( 'last' );
//   $f = explode( ' ', $lines[0] );
//   $today = daily_production( $year, $month, $day );
//   if( $today === false )
//     $today = 'n/a';
//   else
//     $today = sprintf( '%u', $today * 1000.1 );
//   $caption = sprintf( "<span> Zeit: %sUTC </span>", $f[ 0 ] );
//   $caption .= sprintf( "<span style='padding-left:4em;padding-right:2em;'>Produktion aktuell: %u W </span>", $f[ 2 ] );
//   if( 0 * $today > 0 ) {
//     $caption .= sprintf( "<span style='padding-left:2em;padding-right:2em;'>Produktion heute: %u kWh </span>", $today );
//   }
//   $caption .= sprintf( "<span>gesamt seit Inbetriebnahme: %.2f MWh </span>", $f[ 1 ] );

  day_graph( $year, $month, $day, $caption );


if( ! getenv('robot') ) {
  $urandom_handle = fopen( '/dev/urandom', 'r' );
  $url = "http://unisolar.qipc.org/daten/current.php?nonce=";
  for( $bytes = 8; $bytes > 0; $bytes-- ) {
    $c = fgetc( $urandom_handle );
    $url .= sprintf( '%02x', ord( $c ) );
  }
  echo "
    <script type='text/javascript'>
      var d = new Date();
      var n = d.getTime();
      var ticks = 1200;
      function rl() {
        if( ticks-- > 0 ) {
          document.getElementById('timer').style.backgroundPosition = ( 0.833 * ticks ) / 10 + '% 0px';
          setTimeout( 'rl()', 50 );
        } else {
          self.location.href = '$url';
        }
      }
      setTimeout( 'rl()', 50 );
    </script>
  ";
}

echo "</body></html>";

?>
