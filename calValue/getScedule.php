<?php

    require_once '../tools/check.php';
    require_once 'PeriodAmount.php';
    require_once 'TotalScedule.php';
    
    $req_type = 0;
    $ret_type = 0;
    
    $amount = 0;
    $rate = 0;
    $total = 0;
    $per_days = 0;
    $s_date = "";
    $days = null;

    $wjObj = new TotalScedule();

    
    /*
     /////   测试   ///////////////////////////
     $amount = 10000;
     $rate =0.213;
     $total = 6;
     $per_days = 0;
     $s_date = "2018-1-5";
     $days = null;
     $days = array(25,31,28,31,30,31);
     $days = array(55,31,30,31,30,31,31,30,31,30,31,31);
     $req_str = Check_tools::getReqStr( $amount ,$rate, $total, $per_days, $s_date, $days);
     //   /////   测试   //////////////////////////
     */
    
    
    
    if ( Check_tools::is_post() )
    {
        $req_type = intval( Check_tools::getPOSTValue('req_type') ); // 请求类型  0=json , 1=独立参数
        $ret_type = intval( Check_tools::getPOSTValue('ret_type') ); // 返回类型  0=json , 1=TABEL
        
        
        if ( $req_type == null || $req_type == 0  )
        {
            $req_str = Check_tools::getPOSTValue('req_str');  // 按 json 方式取请求参数
        }
        else {
            $amount = floatval( Check_tools::getPOSTValue('amount') );            
            $rate = floatval( Check_tools::getPOSTValue('rate') );
            $total = intval( Check_tools::getPOSTValue('total') );
            $per_days = intval( Check_tools::getPOSTValue('per_days') );
//            $days = Check_tools::getPOSTValue('days');
        }
    
    }
    elseif ( Check_tools::is_get() )
    {
        $req_type = Check_tools::getURLValue('req_type'); // 请求类型  0=json , 1=独立参数
        $ret_type = Check_tools::getURLValue('ret_type'); // 返回类型  0=json , 1=TABEL
        
        
        if ( $req_type == null || $req_type == 0  )
        {            
            $req_str = Check_tools::getURLValue('req_str');  // 按 json 方式取请求参数
        }
        else {
            $amount = floatval( Check_tools::getURLValue('amount') );
            $rate = floatval( Check_tools::getURLValue('rate') );
            $total = intval( Check_tools::getURLValue('total') );
            $per_days = intval( Check_tools::getURLValue('per_days') );
            //            $days = Check_tools::getPOSTValue('days');
        }

    }
    
    

    $the_date = date_create(date("Y-m-d"));
    $s_date = date_format($the_date,"Y-m-d");
    
    if ( $req_type == null || $req_type == 0  )
    {
        $str = urldecode ( $req_str );
        $arr = json_decode ( $str,true );

        $amount = Check_tools::getArrValue( $arr,'amount',0);
        $rate = Check_tools::getArrValue( $arr,'rate',0);
        $total = Check_tools::getArrValue( $arr,'total',0);
        $per_days = Check_tools::getArrValue( $arr,'per_days',0);
        $s_date = Check_tools::getArrValue( $arr,'s_date',$the_today);
        $days = Check_tools::getArrValue( $arr,'days',null);

    }
    
    $wjObj->calPeriodAmount($amount,$rate,$total,$per_days, $s_date, $days);
    
    if ( $ret_type == null || $ret_type == 0  ) // 返回 json
    {
        header('Content-Type: application/json');
        header('Content-Type: text/html;charset=utf-8');
        
        $echoStr = $wjObj->echoTable(false);
        
        echo $echoStr;
        
    } else {
        $echoStr = $wjObj->echoTable(true); // 返回 table
        echo $echoStr;
    }
    //        $echoStr = urlencode ( $echoStr );
    //        $echoStr = urldecode ( $echoStr );
    
    // echo $echoStr;
    
    
?>