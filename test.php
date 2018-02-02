<?php
echo time();
$url = "$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
echo $url."   ";
//echo "$_SERVER[REQUEST_URL]";

//require_once 'calValue/GetRates.php';
require_once 'calValue/GetTotal.php';

/*
$aa1 = new TheDates(12);
$aa1->calScheduleDate( 16, -1, "2018-1-29", 0, true,null);
$aa1->echoData();
$aa2 = new TheRates(12);
$aa2->cal_z_pai($aa1,0.059);
$aa2->echoData();
*/

$aa = new TheTotals();
$aa->cal_theTotals(90000,0.059,16,-1,"2018-1-29",0,true);


// $a->calPeriodAmount(90000,0.059,16,-1,"2018-1-29",0,true);

require_once 'calValue/TotalScedule.php';

$a = new TotalScedule();

//$a->calPeriodDate(50,-1,"2018-7-31",null);
$a->calPeriodAmount(90000,0.059,16,-1,"2018-1-29",0,true);


echo $a->echoTable(true);

/*
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
*/

/*
echo 13%12;


echo ceil(3.333)."<br>"; //out 4
echo floor(3.333)."<br>"; //out 3
echo round(3.333)."<br>"; //out 3 

echo ceil(3)."<br>"; //out 4
echo floor(3)."<br>"; //out 3
echo round(3)."<br>"."<br>"."<br>"."<br>"; //out 3 

$m_month = 1;
$shift = -37;
$m_year = 2018;

$add_year = floor( ( $m_month + $shift - 1 ) / 12 );
$m_month = ( ( $m_month + $shift - 1 ) % 12 ) + 1;
if ( $m_month <= 0 ) $m_month = $m_month + 12;
$m_year = $m_year + $add_year;     


echo $m_month;
echo "<br>"."<br>"."<br>";
echo $m_year;
*/
/*
echo "<br>"."<br>"."<br>";

for ($i= -30 ; $i<31; $i++){
    $date=date_create_from_format("Y-m-d","2017-2-7");
    $date1 = date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
    $date2 = $a->getShiftSameDay($date1,$i,false);
    echo $i."___".date_format($date,"Y-m-d")."____".date_format($date2,"Y-m-d")."<br>";
    
    
}

*/

?>