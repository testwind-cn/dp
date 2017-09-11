<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Insert title here</title>
</head>

    <body>
    <p>This page测试 uses frames. The current browser you are using does not support frames.</p>
    <?php

    class PeriodMount 
    {
        private $this_period_no = 0;
        private $this_start_date;// = date_create();    // 贷款首期借款日期
        private $this_due_date;// = date_create();      // 贷款本期还款日期
        private $this_principal = 0;                    // 本期总欠本金
        private $this_due_principal = 0;                // 本期应还本金
        private $this_due_days = 0;                     // 本期天数
        private $this_due_interest_real = 0.0;          // 本期应还利息_原始小数
        private $this_due_interest = 0;                 // 本期应还利息_取整
        private $this_due_total = 0;                    // 本期应还本息
        
        function __construct()
        {
            $this->this_start_date = date_create(); 
            $this->this_due_date = date_create();
            
        }
        
        public function setPrincipal($principal)
        { // 设置本期总欠款本金
            $this->this_principal = $principal;
        }
        
        public function getNextPeriodPrincipal()
        { // 计算下期总欠款本金
            return $this->this_principal - $this->this_due_principal;
        }
        
        public function cal_principal_interest($new_principal,$rate,$per_Period_round)
        { // 计算本期应还本金、利息、剩余本金。
            $this->this_principal = $new_principal;
            $new_interest = $new_principal * $this->this_due_days * $rate / 360.0;
            $new_interest_round = round( $new_interest, 2, PHP_ROUND_HALF_UP );
            
            $this->this_due_interest_real = $new_interest;
            $this->this_due_interest = $new_interest_round;
            $this->this_due_principal = $per_Period_round - $new_interest_round;
        }
        
        public function setDate($x,$start_date)
        {
            $this->this_period_no = $x;
            $i = new DateInterval("P".$x."M");
            
            //$i1= date_format($start_date,"Y");
            //$i2= date_format($start_date,"n");
            //$i3= date_format($start_date,"j");
            //date_date_set($this->this_start_date,$i1,$i2,$i3);
            //date_date_set($this->this_due_date,$i1,$i2,$i3);
            
            $this->this_start_date= date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
            $this->this_due_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
            
                  
            $this->this_due_date = date_add($this->this_due_date,$i);
        //    echo date_format($date,"Y/m/d")."<br>";
            $this->this_due_days = (int) date_diff($this->this_due_date,$this->this_start_date)->format("%a");
            return;
        }
        
        public function getDate()
        { // 获取本期还款日的一个副本
            //$date = date_create();
            //$i1= date_format($this->this_due_date,"Y");
            //$i2= date_format($this->this_due_date,"n");
            //$i3= date_format($this->this_due_date,"j");
            //date_date_set($date,$i1,$i2,$i3);
            $date= date_create_from_format("Y-m-d H:i:s",date_format($this->this_due_date,"Y-m-d 00:00:00"));
            return $date;            
        }
        
        public function fixDueDate($date)
        { // 计算本期还款日和某日期（上期还款日）间隔的天数
            $this->this_due_days = (int) date_diff($this->this_due_date,$date)->format("%a");
        }
        
        public function echoDate()
        {
            //echo date_default_timezone_get();
            echo $this->this_period_no."  ".date_format($this->this_start_date,"Y/m/d");
            echo "  ".date_format($this->this_due_date,"Y/m/d");
            echo "  ".$this->this_due_days;
            echo "  ".$this->this_due_principal;
            echo "  ".$this->this_due_interest."<br>";
 
        }
    }
    
    class TotalScedule
    {
        private $d1_all_loan = 12000;
        private $d2_real_rate = 0.18;
        private $d3_per_days = 30;
        private $d4_total_Period = 24;
        private $d5_pow = 0.0;        
        private $d6_per_Period = 0.0;
        private $d6_per_Period_round = 0;
        private $start_date;
        private $PeriodMounts = array();
        
        
        public function calPeriodMount()
        {
            
            date_default_timezone_set("Asia/Shanghai");
            
            
            $this->d5_pow = pow( 1 + $this->d2_real_rate * $this->d3_per_days / 360.0 , $this->d4_total_Period );
            $this->d6_per_Period = $this->d1_all_loan * $this->d2_real_rate * $this->d3_per_days / 360.0 * $this->d5_pow / ($this->d5_pow - 1);
            $this->d6_per_Period_round = round( $this->d6_per_Period, 2, PHP_ROUND_HALF_UP );
            
            $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
            $this->start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
            
            
            unset($this->PeriodMounts);
            $this->PeriodMounts =array();
            
            $this->PeriodMounts[0] = new PeriodMount();
            $this->PeriodMounts[0]->setDate(0,$this->start_date);
            $this->PeriodMounts[0]->setPrincipal($this->d1_all_loan);
            
            for ($x=1; $x <= $this->d4_total_Period; $x++) {
                $this->PeriodMounts[$x] = new PeriodMount();
                $this->PeriodMounts[$x]->setDate($x,$this->start_date);  // 赋值借款日和本期还款日、本期期数
                $this->PeriodMounts[$x]->fixDueDate($this->PeriodMounts[$x-1]->getDate()); // 修正本期天数
                $this->PeriodMounts[$x]->cal_principal_interest($this->PeriodMounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_rate,$this->d6_per_Period_round);
            }
            
            for ($x=1; $x <= $this->d4_total_Period; $x++) {
                $this->PeriodMounts[$x]->echoDate();
            }
        }
        
    }
    
    class wjTestClass
    {
    	public function valid()
    	{
    		$echoStr = $_GET["echostr"];
    		if($this->checkSignature()){
    			echo $echoStr;
    			exit;
    		}
    	}
    	
    	public function getPerMount()
    	{
    		$d1_all_loan = 12000;
    		$d2_real_rate = 0.18;
    		$d3_per_days = 30;
    		$d4_all_times = 6;
    		
    		$d5_pow = pow( 1 + $d2_real_rate * $d3_per_days / 360.0 , $d4_all_times );
    		
    		$d6_per_mount = $d1_all_loan * $d2_real_rate * $d3_per_days / 360.0 * $d5_pow / ($d5_pow - 1);
    		
    		$d_round = round( $d6_per_mount, 2, PHP_ROUND_HALF_UP );
    		echo $d5_pow;
    		echo "<br>";
    		echo $d6_per_mount."<br>";
    		echo number_format($d_round,4,'.',',')."<br>";
    		
    		$start_date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
    		
    		echo date_format($start_date,"Y/m/d")."<br>";
    		
    		$i1= date_format($start_date,"Y");
    		$i2= date_format($start_date,"n");
    		$i3= date_format($start_date,"j");
    		
    		    
    		$date=date_create();    		
    		
    		for ($x=1; $x<12; $x++) {
    		    date_date_set($date,$i1,$i2,$i3);    // date_date_set($date,2020,10,15);
    		    echo "数字是：$x   ";
    		    $i = new DateInterval("P".$x."M");
    		    date_add($date,$i);
    		    echo date_format($date,"Y/m/d")."<br>";
    		}
    		
    	}
    
    	private function checkSignature()
    	{
    		$signature = $_GET["signature"];
    		$timestamp = $_GET["timestamp"];
    		$nonce = $_GET["nonce"];
    
    		$token = TOKEN;
    		$tmpArr = array($token, $timestamp, $nonce);
    		sort($tmpArr);
    		$tmpStr = implode( $tmpArr );
    		$tmpStr = sha1( $tmpStr );
    
    		if( $tmpStr == $signature ){
    			return true;
    		}else{
    			return false;
    		}
    	}
    
    
    
    	public function responseMsg2()
    	{
    		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    
    		if (!empty($postStr)){
    			$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
    			$fromUsername = $postObj->FromUserName;
    			$toUsername = $postObj->ToUserName;
    			$keyword = trim($postObj->Content);
    			$time = time();
    			$textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
    			if($keyword == "?" || $keyword == "？")
    			{
    				$msgType = "text";
    				$contentStr = date("Y-m-d H:i:s",time());
    				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
    				echo $resultStr;
    			}
    		}else{
    			echo "zzz";
    			exit;
    		}
    	}
    }
    
//   $wjObj = new wjTestClass(); 
//   $wjObj->getPerMount();
    $wjObj = new TotalScedule();
   $wjObj->calPeriodMount();

	?>
    </body>

</html>