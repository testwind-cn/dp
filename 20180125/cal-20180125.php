<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>这是标题</title>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<script type="text/javascript">




function displayTab(){

	var dt = document.getElementById('theTab');//通过id获取该div
	dt.innerHTML = "abc";//把123替换成abc

}


</script>


<!-- last updated 2017-9-14 晚上更新 -->
</head>

    <body>
    这是PHP工具
    <br>
    <br>
    
   
   

<div id='theTab'>test！</div>


    <?php
    $qS = $_SERVER['QUERY_STRING'];
    
    echo $qS."<br>";
    
    
    parse_str($qS);
    if ( ! isset($amount) )    {  $amount = 10000; }
    if ( ! isset($rate) )  {   $rate =0.213;}
    if ( ! isset($total) )   {  $total = 120;}
    if ( ! isset($days) )  {   $days = 0;}
    
    echo "_".$amount;  // value
    echo "_".$rate; // foo bar
    echo "_".$total; // baz
    echo "_".$days; // baz
    
    ?>

<form id="form1" name="form1" method="get"  action="">
  <p>
    <label for="amount">总本金</label>
    <input name="amount" type="text" id="amount" value="<?php echo $amount; ?>" />
  </p>
  <p>
    <label for="rate">年利率</label>
    <input name="rate" type="text" id="rate" value="<?php echo $rate; ?>" />
  </p>
  <p>
    <label for="total">期数</label>
    <input name="total" type="text" id="total" value="<?php echo $total; ?>"  />
  </p>
  
  
   <p>   
     <label for="days">每期天数（0表示月还）</label>
    <input name="days" type="text" id="days" value="<?php echo $days; ?>"  />
  </p>

    <input type="submit"  id="submit" value="提交"  onclick="displayTab()" />
</form>



<?php
    
    $s_date = "2017-12-16";
    $s_date = "2018-1-5";

    $t_period_days_array = array(25,31,28,31,30,31);
    
 //   $t_period_days_array = array(27,28,31,30,31,30,31,31,30,31,30,31,31);
    $t_period_days_array = array(55,31,30,31,30,31,31,30,31,30,31,31);
    
//    for ($x=0; $x < count($t_period_days_array); $x++)
//        echo $t_period_days_array[$x].'<br>';
    
    require_once 'calValue/PeriodAmount-20180125.php';
    require_once 'calValue/TotalScedule-20180125.php';
    
//    require_once 'calValue/getScedule.php';
    require_once '../tools/check.php';
    
    

    
    $wjObj = new TotalScedule_20180125();
//    $wjObj->calPeriodMount_old();
    
//   $wjObj->calPeriodAmount(10000,0.18,6,0);
//    $wjObj->calPeriodAmount(10000,0.213,6,-1, "2017-12-16", $t_period_days_array);
    $wjObj->calPeriodAmount($amount,$rate,$total,$days, $s_date, $t_period_days_array);
    $echoStr = $wjObj->echoTable(true);
    $echoStr = urlencode ( $echoStr );
    $echoStr = urldecode ( $echoStr );
    echo $echoStr;

   //   $wjObj = new wjTestClass();
   //   $wjObj->getPerMount();
?>
    </body>

</html>