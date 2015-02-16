<?php
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
  return( $a );
}

?>
