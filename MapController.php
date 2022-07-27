<?php

//set no ticket is NORMAL
$sql_all_pr = "SELECT * FROM provinces ORDER BY id desc";
$result_all_pr = mysqli_query($conn, $sql_all_pr) or die("error");
$data2map = '';
foreach ($result_all_pr as $data) {
    $data2map .= "['" . $data['name_en'] . "'," . '0' . "],";
}

//sent all ticket that open
$sql_all_tg = "SELECT * FROM trueCATV ORDER BY date desc";
$query_tg = mysqli_query($conn, $sql_all_tg) or die("error");
$result_all_tg = mysqli_query($conn, $sql_all_tg);

foreach ($result_all_tg as $data) {
    $data2map .= "['" . $data['province'] . "'," . $data['status'] . "],";
}
