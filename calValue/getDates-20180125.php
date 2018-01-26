<?php

class PerDate
{
    private $data_period_num = 0;
    private $data_start_date;// = date_create();        // 贷款首期借款日期
    private $data_last_date;// = date_create();         // 贷款上期还款日期
    private $data_period_date;// = date_create();       // 贷款本期还款日期
    //private $data_period_principal = 0;                 // 本期总欠本金
    private $data_due_days = 0;                         // 本期借款天数
    //private $data_due_principal = 0;                    // 本期应还本金
    //private $data_due_interest_real = 0.0;              // 本期应还利息_原始小数
    //private $data_due_interest = 0.0;                   // 本期应还利息_取整
    //private $data_due_amount = 0;                        // 本期应还本息
    private $data_z_1_B = 1;                            // 本期本息率 = 1 + 年率 /360* 本期天数
    private $data_z_pai = 1;                            // <本息率>连乘积
    
    public function setPeriodDate($start_date, $x, $period_days=0, $period_days_array=null)
    {
        $this->data_period_num = $x; //设置这是第几期的编号
        $this->data_start_date  = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
//        $this->data_last_date = date_create_from_format("Y-m-d H:i:s",date_format($last_date,"Y-m-d 00:00:00"));
        $this->data_period_date = date_create_from_format("Y-m-d H:i:s",date_format($start_date,"Y-m-d 00:00:00"));
        

        
        if ($period_days > 0) // 如果是大于0.则是按天
        {
            $xd = $x * $period_days;
            $per_Int = new DateInterval("P" . $xd . "D");
            
            $this->data_period_date = date_add($this->data_period_date, $per_Int);
            
            
        } else { // 如果是0，则是按半月还，间隔为x个半月.
            if ( $period_days <= 0 && $period_days >= - 24 ) // 如果是-1..-24，则是按月还，间隔为-period_days月.
            {
                $theday1 = getdate($start_date->getTimestamp());
                
                
                
                ////////////// 1) 借款日31号的，首月之后调整到1号
                // 2： 按月的，借款日31号的，往后挪一天到1号，之后按月加，不用调整；首月多借了一天
                if ( $theday1['mday'] == 31 && ($period_days<0 || ($x % 2==0) ) )  // 按月，按半月x是双数的
                {
                    if ($x > 0) // 第2月开始平移到1号
                        date_add($this->data_period_date, new DateInterval("P1D"));
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
                date_add($this->data_period_date, $per_Int);
                
                ////////////// 2)      
                
                
                ////////////// 3) 半月，单数，15号以前，增加15天
                
                if ($period_days == 0 && ($x % 2==1) && ( $theday1['mday'] <= 15 ) )// 半月，单数，15号以前的，<=15号的，就加（x-1）/2个月，再加15天，再修正29,30
                    date_add($this->data_period_date,  new DateInterval("P15D"));
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
                        $aa = $this->fix29_30($this->data_period_date, $fixNum1 );
                        $this->data_period_date = $aa;
                    
                    }
                }
                ////////////// 4)
                
                
                ////////////// 5) 半月，单数，>=16号的，就加（x+1）/2个月，再减15天，修正到day-15
                if ( $period_days == 0 && ( ($x % 2==1) && ( $theday1['mday'] >= 16 ) ) )
                {
                    date_sub($this->data_period_date,  new DateInterval("P15D"));
                    $theday2 = getdate( $this->data_period_date->getTimestamp() );
                    $this->data_period_date = date_create_from_format("Y-m-d H:i:s",$theday2['year']."-".$theday2['mon']."-".($theday1['mday']-15)." 00:00:00");
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
        // $this->fixDueDays($last_date);
        

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
    
    
    public function getPeriodDate()
    { // 获取本期还款日的一个副本
        $date= date_create_from_format("Y-m-d H:i:s",date_format($this->data_period_date,"Y-m-d 00:00:00"));
        return $date;
    }
    
    private function fixDueDays($date)
    { // 计算本期还款日和某日期（上期还款日）间隔的天数
        $this->data_due_days = (int) date_diff($this->data_period_date,$date)->format("%a");
    }
    
    
    public function echoData( $need_table=false )
    {
        if ( $need_table ) {
            //echo date_default_timezone_get();
            $echoStr = "        <td>".$this->data_period_num."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_start_date,"Y-m-d")."</td>\n";
//            $echoStr = $echoStr."        <td>".date_format($this->data_last_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".date_format($this->data_period_date,"Y-m-d")."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_due_days."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_1_B."</td>\n";
            $echoStr = $echoStr."        <td>".$this->data_z_pai."</td>\n";
            $echoStr = $echoStr."\n";
        }
        
        return $echoStr;
    }
    
}

class GetDates
{
    // 1-1098按设置固定天（ 多期、一期），
    // 0按半月，-1按月，-2双月，-3三月，-4四月，-5五月，-6六月、-7七月、-8八月、-9九月、-10十月、-11十月、-12一年、（ 多期、一期）
    // -13 .. -24两年，（ 多期、一期）
    // -25按指定天,（ 多期、一期）
    
    
    private $d3_total_Period = 6;
    private $d4_period_days = 0;  // 0=按自然月还， 1-365=按天数周期还，-1=按后面的还款天表
    private $d5_start_date;
    private $period_days_array=null;
    
    
    
    public function echoTable( $need_table=false )
    {
        if (  $need_table )
        {
            $echoStr = "<table border=1 cellspacing=0 cellpadding=0>\n";
            for ($x=0; $x <= $this->d3_total_Period+1; $x++) {
                $echoStr = $echoStr."    <tr>\n";
                if (isset($this->perDates[$x]))
                {
                    $echoStr = $echoStr.$this->perDates[$x]->echoData(true);
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
                if (isset($this->perDates[$x]))
                {
                    $echoStr = $echoStr.$this->perDates[$x]->echoData(false);
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
    
    

    
  
    public function calPeriodDate( $total_Period, $days_len=-1, $start_date=null, $spec_mday=0, $spec_mode=false,$days_array=null)
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

        if ( $total_Period < 1 ) { $total_Period = 1; }
        
//        $this->d2_real_day_rate = $this->d2_real_rate / 360.0;
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
        
        if ( $spec_mday > 28 ) $spec_mday = 28; // spec_mode 按实际传入的        
        if ( $spec_mday < 0 ) {            
            if ( $m_day <= 28 )
                $spec_mday = $m_day;
            else {
                $spec_mday = 28;
                $spec_mode = true;
            }
        }
        
        
        /////////// 得到本月指定日
        $date = date_create_from_format("Y-m-d H:i:s", date_format($this->d5_start_date, "Y-m-d 00:00:00"));
        /*if ($month >= 12) {
            $year = $year + 1;
            $month = 1;
        } else {
            $month = $month + 1;
        }*/
        if ( $spec_mday > 0 ) // 等于0的不用修正，就是开始日
            $date->setDate ( $m_year , $m_month , $spec_mday );
        /////////// 得到本月指定日
        
        
        
        $m_delta = 0;
        if ( $m_day <= $spec_mday ) { // 首期就是 N+1月
            $m_delta = 0;
        } elseif ( $spec_mday > 0 ) { // 需要是 $spec_mday 大于 0 的， 等于0的不处理
            
            
            
            if ( $spec_mode ) { // true 就是半月靠近
                if ( ( $m_day - $spec_mday ) < 15 ) { // 后面超过半个月
                    $m_delta = 0;
                } else {
                    $m_delta = 1; // 少于半个月，要退后一个月
                }                
            }else 
              $m_delta = 1; // false 都要从N+2月开始            
        }
        // 结果是：是否要加一个月。
        // ** 如果 spec_mday 等于0，不设置spec_mday，事后要修正
        
        //////////////// 2.修正指定日期
        
        
        
          
        
        
        
        $this->period_days_array = $days_array;        
        
        unset($this->perDates);
        $this->perDates =array();
        
        $this->perDates[0] = new PerDate();
        
        $this->perDates[0]->setPeriodDate($date,$m_delta,$this->d4_period_days,$this->period_days_array);
        
        for ($x=1; $x <= $this->d3_total_Period; $x++)
        {
            $last_date = $this->perDates[$x-1]->getPeriodDate();
            $this->perDates[$x] = new PerDate();
            $this->perDates[$x]->setPeriodDate($date,$x+$m_delta, $this->d4_period_days, $this->period_days_array);       // 赋值借款日和本期还款日、本期期数
//不需要了            $this->perDates[$x]->fixDueDays($this->periodAmounts[$x-1]->getPeriodDate()); // 修正本期天数
//            $this->perDates[$x]->fix_z_1_B($this->d2_real_day_rate);
        }
        
        /*待定        $this->perDates[$this->d3_total_Period+1] = new PeriodAmount(); // 多生成一个，data_due_z_1_B = 1；
        
        //待定        $sum_z_pai = 0; // 从 2 到 第 25 个 z_pai 求和
        
        for ($x=$this->d3_total_Period; $x >= 1; $x--)
        {
            $mult_pai = $this->periodAmounts[$x+1]->get_z_pai();
            $this->periodAmounts[$x]->set_z_pai( $mult_pai );
            $sum_z_pai = $sum_z_pai + $mult_pai; // 从 2 到 第 25 个 z_pai 求和
        }
        
        $first_z_pai = $this->periodAmounts[1]->get_z_pai(); //  第1 个 z_pai
        $this->d6_period_amount = $this->d1_all_loan * $first_z_pai / $sum_z_pai; // 求精确月供
        //        $this->d6_period_amount_round = round( $this->d6_period_amount, 2, PHP_ROUND_HALF_UP ); // 求四舍五入到分月供
        $this->d6_period_amount_round = round( ceil($this->d6_period_amount *100) / 100, 2, PHP_ROUND_HALF_UP ); // 求向上取整到分月供
        
        
        for ($x=1; $x <= $this->d3_total_Period; $x++) {
            $this->periodAmounts[$x]->cal_principal_interest($this->periodAmounts[$x-1]->getNextPeriodPrincipal(),$this->d2_real_day_rate,$this->d6_period_amount_round);
        }
        
        $this->periodAmounts[$this->d3_total_Period]->cal_last_period_due_principal();
        */
    }
    
    

    
}



?>

