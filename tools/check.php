<?php

class Check_tools
{
    
    public static function is_post()
    {
        return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='POST';
    }
    
    public static function is_get()
    {
        return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='GET';
    }
    
    public static function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])=='XMLHTTPREQUEST';
    }
    
    public static function is_cli()
    {
        return (PHP_SAPI === 'cli' OR defined('STDIN'));
    }
    
    
    public static function getURLValue($name)
    {
        $value = null;
        if ( isset($_GET) && is_array($_GET) && count($_GET)>0)//先判断是否通过get传值了
        {
            if ( isset($_GET[$name]) )//是否存在"$name"的参数
            {
                $value=$_GET[$name];//存在
            }
        }
        return $value;
    }
    
    public static function getPOSTValue($name, $defValue, $isPost=true)
    {
        $value = $defValue;
        if ( $isPost )
        {
            if ( isset($_POST) && is_array($_POST) && count($_POST)>0)//先判断是否通过get传值了
            {
                if ( isset($_POST[$name]) )//是否存在"$name"的参数
                {
                    $value=$_POST[$name];//存在
                }
            }
        } else {
            if ( isset($_GET) && is_array($_GET) && count($_GET)>0)//先判断是否通过get传值了
            {
                if ( isset($_GET[$name]) )//是否存在"$name"的参数
                {
                    $value=$_GET[$name];//存在
                }
            }
        }
        return $value;
    }
    
    public static function getArrValue($arr,$name,$default)
    {
        $value = $default;
        if ( isset($arr) && is_array($arr) ) //先判断是否存在,是否数组
        {
            if ( isset($arr[$name]) ) //是否存在"$name"的参数
            {
                $value=$arr[$name];//存在
            }
        }
        return $value;
    }
    
    
    public static function getReqStr( $all_loan ,$real_rate, $total_Period, $period_days=0, $start_date=null, $period_days_array=null)
    {
        
        $arr  = array("amount"=>$all_loan,"rate"=>$real_rate,"total"=>$total_Period,
            "per_days"=>$period_days,"s_date"=>$start_date,
            "days"=>$period_days_array);
        //array(55,31,30,31,30,31,31,30,31,30,31,31));
        $echoStr = json_encode($arr);
        $echoStr = urlencode ( $echoStr );
        return $echoStr;
    }
    
    
    
    /**
     * PHP发送Json对象数据
     *
     * @param $url 请求url
     * @param $jsonStr 发送的json字符串
     * @return array
     */
    public static function http_post_json($url, $jsonStr)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonStr);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($jsonStr)
        )
            );
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        
        return array($httpCode, $response);
    }
    
}













/**
 *@todo: 判断是否为post

if(!function_exists('is_post')){
    function is_post()
    {
        return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='POST';
    }
}
 */

/**
 *@todo: 判断是否为get

if(!function_exists('is_get')){
    function is_get()
    {
        return isset($_SERVER['REQUEST_METHOD']) && strtoupper($_SERVER['REQUEST_METHOD'])=='GET';
    }
}
 */
/**
 *@todo: 判断是否为ajax
 
if(!function_exists('is_ajax')){
    function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH'])=='XMLHTTPREQUEST';
    }
}
*/
/**
 *@todo: 判断是否为命令行模式

if(!function_exists('is_cli')){
    function is_cli()
    {
        return (PHP_SAPI === 'cli' OR defined('STDIN'));
    }
}  
 */