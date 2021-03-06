<?php

require_once 'calValue/TheRates.php';
require_once 'calValue/TheDates.php';
require_once 'calValue/ThePayments.php';
require_once 'calValue/TheMethod.php';


class TheTotal
{
    // 1-1098按设置固定天（ 多期、一期），
    // 0按半月，-1按月，-2双月，-3三月，-4四月，-5五月，-6六月、-7七月、-8八月、-9九月、-10十月、-11十月、-12一年、（ 多期、一期）
    // -13 .. -24两年，（ 多期、一期）
    // -25按指定天,（ 多期、一期）
    
    private $d1_all_loan = 12000;
    private $d2_real_rate = 0.18;
    private $d2_real_day_rate = 0.0005;
    private $d3_total_Period = 6;
    private $d4_period_days = 0;  // 0=按自然月还， 1-365=按天数周期还，-1=按后面的还款天表
    private $d5_start_date;
    private $d6_period_amount = 0.0;
    private $d6_period_amount_round = 0;
    private $period_days_array=null;
//    private $periodAmounts = array();
    
    
    
    
    public function __construct()
    {
        //        $this->data_start_date = date_create();
        

        
    }
    
    
    public function __destruct() {

    }
    
    
    public function cal_theTotals($all_loan,$rate,$total,$len, $sdate, $spec_mday,$spec_mode,$useDay){ // useDay 一般默认false，表示按期

        
//        $a->calPeriodAmount(90000,0.059,16,-1,"2018-1-29",0,true);
        
        $theDates = new TheDates($total);
        $theDates->cal_theDates( $total, $len, $sdate , $spec_mday , $spec_mode,null);
        $theDates->echoData();
        
        
        $theRates = new TheRates($total);
        $theRates->cal_theRates($theDates,$rate,$useDay);
        $theRates->echoData();
        
        $thePayments = new ThePayments($total);
        $thePayments->setAllPrincipal($all_loan*100);
        
        $theMtd = new TheMethod();
        $theMtd->cal_Payments($theRates, $thePayments, $useDay);
        
//        $theAmounts->cal_theAmounts( $theRates, $all_loan, $useDay );
        $thePayments->echoData();
        
    }
    
    
    
    
    
    
        
}

?>