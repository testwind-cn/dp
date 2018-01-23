<?php
echo time();
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo $url."   ";
//echo "$_SERVER[REQUEST_URL]";


require_once 'calValue/getDates.php';

$a = new GetDates();
//$a->calPeriodDate(50,-1,"2018-7-31",null);
$a->calPeriodDate(50,0,"2018-7-10",null);

echo $a->echoTable(true);


$x = 1;

$start_date = "2024-2-16";

date_default_timezone_set("Asia/Shanghai");
$start_date=date_create_from_format("Y-m-d",$start_date);
$theday = getdate( $start_date->getTimestamp() );
print_r( $theday );

echo "\n<br><br><br>".$theday['year']."=".$theday['mon']."=".$theday['mday']; // 2018-1-29.mday29.yday28


$data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));





for ($x=0; $x <= 50; $x++)
{
    $data_period_date = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));

    $per_Int = new DateInterval("P" . $x . "M");

    $data_period_date = date_add($data_period_date,$per_Int);

    echo "\n<br>".date_format($data_period_date,"Y-m-d 00:00:00")  ;
}

?>