<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Insert title here</title>
</head>

    <body>
    <p>This page测试 uses frames. The current browser you are using does not support frames.</p>
    <?php

    
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
    		
    		$d5 = pow( 1 + $d2_real_rate * $d3_per_days / 360.0 , $d4_all_times );
    		
    		$d6_per_mount = $d1_all_loan * $d2_real_rate * $d3_per_days / 360.0 * $d5 / ($d5 - 1);
    		
    		$d_round = round( $d6_per_mount, 2, PHP_ROUND_HALF_UP );
    		echo $d5;
    		echo "<br>";
    		echo $d6_per_mount."<br>";
    		echo number_format($d_round,2,'.','');
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
    	
   $wjObj = new wjTestClass(); 
   $wjObj->getPerMount();
    	
	?>
    </body>

</html>