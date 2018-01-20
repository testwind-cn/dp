<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>这是标题</title>

<script src="http://libs.baidu.com/jquery/2.0.0/jquery.min.js"></script>

<script type="text/javascript">

function displayTab2(){
	var dt = document.getElementById('theTab');//通过id获取该div
	dt.innerHTML = "abc";//把123替换成abc
}


function displayTab() {
    $.ajax({
    //几个参数需要注意一下
        type: "POST",//方法类型
        dataType: "html",  //  "json",预期服务器返回的数据类型
        url: "calValue/getScedule.php" ,//url
        data: $('#form1').serialize(),
        success: function (result) {
            console.log(result);//打印服务端返回的数据(调试用)

            var dt = document.getElementById('theTab');//通过id获取该div
        	dt.innerHTML = result;//把123替换成abc
        	
            if (result.resultCode == 200) {
                alert("SUCCESS");
            }
            ;
        },
        error : function() {
            alert("异常！");
        }
    });
}
</script>


<!-- last updated 2018-1-19 晚上更新 -->
</head>
<body>
    这是还款计划表工具
<?php
    $qS = $_SERVER['QUERY_STRING'];
    
    echo $qS."<br>";
    
     
    parse_str($qS);
    if ( ! isset($amount) )    {  $amount = 10000; }
    if ( ! isset($rate) )  {   $rate =0.213;}
    if ( ! isset($total) )   {  $total = 12;}
    if ( ! isset($per_days) )  {   $per_days = 0;}
    if ( ! isset($s_date) )  {   $s_date = "2018-1-5";}
    if ( ! isset($days) )  {   $days = "31,28,31,30,31,30,31,31,30,31,30,31";}
    
    echo $amount;  // value
    echo ",&nbsp;&nbsp;".$rate; // foo bar
    echo ",&nbsp;&nbsp;".$total; // baz
    echo ",&nbsp;&nbsp;".$per_days."<br>\n"; // baz
    echo $days; // baz
    
?>
<form id="form1" name="form1"  onsubmit="return false" action="##" method="post">
  <p>
    <label for="amount">总本金</label>
    <input name="amount" type="text" id="amount" value="<?php echo $amount; ?>" />
  </p>

  <p>
    <label for="rate">年利率</label>
    <input name="rate" type="text" id="rate" value="<?php echo $rate; ?>" />
  </p>
  
  
  <p>
    <label for="s_date">借款日期</label>
    <input name="s_date" type="text" id="s_date" value="<?php echo $s_date; ?>"  />
  </p>

  <p>
    <label for="total">期数</label>
    <input name="total" type="text" id="total" value="<?php echo $total; ?>"  />
  </p>
  
  <p>   
    <label for="per_days">每期天数（0表示月还）</label>
    <input name="per_days" type="text" id="per_days" value="<?php echo $per_days; ?>"  />
  </p>
  
  <p>   
    <label for="days">指定每期天数</label>
    <input name="days" type="text" id="days" value="<?php echo $days; ?>"  />
  </p>

  <input type="button"  id="getdata" value="提交"  onclick="displayTab()" />
  <input type="hidden" name="req_type" value="0">
  <input type="hidden" name="ret_type" value="0">
    
</form>


<div id='theTab'>
<?php

    require_once 'calValue/PeriodAmount.php';
    require_once 'calValue/TotalScedule.php';
//    require_once 'calValue/getScedule.php';
    require_once 'tools/check.php';
    
    $s_date = "2017-12-16";
    $s_date = "2018-1-5";

    $days = array(25,31,28,31,30,31);
    //   $days = array(27,28,31,30,31,30,31,31,30,31,30,31,31);
    $days = array(55,31,30,31,30,31,31,30,31,30,31,31);
    
    //    for ($x=0; $x < count($days); $x++)
        //        echo $days[$x].'<br>';

    
    $wjObj = new TotalScedule();
    
//   $wjObj->calPeriodAmount(10000,0.18,6,0);
//    $wjObj->calPeriodAmount(10000,0.213,6,-1, "2017-12-16", $t_period_days_array);
    $wjObj->calPeriodAmount($amount,$rate,$total,$per_days, $s_date, $days);
    $echoStr = $wjObj->echoTable(true);
    //$echoStr = urlencode ( $echoStr );
    //$echoStr = urldecode ( $echoStr );
    echo $echoStr;

?>
</div>
    </body>

</html>