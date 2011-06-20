<?php

define( 'A_UTC', "<a title='UTC: koordinierte Weltzeit' href='http://de.wikipedia.org/wiki/UTC' target='_new'>UTC</a>" );

global $jlf_urandom_handle;
$jlf_urandom_handle = false;

function random_hex_string( $bytes ) {
  global $jlf_urandom_handle;
  if( ! $jlf_urandom_handle )
    $jlf_urandom_handle = fopen( '/dev/urandom', 'r' );
  $s = '';
  while( $bytes > 0 ) {
    $c = fgetc( $jlf_urandom_handle );
    $s .= sprintf( '%02x', ord($c) );
    $bytes--;
  }
  return $s;
}

function inlink( $change = array(), $amp = '&amp;' ) {
  $nonce = random_hex_string( 8 );
  $reself = "lens.php?nonce=$nonce{$amp}string=".$GLOBALS['string'];
  if( $change === 'current' ) {
    return $reself;
  } else {
    $Y = ( isset( $change['Y'] ) ? $change['Y'] : $GLOBALS['Y'] );
    $m = ( isset( $change['m'] ) ? $change['m'] : $GLOBALS['m'] );
    $d = ( isset( $change['d'] ) ? $change['d'] : $GLOBALS['d'] );
    $H = ( isset( $change['H'] ) ? $change['H'] : $GLOBALS['H'] );
    return "$reself&amp;Y=$Y&amp;m=$m&amp;d=$d&amp;H=$H";
  }
}


function vbar_graph( $data, $height, $cwidth = 3, $caption = '' ) {
  $rv = " <table class='graph'>";
  if( $caption ) {
    $rv .= sprintf( "<caption>%s</caption>", $caption );
  }

  $barwidth = ( $cwidth > 10 ? $cwidth * 0.8 : $cwidth );

  $rv .= "<tr>";
  foreach( $data as $d ) {
    $val = $d[ 1 ];
    $label = $d[ 2 ];
    $link = ( isset( $d[ 3 ] ) ? $d[ 3 ] : '' );
    $active = ( isset( $d[ 4 ] ) ? $d[ 4 ] : false );
    $class = ( $active ? 'active' : 'inactive' );
    if( $val === null ) {
      $rv .= sprintf( "\n  <td class='vbar null $class' title='%s' style='height:$height;min-width:%upx;'></td>", $label, $cwidth );
    } else {
      $rv .= sprintf( "\n  <td class='vbar $class' title='%s' style='height:$height;min-width:%upx;'>", $label, $cwidth );
      if( $val >= 1 ) {
        $img = sprintf( "<img src='y.png' alt='%u' style='width:%upx;height:%upx;'>", $val, $barwidth, $val );
        if( $link ) {
          $rv .= "<a href='$link'>$img</a>";
        } else {
          $rv .= $img;
        }
      }
      $rv .= '</td>';
    }
  }
  $rv .= "\n</tr>";
  if( $cwidth >= 3 ) {
    $rv .= "\n<tr>";
    $s = '';
    $last_label = '';
    $last_link = '';
    $last_class = 'inactive';
    foreach( $data as $d ) {
      $new_label = $d[ 0 ];
      $new_link = ( isset( $d[ 3 ] ) ? $d[ 3 ] : '' );
      $active = ( isset( $d[ 4 ] ) ? $d[ 4 ] : false );
      $new_class = ( $active ? 'active' : 'inactive' );
      if( $last_label === $new_label ) {
        $colspan++;
      } else {
        if( $last_label ) {
          if( $last_link )
            $last_label = "<a href='$last_link'>$last_label</a>";
          $rv .= "<th class='vbar $last_class' colspan='$colspan'>$last_label</th>";
        }
        $last_label = $new_label;
        $last_link = $new_link;
        $last_class = $new_class;
        $colspan = 1;
      }
    }
    if( $last_label ) {
      if( $last_link )
        $last_label = "<a href='$last_link'>$last_label</a>";
      $rv .= "<th class='vbar $last_class' colspan='$colspan'>$last_label</th>";
    }
    $rv .= "\n</tr>";
  }
  return $rv . "</table>";
}



function string_graph( $Y, $m, $d, $H, $string, $cheight = 200 ) {
  if( ! checkdate( $m, $d, $Y ) )
    return false;

  $path = "$Y/$m/$d.txt";
  if( ! is_readable( $path ) ) {
    return "(data not available)";
  }
  $lines = file( "$Y/$m/$d.txt" );
  if( ! $lines )
    return false;

  switch( "$string" ) {
    case 'ab':
      $scale = 10000 / $cheight;
      $column = 3;
      break;
    case 'c':
      $scale = 5000 / $cheight;
      $column = 4;
      break;
    case 'de':
      $scale = 10000 / $cheight;
      $column = 5;
      break;
    case 'f':
      $scale = 5000 / $cheight;
      $column = 6;
      break;
    default:
      return false;
  }
  $data = array();
  $n = 0;
  foreach( $lines as $l ) {
    $f = explode( ' ', $l );
    sscanf( substr( $f[ 0 ], 0, 2 ), '%u', & $hi );
    if( ( $H > $hi ) || ( $hi > $H + 2 ) )
      continue;
    $data[] = array( sprintf( '%02u', $hi ), $f[ $column ] / $scale, sprintf( '%04uUTC: %u W', $f[ 0 ], $f[ $column ] ) );
  }
  sscanf( $f[ 0 ], '%u', & $t );
  $t += 5;
  while( $t < 100 * ( $H + 3 ) ) {
    $data[] = array( sprintf( '%02u', $t / 100 ), null, 'n/a' );
    $t += 5;
    if( $t % 100 >= 60 ) {
      $t += 40;
    }
  }
  return vbar_graph( $data, $cheight, 10, false );
}






echo               "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">




<html>
<head>
  <title>UniSolar Potsdam e.V. - PV-Anlage Haus 6, Campus Golm</title>
  <meta http-equiv='expires' content='0'>
  <style type='text/css'>
    body, div, caption, th, td, span {
      font-size:10pt;
      font-family:arial,sans-serif;
    }
    .bigskip {
      padding-top:2em;
    }
    .medskip {
      padding-top:1em;
    }
    .smallskip {
      padding-top:1ex;
    }
    img, a img {
      padding:0px;
      margin:0px;
      border:0px !important;
    }
    h4.view {
      padding: 0.1ex 1em 0ex 1em;
      margin:0.5ex 1em 0.1ex 1em;
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
      outline:1px solid black;
      border:0px;
    }
    table.graph th.vbar.active {
      background-color:#eeccdd;
    }
    table.graph td.vbar {
      padding:0pt;
      margin:0pt;
      background-color:#3355bb;
      text-align:center;
      vertical-align:bottom;
    }
    table.graph td.vbar.active {
      background-color:#8855bb;
    }
    table.graph td.vbar.null {
      background-color:#bbbbbb;
    }
    table.graph td.vbar.null.active {
      background-color:#aa88aa;
    }
    table.roof {
      border-spacing:0px;
      border-style:none;
      border-width:0px;
    }
    table.roof td.r {
      border-style:none;
      border-width:0px;
      width:30px !important;
      min-width:30px !important;
      height:34px !important;
      min-height:34px !important;
      margin:0pt;
      padding:0pt;
    }
    table.roof td.air {
      background-color:white;
    }
    table.roof td.roof {
      background-color:#aaaaaa;
    }
    table.roof td.ab {
      background-color:#22cc22;
    }
    table.roof td.c {
      background-color:#22ff44;
    }
    table.roof td.de {
      background-color:#cc2222;
    }
    table.roof td.f {
      background-color:#ff2244;
    }
    table.roof td.box {
      border:0px solid black !important;
      vertical-align:middle;
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
  $Y = $now[0];
  $m = $now[1];
  $d = $now[2];
  $H = max( $now[3] - 0, 0 );
  $string = '0';

  $current = true;

  if( isset( $_GET['Y'] ) ) {
    sscanf( $_GET['Y'], '%u', & $Y );
    $current = false;
  }

  if( isset( $_GET['m'] ) ) {
    sscanf( $_GET['m'], '%u', & $m );
    $current = false;
  }
  $m = sprintf( '%02u', $m );

  if( isset( $_GET['d'] ) ) {
    sscanf( $_GET['d'], '%u', & $d );
    $current = false;
  }
  $d = sprintf( '%02u', $d );

  if( isset( $_GET['H'] ) ) {
    sscanf( $_GET['H'], '%u', & $H );
    $current = false;
  }
  $H = sprintf( '%02u', $H );

  if( isset( $_GET['string'] ) ) {
    $string = substr( $_GET['string'], 0, 2 );
  }


  if( $current ) {
    echo "<div id='timer'>String $string / aktuelle Daten $Y$m$d.{$now[3]}{$now[4]} ".A_UTC."</div>";

  } else {
    echo "<div class='medskip'>historische Ansicht $Y$m$d.$H --- 
         <a href='" . inlink( 'current' ) ."'>aktuelle Daten zeigen</a></div>";
  }
  echo "<div class='medskip'>
    Rohdaten: <a href='$Y/$m/raw.$Y$m$d.csv'>$Y/$m/raw.$Y$m$d.csv</a></div>
  ";

  echo "<div id='stringgraph'> " . string_graph( $Y, $m, $d, max( $H - 2, 2 ), $string  ) . "</div>";

  
if( $current ) {
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
        self.location.href = '". inlink( 'current', '&' ) ."';
      }
    }
    setTimeout( 'rl()', 50 );
  </script>
  ";
}

echo "
  </body>
  </html>
  ";

?>
