<?php


define("TOKEN", "weixin");

$thetime = time();

$wechatObj = new wechatCallbackapiTest();


//	$wechatObj->responseMsg();




function wj_get_token(){
    
    //更换成自己的APPID和APPSECRET
    
    
    $APPID="wx9dbed6286129d8e4";
    $APPSECRET="bf549a407efe0da9c8ea3b59376eef0d";
    
    $TOKEN_URL="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$APPID."&secret=".$APPSECRET;
    
    
    
    $json=file_get_contents($TOKEN_URL);
    
    //   return $json;
    
    $result=json_decode($json);
    
    $ACC_TOKEN=$result->access_token;
    
    return $ACC_TOKEN;
}



function wj_get_jsapi_ticket(){

    $ticket = "";

    //  do{

        //    $ticket = S('wx_ticket');

    //       if (!empty($ticket)) {

    //      break;

    //    }

    //      $token = S('access_token');

    //  if (empty($token)){

    //        wx_get_token();

    //     }

    //   $token = S('access_token');
    
    $token = wj_get_token();

    //     if (empty($token)) {

    //      logErr("get access token error.");

    //      break;

    //  }

        $url2 = sprintf("https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=jsapi",

            $token);

        $res = file_get_contents($url2);

        $res = json_decode($res, true);

        $ticket = $res['ticket'];

        // 注意：这里需要将获取到的ticket缓存起来（或写到数据库中）

        // ticket和token一样，不能频繁的访问接口来获取，在每次获取后，我们把它保存起来。

        //        S('wx_ticket', $ticket, 3600);

    //  }while(0);

    return $ticket;

}

/*   
    $data = '{
        "touser":"'.$touser.'",
        "msgtype":"text",
        "text":
        {
             "content":"'.$content.'"
        }
    }';
    
    $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$ACC_TOKEN;
    
    $result = https_post($url,$data);
    $final = json_decode($result);
    return $final;
}


*/


	function wj_get_signature() {
// 签名，将jsapi_ticket、noncestr、timestamp、分享的url按字母顺序连接起来，进行sha1签名。

// noncestr是你设置的任意字符串。

// timestamp为时间戳。

global $thetime;
        
            $timestamp = $thetime;

            $wxnonceStr = "anystring";

            $wxticket = wj_get_jsapi_ticket();

            $wxOri = sprintf("jsapi_ticket=%s&noncestr=%s&timestamp=%s&url=%s",

                $wxticket, $wxnonceStr, $timestamp,

                'http://togo.sinaapp.com/main.php'

                ); 

           $wxSha1 = sha1($wxOri);
        
        return $wxSha1;
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
    
    private function wj_get_token() {
        
        // $token = S('access_token');

	    if (!$token) {

    	    $res = file_get_contents('https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='            .'你的AppID'.'&secret='            .'你的AppSecret');

        	$res = json_decode($res, true);

   		     $token = $res['access_token'];

        // 注意：这里需要将获取到的token缓存起来（或写到数据库中）

        // 不能频繁的访问https://api.weixin.qq.com/cgi-bin/token，每日有次数限制

        // 通过此接口返回的token的有效期目前为2小时。令牌失效后，JS-SDK也就不能用了。

        // 因此，这里将token值缓存1小时，比2小时小。缓存失效后，再从接口获取新的token，这样

        // 就可以避免token失效。

        // S()是ThinkPhp的缓存函数，如果使用的是不ThinkPhp框架，可以使用你的缓存函数，或使用数据库来保存。

        //      S('access_token', $token, 3600);

    	}

 	   return $token;

	}

}



?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="initial-scale=1,width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<title>无标题文档</title>
<link href="mycss.css" rel="stylesheet" type="text/css">
<style type="text/css">
@import url("eve.1d76c278.css");
</style>
</head>

<body>
<div class="mytopmenu" id="topmenu">此处显示  id "topmenu" 的内容</div>
<div class="mybox" id="box">
  <div class="mytopmytop" id="top">此处显示  id "top" 的内容</div>
  <div class="myleft" id="left">此处显示  id "left" 的内容</div>
  <div class="mymain" id="main">此处显示  id "main" 的内容</div>
此处显示  id "box" 的内容</div>
<div class="myendmenu" id="endmenu">此处显示  id "endmenu" 的内容
    <?php

// echo wj_get_token();
    ?>
    <br>
<?php

// echo wj_get_jsapi_ticket();
// echo wj_get_signature();
    ?>
    
    </div>


<div class="deal-container">
    <div id="deals" class="deals-list">


<dl class="list" gaevent="common/poilist">
        <dd class="poi-list-item"><a class="react" href="http://i.meituan.com/poi/420847" data-ctpoi="288352485213995520_a420847_c0_e12916641b5c63534aae33647fe809faa">
            <span class="poiname">85度C（瞿溪路店）</span>
                <span class="dealtype-icon dealcard-magiccard">券</span>
                <span class="dealtype-icon">团</span>
            <div class="kv-line-r">
                <h6>

    <span class="stars"><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><em class="star-text">5.0</em></span>
                </h6>
                <p><span data-lat="31.2" data-lng="121.47" data-com="locdist"></span> 打浦桥</p>
            </div>
        </a></dd>
        <dd>
        </dd>
        <dd><dl class="list">
        
        <dd><a href="http://i.meituan.com/deal/26291533.html" data-stid="288352485213995520_a420847_c0_e12916641b5c63534aae33647fe809faa" gaevent="imt/poi/list/list-item" class="react">
<div class="dealcard dealcard-poi" data-did="26291533">
        <span class="dealcard-nobooking"></span>
        <div class="dealcard-img imgbox" data-src="http://p1.meituan.net/100.0/deal/114f4045b424d5abc3a10a7de52928ec32631.jpg" data-src-high="http://p1.meituan.net/200.0/deal/114f4045b424d5abc3a10a7de52928ec32631.jpg" data-com="unveil"></div>
    <div class="dealcard-block-right">

        <div class="title text-block">20元代金券1张，可叠加</div>
        <div class="price">
            <strong>19.3</strong><span class="strong-color">元</span>
                <del>20元</del>
            <span class="line-right">
                    已售361996

            </span>
        </div>
    </div>
</div>
        </a></dd>
        
</dl>
</dd>
    </dl>
    <dl class="list" gaevent="common/poilist">
        <dd class="poi-list-item"><a class="react" href="http://i.meituan.com/poi/6701427" data-ctpoi="288352485213995520_a6701427_c1_e12916641b5c63534aae33647fe809faa">
            <span class="poiname">西树泡芙（万达店）</span>
                <span class="dealtype-icon dealcard-magiccard">券</span>
                <span class="dealtype-icon">团</span>
            <div class="kv-line-r">
                <h6>

    <span class="stars"><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><i class="text-icon icon-star"></i><em class="star-text">4.8</em></span>
                </h6>
                <p><span data-lat="31.06" data-lng="121.24" data-com="locdist"></span> 松江万达广场</p>
            </div>
        </a></dd>
        <dd>
        </dd>
        <dd><dl class="list">
        
        <dd><a href="http://i.meituan.com/deal/25637951.html" data-stid="288352485213995520_a6701427_c0_e12916641b5c63534aae33647fe809faa" gaevent="imt/poi/list/list-item" class="react">
<div class="dealcard dealcard-poi" data-did="25637951">
        <span class="dealcard-nobooking"></span>
        <div class="dealcard-img imgbox" data-src="http://p1.meituan.net/100.0/deal/__49207261__1402071.jpg" data-src-high="http://p1.meituan.net/200.0/deal/__49207261__1402071.jpg" data-com="unveil"></div>
    <div class="dealcard-block-right">

        <div class="title text-block">30元代金券1张，可叠加</div>
        <div class="price">
            <strong>19.8</strong><span class="strong-color">元</span>
                <del>30元</del>
            <span class="line-right">
                    已售21853

            </span>
        </div>
    </div>
</div>
        </a></dd>
        
</dl>
</dd>
    </dl>
    
    </div>
</div>
    
    <button class="btn btn_primary" id="checkJsApi">checkJsApi</button>
    
 <button class="btn btn_primary" id="chooseImage">chooseImage</button>
    
    <button class="btn btn_primary" id="openLocation">openLocation</button>
      <span class="desc">获取地理位置接口</span>
      <button class="btn btn_primary" id="getLocation">getLocation</button>
    
    
    <button class="btn btn_primary" id="scanQRCode0">scanQRCode(微信处理结果)</button>
      <button class="btn btn_primary" id="scanQRCode1">scanQRCode(直接返回结果)</button>
    
</body>
    
    
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"> </script>
<script>
  wx.config({
      debug: false,
      appId: 'wx9dbed6286129d8e4',
      timestamp: <?php echo $thetime ?>,
      nonceStr: 'anystring',
      signature:  '<?php echo wj_get_signature()?>', // '03cf10e38e20717d474e1545bd89eb77aa2c6f28',
      jsApiList: [
        'checkJsApi',
        'chooseImage',
      'openLocation',
		'getLocation',

      'scanQRCode'
      ]
  });
</script>
<script src="wxjs.js"> </script>
    
    

</html>
