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
?>