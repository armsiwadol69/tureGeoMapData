<?php

//Int:status Value to Text(NORMAL,NSA,SA)
function checkStatus($status)
{
    if ($status == "0") {
        $returnStatus = "Normal";
    } elseif ($status == "1") {
        $returnStatus = '<span class="badge bg-warning">NSA</span>';
    } elseif ($status == "2") {
        $returnStatus = '<span class="badge bg-danger">SA</span>';
    } else { $returnStatus = "";}

    return $returnStatus;
}
