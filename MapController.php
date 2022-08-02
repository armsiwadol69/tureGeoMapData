<?php

//set no ticket is NORMAL
$sql_all_pr = "SELECT * FROM provinces ORDER BY id desc";
$result_all_pr = mysqli_query($conn, $sql_all_pr) or die("error");
$data2map = '';
foreach ($result_all_pr as $data) {
    //$data2map .= "['" . $data['name_en'] . "'," . '0' . "],";
    $data2map .= "[{ v: '" . $data['ISO_Code']."', f: '". $data['name_en'] . "' },  0],\r\n";
}

//sent all ticket that open
//$sql_all_tg = "SELECT * FROM trueCATV ORDER BY date desc";
$sql_all_tg = "SELECT * FROM trueCATV LEFT JOIN provinces ON provinces.name_en = trueCATV.province ORDER BY date desc";


$result_all_tg = mysqli_query($conn, $sql_all_tg) or die("error");
//$result_all_tg = mysqli_query($conn, $sql_all_tg);

$toBeEcho = mysqli_fetch_array($result_all_tg);

foreach ($result_all_tg as $data) {
//$data2map .= "[{ v: '" . $data['ISO_Code']."', f: '". $data['name_en'] . "' },  ."$data['status']".],";

$data2map .= "[{ v: '" . $data['ISO_Code']."', f: '". $data['name_en'] . "' },".$data["status"]."],\r\n";
}

?>
