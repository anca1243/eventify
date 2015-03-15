<?php
//A magic function that turns
//"12th september 2014"
//into unix time
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

//This is really, really hacky
//Basically the user's input data will be in a different format
//To the council. So we need a new function ( ;) )
function stringToDateUser($a) {
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
