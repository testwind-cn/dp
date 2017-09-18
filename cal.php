<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>这是标题</title>
<!-- last updated 2017-9-14 晚上更新 -->
</head>

    <body>
    123123哦
    <?php

    require_once 'calValue/PeriodAmount.php';
    require_once 'calValue/TotalScedule.php';
    
    $wjObj = new TotalScedule();
    $wjObj->calPeriodMount_old();
    
   $wjObj->calPeriodAmount(12000,0.18,24,0);
   $wjObj->echoTable();
   
   //   $wjObj = new wjTestClass();
   //   $wjObj->getPerMount();
	?>
    </body>

</html>