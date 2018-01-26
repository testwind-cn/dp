<?php

require_once 'PeriodAmount.php';

class TotalScedule
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
    private $periodAmounts = array();
    
    
    
    

    
    
    
    
    
    
    public function echoTable( $need_table=false )
    {
        if (  $need_table )
        {
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                if (isset($this->periodAmounts[$x]))
                {
                    $echoStr = $echoStr.$this->periodAmounts[$x]->echoData(true);
                }
                else {
                    $echoStr = $echoStr."    <td>no data</td>\n";
                }
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
        } else {
            $echoStr = "{";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++)
            {
                if (isset($this->periodAmounts[$x]))
                {
                    $echoStr = $echoStr.$this->periodAmounts[$x]->echoData(false);
                    $echoStr = $echoStr.",";
                }
                else {
                    
                }
            }
            
            $echoStr = substr($echoStr,0,strlen($echoStr)-1 )."}";
            
        }
        return $echoStr;
    }
    
    
    public function getShiftSameDay( $start_date, $shift=0, $is_month=true) // shift 前后挪期， $is_month=false半月，true月
    {        
        
        // ?? 检查 $start_date 是合法日期
        
        $theday1 = getdate( $start_date->getTimestamp() );
        $m_year = $theday1['year'];
        $m_month = $theday1['mon'];
        $m_day = $theday1['mday'];
        
        if ( $m_day > 28 ) $m_day = 28; //只会是 1-28
        
        if ( $is_month == false ) { // 半月
            if ( $m_day == 15 ) $m_day = 16;
            if ( $m_day == 14 ) $m_day = 13;
            
            if ( $shift % 2 != 0 ) { // 单数半月
                if ( $m_day < 15 ){
                    $m_day = $m_day + 15;
                    $shift = $shift - 1; //去掉一个半月，人工挪后半月
                } else {
                    $m_day = $m_day - 15;
                    $shift = $shift + 1; //去掉一个半月，人工前移半月
                }
            }
            $shift = floor( $shift / 2 );
        }
        
        
        // 月 和 半月 相同模式
        $add_year = floor( ( $m_month + $shift - 1 ) / 12 );
        $m_month = ( ( $m_month + $shift - 1 ) % 12 ) + 1;
        if ( $m_month <= 0 ) $m_month = $m_month + 12;
        $m_year = $m_year + $add_year;
        
        $date = date_create_from_format("Y-m-d H:i:s", $m_year."-".$m_month."-".$m_day." 00:00:00");
        
        return $date;

    }
    
    

    
  
    public function calPeriodAmount( $all_loan ,$real_rate,  $total_Period, $days_len=-1, $start_date=null, $spec_mday=0, $spec_mode=false,$days_array=null)
    {
        /*
         * $total_Period 总借款期数
         * $days_len 每期间隔长度，-1=按自然月还， 1-365=按天数周期还，0=半月，-1..-24按月，-25=按后面的还款天表
         * $start_date ， 借款日，null 表示当日
         * 
         * 
         * $spec_mday，指定还款日  1-100=修正到1-28,   0不指定；
         * ** 指定日只能是 1-28，大于28改为28
         * ** 负数不指定同借款日，但实先修正还款日，29-31变成28，是下面 = B.b1.方案
         * ** 0不指定同借款日，也不修正还款日，按实际生成的还款日后再修正29-31
         * 
         * ** A.借款日小于等于指定日的，首期就是下月，无疑问
         * ** B.借款日大于等于指定日的
         *          B.a.方案，false,全部到N+2月开始还
         *          B.b1.方案，true,下月还款日减借款日>15的，就是N+1月还款日
         *          B.b2.方案，true,下月还款日减借款日<16的，就是N+2月还款日
         * 
         *          
         *          
         * ** 如果 spec_mday 大于28，则修正成28，需要指定 spec_mode，true的按半月贴近模式。False的不满整月都到第三月。
         * ** 如果 spec_mday 小于0，则取借款日mday，	
         * ** 如果mday小于等于28，则作为spec_day；spec_mode=什么无所谓
         * *  如果mday大于28，设置spec_mode=28，我认为要设置spec_mode为true，按B.b1.方案，否则59天太长
         * ** 如果 spec_mday 等于0，不设置spec_mday，事后要修正	
         
         *          
         *          
         * $spec_mode : false = B.a.方案   , true = B.b.方案
         * 
         * 
         * 
         * 
         * 
         * 
         * ?? 首期之前加 N 天免息日， 免多少期，免多少天
         * 
         * 
         */
        
        
        
        
        /*
         * 
         * 
         * 
         */

        if ( $all_loan < 0 ) { $all_loan = 0; }
        if ( $real_rate< 0 ) { $real_rate = 0; }
        if ( $total_Period < 1 ) { $total_Period = 1; }
        
        $this->d1_all_loan = $all_loan;
        $this->d2_real_rate = $real_rate;
        $this->d2_real_day_rate = $this->d2_real_rate / 360.0;
        $this->d3_total_Period = $total_Period; // 总期数不能小于1
        $this->d4_period_days = $days_len; // -1=按自然月还， 1-365=按天数周期还，-25=按后面的还款天表
        $this->period_days_array = $days_array;
        
        
        
        //////////////// 1.设定开始日期
        date_default_timezone_set("Asia/Shanghai");
        // $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        
        $date=date_create_from_format("Y-m-d",$start_date);
        if ( $date == false )
        { // 如果没有传递开始日期，或者错误的开始日期，则设置当前日期为开始日期
            $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        }
        $this->d5_start_date= date_create_from_format("Y-m-d H:i:s",date_format($date,"Y-m-d 00:00:00"));
        //////////////// 1.设定开始日期
        
        
        
        
        
        $theday1 = getdate( $this->d5_start_date->getTimestamp() );
        $m_year = $theday1['year'];
        $m_month = $theday1['mon'];
        $m_day = $theday1['mday'];
        
        
        
        //////////////// 2.修正指定日期
        if ( $spec_mday < 0 ) {
            $spec_mday = $m_day;
        }
        if ( $spec_mday > 28 ) $spec_mday = 28; // spec_mode 按实际传入的
        
        
        if (  $days_len == 0 ) { ///半月模式 
            if ( $spec_mday !=0 ) { //注意半月不指定日期模式！！！ 不是0任意天模式，
                if ( $spec_mday == 15 ) $spec_mday = 16;
                if ( $spec_mday == 14 ) $spec_mday = 13;
            }
            
            if ( $m_day + 15 <= $spec_mday ) $spec_mday -= 15; //** 半月模式的，借款日的mday + 15 <=指定日mday， 指定日mday-=15
            if ( $spec_mday + 15 <= $m_day ) $spec_mday += 15; //** 半月模式的，指定日mday + 15 <= 借款日的mday， 指定日mday+=15
            
        }
        
        
        if ( $spec_mday > 0 ) {
            if ( $m_day <= $spec_mday ) {
                
                $date=date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date,"Y-m-d 00:00:00"));
                $date->setDate ( $m_year , $m_month , $spec_mday );
                $m_fake_start = $date;
                
                $m_diff = (int) date_diff( $m_fake_start ,$this->d5_start_date)->format("%a");
                
                if ( $spec_mode == false ) {
                    
                    $m_fake_start = $date;//$this->getShiftSameDay($date);         // 不用
                } else {
                    if ( $m_diff >15 || ($m_diff > 7 & $days_len==0)  ) {
                        $m_fake_start = $this->getShiftSameDay($date,-1,$days_len!=0);
                    } else { // 指定日mday - 借款日的mday <= 15
                        // 月：用指定日生成本月  --做假借款日
                        // 半月：用指定日生成本期  --做假借款日
                        $m_fake_start = $date; // 不用
                    }
                    
                }
                
                
            }else { //指定日mday<借款日的mday
                
                $date=date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date,"Y-m-d 00:00:00"));
                $date->setDate ( $m_year , $m_month , $spec_mday );
                $m_fake_start = $this->getShiftSameDay($date,1,$days_len!=0);
                
                $m_diff = (int) date_diff( $m_fake_start ,$this->d5_start_date)->format("%a");
                
                if ( $spec_mode == false ) {
                    $m_fake_start = $this->getShiftSameDay($date,1,$days_len!=0); // 不用
                } else {
                    if ( $m_diff >15 || ($m_diff > 7 & $days_len==0)  ) {
                        $m_fake_start = $date;
                    } else {
                        $m_fake_start = $this->getShiftSameDay($date,1,$days_len!=0); // 不用
                    }
                    
                }
                
            }
            
        } else { // 任意天的，支持 29,30,31的
            $m_fake_start = date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date,"Y-m-d 00:00:00"));
        }
        
        
          
        
        
        
        $this->period_days_array = $days_array;        
        
        unset($this->periodAmounts);
        $this->periodAmounts =array();        
        $this->periodAmounts[0] = new PeriodAmount();
        
        $this->periodAmounts[0]->setPeriodDate($this->d5_start_date,$this->d5_start_date,0,$this->d4_period_days,$this->period_days_array);
        $this->periodAmounts[0]->setPeriodPrincipal($this->d1_all_loan);
        
        for ($x=1; $x <= $this->d3_total_Period; $x++)
        {
            $last_date = $this->periodAmounts[$x-1]->getPeriodDate();
            $this->periodAmounts[$x] = new PeriodAmount();
            $this->periodAmounts[$x]->setPeriodDate($m_fake_start,$last_date,$x, $this->d4_period_days, $this->period_days_array);       // 赋值借款日和本期还款日、本期期数
//不需要了            $this->perDates[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
            $this->periodAmounts[$x]->fix_z_1_B($this->d2_real_day_rate,$this->d4_period_days,false); // $this->d2_real_day_rate, false 按期，true 按天
        }
        
        $this->periodAmounts[$this->d3_total_Period]->setPeriodDate($this->d5_start_date,$last_date,$this->d3_total_Period,$this->d4_period_days,  $this->period_days_array); // 修正末期
        
        $this->periodAmounts[$this->d3_total_Period+1] = new PeriodAmount(); // 多生成一个，data_due_z_1_B = 1；
        
        
        
        
        $sum_z_pai = 0; // 从 2 到 第 25 个 z_pai 求和
        

        for ($x=$this->d3_total_Period; $x >= 1; $x--)
        {
            $mult_pai = $this->periodAmounts[$x+1]->get_z_pai();
            $this->periodAmounts[$x]->set_z_pai( $mult_pai );
            $sum_z_pai = $sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
        }
        
        $first_z_pai = $this->periodAmounts[1]->get_z_pai(); //  第1 个 z_pai
        
        $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
        $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        // $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $this->d3_total_Period; $x++) {
            $this->periodAmounts[$x]->cal_principal_interest($this->periodAmounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_day_rate,$this->d6_period_amount_round);
        }
                
        $this->periodAmounts[$this->d3_total_Period]->cal_last_period_due_principal();
        $this->periodAmounts[1]->cal_period_dueday_interest($this->d2_real_day_rate);
        $this->periodAmounts[$this->d3_total_Period]->cal_period_dueday_interest($this->d2_real_day_rate);
        
    }
    
    

    
}



?>

