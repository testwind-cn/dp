<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Insert title here</title>
</head>

    <body>
    123123哦
    <?php
    class PeriodAmount 
    {
        private $data_period_num = 0;
        private $data_start_date;// = date_create();        // 贷款首期借款日期
        private $data_period_date;// = date_create();       // 贷款本期还款日期
        private $data_period_principal = 0;                 // 本期总欠本金
        private $data_due_days = 0;                         // 本期借款天数
        private $data_due_principal = 0;                    // 本期应还本金
        private $data_due_interest_real = 0.0;              // 本期应还利息_原始小数
        private $data_due_interest = 0.0;                   // 本期应还利息_取整
        private $data_due_amount = 0;                        // 本期应还本息
        private $data_z_1_B = 1;                            // 本期本息率 = 1 + 年率 /360* 本期天数
        private $data_z_pai = 1;                            // <本息率>连乘积
        
        function __construct()
        {
            $this->data_start_date = date_create(); 
            $this->data_period_date = date_create();
            
        }
        
        
        
        public function setPeriodPrincipal($principal)
        { // 设置本期总欠款本金
            $this->data_period_principal = $principal;
        }
        
        public function getNextPeriodPrincipal()
        { // 计算下期总欠款本金
            return $this->data_period_principal - $this->data_due_principal;
        }
        
        public function cal_principal_interest($new_principal,$rate,$per_amount_round)
        { // 计算本期应还本金、利息、剩余本金。
            $this->data_period_principal = $new_principal;                          // 本期总欠本金
            $new_interest = $new_principal * $this->data_due_days * $rate / 360.0;  // 本期精确应还利息取整
            $new_interest_round = round( $new_interest, 2, PHP_ROUND_HALF_UP );     // 本期应还利息取整
            
            $this->data_due_interest_real = $new_interest;
            $this->data_due_interest = $new_interest_round;                         // 本期应还利息取整
            $this->data_due_principal = $per_amount_round - $new_interest_round;
            
            if ( $this->data_due_principal > $this->data_period_principal ) // 修正本期应还本金，如果应还本金，大于剩余本金，就是错误，改为剩余本金。
            {
                $this->data_due_principal = $this->data_period_principal;
            }
            $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
        }
        
        public function cal_last_period_due_principal()
        { // 修正最后一期应还本金，如果没还完本金，全部归还。
            if ( $this->data_due_principal < $this->data_period_principal )
            {
                $this->data_due_principal = $this->data_period_principal;
            }
            $this->data_due_amount = $this->data_due_principal + $this->data_due_interest;
        }
        
        public function setPeriodDate($x,$start_date)
        {
            $this->data_period_num = $x;
            $i = new DateInterval("P".$x."M");
            
            $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
            $this->data_period_date = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
            
                  
            $this->data_period_date = date_add($this->data_period_date,$i);
        //    echo date_format($date,"Y/m/d")."<br>";
            $this->data_due_days = (int) date_diff($this->data_period_date,$this->data_start_date)->format("%a");  //这个没用了，后面需要重新 FixDueDays
            return;
        }
        
        public function getPeriodDate()
        { // 获取本期还款日的一个副本
            $date= date_create_from_format("Y-m-d H:i:s",date_format($this->data_period_date,"Y-m-d 00:00:00"));
            return $date;
        }
        
        public function fixDueDays($date)
        { // 计算本期还款日和某日期（上期还款日）间隔的天数
            $this->data_due_days = (int) date_diff($this->data_period_date,$date)->format("%a");
        }
        
        public function fix_z_1_B($real_rate)
        {
        	$this->data_z_1_B = 1 + $this->data_due_days * $real_rate / 360.0;
        }
        
        public function get_z_pai()
        {
        	return $this->data_z_pai; 
        }  
        public function set_z_pai($mult_pai)
        {
        	$this->data_z_pai = $this->data_z_1_B * $mult_pai;        	
        }
        
        public function echoData()
        {
            //echo date_default_timezone_get();
            echo "        <td>".$this->data_period_num."</td>\n";
            echo "        <td>".date_format($this->data_start_date,"Y/m/d")."</td>\n";
            echo "        <td>".date_format($this->data_period_date,"Y/m/d")."</td>\n";
            echo "        <td>".$this->data_period_principal."</td>\n";
            echo "        <td>".$this->data_due_days."</td>\n";
            echo "        <td>".$this->data_due_principal."</td>\n";
            echo "        <td>".$this->data_due_interest."</td>\n";
            echo "        <td>".$this->data_due_amount."</td>\n";
            echo "        <td>".$this->data_z_1_B."</td>\n";
            echo "        <td>".$this->data_z_pai."</td>\n";
            echo "\n";
        }
    }
    class TotalScedule
    {
        private $d1_all_loan = 12000;
        private $d2_real_rate = 0.18;
        private $d3_period_days = 30;
        private $d4_total_Period = 36;
        private $d5_pow = 0.0;          // 没用了
        private $d6_period_amount = 0.0;
        private $d6_period_amount_round = 0;
        private $start_date;
        private $PeriodMounts = array();
        
        public function calPeriodAmount()
        {
            date_default_timezone_set("Asia/Shanghai");
            
            $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
            $this->start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
            
            unset($this->PeriodMounts);
            $this->PeriodMounts =array();
            
            $this->PeriodMounts[0] = new PeriodAmount();
            $this->PeriodMounts[0]->setPeriodDate(0,$this->start_date);
            $this->PeriodMounts[0]->setPeriodPrincipal($this->d1_all_loan);
            
            for ($x=1; $x <= $this->d4_total_Period; $x++) 
            {
                $this->PeriodMounts[$x] = new PeriodAmount();
                $this->PeriodMounts[$x]->setPeriodDate($x,$this->start_date);       // 赋值借款日和本期还款日、本期期数
                $this->PeriodMounts[$x]->fixDueDays($this->PeriodMounts[$x-1]->getPeriodDate()); // 修正本期天数
                $this->PeriodMounts[$x]->fix_z_1_B($this->d2_real_rate);
            }
            
            $this->PeriodMounts[$this->d4_total_Period+1] = new PeriodAmount(); // 多生成一个，data_due_z_1_B = 1；
            
            $sum_z_pai = 0; // 从 2 到 第 25 个 z_pai 求和
            
            for ($x=$this->d4_total_Period; $x >= 1; $x--) 
            {
                $mult_pai = $this->PeriodMounts[$x+1]->get_z_pai();
                $this->PeriodMounts[$x]->set_z_pai( $mult_pai );
                $sum_z_pai = $sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
            }
            
            $first_z_pai = $this->PeriodMounts[1]->get_z_pai(); //  第1 个 z_pai
            $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
            $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
            
            for ($x=1; $x <= $this->d4_total_Period; $x++) {
                $this->PeriodMounts[$x]->cal_principal_interest($this->PeriodMounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_rate,$this->d6_period_amount_round);
            }
            
            $this->PeriodMounts[$this->d4_total_Period]->cal_last_period_due_principal();

        }
        
        public function echoTable()
        {
            echo "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d4_total_Period+1+9; $x++) {
                echo "    <tr>\n";
                if (isset($this->PeriodMounts[$x])) 
                {
                    $this->PeriodMounts[$x]->echoData();
                }
                else
                {
                    echo "    <td>no data</td>\n";
                }
                echo "    </tr>\n";
            }
            echo "</table>\n";        	
        }
        
        
        public function calPeriodMount_old() // 这个函数不用了，弃用
        {
            // 这个函数不用了，弃用
            
            date_default_timezone_set("Asia/Shanghai");
            
            
            $this->d5_pow = pow( 1 + $this->d2_real_rate * $this->d3_period_days / 360.0 , $this->d4_total_Period );
            $this->d6_period_amount = $this->d1_all_loan * $this->d2_real_rate * $this->d3_period_days / 360.0 * $this->d5_pow / ($this->d5_pow - 1);
            $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP );
            
            $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
            $this->start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
            
            
            unset($this->PeriodMounts);
            $this->PeriodMounts =array();
            
            $this->PeriodMounts[0] = new PeriodAmount();
            $this->PeriodMounts[0]->setDate(0,$this->start_date);
            $this->PeriodMounts[0]->setPrincipal($this->d1_all_loan);
            
            for ($x=1; $x <= $this->d4_total_Period; $x++) {
                $this->PeriodMounts[$x] = new PeriodAmount();
                $this->PeriodMounts[$x]->setDate($x,$this->start_date);  // 赋值借款日和本期还款日、本期期数
                $this->PeriodMounts[$x]->fixDueDate($this->PeriodMounts[$x-1]->getDate()); // 修正本期天数
                $this->PeriodMounts[$x]->cal_principal_interest($this->PeriodMounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_rate,$this->d6_period_amount_round);
            }
            
            echo "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=1; $x <= $this->d4_total_Period; $x++) 
            {
                echo "    <tr>\n";
                $this->PeriodMounts[$x]->echoDate();
                echo "    </tr>\n";
            }
            echo "</table>\n";
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

    $wjObj = new TotalScedule();
   $wjObj->calPeriodAmount();
   $wjObj->echoTable();
   //   $wjObj = new wjTestClass();
   //   $wjObj->getPerMount();
	?>
    </body>

</html>