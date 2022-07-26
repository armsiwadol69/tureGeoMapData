<?php

//Int:status Value to Text(NORMAL,NSA,SA) 
function checkStatus($status){
  if($status == "0")
  {
  $returnStatus = "Normal";
  }
  elseif ($status == "1")
  {
   $returnStatus = "NSA";
  }
  elseif ($status == "2")
  {
   $returnStatus = "SA";
  }else{$returnStatus = "";}

  return $returnStatus;
 }




?>