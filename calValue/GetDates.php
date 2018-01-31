<?php


class TheDates
{

    private $d3_total_Period = 0;
    private $d4_period_len;
    private $d5_start_date;
    
    //    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $data_last_date;// = date_create();         // 贷款上期还款日期
    private $data_period_date;// = date_create();       // 贷款本期还款日期
    private $data_due_days;                         // 本期借款天数
    private $period_days_array=null;

    
    
    public function __construct($num)
    {
        //        $this->data_start_date = date_create();
        
        $this->data_period_date = array();
        $this->data_last_date = array();
        $this->data_due_days = array();
        
        $this->d3_total_Period = $num;
        
        for ($i=0 ; $i<=$this->d3_total_Period+1;$i++){
            $this->data_period_date[$i] = date_create();
            $this->data_last_date[$i] =  date_create();
            $this->data_due_days[$i] =  0;
        }
        
        
    }
    
    
    public function __destruct() {
        echo 'Destroying: ';
        //, $this->name, PHP_EOL;
        for ($i = $this->d3_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->data_last_date) && isset($this->data_last_date[$i]))
                unset($this->data_last_date[$i]);
            if (is_array($this->data_period_date) && isset($this->data_period_date[$i]))
                unset($this->data_period_date[$i]);
            if (is_array($this->data_due_days) && isset($this->data_due_days[$i]))
                unset($this->data_due_days[$i]);
        }
        $this->data_last_date = null;
        $this->data_period_date = null;
        $this->data_due_days = null;
    }
   
    public function getLastDate($num)
    { // 获取上期还款日的一个副本
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return null;
        if (is_array($this->data_last_date) && isset($this->data_last_date[$num])) {
            $date = date_create_from_format("Y-m-d H:i:s", date_format($this->data_last_date[$num], "Y-m-d 00:00:00"));
            return $date;
        }
        return null;
    }
    
    
    public function getThisDate($num)
    { // 获取本期还款日的一个副本
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return null;
        if (is_array($this->data_period_date) && isset($this->data_period_date[$num])) {
            $date = date_create_from_format("Y-m-d H:i:s", date_format($this->data_period_date[$num], "Y-m-d 00:00:00"));
            return $date;
        }
        return null;
    }
    
    public function getDueDays($num)
    { // 获取上期还款日的一个副本
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return 0;
        if (is_array($this->data_due_days) && isset($this->data_due_days[$num])) {
            return $this->data_due_days[$num];
        }
        return 0;
    }
    
    public function getTotal()
    { // ???
        return $this->d3_total_Period;
    }
    
    public function getPeriod_Len()
    { // ???
        return $this->d4_period_len;
    }
    
    
    
    public function getShiftSameDay( $start_date, $shift=0, $is_month=true) // shift 前后挪期， $is_month=false半月，true月
    {
        
        // ?? 检查 $start_date 是合法日期 !!!!!
        
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
    
    
    
    private function getFakeStartDate( $start_date, $days_len, $spec_mday,$spec_mode ) {
        
        // ?? 检查 $start_date 是合法日期 !!!!!
        
        
        $date=date_create_from_format("Y-m-d H:i:s", date_format( $start_date, "Y-m-d 00:00:00"));
        
        if ( $days_len > 0 || $spec_mday == 0 ) { // 按日模式不修改，只改半月和月, 不指定日期的，也返回
            
            $m_fake_start = $date;
            return $m_fake_start;
        }
        
        $theday1 = getdate( $date->getTimestamp() );
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
                
                $date=date_create_from_format("Y-m-d H:i:s", date_format($start_date,"Y-m-d 00:00:00"));
                $date->setDate ( $m_year , $m_month , $spec_mday );
                $m_fake_start = $date;
                
                $m_diff = (int) date_diff( $m_fake_start ,$start_date)->format("%a");
                
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
                
                $date=date_create_from_format("Y-m-d H:i:s", date_format($start_date,"Y-m-d 00:00:00"));
                $date->setDate ( $m_year , $m_month , $spec_mday );
                $m_fake_start = $this->getShiftSameDay($date,1,$days_len!=0);
                
                $m_diff = (int) date_diff( $m_fake_start ,$start_date)->format("%a");
                
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
            //            $m_fake_start = date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date,"Y-m-d 00:00:00"));
        }
        
        return $m_fake_start;
        
    }
    
    
    public function calScheduleDate( $total_Period, $days_len=-1, $start_date=null, $spec_mday=0, $spec_mode=false,$days_array=null)
    {
        
        $num = $this->getTotal();
        if ( $total_Period <=0 ) return;
        if ( $total_Period != $num  ) {
            $this->__destruct();
            $this->__construct($total_Period);
        }
        
        
        $this->d3_total_Period = $total_Period; // 总期数不能小于1
        $this->d4_period_len = $days_len; // -1=按自然月还， 1-365=按天数周期还，-25=按后面的还款天表
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
        
        
        $m_fake_start = $this->getFakeStartDate($this->d5_start_date,$days_len,$spec_mday,$spec_mode);
        
        
        
        
        
        
//        unset($this->periodAmounts);
//        $this->periodAmounts =array();
//        $this->periodAmounts[0] = new PeriodAmount();
        
        $this->setPeriodDate($this->d5_start_date,$this->d5_start_date,0,$this->d4_period_len,$this->period_days_array);
//        $this->setPeriodPrincipal($this->d1_all_loan);
        
        for ($x=1; $x <= $this->d3_total_Period; $x++)
        {
            $last_date = $this->getThisDate($x-1);
//            $this->periodAmounts[$x] = new PeriodAmount();
            $this->setPeriodDate($m_fake_start,$last_date,$x, $this->d4_period_len, $this->period_days_array);       // 赋值借款日和本期还款日、本期期数
            //不需要了            $this->perDates[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
//需要再实现            $this->periodAmounts[$x]->fix_z_1_B($this->d2_real_day_rate,$this->d4_period_len,false); // $this->d2_real_day_rate, false 按期，true 按天
        }
        
        $this->setPeriodDate($this->d5_start_date,$last_date,$this->d3_total_Period,$this->d4_period_len,  $this->period_days_array); // 修正末期
        
//        $this->periodAmounts[$this->d3_total_Period+1] = new PeriodAmount(); // 多生成一个，data_due_z_1_B = 1；
        
        
     


    
        
    }
    

    
    
    public function setPeriodDate($start_date,$last_date, $x, $period_days=0, $period_days_array=null)
    {
        
        if ( $x < 0 || $x > $this->d3_total_Period + 1) {
            return;
        }
        
//        $this->data_period_num = $x; //设置这是第几期的编号
        //        $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        $this->data_last_date[$x] = date_create_from_format("Y-m-d H:i:s",date_format($last_date,"Y-m-d 00:00:00"));
        $this->data_period_date[$x] = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        
        
        if ( $x <= 0 ) {
            return;
        }
        
        if ($period_days > 0) // 如果是大于0.则是按天
        {
            $xd = $x * $period_days;
            $per_Int = new DateInterval("P" . $xd . "D");
            
            date_add($this->data_period_date[$x], $per_Int);
            
            
        } else { // 如果是0，则是按半月还，间隔为x个半月.
            if ( $period_days <= 0 && $period_days >= - 24 ) // 如果是-1..-24，则是按月还，间隔为-period_days月.
            {
                $theday1 = getdate($start_date->getTimestamp());
                
                
                
                ////////////// 1) 借款日31号的，首月之后调整到1号
                // 2： 按月的，借款日31号的，往后挪一天到1号，之后按月加，不用调整；首月多借了一天
                if ( $theday1['mday'] == 31 && ($period_days<0 || ($x % 2==0) ) )  // 按月，按半月x是双数的
                {
                    if ($x > 0) // 第2月开始平移到1号
                        date_add($this->data_period_date[$x], new DateInterval("P1D"));
                }
                ////////////// 1)
                
                
                
                ////////////// 2) 加 x 或者 (x+1)/2 、 (x-1)/2 个月
                if ($period_days < 0)
                    $xd = $x * (- $period_days); // 月还, 从首月，增加 x * per 个月
                    else { // 半月还, 从首月，增加 x /2 个月
                        if ($x % 2 == 0) // 半月，双数
                            $xd = $x / 2;
                            if ($x % 2 == 1) // 半月，单数
                            {
                                if ($theday1['mday'] >= 16) // 半月，单数，16号以后的
                                    $xd = ($x + 1) / 2;
                                    else // 半月，单数，15号以前的
                                        $xd = ($x - 1) / 2;
                            }
                    }
                    
                    
                    $per_Int = new DateInterval("P" . $xd . "M");
                    date_add($this->data_period_date[$x], $per_Int);
                    
                    ////////////// 2)
                    
                    
                    ////////////// 3) 半月，单数，15号以前，增加15天
                    
                    if ($period_days == 0 && ($x % 2==1) && ( $theday1['mday'] <= 15 ) )// 半月，单数，15号以前的，<=15号的，就加（x-1）/2个月，再加15天，再修正29,30
                        date_add($this->data_period_date[$x],  new DateInterval("P15D"));
                        ////////////// 3)
                        
                        
                        ////////////// 4) N月还，或者：半月，双数，或者：半月，单数，15号以前，修正 29,30号起始日的
                        //// 半月 单数  14,15需要修正
                        $fixNum1 = $theday1['mday']; // 首期的开始日
                        if ( $period_days < 0 ||($x % 2==0) || ( $fixNum1 <= 15 ) )
                        {
                            if (  $period_days == 0 && ($x % 2==1) && ( $fixNum1 == 14 || $fixNum1 == 15 ) )
                            {
                                // $theday2 = getdate( $this->data_period_date->getTimestamp() );
                                $fixNum1 = $fixNum1 + 15;
                            }
                            if ($fixNum1 == 29 || $fixNum1 == 30)
                            {
                                $aa = $this->fix29_30($this->data_period_date[$x], $fixNum1 );
                                $this->data_period_date[$x] = $aa;
                                
                            }
                        }
                        ////////////// 4)
                        
                        
                        ////////////// 5) 半月，单数，>=16号的，就加（x+1）/2个月，再减15天，修正到day-15
                        if ( $period_days == 0 && ( ($x % 2==1) && ( $theday1['mday'] >= 16 ) ) )
                        {
                            date_sub($this->data_period_date[$x],  new DateInterval("P15D"));
                            $theday2 = getdate( $this->data_period_date[$x]->getTimestamp() );
                            $this->data_period_date[$x] = date_create_from_format("Y-m-d H:i:s",$theday2['year']."-".$theday2['mon']."-".($theday1['mday']-15)." 00:00:00");
                        }
                        ////////////// 5)
                        
                        
            } elseif ($period_days < - 24) // 需要采用后面的实际天数数组
            {
                $sumDays = 0;
                // int t_period_days_array[] = (int[]) period_days_array;
                if (isset($period_days_array))
                    for ($i = 0; $i < $x && $i < count($period_days_array); $i ++) {
                        if (isset($period_days_array[$i]))
                            $sumDays += $period_days_array[$i];
                    }
                $per_Int = new DateInterval("P" . $sumDays . "D"); // 日期加sumDays个天
            }
        }
        
        //    echo date_format($date,"Y/m/d")."<br>";
        // $this->data_due_days = (int) date_diff($this->data_period_date,$this->data_last_date)->format("%a");  //这个没用了，后面需要重新 FixDueDays
        $this->fixDueDays( $x, $last_date);
        
        
        return;
    }
    
    public function fix29_30( $thedate, $num )
    {
        $thedate = date_create_from_format("Y-m-d H:i:s",date_format($thedate,"Y-m-d 00:00:00"));
        $theday2 = getdate( $thedate->getTimestamp() );
        
        // 1：  借款日29号的，按月加，如果结果日不等于29（就是1），就减一天
        if ( $num == 29 )
        {
            if ( $theday2['mday'] != 29 )
                $thedate = date_sub( $thedate,new DateInterval("P1D"));
        }
        // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
        if ( $num == 30 )
        {
            if ( $theday2['mday'] != 30 )
            {
                // echo  date_format( date_create_from_format("Y-m-d", "2009-2-15"),"Y-m-d H:i:s" ); //会把当前时分秒带进去，
                $thedate = date_create_from_format("Y-m-d H:i:s",$theday2['year']."-".$theday2['mon']."-"."1 00:00:00");
                
                $temp_date = date_create_from_format("Y-m-d H:i:s",date_format($thedate,"Y-m-d 00:00:00"));
                date_sub( $temp_date, new DateInterval("P1D"));
                $theday3 = getdate( $temp_date->getTimestamp() );
                
                if ( $theday3['mday'] == 29 )
                    $thedate = $temp_date;
                    // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
            }
        }
        return $thedate;
    }
    
    
    
    
    private function fixDueDays($num, $date)
    { // 计算本期还款日和某日期（上期还款日）间隔的天数
        if ($num < 0 || $num > $this->d3_total_Period + 1)
            return;
        if ( is_array($this->data_due_days) && isset($this->data_due_days[$num]) )
            $this->data_due_days[$num] = (int) date_diff($this->data_period_date[$num], $date)->format("%a");
    }
    
    public function echoData( $need_table=true )
    {
        if ( $need_table ) {
            //echo date_default_timezone_get();
            
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                
                
                $echoStr = $echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $echoStr = $echoStr."        <td>".date_format($this->data_last_date[$x],"Y-m-d")."</td>\n";
                $echoStr = $echoStr."        <td>".date_format($this->data_period_date[$x],"Y-m-d")."</td>\n";
                $echoStr = $echoStr."        <td>".$this->data_due_days[$x]."</td>\n";

                $echoStr = $echoStr."\n";
                
                
                $echoStr = $echoStr."    </tr>\n";
            }
            $echoStr = $echoStr."</table>\n";
            
            
            echo $echoStr;
            
        }
        
    }
    
    
}

?>