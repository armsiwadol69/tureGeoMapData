<?php
header('Content-Type: text/html; charset=utf-8');

if (empty($_POST["site"])) {
    header('Location: dashboard.php');
    exit(0);
}

// function generateRandomString($length = 10) {
//     $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
//     $charactersLength = strlen($characters);
//     $randomString = '';
//     for ($i = 0; $i < $length; $i++) {
//         $randomString .= $characters[rand(0, $charactersLength - 1)];
//     }
//     return $randomString;
// }

include 'conn.php';
$conn = mysqli_connect($serverName, $userName, $userPassword, $dbName);

date_default_timezone_set("Asia/Bangkok");
echo date_default_timezone_get();

$Gen_TicketNo = "TT" . date("YmdHis");

$order = array("\r\n", "\n", "\r");
$replace = '<br />';

$pre_detail = str_replace($order, $replace, $_POST["detail"]);
$TicketNo = mysqli_real_escape_string($conn, $Gen_TicketNo);
$site = mysqli_real_escape_string($conn, $_POST["site"]);
$province = mysqli_real_escape_string($conn, $_POST["province"]);
$detail = mysqli_real_escape_string($conn, $pre_detail);
$date = mysqli_real_escape_string($conn, $_POST["date"]);
$time = mysqli_real_escape_string($conn, $_POST["time"]);
$duration = mysqli_real_escape_string($conn, $_POST["duration"]);
$status = mysqli_real_escape_string($conn, $_POST["status"]);

if (!$conn) {
    die('Could not Connect My Sql:' . mysql_error());
}

$sql = "INSERT INTO trueCATV(site,province,TicketNo,date,time,duration,detail,status)
VALUES('$site','$province','$TicketNo','$date','$time','$duration','$detail','$status')";
$query = mysqli_query($conn, $sql);
echo "your data was submitted!";

//echo "back to home in 3 sec.";
if ($query) {
    header('Location:dashboard.php?result=done&newid=' . $Gen_TicketNo);
} else {
    header('Location:dashboard.php?result=fail');
}
exit(0);
