<?php


class TheDates
{

    private $ww_total_Period = 0;
    private $ww_period_len;
    private $ww_start_date;
    
    //    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $ww_last_date;// = date_create();         // 贷款上期还款日期
    private $ww_period_date;// = date_create();       // 贷款本期还款日期
    private $ww_due_days;                         // 本期借款天数
    private $ww_period_days_array=null;
    
    private $ww_data_is_HeadRear_Period = false; // 这是通过日期比对,看实际头尾是否是正月,是就 true, 不是就 false

    
    private function initMe($pp_num)
    {
        $this->ww_period_date = array();
        $this->ww_last_date = array();
        $this->ww_due_days = array();
        
        $this->ww_total_Period = $pp_num;
        
        for ($i=0 ; $i<=$this->ww_total_Period+1;$i++){
            $this->ww_period_date[$i] = date_create();
            $this->ww_last_date[$i] =  date_create();
            $this->ww_due_days[$i] =  0;
        }
        
    }
    
    public function __construct($pp_num)
    {
        //        $this->data_start_date = date_create();
        
        $this->initMe($pp_num);        
    }
    
    
    private function releaseMe()
    {
        //, $this->name, PHP_EOL;
        for ($i = $this->ww_total_Period + 1; $i >= 0; $i --) {
            if (is_array($this->ww_last_date) && isset($this->ww_last_date[$i]))
                unset($this->ww_last_date[$i]);
            if (is_array($this->ww_period_date) && isset($this->ww_period_date[$i]))
                unset($this->ww_period_date[$i]);
            if (is_array($this->ww_due_days) && isset($this->ww_due_days[$i]))
                unset($this->ww_due_days[$i]);
        }
        $this->ww_last_date = null;
        $this->ww_period_date = null;
        $this->ww_due_days = null;
        
    }
    
    
    public function __destruct() {
//        echo 'Destroying: ';
        $this->releaseMe();
    }
   
    private function getLastDate($pp_num)
    { // 获取上期还款日的一个副本
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return null;
        if (is_array($this->ww_last_date) && isset($this->ww_last_date[$pp_num])) {
            $date = date_create_from_format("Y-m-d H:i:s", date_format($this->ww_last_date[$pp_num], "Y-m-d 00:00:00"));
            return $date;
        }
        return null;
    }
    
    
    private function getThisDate($pp_num)
    { // 获取本期还款日的一个副本
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return null;
        if (is_array($this->ww_period_date) && isset($this->ww_period_date[$pp_num])) {
            $ll_date = date_create_from_format("Y-m-d H:i:s", date_format($this->ww_period_date[$pp_num], "Y-m-d 00:00:00"));
            return $ll_date;
        }
        return null;
    }
    
    public function getDueDays($pp_num)
    { // 获取上期还款日的一个副本
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return 0;
        if (is_array($this->ww_due_days) && isset($this->ww_due_days[$pp_num])) {
            return $this->ww_due_days[$pp_num];
        }
        return 0;
    }
    
    public function getCount()
    { // ???
        return $this->ww_total_Period;
    }
    
    public function getPeriod_Len()
    { // ???
        return $this->ww_period_len;
    }
    
    public function is_HeadRear_Period() {
        return $this->ww_data_is_HeadRear_Period;
    }
    
    
    private function getShiftSameDay( $pp_start_date, $pp_shift=0, $pp_is_month=true) // shift 前后挪期， $is_month=false半月，true月
    {
        
        // ?? 检查 $start_date 是合法日期 !!!!!
        
        $ll_theday1 = getdate( $pp_start_date->getTimestamp() );
        $ll_year = $ll_theday1['year'];
        $ll_month = $ll_theday1['mon'];
        $ll_day = $ll_theday1['mday'];
        
        if ( $ll_day > 28 ) $ll_day = 28; //只会是 1-28
        
        if ( $pp_is_month == false ) { // 半月
            if ( $ll_day == 15 ) $ll_day = 16;
            if ( $ll_day == 14 ) $ll_day = 13;
            
            if ( $pp_shift % 2 != 0 ) { // 单数半月
                if ( $ll_day < 15 ){
                    $ll_day = $ll_day + 15;
                    $pp_shift = $pp_shift - 1; //去掉一个半月，人工挪后半月
                } else {
                    $ll_day = $ll_day - 15;
                    $pp_shift = $pp_shift + 1; //去掉一个半月，人工前移半月
                }
            }
            $pp_shift = floor( $pp_shift / 2 );
        }
        
        
        // 月 和 半月 相同模式
        $ll_add_year = floor( ( $ll_month + $pp_shift - 1 ) / 12 );
        $ll_month = ( ( $ll_month + $pp_shift - 1 ) % 12 ) + 1;
        if ( $ll_month <= 0 ) $ll_month = $ll_month + 12;
        $ll_year = $ll_year + $ll_add_year;
        
        $ll_date = create_from_format("Y-m-d H:i:s", $ll_year."-".$ll_month."-".$ll_day." 00:00:00");
        
        return $ll_date;
        
    }
    
    
    
    private function getFakeStartDate( $pp_start_date, $pp_days_len, $pp_spec_mday,$pp_spec_mode ) {
        
        // ?? 检查 $start_date 是合法日期 !!!!!
        
        
        $ll_Date=date_create_from_format("Y-m-d H:i:s", date_format( $pp_start_date, "Y-m-d 00:00:00"));
        
        if ( $pp_days_len > 0 || $pp_spec_mday <= 0 || $pp_spec_mday > 28 ) { // 按日模式不修改，只改半月和月, 不指定日期的，也返回
            
            $ll_fake_start = $ll_Date;
            return $ll_fake_start;
        }
        
        $ll_theday1 = getdate( $ll_Date->getTimestamp() );
        $ll_year = $ll_theday1['year'];
        $ll_month = $ll_theday1['mon'];
        $ll_day = $ll_theday1['mday'];
        
        
        
        //////////////// 2.修正指定日期
        /*
        if ( $spec_mday < 0 ) {
            $spec_mday = $m_day;
        }
        if ( $spec_mday > 28 ) $spec_mday = 28; // spec_mode 按实际传入的
        */
        
        if (  $pp_days_len == 0 ) { ///半月模式
            if ( $pp_spec_mday !=0 ) { //注意半月不指定日期模式！！！ 不是0任意天模式，
                if ( $pp_spec_mday == 15 ) $pp_spec_mday = 16;
                if ( $pp_spec_mday == 14 ) $pp_spec_mday = 13;
            }
            
            if ( $ll_day + 15 <= $pp_spec_mday ) $pp_spec_mday -= 15; //** 半月模式的，借款日的mday + 15 <=指定日mday， 指定日mday-=15
            if ( $pp_spec_mday + 15 <= $ll_day ) $pp_spec_mday += 15; //** 半月模式的，指定日mday + 15 <= 借款日的mday， 指定日mday+=15
            
        }
        
        
        if ( $pp_spec_mday > 0 ) {
            if ( $ll_day <= $pp_spec_mday ) {
                
                $ll_Date=date_create_from_format("Y-m-d H:i:s", date_format($pp_start_date,"Y-m-d 00:00:00"));
                $ll_Date->setDate ( $ll_year , $ll_month , $pp_spec_mday );
                $ll_fake_start = $ll_Date;
                
                $ll_diff = (int) date_diff( $ll_fake_start ,$pp_start_date)->format("%a");
                
                if ( $pp_spec_mode == false ) {
                    
                    $ll_fake_start = $ll_Date;//$this->getShiftSameDay($date);         // 不用
                } else {
                    if ( $ll_diff >15 || ($ll_diff > 7 & $pp_days_len==0)  ) {
                        $ll_fake_start = $this->getShiftSameDay($ll_Date,-1,$pp_days_len!=0);
                    } else { // 指定日mday - 借款日的mday <= 15
                        // 月：用指定日生成本月  --做假借款日
                        // 半月：用指定日生成本期  --做假借款日
                        $ll_fake_start = $ll_Date; // 不用
                    }
                    
                }
                
                
            }else { //指定日mday<借款日的mday
                
                $ll_Date=date_create_from_format("Y-m-d H:i:s", date_format($pp_start_date,"Y-m-d 00:00:00"));
                $ll_Date->setDate ( $ll_year , $ll_month , $pp_spec_mday );
                $ll_fake_start = $this->getShiftSameDay($ll_Date,1,$pp_days_len!=0);
                
                $ll_diff = (int) date_diff( $ll_fake_start ,$pp_start_date)->format("%a");
                
                if ( $pp_spec_mode == false ) {
                    $ll_fake_start = $this->getShiftSameDay($ll_Date,1,$pp_days_len!=0); // 不用
                } else {
                    if ( $ll_diff >15 || ($ll_diff > 7 & $pp_days_len==0)  ) {
                        $ll_fake_start = $ll_Date;
                    } else {
                        $ll_fake_start = $this->getShiftSameDay($ll_Date,1,$pp_days_len!=0); // 不用
                    }
                    
                }
                
            }
            
        } else { // 任意天的，支持 29,30,31的
            //            $m_fake_start = date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date,"Y-m-d 00:00:00"));
        }
        
        return $ll_fake_start;
        
    }
    
    
    public function cal_theDates( $pp_total_Period, $pp_days_len=-1, $pp_start_date=null, $pp_spec_mday=0, $pp_spec_mode=false,$pp_days_array=null)
    {
        
        $ll_num = $this->getCount();
        if ( $pp_total_Period <=0 ) return;
        if ( $pp_total_Period != $ll_num  ) {
            $this->releaseMe();
            $this->initMe($pp_total_Period);
        }
        
        
        $this->ww_total_Period = $pp_total_Period; // 总期数不能小于1
        $this->ww_period_len = $pp_days_len; // -1=按自然月还， 1-365=按天数周期还，-25=按后面的还款天表
        $this->ww_period_days_array = $pp_days_array;
        
        
        
        
        
        //////////////// 1.设定开始日期
        date_default_timezone_set("Asia/Shanghai");
        // $date=date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        
        $ll_date = date_create_from_format("Y-m-d",$pp_start_date);
        if ( $ll_date == false )
        { // 如果没有传递开始日期，或者错误的开始日期，则设置当前日期为开始日期
            $ll_date = date_create(date("Y-m-d")); // "Y-m-d 2017-01-09 Y n j 2017-1-9" // date_date_set($date,2020,10,15);
        }
        $this->ww_start_date= date_create_from_format("Y-m-d H:i:s",date_format($ll_date,"Y-m-d 00:00:00"));
        //////////////// 1.设定开始日期
        
        
        $ll_fake_start = $this->getFakeStartDate($this->ww_start_date,$pp_days_len,$pp_spec_mday,$pp_spec_mode);
        
        
        
        
        
        
//        unset($this->periodAmounts);
//        $this->periodAmounts =array();
//        $this->periodAmounts[0] = new PeriodAmount();
        
        $this->setPeriodDate($this->ww_start_date,$this->ww_start_date,0,$this->ww_period_len,$this->ww_period_days_array);
//        $this->setPeriodPrincipal($this->d1_all_loan);
        
        for ($x=1; $x <= $this->ww_total_Period; $x++)
        {
            $ll_last_date = $this->getThisDate($x-1);
//            $this->periodAmounts[$x] = new PeriodAmount();
            $this->setPeriodDate($ll_fake_start,$ll_last_date,$x, $this->ww_period_len, $this->ww_period_days_array);       // 赋值借款日和本期还款日、本期期数
            //不需要了            $this->perDates[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
//需要再实现            $this->periodAmounts[$x]->fix_z_1_B($this->d2_real_day_rate,$this->d4_period_len,false); // $this->d2_real_day_rate, false 按期，true 按天
        }
        
        $this->setPeriodDate($this->ww_start_date,$ll_last_date,$this->ww_total_Period,$this->ww_period_len,  $this->ww_period_days_array); // 修正末期
        
//        $this->periodAmounts[$this->d3_total_Period+1] = new PeriodAmount(); // 多生成一个，data_due_z_1_B = 1；
        
        
     


    
        
    }
    

    
    
    private function setPeriodDate($pp_start_date,$pp_last_date, $x, $pp_period_days=0, $pp_period_days_array=null)
    {
        
        if ( $x < 0 || $x > $this->ww_total_Period + 1) {
            return;
        }
        
//        $this->data_period_num = $x; //设置这是第几期的编号
        //        $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        $this->ww_last_date[$x] = date_create_from_format("Y-m-d H:i:s",date_format($pp_last_date,"Y-m-d 00:00:00"));
        $this->ww_period_date[$x] = date_create_from_format("Y-m-d H:i:s",date_format($pp_start_date,"Y-m-d 00:00:00"));
        
        
        if ( $x <= 0 ) {
            return;
        }
        
        if ($pp_period_days > 0) // 如果是大于0.则是按天
        {
            $xd = $x * $pp_period_days;
            $ll_per_Int = new DateInterval("P" . $xd . "D");
            
            date_add($this->ww_period_date[$x], $ll_per_Int);
            
            
        } else { // 下面是月还，和半月还。如果是0，则是按半月还，间隔为x个半月.
            if ( 0 >= $pp_period_days && $pp_period_days >= - 24 ) // 如果是-1..-24，则是按月还，间隔为-period_days月.
            {
                $ll_theday1 = getdate($pp_start_date->getTimestamp());
                $ll_mday = $ll_theday1['mday'];
                
                
                
                ////////////// 1) 借款日31号的，首月之后调整到1号
                // 2： 按月的，借款日31号的，往后挪一天到1号，之后按月加，不用调整；首月多借了一天
                if ( $ll_mday == 31 && ($pp_period_days<0 || ($x % 2==0) ) )  // 按月，按半月x是双数的
                {
                    if ($x > 0) // 第2月开始平移到1号
                        date_add($this->ww_period_date[$x], new DateInterval("P1D"));
                }
                // //////////// 1)
                
                    
                // //////////// 2) 加 x 或者 (x+1)/2 、 (x-1)/2 个月
                if ($pp_period_days < 0)
                    $xd = $x * (- $pp_period_days); // 月还, 从首月，增加 x * per 个月
                else { // 半月还, 从首月，增加 x /2 个月
                    if ($x % 2 == 0) // 半月，双数
                        $xd = $x / 2;
                    if ($x % 2 == 1) // 半月，单数
                    {
                        if ($ll_mday >= 16) // 半月，单数，16号以后的
                            $xd = ($x + 1) / 2;
                        else // 半月，单数，15号以前的
                            $xd = ($x - 1) / 2;
                    }
                }
                
                $ll_per_Int = new DateInterval("P" . $xd . "M");
                date_add($this->ww_period_date[$x], $ll_per_Int);
                ////////////// 2)
                
                $ll_fixNum1 = $ll_mday; // 首期的开始日
                // //////////// 3) 半月，单数，15号以前，增加15天
                if ($pp_period_days == 0 && ($x % 2 == 1) && ( $ll_mday <= 15 ) ) { // 半月，单数，15号以前的，<=15号的，就加（x-1）/2个月，再加15天，再修正29,30
                    date_add($this->ww_period_date[$x], new DateInterval("P15D"));
                    $ll_fixNum1 = $ll_fixNum1 + 15;
                }
                ////////////// 3)
                
                ////////////// 4) N月还；或者：半月，双数；或者：半月，单数，15号以前。修正 29,30号起始日的
                //// 半月 单数  14,15需要修正
                //// 半月 单数  29,30 不需要修正！！！！
                if ($pp_period_days < 0 || ($x % 2 == 0) || ( $ll_mday <= 15 ) ) {
                    
                    if ( $ll_fixNum1 == 29 || $ll_fixNum1 == 30 ) {
                        $aa = $this->fix29_30($this->ww_period_date[$x], $ll_fixNum1);
                        $this->ww_period_date[$x] = $aa;
                    }
                }
                ////////////// 4)
                
                ////////////// 5) 半月，单数，>=16号的，就加（x+1）/2个月，再减15天，修正到day-15
                if ( $pp_period_days == 0 && ( ($x % 2==1) && ( $ll_mday >= 16 ) ) )
                {
                    date_sub($this->ww_period_date[$x],  new DateInterval("P15D"));
                    $ll_theday2 = getdate( $this->ww_period_date[$x]->getTimestamp() );
                    $this->ww_period_date[$x] = date_create_from_format("Y-m-d H:i:s",$ll_theday2['year']."-".$ll_theday2['mon']."-".($ll_mday-15 )." 00:00:00");
                }
                ////////////// 5)
                        
                        
            } elseif ($pp_period_days < - 24) // 需要采用后面的实际天数数组
            {
                $ll_sumDays = 0;
                // int t_period_days_array[] = (int[]) period_days_array;
                if (isset($pp_period_days_array))
                    for ($i = 0; $i < $x && $i < count($pp_period_days_array); $i ++) {
                        if (isset($pp_period_days_array[$i]))
                            $ll_sumDays += $pp_period_days_array[$i];
                    }
                $ll_per_Int = new DateInterval("P" . $ll_sumDays . "D"); // 日期加sumDays个天
            }
        }
        
        //    echo date_format($date,"Y/m/d")."<br>";
        // $this->data_due_days = (int) date_diff($this->data_period_date,$this->data_last_date)->format("%a");  //这个没用了，后面需要重新 FixDueDays
        $this->fixDueDays( $x, $pp_last_date);
        
        
        return;
    }
    
    private function fix29_30( $pp_thedate, $pp_num )
    {
        $ll_Date = date_create_from_format("Y-m-d H:i:s",date_format($pp_thedate,"Y-m-d 00:00:00"));
        $ll_Day = getdate( $ll_Date->getTimestamp() );
        $ll_mday1 = $ll_Day['mday'];
        
        // 1：  借款日29号的，按月加，如果结果日不等于29（就是1），就减一天
        if ( $pp_num == 29 )
        { // JAVA： 1月29日 + 一月 = 2月28日，不用处理；  PHP：1月29日 + 一月 = 3月1日，减一天；
            
            /* JAVA： 2017-1-29 + 一月 = 2017-2-28，不用处理；
             * JAVA： 2016-1-29 + 一月 = 2016-2-29，不用处理；
             * PHP：2017-1-29 + 一月 = 2017-3-1：减一天，成2017-2-28；
             * PHP：2016-1-29 + 一月 = 2016-2-29，不用处理；
             *
             */
            
            if ( $ll_mday1 != 29 && $ll_mday1 != 28 )
                date_sub( $ll_Date,new DateInterval("P1D"));
        }
        // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
        if ( $pp_num == 30 )
        {
            
            /* JAVA： 2017-1-30 + 一月 = 2017-2-28，改成2017-3-1；
             * JAVA： 2016-1-30 + 一月 = 2016-2-29，不用处理；
             * PHP：2017-1-30 + 一月 = 2017-3-2，改成2017-3-1；
             * PHP：2016-1-30 + 一月 = 2016-3-1，改成2017-3-1，再减一天，改成2016-2-29；
             *
             */
            
            if ( $ll_mday1 < 5 )
            { // PHP 的模式：只会是 3月日1,3月2日，等
                
                
                // PHP：1月30日 + 一月 = 3月2日，调整到1日；
                $ll_Date = date_create_from_format("Y-m-d H:i:s",$ll_Day['year']."-".$ll_Day['mon']."-"."1 00:00:00");
                // echo  date_format( date_create_from_format("Y-m-d", "2009-2-15"),"Y-m-d H:i:s" ); //会把当前时分秒带进去，
                
                // PHP：1月30日 + 一月 = 3月2日，调整到1日，如果再减1日是2月29日，就用2月29日；
                $ll_aDate2 = date_create_from_format("Y-m-d H:i:s",date_format($ll_Date,"Y-m-d 00:00:00"));
                date_sub( $ll_aDate2, new DateInterval("P1D"));
                
                $ll_Day = getdate( $ll_aDate2->getTimestamp() ); 
                $ll_mday2 = $ll_Day['mday'];
                
                if ( $ll_mday2 == 29 )
                    $ll_Date = $ll_aDate2;
                    // 3：  借款日30号的，day=30时, 先按月加，如果结果日不等于30，回到1号，如果是上月是闰月29，再减一天到2月29
            } else {
                // JAVA 的模式
                if ( $ll_mday1 == 28 ) {
                    date_add( $ll_Date,new DateInterval("P1D"));
                }
            }
        }
        return $ll_Date;
    }
    
    
    
    
    private function fixDueDays($pp_num, $pp_aDate)
    { // 计算本期还款日和某日期（上期还款日）间隔的天数
        if ($pp_num < 0 || $pp_num > $this->ww_total_Period + 1)
            return;
        if ( is_array($this->ww_due_days) && isset($this->ww_due_days[$pp_num]) )
            $this->ww_due_days[$pp_num] = (int) date_diff($this->ww_period_date[$pp_num], $pp_aDate)->format("%a");
    }
    
    public function echoData( $pp_need_table=true )
    {
        if ( $pp_need_table ) {
            //echo date_default_timezone_get();
            
            $ll_echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->ww_total_Period+1; $x++) {
                $ll_echoStr = $ll_echoStr."    <tr>\n";
                
                
                $ll_echoStr = $ll_echoStr."        <td>".$x."</td>\n";
                //            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".date_format($this->ww_last_date[$x],"Y-m-d")."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".date_format($this->ww_period_date[$x],"Y-m-d")."</td>\n";
                $ll_echoStr = $ll_echoStr."        <td>".$this->ww_due_days[$x]."</td>\n";

                $ll_echoStr = $ll_echoStr."\n";
                
                
                $ll_echoStr = $ll_echoStr."    </tr>\n";
            }
            $ll_echoStr = $ll_echoStr."</table>\n";
            
            
            echo $ll_echoStr;
            
        }
        
    }
    
    
}

?>