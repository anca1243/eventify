<?php

function toUnix($s) {
  $split = explode(" ", $s);
  $c = 0;
  switch ($split[2]) {
    case "January":
      $c = 1;
      break;
    case "February":
      $c = 2;
      break;
    case "March":
      $c = 3;
      break;
    case "April":
      $c = 4;
      break;
    case "May":
      $c = 5;
      break;
    case "June":
      $c = 6;
      break;
    case "July":
      $c = 7;
      break;
    case "August":
      $c = 8;
      break;
    case "September":
      $c = 9;
      break;
    case "October":
      $c = 10;
      break;
    case "November":
      $c = 11;
      break;
    case "December":
      $c = 12;
      break;
  }
  return strtotime($split[1]."-".$c."-".$split[3]);
}
function stringToDate($a) {
  $a = explode("-",$a);
  $i = 0;
  $lastVal = 0;
  foreach ($a as $b) {
    $a[$i] = strtotime($b);
    $i+=1;
    $lastVal = strtotime($b);
  }
  if ($i == 1) {
    $a[1] = $lastVal;
  }
  print_r( $a );
}

?>
