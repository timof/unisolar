<?

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

if( getenv( 'robot' ) ) {
  if( $_GET['nonce'] ) {
    header( 'HTTP/1.0 410 gone' );
    return;
  }
}

function maxday( $Y, $m ) {
  foreach( array( 31, 30, 29, 28 ) as $d )
    if( checkdate( $m, $d, $Y ) )
      return $d;
  return NULL;
}

function inlink( $change = array() ) {
  $nonce = random_hex_string( 8 );
  $reself = "roof.php?";
  if( ! getenv('robot') )
    $reself .= "&amp;nonce=$nonce";
  if( $change === 'current' ) {
    return $reself;
  } else {
    $Y = ( isset( $change['Y'] ) ? $change['Y'] : $GLOBALS['Yi'] );
    $m = ( isset( $change['m'] ) ? $change['m'] : $GLOBALS['mi'] );
    $d = ( isset( $change['d'] ) ? $change['d'] : min( $GLOBALS['di'], maxday( $Y, $m ) ) );
    $H = ( isset( $change['H'] ) ? $change['H'] : $GLOBALS['Hi'] );
    if( $Y < 2011 || $Y > $GLOBALS['Yn'] )
      return '#';
    if( $H < 0 || $H > 23 )
      return '#';
    if( ! checkdate( $m, $d, $Y ) )
      return '#';
    return "$reself&amp;Y=$Y&amp;m=$m&amp;d=$d&amp;H=$H";
  }
}

function daily_production( $Y, $m, $d ) {
  $path  = sprintf( "%04u/%02u/%02u.last", $Y, $m, $d );

  // check whether there was already production on $Y$m$d or later (if not,
  // $d.last may still contain previous day's reading!)
  //
  $lp_lines = file( 'last_production' );
  sscanf( $lp_lines[0], '%d', & $lp );

  if( ( $lp >= ( $Y * 100 + $m ) * 100 + $d ) && is_readable( $path ) ) {
    $lines = file( $path );
    return $lines[ 2 ];
  } else {
    return false;
  }
}

function monthly_production_kWh( $Y, $m ) {
  $path1  = sprintf( "%04u/%02u/01.first", $Y, $m );
  if( is_readable( $path1 ) ) {
    for( $d = 31; $d >= 1; $d-- ) {
      $path2  = sprintf( "%04u/%02u/%02u.last", $Y, $m, $d );
      if( is_readable( $path2 ) )
        break;
    }
  }

  if( is_readable( $path1 ) && is_readable( $path2 ) ) {
    $lines1 = file( $path1 );
    sscanf( $lines1[ 3 ], "%f %s", & $work1, & $work1_unit );
    switch( $work1_unit ) {
      case 'MWh':
        $work1 *= 1000;
      case 'kWh':
        break;
      default:
        return false;
    }
    $lines2 = file( $path2 );
    sscanf( $lines2[ 3 ], "%f %s", & $work2, & $work2_unit );
    switch( $work2_unit ) {
      case 'MWh':
        $work2 *= 1000;
      case 'kWh':
        break;
      default:
        return false;
    }
    return $work2 - $work1;
  }
  return false;
}

function roof( $string_ab = 'AB', $string_c = 'C', $string_de = 'DE', $string_f = 'F', $caption = '' ) {
  $rv = "<table class='roof'>
         <colgroup>
           <col span='46' width='22px'>
         </colgroup>
  ";
  if( $caption ) {
    $rv .= "<caption>$caption</caption>";
  }
  $rv .= "
       <tr>
         <td colspan='5' class='r air'> </td>
         <td colspan='5' class='r roof'> </td>
         <td colspan='8' class='r ab'>AB</td>
         <td colspan='1' class='r c'>C</td>
         <td colspan='5' rowspan='2' class='r c box'>$string_c</td>
         <td colspan='1' class='r c'> </td>
         <td colspan='4' class='r roof'> </td>
         <td colspan='2' class='r de'>DE</td>
         <td colspan='5' rowspan='2' class='r de box'>$string_de </td>
         <td colspan='2' class='r de'> </td>
         <td colspan='3' class='r roof'> </td>
         <td colspan='5' class='r air'> </td>
       </tr><tr>
         <td colspan='4' class='r air'> </td>
         <td colspan='5' class='r roof'> </td>
         <td colspan='2' class='r ab'> </td>
         <td colspan='5' rowspan='2' class='r ab box'>$string_ab</td>
         <td colspan='2' class='r ab'> </td>
         <td colspan='1' class='r c'> </td>
         <td colspan='1' class='r c'> </td>
         <td colspan='4' class='r roof'> </td>
         <td colspan='2' class='r de'> </td>
         <td colspan='2' class='r de'> </td>
         <td colspan='4' class='r roof'> </td>
         <td colspan='4' class='r air'> </td>
       </tr><tr>
         <td colspan='3' class='r air'> </td>
         <td colspan='5' class='r roof'> </td>
         <td colspan='3' class='r ab'> </td>
         <td colspan='2' class='r ab'> </td>
         <td colspan='6' class='r c'> </td>
         <td colspan='15' class='r de'> </td>
         <td colspan='3' class='r f'>F</td>
         <td colspan='1' class='r roof'> </td>
         <td colspan='3' class='r air'> </td>
       </tr><tr>
         <td colspan='2' class='r air'> </td>
         <td colspan='5' class='r roof'> </td>
         <td colspan='11' class='r ab'> </td>
         <td colspan='6' class='r c'> </td>
         <td colspan='8' class='r de'> </td>
         <td colspan='3' class='r f'> </td>
         <td colspan='5' rowspan='2' class='r f box'>$string_f </td>
         <td colspan='3' class='r f'> </td>
         <td colspan='1' class='r roof'> </td>
         <td colspan='2' class='r air'> </td>
       </tr><tr>
         <td colspan='1' class='r air'> </td>
         <td colspan='6' class='r roof'> </td>
         <td colspan='14' class='r ab'> </td>
         <td colspan='11' class='r de'> </td>
         <td colspan='3' class='r f'> </td>
         <td colspan='4' class='r f'> </td>
         <td colspan='1' class='r roof'> </td>
         <td colspan='1' class='r air'> </td>
      </tr>
    </table>
  ";
  return $rv;
}

function vbar_graph( $data, $height, $cwidth = 3, $caption = '' ) {
  $rv = " <table class='graph'>";
  if( $caption ) {
    $rv .= sprintf( "<caption>%s</caption>", $caption );
  }

  $barwidth = ( $cwidth > 10 ? $cwidth * 0.8 : $cwidth );

  $have_ticks = false;
  $rv .= "<tr>";
  foreach( $data as $d ) {
    $val = $d[ 1 ];
    $label = $d[ 2 ];
    if( $d[ 0 ] )
      $have_ticks = true;
    $link = ( isset( $d[ 3 ] ) ? $d[ 3 ] : '' );
    $active = ( isset( $d[ 4 ] ) ? $d[ 4 ] : false );
    $class = ( $active ? 'active' : '' );
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
  if( $have_ticks ) {
    $rv .= "\n<tr>";
    $s = '';
    $last_label = '';
    $last_link = '';
    $last_class = '';
    foreach( $data as $d ) {
      $new_label = $d[ 0 ];
      $new_link = ( isset( $d[ 3 ] ) ? $d[ 3 ] : '' );
      $active = ( isset( $d[ 4 ] ) ? $d[ 4 ] : false );
      $new_class = ( $active ? 'active' : '' );
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



function string_graph( $Y, $m, $d, $H, $string, $cheight = 62, $cwidth = 3 ) {
  if( ! checkdate( $m, $d, $Y ) ) {
    var_dump( $m, $Y, $d );
    return false;
  }

  $path = sprintf( '%04u/%02u/%02u.txt', $Y, $m, $d );
  if( ! is_readable( $path ) ) {
    return "(data not available)";
  }
  $path = sprintf( '%04u/%02u/%02u.txt', $Y, $m, $d );
  $lines = file( $path );
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
    $data[] = array( null, $f[ $column ] / $scale, sprintf( '%04uUTC: %u W', $f[ 0 ], $f[ $column ] ) );
  }
  sscanf( $f[ 0 ], '%u', & $t );
  $t += 5;
  while( $t < 100 * ( $H + 3 ) ) {
    $data[] = array( null, null, 'n/a' );
    $t += 5;
    if( $t % 100 >= 60 ) {
      $t += 40;
    }
  }
  return vbar_graph( $data, $cheight, $cwidth, false );
}

function roof_graph( $Y, $m, $d, $H, $caption = '' ) {
  $Hi = max( $H - 2, 0 );
  $g_ab = string_graph( $Y, $m, $d, $Hi, 'ab' );
  $g_c  = string_graph( $Y, $m, $d, $Hi, 'c' );
  $g_de = string_graph( $Y, $m, $d, $Hi, 'de' );
  $g_f  = string_graph( $Y, $m, $d, $Hi, 'f' );

  return roof( $g_ab, $g_c, $g_de, $g_f, $caption );
}


function day_graph( $Y, $m, $d, $caption = '' ) {
  if( ! checkdate( $m, $d, $Y ) )
    return false;

  if( ( ! $caption ) && ( $caption !== false ) ) {
    $caption = sprintf( "Tagesproduktion %04u%02u%02u", $Y, $m, $d );
  }
  $path = sprintf( '%04u/%02u/%02u.txt', $Y, $m, $d );
  if( ! is_readable( $path ) ) {
    return "(data not available)";
  }
  $lines = file( $path );
  if( ! $lines )
    return false;

  $cwidth = 3;
  if( $cwidth >= 3 ) {
    $cheight = 110;
  } else {
    $cheight = 30;
  }
  $scale = 29640 / $cheight;

  $data = array();
  $Hs_last = '-';
  $t = 0;
  $n = 0;
  $f = array( 0 => null );
  while( $t <= 2355 ) {
    $ts = sprintf( '%04u', $t );
    while( isset( $lines[ $n ] ) ) {
      $l = $lines[ $n ];
      $f = explode( ' ', $l );
      sscanf( $f[ 0 ], '%u', & $ti );
      if( $ti >= $t ) {
        break;
      }
      $n++;
    }
    $Hs = substr( $ts, 0, 2 );
    sscanf( $Hs, '%u', & $Hi );
    if( $f[ 0 ] === $ts ) {
      if( $Hs !== $Hs_last ) {
        $link = inlink( array( 'H' => max( $Hi, 0 ) ) );
        $Hs_last = $Hs;
      }
      $data[] = array(
        $Hs
      , $f[ 2 ] / $scale
      , sprintf( '%04uUTC: %u W', $f[0], $f[ 2 ] )
      , $link
      , ( $GLOBALS['Hi'] <= $Hi + 2 ) && ( $GLOBALS['Hi'] >= $Hi )
      );
    } else {
      $data[] = array(
        sprintf( '%02u', $t / 100 )
      , null
      , 'n/a'
      , ''
      , ( $GLOBALS['Hi'] <= (int)($t / 100) + 2 ) && ( $GLOBALS['Hi'] >= (int)($t / 100) )
      );
    }
    $t += 5;
    if( $t % 100 >= 60 ) {
      $t += 40;
    }
  }
  return vbar_graph( $data, $cheight, $cwidth, $caption );
}

function month_graph( $Y, $m, $caption = '' ) {
  if( ! checkdate( $m, 1, $Y ) )
    return false;

  if( ( ! $caption ) && ( $caption !== false ) ) {
    $caption = sprintf( "Monatsproduktion %04u%02u", $Y, $m );
  }

  $d = 1;
  $data = array();
  while( checkdate( $m, $d, $Y ) ) {
    $val = daily_production( $Y, $m, $d );
    if( $val !== false ) {
      $link = inlink( array( 'd' => $d ) );
      $data[] = array(
        sprintf( "%02u", $d )
      , $val * 0.5
      , sprintf( '%04u%02u%02u: %u kWh', $Y, $m, $d, $val )
      , $link
      , $GLOBALS['di'] == $d
      );
    } else {
      $data[] = array( sprintf( '%02u', $d ), null, 'n/a', '', $GLOBALS['di'] == $d );
    }
    $d++;
  }
  // var_dump( $data );
  return vbar_graph( $data, 110, 30, $caption );
}

function year_graph( $Y, $caption = '' ) {

  if( ( ! $caption ) && ( $caption !== false ) ) {
    $caption = sprintf( "Jahresproduktion %04u", $Y );
  }

  $data = array();
  for( $m = 1; $m <= 12; $m++ ) {
    $val = monthly_production_kWh( $Y, $m );
//     $path1  = sprintf( "%04u/%02u/%02u.txt", $Y, $m, 1 );
//     for( $d = 31; $d >= 1; $d-- ) {
//       $path2 = sprintf( "%04u/%02u/%02u.txt", $Y, $m, $d );
//      if( is_readable( $path2 ) )
//         break;
//     }
//     if( is_readable( $path1 ) && is_readable( $path2 ) ) {
//       $lines = file( $path1 );
//       $f1 = explode( ' ', $lines[ 0 ] );
//       $lines = file( $path2 );
//       $f2 = explode( ' ', $lines[ count($lines) - 1 ] );
//       $val = $f2[ 1 ] - $f1[ 1 ];
    $link = inlink( array( 'm' => $m ) );
    if( $val !== false ) {
       $data[] = array(
         sprintf( "%02u", $m )
       , $val / 50
       , sprintf( '%04u%02u: %u kWh', $Y, $m, $val )
       , $link
       , $GLOBALS['mi'] == $m
       );
     } else {
       $data[] = array( sprintf( '%02u', $m ), null, 'n/a', '', $GLOBALS['m'] == $m );
     }
  }
  return vbar_graph( $data, 100, 30, $caption );
}





$now = explode( ',' , date( 'Y,m,d,H,i,s' ) );
$Yn = $now[0];
$mn = $now[1];
$dn = $now[2];
$Hn = $now[3];
$Mn = $now[4];

$lines = file( 'last' );
$last = $lines[ 0 ];
$Yi = substr( $last, 0, 4 );
$mi = substr( $last, 4, 2 );
$di = substr( $last, 6, 2 );
$Hi = substr( $last, 9, 2 );
$Mi = substr( $last, 11, 2 );

$current = true;

if( isset( $_GET['Y'] ) ) {
  sscanf( $_GET['Y'], '%u', & $Yi );
  $current = false;
}
$Ys = sprintf( '%02u', $Yi );

if( isset( $_GET['m'] ) ) {
  sscanf( $_GET['m'], '%u', & $mi );
  $current = false;
}
$ms = sprintf( '%02u', $mi );

if( isset( $_GET['d'] ) ) {
  sscanf( $_GET['d'], '%u', & $di );
  $current = false;
}
$ds = sprintf( '%02u', $di );

if( isset( $_GET['H'] ) ) {
  sscanf( $_GET['H'], '%u', & $Hi );
  $current = false;
}
$Hs = sprintf( '%02u', $Hi );

$Ms = sprintf( '%02u', $Mi );

if( ( ! checkdate( $mi, $di, $Yi ) )
    || ( $Yi < 2011 )
    || ( $Yi > $Yn )
    || ( $Hi < 2 )
    || ( $Hi > 23 ) ) {
  header( 'HTTP/1.0 404 invalid parameters' );
  echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">\n\n\ninvalid parameters in query string";
  return;
}




echo               "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">


<html>
<head>
  <title>UniSolar Potsdam e.V. - PV-Anlage Haus 6, Campus Golm</title>
  <meta name='robots' content='index'>
  <meta http-equiv='expires' content='0'>
  <style type='text/css'>
    body, div, caption, th, td, span {
      font-size:10pt;
      font-family:arial,sans-serif;
      background-color:#aabbff;
      padding:0px;
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
    div.title {
      padding:0ex 0em 1ex 0em;
      margin:-1ex 0em 0.1ex 0em;
      font-size:11pt;
      text-align:left;
    }
    h4.view {
      display:table-row;
      padding: 0.1ex 1em 0ex 1em;
      margin:0.5ex 1em 0.1ex 1em;
    }
    span.td.gap {
      /* border: 1px solid red; */
      display:table-cell;
      min-width:4em !important;
      max-width:4em !important;
      width:4em !important;
      text-align:center;
    }
    span.td {
      /* border: 1px solid blue; */
      display:table-cell;
      text-align:center;
      padding:1px 1ex 1px 1ex;
    }
    table.layout, table.layout tr, table.layout tr td {
      padding:0px;
      margin:0px !important;
      border-collapse:collapse;
      empty-cells:show !important;
      border-spacing:0px !important;
      border:0px dotted red;
    }
    table.data, table.data tr, table.data tr th {
      padding-left:2em;
      white-space:nowrap !important;
      text-align:left;
    }
    table.data tr td {
      font-weight:bold;
      white-space:nowrap !important;
    }
    table.data tr td.number {
      padding-left:1em;
      text-align:right;
    }
    table.data tr td.unit {
      text-align:left;
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
      background-color:#7066cc;
    }
    table.graph td.vbar {
      padding:0pt;
      margin:0pt;
      background-color:#3355bb;
      text-align:center;
      vertical-align:bottom;
    }
    table.graph td.vbar.active {
      background-color:#7066cc;
    }
    table.graph td.vbar.null {
      background-color:#bbbbbb;
    }
    table.graph td.vbar.null.active {
      background-color:#aa99bb;
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
      background-color:#aabbff;
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
<body>";


  echo "<table class='layout'><tr><td>";
  echo "<h4 class='view' style='padding-top:2px;'><span class='td gap'>";
  if( $Yi > 2011 )
    echo "<a href='".inlink( array( 'Y' => $Yi - 1 ) )."'>&lt;&lt&lt</a>";
  echo "</span><span class='td'>Jahresproduktion $Ys</span><span class='td gap'>";
  if( $Yi < $Yn )
    echo "<a href='".inlink( array( 'Y' => $Yi + 1 ) )."'>&gt;&gt&gt</a>";
  echo "</span>
        </h4>
    <div id='yeargraph'>" . year_graph( $Yi, false ) . "</div>
  ";
  echo "</td><td style='vertical-align:top;padding:1ex 1em 1ex 1em;font-size:12pt;'>";

  echo "<div class='title'><a href='http://www.unisolar-potsdam.de'>UniSolar Potsdam e.V.</a> - <a href='//www.unisolar-potsdam.de/?page_id=716'>Photovoltaik-Anlage Haus 6, Campus Golm</a></div>";

  if( $current ) {
    echo "<div id='timer' style='padding:0px;margin:0pt;'>aktuelle Ablesung: $Ys$ms$ds.$Hs$Ms ".A_UTC."</div>";

    if( count( $lines ) == 4 ) {
      sscanf( $lines[ 3 ], '%f %s', & $gt, & $gt_unit );
      switch( $gt_unit ) {
        case 'kWh':
          $gt /= 1000;
        case 'MWh':
          $gt = sprintf( "%.2f", $gt );
          break;
        default:
          break;
      }
      sscanf( $lines[ 2 ], '%f %s', & $dt, & $dt_unit );
      switch( $dt_unit ) {
        case 'MWh':
          $dt *= 1000;
        case 'kWh':
          $dt = sprintf( "%.2f", $dt );
          break;
        default:
          break;
      }
      sscanf( $lines[ 1 ], '%f %s', & $cp, & $cp_unit );
      switch( $cp_unit ) {
        case 'W':
          $cp /= 1000.0;
        case 'kW':
          $cp = sprintf( "%.2f", $cp );
          break;
        default:
          break;
      }
      // if( 0 ) {
      echo "<table class='data'>";
      printf( "<tr><th>Leistung:</th><td class='number'>%s</td><td class='unit'>kW</tr>", $cp );
      printf( "<tr><th>Arbeit heute:</th><td class='number'>%s</td><td class='unit'>kWh</td></tr>", $dt );
      printf( "<tr><th>Arbeit gesamt:</th><td class='number'>%s</td><td class='unit'>MWh</td></tr>", $gt );
      printf( "<tr><th style='padding-top:2px;'>Rohdaten:</th><td  style='padding-top:2px;' colspan='2'><a href='$Ys/$ms/raw.$Ys$ms$ds.csv'>$Ys/$ms/raw.$Ys$ms$ds.csv</a></td></tr>" );
      echo "</table>";
      // }
    }
  
  } else {
    echo "<div class='smallskip'>historische Ansicht $Ys$ms$ds.$Hs --- 
         <a href='" . inlink( 'current' ) ."'>aktuelle Daten zeigen</a></div>";
    echo "<div class='smallskip'>Rohdaten: <a href='$Ys/$ms/raw.$Ys$ms$ds.csv'>$Ys/$ms/raw.$Ys$ms$ds.csv</a></div>";
  }

  echo "</td></tr></table>";
  
  echo "<h4 class='view'><span class='td gap'>";
  if( $mi > 1 )
    echo "<a href='".inlink( array( 'm' => $mi - 1 ) )."'>&lt;&lt&lt</a>";
  echo "</span><span class='td'>Monatsproduktion $Ys$ms</span><span class='td gap'>";
  if( $mi < 12 )
    echo "<a href='".inlink( array( 'm' => $mi + 1 ) )."'>&gt;&gt&gt</a>";
  echo "</span></h4>
    <div id='monthgraph'> " . month_graph( $Yi, $mi, false ) . "</div>
  ";

  echo "<h4 class='view'><span class='td gap'>";
  if( $di > 1 )
    echo "<a href='".inlink( array( 'd' => $di - 1 ) )."'>&lt;&lt&lt</a>";
  echo "</span><span class='td'>Tagesproduktion $Ys$ms$ds</span><span class='td gap'>";
  if( checkdate( $mi, $di + 1, $Yi ) )
    echo "<a href='".inlink( array( 'd' => $di + 1 ) )."'>&gt;&gt&gt</a>";
  echo "</span></h4>
    <div id='daygraph'>" . day_graph( $Yi, $mi, $di, false ) . "</div>
  ";

  echo "<h4 class='view'><span class='td gap'>";
  if( $Hi > 2 )
    echo "<a href='".inlink( array( 'H' => $Hi - 1 ) )."'>&lt;&lt&lt</a>";
  echo "</span><span class='td'>Stringansicht $Ys$ms$ds.$Hs</span><span class='td gap'>";
  if( $Hi < 23 )
    echo "<a href='".inlink( array( 'H' => $Hi + 1 ) )."'>&gt;&gt&gt</a>";
  echo "</span></h4>
    <div id='roofgraph'>" . roof_graph( $Yi, $mi, $di, $Hi, false ) . "</div>
  ";

  echo "<h4 class='view'><span class='td gap'>";
  if( $Hi > 2 )
    echo "<a href='".inlink( array( 'H' => $Hi - 1 ) )."'>&lt;&lt&lt</a>";
  echo "</span><span class='td'>Vergroesserung  Stringansicht $Ys$ms$ds.$Hs</span><span class='td gap'>";
  if( $Hi < 23 )
    echo "<a href='".inlink( array( 'H' => $Hi + 1 ) )."'>&gt;&gt&gt</a>";
  echo "</span></h4>
    <table><tr>
  ";
  $HiS = max( $Hi - 2, 0 );
  foreach( array( 'ab', 'c', 'de', 'f' ) as $string ) {
    echo "<td>". string_graph( $Yi, $mi, $di, $HiS, $string, 400, 6 )."</td>";
  }
  echo "</tr></table>";

  echo "<hr><table width='100%'><tr>";
    echo "<td style='text-align:left;'>server: <kbd>". getenv('HOSTNAME').'/'.getenv('server') ."</kbd></td>";
    $version = file_exists( '../version.txt' ) ? file_get_contents( '../version.txt' ) : 'unknown';
    echo "<td style='text-align:center;'><a href='http://github.com/timof/unisolar'>unisolar monitoring scripts</a> version $version </td>";
    echo "<td style='text-align:right;'>".date( 'Ymd.His' )."</td>";
  echo "</tr></table>";

  
  
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
        self.location.href = '". inlink( 'current' ) ."';
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
