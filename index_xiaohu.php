<?php
/*
    方倍工作室 http://www.cnblogs.com/txw1958/
    CopyRight 2013 www.doucube.com  All Rights Reserved
*/

require_once 'sql.func.php';
//引入记录消息的函数文件
require_once 'record_message.func.inc.php';



			$pushmsg=array(
					"尊敬的客户：大涨过后更需要保持一颗平常心，本周逐步卖出金融股，买入本月中央经济工作会议将会重点布局的一路一带板块。未来指数的上涨将会趋于平缓，振荡也会加大，选对正确的股票是净值稳健上涨的关键。
由于明河价值买入了嘉实元合（中石化销售公司）占仓位五个点，目前估值仍按买入价计算，造成近期净值涨幅少于明河成长，但根据目前行情，一旦开盘后预计将有三个涨停或以上幅度的上涨，特此告知各位客户。
祝您及您的家人周末愉快！

 明河价值本周净值1.29元。2014-12-5",
					"尊敬的客户：大涨过后更需要保持一颗平常心，本周逐步卖出金融股，买入本月中央经济工作会议将会重点布局的一路一带板块。未来指数的上涨将会趋于平缓，振荡也会加大，选对正确的股票是净值稳健上涨的关键。祝您及您的家人周末愉快！

 明河成长本周净值1.33元。2014-12-5",
					"尊敬的客户：大涨过后更需要保持一颗平常心，本周逐步卖出金融股，买入本月中央经济工作会议将会重点布局的一路一带板块。未来指数的上涨将会趋于平缓，振荡也会加大，选对正确的股票是净值稳健上涨的关键。祝您及您的家人周末愉快！

明河优质企业本周净值1.10元。2014-12-5");




define("TOKEN", "weixin");

//sae_debug("weixin");

$wechatObj = new wechatCallbackapiTest();

//sae_debug($GLOBALS["HTTP_RAW_POST_DATA"]);

if (isset($_GET["echostr"])) {
	$wechatObj->valid();
}else{
	$wechatObj->responseMsg();
}

class wechatCallbackapiTest
{
    public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
            exit;
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
    
    
    public function responseMsg0($postObj)
    {
 

            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            $msgType = "text";
            $contentStr = date("Y-m-d H:i:s",time());
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;

    }
    
     public function responseMsg1()
    {
    	
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
		if (empty($postStr)) {
			echo "";	return;
		}
		
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
 

            $fromUsername = $postObj->FromUserName;
            $toUsername = $postObj->ToUserName;
            $time = time();
            $textTpl = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        <FuncFlag>0</FuncFlag>
                        </xml>";
            $msgType = "text";
            $contentStr = date("Y-m-d H:i:s",time());
            $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
            echo $resultStr;

    }
    
    
    public function responseMsg3()
    {
    	
    	$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
    	
    	$db=mysql_connect(SAE_MYSQL_HOST_M.':'.SAE_MYSQL_PORT,SAE_MYSQL_USER,SAE_MYSQL_PASS);
			if($db) {
				mysql_select_db(SAE_MYSQL_DB,$db);
			}
//		"  . $postStr . "
			$sql = "INSERT INTO `product_msg` (`msg`) VALUES ('"  . $postStr . "' ) ";

		$result=mysql_query($sql);
		mysql_free_result($query);//释放mysql内存
		mysql_close($db);//关闭mysql连接
		
		
    	echo "";	return;
    }



	public function responseMsg()
	{
		
		
		
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		
		if (empty($postStr)) {
			echo "";	return;
		}
		
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			
		if ( $postObj->MsgType  == "event" ) {
			$this->responseEventMsg($postObj);
			return;
		}
			
		if ( $postObj->MsgType  == "text" ) {
			$this->responseTextMsg($postObj);
			return;
		}
		
		if ( $postObj->MsgType  == "location" ) {
			$this->responseMsg0($postObj);
			return;
		}	

	}
	
	public function responseLocMsg($postObj) {
		
		
		if ( empty($postObj) || $postObj->MsgType  != "location" ) {
			echo "";	return;
		}
		
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		
		$contentStr = "aaa"; //trim($postObj->Label);
		$time = time();
		
		$msgType = "text";
		$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[您是想询问如何到我公司吗？您的地址是： %s]]></Content>
<FuncFlag>0</FuncFlag>
</xml>";

		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		echo $resultStr;
	}


	

	

	
	public function responseTextMsg($postObj) {
		
		
//		http://www.jb51.net/article/24666.htm
//		PHP的isset()函数 一般用来检测变量是否设置
//		格式：bool isset ( mixed var [, mixed var [, ...]] ) 
//		PHP的empty()函数 判断值为否为空
//		格式：bool empty ( mixed var ) 

		global $pushmsg;


		if ( empty($postObj) || $postObj->MsgType  != "text" ) {
			echo "";	return;
		}
		
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		
		$keyword = trim($postObj->Content);
		$time = time();
		
		$msgType = "news";
		$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[信息]]></Content>
<ArticleCount>1</ArticleCount>
<Articles>
	<item>
	  <Title><![CDATA[产品信息查询]]></Title>
	  <Description><![CDATA[%s]]>
	  </Description>
	  <PicUrl><![CDATA[http://sae.sina.com.cn/static/image/home/qr_code.png]]></PicUrl>
	  <Url><![CDATA[http://1.mynull.sinaapp.com/msg.php]]></Url>
	  </item>
</Articles>
<FuncFlag>0</FuncFlag>
</xml>";

		$contentStr = null;
		openDB();
		_fetch_array( $pushmsg );
		$date_stamp = date('Y-m-d H:i:s');
		//调用_record_message()函数，记录消息入数据库
		_record_message($fromUsername,$keyword,$date_stamp);
		closeDB();
		
		sae_debug("weixin+keyword".$keyword);
		
		if($keyword == "价值" )
		{
			$contentStr = $pushmsg[0];
		}
		
		if($keyword == "成长" )
		{
			$contentStr = $pushmsg[1];
		}
		
		if($keyword == "优质" || $keyword == "优质企业")
		{
			$contentStr = $pushmsg[2];
		}
		
//  	sae_debug("weixin+contentStr".$contentStr);
		
		if ( $contentStr == null || $keyword == "?" || $keyword == "？")  {
			//  $contentStr = date("Y-m-d H:i:s",time());
			$msgType = "text";
			$contentStr = "您可回复“价值”或“成长”或“优质企业”查看产品的最新净值信息。";
			$textTpl = "<xml>
	                        <ToUserName><![CDATA[%s]]></ToUserName>
	                        <FromUserName><![CDATA[%s]]></FromUserName>
	                        <CreateTime>%s</CreateTime>
	                        <MsgType><![CDATA[%s]]></MsgType>
	                        <Content><![CDATA[%s]]></Content>
	                        <FuncFlag>0</FuncFlag>
	                        </xml>";
		}
		
		$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
		echo $resultStr;	
			
	}
	
	public function responseEventMsg($postObj) {
		
		if ( empty($postObj) || $postObj->MsgType  != "event" ) {
			echo "";	return;
		}
		
		$textTpl = "<xml>
<ToUserName><![CDATA[%s]]></ToUserName>
<FromUserName><![CDATA[%s]]></FromUserName>
<CreateTime>%s</CreateTime>
<MsgType><![CDATA[%s]]></MsgType>
<Content><![CDATA[%s]]></Content>
<FuncFlag>0</FuncFlag>
</xml>";

	$msgType = "text";
	$time = time();
	$fromUsername = $postObj->FromUserName;
	$toUsername = $postObj->ToUserName;
	$contentStr = "欢迎加入 明河投资微信，祝您投资愉快！
因客户分组需求，请留言告知您持有的产品或您所属的银行名称，感谢您的加入！
您可回复“价值”或“成长”或“优质企业”查看产品的最新净值信息。";
	                        
		
		switch ( $postObj->Event ) {
			case "subscribe":
				$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
				echo $resultStr;
				break;
			case "blue":
				echo "Your favorite color is blue!";
				break;
			default:
				echo "";
		}		
	}



}
?>